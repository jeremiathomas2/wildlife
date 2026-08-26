<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmation;
use App\Mail\NewBookingAlert;

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

        return Redirect::back()->with('success', 'Your booking has been submitted successfully! We will contact you soon.');
    }
}
