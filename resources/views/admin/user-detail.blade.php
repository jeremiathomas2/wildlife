@extends('admin.layout')

@section('title', $user->name . ' — Admin User')

@section('content')
@php
$canManage = $currentAdmin && $currentAdmin->canManageUsers();
$canDelete = $currentAdmin && $currentAdmin->canDeleteUsers();
$actionLabels = [
    'user.created' => 'Created user account',
    'user.updated' => 'Updated user account',
    'user.deleted' => 'Deleted user account',
    'user.toggled' => 'Changed activation status',
    'user.password_reset' => 'Reset user password',
    'auth.password_changed' => 'Changed own password',
];
@endphp

<div class="view active">
    <div class="view-head">
        <div style="display:flex;gap:14px;align-items:center;">
            <div class="thumb" style="display:flex;align-items:center;justify-content:center;background:var(--terracotta-100);color:var(--terracotta-600);font-weight:700;font-family:'Raleway',sans-serif;width:52px;height:52px;font-size:20px;border-radius:14px;">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 style="display:flex;align-items:center;gap:8px;">
                    {{ $user->name }}
                    @if($isSelf)
                        <span class="tag tag-gold">You</span>
                    @endif
                    @if($user->must_change_password)
                        <span class="tag tag-red">Must change password</span>
                    @endif
                </h2>
                <p class="sub">{{ $user->email }}</p>
            </div>
        </div>
        <div class="view-actions" style="gap:8px;">
            <a href="{{ route('admin.users') }}" class="btn btn-ghost">← Users</a>
            @if($canManage)
                <button class="btn btn-primary" onclick="openUserModal({{ $user->id }})">Edit user</button>
                @if(!$isSelf)
                    <button class="btn btn-soft" onclick="submitForm('/live/users/{{ $user->id }}/toggle')">{{ $user->is_active ? 'Deactivate' : 'Activate' }}</button>
                    <button class="btn btn-soft" onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}')">Reset password</button>
                @endif
            @endif
            @if($canDelete && !$isSelf)
                <button class="btn btn-danger" onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')">Delete</button>
            @endif
        </div>
    </div>

    <div class="stat-grid" style="grid-template-columns:repeat(auto-fit,minmax(160px,1fr));margin-bottom:20px;">
        <div class="stat-card" style="--stat-tint:var(--terracotta-100);--stat-fg:var(--terracotta-600);">
            <div class="stat-label" style="margin-bottom:6px;">Role</div>
            <div style="font-size:15px;font-weight:700;"><span class="tag {{ \App\Models\AdminUser::ROLE_TAGS[$user->role] ?? 'tag-grey' }}">{{ $user->roleLabel() }}</span></div>
        </div>
        <div class="stat-card" style="--stat-tint:var(--green-100,var(--acacia-100));--stat-fg:var(--acacia-600);">
            <div class="stat-label" style="margin-bottom:6px;">Status</div>
            <div style="font-size:15px;font-weight:700;">{!! $user->is_active ? '<span class="tag tag-green">Active</span>' : '<span class="tag tag-red">Inactive</span>' !!}</div>
        </div>
        <div class="stat-card" style="--stat-tint:var(--sand-200);--stat-fg:var(--ink-soft);">
            <div class="stat-label" style="margin-bottom:6px;">Created</div>
            <div style="font-size:15px;font-weight:700;">{{ $user->created_at->format('M j, Y') }}</div>
        </div>
        <div class="stat-card" style="--stat-tint:var(--gold-100);--stat-fg:#8a6418;">
            <div class="stat-label" style="margin-bottom:6px;">Last login</div>
            <div style="font-size:15px;font-weight:700;">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</div>
        </div>
        <div class="stat-card" style="--stat-tint:var(--acacia-100);--stat-fg:var(--acacia-600);">
            <div class="stat-value">{{ $loginCount }}</div>
            <div class="stat-label">Successful logins</div>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start;">
        <div class="table-card" style="min-width:0;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong style="font-size:14px;">Login history</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Last 20 attempts</span>
            </div>
            @if($loginLogs->isEmpty())
                <div class="empty-state" style="padding:30px 20px;">
                    <h4 style="margin-bottom:4px;">No login attempts</h4>
                    <p>This user has no recorded logins yet.</p>
                </div>
            @else
            <div class="table-scroll">
                <table style="min-width:0;">
                    <thead>
                        <tr>
                            <th>When</th>
                            <th>IP address</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loginLogs as $log)
                        <tr>
                            <td style="white-space:nowrap;" title="{{ $log->created_at->format('M j, Y H:i') }}">{{ $log->created_at->diffForHumans() }}</td>
                            <td style="font-family:monospace;font-size:12.5px;">{{ $log->ip_address ?: '—' }}</td>
                            <td>
                                @if($log->success)
                                    <span class="tag tag-green">Success</span>
                                @else
                                    <span class="tag tag-red">Failed</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        <div class="table-card" style="min-width:0;">
            <div class="table-toolbar" style="border-bottom:1px solid var(--line);">
                <strong style="font-size:14px;">Account activity</strong>
                <span style="color:var(--ink-soft);font-size:12.5px;">Last 25 events</span>
            </div>
            @if($recentActivity->isEmpty())
                <div class="empty-state" style="padding:30px 20px;">
                    <h4 style="margin-bottom:4px;">No activity</h4>
                    <p>User actions will appear here once they start working.</p>
                </div>
            @else
            <div class="table-scroll">
                <table style="min-width:0;">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>When</th>
                            <th>Origin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentActivity as $log)
                        <tr>
                            <td>
                                <span class="tag tag-gold">{{ $actionLabels[$log->action] ?? ucwords(str_replace('_', ' ', $log->action)) }}</span>
                                @if(!empty($log->details['changes']['role']))
                                    <div style="font-size:11.5px;color:var(--ink-soft);margin-top:3px;">
                                        Role: {{ ucwords(str_replace('_', ' ', $log->details['changes']['role']['from'])) }} → {{ ucwords(str_replace('_', ' ', $log->details['changes']['role']['to'])) }}
                                    </div>
                                @endif
                            </td>
                            <td style="white-space:nowrap;" title="{{ $log->created_at->format('M j, Y H:i') }}">{{ $log->created_at->diffForHumans() }}</td>
                            <td style="font-family:monospace;font-size:12px;color:var(--ink-soft);">{{ $log->ip_address ?: '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</div>

@include('admin.partials.user-modals', [
    'usersDataArr' => [$user],
    'currentUserId' => $currentAdmin ? $currentAdmin->id : 0,
    'canManageUsers' => $canManage,
    'canDeleteUsers' => $canDelete,
])

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