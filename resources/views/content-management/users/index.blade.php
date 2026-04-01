<div class="admin-livewire-page d-flex w-100 align-items-stretch">
@include('content-management.includes.sidebar')
<div class="content">
    @include('admin.includes.navbar')

    <div class="container-fluid pt-4 px-4">
        <div class="bg-light rounded h-100 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="mb-0">System Users Management</h4>
                    <small class="text-muted">Assign <strong>Admin</strong> (content only) or <strong>Normal User</strong> (no admin). Super Admin accounts are created via seeding only.</small>
                </div>
                <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#userModal" onclick="resetForm()">
                    <i class="fa fa-plus me-2"></i>Add New User
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Email Verified</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role)
                                    <span class="badge bg-info">{{ $user->role->name }}</span>
                                @else
                                    <span class="badge bg-secondary">No Role Assigned</span>
                                @endif
                            </td>
                            <td>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning">Not Verified</span>
                                @endif
                            </td>
                            <td><span class="badge bg-{{ $user->status == 'Active' ? 'success' : 'danger' }}">{{ $user->status }}</span></td>
                            <td>
                                <div class="btn-group" role="group">
                                    @if(!$user->email_verified_at)
                                    <button class="btn btn-sm btn-success" onclick="verifyEmail({{ $user->id }})" title="Verify Email">
                                        <i class="fa fa-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info" onclick="resendVerification({{ $user->id }})" title="Resend Verification">
                                        <i class="fa fa-envelope"></i>
                                    </button>
                                    @endif
                                    <button class="btn btn-sm btn-warning" onclick="editUser({{ $user->id }})" title="Edit User">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-secondary" onclick="resetPassword({{ $user->id }})" title="Reset Password">
                                        <i class="fa fa-key"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteUser({{ $user->id }})" title="Delete User">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalTitle">Add New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="userForm">
                <div class="modal-body">
                    <input type="hidden" id="user_id" name="id">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" class="form-control" id="user_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" id="user_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password <span id="passwordLabel">*</span></label>
                        <input type="password" class="form-control" id="user_password" name="password" required>
                        <small class="form-text text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Assign Role *</label>
                        <select class="form-control form-select" id="user_role_id" name="role_id" required>
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}" data-role-name="{{ $role->name }}">
                                {{ $role->name }}
                                @if($role->description)
                                    — {{ $role->description }}
                                @endif
                            </option>
                            @endforeach
                            @if(isset($superAdminRole) && $superAdminRole)
                            <option value="{{ $superAdminRole->id }}" id="role_option_super_admin" hidden data-role-name="{{ $superAdminRole->name }}">
                                {{ $superAdminRole->name }} — seeded only; keep or change to Admin / Normal User
                            </option>
                            @endif
                        </select>
                        <small class="form-text text-muted">Super Admin is not listed — use only for the seeded system account.</small>
                    </div>
                    <div class="mb-3" id="verifyImmediatelyContainer">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="verify_immediately" name="verify_immediately" value="1" checked>
                            <label class="form-check-label" for="verify_immediately">
                                <strong>Verify email immediately</strong>
                            </label>
                        </div>
                        <small class="form-text text-muted">If checked, the user will be verified immediately without sending a verification email. Recommended for manually created users.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reset Password Modal -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reset Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="resetPasswordForm">
                <div class="modal-body">
                    <input type="hidden" id="reset_password_user_id" name="user_id">
                    <div class="alert alert-info">
                        <i class="fa fa-info-circle me-2"></i>You can reset this user's password without knowing their current password.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password *</label>
                        <input type="password" class="form-control" id="new_password" name="password" required minlength="8">
                        <small class="form-text text-muted">Minimum 8 characters</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password *</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="password_confirmation" required minlength="8">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let currentUserId = null;

function resetForm() {
    currentUserId = null;
    document.getElementById('userForm').reset();
    document.getElementById('user_id').value = '';
    document.getElementById('user_password').required = true;
    document.getElementById('passwordLabel').textContent = '*';
    document.getElementById('userModalTitle').textContent = 'Add New User';
    document.getElementById('verifyImmediatelyContainer').style.display = 'block';
    document.getElementById('verify_immediately').checked = true; // Default to checked
    const superOpt = document.getElementById('role_option_super_admin');
    if (superOpt) superOpt.setAttribute('hidden', 'hidden');
}

function editUser(id) {
    fetch(`{{ route('content-management.users.show', ':id') }}`.replace(':id', id))
        .then(response => response.json())
        .then(data => {
            currentUserId = id;
            const superOpt = document.getElementById('role_option_super_admin');
            if (superOpt) {
                if (data.role && data.role.slug === 'super-admin') {
                    superOpt.removeAttribute('hidden');
                } else {
                    superOpt.setAttribute('hidden', 'hidden');
                }
            }
            document.getElementById('user_id').value = data.id;
            document.getElementById('user_name').value = data.name;
            document.getElementById('user_email').value = data.email;
            document.getElementById('user_role_id').value = data.role_id;
            document.getElementById('user_password').required = false;
            document.getElementById('passwordLabel').textContent = '(leave blank to keep current)';
            document.getElementById('userModalTitle').textContent = 'Edit User';
            document.getElementById('verifyImmediatelyContainer').style.display = 'none';
            new bootstrap.Modal(document.getElementById('userModal')).show();
        });
}

function verifyEmail(id) {
    if (confirm('Verify this user\'s email?')) {
        fetch(`{{ route('content-management.users.verify-email', ':id') }}`.replace(':id', id), {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function resendVerification(id) {
    fetch(`{{ route('content-management.users.resend-verification', ':id') }}`.replace(':id', id), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Verification email sent successfully!');
        }
    });
}

function deleteUser(id) {
    if (confirm('Are you sure you want to delete this user?')) {
        fetch(`{{ route('content-management.users.destroy', ':id') }}`.replace(':id', id), {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}

function resetPassword(id) {
    document.getElementById('reset_password_user_id').value = id;
    document.getElementById('resetPasswordForm').reset();
    document.getElementById('reset_password_user_id').value = id;
    new bootstrap.Modal(document.getElementById('resetPasswordModal')).show();
}

document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const userId = document.getElementById('reset_password_user_id').value;
    const password = document.getElementById('new_password').value;
    const passwordConfirmation = document.getElementById('new_password_confirmation').value;
    
    if (password !== passwordConfirmation) {
        alert('Passwords do not match!');
        return;
    }
    
    if (password.length < 8) {
        alert('Password must be at least 8 characters long!');
        return;
    }
    
    const formData = new FormData();
    formData.append('password', password);
    formData.append('password_confirmation', passwordConfirmation);
    
    fetch(`{{ route('content-management.users.reset-password', ':id') }}`.replace(':id', userId), {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message || 'Password reset successfully!');
            const modalElement = document.getElementById('resetPasswordModal');
            if (modalElement && typeof jQuery !== 'undefined') {
                jQuery(modalElement).modal('hide');
            } else if (modalElement) {
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
        } else {
            alert(data.message || 'Failed to reset password. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred. Please try again.');
    });
});

document.getElementById('userForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const url = currentUserId 
        ? `{{ route('content-management.users.update', ':id') }}`.replace(':id', currentUserId)
        : '{{ route('content-management.users.store') }}';
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Close modal using jQuery (more reliable)
            const modalElement = document.getElementById('userModal');
            if (modalElement && typeof jQuery !== 'undefined') {
                jQuery(modalElement).modal('hide');
            } else if (modalElement) {
                // Fallback: manually hide
                modalElement.classList.remove('show');
                modalElement.style.display = 'none';
                document.body.classList.remove('modal-open');
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
            }
            setTimeout(() => location.reload(), 300);
        }
    });
});
</script>
</div>
