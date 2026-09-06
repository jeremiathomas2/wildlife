<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Mail\NewBookingAlert;
use App\Models\Booking;
use App\Models\Destination;
use App\Services\PaymentService;
use App\Services\PaymentSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'destination_id' => 'required|integer|exists:destinations,id',
            'tour_name' => 'required|string',
            'travel_date' => 'required|date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'currency' => 'required|string',
            'country_code' => 'required|string',
            'phone_number' => 'required|string',
        ]);

        $destination = Destination::findOrFail($validated['destination_id']);

        $adultPrice = $destination->price_adult ?? $destination->price ?? 0;
        $childPrice = $destination->price_child ?? ($adultPrice / 2);
        $totalPrice = ($adultPrice * $validated['adults']) + ($childPrice * ($validated['children'] ?? 0));

        $booking = Booking::create([
            ...$validated,
            'base_price' => $adultPrice,
            'total_price' => $totalPrice,
        ]);

        Mail::to($validated['email'])->queue(new BookingConfirmation($booking));
        Mail::to(config('mail.from.address'))->queue(new NewBookingAlert($booking));

        if (PaymentSettings::isEnabled()) {
            try {
                $payment = app(PaymentService::class)->createPaymentForBooking($booking);

                if ($payment->redirect_url) {
                    return redirect()->away($payment->redirect_url);
                }
            } catch (\Throwable $e) {
                logger()->error('Payment initiation failed', [
                    'booking' => $booking->id,
                    'error' => $e->getMessage(),
                ]);

                return Redirect::back()->with('success', 'Your booking has been submitted successfully! We will contact you to arrange payment.');
            }
        }

        return Redirect::back()->with('success', 'Your booking has been submitted successfully! We will contact you soon.');
    }
}
