<?php

namespace App\Http\Controllers;

use App\Exceptions\PesaPalException;
use App\Models\AdminUser;
use App\Models\Booking;
use App\Models\Destination;
use App\Models\Message;
use App\Models\Payment;
use App\Models\Review;
use App\Services\PaymentService;
use App\Services\PaymentSettings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminPaymentController extends Controller
{
    protected array $statuses = [
        Payment::STATUS_PENDING,
        Payment::STATUS_PROCESSING,
        Payment::STATUS_COMPLETED,
        Payment::STATUS_FAILED,
        Payment::STATUS_CANCELLED,
        Payment::STATUS_REFUNDED,
        Payment::STATUS_EXPIRED,
    ];

    public function __construct(protected PaymentService $payments)
    {
    }

    public function index(Request $request): View
    {
        $query = Payment::query()->with('booking');

        if ($request->filled('status') && in_array($request->string('status')->lower()->toString(), $this->statuses, true)) {
            $query->where('status', $request->string('status')->lower()->toString());
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->trim()->toString();
            $query->where(function ($sub) use ($q) {
                $sub->where('merchant_reference', 'like', "%{$q}%")
                    ->orWhere('order_tracking_id', 'like', "%{$q}%")
                    ->orWhere('customer_email', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%");
            });
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        return view('admin.payments', $this->layoutData([
            'payments' => $payments,
            'statuses' => $this->statuses,
            'activeStatus' => $request->get('status', ''),
            'search' => $request->get('q', ''),
        ]));
    }

    public function show(int $id): View
    {
        $payment = Payment::with(['booking', 'logs.admin'])->findOrFail($id);

        return view('admin.payment-detail', $this->layoutData([
            'payment' => $payment,
            'statuses' => $this->statuses,
        ]));
    }

    public function verify(int $id): RedirectResponse
    {
        $payment = Payment::findOrFail($id);

        try {
            $payment = $this->payments->reconcile($payment);
            return back()->with('success', 'Payment re-verified. Current status: ' . ucfirst($payment->status) . '.');
        } catch (PesaPalException $e) {
            return back()->with('error', 'Verification failed: ' . $e->getMessage());
        }
    }

    public function markStatus(Request $request, int $id): RedirectResponse
    {
        $request->validate(['status' => 'required|string']);

        $status = strtolower($request->string('status')->toString());
        if (!in_array($status, $this->statuses, true)) {
            return back()->with('error', 'Invalid status.');
        }

        $payment = Payment::findOrFail($id);
        $admin = AdminUser::find(session('admin_user_id'));
        $payment = $this->payments->markByAdmin($payment, $status, $admin);

        return back()->with('success', 'Payment marked as ' . ucfirst($payment->status) . '.');
    }

    public function resendPaymentLink(int $bookingId): RedirectResponse
    {
        $booking = Booking::findOrFail($bookingId);

        try {
            $payment = $this->payments->createPaymentForBooking($booking);

            if ($payment->status === Payment::STATUS_COMPLETED) {
                return back()->with('error', 'This booking is already fully paid.');
            }

            $this->payments->sendPaymentLink($payment);

            return back()->with('success', 'Payment link sent to ' . $booking->email . '.');
        } catch (PesaPalException $e) {
            return back()->with('error', 'Could not create payment: ' . $e->getMessage());
        }
    }

    public function copyPaymentLink(int $bookingId): JsonResponse
    {
        $booking = Booking::findOrFail($bookingId);

        return response()->json([
            'url' => $this->payments->paymentLinkForBooking($booking),
        ]);
    }

    public function settings(?array $ipnList = null, string $activePane = 'general'): View
    {
        $currencies = array_values(array_intersect(
            \App\Helpers\CurrencyHelper::getSupportedCurrencies(),
            \App\Services\PesaPalService::SUPPORTED_CURRENCIES
        ));

        return view('admin.payment-settings', $this->layoutData([
            'settings' => PaymentSettings::toArray(),
            'currencies' => $currencies ?: ['USD', 'TZS', 'KES', 'UGX'],
            'secretsStored' => [
                'pesapal_consumer_key' => PaymentSettings::isStored('pesapal_consumer_key'),
                'pesapal_consumer_secret' => PaymentSettings::isStored('pesapal_consumer_secret'),
            ],
            'notificationId' => PaymentSettings::notificationId(),
            'depositPercentage' => PaymentSettings::depositPercentage(),
            'environment' => PaymentSettings::environment(),
            'callbackUrl' => PaymentSettings::value('pesapal_callback_url') ?: route('payments.callback'),
            'cancellationUrl' => PaymentSettings::value('pesapal_cancellation_url') ?: route('payments.cancelled'),
            'ipnUrl' => PaymentSettings::value('pesapal_ipn_url') ?: url('api/pesapal/ipn'),
            'ipnList' => $ipnList,
            'activePane' => $activePane,
        ]));
    }

    public function ipnList(): View
    {
        return $this->settings($this->normalizeIpnList($this->payments->getIpnList()), 'endpoints');
    }

    protected function normalizeIpnList(array $result): array
    {
        if (isset($result['error'])) {
            return ['error' => $result['error']];
        }

        $entries = $result['ipns'] ?? $result['results'] ?? $result['output_ipns'] ?? [];
        $rows = [];

        foreach ((array) $entries as $entry) {
            if (!is_array($entry)) {
                continue;
            }
            $rows[] = [
                'id' => $entry['ipn_id'] ?? $entry['notification_id'] ?? $entry['id'] ?? '—',
                'url' => $entry['url'] ?? $entry['ipn_url'] ?? '—',
                'type' => $entry['ipn_notification_type'] ?? $entry['notification_type'] ?? '—',
                'created' => $entry['created_date'] ?? $entry['created_at'] ?? '',
            ];
        }

        return ['rows' => $rows];
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'payment_enabled' => 'sometimes|boolean',
            'pesapal_environment' => 'required|in:sandbox,live',
            'pesapal_consumer_key' => 'nullable|string|max:255',
            'pesapal_consumer_secret' => 'nullable|string|max:255',
            'pesapal_currency' => 'required|string|max:8',
            'pesapal_deposit_percentage' => 'required|integer|min:0|max:100',
            'pesapal_ipn_url' => 'nullable|url',
            'pesapal_callback_url' => 'nullable|url',
            'pesapal_cancellation_url' => 'nullable|url',
        ]);

        PaymentSettings::save('payment_enabled', $request->boolean('payment_enabled') ? '1' : '0');
        PaymentSettings::save('pesapal_environment', $request->input('pesapal_environment'));
        PaymentSettings::save('pesapal_currency', strtoupper($request->input('pesapal_currency')));
        PaymentSettings::save('pesapal_deposit_percentage', (string) $request->integer('pesapal_deposit_percentage'));
        PaymentSettings::save('pesapal_ipn_url', (string) $request->input('pesapal_ipn_url'));
        PaymentSettings::save('pesapal_callback_url', (string) $request->input('pesapal_callback_url'));
        PaymentSettings::save('pesapal_cancellation_url', (string) $request->input('pesapal_cancellation_url'));

        $key = trim((string) $request->input('pesapal_consumer_key'));
        $secret = trim((string) $request->input('pesapal_consumer_secret'));
        if ($key !== '') {
            PaymentSettings::saveSecret('pesapal_consumer_key', $key);
        }
        if ($secret !== '') {
            PaymentSettings::saveSecret('pesapal_consumer_secret', $secret);
        }

        $this->forgetTokens();

        return back()->with('success', 'Payment settings saved.');
    }

    public function testConnection(): RedirectResponse
    {
        try {
            $result = $this->payments->testConnection();
            return back()->with('success', 'Connection OK (' . $result['environment'] . '). PesaPal returned a valid access token.');
        } catch (PesaPalException $e) {
            return back()->with('error', 'Connection failed: ' . $e->getMessage());
        }
    }

    public function registerIpn(): RedirectResponse
    {
        try {
            $result = $this->payments->registerIpnUrl();
            if (($result['success'] ?? false) === true) {
                return back()->with('success', 'IPN registered successfully. Notification ID: ' . $result['ipn_id']);
            }
            return back()->with('error', 'IPN registration failed: ' . json_encode($result['result'] ?? []));
        } catch (PesaPalException $e) {
            return back()->with('error', 'IPN registration failed: ' . $e->getMessage());
        }
    }

    protected function forgetTokens(): void
    {
        Cache::forget('pesapal_token_sandbox');
        Cache::forget('pesapal_token_live');
    }

    protected function layoutData(array $data): array
    {
        return array_merge($data, [
            'destCount' => Destination::count(),
            'reviewCount' => Review::where('status', 'Pending')->count(),
            'bookingCount' => Booking::where('status', 'Pending')->count(),
            'msgCount' => Message::where('read', false)->count(),
        ]);
    }
}