@extends('layouts.app')

@section('title', 'Users Management')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Users Management</h1>
        <p class="text-muted mb-0">Manage registered users, roles, and account details.</p>
    </div>

    <a href="{{ secure_url(route('admin.dashboard', [], false)) }}" class="btn btn-light border shadow-sm">
        <i class="bi bi-arrow-left me-1"></i>
        Dashboard
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
        <div class="d-flex gap-2">
            <i class="bi bi-x-circle-fill"></i>
            <div>
                <strong>Please fix the following:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
    <div class="card-header bg-white border-0 p-4">
        <div class="d-flex align-items-center gap-2">
            <div class="rounded-3 d-flex align-items-center justify-content-center"
                 style="width:42px;height:42px;background:#eef3ff;color:#2563eb;">
                <i class="bi bi-people-fill fs-5"></i>
            </div>
            <div>
                <h5 class="fw-bold mb-0">All Users</h5>
                <p class="text-muted small mb-0">Edit user information, admin access, or remove accounts.</p>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:80px">#</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $i => $user)
                    <tr>
                        <td class="text-muted">
                            {{ $users->firstItem() + $i }}
                        </td>

                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($user->avatar)
                                    <img src="{{ secure_asset('uploads/avatars/' . $user->avatar) }}"
                                         class="rounded-circle"
                                         width="38"
                                         height="38"
                                         style="object-fit:cover;">
                                @else
                                    <div class="rounded-circle d-flex align-items-center justify-content-center"
                                         style="width:38px;height:38px;background:#eef3ff;color:#2563eb;font-weight:700;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    <div class="text-muted small">ID #{{ $user->id }}</div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <span class="text-muted">{{ $user->email }}</span>
                        </td>

                        <td>
                            <span class="badge rounded-pill {{ $user->is_admin ? 'text-bg-primary' : 'text-bg-secondary' }}">
                                <i class="bi {{ $user->is_admin ? 'bi-shield-check' : 'bi-person' }} me-1"></i>
                                {{ $user->is_admin ? 'Admin' : 'Member' }}
                            </span>
                        </td>

                        <td>
                            <span class="text-muted">{{ $user->created_at->format('M d, Y') }}</span>
                        </td>

                        <td class="text-end">
                            <div class="btn-group btn-group-sm">
                                <button type="button"
                                        class="btn btn-light border"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="bi bi-pencil me-1"></i>
                                    Edit
                                </button>

                                <button type="button"
                                        class="btn btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteUserModal{{ $user->id }}">
                                    <i class="bi bi-trash3 me-1"></i>
                                    Delete
                                </button>
                            </div>
                        </td>
                    </tr>

                    {{-- Edit User Modal --}}
                    <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <div>
                                        <h5 class="modal-title fw-bold">
                                            <i class="bi bi-person-gear text-primary me-1"></i>
                                            Edit User
                                        </h5>
                                        <p class="text-muted small mb-0">
                                            Update account details and admin access.
                                        </p>
                                    </div>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form method="POST" action="{{ secure_url(route('admin.users.update', $user, false)) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Full Name</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="bi bi-person"></i>
                                                    </span>
                                                    <input type="text"
                                                           name="name"
                                                           class="form-control"
                                                           value="{{ old('name', $user->name) }}"
                                                           required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Email Address</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="bi bi-envelope"></i>
                                                    </span>
                                                    <input type="email"
                                                           name="email"
                                                           class="form-control"
                                                           value="{{ old('email', $user->email) }}"
                                                           required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">New Password</label>
                                                <input type="password"
                                                       name="password"
                                                       class="form-control"
                                                       placeholder="Leave blank to keep current password">
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label fw-semibold">Confirm Password</label>
                                                <input type="password"
                                                       name="password_confirmation"
                                                       class="form-control"
                                                       placeholder="Repeat new password">
                                            </div>

                                            <div class="col-12">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input"
                                                           type="checkbox"
                                                           role="switch"
                                                           id="isAdmin{{ $user->id }}"
                                                           name="is_admin"
                                                           value="1"
                                                           @checked($user->is_admin)>
                                                    <label class="form-check-label fw-semibold" for="isAdmin{{ $user->id }}">
                                                        Administrator access
                                                    </label>
                                                </div>

                                                <div class="form-text">
                                                    Admin users can access the dashboard, manage users, and update reservation statuses.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer border-0 pt-0">
                                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                                            Cancel
                                        </button>

                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-check2-circle me-1"></i>
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Delete User Modal --}}
                    <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 rounded-4 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <div>
                                        <h5 class="modal-title fw-bold">
                                            <i class="bi bi-trash3 text-danger me-1"></i>
                                            Delete User?
                                        </h5>
                                        <p class="text-muted small mb-0">
                                            This action cannot be undone.
                                        </p>
                                    </div>

                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <div class="rounded-4 p-3 bg-light">
                                        <div class="d-flex align-items-center gap-2">
                                            @if($user->avatar)
                                                <img src="{{ secure_asset('uploads/avatars/' . $user->avatar) }}"
                                                     class="rounded-circle"
                                                     width="42"
                                                     height="42"
                                                     style="object-fit:cover;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                     style="width:42px;height:42px;background:#eef3ff;color:#2563eb;font-weight:700;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div>
                                                <div class="fw-bold">{{ $user->name }}</div>
                                                <div class="text-muted small">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </div>

                                    @if($user->id === auth()->id())
                                        <div class="alert alert-warning mt-3 mb-0">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                            You cannot delete your own account.
                                        </div>
                                    @else
                                        <p class="text-muted small mt-3 mb-0">
                                            Deleting this account will permanently remove this user from the system.
                                        </p>
                                    @endif
                                </div>

                                <div class="modal-footer border-0 pt-0">
                                    <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    @if($user->id !== auth()->id())
                                        <form method="POST" action="{{ secure_url(route('admin.users.delete', $user, false)) }}">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash3 me-1"></i>
                                                Delete User
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="text-center text-muted py-5">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                <h5 class="fw-bold">No users found</h5>
                                <p class="mb-0">Registered users will appear here.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div class="card-footer bg-white border-0 p-3">
            {{ $users->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

@endsection