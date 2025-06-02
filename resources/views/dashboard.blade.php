@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- Stats Overview -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-subtitle text-muted">Total Inmates</h6>
                    <i class="fas fa-users text-muted"></i>
                </div>
                <h2 class="card-title mb-1">{{ number_format($stats['totalInmates']) }}</h2>
                <p class="card-text small text-muted">Across all facilities</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-subtitle text-muted">Active Programs</h6>
                    <i class="fas fa-book-open text-muted"></i>
                </div>
                <h2 class="card-title mb-1">{{ $stats['activePrograms'] }}</h2>
                <p class="card-text small text-muted">Rehabilitation programs</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-subtitle text-muted">Parole Eligible</h6>
                    <i class="fas fa-calendar text-muted"></i>
                </div>
                <h2 class="card-title mb-1">{{ $stats['paroleEligible'] }}</h2>
                <p class="card-text small text-muted">Ready for review</p>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="card-subtitle text-muted">Reintegration Ready</h6>
                    <i class="fas fa-chart-line text-muted"></i>
                </div>
                <h2 class="card-title mb-1">{{ $stats['reintegrationReady'] }}</h2>
                <p class="card-text small text-muted">High readiness score</p>
            </div>
        </div>
    </div>
</div>

<!-- Workflow Visualization -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Rehabilitation Workflow</h5>
        <p class="card-text small text-muted">Visual representation of the rehabilitation and reintegration process</p>
    </div>
    <div class="card-body">
        <div class="text-center">
            <img src="{{ asset('images/workflow-diagram.png') }}" alt="FreedomTrack NG Workflow Diagram" class="img-fluid border rounded">
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Activities -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Activities</h5>
                <p class="card-text small text-muted">Latest updates from rehabilitation programs</p>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentActivities as $activity)
                    <div class="list-group-item px-0">
                        <div class="d-flex">
                            <div class="me-3">
                                @if($activity->type == 'program')
                                <i class="fas fa-book-open text-primary"></i>
                                @elseif($activity->type == 'parole')
                                <i class="fas fa-calendar text-success"></i>
                                @elseif($activity->type == 'therapy')
                                <i class="fas fa-check-circle text-purple"></i>
                                @elseif($activity->type == 'education')
                                <i class="fas fa-chart-line text-warning"></i>
                                @endif
                            </div>
                            <div>
                                <p class="mb-1 fw-medium">{{ $activity->inmate->name }}</p>
                                <p class="mb-1 text-muted">{{ $activity->activity }}</p>
                                <p class="mb-0 small text-muted">{{ $activity->time_ago }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4">
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
                <h5 class="card-title mb-0">Upcoming Parole Reviews</h5>
                <p class="card-text small text-muted">Inmates scheduled for parole consideration</p>
            </div>
            <div class="card-body">
                @forelse($upcomingParoles as $parole)
                <div class="card mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="card-title mb-0">{{ $parole->name }}</h6>
                            <span class="badge {{ $parole->readiness_score >= 85 ? 'bg-success' : 'bg-secondary' }}">
                                {{ $parole->readiness_score >= 85 ? 'High Readiness' : 'Moderate Readiness' }}
                            </span>
                        </div>
                        <p class="card-text small text-muted mb-3">Review Date: {{ $parole->parole_date->format('Y-m-d') }}</p>
                        <div class="mb-2">
                            <div class="d-flex justify-content-between small mb-1">
                                <span>Readiness Score</span>
                                <span>{{ $parole->readiness_score }}%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" @style(['width'=> $parole->readiness_score . '%']) aria-valuenow="{{ $parole->readiness_score }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <p class="card-text small text-muted">{{ $parole->programs->count() }} programs completed</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-4">
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
        <h5 class="card-title mb-0">Quick Actions</h5>
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
                <a href="{{ route('inmates.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-users mb-2 fa-2x"></i>
                    Manage Inmates
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="{{ route('programs.index') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-book-open mb-2 fa-2x"></i>
                    Track Programs
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-exclamation-circle mb-2 fa-2x"></i>
                    Incident Reports
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-clock mb-2 fa-2x"></i>
                    Schedule Activities
                </button>
            </div>
            @elseif($selectedRole == 'judiciary')
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-calendar mb-2 fa-2x"></i>
                    Parole Reviews
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-chart-line mb-2 fa-2x"></i>
                    Readiness Reports
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-check-circle mb-2 fa-2x"></i>
                    Approve Releases
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-users mb-2 fa-2x"></i>
                    Case Reviews
                </button>
            </div>
            @elseif($selectedRole == 'ngo')
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-user-check mb-2 fa-2x"></i>
                    Reintegration Support
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-book-open mb-2 fa-2x"></i>
                    Skill Programs
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-calendar mb-2 fa-2x"></i>
                    Counseling Sessions
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-chart-line mb-2 fa-2x"></i>
                    Progress Tracking
                </button>
            </div>
            @elseif($selectedRole == 'researcher')
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-chart-line mb-2 fa-2x"></i>
                    Analytics Dashboard
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-book-open mb-2 fa-2x"></i>
                    Research Reports
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-users mb-2 fa-2x"></i>
                    Population Studies
                </button>
            </div>
            <div class="col-md-3 mb-3">
                <button class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                    <i class="fas fa-check-circle mb-2 fa-2x"></i>
                    Policy Insights
                </button>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection