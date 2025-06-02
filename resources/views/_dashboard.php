@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Stats Overview -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="card-subtitle mb-2 opacity-75">Total Inmates</h6>
                        <h2 class="card-title mb-0">{{ number_format($stats['totalInmates']) }}</h2>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-arrow-up me-1"></i>
                    <small class="opacity-75">Across all facilities</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="card-subtitle mb-2 opacity-75">Active Programs</h6>
                        <h2 class="card-title mb-0">{{ $stats['activePrograms'] }}</h2>
                    </div>
                    <i class="fas fa-book-open fa-2x opacity-75"></i>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-play-circle me-1"></i>
                    <small class="opacity-75">Rehabilitation programs</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="card-subtitle mb-2 opacity-75">Parole Eligible</h6>
                        <h2 class="card-title mb-0">{{ $stats['paroleEligible'] }}</h2>
                    </div>
                    <i class="fas fa-calendar fa-2x opacity-75"></i>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-gavel me-1"></i>
                    <small class="opacity-75">Ready for review</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div>
                        <h6 class="card-subtitle mb-2 opacity-75">Reintegration Ready</h6>
                        <h2 class="card-title mb-0">{{ $stats['reintegrationReady'] }}</h2>
                    </div>
                    <i class="fas fa-chart-line fa-2x opacity-75"></i>
                </div>
                <div class="d-flex align-items-center">
                    <i class="fas fa-trophy me-1"></i>
                    <small class="opacity-75">High readiness score</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Visual Analytics Row -->
<div class="row mb-4">
    <!-- Rehabilitation Workflow Visualization -->
    <div class="col-lg-8 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-project-diagram me-2"></i>
                    Rehabilitation & Reintegration Workflow
                </h5>
                <p class="card-text small text-muted">Visual representation of the rehabilitation process</p>
            </div>
            <div class="card-body">
                <div class="workflow-container">
                    <!-- Workflow Steps -->
                    <div class="row text-center">
                        <div class="col-md-2">
                            <div class="workflow-step">
                                <div class="step-circle bg-secondary text-white">
                                    <i class="fas fa-user-lock"></i>
                                </div>
                                <h6 class="mt-2">Incarceration</h6>
                                <p class="small text-muted">{{ $stats['totalInmates'] }} inmates</p>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </div>
                        <div class="col-md-2">
                            <div class="workflow-step">
                                <div class="step-circle bg-primary text-white">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <h6 class="mt-2">Programs</h6>
                                <p class="small text-muted">{{ $stats['activePrograms'] }} active</p>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </div>
                        <div class="col-md-2">
                            <div class="workflow-step">
                                <div class="step-circle bg-info text-white">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <h6 class="mt-2">Assessment</h6>
                                <p class="small text-muted">Progress tracking</p>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </div>
                        <div class="col-md-2">
                            <div class="workflow-step">
                                <div class="step-circle bg-warning text-white">
                                    <i class="fas fa-gavel"></i>
                                </div>
                                <h6 class="mt-2">Parole Review</h6>
                                <p class="small text-muted">{{ $stats['paroleEligible'] }} eligible</p>
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-center justify-content-center">
                            <i class="fas fa-arrow-right text-muted"></i>
                        </div>
                        <div class="col-md-2">
                            <div class="workflow-step">
                                <div class="step-circle bg-success text-white">
                                    <i class="fas fa-home"></i>
                                </div>
                                <h6 class="mt-2">Reintegration</h6>
                                <p class="small text-muted">{{ $stats['reintegrationReady'] }} ready</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Readiness Score Distribution -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Readiness Distribution
                </h5>
                <p class="card-text small text-muted">Inmate readiness scores</p>
            </div>
            <div class="card-body">
                <canvas id="readinessChart" width="300" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Program Analytics Row -->
<div class="row mb-4">
    <!-- Program Participation Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>
                    Program Participation
                </h5>
                <p class="card-text small text-muted">Enrollment by program category</p>
            </div>
            <div class="card-body">
                <canvas id="participationChart" width="400" height="250"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Progress Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-line-chart me-2"></i>
                    Monthly Progress Trends
                </h5>
                <p class="card-text small text-muted">Program completions over time</p>
            </div>
            <div class="card-body">
                <canvas id="progressChart" width="400" height="250"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Activities -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-clock me-2"></i>
                    Recent Activities
                </h5>
                <p class="card-text small text-muted">Latest updates from rehabilitation programs</p>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentActivities as $activity)
                    <div class="list-group-item px-0 border-0">
                        <div class="d-flex">
                            <div class="me-3">
                                @if($activity->type == 'program')
                                <div class="activity-icon bg-primary-light text-primary">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                @elseif($activity->type == 'parole')
                                <div class="activity-icon bg-success-light text-success">
                                    <i class="fas fa-calendar"></i>
                                </div>
                                @elseif($activity->type == 'therapy')
                                <div class="activity-icon bg-info-light text-info">
                                    <i class="fas fa-heart"></i>
                                </div>
                                @elseif($activity->type == 'education')
                                <div class="activity-icon bg-warning-light text-warning">
                                    <i class="fas fa-graduation-cap"></i>
                                </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1 fw-medium">{{ $activity->inmate->name }}</p>
                                <p class="mb-1 text-muted">{{ $activity->activity }}</p>
                                <p class="mb-0 small text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $activity->time_ago }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-clock fa-2x text-muted mb-2"></i>
                        <p class="text-muted">No recent activities</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Parole Reviews -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-gavel me-2"></i>
                    Upcoming Parole Reviews
                </h5>
                <p class="card-text small text-muted">Inmates scheduled for parole consideration</p>
            </div>
            <div class="card-body">
                @forelse($upcomingParoles as $parole)
                <div class="card mb-3 border-start border-info border-3">
                    <div class="card-body py-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0">{{ $parole->name }}</h6>
                            <span class="badge {{ $parole->readiness_score >= 85 ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ $parole->readiness_score >= 85 ? 'High Readiness' : 'Moderate Readiness' }}
                            </span>
                        </div>
                        <p class="card-text small text-muted mb-3">
                            <i class="fas fa-calendar me-1"></i>
                            Review Date: {{ $parole->parole_date ? $parole->parole_date->format('M d, Y') : 'TBD' }}
                        </p>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Readiness Score</span>
                                <span class="fw-medium">{{ $parole->readiness_score }}%</span>
                            </div>
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar {{ $parole->readiness_score >= 85 ? 'bg-success' : 'bg-warning' }}"
                                    role="progressbar"
                                    @style(['width'=> $parole->readiness_score . '%'])
                                    aria-valuenow="{{ $parole->readiness_score }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                        <p class="card-text small text-muted mb-0">
                            <i class="fas fa-book-open me-1"></i>
                            {{ $parole->programs->count() }} programs completed
                        </p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-gavel fa-2x text-muted mb-2"></i>
                    <p class="text-muted">No upcoming parole reviews</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Role-based Quick Actions -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-bolt me-2"></i>
            Quick Actions
        </h5>
        <p class="card-text small text-muted">
            @if($selectedRole == 'judiciary')
            Judiciary & Parole Board Tools
            @elseif($selectedRole == 'ngo')
            NGO & Social Worker Resources
            @elseif($selectedRole == 'researcher')
            Research & Policy Analysis
            @else
            Correctional Officer Dashboard
            @endif
        </p>
    </div>
    <div class="card-body">
        <div class="row">
            @if($selectedRole == 'correctional')
            <div class="col-md-3 mb-3">
                <a href="{{ route('inmates.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 text-decoration-none">
                    <i class="fas fa-users mb-2 fa-2x"></i>
                    <span>Manage Inmates</span>
                    <small class="text-muted mt-1">{{ $stats['totalInmates'] }} total</small>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('programs.index') }}" class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 text-decoration-none">
                    <i class="fas fa-book-open mb-2 fa-2x"></i>
                    <span>Track Programs</span>
                    <small class="text-muted mt-1">{{ $stats['activePrograms'] }} active</small>
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-exclamation-circle mb-2 fa-2x"></i>
                    <span>Incident Reports</span>
                    <small class="text-muted mt-1">View & create</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-clock mb-2 fa-2x"></i>
                    <span>Schedule Activities</span>
                    <small class="text-muted mt-1">Plan & organize</small>
                </button>
            </div>
            @elseif($selectedRole == 'judiciary')
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-calendar mb-2 fa-2x"></i>
                    <span>Parole Reviews</span>
                    <small class="text-muted mt-1">{{ $stats['paroleEligible'] }} pending</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-chart-line mb-2 fa-2x"></i>
                    <span>Readiness Reports</span>
                    <small class="text-muted mt-1">Assessment tools</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-check-circle mb-2 fa-2x"></i>
                    <span>Approve Releases</span>
                    <small class="text-muted mt-1">{{ $stats['reintegrationReady'] }} ready</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-folder-open mb-2 fa-2x"></i>
                    <span>Case Reviews</span>
                    <small class="text-muted mt-1">Detailed analysis</small>
                </button>
            </div>
            @elseif($selectedRole == 'ngo')
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-hands-helping mb-2 fa-2x"></i>
                    <span>Reintegration Support</span>
                    <small class="text-muted mt-1">Community programs</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-tools mb-2 fa-2x"></i>
                    <span>Skill Programs</span>
                    <small class="text-muted mt-1">Vocational training</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-heart mb-2 fa-2x"></i>
                    <span>Counseling Sessions</span>
                    <small class="text-muted mt-1">Mental health support</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-chart-line mb-2 fa-2x"></i>
                    <span>Progress Tracking</span>
                    <small class="text-muted mt-1">Individual monitoring</small>
                </button>
            </div>
            @elseif($selectedRole == 'researcher')
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-chart-bar mb-2 fa-2x"></i>
                    <span>Analytics Dashboard</span>
                    <small class="text-muted mt-1">Data insights</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-file-alt mb-2 fa-2x"></i>
                    <span>Research Reports</span>
                    <small class="text-muted mt-1">Generate studies</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-users mb-2 fa-2x"></i>
                    <span>Population Studies</span>
                    <small class="text-muted mt-1">Demographic analysis</small>
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-lightbulb mb-2 fa-2x"></i>
                    <span>Policy Insights</span>
                    <small class="text-muted mt-1">Recommendations</small>
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Readiness Score Distribution Chart
    const readinessCtx = document.getElementById('readinessChart').getContext('2d');
    new Chart(readinessCtx, {
        type: 'doughnut',
        data: {
            labels: ['Low (0-40)', 'Moderate (41-70)', 'High (71-85)', 'Excellent (86-100)'],
            datasets: [{
                data: [12, 28, 35, 25], // Sample data - replace with actual
                backgroundColor: [
                    '#dc3545',
                    '#ffc107',
                    '#0dcaf0',
                    '#198754'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true
                    }
                }
            }
        }
    });

    // Program Participation Chart
    const participationCtx = document.getElementById('participationChart').getContext('2d');
    new Chart(participationCtx, {
        type: 'bar',
        data: {
            labels: ['Vocational', 'Education', 'Therapy'],
            datasets: [{
                label: 'Enrolled',
                data: [145, 189, 98],
                backgroundColor: 'rgba(13, 110, 253, 0.8)',
                borderColor: '#0d6efd',
                borderWidth: 1
            }, {
                label: 'Completed',
                data: [98, 142, 76],
                backgroundColor: 'rgba(25, 135, 84, 0.8)',
                borderColor: '#198754',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Monthly Progress Trends Chart
    const progressCtx = document.getElementById('progressChart').getContext('2d');
    new Chart(progressCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Program Completions',
                data: [12, 19, 15, 25, 22, 30],
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'New Enrollments',
                data: [25, 32, 28, 35, 40, 38],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<style>
    .workflow-container {
        padding: 20px 0;
    }

    .workflow-step {
        position: relative;
    }

    .step-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        /* justify-content-center; */
        margin: 0 auto;
        font-size: 1.5rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        /* justify-content-center; */
        font-size: 1rem;
    }

    .card {
        transition: transform 0.2s ease-in-out;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
</style>
@endsection