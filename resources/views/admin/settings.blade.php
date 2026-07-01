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

    <div class="settings-grid">
        <div class="settings-nav">
            <button class="active" data-pane="general" onclick="setSettingsPane('general')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="18" height="18" rx="2"></rect>
                    <rect x="9" y="9" width="6" height="6"></rect>
                </svg>
                General
            </button>
            <button data-pane="brand" onclick="setSettingsPane('brand')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="13.5" cy="6.5" r=".5"></circle>
                    <circle cx="17.5" cy="10.5" r=".5"></circle>
                    <circle cx="8.5" cy="7.5" r=".5"></circle>
                    <circle cx="6.5" cy="12.5" r=".5"></circle>
                    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C22 6.012 17.461 2 12 2Z"></path>
                </svg>
                Brand & Colors
            </button>
            <button data-pane="contact" onclick="setSettingsPane('contact')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92Z"></path>
                </svg>
                Contact & Social
            </button>
            <button data-pane="notifications" onclick="setSettingsPane('notifications')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                    <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                </svg>
                Notifications
            </button>
            <button data-pane="users" onclick="setSettingsPane('users')">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                Admin Users
            </button>
        </div>

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
                    <p class="field-hint" style="margin-bottom:16px;">These mirror the live site's safari palette — sandy neutrals with terracotta, gold and acacia-green accents.</p>
                    <div class="color-swatch-row">
                        <div class="color-swatch">
                            <div class="swatch" style="background: #C2592B;"></div>
                            <span class="swatch-label">Terracotta</span>
                        </div>
                        <div class="color-swatch">
                            <div class="swatch" style="background: #2A1B10;"></div>
                            <span class="swatch-label">Coffee</span>
                        </div>
                        <div class="color-swatch">
                            <div class="swatch" style="background: #D4A24C;"></div>
                            <span class="swatch-label">Savanna Gold</span>
                        </div>
                        <div class="color-swatch">
                            <div class="swatch" style="background: #7A8450;"></div>
                            <span class="swatch-label">Acacia Green</span>
                        </div>
                        <div class="color-swatch">
                            <div class="swatch" style="background: #FBF7EF;"></div>
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
                    <h3 style="font-size:17px;margin-bottom:18px;">Contact & Social</h3>
                    @foreach($contents->where('group', 'contact') as $content)
                        <div class="field">
                            <label>{{ $content->label ?? $content->key }}</label>
                            @if($content->type === 'email')
                                <input type="email" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}">
                            @else
                                <input type="text" name="content[{{ $content->key }}]" value="{{ old('content.' . $content->key, $content->value) }}">
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="settings-pane" id="pane-notifications" style="display:none;">
                    <h3 style="font-size:17px;margin-bottom:6px;">Notification preferences</h3>
                    @foreach($contents->where('group', 'notifications') as $content)
                        <div class="toggle-row">
                            <div class="toggle-text">
                                <strong>{{ $content->label ?? $content->key }}</strong>
                                <span>{{ $content->value ?? 'Enable this notification' }}</span>
                            </div>
                            <button type="button" class="switch {{ $content->value === '1' || $content->value === 'true' ? 'on' : '' }}" onclick="this.classList.toggle('on')"></button>
                        </div>
                    @endforeach
                </div>

                <div class="settings-pane" id="pane-users" style="display:none;">
                    <h3 style="font-size:17px;margin-bottom:18px;">Admin Users</h3>
                    <p style="color:var(--ink-soft);font-size:13.5px;margin-bottom:16px;">User management is not yet implemented. Contact your system administrator to add or remove users.</p>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setSettingsPane(pane) {
    document.querySelectorAll('.settings-nav button').forEach(b => b.classList.remove('active'));
    document.querySelector('.settings-nav button[data-pane="'+pane+'"]').classList.add('active');
    document.querySelectorAll('.settings-pane').forEach(p => p.style.display = 'none');
    document.getElementById('pane-'+pane).style.display = 'block';
}
</script>

@if(session('success'))
<script>
    toast('{{ session('success') }}', 'success');
</script>
@endif
@endsection
