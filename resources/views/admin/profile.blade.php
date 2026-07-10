@extends('admin.layout')

@section('title', 'My Profile')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>My Profile</h2>
            <p class="sub">Update your account information and password.</p>
        </div>
        <div class="view-actions">
            <button type="submit" form="profileForm" class="btn btn-primary">Save changes</button>
        </div>
    </div>

    <div class="panel-grid" style="grid-template-columns: 1fr;">
        <div class="panel">
            <div class="panel-head">
                <h3>Account Information</h3>
            </div>
            <form id="profileForm" action="{{ route('admin.profile.update') }}" method="POST" class="panel-body">
                @csrf
                @method('PUT')
                
                @if(session('success'))
                    <div class="alert" style="background:var(--acacia-100);color:var(--acacia-600);padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;display:flex;align-items:center;gap:10px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;">
                            <path d="M20 6 9 17l-5-5"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert" style="background:var(--danger-100);color:var(--danger);padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;display:flex;align-items:center;gap:10px;">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:20px;height:20px;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert" style="background:var(--danger-100);color:var(--danger);padding:12px 16px;border-radius:var(--radius-md);margin-bottom:16px;">
                        <ul style="margin:0;padding-left:20px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="field">
                    <label>Name</label>
                    <input type="text" name="name" value="{{ $currentUser->name }}" required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $currentUser->email }}" required readonly style="background:var(--sand-100);cursor:not-allowed;">
                    <small style="color:var(--ink-soft);font-size:12px;">Email cannot be changed</small>
                </div>

                <div style="margin-top:24px;padding-top:24px;border-top:1px solid var(--line);">
                    <h4 style="margin-bottom:16px;font-family:'Raleway',sans-serif;color:var(--coffee-900);">Change Password</h4>
                    <p style="color:var(--ink-soft);margin-bottom:16px;font-size:13px;">Leave blank to keep current password</p>
                    
                    <div class="field">
                        <label>Current Password</label>
                        <input type="password" name="current_password">
                    </div>

                    <div class="field">
                        <label>New Password</label>
                        <input type="password" name="new_password" minlength="6">
                    </div>

                    <div class="field">
                        <label>Confirm New Password</label>
                        <input type="password" name="new_password_confirmation" minlength="6">
                    </div>
                </div>
            </form>
        </div>
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
