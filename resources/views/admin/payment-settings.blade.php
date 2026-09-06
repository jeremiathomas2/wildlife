@extends('admin.layout')

@section('title', 'Payment Settings')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Payment Integration</h2>
            <p class="sub">PesaPal credentials, environment and payment rules.</p>
        </div>
        <div class="view-actions">
            <a href="{{ route('admin.payments') }}" class="btn btn-ghost">← Payments</a>
            <button type="submit" form="paymentSettingsForm" class="btn btn-primary">Save changes</button>
        </div>
    </div>

    <div class="settings-grid">
        <div class="settings-nav">
            <button class="{{ $activePane === 'general' ? 'active' : '' }}" onclick="setSettingsPane('general'); this.classList.add('active');">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px;">
                    <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                    <rect x="9" y="9" width="6" height="6"></rect>
                </svg>
                Connection
            </button>
            <button class="{{ $activePane === 'rules' ? 'active' : '' }}" onclick="setSettingsPane('rules'); this.classList.add('active');">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px;">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                Payment Rules
            </button>
            <button class="{{ $activePane === 'endpoints' ? 'active' : '' }}" onclick="setSettingsPane('endpoints'); this.classList.add('active');">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:17px;height:17px;">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
                URLs & IPN
            </button>
        </div>

        <div class="settings-panel">
            <form id="paymentSettingsForm" action="{{ route('admin.payments.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="settings-pane {{ $activePane === 'general' ? 'active' : '' }}" id="pane-general">
                    <h3 style="font-size:17px;margin-bottom:6px;">PesaPal connection</h3>
                    <p class="field-hint" style="color:var(--ink-soft);font-size:13px;margin-bottom:18px;">
                        Credentials are stored <b>encrypted</b>. A blank key/secret keeps the saved value.
                    </p>

                    <div class="toggle-row" style="border-bottom:1px solid var(--line);margin-bottom:18px;">
                        <div class="toggle-text">
                            <strong>Online payments enabled</strong>
                            <span>Redirect customers to PesaPal checkout after booking</span>
                        </div>
                        <input type="hidden" name="payment_enabled" value="0">
                        <button type="button" data-hidden-name="payment_enabled" data-toggle class="switch {{ ($settings['payment_enabled'] ?? '0') === '1' ? 'on' : '' }}"></button>
                    </div>

                    <div class="field">
                        <label>Environment</label>
                        <select name="pesapal_environment">
                            <option value="sandbox" {{ $environment === 'sandbox' ? 'selected' : '' }}>Sandbox (test)</option>
                            <option value="live" {{ $environment === 'live' ? 'selected' : '' }}>Live (production)</option>
                        </select>
                        <p class="field-hint" style="font-size:12px;color:var(--ink-soft);margin-top:5px;">
                            Sandbox: cybqa.pesapal.com · Live: pay.pesapal.com
                        </p>
                    </div>

                    <div class="form-row">
                        <div class="field">
                            <label>Consumer key</label>
                            <input type="password" name="pesapal_consumer_key" placeholder="{{ !empty($secretsStored['pesapal_consumer_key']) ? '•••••••• (saved — leave blank to keep)' : '' }}" autocomplete="off">
                        </div>
                        <div class="field">
                            <label>Consumer secret</label>
                            <input type="password" name="pesapal_consumer_secret" placeholder="{{ !empty($secretsStored['pesapal_consumer_secret']) ? '•••••••• (saved — leave blank to keep)' : '' }}" autocomplete="off">
                        </div>
                    </div>

                    <div style="display:flex;gap:10px;flex-wrap:wrap;">
                        <button type="button" onclick="submitPaymentAction('{{ route('admin.payments.settings.test') }}')" class="btn btn-soft">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                                <path d="M21 12a9 9 0 1 1-2.64-6.36"></path>
                                <polyline points="21 3 21 9 15 9"></polyline>
                            </svg>
                            Test connection
                        </button>
                        <button type="button" onclick="submitPaymentAction('{{ route('admin.payments.settings.ipn') }}')" class="btn btn-soft">Register IPN URL</button>
                    </div>
                </div>

                <div class="settings-pane {{ $activePane === 'rules' ? 'active' : '' }}" id="pane-rules">
                    <h3 style="font-size:17px;margin-bottom:18px;">Payment rules</h3>
                    <div class="form-row">
                        <div class="field">
                            <label>Charging currency</label>
                            <select name="pesapal_currency">
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency }}" {{ strtoupper($settings['pesapal_currency'] ?? 'USD') === $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field">
                            <label>Deposit percentage (0 = full amount)</label>
                            <input type="number" name="pesapal_deposit_percentage" min="0" max="100" value="{{ $depositPercentage }}" required>
                        </div>
                    </div>
                    <p class="field-hint" style="font-size:12.5px;color:var(--ink-soft);margin-top:8px;">
                        When a deposit is set, customers are charged that percentage now and the balance is arranged before travel.
                        Set to 0 or 100 to always charge the full tour amount.
                    </p>
                </div>

                <div class="settings-pane {{ $activePane === 'endpoints' ? 'active' : '' }}" id="pane-endpoints">
                    <h3 style="font-size:17px;margin-bottom:6px;">Endpoints & IPN</h3>
                    <p class="field-hint" style="font-size:12.5px;color:var(--ink-soft);margin-bottom:18px;">
                        Leave blank to use the app routes automatically. For local testing, point these to a public tunnel
                        (e.g. ngrok) so PesaPal can reach your server.
                    </p>
                    <div class="field">
                        <label>Callback URL</label>
                        <input type="url" name="pesapal_callback_url" value="{{ $settings['pesapal_callback_url'] ?? '' }}" placeholder="{{ $callbackUrl }}">
                    </div>
                    <div class="field">
                        <label>Cancellation URL</label>
                        <input type="url" name="pesapal_cancellation_url" value="{{ $settings['pesapal_cancellation_url'] ?? '' }}" placeholder="{{ $cancellationUrl }}">
                    </div>
                    <div class="field">
                        <label>IPN URL</label>
                        <input type="url" name="pesapal_ipn_url" value="{{ $settings['pesapal_ipn_url'] ?? '' }}" placeholder="{{ $ipnUrl }}">
                    </div>
                    <div class="issue-card" style="background:var(--sand-100);border:1px dashed var(--coffee-300);border-radius:10px;padding:14px 16px;">
                        <div class="detail-row" style="display:flex;justify-content:space-between;font-size:13.5px;padding:6px 0;">
                            <span style="color:var(--ink-soft);">Notification ID</span>
                            <span style="font-weight:700;color:var(--coffee-900);">{{ $notificationId ?: 'Not registered' }}</span>
                        </div>
                        <p style="font-size:12px;color:var(--ink-soft);margin-top:6px;">
                            Register the IPN URL once per environment. The notification ID is required when submitting orders to PesaPal.
                        </p>
                    </div>

                    <div style="margin-top:16px;">
                        <button type="button" onclick="submitPaymentAction('{{ route('admin.payments.settings.ipns') }}')" class="btn btn-soft btn-sm">View registered IPNs</button>
                    </div>

                    @if(isset($ipnList))
                        @if(isset($ipnList['error']))
                            <div style="margin-top:16px;padding:12px 16px;background:var(--danger-100);border:1px solid var(--danger-200);border-radius:10px;color:var(--danger);font-size:13px;">
                                Could not fetch registered IPNs: {{ $ipnList['error'] }}
                            </div>
                        @elseif(empty($ipnList['rows']))
                            <div style="margin-top:16px;padding:12px 16px;background:var(--sand-100);border-radius:10px;color:var(--ink-soft);font-size:13px;">
                                No IPN URLs registered in this PesaPal environment yet.
                            </div>
                        @else
                            <div style="margin-top:16px;border:1px solid var(--line);border-radius:10px;overflow:hidden;">
                                <table style="width:100%;min-width:0;border-collapse:collapse;font-size:13px;">
                                    <thead>
                                        <tr style="background:var(--sand-50);">
                                            <th style="text-align:left;padding:10px 14px;font-size:11px;text-transform:uppercase;color:var(--ink-soft);">URL</th>
                                            <th style="text-align:left;padding:10px 14px;font-size:11px;text-transform:uppercase;color:var(--ink-soft);">Type</th>
                                            <th style="text-align:left;padding:10px 14px;font-size:11px;text-transform:uppercase;color:var(--ink-soft);">Created</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ipnList['rows'] as $ipn)
                                            <tr style="border-top:1px solid var(--line);">
                                                <td style="padding:10px 14px;word-break:break-all;">
                                                    @if(isset($ipn['id']) && $ipn['id'] === $notificationId)
                                                        <span class="tag tag-green" style="margin-right:6px;">Active</span>
                                                    @endif
                                                    {{ $ipn['url'] }}
                                                    @if(isset($ipn['id']) && $ipn['id'] !== '—')
                                                        <div style="font-size:11px;color:var(--ink-soft);margin-top:2px;">{{ $ipn['id'] }}</div>
                                                    @endif
                                                </td>
                                                <td style="padding:10px 14px;"><span class="tag tag-grey">{{ $ipn['type'] ?: '—' }}</span></td>
                                                <td style="padding:10px 14px;">{{ $ipn['created'] ?: '—' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <p style="font-size:11.5px;color:var(--ink-soft);margin-top:8px;">
                                Only the entry tagged <b>Active</b> is the one currently stored as your Notification ID.
                            </p>
                        @endif
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setSettingsPane(pane) {
    document.querySelectorAll('.settings-nav button').forEach(b => b.classList.remove('active'));
    document.querySelector('.settings-nav button[onclick*="' + pane + '"]').classList.add('active');
    document.querySelectorAll('.settings-pane').forEach(p => p.style.display = 'none');
    document.getElementById('pane-' + pane).style.display = 'block';
}

function submitPaymentAction(url) {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    form.innerHTML = '<input type="hidden" name="_token" value="' + csrf + '">';
    document.body.appendChild(form);
    form.submit();
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-toggle]').forEach(function (btn) {
        btn.addEventListener('click', function () {
            this.classList.toggle('on');
            const hidden = document.querySelector('input[name="' + this.dataset.hiddenName + '"][type="hidden"]');
            if (hidden) hidden.value = this.classList.contains('on') ? '1' : '0';
        });
    });
});
</script>

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