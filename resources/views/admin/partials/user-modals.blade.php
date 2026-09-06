{{-- Shared admin-user modals (create/edit, reset password, type-to-confirm delete) --}}
@php
$safeUsers = array_map(fn ($u) => [
    'id' => (int) $u->id,
    'name' => $u->name,
    'email' => $u->email,
    'role' => $u->role,
    'is_active' => (bool) $u->is_active,
], $usersDataArr);
$canManageU = $canManageUsers ?? false;
$canDeleteU = $canDeleteUsers ?? false;
$currentUId = $currentUserId ?? 0;
@endphp

<!-- Create / Edit user -->
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
                <div class="form-row" style="align-items:flex-end;">
                    <div class="field" style="flex:1;">
                        <label>Role</label>
                        <select id="userRole" name="role">
                            @foreach(\App\Models\AdminUser::ROLES as $role)
                                <option value="{{ $role }}">{{ \App\Models\AdminUser::ROLE_LABELS[$role] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field" style="margin-bottom:16px;">
                        <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;text-transform:none;font-weight:600;">
                            <input type="checkbox" id="userActive" name="is_active" value="1" checked style="width:auto;">
                            <span>Active</span>
                        </label>
                    </div>
                </div>
                <div class="field">
                    <label>Password</label>
                    <div class="pwd-wrap">
                        <input type="password" id="userPassword" name="password" placeholder="•••••••• (min. 8 chars)">
                        <button type="button" class="pwd-toggle" tabindex="-1" onclick="togglePwd(this)" title="Show / hide">👁</button>
                    </div>
                </div>
                <div class="field">
                    <label>Confirm password</label>
                    <input type="password" id="userPasswordConfirm" name="password_confirmation" placeholder="Repeat password">
                </div>
                <div class="field" id="forceChangeField" style="display:none;">
                    <label style="display:inline-flex;align-items:center;gap:8px;cursor:pointer;text-transform:none;font-weight:600;">
                        <input type="checkbox" id="userForceChange" name="must_change_password" value="1" style="width:auto;">
                        <span>Force password change on next login</span>
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

<!-- Reset password -->
<div class="modal-backdrop" id="resetModalBackdrop">
    <div class="modal" style="max-width:430px;">
        <div class="modal-head">
            <h3>Reset password</h3>
            <button class="modal-close" onclick="closeModal('resetModalBackdrop')">✕</button>
        </div>
        <form id="resetForm" method="POST">
            @csrf
            <div class="modal-body">
                <p style="font-size:13.5px;color:var(--ink-soft);line-height:1.6;margin-bottom:14px;" id="resetIntro">Set a temporary password for this user. They must change it on next login.</p>
                <div class="field">
                    <label>New password</label>
                    <div class="pwd-wrap">
                        <input type="password" id="resetPassword" name="password" placeholder="Min. 8 characters" required>
                        <button type="button" class="pwd-toggle" tabindex="-1" onclick="togglePwd(this)" title="Show / hide">👁</button>
                    </div>
                </div>
                <div class="field">
                    <label>Confirm password</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat password" required>
                </div>
            </div>
            <div class="modal-foot">
                <button type="button" class="btn btn-ghost" onclick="closeModal('resetModalBackdrop')">Cancel</button>
                <button type="submit" class="btn btn-primary">Reset password</button>
            </div>
        </form>
    </div>
</div>

<!-- Type-to-confirm delete -->
<div class="modal-backdrop" id="confirmModalBackdrop">
    <div class="modal" style="max-width:420px;">
        <div class="modal-head">
            <h3 style="color:var(--danger);">Delete user?</h3>
            <button class="modal-close" onclick="closeModal('confirmModalBackdrop')">✕</button>
        </div>
        <div class="modal-body">
            <p style="font-size:14px;color:var(--ink-soft);line-height:1.7;" id="confirmText">This action cannot be undone.</p>
            <div class="field" style="margin-top:14px;">
                <label>Type <strong style="letter-spacing:1px;">DELETE</strong> to confirm</label>
                <input type="text" id="confirmTyped" placeholder="DELETE" oninput="document.getElementById('confirmDeleteBtn').disabled = this.value.trim() !== 'DELETE'">
            </div>
        </div>
        <div class="modal-foot">
            <button class="btn btn-ghost" onclick="closeModal('confirmModalBackdrop')">Cancel</button>
            <button class="btn btn-danger" id="confirmDeleteBtn" onclick="executeDelete()" disabled>Delete user</button>
        </div>
    </div>
</div>

<script>
const usersData = @json($safeUsers);
const currentUserId = {{ $currentUId }};
const canManageUsersFlag = {{ $canManageU ? 'true' : 'false' }};
let pendingDeleteFunc = null;
let currentUserModalId = null;

function openUserModal(id = null) {
    if (!canManageUsersFlag) return;
    currentUserModalId = id;
    const isEdit = id !== null;
    const title = document.getElementById('userModalTitle');
    const form = document.getElementById('userForm');
    const passwordField = document.getElementById('userPassword');
    document.getElementById('forceChangeField').style.display = isEdit && id !== currentUserId ? 'block' : 'none';

    if (isEdit) {
        const user = usersData.find(u => u.id === id);
        if (!user) return;
        form.action = "/live/users/" + id;
        document.getElementById('userMethod').value = 'PUT';
        document.getElementById('userId').value = user.id;
        document.getElementById('userName').value = user.name;
        document.getElementById('userEmail').value = user.email;
        document.getElementById('userRole').value = user.role;
        passwordField.placeholder = '•••••••• (leave blank to keep current)';
        passwordField.required = false;
        document.getElementById('userPassword').value = '';
        document.getElementById('userPasswordConfirm').value = '';
        document.getElementById('userActive').checked = user.is_active;
        document.getElementById('userForceChange').checked = false;
        document.getElementById('userRole').disabled = id === currentUserId;
    } else {
        form.action = "{{ route('admin.users.store') }}";
        document.getElementById('userMethod').value = '';
        document.getElementById('userId').value = '';
        document.getElementById('userName').value = '';
        document.getElementById('userEmail').value = '';
        document.getElementById('userRole').value = 'admin';
        document.getElementById('userRole').disabled = false;
        passwordField.placeholder = '•••••••• (min. 8 characters)';
        passwordField.required = true;
        document.getElementById('userPassword').value = '';
        document.getElementById('userPasswordConfirm').value = '';
        document.getElementById('userActive').checked = true;
        document.getElementById('userForceChange').checked = false;
    }
    openModal('userModalBackdrop');
}

function openResetModal(id, name) {
    document.getElementById('resetIntro').textContent = 'Set a temporary password for ' + name + '. They must change it on next login.';
    document.getElementById('resetForm').action = "/live/users/" + id + "/reset-password";
    document.getElementById('resetPassword').value = '';
    document.querySelector('#resetForm input[name="password_confirmation"]').value = '';
    openModal('resetModalBackdrop');
}

function confirmDeleteUser(id, name) {
    document.getElementById('confirmText').textContent = 'Delete "' + name + '"? Their login and activity history will also be removed. This cannot be undone.';
    document.getElementById('confirmTyped').value = '';
    document.getElementById('confirmDeleteBtn').disabled = true;
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
}

function togglePwd(btn) {
    const input = btn.parentElement.querySelector('input[type="password"], input[type="text"]');
    const reveal = input.type === 'password';
    input.type = reveal ? 'text' : 'password';
    btn.textContent = reveal ? '🙈' : '👁';
}

function submitForm(url) {
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = url;
    form.innerHTML = '<input type="hidden" name="_token" value="' + csrf + '">';
    document.body.appendChild(form);
    form.submit();
}

document.getElementById('userForm').addEventListener('submit', function (e) {
    const pwd = document.getElementById('userPassword');
    const confirm = document.getElementById('userPasswordConfirm');
    if (currentUserModalId === null && pwd.value.length < 8) {
        e.preventDefault();
        toast('Password must be at least 8 characters.', 'error');
        return;
    }
    if (pwd.value && pwd.value !== confirm.value) {
        e.preventDefault();
        toast('Passwords do not match.', 'error');
        return;
    }
});
</script>