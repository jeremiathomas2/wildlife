<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->string('merchant_reference')->unique();
            $table->string('order_tracking_id')->nullable()->index();
            $table->text('redirect_url')->nullable();
            $table->string('payment_mode')->default('full');
            $table->unsignedInteger('deposit_percentage')->default(0);
            $table->decimal('amount', 12, 2);
            $table->decimal('requested_amount', 12, 2)->nullable();
            $table->string('currency', 8)->default('USD');
            $table->string('status')->default('pending')->index();
            $table->string('provider')->default('pesapal');
            $table->string('payment_method')->nullable();
            $table->string('description')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->json('billing_address')->nullable();
            $table->json('callback_data')->nullable();
            $table->json('ipn_data')->nullable();
            $table->json('raw_request')->nullable();
            $table->json('raw_response')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};