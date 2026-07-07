<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'tour_name' => 'required|string',
            'base_price' => 'required|numeric',
            'currency' => 'required|string',
            'travel_date' => 'required|date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'email' => 'required|email',
            'country_code' => 'required|string',
            'phone_number' => 'required|string',
            'total_price' => 'required|numeric',
        ]);

        Booking::create($validated);

        return Redirect::back()->with('success', 'Your booking has been submitted successfully! We will contact you soon.');
    }
}
