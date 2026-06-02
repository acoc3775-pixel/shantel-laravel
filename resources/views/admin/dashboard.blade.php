@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h1 class="fw-bold mb-1">Admin Dashboard</h1>
        <p class="text-muted mb-0">Platform overview, reservation status, and monthly activity.</p>
    </div>

    <a href="{{ secure_url(route('admin.users', [], false)) }}" class="btn btn-primary">
        <i class="bi bi-people-fill me-1"></i>
        Manage Users
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6 col-xl">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Users</div>
                        <div class="fs-2 fw-bold">{{ $stats['users'] }}</div>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#eef3ff;color:#2563eb;">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Reservations</div>
                        <div class="fs-2 fw-bold">{{ $stats['reservations'] }}</div>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#eef3ff;color:#2563eb;">
                        <i class="bi bi-calendar-check fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Pending</div>
                        <div class="fs-2 fw-bold">{{ $stats['pending'] }}</div>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#fff7ed;color:#f97316;">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Confirmed</div>
                        <div class="fs-2 fw-bold">{{ $stats['confirmed'] }}</div>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#ecfdf5;color:#22c55e;">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="text-muted small fw-semibold text-uppercase">Cancelled</div>
                        <div class="fs-2 fw-bold">{{ $stats['cancelled'] }}</div>
                    </div>
                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                         style="width:48px;height:48px;background:#fef2f2;color:#ef4444;">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Charts --}}
<div class="row g-4 mb-4">
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-pie-chart-fill text-primary me-1"></i>
                    Booking Status Distribution
                </h5>
                <p class="text-muted small mb-0">Pending, confirmed, and cancelled bookings.</p>
            </div>
            <div class="card-body p-4">
                <canvas id="statusChart" height="230"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-graph-up-arrow text-primary me-1"></i>
                    Monthly Reservations
                </h5>
                <p class="text-muted small mb-0">Reservations created over the last 6 months.</p>
            </div>
            <div class="card-body p-4">
                <canvas id="monthlyChart" height="230"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-clock-history text-primary me-1"></i>
                    Recent Reservations
                </h5>
                <p class="text-muted small mb-0">Latest reservation activity.</p>
            </div>

            <div class="card-body p-4">
                @if($recentReservations->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                        <h5 class="fw-bold">No reservations yet</h5>
                        <p class="mb-0">Reservations will appear here once users create them.</p>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($recentReservations as $reservation)
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-3">
                                <div>
                                    <div class="fw-semibold">{{ $reservation->full_name }}</div>
                                    <div class="text-muted small">
                                        {{ $reservation->email }} ·
                                        {{ $reservation->reservation_date->format('M d, Y') }}
                                    </div>
                                </div>

                                <span class="badge rounded-pill
                                    @if($reservation->status === 'confirmed') text-bg-success
                                    @elseif($reservation->status === 'cancelled') text-bg-danger
                                    @else text-bg-warning
                                    @endif">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-header bg-white border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0">
                    <i class="bi bi-person-lines-fill text-primary me-1"></i>
                    Recent Users
                </h5>
                <p class="text-muted small mb-0">Newest registered accounts.</p>
            </div>

            <div class="card-body p-4">
                @if($recentUsers->isEmpty())
                    <div class="text-center text-muted py-5">
                        <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                        <h5 class="fw-bold">No users yet</h5>
                        <p class="mb-0">Registered users will appear here.</p>
                    </div>
                @else
                    <div class="list-group list-group-flush">
                        @foreach($recentUsers as $user)
                            <div class="list-group-item px-0 d-flex justify-content-between align-items-center gap-3">
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
                                        <div class="text-muted small">{{ $user->email }}</div>
                                    </div>
                                </div>

                                <span class="badge rounded-pill {{ $user->is_admin ? 'text-bg-primary' : 'text-bg-secondary' }}">
                                    {{ $user->is_admin ? 'Admin' : 'Member' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>

<script>
const statusCtx = document.getElementById('statusChart');
const monthlyCtx = document.getElementById('monthlyChart');

if (statusCtx) {
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: @json($statusChart['labels']),
            datasets: [{
                data: @json($statusChart['data']),
                backgroundColor: ['#f97316', '#22c55e', '#ef4444'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

if (monthlyCtx) {
    new Chart(monthlyCtx, {
        type: 'bar',
        data: {
            labels: @json($monthlyChart['labels']),
            datasets: [{
                label: 'Reservations',
                data: @json($monthlyChart['data']),
                backgroundColor: '#2563eb',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
}
</script>
@endsection