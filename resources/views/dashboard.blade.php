@extends('layouts.app')

@section('title', 'Admin Dashboard')

@push('css')
<style>
    .dashboard-hero {
        background: linear-gradient(135deg, #0d47a1 0%, #1565c0 55%, #42a5f5 100%);
        border: none;
        color: #ffffff;
        overflow: hidden;
    }

    .dashboard-hero .btn {
        border-color: rgba(255, 255, 255, 0.35);
        color: #ffffff;
    }

    .dashboard-hero .btn:hover {
        background-color: rgba(255, 255, 255, 0.18);
        color: #ffffff;
    }

    .metric-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 0.8rem;
        background: rgba(255, 255, 255, 0.18);
        margin-right: 8px;
        margin-top: 8px;
    }

    .kpi-title {
        font-size: 0.78rem;
        letter-spacing: 0.04em;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 6px;
    }

    .kpi-value {
        font-size: 1.65rem;
        line-height: 1.1;
        font-weight: 700;
        color: #1f2d3d;
    }

    .kpi-sub {
        font-size: 0.83rem;
        color: #6c757d;
    }

    .kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 1.1rem;
    }

    .chart-wrap {
        min-height: 320px;
    }

    .table-modern th,
    .table-modern td {
        vertical-align: middle;
    }

    .package-progress .progress {
        height: 8px;
    }

    .soft-divider {
        border-top: 1px dashed rgba(0, 0, 0, 0.12);
    }
</style>
@endpush

@section('body')
@php
    $totalAppointments = $totalAppointments ?? 0;
    $pendingAppointments = $pendingAppointments ?? 0;
    $processedAppointments = $processedAppointments ?? 0;
    $totalPrescriptions = $totalPrescriptions ?? 0;
    $todayAppointments = $todayAppointments ?? 0;
    $todayPrescriptions = $todayPrescriptions ?? 0;
    $scheduledToday = $scheduledToday ?? 0;
    $activePackages = $activePackages ?? 0;
    $activeAdvices = $activeAdvices ?? 0;
    $totalPractitioners = $totalPractitioners ?? 0;
    $doctorCount = $doctorCount ?? 0;
    $hypnotherapistCount = $hypnotherapistCount ?? 0;
    $completionRate = $completionRate ?? 0;
    $pendingRate = $pendingRate ?? 0;
    $dayLabels = $dayLabels ?? [];
    $appointmentSeries = $appointmentSeries ?? [];
    $prescriptionSeries = $prescriptionSeries ?? [];
    $packagePerformance = $packagePerformance ?? [];
    $recentAppointments = $recentAppointments ?? [];
    $recentPrescriptions = $recentPrescriptions ?? [];

    $doctorShare = $totalPractitioners > 0 ? round(($doctorCount / $totalPractitioners) * 100, 1) : 0;
    $hypnotherapistShare = $totalPractitioners > 0 ? round(($hypnotherapistCount / $totalPractitioners) * 100, 1) : 0;
@endphp

<div class="card card-round dashboard-hero mb-4">
    <div class="card-body p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
            <div>
                <h3 class="mb-2 fw-bold text-white">Operations Dashboard</h3>
                <p class="mb-2 opacity-75">Live snapshot of appointments, prescriptions, practitioner activity, and package performance.</p>
                <div>
                    <span class="metric-chip"><i class="fas fa-calendar-day"></i> Scheduled Today: {{ number_format($scheduledToday) }}</span>
                    <span class="metric-chip"><i class="fas fa-file-medical"></i> Prescriptions Today: {{ number_format($todayPrescriptions) }}</span>
                </div>
            </div>

            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-round">
                    <i class="fas fa-calendar-check me-1"></i> Appointments
                </a>
                <a href="{{ route('prescriptions.all') }}" class="btn btn-sm btn-round">
                    <i class="fas fa-notes-medical me-1"></i> Prescriptions
                </a>
                <a href="{{ route('packages.index') }}" class="btn btn-sm btn-round">
                    <i class="fas fa-box-open me-1"></i> Packages
                </a>
                <a href="{{ route('advices.index') }}" class="btn btn-sm btn-round">
                    <i class="fas fa-lightbulb me-1"></i> Advices
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-xl-2 mb-3">
        <div class="card card-round h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-title">Total Appointments</p>
                    <h4 class="kpi-value">{{ number_format($totalAppointments) }}</h4>
                    <p class="kpi-sub mb-0">{{ number_format($todayAppointments) }} created today</p>
                </div>
                <div class="kpi-icon bg-primary"><i class="fas fa-calendar-check"></i></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2 mb-3">
        <div class="card card-round h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-title">Pending Queue</p>
                    <h4 class="kpi-value">{{ number_format($pendingAppointments) }}</h4>
                    <p class="kpi-sub mb-0">{{ $pendingRate }}% of total</p>
                </div>
                <div class="kpi-icon bg-warning"><i class="fas fa-hourglass-half"></i></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2 mb-3">
        <div class="card card-round h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-title">Prescriptions</p>
                    <h4 class="kpi-value">{{ number_format($totalPrescriptions) }}</h4>
                    <p class="kpi-sub mb-0">{{ number_format($todayPrescriptions) }} issued today</p>
                </div>
                <div class="kpi-icon bg-success"><i class="fas fa-file-medical"></i></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2 mb-3">
        <div class="card card-round h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-title">Completion Rate</p>
                    <h4 class="kpi-value">{{ $completionRate }}%</h4>
                    <p class="kpi-sub mb-0">{{ number_format($processedAppointments) }} appointments processed</p>
                </div>
                <div class="kpi-icon bg-info"><i class="fas fa-chart-line"></i></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2 mb-3">
        <div class="card card-round h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-title">Active Packages</p>
                    <h4 class="kpi-value">{{ number_format($activePackages) }}</h4>
                    <p class="kpi-sub mb-0">Offerings currently available</p>
                </div>
                <div class="kpi-icon bg-secondary"><i class="fas fa-box-open"></i></div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-2 mb-3">
        <div class="card card-round h-100">
            <div class="card-body d-flex justify-content-between align-items-start">
                <div>
                    <p class="kpi-title">Active Advices</p>
                    <h4 class="kpi-value">{{ number_format($activeAdvices) }}</h4>
                    <p class="kpi-sub mb-0">Guidelines selectable in Rx</p>
                </div>
                <div class="kpi-icon bg-danger"><i class="fas fa-lightbulb"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card card-round h-100">
            <div class="card-header d-flex flex-wrap justify-content-between gap-2 align-items-center">
                <div>
                    <h4 class="card-title mb-1">7-Day Service Activity</h4>
                    <p class="card-category mb-0">Appointments vs prescriptions created per day</p>
                </div>
            </div>
            <div class="card-body">
                <div class="chart-wrap">
                    <canvas id="dashboardTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mb-4">
        <div class="card card-round mb-3">
            <div class="card-header">
                <h4 class="card-title mb-1">Practitioner Mix</h4>
                <p class="card-category mb-0">Distribution by profile type</p>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-center">
                    <canvas id="practitionerMixChart" style="max-height: 220px;"></canvas>
                </div>
                <div class="soft-divider my-3"></div>
                <div class="d-flex justify-content-between mb-2">
                    <span><i class="fas fa-circle text-primary me-1"></i> Doctor</span>
                    <strong>{{ number_format($doctorCount) }} ({{ $doctorShare }}%)</strong>
                </div>
                <div class="d-flex justify-content-between">
                    <span><i class="fas fa-circle text-danger me-1"></i> Hypnotherapist</span>
                    <strong>{{ number_format($hypnotherapistCount) }} ({{ $hypnotherapistShare }}%)</strong>
                </div>
            </div>
        </div>

        <div class="card card-round package-progress">
            <div class="card-header">
                <h4 class="card-title mb-1">Top Package Demand</h4>
                <p class="card-category mb-0">Share of total appointment bookings</p>
            </div>
            <div class="card-body">
                @forelse($packagePerformance as $package)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-semibold">{{ $package['name'] }}</span>
                            <span>{{ $package['total'] }}</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $package['share'] }}%"></div>
                        </div>
                        <small class="text-muted">{{ $package['share'] }}% share</small>
                    </div>
                @empty
                    <p class="text-muted mb-0">No package booking data available yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 mb-4">
        <div class="card card-round h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-1">Recent Appointments</h4>
                    <p class="card-category mb-0">Latest bookings and queue status</p>
                </div>
                <a href="{{ route('appointments.index') }}" class="btn btn-sm btn-primary">Open Queue</a>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Package</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAppointments as $appointment)
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $appointment->name }}</div>
                                        <small class="text-muted">{{ $appointment->phone ?: 'No phone' }}</small>
                                    </td>
                                    <td>{{ $appointment->package->name ?? '-' }}</td>
                                    <td>{{ $appointment->date ?: '-' }} {{ $appointment->time ?: '' }}</td>
                                    <td>
                                        @if((string) $appointment->status === '0')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @else
                                            <span class="badge bg-success">Processed</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No appointments available yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 mb-4">
        <div class="card card-round h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-1">Recent Prescriptions</h4>
                    <p class="card-category mb-0">Most recently generated prescription records</p>
                </div>
                <a href="{{ route('prescriptions.all') }}" class="btn btn-sm btn-success">View All</a>
            </div>
            <div class="card-body pt-0">
                <div class="table-responsive">
                    <table class="table table-modern table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>Practitioner</th>
                                <th>Advice Count</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPrescriptions as $history)
                                @php
                                    $decodedAdvice = json_decode($history->advice ?? '', true);
                                    $adviceCount = is_array($decodedAdvice) ? count($decodedAdvice) : (filled($history->advice) ? 1 : 0);
                                @endphp
                                <tr>
                                    <td>
                                        <div class="fw-semibold">{{ $history->patient_name }}</div>
                                        <small class="text-muted">{{ $history->package->name ?? 'No package' }}</small>
                                    </td>
                                    <td>
                                        <div>{{ $history->practitioner?->name ?? 'Unknown' }}</div>
                                        <small class="text-muted">{{ ucfirst($history->practitioner_type ?? 'doctor') }}</small>
                                    </td>
                                    <td>{{ $adviceCount }}</td>
                                    <td>
                                        <a href="{{ route('prescriptions.view', $history->id) }}" class="btn btn-sm btn-info text-white" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('prescription.print', $history->id) }}" target="_blank" class="btn btn-sm btn-secondary" title="Print">
                                            <i class="fas fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">No prescription records available yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function () {
        const trendChartCanvas = document.getElementById('dashboardTrendChart');
        if (trendChartCanvas) {
            new Chart(trendChartCanvas, {
                type: 'line',
                data: {
                    labels: @json($dayLabels),
                    datasets: [
                        {
                            label: 'Appointments',
                            data: @json($appointmentSeries),
                            borderColor: '#1d7af3',
                            backgroundColor: 'rgba(29, 122, 243, 0.14)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        },
                        {
                            label: 'Prescriptions',
                            data: @json($prescriptionSeries),
                            borderColor: '#31ce36',
                            backgroundColor: 'rgba(49, 206, 54, 0.14)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.35,
                            pointRadius: 3,
                            pointHoverRadius: 5
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    }
                }
            });
        }

        const practitionerMixCanvas = document.getElementById('practitionerMixChart');
        if (practitionerMixCanvas) {
            new Chart(practitionerMixCanvas, {
                type: 'doughnut',
                data: {
                    labels: ['Doctor', 'Hypnotherapist'],
                    datasets: [
                        {
                            data: [{{ $doctorCount }}, {{ $hypnotherapistCount }}],
                            backgroundColor: ['#1d7af3', '#f3545d'],
                            borderColor: ['#ffffff', '#ffffff'],
                            borderWidth: 2
                        }
                    ]
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
    })();
</script>
@endpush
