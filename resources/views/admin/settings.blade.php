@extends('admin.layout')

@section('title', 'Settings')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Site Settings</h2>
            <p class="sub">Update business details, brand colors, and integrations.</p>
        </div>
        <div class="view-actions">
            <button type="submit" form="settingsForm" class="btn btn-primary">Save changes</button>
        </div>
    </div>

    <div class="settings-grid settings-grid-single">
        <div class="settings-panel">
            <form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="settings-pane active" id="pane-general">
                    <h3 style="font-size:17px;margin-bottom:18px;">General information</h3>
                    @foreach($contents->where('group', 'general') as $content)
                        <div class="field">
                            <label>{{ $content->label ?? $content->key }}</label>
                            @if($content->type === 'textarea')
                                <textarea name="content[{{ $content->key }}]" rows="3">{{ old('content.' . $content->key, $content->value) }}</textarea>
                            @elseif($content->type === 'select')
                                <select name="content[{{ $content->key }}]">
                                    @if($content->key === 'default_currency')
                                        <option {{ $content->value === 'USD ($)' ? 'selected' : '' }}>USD ($)</option>
                                        <option {{ $content->value === 'TZS (TSh)' ? 'selected' : '' }}>TZS (TSh)</option>
                                        <option {{ $content->value === 'EUR (€)' ? 'selected' : '' }}>EUR (€)</option>
                                    @elseif($content->key === 'timezone')
                                        <option {{ $content->value === 'Africa/Dar es Salaam (EAT)' ? 'selected' : '' }}>Africa/Dar es Salaam (EAT)</option>
                                        <option {{ $content->value === 'UTC' ? 'selected' : '' }}>UTC</option>
                                    @endif
                                </select>
                            @else
                                <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}">
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="settings-pane" id="pane-brand" style="display:none;">
                    <h3 style="font-size:17px;margin-bottom:6px;">Brand & Assets</h3>
                    <p class="field-hint" style="margin-bottom:16px;">These mirror the live site's safari palette — earthy tones with espresso, orange and acacia-green accents.</p>
                    <div class="color-swatch-row">
                        <div class="color-swatch">
                            <div class="swatch" style="background: #631e08;"></div>
                            <span class="swatch-label">Espresso</span>
                        </div>
                        <div class="color-swatch">
                            <div class="swatch" style="background: #ff9729;"></div>
                            <span class="swatch-label">Orange</span>
                        </div>
                        <div class="color-swatch">
                            <div class="swatch" style="background: #088529;"></div>
                            <span class="swatch-label">Acacia Green</span>
                        </div>
                        <div class="color-swatch">
                            <div class="swatch" style="background: #854208;"></div>
                            <span class="swatch-label">Brown</span>
                        </div>
                        <div class="color-swatch">
                            <div class="swatch" style="background: #f8f4f0;"></div>
                            <span class="swatch-label">Sand</span>
                        </div>
                    </div>
                    @foreach($contents->where('group', 'brand') as $content)
                        <div class="field" style="margin-top:22px;">
                            <label>{{ $content->label ?? $content->key }}</label>
                            @if($content->type === 'image')
                                <div class="space-y-2">
                                    @if($content->value)
                                        <img src="{{ $content->value }}" alt="{{ $content->label }}" style="width: 64px; height: 64px; object-fit: cover; border-radius: 8px; border: 1px solid var(--line);">
                                    @endif
                                    <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}" placeholder="Image URL">
                                </div>
                            @else
                                <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}">
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="settings-pane" id="pane-contact" style="display:none;">
                    <h3 style="font-size:17px;margin-bottom:6px;">Contact & Social</h3>
                    <p style="font-size:12.5px;color:var(--ink-soft);margin-bottom:6px;">Used across the site header, footer, contact page and booking confirmations.</p>

                    @php
                    $con = fn ($key) => $contents->firstWhere('key', $key);
                    $conVal = fn ($key) => $con($key) ? old('content.' . $key, $con($key)->value) : '';
                    @endphp

                    <div class="settings-section"><h4>Contact details</h4></div>
                    <div class="form-row">
                        <div class="field">
                            <label>{{ $con('contact_phone')->label ?? 'Phone Number' }}</label>
                            <div class="input-icon-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"></path>
                                </svg>
                                <input type="tel" name="content[contact_phone]" value="{{ $conVal('contact_phone') }}" placeholder="+255 ...">
                            </div>
                        </div>
                        <div class="field">
                            <label>{{ $con('contact_whatsapp')->label ?? 'WhatsApp Number' }}</label>
                            <div class="input-icon-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 11.5a8.38 8.38 0 0 1-8.5 8.5 8.5 8.5 0 0 1-3.8-.9L3 21l1.9-5.7A8.38 8.38 0 0 1 4 11.5 8.5 8.5 0 0 1 12.5 3a8.38 8.38 0 0 1 8.5 8.5Z"></path>
                                    <path d="M8.5 9.5c0 4.5 2.5 7 7 7"></path>
                                </svg>
                                <input type="tel" name="content[contact_whatsapp]" value="{{ $conVal('contact_whatsapp') }}" placeholder="+255 ...">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="field">
                            <label>{{ $con('contact_email')->label ?? 'Email Address' }}</label>
                            <div class="input-icon-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="2" y="4" width="20" height="16" rx="2"></rect>
                                    <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                </svg>
                                <input type="email" name="content[contact_email]" value="{{ $conVal('contact_email') }}" placeholder="info@example.com">
                            </div>
                        </div>
                        <div class="field">
                            <label>{{ $con('contact_location')->label ?? 'Location' }}</label>
                            <div class="input-icon-wrap">
                                <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <input type="text" name="content[contact_location]" value="{{ $conVal('contact_location') }}" placeholder="City, Country">
                            </div>
                        </div>
                    </div>

                    <div class="settings-section"><h4>Social media</h4></div>
                    <div class="field">
                        <label>{{ $con('social_instagram')->label ?? 'Instagram URL' }}</label>
                        <div class="input-icon-wrap">
                            <svg class="input-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="2" y="2" width="20" height="20" rx="5"></rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37Z"></path>
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                            </svg>
                            <input type="url" name="content[social_instagram]" value="{{ $conVal('social_instagram') }}" placeholder="https://instagram.com/yourpage">
                        </div>
                        <p class="field-hint">Shown in the footer and contact page.</p>
                    </div>

                    <div class="settings-section"><h4>Contact page content</h4></div>
                    <div style="font-size:12.5px;color:var(--ink-soft);margin-bottom:14px;">Headline, subtitle and description displayed on the public contact page.</div>
                    <div class="form-row">
                        <div class="field">
                            <label>{{ $con('contact_page_title')->label ?? 'Contact Page Title' }}</label>
                            <input type="text" name="content[contact_page_title]" value="{{ $conVal('contact_page_title') }}">
                        </div>
                        <div class="field">
                            <label>{{ $con('contact_subtitle')->label ?? 'Contact Subtitle' }}</label>
                            <input type="text" name="content[contact_subtitle]" value="{{ $conVal('contact_subtitle') }}">
                        </div>
                    </div>
                    <div class="field">
                        <label>{{ $con('contact_description')->label ?? 'Contact Description' }}</label>
                        <textarea name="content[contact_description]" rows="4" placeholder="A short description shown on the contact page">{{ $conVal('contact_description') }}</textarea>
                    </div>
                </div>

                <div class="settings-pane" id="pane-notifications" style="display:none;">
                    <h3 style="font-size:17px;margin-bottom:6px;">Notification preferences</h3>
                    @foreach($contents->where('group', 'notifications') as $content)
                        <div class="toggle-row">
                            <div class="toggle-text">
                                <strong>{{ $content->label ?? $content->key }}</strong>
                                <span>{{ $content->value ?? 'Enable this notification' }}</span>
                            </div>
                            <input type="hidden" name="content[{{ $content->key }}]" value="0">
                            <button type="button" class="switch {{ $content->value === '1' || $content->value === 'true' ? 'on' : '' }}" onclick="this.classList.toggle('on'); this.previousElementSibling.value = this.classList.contains('on') ? '1' : '0'"></button>
                        </div>
                    @endforeach
                </div>
            </form>

            <div style="border-top:1px solid var(--line);margin:26px -26px 0;"></div>

            <form id="paymentSettingsForm" action="{{ route('admin.payments.settings.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="settings-pane" id="pane-payments" style="display:none;padding-top:26px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;gap:12px;flex-wrap:wrap;">
                        <div>
                            <h3 style="font-size:17px;">Payment Integration</h3>
                            <p style="font-size:12.5px;color:var(--ink-soft);margin-top:3px;">PesaPal credentials, environment and charging rules. Credentials are stored encrypted.</p>
                        </div>
                        <a href="{{ route('admin.payments.settings') }}" style="font-size:12.5px;font-weight:700;color:var(--terracotta-600);">Manage full payment settings →</a>
                    </div>

                    <div class="toggle-row">
                        <div class="toggle-text">
                            <strong>Online payments enabled</strong>
                            <span>Redirect customers to PesaPal checkout after booking</span>
                        </div>
                        <input type="hidden" name="payment_enabled" value="0">
                        <button type="button" class="switch {{ ($settings['payment_enabled'] ?? '0') === '1' ? 'on' : '' }}" onclick="this.classList.toggle('on'); this.previousElementSibling.value = this.classList.contains('on') ? '1' : '0'"></button>
                    </div>

                    <div class="field" style="margin-top:18px;">
                        <label>Environment</label>
                        <select name="pesapal_environment">
                            <option value="sandbox" {{ $settings['pesapal_environment'] === 'sandbox' ? 'selected' : '' }}>Sandbox (test)</option>
                            <option value="live" {{ $settings['pesapal_environment'] === 'live' ? 'selected' : '' }}>Live (production)</option>
                        </select>
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

                    <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:6px;">
                        <button type="submit" class="btn btn-primary btn-sm">Save payment settings</button>
                        <button type="button" onclick="submitPaymentAction('{{ route('admin.payments.settings.test') }}')" class="btn btn-soft btn-sm">Test connection</button>
                        <button type="button" onclick="submitPaymentAction('{{ route('admin.payments.settings.ipn') }}')" class="btn btn-soft btn-sm">Register IPN URL</button>
                    </div>
                </div>
            </form>

            <div style="border-top:1px solid var(--line);margin:26px -26px 0;"></div>

            <form id="mailSettingsForm" action="{{ route('admin.settings.mail.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="settings-pane" id="pane-mail" style="display:none;padding-top:26px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;gap:12px;flex-wrap:wrap;">
                        <div>
                            <h3 style="font-size:17px;">Mail Settings</h3>
                            <p style="font-size:12.5px;color:var(--ink-soft);margin-top:3px;">SMTP credentials used to send booking confirmations, payment and notification emails.</p>
                        </div>
                        @if($mailPasswordStored)
                            <span class="tag tag-green">SMTP password saved</span>
                        @endif
                    </div>

                    <div class="form-row">
                        <div class="field" style="flex:1.6;">
                            <label>SMTP host</label>
                            <input type="text" name="mail_smtp_host" value="{{ old('mail_smtp_host', $mailSettings['mail_smtp_host']) }}" placeholder="smtp.gmail.com" required>
                        </div>
                        <div class="field" style="flex:0.7;">
                            <label>Port</label>
                            <input type="number" name="mail_smtp_port" value="{{ old('mail_smtp_port', $mailSettings['mail_smtp_port']) }}" min="1" max="65535" required>
                        </div>
                        <div class="field" style="flex:0.8;">
                            <label>Encryption</label>
                            <select name="mail_smtp_encryption">
                                <option value="tls" {{ $mailSettings['mail_smtp_encryption'] === 'tls' ? 'selected' : '' }}>TLS</option>
                                <option value="ssl" {{ $mailSettings['mail_smtp_encryption'] === 'ssl' ? 'selected' : '' }}>SSL</option>
                                <option value="none" {{ $mailSettings['mail_smtp_encryption'] === 'none' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label>SMTP username</label>
                        <input type="text" name="mail_smtp_username" value="{{ old('mail_smtp_username', $mailSettings['mail_smtp_username']) }}" placeholder="you@example.com" required>
                    </div>

                    <div class="field">
                        <label>App password</label>
                        <input type="password" name="mail_smtp_password" autocomplete="new-password" placeholder="{{ $mailPasswordStored ? '•••••••• (saved — leave blank to keep)' : 'Your SMTP app password' }}">
                        <p class="field-hint">For Gmail, generate an App Password (not your normal sign-in password). Stored encrypted.</p>
                    </div>

                    <div class="form-row">
                        <div class="field">
                            <label>From name</label>
                            <input type="text" name="mail_from_name" value="{{ old('mail_from_name', $mailSettings['mail_from_name']) }}" required>
                        </div>
                        <div class="field">
                            <label>From email</label>
                            <input type="email" name="mail_from_address" value="{{ old('mail_from_address', $mailSettings['mail_from_address']) }}" required>
                        </div>
                    </div>

<div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:6px;">
                        <button type="submit" class="btn btn-primary btn-sm">Save mail settings</button>
                    </div>
                </div>
            </form>

            <form action="{{ route('admin.settings.mail.test') }}" method="POST">
                @csrf
                <div class="settings-pane" id="pane-mail-test" style="display:none;padding-top:24px;">
                    <div style="border-top:1px solid var(--line);margin:0 -26px;padding:20px 26px 0;"></div>
                    <h3 style="font-size:15px;margin-bottom:10px;">Send test email</h3>
                    <p style="font-size:12.5px;color:var(--ink-soft);margin-bottom:14px;">Send a test email using the saved settings to confirm everything works.</p>
                    <div style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
                        <div class="field" style="margin-bottom:0;">
                            <label>Send to</label>
                            <input type="email" name="to" value="{{ old('to') }}" placeholder="recipient@example.com">
                        </div>
                        <button type="submit" class="btn btn-soft btn-sm">Send test email</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const SETTINGS_PANES = ['general', 'brand', 'contact', 'notifications', 'payments', 'mail'];

function setSettingsPane(pane) {
    document.querySelectorAll('.settings-pane').forEach(p => p.style.display = 'none');
    const mailPanes = ['mail', 'mail-test'];
    if (mailPanes.includes(pane)) {
        mailPanes.forEach(id => {
            const el = document.getElementById('pane-' + id);
            if (el) el.style.display = 'block';
        });
        return;
    }
    document.getElementById('pane-' + pane).style.display = 'block';
}

(function initPaneFromQuery() {
    const pane = new URLSearchParams(location.search).get('pane');
    if (pane && SETTINGS_PANES.includes(pane)) {
        setSettingsPane(pane);
    }
})();

function submitPaymentAction(url) {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    form.innerHTML = '<input type="hidden" name="_token" value="' + csrf + '">';
    document.body.appendChild(form);
    form.submit();
}
</script>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif
@endsection
