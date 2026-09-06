<?php

namespace App\Console\Commands;

use App\Services\PaymentService;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('pesapal:register-ipn')]
#[Description('Register the PesaPal IPN URL for the configured environment')]
class RegisterPesaPalIpn extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(PaymentService $payments): int
    {
        try {
            $result = $payments->registerIpnUrl();

            if (($result['success'] ?? false) === true) {
                $this->info('IPN registered successfully. Notification ID: ' . $result['ipn_id']);

                return self::SUCCESS;
            }

            $this->error('IPN registration failed: ' . json_encode($result['result'] ?? []));

            return self::FAILURE;
        } catch (\Throwable $e) {
            $this->error('IPN registration failed: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}