@extends('admin.layout')

@section('title', 'Admin Users')

@section('content')
<div class="view active">
    <div class="view-head">
        <div>
            <h2>Admin Users</h2>
            <p class="sub">Manage admin user accounts and access.</p>
        </div>
        <div class="view-actions">
            <button class="btn btn-primary" onclick="openUserModal()">+ New user</button>
        </div>
    </div>

    <div class="table-card">
        <div class="table-toolbar">
            <div class="chip-filters" id="userFilterChips">
                <button class="chip active" data-filter="all" onclick="setUserFilter('all')">All</button>
                <button class="chip" data-filter="active" onclick="setUserFilter('active')">Active</button>
                <button class="chip" data-filter="inactive" onclick="setUserFilter('inactive')">Inactive</button>
            </div>
            <div class="table-search">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" placeholder="Search name or email…" oninput="filterUsers(this.value)">
            </div>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Last login</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="usersBody">
                    @if($users->isEmpty())
                    <tr>
                        <td colspan="5">
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
                    @else
                    @foreach($users as $user)
                    <tr data-id="{{ $user->id }}" data-status="{{ $user->is_active ? 'active' : 'inactive' }}" data-search="{{ strtolower($user->name.' '.$user->email) }}">
                        <td>
                            <div class="cell-main">
                                <div class="thumb" style="display:flex;align-items:center;justify-content:center;background:var(--terracotta-100);color:var(--terracotta-600);font-weight:700;font-family:'Fraunces',serif;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="cell-title">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->is_active)
                                <span class="tag tag-green">Active</span>
                            @else
                                <span class="tag tag-red">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}</td>
                        <td>
                            <div class="row-actions">
                                <button onclick="editUser({{ $user->id }})" title="Edit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L12 15l-4 1 1-4Z"></path>
                                    </svg>
                                </button>
                                <button class="danger" onclick="confirmDeleteUser({{ $user->id }}, '{{ $user->name }}')" title="Delete">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal-backdrop" id="userModalBackdrop">
    <div class="modal">
        <div class="modal-head">
            <h3 id="userModalTitle">New user</h3>
            <button class="modal-close" onclick="closeModal('userModalBackdrop')">✕</button>
        </div>
        <form id="userForm" action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <input type="hidden" id="userId" name="id">
            <input type="hidden" id="userMethod" name="_method" value="">
            <div class="modal-body">
                <div class="field">
                    <label>Name</label>
                    <input type="text" id="userName" name="name" placeholder="e.g. Jane Doe" required>
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" id="userEmail" name="email" placeholder="jane@example.com" required>
                </div>
                <div class="field">
                    <label>Password</label>
                    <input type="password" id="userPassword" name="password" placeholder="••••••••">
                </div>
                <div class="field">
                    <label>
                        <input type="checkbox" id="userActive" name="is_active" value="1" checked>
                        <span>Active</span>
                    </label>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('userModalBackdrop')">Cancel</button>
                <button type="submit" class="btn btn-primary">Save user</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-backdrop" id="confirmModalBackdrop">
    <div class="modal" style="max-width:400px;">
        <div class="modal-head">
            <h3>Delete user?</h3>
            <button class="modal-close" onclick="closeModal('confirmModalBackdrop')">✕</button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px;color:var(--ink-soft);line-height:1.6;" id="confirmText">This action cannot be undone.</p>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeModal('confirmModalBackdrop')">Cancel</button>
            <button class="btn btn-danger" id="confirmDeleteBtn" onclick="executeDelete()">Delete</button>
        </div>
    </div>
</div>

<script>
const usersData = @json($users->items());
let currentUserFilter = 'all';
let currentUserSearch = '';
let pendingDeleteFunc = null;

function setUserFilter(filter) {
    currentUserFilter = filter;
    document.querySelectorAll('#userFilterChips .chip').forEach(c => c.classList.toggle('active', c.dataset.filter === filter));
    renderFilteredUsers();
}

function filterUsers(search) {
    currentUserSearch = search.toLowerCase();
    renderFilteredUsers();
}

function renderFilteredUsers() {
    document.querySelectorAll('#usersBody tr').forEach(tr => {
        if (!tr.dataset.id) return;
        let match = true;
        if (currentUserFilter !== 'all') {
            match = tr.dataset.status === currentUserFilter;
        }
        if (currentUserSearch) {
            match = match && tr.dataset.search.includes(currentUserSearch);
        }
        tr.style.display = match ? 'table-row' : 'none';
    });
}

function openUserModal(id = null) {
    const title = document.getElementById('userModalTitle');
    title.textContent = id ? 'Edit user' : 'New user';
    const form = document.getElementById('userForm');
    const passwordField = document.getElementById('userPassword');
    if (id) {
        const user = usersData.find(u => u.id === id);
        if (!user) return;
        form.action = "/live/users/" + id;
        document.getElementById('userMethod').value = 'PUT';
        document.getElementById('userId').value = user.id;
        document.getElementById('userName').value = user.name;
        document.getElementById('userEmail').value = user.email;
        passwordField.placeholder = '•••••••• (leave blank to keep current)';
        passwordField.required = false;
        document.getElementById('userActive').checked = user.is_active;
    } else {
        form.action = "{{ route('admin.users.store') }}";
        document.getElementById('userMethod').value = '';
        document.getElementById('userId').value = '';
        document.getElementById('userName').value = '';
        document.getElementById('userEmail').value = '';
        passwordField.placeholder = '••••••••';
        passwordField.required = true;
        document.getElementById('userActive').checked = true;
    }
    openModal('userModalBackdrop');
}

function editUser(id) {
    openUserModal(id);
}

function confirmDeleteUser(id, name) {
    document.getElementById('confirmText').textContent = 'Delete "' + name + '"?';
    pendingDeleteFunc = () => {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = "/live/users/" + id;
        form.innerHTML = '@csrf @method("DELETE")';
        document.body.appendChild(form);
        form.submit();
    };
    openModal('confirmModalBackdrop');
}

function executeDelete() {
    if (pendingDeleteFunc) pendingDeleteFunc();
    closeModal('confirmModalBackdrop');
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
@endsection
