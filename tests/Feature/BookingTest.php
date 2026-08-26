<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Booking;
use App\Models\Destination;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    private function createDestination(array $overrides = []): Destination
    {
        return Destination::create(array_merge([
            'name' => 'Serengeti Safari',
            'slug' => 'serengeti-safari',
            'category' => 'Day Trip',
            'duration' => '1 Day',
            'price' => 250,
            'price_adult' => 250,
            'price_child' => 125,
            'status' => 'Published',
            'image' => 'https://example.com/image.jpg',
            'desc' => 'A great safari',
        ], $overrides));
    }

    public function test_valid_booking_creates_record_with_server_computed_prices(): void
    {
        $destination = $this->createDestination(['price_adult' => 300, 'price_child' => 150]);

        $response = $this->post(route('bookings.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'destination_id' => $destination->id,
            'tour_name' => 'Serengeti Safari',
            'travel_date' => now()->addDays(30)->format('Y-m-d'),
            'adults' => 2,
            'children' => 1,
            'currency' => 'USD',
            'country_code' => '+255',
            'phone_number' => '712345678',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('bookings', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'destination_id' => $destination->id,
            'base_price' => 300,
            'total_price' => 750,
            'adults' => 2,
            'children' => 1,
        ]);
    }

    public function test_tampered_price_is_overridden_by_server(): void
    {
        $destination = $this->createDestination(['price_adult' => 500, 'price_child' => 250]);

        $response = $this->post(route('bookings.store'), [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'destination_id' => $destination->id,
            'tour_name' => 'Serengeti Safari',
            'travel_date' => now()->addDays(15)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'currency' => 'USD',
            'country_code' => '+255',
            'phone_number' => '712345678',
        ]);

        $response->assertRedirect();
        $booking = Booking::where('email', 'jane@example.com')->first();
        $this->assertEquals(500, $booking->base_price);
        $this->assertEquals(1000, $booking->total_price);
    }

    public function test_missing_required_fields_returns_422(): void
    {
        $response = $this->post(route('bookings.store'), []);
        $response->assertStatus(422);
    }

    public function test_invalid_destination_id_returns_422(): void
    {
        $response = $this->post(route('bookings.store'), [
            'name' => 'Test',
            'email' => 'test@example.com',
            'destination_id' => 99999,
            'tour_name' => 'Test',
            'travel_date' => now()->format('Y-m-d'),
            'adults' => 1,
            'currency' => 'USD',
            'country_code' => '+255',
            'phone_number' => '123',
        ]);

        $response->assertStatus(422);
    }
}
