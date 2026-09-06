@extends('admin.layout')

@section('title', 'Payments')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Payments</h2>
            <p class="sub">Track, verify and manage all PesaPal transactions.</p>
        </div>
        <div class="view-actions">
            <a href="{{ route('admin.payments.settings') }}" class="btn btn-soft">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.7 1.7 0 0 0-1.87-.34 1.7 1.7 0 0 0-1.04 1.56V21a2 2 0 0 1-4 0v-.09A1.7 1.7 0 0 0 9 19.4a1.7 1.7 0 0 0-1.87.34l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06A1.7 1.7 0 0 0 4.6 15a1.7 1.7 0 0 0-1.56-1.04H3a2 2 0 0 1 0-4h.09A1.7 1.7 0 0 0 4.6 9a1.7 1.7 0 0 0-.34-1.87l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06A1.7 1.7 0 0 0 9 4.6a1.7 1.7 0 0 0 1.04-1.56V3a2 2 0 0 1 4 0v.09A1.7 1.7 0 0 0 15 4.6a1.7 1.7 0 0 0 1.87-.34l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06A1.7 1.7 0 0 0 19.4 9a1.7 1.7 0 0 0 1.56 1.04H21a2 2 0 0 1 0 4h-.09A1.7 1.7 0 0 0 19.4 15Z"></path>
                </svg>
                Payment Settings
            </a>
        </div>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div class="chip-filters">
                <a class="chip {{ $activeStatus === '' ? 'active' : '' }}" href="{{ route('admin.payments') }}">All</a>
                @foreach($statuses as $status)
                    <a class="chip {{ $activeStatus === $status ? 'active' : '' }}" href="{{ route('admin.payments', ['status' => $status]) }}">{{ ucfirst($status) }}</a>
                @endforeach
            </div>
            <form class="table-search" method="GET" action="{{ route('admin.payments') }}">
                @if($activeStatus)
                    <input type="hidden" name="status" value="{{ $activeStatus }}">
                @endif
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" value="{{ $search }}" placeholder="Search reference, email, guest…">
                @if($search || $activeStatus)
                    <a href="{{ route('admin.payments') }}" style="display:inline-flex;align-items:center;color:var(--ink-soft);" title="Clear filters">✕</a>
                @endif
            </form>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Payment</th>
                        <th>Customer</th>
                        <th>Booking</th>
                        <th>Amount</th>
                        <th>Mode</th>
                        <th>Method</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if($payments->isEmpty())
                        <tr><td colspan="9" style="text-align:center;color:var(--ink-soft);padding:30px;">No payments found.</td></tr>
                    @else
                        @foreach($payments as $payment)
                        <tr>
                            <td>
                                <div class="cell-main">
                                    <div>
                                        <div class="cell-title">{{ $payment->merchant_reference }}</div>
                                        <div class="cell-sub">{{ $payment->order_tracking_id ?? 'no tracking id' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="cell-title">{{ $payment->customer_name ?? '—' }}</div>
                                <div class="cell-sub">{{ $payment->customer_email }}</div>
                            </td>
                            <td>
                                <div class="cell-title">{{ $payment->booking?->reference ?? '—' }}</div>
                                <div class="cell-sub">{{ \Illuminate\Support\Str::limit($payment->description, 40) }}</div>
                            </td>
                            <td>
                                <div class="cell-title">{{ \App\Helpers\CurrencyHelper::format($payment->amount, $payment->currency) }}</div>
                                @if($payment->requested_amount && (float)$payment->requested_amount !== (float)$payment->amount)
                                    <div class="cell-sub">of {{ \App\Helpers\CurrencyHelper::format($payment->requested_amount, $payment->currency) }}</div>
                                @endif
                            </td>
                            <td>
                                <span class="tag tag-grey">{{ ucfirst($payment->payment_mode) }}{{ $payment->deposit_percentage > 0 ? ' ' . $payment->deposit_percentage . '%' : '' }}</span>
                            </td>
                            <td>{{ $payment->payment_method ?: '—' }}</td>
                            <td>{{ $payment->created_at->format('M d, Y') }}</td>
                            <td>{!! \App\Models\Payment::statusTag($payment->status) !!}</td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('admin.payments.show', $payment->id) }}" title="View" style="width:32px;height:32px;border-radius:8px;border:1px solid var(--line);background:var(--white);display:flex;align-items:center;justify-content:center;color:var(--coffee-700);">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14.5px;height:14.5px;">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    @if(!$payment->isCompleted)
                                        <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" title="Re-verify with PesaPal" style="display:inline;">
                                            @csrf
                                            <button type="submit" style="width:32px;height:32px;border-radius:8px;border:1px solid var(--line);background:var(--white);display:flex;align-items:center;justify-content:center;color:var(--coffee-700);">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:14.5px;height:14.5px;">
                                                    <path d="M21 12a9 9 0 1 1-2.64-6.36"></path>
                                                    <polyline points="21 3 21 9 15 9"></polyline>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        @if($payments->hasPages())
            <div class="table-pagination">
                {{ $payments->links('vendor.pagination.admin') }}
            </div>
        @endif
    </div>
</div>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif
@if(session('error'))
<script>
    toast('{{ session('error') }}', 'error');
</script>
@endif
@endsection