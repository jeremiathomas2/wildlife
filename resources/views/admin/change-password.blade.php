@extends('admin.layout')

@section('title', 'Change Password')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Change your password</h2>
            <p class="sub">{{ $currentAdmin ? 'You are signed in as ' . $currentAdmin->email : '' }}</p>
        </div>
    </div>

    <div style="max-width:520px;">
        <div class="settings-panel">
            <h3 style="font-size:16px;margin-bottom:6px;">Set a new password</h3>
            <p style="font-size:13px;color:var(--ink-soft);line-height:1.6;margin-bottom:18px;">
                Use at least 8 characters. Avoid reusing passwords you use elsewhere.
            </p>
            <form action="{{ route('admin.change-password.submit') }}" method="POST">
                @csrf
                <div class="field">
                    <label>New password</label>
                    <div class="pwd-wrap">
                        <input type="password" name="password" placeholder="Min. 8 characters" required minlength="8">
                        <button type="button" class="pwd-toggle" tabindex="-1" onclick="togglePwd(this)" title="Show / hide">👁</button>
                    </div>
                </div>
                <div class="field">
                    <label>Confirm password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password" required>
                </div>
                <div style="display:flex;gap:10px;margin-top:8px;">
                    <button type="submit" class="btn btn-primary">Update password</button>
                    @if(!$currentAdmin || !$currentAdmin->must_change_password)
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">Back to dashboard</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function togglePwd(btn) {
    const input = btn.parentElement.querySelector('input[type="password"], input[type="text"]');
    const reveal = input.type === 'password';
    input.type = reveal ? 'text' : 'password';
    btn.textContent = reveal ? '🙈' : '👁';
}
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
@if(session('info'))
<script>
    toast('{{ session('info') }}', 'error');
</script>
@endif
@endsection