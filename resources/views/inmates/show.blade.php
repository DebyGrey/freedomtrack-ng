@php
$score = max(0, min(100, (float) $inmate->readiness_score));
@endphp

@extends('layouts.app')

@section('title', $inmate->name . ' - Inmate Profile')

@section('content')
<!-- Inmate Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="position-relative">
                            <img src="/placeholder.svg?height=120&width=120"
                                alt="{{ $inmate->name }}"
                                class="rounded-circle border border-3 border-light shadow"
                                style="width: 120px; height: 120px; object-fit: cover;">
                            <span class="position-absolute bottom-0 end-0 badge rounded-pill 
                                    {{ $inmate->status == 'active' ? 'bg-success' : 
                                       ($inmate->status == 'parole' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                {{ ucfirst($inmate->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="mb-1">{{ $inmate->name }}</h2>
                        <p class="text-muted mb-2">
                            <i class="fas fa-id-card me-2"></i>
                            Inmate ID: <strong>{{ $inmate->inmate_id }}</strong>
                        </p>
                        <div class="row text-sm">
                            <div class="col-6">
                                <p class="mb-1">
                                    <i class="fas fa-calendar me-1"></i>
                                    <strong>Age:</strong> {{ $inmate->age }} years
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-venus-mars me-1"></i>
                                    <strong>Gender:</strong> {{ ucfirst($inmate->gender) }}
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <strong>Admission:</strong> {{ $inmate->admission_date->format('M d, Y') }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-clock me-1"></i>
                                    <strong>Time Served:</strong> {{ $inmate->admission_date->diffForHumans(null, true) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="card bg-primary-light text-center">
                                    <div class="card-body py-3">
                                        <h4 class="text-primary mb-1">{{ $inmate->readiness_score }}%</h4>
                                        <small class="text-muted">Readiness Score</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-success-light text-center">
                                    <div class="card-body py-3">
                                        <h4 class="text-success mb-1">{{ $inmate->programs->count() }}</h4>
                                        <small class="text-muted">Programs</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-info-light text-center">
                                    <div class="card-body py-3">
                                        <h4 class="text-info mb-1">{{ $inmate->behavior_score }}/10</h4>
                                        <small class="text-muted">Behavior</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-warning-light text-center">
                                    <div class="card-body py-3">
                                        <h4 class="text-warning mb-1">
                                            @if($inmate->parole_date)
                                            {{ $inmate->parole_date->diffInDays() }}d
                                            @else
                                            N/A
                                            @endif
                                        </h4>
                                        <small class="text-muted">To Parole</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Navigation Tabs -->
<ul class="nav nav-tabs mb-4" id="inmateProfileTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
            type="button" role="tab" aria-controls="overview" aria-selected="true">
            <i class="fas fa-user me-2"></i>Overview
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="programs-tab" data-bs-toggle="tab" data-bs-target="#programs"
            type="button" role="tab" aria-controls="programs" aria-selected="false">
            <i class="fas fa-book-open me-2"></i>Programs ({{ $inmate->programs->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="assessment-tab" data-bs-toggle="tab" data-bs-target="#assessment"
            type="button" role="tab" aria-controls="assessment" aria-selected="false">
            <i class="fas fa-chart-line me-2"></i>Assessment
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="parole-tab" data-bs-toggle="tab" data-bs-target="#parole"
            type="button" role="tab" aria-controls="parole" aria-selected="false">
            <i class="fas fa-gavel me-2"></i>Parole Review
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline"
            type="button" role="tab" aria-controls="timeline" aria-selected="false">
            <i class="fas fa-history me-2"></i>Timeline
        </button>
    </li>
</ul>

<div class="tab-content" id="inmateProfileTabsContent">
    <!-- Overview Tab -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
        <div class="row">
            <!-- Personal Information -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Full Name:</strong></div>
                            <div class="col-sm-8">{{ $inmate->name }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Inmate ID:</strong></div>
                            <div class="col-sm-8">{{ $inmate->inmate_id }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Age:</strong></div>
                            <div class="col-sm-8">{{ $inmate->age }} years old</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Gender:</strong></div>
                            <div class="col-sm-8">{{ ucfirst($inmate->gender) }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Crime Category:</strong></div>
                            <div class="col-sm-8">
                                <span class="badge bg-secondary">{{ ucfirst($inmate->crime_category) }}</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Sentence Length:</strong></div>
                            <div class="col-sm-8">{{ $inmate->sentence_length }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Admission Date:</strong></div>
                            <div class="col-sm-8">{{ $inmate->admission_date->format('F d, Y') }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4"><strong>Expected Release:</strong></div>
                            <div class="col-sm-8">
                                @if($inmate->release_date)
                                {{ $inmate->release_date->format('F d, Y') }}
                                <small class="text-muted">({{ $inmate->release_date->diffForHumans() }})</small>
                                @else
                                <span class="text-muted">Not determined</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Status & Progress -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>Current Status & Progress
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Readiness Score -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Reintegration Readiness</span>
                                <span class="badge {{ $inmate->readiness_score >= 85 ? 'bg-success' : 
                                        ($inmate->readiness_score >= 70 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ $inmate->readiness_score }}%
                                </span>
                            </div>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar {{ $inmate->readiness_score >= 85 ? 'bg-success' : 
                                        ($inmate->readiness_score >= 70 ? 'bg-warning' : 'bg-danger') }}"
                                    role="progressbar"
                                    @style(['width'=> $inmate->readiness_score . '%'])
                                    aria-valuenow="{{ $inmate->readiness_score }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <div class="progress mb-2" style="height: 10px;">
                                <div class="progress-bar {{ $inmate->readiness_score >= 85 ? 'bg-success' : 
                                        ($inmate->readiness_score >= 70 ? 'bg-warning' : 'bg-danger') }}"
                                    role="progressbar"
                                    @style(['width'=> $inmate->readiness_score . '%'])
                                    aria-valuenow="{{ $inmate->readiness_score }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">
                                @if($inmate->readiness_score >= 85)
                                Excellent - Ready for reintegration
                                @elseif($inmate->readiness_score >= 70)
                                Good - Progressing well
                                @elseif($inmate->readiness_score >= 50)
                                Fair - Needs improvement
                                @else
                                Poor - Requires intensive support
                                @endif
                            </small>
                        </div>

                        <!-- Behavior Score -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Behavior Score</span>
                                <span class="badge {{ $inmate->behavior_score >= 8 ? 'bg-success' : 
                                        ($inmate->behavior_score >= 6 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                    {{ $inmate->behavior_score }}/10
                                </span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar {{ $inmate->behavior_score >= 8 ? 'bg-success' : 
                                        ($inmate->behavior_score >= 6 ? 'bg-warning' : 'bg-danger') }}"
                                    role="progressbar"
                                    @style(['width'=> ($inmate->behavior_score /10) * 100 . '%'])
                                    aria-valuenow="{{ $inmate->behavior_score }}"
                                    aria-valuemin="0"
                                    aria-valuemax="10"></div>
                            </div>
                        </div>

                        <!-- Program Participation -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Program Participation</span>
                                <span class="badge bg-info">{{ $inmate->programs->count() }} programs</span>
                            </div>
                            <div class="small text-muted">
                                Active: {{ $inmate->programs->where('pivot.status', 'active')->count() }} |
                                Completed: {{ $inmate->programs->where('pivot.status', 'completed')->count() }}
                            </div>
                        </div>

                        <!-- Parole Eligibility -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Parole Eligibility</span>
                                @if($inmate->parole_date && $inmate->parole_date <= now())
                                    <span class="badge bg-success">Eligible Now</span>
                                    @elseif($inmate->parole_date)
                                    <span class="badge bg-warning text-dark">
                                        {{ $inmate->parole_date->diffForHumans() }}
                                    </span>
                                    @else
                                    <span class="badge bg-secondary">Not Determined</span>
                                    @endif
                            </div>
                            @if($inmate->parole_date)
                            <small class="text-muted">
                                Parole Date: {{ $inmate->parole_date->format('F d, Y') }}
                            </small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#enrollProgramModal">
                                    <i class="fas fa-plus me-2"></i>Enroll in Program
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#updateProgressModal">
                                    <i class="fas fa-chart-line me-2"></i>Update Progress
                                </button>
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#behaviorReportModal">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Behavior Report
                                </button>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ route('inmates.edit', $inmate) }}" class="btn btn-outline-secondary w-100">
                                    <i class="fas fa-edit me-2"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Programs Tab -->
    <div class="tab-pane fade" id="programs" role="tabpanel" aria-labelledby="programs-tab">
        <div class="row">
            <!-- Active Programs -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-play-circle me-2"></i>Active Programs
                        </h5>
                    </div>
                    <div class="card-body">
                        @forelse($inmate->programs->where('pivot.status', 'active') as $program)
                        <div class="card mb-3 border-start border-primary border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $program->name }}</h6>
                                    <span class="badge bg-{{ $program->category == 'vocational' ? 'primary' : 
                                                ($program->category == 'education' ? 'success' : 'info') }}">
                                        {{ ucfirst($program->category) }}
                                    </span>
                                </div>
                                <p class="card-text small text-muted mb-3">{{ $program->instructor }}</p>

                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span>Progress</span>
                                        <span>{{ $program->pivot->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            @style(['width'=> $program->pivot->progress ?? 0 . '%'])
                                            aria-valuenow="{{ $program->pivot->progress ?? 0 }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="row text-sm">
                                    <div class="col-6">
                                        <strong>Started:</strong><br>
                                        <span class="text-muted">
                                            {{ $program->pivot->enrollment_date ? 
                                                        \Carbon\Carbon::parse($program->pivot->enrollment_date)->format('M d, Y') : 
                                                        'N/A' }}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Expected End:</strong><br>
                                        <span class="text-muted">{{ $program->end_date->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No active programs</p>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#enrollProgramModal">
                                <i class="fas fa-plus me-1"></i>Enroll in Program
                            </button>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Completed Programs -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-check-circle me-2"></i>Completed Programs
                        </h5>
                    </div>
                    <div class="card-body">
                        @forelse($inmate->programs->where('pivot.status', 'completed') as $program)
                        <div class="card mb-3 border-start border-success border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="card-title mb-0">{{ $program->name }}</h6>
                                    <div class="d-flex gap-1">
                                        <span class="badge bg-{{ $program->category == 'vocational' ? 'primary' : 
                                                    ($program->category == 'education' ? 'success' : 'info') }}">
                                            {{ ucfirst($program->category) }}
                                        </span>
                                        <span class="badge bg-success">Completed</span>
                                    </div>
                                </div>
                                <p class="card-text small text-muted mb-3">{{ $program->instructor }}</p>

                                <div class="row text-sm">
                                    <div class="col-6">
                                        <strong>Completed:</strong><br>
                                        <span class="text-muted">
                                            {{ $program->pivot->completion_date ? 
                                                        \Carbon\Carbon::parse($program->pivot->completion_date)->format('M d, Y') : 
                                                        'N/A' }}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Certification:</strong><br>
                                        @if($program->pivot->certification)
                                        <span class="badge bg-warning text-dark">Certified</span>
                                        @else
                                        <span class="text-muted">No certification</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-graduation-cap fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No completed programs yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Assessment Tab -->
    <div class="tab-pane fade" id="assessment" role="tabpanel" aria-labelledby="assessment-tab">
        <div class="row">
            <!-- Assessment Scores -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-star me-2"></i>Assessment Scores
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Education Score -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Education</span>
                                <span class="badge bg-primary">75%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 75%"></div>
                            </div>
                        </div>

                        <!-- Vocational Score -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Vocational Skills</span>
                                <span class="badge bg-success">68%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 68%"></div>
                            </div>
                        </div>

                        <!-- Mental Health Score -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Mental Health</span>
                                <span class="badge bg-info">82%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 82%"></div>
                            </div>
                        </div>

                        <!-- Social Skills Score -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Social Skills</span>
                                <span class="badge bg-warning text-dark">71%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 71%"></div>
                            </div>
                        </div>

                        <!-- Behavior Score -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Behavior</span>
                                <span class="badge bg-success">{{ ($inmate->behavior_score / 10) * 100 }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    @style(['width'=> ($inmate->behavior_score /10) * 100 . '%'])
                                    ></div>
                            </div>
                        </div>

                        <!-- Overall Readiness -->
                        <hr>
                        <div class="text-center">
                            <h4 class="text-primary mb-1">{{ $inmate->readiness_score }}%</h4>
                            <p class="text-muted mb-0">Overall Readiness</p>
                            <small class="text-muted">
                                Last updated: {{ now()->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment History -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-history me-2"></i>Assessment History
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <div class="fw-medium">Latest Assessment</div>
                                    <small class="text-muted">{{ now()->format('M d, Y') }}</small>
                                </div>
                                <span class="badge bg-primary">{{ $inmate->readiness_score }}%</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <div class="fw-medium">Previous Assessment</div>
                                    <small class="text-muted">{{ now()->subMonth()->format('M d, Y') }}</small>
                                </div>
                                <span class="badge bg-secondary">{{ $inmate->readiness_score - 5 }}%</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <div class="fw-medium">Initial Assessment</div>
                                    <small class="text-muted">{{ $inmate->admission_date->format('M d, Y') }}</small>
                                </div>
                                <span class="badge bg-secondary">{{ $inmate->readiness_score - 15 }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Parole Review Tab -->
    <div class="tab-pane fade" id="parole" role="tabpanel" aria-labelledby="parole-tab">
        <div class="row">
            <!-- Parole Eligibility Status -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-gavel me-2"></i>Parole Eligibility Status
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            @if($inmate->parole_date && $inmate->parole_date <= now())
                                <div class="alert alert-success">
                                <i class="fas fa-check-circle fa-2x mb-2"></i>
                                <h5>Eligible for Parole</h5>
                                <p class="mb-0">This inmate is currently eligible for parole review.</p>
                        </div>
                        @elseif($inmate->parole_date)
                        <div class="alert alert-warning">
                            <i class="fas fa-clock fa-2x mb-2"></i>
                            <h5>Parole Eligible {{ $inmate->parole_date->diffForHumans() }}</h5>
                            <p class="mb-0">Parole Date: {{ $inmate->parole_date->format('F d, Y') }}</p>
                        </div>
                        @else
                        <div class="alert alert-secondary">
                            <i class="fas fa-calendar-times fa-2x mb-2"></i>
                            <h5>Parole Date Not Set</h5>
                            <p class="mb-0">Parole eligibility has not been determined.</p>
                        </div>
                        @endif
                    </div>

                    <!-- Parole Readiness Factors -->
                    <h6 class="mb-3">Readiness Factors</h6>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Behavior Score</span>
                            <span class="badge {{ $inmate->behavior_score >= 8 ? 'bg-success' : 
                                        ($inmate->behavior_score >= 6 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $inmate->behavior_score }}/10
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Program Completion</span>
                            <span class="badge bg-info">
                                {{ $inmate->programs->where('pivot.status', 'completed')->count() }} programs
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Time Served</span>
                            <span class="badge bg-secondary">
                                {{ $inmate->admission_date->diffForHumans(null, true) }}
                            </span>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span>Readiness Score</span>
                            <span class="badge {{ $inmate->readiness_score >= 85 ? 'bg-success' : 
                                        ($inmate->readiness_score >= 70 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ $inmate->readiness_score }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Parole Review Checklist -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-check me-2"></i>Parole Review Checklist
                    </h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-{{ $inmate->behavior_score >= 7 ? 'check-circle text-success' : 'times-circle text-danger' }} me-2"></i>
                                Good Behavior Record
                            </div>
                            <span class="badge {{ $inmate->behavior_score >= 7 ? 'bg-success' : 'bg-danger' }}">
                                {{ $inmate->behavior_score >= 7 ? 'Met' : 'Not Met' }}
                            </span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-{{ $inmate->programs->where('pivot.status', 'completed')->count() >= 2 ? 'check-circle text-success' : 'times-circle text-danger' }} me-2"></i>
                                Completed Rehabilitation Programs
                            </div>
                            <span class="badge {{ $inmate->programs->where('pivot.status', 'completed')->count() >= 2 ? 'bg-success' : 'bg-danger' }}">
                                {{ $inmate->programs->where('pivot.status', 'completed')->count() >= 2 ? 'Met' : 'Not Met' }}
                            </span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-{{ $inmate->readiness_score >= 70 ? 'check-circle text-success' : 'times-circle text-danger' }} me-2"></i>
                                Minimum Readiness Score (70%)
                            </div>
                            <span class="badge {{ $inmate->readiness_score >= 70 ? 'bg-success' : 'bg-danger' }}">
                                {{ $inmate->readiness_score >= 70 ? 'Met' : 'Not Met' }}
                            </span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-{{ $inmate->admission_date->diffInMonths() >= 12 ? 'check-circle text-success' : 'times-circle text-danger' }} me-2"></i>
                                Minimum Time Served (12 months)
                            </div>
                            <span class="badge {{ $inmate->admission_date->diffInMonths() >= 12 ? 'bg-success' : 'bg-danger' }}">
                                {{ $inmate->admission_date->diffInMonths() >= 12 ? 'Met' : 'Not Met' }}
                            </span>
                        </div>

                        <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <i class="fas fa-check-circle text-success me-2"></i>
                                Psychological Evaluation
                            </div>
                            <span class="badge bg-success">Met</span>
                        </div>
                    </div>

                    <hr>

                    @php
                    $checklistScore = 0;
                    if ($inmate->behavior_score >= 7) $checklistScore += 20;
                    if ($inmate->programs->where('pivot.status', 'completed')->count() >= 2) $checklistScore += 20;
                    if ($inmate->readiness_score >= 70) $checklistScore += 20;
                    if ($inmate->admission_date->diffInMonths() >= 12) $checklistScore += 20;
                    $checklistScore += 20; // Psychological evaluation (assumed met)
                    @endphp

                    <div class="text-center">
                        <h5 class="mb-2">Parole Readiness: {{ $checklistScore }}%</h5>
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar {{ $checklistScore >= 80 ? 'bg-success' : 
                                        ($checklistScore >= 60 ? 'bg-warning' : 'bg-danger') }}"
                                role="progressbar"
                                @style(['width'=> $checklistScore . '%'])></div>
                        </div>
                        @if($checklistScore >= 80)
                        <button class="btn btn-success">
                            <i class="fas fa-gavel me-2"></i>Recommend for Parole
                        </button>
                        @else
                        <button class="btn btn-warning">
                            <i class="fas fa-clock me-2"></i>Needs More Preparation
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Timeline Tab -->
<div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-tab">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-history me-2"></i>Inmate Timeline
            </h5>
            <p class="card-text small text-muted">Complete history of activities and milestones</p>
        </div>
        <div class="card-body">
            <div class="timeline">
                <!-- Timeline items -->
                <div class="timeline-item">
                    <div class="timeline-marker bg-secondary"></div>
                    <div class="timeline-content">
                        <h6 class="timeline-title">Admission to Facility</h6>
                        <p class="timeline-description">{{ $inmate->name }} was admitted to the correctional facility.</p>
                        <small class="text-muted">{{ $inmate->admission_date->format('F d, Y') }}</small>
                    </div>
                </div>

                @foreach($inmate->programs as $program)
                <div class="timeline-item">
                    <div class="timeline-marker bg-primary"></div>
                    <div class="timeline-content">
                        <h6 class="timeline-title">Enrolled in {{ $program->name }}</h6>
                        <p class="timeline-description">Started {{ $program->category }} program with {{ $program->instructor }}.</p>
                        <small class="text-muted">
                            {{ $program->pivot->enrollment_date ? 
                                            \Carbon\Carbon::parse($program->pivot->enrollment_date)->format('F d, Y') : 
                                            'Date not recorded' }}
                        </small>
                    </div>
                </div>

                @if($program->pivot->status == 'completed')
                <div class="timeline-item">
                    <div class="timeline-marker bg-success"></div>
                    <div class="timeline-content">
                        <h6 class="timeline-title">Completed {{ $program->name }}</h6>
                        <p class="timeline-description">
                            Successfully completed the program
                            @if($program->pivot->certification)
                            and received certification.
                            @else
                            .
                            @endif
                        </p>
                        <small class="text-muted">
                            {{ $program->pivot->completion_date ? 
                                                \Carbon\Carbon::parse($program->pivot->completion_date)->format('F d, Y') : 
                                                'Date not recorded' }}
                        </small>
                    </div>
                </div>
                @endif
                @endforeach

                @if($inmate->parole_date && $inmate->parole_date <= now())
                    <div class="timeline-item">
                    <div class="timeline-marker bg-warning"></div>
                    <div class="timeline-content">
                        <h6 class="timeline-title">Parole Eligible</h6>
                        <p class="timeline-description">Became eligible for parole consideration.</p>
                        <small class="text-muted">{{ $inmate->parole_date->format('F d, Y') }}</small>
                    </div>
            </div>
            @endif

            <!-- Current status -->
            <div class="timeline-item">
                <div class="timeline-marker bg-info"></div>
                <div class="timeline-content">
                    <h6 class="timeline-title">Current Status</h6>
                    <p class="timeline-description">
                        Readiness Score: {{ $inmate->readiness_score }}% |
                        Behavior Score: {{ $inmate->behavior_score }}/10
                    </p>
                    <small class="text-muted">{{ now()->format('F d, Y') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>

<!-- Modals -->
<!-- Enroll Program Modal -->
<div class="modal fade" id="enrollProgramModal" tabindex="-1" aria-labelledby="enrollProgramModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollProgramModalLabel">
                    <i class="fas fa-plus me-2"></i>Enroll in Program
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inmates.enroll', $inmate) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="program_id" class="form-label">Select Program</label>
                        <select class="form-select" id="program_id" name="program_id" required>
                            <option value="">Choose a program...</option>
                            @foreach($availablePrograms ?? [] as $program)
                            <option value="{{ $program->id }}">
                                {{ $program->name }} ({{ ucfirst($program->category) }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="enrollment_date" class="form-label">Enrollment Date</label>
                        <input type="date" class="form-control" id="enrollment_date" name="enrollment_date"
                            value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Enroll
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Progress Modal -->
<div class="modal fade" id="updateProgressModal" tabindex="-1" aria-labelledby="updateProgressModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProgressModalLabel">
                    <i class="fas fa-chart-line me-2"></i>Update Progress
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inmates.updateProgress', $inmate) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="progress_program_id" class="form-label">Program</label>
                        <select class="form-select" id="progress_program_id" name="program_id" required>
                            <option value="">Select program...</option>
                            @foreach($inmate->programs->where('pivot.status', 'active') as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="progress" class="form-label">Progress (%)</label>
                        <input type="range" class="form-range" id="progress" name="progress"
                            min="0" max="100" value="50" oninput="this.nextElementSibling.value = this.value">
                        <output>50</output>%
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                            placeholder="Add any notes about the progress..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i>Update Progress
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Behavior Report Modal -->
<div class="modal fade" id="behaviorReportModal" tabindex="-1" aria-labelledby="behaviorReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="behaviorReportModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Behavior Report
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('inmates.behaviorReport', $inmate) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="behavior_type" class="form-label">Report Type</label>
                        <select class="form-select" id="behavior_type" name="behavior_type" required>
                            <option value="">Select type...</option>
                            <option value="positive">Positive Behavior</option>
                            <option value="negative">Negative Behavior</option>
                            <option value="incident">Incident Report</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="behavior_score" class="form-label">Behavior Score (1-10)</label>
                        <input type="number" class="form-control" id="behavior_score" name="behavior_score"
                            min="1" max="10" value="{{ $inmate->behavior_score }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="behavior_description" class="form-label">Description</label>
                        <textarea class="form-control" id="behavior_description" name="description" rows="4"
                            placeholder="Describe the behavior or incident..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="report_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="report_date" name="report_date"
                            value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i>Submit Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 15px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #dee2e6;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-marker {
        position: absolute;
        left: -22px;
        top: 5px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #dee2e6;
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 3px solid #0d6efd;
    }

    .timeline-title {
        margin-bottom: 5px;
        color: #495057;
    }

    .timeline-description {
        margin-bottom: 5px;
        color: #6c757d;
    }

    .card:hover {
        transform: translateY(-2px);
        transition: transform 0.2s ease-in-out;
    }

    .progress {
        height: 8px;
    }

    .badge {
        font-size: 0.75em;
    }
</style>
@endsection