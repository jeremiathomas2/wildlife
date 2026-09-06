<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Payment;
use App\Services\PaymentService;
use App\Services\PaymentSettings;
use App\Services\PesaPalService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;

    private function createDestination(array $overrides = []): Destination
    {
        return Destination::create(array_merge([
            'name' => 'Ngorongoro Crater',
            'slug' => 'ngorongoro-crater',
            'category' => 'Day Trip',
            'duration' => '1 Day',
            'price' => 300,
            'price_adult' => 300,
            'price_child' => 150,
            'status' => 'Published',
            'image' => 'https://example.com/image.jpg',
            'desc' => 'A great crater',
        ], $overrides));
    }

    private function createBooking(Destination $destination): Booking
    {
        return Booking::create([
            'destination_id' => $destination->id,
            'tour_name' => 'Ngorongoro Crater',
            'base_price' => 300,
            'total_price' => 600,
            'currency' => 'USD',
            'travel_date' => now()->addDays(10)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'email' => 'traveler@example.com',
            'country_code' => '+255',
            'phone_number' => '712345678',
            'name' => 'Asha Mwangi',
            'status' => 'Pending',
        ]);
    }

    private function enablePayments(int $deposit = 0): void
    {
        PaymentSettings::save('payment_enabled', '1');
        PaymentSettings::save('pesapal_environment', 'sandbox');
        PaymentSettings::save('pesapal_currency', 'USD');
        PaymentSettings::save('pesapal_deposit_percentage', (string) $deposit);
        PaymentSettings::save('pesapal_consumer_key', 'test-key');
        PaymentSettings::save('pesapal_consumer_secret', 'test-secret');
        PaymentSettings::save('pesapal_notification_id', 'notif-123');
    }

    private function fakePesaPal(): void
    {
        $base = PesaPalService::SANDBOX_BASE;

        Http::fake([
            $base . '/Auth/RequestToken*' => Http::response([
                'token' => 'test-access-token',
            ]),
            $base . '/Transactions/SubmitOrderRequest*' => Http::response([
                'order_tracking_id' => 'TRACK-001',
                'redirect_url' => 'https://pay.pesapal.com/checkout/TRACK-001',
                'merchant_reference' => '*',
            ]),
            $base . '/Transactions/GetTransactionStatus*' => Http::response([
                'order_tracking_id' => 'TRACK-001',
                'status' => 'COMPLETED',
                'payment_method' => 'VISA',
                'payment_status_description' => 'Completed',
                'paid_amount' => 600.00,
            ]),
        ]);
    }

    public function test_create_payment_for_booking_with_deposit(): void
    {
        $this->enablePayments(30);
        $this->fakePesaPal();

        $booking = $this->createBooking($this->createDestination());

        $payment = app(PaymentService::class)->createPaymentForBooking($booking);

        $this->assertSame(Payment::STATUS_PENDING, $payment->status);
        $this->assertSame(Payment::MODE_DEPOSIT, $payment->payment_mode);
        $this->assertEquals(180.00, (float) $payment->amount);
        $this->assertSame('TRACK-001', $payment->order_tracking_id);
        $this->assertSame('https://pay.pesapal.com/checkout/TRACK-001', $payment->redirect_url);
        $this->assertStringStartsWith('TDTS-', $payment->merchant_reference);
        $this->assertDatabaseHas('payment_logs', [
            'payment_id' => $payment->id,
            'event' => 'order_responded',
        ]);
    }

    public function test_booking_submit_redirects_to_pesapal_when_enabled(): void
    {
        $this->enablePayments(100);
        $this->fakePesaPal();

        $destination = $this->createDestination(['price_adult' => 300, 'price_child' => 150]);

        $response = $this->post(route('bookings.store'), [
            'name' => 'Asha Mwangi',
            'email' => 'traveler@example.com',
            'destination_id' => $destination->id,
            'tour_name' => 'Ngorongoro Crater',
            'travel_date' => now()->addDays(10)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'currency' => 'USD',
            'country_code' => '+255',
            'phone_number' => '712345678',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('https://pay.pesapal.com/checkout/TRACK-001');

        $this->assertDatabaseHas('payments', [
            'amount' => 600.00,
            'order_tracking_id' => 'TRACK-001',
            'status' => Payment::STATUS_PENDING,
        ]);
    }

    public function test_booking_submit_with_selected_currency_converts_total_and_charges_exact_deposit(): void
    {
        $this->enablePayments(30);
        $this->fakePesaPal();

        $destination = $this->createDestination(['price_adult' => 300, 'price_child' => 150]);

        $response = $this->post(route('bookings.store'), [
            'name' => 'Asha Mwangi',
            'email' => 'traveler@example.com',
            'destination_id' => $destination->id,
            'tour_name' => 'Ngorongoro Crater',
            'travel_date' => now()->addDays(10)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'currency' => 'EUR',
            'country_code' => '+255',
            'phone_number' => '712345678',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect('https://pay.pesapal.com/checkout/TRACK-001');

        $this->assertDatabaseHas('bookings', [
            'email' => 'traveler@example.com',
            'currency' => 'EUR',
            'total_price' => 552.00,
        ]);
        $this->assertDatabaseHas('payments', [
            'currency' => 'EUR',
            'amount' => 165.60,
            'requested_amount' => 552.00,
            'status' => Payment::STATUS_PENDING,
        ]);
    }

    public function test_booking_submit_with_unsupported_currency_does_not_create_payment(): void
    {
        $this->enablePayments(30);
        $this->fakePesaPal();

        $destination = $this->createDestination(['price_adult' => 300, 'price_child' => 150]);

        $response = $this->post(route('bookings.store'), [
            'name' => 'Asha Mwangi',
            'email' => 'traveler@example.com',
            'destination_id' => $destination->id,
            'tour_name' => 'Ngorongoro Crater',
            'travel_date' => now()->addDays(10)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'currency' => 'JPY',
            'country_code' => '+255',
            'phone_number' => '712345678',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('payments', 0);
        $this->assertDatabaseHas('bookings', [
            'email' => 'traveler@example.com',
            'currency' => 'JPY',
            'total_price' => 90600.00,
        ]);
    }

    public function test_amount_for_booking_converts_uncommon_currency_to_charge_currency(): void
    {
        $this->enablePayments(30);

        $booking = Booking::create([
            'destination_id' => $this->createDestination()->id,
            'tour_name' => 'Ngorongoro Crater',
            'base_price' => 300,
            'total_price' => 90600.00,
            'currency' => 'JPY',
            'travel_date' => now()->addDays(10)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'email' => 'traveler@example.com',
            'country_code' => '+255',
            'phone_number' => '712345678',
            'name' => 'Asha Mwangi',
            'status' => 'Pending',
        ]);

        $amounts = app(PaymentService::class)->amountForBooking($booking);

        $this->assertSame(Payment::MODE_DEPOSIT, $amounts['mode']);
        $this->assertEquals(180.00, $amounts['amount']);
        $this->assertEquals(600.00, $amounts['requested_amount']);
    }

    public function test_booking_submit_with_payment_disabled_does_not_create_payment(): void
    {
        $this->fakePesaPal();

        $destination = $this->createDestination(['price_adult' => 300, 'price_child' => 150]);

        $response = $this->post(route('bookings.store'), [
            'name' => 'Asha Mwangi',
            'email' => 'traveler@example.com',
            'destination_id' => $destination->id,
            'tour_name' => 'Ngorongoro Crater',
            'travel_date' => now()->addDays(10)->format('Y-m-d'),
            'adults' => 2,
            'children' => 0,
            'currency' => 'USD',
            'country_code' => '+255',
            'phone_number' => '712345678',
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('payments', 0);
        $this->assertDatabaseHas('bookings', [
            'email' => 'traveler@example.com',
            'total_price' => 600.00,
        ]);
    }

    public function test_callback_reconciles_and_completes_payment(): void
    {
        $this->enablePayments(100);
        $this->fakePesaPal();
        Mail::fake();

        $payment = app(PaymentService::class)->createPaymentForBooking($this->createBooking($this->createDestination()));

        $response = $this->get(route('payments.callback', [
            'OrderMerchantReference' => $payment->merchant_reference,
            'OrderTrackingId' => 'TRACK-001',
        ]));

        $response->assertOk();
        $response->assertSee('Payment Confirmed');

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => Payment::STATUS_COMPLETED,
            'payment_method' => 'VISA',
        ]);
        $this->assertNotNull($payment->refresh()->paid_at);
        $this->assertDatabaseHas('payment_logs', [
            'payment_id' => $payment->id,
            'event' => 'status_changed',
            'status_from' => Payment::STATUS_PENDING,
            'status_to' => Payment::STATUS_COMPLETED,
        ]);
    }

    public function test_amount_mismatch_marks_payment_failed(): void
    {
        $this->enablePayments(100);
        $base = PesaPalService::SANDBOX_BASE;

        Http::fake([
            $base . '/Auth/RequestToken*' => Http::response(['token' => 'test-access-token']),
            $base . '/Transactions/SubmitOrderRequest*' => Http::response([
                'order_tracking_id' => 'TRACK-001',
                'redirect_url' => 'https://pay.pesapal.com/checkout/TRACK-001',
            ]),
            $base . '/Transactions/GetTransactionStatus*' => Http::response([
                'order_tracking_id' => 'TRACK-001',
                'status' => 'COMPLETED',
                'paid_amount' => 100.00,
            ]),
        ]);

        $payment = app(PaymentService::class)->createPaymentForBooking($this->createBooking($this->createDestination()));

        $this->get(route('payments.callback', [
            'OrderMerchantReference' => $payment->merchant_reference,
            'OrderTrackingId' => 'TRACK-001',
        ]));

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => Payment::STATUS_FAILED,
        ]);
    }

    public function test_ipn_webhook_acknowledges_and_updates_payment(): void
    {
        $this->enablePayments(100);
        $this->fakePesaPal();

        $payment = app(PaymentService::class)->createPaymentForBooking($this->createBooking($this->createDestination()));

        $response = $this->postJson(route('payments.ipn'), [
            'OrderMerchantReference' => $payment->merchant_reference,
            'OrderTrackingId' => 'TRACK-001',
        ], [
            'X-CSRF-TOKEN' => csrf_token(),
        ]);

        $response->assertOk()
            ->assertJson(['acknowledged' => true]);

        $this->assertDatabaseHas('payments', [
            'id' => $payment->id,
            'status' => Payment::STATUS_COMPLETED,
        ]);
        $this->assertDatabaseHas('payment_logs', [
            'payment_id' => $payment->id,
            'event' => 'ipn_received',
        ]);
    }

    public function test_callback_with_unknown_reference_redirects_to_cancelled(): void
    {
        $this->fakePesaPal();

        $this->get(route('payments.callback', [
            'OrderMerchantReference' => 'UNKNOWN-REF',
            'OrderTrackingId' => 'TRACK-001',
        ]))->assertRedirect(route('payments.cancelled'));
    }

    public function test_payment_link_for_booking_returns_resume_url_without_contacting_gateway(): void
    {
        $this->enablePayments();
        Http::fake(); // no gateway call should happen

        $booking = $this->createBooking($this->createDestination());

        $url = app(PaymentService::class)->paymentLinkForBooking($booking);

        $this->assertStringContainsString('/payments/pay/', $url);

        $payment = Payment::where('booking_id', $booking->id)->first();
        $this->assertNotNull($payment);
        $this->assertSame(Payment::STATUS_PENDING, $payment->status);
    }

    public function test_resume_for_unknown_reference_redirects_to_cancelled(): void
    {
        $this->get(route('payments.resume', 'UNKNOWN-REF'))
            ->assertRedirect(route('payments.cancelled'));
    }

    public function test_admin_can_view_registered_ipns(): void
    {
        $this->enablePayments();

        $base = PesaPalService::SANDBOX_BASE;

        Http::fake([
            $base . '/Auth/RequestToken*' => Http::response(['token' => 'fake-token']),
            $base . '/URLSetup/GetIpnList*' => Http::response([
                'ipns' => [
                    [
                        'ipn_id' => 'ipn-111',
                        'url' => 'https://example.com/api/pesapal/ipn',
                        'ipn_notification_type' => 'POST',
                        'created_date' => '01-Sep-2026 09:27',
                    ],
                    [
                        'ipn_id' => 'ipn-222',
                        'url' => 'https://paymentspageapi.pesapal.com/api/Transactions/CreateTransaction',
                        'ipn_notification_type' => 'POST',
                        'created_date' => '10-Aug-2026 10:20',
                    ],
                ],
            ]),
        ]);

        $admin = \App\Models\AdminUser::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => 'secret',
            'is_active' => true,
        ]);

        $response = $this->withSession([
            'admin_logged_in' => true,
            'admin_user_id' => $admin->id,
            'admin_last_activity' => time(),
        ])->post(route('admin.payments.settings.ipns'));

        $response->assertOk();
        $response->assertViewHas('ipnList', function ($val) {
            return isset($val['rows'])
                && count($val['rows']) === 2
                && $val['rows'][0]['id'] === 'ipn-111';
        });
    }
}