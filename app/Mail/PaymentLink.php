<?php

namespace App\Mail;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentLink extends Mailable
{
    use Queueable, SerializesModels;

    public Payment $payment;
    public string $payUrl;

    public function __construct(Payment $payment, string $payUrl)
    {
        $this->payment = $payment;
        $this->payUrl = $payUrl;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Complete Your Payment - Tanzania Daily Tours & Safari',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-link',
        );
    }
}