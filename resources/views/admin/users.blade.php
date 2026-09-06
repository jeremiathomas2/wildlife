@extends('admin.layout')

@section('title', 'Admin Users')

@section('content')
@php
$canManage = $currentAdmin && $currentAdmin->canManageUsers();
$canDelete = $currentAdmin && $currentAdmin->canDeleteUsers();
$baseParams = array_filter(['q' => $filters['q'], 'role' => $filters['role']]);
$usersUrl = fn (array $extra = []) => route('admin.users', array_merge($baseParams, array_filter($extra)));
@endphp

<div class="view active">
    <div class="view-head">
        <div>
            <h2>Admin Users</h2>
            <p class="sub">Manage admin accounts, roles, access and login activity.</p>
        </div>
        <div class="view-actions">
            @if($canManage)
                <button class="btn btn-primary" onclick="openUserModal()">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width:16px;height:16px;">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <line x1="19" y1="8" x2="19" y2="14"></line>
                        <line x1="16" y1="11" x2="22" y2="11"></line>
                    </svg>
                    New user
                </button>
            @endif
        </div>
    </div>

    <div class="stat-grid" style="grid-template-columns:repeat(auto-fit,minmax(150px,1fr));margin-bottom:20px;">
        <div class="stat-card" style="--stat-tint:var(--coffee-100);--stat-fg:var(--coffee-700);">
            <div class="stat-value">{{ $stats['total'] }}</div>
            <div class="stat-label">Total users</div>
        </div>
        <div class="stat-card" style="--stat-tint:var(--acacia-100);--stat-fg:var(--acacia-600);">
            <div class="stat-value">{{ $stats['active'] }}</div>
            <div class="stat-label">Active</div>
        </div>
        <div class="stat-card" style="--stat-tint:var(--sand-200);--stat-fg:var(--ink-soft);">
            <div class="stat-value">{{ $stats['inactive'] }}</div>
            <div class="stat-label">Inactive</div>
        </div>
        <div class="stat-card" style="--stat-tint:var(--terracotta-100);--stat-fg:var(--terracotta-600);">
            <div class="stat-value">{{ $stats['roles']['super_admin'] ?? 0 }}</div>
            <div class="stat-label">Super admins</div>
        </div>
    </div>

    <div class="table-card">
        <form class="table-toolbar" method="GET" action="{{ route('admin.users') }}">
            <div class="chip-filters" id="userFilterChips">
                <a class="chip {{ $filters['status'] === '' ? 'active' : '' }}" href="{{ $usersUrl([]) }}">All</a>
                <a class="chip {{ $filters['status'] === 'active' ? 'active' : '' }}" href="{{ $usersUrl(['status' => 'active']) }}">Active</a>
                <a class="chip {{ $filters['status'] === 'inactive' ? 'active' : '' }}" href="{{ $usersUrl(['status' => 'inactive']) }}">Inactive</a>
            </div>
            <div class="table-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" value="{{ $filters['q'] }}" placeholder="Search name or email…">
            </div>
            <select name="role" onchange="this.form.submit()" style="min-width:150px;">
                <option value="">All roles</option>
                @foreach(\App\Models\AdminUser::ROLES as $role)
                    <option value="{{ $role }}" {{ $filters['role'] === $role ? 'selected' : '' }}>{{ \App\Models\AdminUser::ROLE_LABELS[$role] }}</option>
                @endforeach
            </select>
            @if($filters['q'] !== '' || $filters['role'] !== '' || $filters['status'] !== '')
                <a href="{{ route('admin.users') }}" class="btn btn-ghost btn-sm" title="Clear filters">✕</a>
            @endif
        </form>

        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Last login</th>
                        <th>Logins</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="usersBody">
                    @forelse($users as $user)
                    @php $isSelf = $currentAdmin && (int) $currentAdmin->id === (int) $user->id; @endphp
                    <tr>
                        <td>
                            <div class="cell-main">
                                <div class="thumb" style="display:flex;align-items:center;justify-content:center;background:var(--terracotta-100);color:var(--terracotta-600);font-weight:700;font-family:'Raleway',sans-serif;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="cell-title" style="display:flex;align-items:center;gap:7px;">
                                        <a href="{{ route('admin.users.show', $user->id) }}" style="text-decoration:none;color:inherit;">{{ $user->name }}</a>
                                        @if($isSelf)
                                            <span class="tag tag-gold">You</span>
                                        @endif
                                    </div>
                                    <div style="color:var(--ink-soft);font-size:12.5px;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><span class="tag {{ \App\Models\AdminUser::ROLE_TAGS[$user->role] ?? 'tag-grey' }}">{{ $user->roleLabel() }}</span></td>
                        <td>
                            @if($user->is_active)
                                <span class="tag tag-green">Active</span>
                            @else
                                <span class="tag tag-red">Inactive</span>
                            @endif
                        </td>
                        <td style="white-space:nowrap;color:var(--ink-soft);">{{ $user->created_at->format('M j, Y') }}</td>
                        <td style="white-space:nowrap;">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>
                        <td>{{ $user->successful_logins }}</td>
                        <td>
                            <div class="row-actions">
                                <a href="{{ route('admin.users.show', $user->id) }}" title="View">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z"></path>
                                        <circle cx="12" cy="12" r="3"></circle>
                                    </svg>
                                </a>
                                @if($canManage)
                                    <button onclick="openUserModal({{ $user->id }})" title="Edit">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                                        </svg>
                                    </button>
                                    @if(!$isSelf)
                                        <button {!! $user->is_active ? '' : 'class="warn"' !!} onclick="submitForm('/live/users/{{ $user->id }}/toggle')" title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                            @if($user->is_active)
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <path d="M4.9 4.9l14.2 14.2"></path>
                                                </svg>
                                            @else
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                                </svg>
                                            @endif
                                        </button>
                                        <button onclick="openResetModal({{ $user->id }}, '{{ addslashes($user->name) }}')" title="Reset password">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <rect x="3" y="11" width="18" height="11" rx="2"></rect>
                                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                                            </svg>
                                        </button>
                                    @endif
                                @endif
                                @if($canDelete && !$isSelf)
                                    <button class="danger" onclick="confirmDeleteUser({{ $user->id }}, '{{ addslashes($user->name) }}')" title="Delete">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                <h4>No users found</h4>
                                <p>Try a different filter or add a new user.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="table-pager">
            <span style="color:var(--ink-soft);font-size:12.5px;">Page {{ $users->currentPage() }} of {{ $users->lastPage() }} · {{ $users->total() }} users</span>
            <div class="pager-pages">
                @if($users->onFirstPage())
                    <span class="page">←</span>
                @else
                    <a href="{{ $users->previousPageUrl() }}">←</a>
                @endif
                @for($i = 1; $i <= $users->lastPage(); $i++)
                    @if($i == $users->currentPage())
                        <span class="page active">{{ $i }}</span>
                    @else
                        <a href="{{ $users->url($i) }}">{{ $i }}</a>
                    @endif
                @endfor
                @if($users->hasMorePages())
                    <a href="{{ $users->nextPageUrl() }}">→</a>
                @else
                    <span class="page">→</span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

@include('admin.partials.user-modals', [
    'usersDataArr' => $users->items(),
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