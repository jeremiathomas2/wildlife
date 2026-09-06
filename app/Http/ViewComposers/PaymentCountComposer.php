<?php

namespace App\Http\ViewComposers;

use App\Models\Payment;
use Illuminate\View\View;

class PaymentCountComposer
{
    /**
     * Bind the pending payment count to the admin layout.
     */
    public function compose(View $view): void
    {
        $view->with('paymentCount', Payment::whereIn('status', [
            Payment::STATUS_PENDING,
            Payment::STATUS_PROCESSING,
        ])->count());
    }
}