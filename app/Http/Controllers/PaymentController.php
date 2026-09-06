<?php

namespace App\Http\Controllers;

use App\Exceptions\PesaPalException;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $payments)
    {
    }

    public function callback(Request $request): View|RedirectResponse
    {
        $result = $this->payments->handleCallback($request->query());

        if (!$result['payment']) {
            return redirect()->route('payments.cancelled')
                ->with('error', $result['message'] ?? 'We could not match this payment to a booking.');
        }

        return view('pages.payment-result', [
            'success' => $result['success'],
            'payment' => $result['payment'],
            'message' => $result['message'],
        ]);
    }

    public function cancelled(): View
    {
        return view('pages.payment-cancelled');
    }

    public function resume(string $reference): RedirectResponse|View
    {
        $payment = Payment::where('merchant_reference', $reference)->first();

        if (!$payment) {
            return redirect()->route('payments.cancelled')->with('error', 'Payment not found.');
        }

        try {
            $payment = $this->payments->resumePayment($payment);
        } catch (\Throwable $e) {
            return redirect()->route('payments.cancelled')
                ->with('error', 'Could not initiate payment: ' . $e->getMessage());
        }

        if ($payment->status === Payment::STATUS_COMPLETED) {
            return view('pages.payment-result', [
                'success' => true,
                'payment' => $payment,
                'message' => 'This payment has already been completed.',
            ]);
        }

        if ($payment->redirect_url) {
            return redirect()->away($payment->redirect_url);
        }

        return redirect()->route('payments.cancelled')
            ->with('error', 'A payment link is not available right now. Please contact us or try again shortly.');
    }

    public function ipn(Request $request): JsonResponse
    {
        $params = array_merge($request->query(), $request->all());

        try {
            $result = $this->payments->handleIpn($params);
        } catch (PesaPalException $e) {
            logger()->error('PesaPal IPN handler error', ['exception' => $e->getMessage()]);
            return response()->json(['acknowledged' => false, 'message' => $e->getMessage()], 500);
        } catch (\Throwable $e) {
            logger()->error('PesaPal IPN handler error', ['exception' => $e->getMessage()]);
            return response()->json(['acknowledged' => false], 500);
        }

        return response()->json(['acknowledged' => $result['acknowledged'] ?? false]);
    }
}