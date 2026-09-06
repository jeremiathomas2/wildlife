@extends('admin.layout')

@section('title', 'Payment ' . $payment->merchant_reference)

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Payment Details</h2>
            <p class="sub">{{ $payment->merchant_reference }} · created {{ $payment->created_at->format('M d, Y g:i A') }}</p>
        </div>
        <div class="view-actions">
            <a href="{{ route('admin.payments') }}" class="btn btn-ghost">← Back to payments</a>
            @if(!$payment->isCompleted)
                <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-soft">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                            <path d="M21 12a9 9 0 1 1-2.64-6.36"></path>
                            <polyline points="21 3 21 9 15 9"></polyline>
                        </svg>
                        Re-verify with PesaPal
                    </button>
                </form>
            @endif
        </div>
    </div>

    <div class="panel-grid" style="grid-template-columns:1fr 1fr;">
        <div class="panel">
            <div class="panel-head">
                <h3>Overview</h3>
                {!! \App\Models\Payment::statusTag($payment->status) !!}
            </div>
            <div class="panel-body">
                <table style="min-width:0;width:100%;">
                    <tbody>
                        @foreach([
                            'Reference' => $payment->merchant_reference,
                            'Tracking ID' => $payment->order_tracking_id ?: '—',
                            'Amount' => \App\Helpers\CurrencyHelper::format($payment->amount, $payment->currency),
                            'Requested Amount' => $payment->requested_amount ? \App\Helpers\CurrencyHelper::format($payment->requested_amount, $payment->currency) : '—',
                            'Mode' => ucfirst($payment->payment_mode) . ($payment->deposit_percentage > 0 ? ' (' . $payment->deposit_percentage . '%)' : ''),
                            'Payment Method' => $payment->payment_method ?: '—',
                            'Provider' => $payment->provider,
                            'Paid At' => $payment->paid_at?->format('M d, Y g:i A') ?: '—',
                        ] as $label => $value)
                        <tr>
                            <td style="padding:9px 12px;font-size:13px;color:var(--ink-soft);border-bottom:1px solid var(--line);width:45%;">{{ $label }}</td>
                            <td style="padding:9px 12px;font-size:13.5px;color:var(--coffee-900);font-weight:600;border-bottom:1px solid var(--line);">{{ $value }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">
                <h3>Customer & Booking</h3>
            </div>
            <div class="panel-body">
                <table style="min-width:0;width:100%;">
                    <tbody>
                        @foreach([
                            'Customer' => $payment->customer_name ?: '—',
                            'Email' => $payment->customer_email ?: '—',
                            'Phone' => $payment->customer_phone ?: '—',
                            'Booking' => $payment->booking?->reference ?: '—',
                            'Tour' => $payment->booking?->tour_name ?: '—',
                            'Travel Date' => $payment->booking ? \Carbon\Carbon::parse($payment->booking->travel_date)->format('M d, Y') : '—',
                            'Booking Status' => $payment->booking ? $payment->booking->status : '—',
                        ] as $label => $value)
                        <tr>
                            <td style="padding:9px 12px;font-size:13px;color:var(--ink-soft);border-bottom:1px solid var(--line);width:45%;">{{ $label }}</td>
                            <td style="padding:9px 12px;font-size:13.5px;color:var(--coffee-900);font-weight:600;border-bottom:1px solid var(--line);">{{ $value }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($payment->booking)
                    <div style="margin-top:16px;">
                        <form action="{{ route('admin.bookings.payment-link', $payment->booking_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-soft btn-sm">Resend payment link</button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="panel-grid" style="grid-template-columns:1.4fr 1fr;margin-top:0;">
        <div class="panel">
            <div class="panel-head">
                <h3>Payment Log</h3>
            </div>
            <div class="panel-body" style="max-height:420px;overflow-y:auto;">
                @if($payment->logs->isEmpty())
                    <p style="color:var(--ink-soft);font-size:13.5px;">No activity yet.</p>
                @else
                    <div class="activity-list">
                        @foreach($payment->logs->sortByDesc('created_at') as $log)
                        <div class="activity-row">
                            <div class="activity-ico">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                            </div>
                            <div style="flex:1;">
                                <div class="activity-text">
                                    <b>{{ strtoupper(str_replace('_', ' ', $log->event)) }}</b>
                                    @if($log->status_from && $log->status_to)
                                        <span style="color:var(--ink-soft);font-size:12.5px;">
                                            · {{ $log->status_from }} → {{ $log->status_to }}
                                        </span>
                                    @endif
                                </div>
                                <div class="activity-time">{{ $log->created_at->format('M d, Y g:i A') }}{{ $log->admin ? ' · by ' . $log->admin->name : '' }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="panel">
            <div class="panel-head">
                <h3>Manual status</h3>
            </div>
            <div class="panel-body">
                <p style="font-size:13px;color:var(--ink-soft);margin-bottom:14px;">Use for offline adjustments (e.g. bank transfer received). This is recorded in the audit log.</p>
                <form action="{{ route('admin.payments.status', $payment->id) }}" method="POST">
                    @csrf
                    <div class="field">
                        <label>New status</label>
                        <select name="status">
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ $payment->status === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">Update status</button>
                </form>
            </div>
        </div>
    </div>

    <div class="panel" style="margin-bottom:0;">
        <div class="panel-head">
            <h3>Gateway payloads</h3>
        </div>
        <div class="panel-body">
            <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:16px;" class="payload-grid">
                <div>
                    <h4 style="font-size:13px;color:var(--coffee-700);margin-bottom:8px;">Order request</h4>
                    <pre style="background:var(--sand-50);border:1px solid var(--line);border-radius:8px;padding:12px;font-size:12px;max-height:260px;overflow:auto;white-space:pre-wrap;word-break:break-all;color:var(--coffee-800);">{{ json_encode($payment->raw_request, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: '—' }}</pre>
                </div>
                <div>
                    <h4 style="font-size:13px;color:var(--coffee-700);margin-bottom:8px;">Order response</h4>
                    <pre style="background:var(--sand-50);border:1px solid var(--line);border-radius:8px;padding:12px;font-size:12px;max-height:260px;overflow:auto;white-space:pre-wrap;word-break:break-all;color:var(--coffee-800);">{{ json_encode($payment->raw_response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: '—' }}</pre>
                </div>
                <div>
                    <h4 style="font-size:13px;color:var(--coffee-700);margin-bottom:8px;">Callback data</h4>
                    <pre style="background:var(--sand-50);border:1px solid var(--line);border-radius:8px;padding:12px;font-size:12px;max-height:260px;overflow:auto;white-space:pre-wrap;word-break:break-all;color:var(--coffee-800);">{{ json_encode($payment->callback_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: '—' }}</pre>
                </div>
                <div>
                    <h4 style="font-size:13px;color:var(--coffee-700);margin-bottom:8px;">IPN data</h4>
                    <pre style="background:var(--sand-50);border:1px solid var(--line);border-radius:8px;padding:12px;font-size:12px;max-height:260px;overflow:auto;white-space:pre-wrap;word-break:break-all;color:var(--coffee-800);">{{ json_encode($payment->ipn_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) ?: '—' }}</pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection