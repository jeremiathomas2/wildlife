<?php

namespace App\Services;

use App\Exceptions\PesaPalException;
use App\Mail\PaymentConfirmation;
use App\Mail\PaymentFailedAdmin;
use App\Mail\PaymentLink;
use App\Mail\PaymentPaidAdmin;
use App\Models\AdminUser;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentLog;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PaymentService
{
    const DIAL_TO_ISO2 = [
        '+255' => 'TZ', '+254' => 'KE', '+256' => 'UG', '+257' => 'BI', '+250' => 'RW',
        '+27' => 'ZA', '+260' => 'ZM', '+265' => 'MW', '+263' => 'ZW', '+258' => 'MZ',
        '+234' => 'NG', '+233' => 'GH', '+220' => 'GM', '+221' => 'SN', '+224' => 'GN',
        '+1' => 'US', '+44' => 'GB', '+49' => 'DE', '+33' => 'FR', '+31' => 'NL',
        '+39' => 'IT', '+34' => 'ES', '+46' => 'SE', '+47' => 'NO', '+45' => 'DK',
        '+91' => 'IN', '+971' => 'AE', '+61' => 'AU', '+81' => 'JP', '+86' => 'CN',
        '+351' => 'PT', '+43' => 'AT', '+41' => 'CH', '+353' => 'IE', '+352' => 'LU',
    ];

    public function __construct(protected PesaPalService $pesapal)
    {
    }

    public function createPaymentForBooking(Booking $booking): Payment
    {
        $latest = $booking->payments()->latest('id')->first();

        if ($latest) {
            if (in_array($latest->status, [Payment::STATUS_COMPLETED, Payment::STATUS_PROCESSING], true)) {
                return $latest;
            }
            if ($latest->status === Payment::STATUS_PENDING) {
                if (!$latest->redirect_url) {
                    $this->initiateWithPesapal($latest);
                }
                return $latest->refresh();
            }
        }

        $payment = $this->createPendingPayment($booking);
        $this->initiateWithPesapal($payment);

        return $payment->refresh();
    }

    protected function createPendingPayment(Booking $booking): Payment
    {
        $amounts = $this->amountForBooking($booking);

        $firstName = $this->firstWord($booking->name);
        $lastName = $this->restAfterFirstWord($booking->name);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'merchant_reference' => $this->generateReference(),
            'payment_mode' => $amounts['mode'],
            'deposit_percentage' => $amounts['deposit_percentage'],
            'amount' => $amounts['amount'],
            'requested_amount' => $booking->total_price,
            'currency' => $this->chargeCurrency($booking),
            'status' => Payment::STATUS_PENDING,
            'provider' => 'pesapal',
            'description' => ($booking->tour_name ?? 'Tour booking') . ' — booking ' . $booking->reference,
            'customer_name' => $booking->name,
            'customer_email' => $booking->email,
            'customer_phone' => trim(($booking->country_code ?? '') . ' ' . ($booking->phone_number ?? '')),
            'billing_address' => [
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email_address' => $booking->email,
                'phone_number' => $booking->phone_number,
            ],
        ]);

        $this->log($payment, 'payment_created');

        return $payment;
    }

    public function paymentLinkForBooking(Booking $booking): string
    {
        $latest = $booking->payments()->latest('id')->first();

        if ($latest) {
            if ($latest->status === Payment::STATUS_COMPLETED) {
                return $this->payNowUrl($latest);
            }
            if (in_array($latest->status, [Payment::STATUS_PROCESSING, Payment::STATUS_PENDING], true)) {
                return $this->payNowUrl($latest->refresh());
            }
        }

        $payment = $this->createPendingPayment($booking);
        return route('payments.resume', $payment->merchant_reference);
    }

    public function resumePayment(Payment $payment): Payment
    {
        if (in_array($payment->status, [Payment::STATUS_COMPLETED, Payment::STATUS_PROCESSING], true)) {
            return $payment;
        }

        if (!$payment->redirect_url) {
            $payment->update(['status' => Payment::STATUS_PENDING]);
            $this->initiateWithPesapal($payment);
        }

        return $payment->refresh();
    }

    public function payNowUrl(Payment $payment): string
    {
        if ($payment->redirect_url && $payment->status !== Payment::STATUS_COMPLETED) {
            return $payment->redirect_url;
        }

        return route('payments.resume', $payment->merchant_reference);
    }

    public function handleCallback(array $params): array
    {
        $reference = $params['OrderMerchantReference'] ?? null;
        $payment = $reference ? Payment::where('merchant_reference', $reference)->first() : null;

        if (!$payment) {
            Log::warning('PesaPal callback for unknown reference', $params);
            return ['success' => false, 'payment' => null, 'message' => 'Payment reference not found.'];
        }

        $this->log($payment, 'callback_received', null, null, $params);
        $payment->update(['callback_data' => $params]);

        $payment = $this->reconcile($payment);

        return [
            'success' => $payment->status === Payment::STATUS_COMPLETED,
            'payment' => $payment,
            'message' => $payment->isCompleted ? 'Payment completed successfully.' : 'Payment was not completed.',
        ];
    }

    public function handleIpn(array $params): array
    {
        $reference = $params['OrderMerchantReference'] ?? $params['order_merchant_reference'] ?? null;
        $trackingId = $params['OrderTrackingId'] ?? $params['order_tracking_id'] ?? null;

        $payment = $reference
            ? Payment::where('merchant_reference', $reference)->first()
            : ($trackingId ? Payment::where('order_tracking_id', $trackingId)->first() : null);

        if (!$payment) {
            Log::warning('PesaPal IPN for unknown payment', $params);
            return ['success' => false, 'acknowledged' => false];
        }

        $this->log($payment, 'ipn_received', null, null, $params);
        $payment->update(['ipn_data' => $params]);

        $this->reconcile($payment);

        return ['success' => true, 'acknowledged' => true, 'payment' => $payment->refresh()];
    }

    public function reconcile(Payment $payment): Payment
    {
        if (!$payment->order_tracking_id) {
            $this->log($payment, 'reconcile_skipped', null, null, ['reason' => 'missing order_tracking_id']);
            $payment->update(['status' => Payment::STATUS_FAILED]);
            return $payment->refresh();
        }

        $result = $this->pesapal->transactionStatus($payment->order_tracking_id, $payment->merchant_reference);

        $current = $payment->raw_response ?? [];
        $current['status_check'] = $result;
        $payment->update(['raw_response' => $current]);

        $this->log($payment, 'status_checked', null, null, $result);

        return $this->applyStatusResult($payment, $result);
    }

    public function markByAdmin(Payment $payment, string $newStatus, AdminUser $admin): Payment
    {
        $newStatus = $this->normalizeStatus($newStatus);

        if ($payment->status !== $newStatus) {
            $from = $payment->status;
            $payment->update([
                'status' => $newStatus,
                'paid_at' => $newStatus === Payment::STATUS_COMPLETED ? now() : $payment->paid_at,
            ]);
            $this->log($payment, 'manual_action', $from, $newStatus, null, $admin->id);
            if ($newStatus === Payment::STATUS_COMPLETED) {
                $this->notifyCollected($payment);
            }
        }

        return $payment->refresh();
    }

    public function amountForBooking(Booking $booking): array
    {
        $full = (float) $booking->total_price;
        $depositPercentage = PaymentSettings::depositPercentage();

        if ($depositPercentage <= 0 || $depositPercentage >= 100) {
            return ['mode' => Payment::MODE_FULL, 'deposit_percentage' => 0, 'amount' => $full];
        }

        return [
            'mode' => Payment::MODE_DEPOSIT,
            'deposit_percentage' => $depositPercentage,
            'amount' => round($full * $depositPercentage / 100, 2),
        ];
    }

    public function chargeCurrency(Booking $booking): string
    {
        $currency = strtoupper((string) $booking->currency);
        if (in_array($currency, PesaPalService::SUPPORTED_CURRENCIES, true)) {
            return $currency;
        }
        $default = PaymentSettings::currency();
        return in_array($default, PesaPalService::SUPPORTED_CURRENCIES, true) ? $default : 'USD';
    }

    public function getIpnList(): array
    {
        try {
            return $this->pesapal->ipnList();
        } catch (\Throwable $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public function registerIpnUrl(): array
    {
        $result = $this->pesapal->registerIpnUrl($this->ipnUrl(), 'POST');
        $id = $result['ipn_id'] ?? $result['notification_id'] ?? null;
        if ($id) {
            PaymentSettings::save('pesapal_notification_id', $id);
            return ['success' => true, 'ipn_id' => $id, 'result' => $result];
        }
        return ['success' => false, 'result' => $result];
    }

    public function testConnection(): array
    {
        $token = $this->pesapal->accessToken();
        return ['success' => (bool) $token, 'token' => $token, 'environment' => PaymentSettings::environment()];
    }

    protected function initiateWithPesapal(Payment $payment): void
    {
        $payload = $this->buildOrderPayload($payment);

        $payment->update(['raw_request' => $payload]);
        $this->log($payment, 'order_submitted', null, null, $payload);

        try {
            $result = $this->pesapal->submitOrder($payload);
            $payment->update([
                'order_tracking_id' => $result['order_tracking_id'] ?? $payment->order_tracking_id,
                'redirect_url' => $result['redirect_url'] ?? $payment->redirect_url,
                'status' => Payment::STATUS_PENDING,
                'raw_response' => array_merge((array) ($payment->raw_response ?? []), ['submit_order' => $result]),
            ]);
            $this->log($payment, 'order_responded', null, null, $result);
        } catch (\Throwable $e) {
            $this->log($payment, 'order_failed', null, null, ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    protected function buildOrderPayload(Payment $payment): array
    {
        $notificationId = $this->ensureNotificationId();
        [$firstName, $lastName] = $this->splitName($payment->customer_name);

        return [
            'id' => $payment->merchant_reference,
            'currency' => $payment->currency,
            'amount' => (float) $payment->amount,
            'description' => $payment->description ?: 'Tour booking payment',
            'callback_url' => $this->callbackUrl(),
            'cancellation_url' => $this->cancellationUrl(),
            'redirect_mode' => 'TOP_WINDOW',
            'notification_id' => $notificationId,
            'billing_address' => [
                'email_address' => $payment->customer_email,
                'phone_number' => $this->sanitizePhone($payment->customer_phone),
                'country_code' => $this->dialToIso2($payment->customer_phone),
                'first_name' => $firstName,
                'middle_name' => '',
                'last_name' => $lastName,
                'line_1' => '',
                'line_2' => '',
                'city' => '',
                'state' => '',
                'postal_code' => '',
                'zip_code' => '',
            ],
        ];
    }

    protected function ensureNotificationId(): string
    {
        if ($id = PaymentSettings::notificationId()) {
            return $id;
        }

        $result = $this->pesapal->registerIpnUrl($this->ipnUrl(), 'POST');
        $id = $result['ipn_id'] ?? $result['notification_id'] ?? null;

        if (!$id) {
            throw new PesaPalException('PesaPal did not return an IPN notification id. Register the IPN URL from the settings page first.');
        }

        PaymentSettings::save('pesapal_notification_id', $id);
        return $id;
    }

    protected function applyStatusResult(Payment $payment, array $result): Payment
    {
        $apiStatus = strtoupper((string) ($result['status'] ?? $result['payment_status_description'] ?? $result['payment_status'] ?? $result['payment_status_code'] ?? ''));

        $newStatus = $this->mapApiStatus($apiStatus);

        if ($newStatus === Payment::STATUS_COMPLETED) {
            $paidAmount = $result['paid_amount'] ?? $result['amount'] ?? null;
            if ($paidAmount !== null && (float) $paidAmount < (float) $payment->amount) {
                Log::warning('PesaPal amount mismatch', [
                    'payment' => $payment->merchant_reference,
                    'expected' => $payment->amount,
                    'paid' => $paidAmount,
                ]);
                $newStatus = Payment::STATUS_FAILED;
            }
        }

        return $this->transition($payment, $newStatus, $result);
    }

    protected function mapApiStatus(string $apiStatus): string
    {
        if (str_contains($apiStatus, 'COMPLET')) return Payment::STATUS_COMPLETED;
        if (in_array($apiStatus, ['PENDING', 'ONGOING', 'ACTIVE', 'AUTHORIZED', 'PROCESSING'], true)) return Payment::STATUS_PENDING;
        if (in_array($apiStatus, ['FAILED', 'INVALID', 'DECLINED', 'ERROR', 'UNKNOWN'], true)) return Payment::STATUS_FAILED;
        if (str_contains($apiStatus, 'CANCEL')) return Payment::STATUS_CANCELLED;
        if (str_contains($apiStatus, 'REVERS')) return Payment::STATUS_REFUNDED;
        if (str_contains($apiStatus, 'EXPIRED')) return Payment::STATUS_EXPIRED;
        return Payment::STATUS_PENDING;
    }

    protected function transition(Payment $payment, string $newStatus, array $result = []): Payment
    {
        if ($payment->status === $newStatus) {
            return $payment;
        }

        $from = $payment->status;

        $payment->update([
            'status' => $newStatus,
            'payment_method' => $result['payment_method'] ?? $result['payment_channel'] ?? $payment->payment_method,
            'paid_at' => $newStatus === Payment::STATUS_COMPLETED ? now() : $payment->paid_at,
            'order_tracking_id' => $result['order_tracking_id'] ?? $payment->order_tracking_id,
        ]);

        $this->log($payment, 'status_changed', $from, $newStatus, $result);

        if ($newStatus === Payment::STATUS_COMPLETED) {
            $this->notifyCollected($payment);
        }

        if ($newStatus === Payment::STATUS_FAILED && $payment->booking) {
            Mail::to(config('mail.from.address'))->queue(new PaymentFailedAdmin($payment));
            $this->log($payment, 'failed_alert_sent', null, null, ['to' => config('mail.from.address')]);
        }

        return $payment->refresh();
    }

    protected function notifyCollected(Payment $payment): void
    {
        Mail::to($payment->customer_email)->queue(new PaymentConfirmation($payment));
        Mail::to(config('mail.from.address'))->queue(new PaymentPaidAdmin($payment));
        $this->log($payment, 'confirmation_emails_sent', null, null, ['to' => $payment->customer_email]);
    }

    public function sendPaymentLink(Payment $payment): void
    {
        $payment = $this->resumePayment($payment);
        Mail::to($payment->customer_email)->queue(new PaymentLink($payment, $this->payNowUrl($payment)));
        $this->log($payment, 'payment_link_sent', null, null, ['to' => $payment->customer_email]);
    }

    protected function log(Payment $payment, string $event, ?string $from = null, ?string $to = null, ?array $payload = null, ?int $adminId = null): void
    {
        PaymentLog::create([
            'payment_id' => $payment->id,
            'event' => $event,
            'status_from' => $from,
            'status_to' => $to,
            'admin_user_id' => $adminId,
            'payload' => $payload,
            'created_at' => now(),
        ]);
    }

    protected function generateReference(): string
    {
        return 'TDTS-' . strtoupper(bin2hex(random_bytes(4)));
    }

    protected function callbackUrl(): string
    {
        return (string) (PaymentSettings::value('pesapal_callback_url') ?: route('payments.callback'));
    }

    protected function cancellationUrl(): string
    {
        return (string) (PaymentSettings::value('pesapal_cancellation_url') ?: route('payments.cancelled'));
    }

    protected function ipnUrl(): string
    {
        return (string) (PaymentSettings::value('pesapal_ipn_url') ?: url('api/pesapal/ipn'));
    }

    protected function sanitizePhone(?string $phone): string
    {
        return preg_replace('/[^\d+]/', '', (string) $phone);
    }

    protected function dialToIso2(string $phone): string
    {
        foreach (self::DIAL_TO_ISO2 as $dial => $iso2) {
            if (str_starts_with($phone, $dial)) {
                return $iso2;
            }
        }
        return '';
    }

    protected function splitName(?string $name): array
    {
        $parts = array_values(array_filter(explode(' ', trim((string) $name))));
        if (count($parts) <= 1) {
            return [$parts[0] ?? '', ''];
        }
        $lastName = array_pop($parts);
        return [implode(' ', $parts), $lastName];
    }

    protected function firstWord(?string $name): string
    {
        $parts = explode(' ', trim((string) $name));
        return $parts[0] ?? '';
    }

    protected function restAfterFirstWord(?string $name): string
    {
        $parts = explode(' ', trim((string) $name));
        array_shift($parts);
        return implode(' ', $parts);
    }

    protected function normalizeStatus(string $status): string
    {
        return strtolower(trim($status));
    }
}