@extends('layouts.app')

@section('title', $program->name . ' - Program Details')

@section('content')
<!-- Program Header -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-2 text-center">
                        <div class="position-relative">
                            <div class="program-icon bg-{{ $program->category == 'vocational' ? 'primary' : 
                                    ($program->category == 'education' ? 'success' : 'info') }} rounded-circle d-flex align-items-center justify-content-center mx-auto"
                                style="width: 120px; height: 120px;">
                                @if($program->category == 'vocational')
                                <i class="fas fa-tools fa-3x text-white"></i>
                                @elseif($program->category == 'education')
                                <i class="fas fa-graduation-cap fa-3x text-white"></i>
                                @else
                                <i class="fas fa-heart fa-3x text-white"></i>
                                @endif
                            </div>
                            <span class="position-absolute bottom-0 end-0 badge rounded-pill 
                                    {{ $program->status == 'active' ? 'bg-success' : 
                                       ($program->status == 'upcoming' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                {{ ucfirst($program->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="mb-1">{{ $program->name }}</h2>
                        <p class="text-muted mb-2">
                            <i class="fas fa-tag me-2"></i>
                            <span class="badge bg-{{ $program->category == 'vocational' ? 'primary' : 
                                    ($program->category == 'education' ? 'success' : 'info') }}">
                                {{ ucfirst($program->category) }}
                            </span>
                        </p>
                        <p class="text-muted mb-3">{{ $program->description }}</p>
                        <div class="row text-sm">
                            <div class="col-6">
                                <p class="mb-1">
                                    <i class="fas fa-user-tie me-1"></i>
                                    <strong>Instructor:</strong> {{ $program->instructor }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-clock me-1"></i>
                                    <strong>Duration:</strong> {{ $program->duration_weeks }} weeks
                                </p>
                            </div>
                            <div class="col-6">
                                <p class="mb-1">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    <strong>Start Date:</strong> {{ $program->start_date->format('M d, Y') }}
                                </p>
                                <p class="mb-1">
                                    <i class="fas fa-calendar-check me-1"></i>
                                    <strong>End Date:</strong> {{ $program->end_date->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="card bg-primary-light text-center">
                                    <div class="card-body py-3">
                                        <h4 class="text-primary mb-1">{{ $program->inmates->count() }}</h4>
                                        <small class="text-muted">Enrolled</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-success-light text-center">
                                    <div class="card-body py-3">
                                        <h4 class="text-success mb-1">{{ $program->capacity }}</h4>
                                        <small class="text-muted">Capacity</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-info-light text-center">
                                    <div class="card-body py-3">
                                        <h4 class="text-info mb-1">{{ $program->inmates->where('pivot.status', 'completed')->count() }}</h4>
                                        <small class="text-muted">Completed</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="card bg-warning-light text-center">
                                    <div class="card-body py-3">
                                        @php
                                        $totalInmates = $program->inmates->count();
                                        $completedInmates = $program->inmates->where('pivot.status', 'completed')->count();
                                        $completionRate = $totalInmates > 0 ? round(($completedInmates / $totalInmates) * 100) : 0;
                                        @endphp
                                        <h4 class="text-warning mb-1">{{ $completionRate }}%</h4>
                                        <small class="text-muted">Success Rate</small>
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
<ul class="nav nav-tabs mb-4" id="programDetailTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview"
            type="button" role="tab" aria-controls="overview" aria-selected="true">
            <i class="fas fa-info-circle me-2"></i>Overview
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="participants-tab" data-bs-toggle="tab" data-bs-target="#participants"
            type="button" role="tab" aria-controls="participants" aria-selected="false">
            <i class="fas fa-users me-2"></i>Participants ({{ $program->inmates->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="curriculum-tab" data-bs-toggle="tab" data-bs-target="#curriculum"
            type="button" role="tab" aria-controls="curriculum" aria-selected="false">
            <i class="fas fa-book me-2"></i>Curriculum
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="progress-tab" data-bs-toggle="tab" data-bs-target="#progress"
            type="button" role="tab" aria-controls="progress" aria-selected="false">
            <i class="fas fa-chart-line me-2"></i>Progress & Analytics
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="schedule-tab" data-bs-toggle="tab" data-bs-target="#schedule"
            type="button" role="tab" aria-controls="schedule" aria-selected="false">
            <i class="fas fa-calendar me-2"></i>Schedule
        </button>
    </li>
</ul>

<div class="tab-content" id="programDetailTabsContent">
    <!-- Overview Tab -->
    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
        <div class="row">
            <!-- Program Information -->
            <div class="col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Program Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Basic Details</h6>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Program Name:</strong></div>
                                    <div class="col-sm-7">{{ $program->name }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Category:</strong></div>
                                    <div class="col-sm-7">
                                        <span class="badge bg-{{ $program->category == 'vocational' ? 'primary' : 
                                                ($program->category == 'education' ? 'success' : 'info') }}">
                                            {{ ucfirst($program->category) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Duration:</strong></div>
                                    <div class="col-sm-7">{{ $program->duration_weeks }} weeks</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Capacity:</strong></div>
                                    <div class="col-sm-7">{{ $program->capacity }} participants</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Status:</strong></div>
                                    <div class="col-sm-7">
                                        <span class="badge {{ $program->status == 'active' ? 'bg-success' : 
                                                ($program->status == 'upcoming' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                                            {{ ucfirst($program->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted mb-3">Schedule & Instructor</h6>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Instructor:</strong></div>
                                    <div class="col-sm-7">{{ $program->instructor }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Start Date:</strong></div>
                                    <div class="col-sm-7">{{ $program->start_date->format('F d, Y') }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>End Date:</strong></div>
                                    <div class="col-sm-7">{{ $program->end_date->format('F d, Y') }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Meeting Days:</strong></div>
                                    <div class="col-sm-7">Monday, Wednesday, Friday</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-5"><strong>Time:</strong></div>
                                    <div class="col-sm-7">9:00 AM - 12:00 PM</div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Program Description</h6>
                            <p class="text-justify">{{ $program->description }}</p>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-muted mb-3">Learning Objectives</h6>
                            <ul class="list-unstyled">
                                @if($program->category == 'vocational')
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Develop practical skills in {{ strtolower($program->name) }}</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Gain industry-relevant certifications</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Prepare for employment opportunities</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Build confidence and work ethic</li>
                                @elseif($program->category == 'education')
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Improve literacy and numeracy skills</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Develop critical thinking abilities</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Enhance communication skills</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Prepare for further education</li>
                                @else
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Develop emotional regulation skills</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Improve interpersonal relationships</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Build coping strategies</li>
                                <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Enhance mental health and wellbeing</li>
                                @endif
                            </ul>
                        </div>

                        <div>
                            <h6 class="text-muted mb-3">Prerequisites</h6>
                            <p class="text-muted">
                                @if($program->category == 'vocational')
                                Basic literacy skills, willingness to learn practical skills, commitment to attend all sessions.
                                @elseif($program->category == 'education')
                                No specific prerequisites required. Open to all participants regardless of educational background.
                                @else
                                Willingness to participate in group discussions, commitment to personal growth and change.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats & Actions -->
            <div class="col-lg-4 mb-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Program Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Enrollment Progress -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Enrollment</span>
                                <span class="text-muted">{{ $program->inmates->count() }}/{{ $program->capacity }}</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    @style(['width'=> ($program->inmates->count() / $program->capacity) * 100 . '%'])
                                    aria-valuenow="{{ $program->inmates->count() }}"
                                    aria-valuemin="0"
                                    aria-valuemax="{{ $program->capacity }}"></div>
                            </div>
                            <small class="text-muted">
                                {{ $program->capacity - $program->inmates->count() }} spots available
                            </small>
                        </div>

                        <!-- Completion Rate -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Completion Rate</span>
                                <span class="text-muted">{{ $completionRate }}%</span>
                            </div>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    @style(['width'=> ($completionRate . '%')])
                                    aria-valuenow="{{ $completionRate }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted">
                                {{ $program->inmates->where('pivot.status', 'completed')->count() }} of {{ $program->inmates->count() }} completed
                            </small>
                        </div>

                        <!-- Active Participants -->
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Active Participants</span>
                                <span class="badge bg-info">{{ $program->inmates->where('pivot.status', 'active')->count() }}</span>
                            </div>
                        </div>

                        <!-- Average Progress -->
                        @php
                        $activeInmates = $program->inmates->where('pivot.status', 'active');
                        $avgProgress = $activeInmates->count() > 0 ? $activeInmates->avg('pivot.progress') : 0;
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="fw-medium">Average Progress</span>
                                <span class="text-muted">{{ round($avgProgress) }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-warning" role="progressbar"
                                    @style(['width'=> ($avgProgress . '%')])
                                    aria-valuenow="{{ $avgProgress }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>Quick Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#enrollInmateModal">
                                <i class="fas fa-user-plus me-2"></i>Enroll Inmate
                            </button>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#updateScheduleModal">
                                <i class="fas fa-calendar-alt me-2"></i>Update Schedule
                            </button>
                            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#generateReportModal">
                                <i class="fas fa-file-alt me-2"></i>Generate Report
                            </button>
                            <a href="{{ route('programs.edit', $program) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-edit me-2"></i>Edit Program
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Participants Tab -->
    <div class="tab-pane fade" id="participants" role="tabpanel" aria-labelledby="participants-tab">
        <div class="row">
            <!-- Active Participants -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users me-2"></i>Active Participants
                        </h5>
                    </div>
                    <div class="card-body">
                        @forelse($program->inmates->where('pivot.status', 'active') as $inmate)
                        <div class="card mb-3 border-start border-primary border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="card-title mb-1">
                                            <a href="{{ route('inmates.show', $inmate) }}" class="text-decoration-none">
                                                {{ $inmate->name }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">ID: {{ $inmate->inmate_id }}</small>
                                    </div>
                                    <span class="badge bg-primary">Active</span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between small mb-1">
                                        <span>Progress</span>
                                        <span>{{ $inmate->pivot->progress ?? 0 }}%</span>
                                    </div>
                                    <div class="progress" style="height: 6px;">
                                        <div class="progress-bar bg-primary" role="progressbar"
                                            @style(['width'=> ($inmate->pivot->progress ?? 0 . '%')])
                                            aria-valuenow="{{ $inmate->pivot->progress ?? 0 }}"
                                            aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>

                                <div class="row text-sm">
                                    <div class="col-6">
                                        <strong>Enrolled:</strong><br>
                                        <span class="text-muted">
                                            {{ $inmate->pivot->enrollment_date ? 
                                                        \Carbon\Carbon::parse($inmate->pivot->enrollment_date)->format('M d, Y') : 
                                                        'N/A' }}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Behavior Score:</strong><br>
                                        <span class="badge {{ $inmate->behavior_score >= 8 ? 'bg-success' : 
                                                    ($inmate->behavior_score >= 6 ? 'bg-warning text-dark' : 'bg-danger') }}">
                                            {{ $inmate->behavior_score }}/10
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No active participants</p>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#enrollInmateModal">
                                <i class="fas fa-user-plus me-1"></i>Enroll Inmate
                            </button>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Completed Participants -->
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-graduation-cap me-2"></i>Completed Participants
                        </h5>
                    </div>
                    <div class="card-body">
                        @forelse($program->inmates->where('pivot.status', 'completed') as $inmate)
                        <div class="card mb-3 border-start border-success border-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="card-title mb-1">
                                            <a href="{{ route('inmates.show', $inmate) }}" class="text-decoration-none">
                                                {{ $inmate->name }}
                                            </a>
                                        </h6>
                                        <small class="text-muted">ID: {{ $inmate->inmate_id }}</small>
                                    </div>
                                    <div class="d-flex gap-1">
                                        <span class="badge bg-success">Completed</span>
                                        @if($inmate->pivot->certification)
                                        <span class="badge bg-warning text-dark">Certified</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row text-sm">
                                    <div class="col-6">
                                        <strong>Completed:</strong><br>
                                        <span class="text-muted">
                                            {{ $inmate->pivot->completion_date ? 
                                                        \Carbon\Carbon::parse($inmate->pivot->completion_date)->format('M d, Y') : 
                                                        'N/A' }}
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <strong>Final Score:</strong><br>
                                        <span class="badge bg-success">100%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-graduation-cap fa-2x text-muted mb-2"></i>
                            <p class="text-muted">No completed participants yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Curriculum Tab -->
    <div class="tab-pane fade" id="curriculum" role="tabpanel" aria-labelledby="curriculum-tab">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book me-2"></i>Program Curriculum
                </h5>
                <p class="card-text small text-muted">Detailed breakdown of program modules and learning outcomes</p>
            </div>
            <div class="card-body">
                @if($program->category == 'vocational')
                <!-- Vocational Curriculum -->
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Module 1: Fundamentals (Weeks 1-2)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Safety protocols and procedures</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Tool identification and usage</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Basic techniques and methods</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Quality standards and measurements</li>
                        </ul>

                        <h6 class="text-primary mb-3">Module 2: Intermediate Skills (Weeks 3-6)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Advanced tool operation</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Project planning and execution</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Problem-solving techniques</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Time management skills</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Module 3: Advanced Applications (Weeks 7-10)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Complex project completion</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Quality control and inspection</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Customer service basics</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Business fundamentals</li>
                        </ul>

                        <h6 class="text-primary mb-3">Module 4: Certification Prep (Weeks 11-12)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Portfolio development</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Practical assessments</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Job readiness training</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Certification examination</li>
                        </ul>
                    </div>
                </div>
                @elseif($program->category == 'education')
                <!-- Education Curriculum -->
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">Module 1: Foundation Skills (Weeks 1-3)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Basic literacy assessment</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Reading comprehension</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Writing fundamentals</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Basic mathematics</li>
                        </ul>

                        <h6 class="text-success mb-3">Module 2: Communication (Weeks 4-6)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Verbal communication skills</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Written communication</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Digital literacy basics</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Presentation skills</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success mb-3">Module 3: Critical Thinking (Weeks 7-9)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Problem-solving strategies</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Analytical thinking</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Decision-making skills</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Research techniques</li>
                        </ul>

                        <h6 class="text-success mb-3">Module 4: Application (Weeks 10-12)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Project-based learning</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Collaborative work</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Final assessments</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Continuing education planning</li>
                        </ul>
                    </div>
                </div>
                @else
                <!-- Therapy Curriculum -->
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-info mb-3">Module 1: Self-Awareness (Weeks 1-3)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Understanding emotions</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Identifying triggers</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Personal reflection exercises</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Goal setting</li>
                        </ul>

                        <h6 class="text-info mb-3">Module 2: Coping Strategies (Weeks 4-6)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Stress management techniques</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Mindfulness practices</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Conflict resolution</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Healthy communication</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-info mb-3">Module 3: Relationships (Weeks 7-9)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Building trust</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Empathy development</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Social skills practice</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Family dynamics</li>
                        </ul>

                        <h6 class="text-info mb-3">Module 4: Future Planning (Weeks 10-12)</h6>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Reintegration preparation</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Support network building</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Relapse prevention</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Ongoing support planning</li>
                        </ul>
                    </div>
                </div>
                @endif

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Assessment Methods</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-clipboard-check text-primary me-2"></i>Weekly progress evaluations</li>
                            <li class="mb-2"><i class="fas fa-clipboard-check text-primary me-2"></i>Practical skill demonstrations</li>
                            <li class="mb-2"><i class="fas fa-clipboard-check text-primary me-2"></i>Peer feedback sessions</li>
                            <li class="mb-2"><i class="fas fa-clipboard-check text-primary me-2"></i>Final project presentation</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Resources & Materials</h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-book text-primary me-2"></i>Program handbook and workbook</li>
                            <li class="mb-2"><i class="fas fa-tools text-primary me-2"></i>Professional-grade tools and equipment</li>
                            <li class="mb-2"><i class="fas fa-video text-primary me-2"></i>Instructional videos and tutorials</li>
                            <li class="mb-2"><i class="fas fa-certificate text-primary me-2"></i>Industry certification materials</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress & Analytics Tab -->
    <div class="tab-pane fade" id="progress" role="tabpanel" aria-labelledby="progress-tab">
        <div class="row">
            <!-- Progress Overview -->
            <div class="col-lg-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>Progress Analytics
                        </h5>
                    </div>
                    <div class="card-body">
                        <!-- Progress Chart Placeholder -->
                        <div class="text-center py-5 bg-light rounded">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Progress Chart</h5>
                            <p class="text-muted">Visual representation of participant progress over time</p>
                            <small class="text-muted">Chart implementation would go here using Chart.js or similar</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Statistics -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-pie me-2"></i>Progress Statistics
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Completion Rates</h6>
                            <div class="d-flex justify-content-between mb-1">
                                <small>Excellent (90-100%)</small>
                                <small>{{ $program->inmates->where('pivot.progress', '>=', 90)->count() }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small>Good (70-89%)</small>
                                <small>{{ $program->inmates->whereBetween('pivot.progress', [70, 89])->count() }}</small>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <small>Fair (50-69%)</small>
                                <small>{{ $program->inmates->whereBetween('pivot.progress', [50, 69])->count() }}</small>
                            </div>
                            <div class="d-flex justify-content-between">
                                <small>Needs Improvement (<50%)< /small>
                                        <small>{{ $program->inmates->where('pivot.progress', '<', 50)->count() }}</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Attendance Rates</h6>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 92%"></div>
                            </div>
                            <small class="text-muted">92% average attendance</small>
                        </div>

                        <div class="mb-4">
                            <h6 class="text-muted mb-2">Engagement Score</h6>
                            <div class="progress mb-2" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 87%"></div>
                            </div>
                            <small class="text-muted">87% engagement rate</small>
                        </div>

                        <div>
                            <h6 class="text-muted mb-2">Satisfaction Rating</h6>
                            <div class="d-flex align-items-center">
                                <div class="me-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= 4 ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                </div>
                                <small class="text-muted">4.2/5.0</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Schedule Tab -->
    <div class="tab-pane fade" id="schedule" role="tabpanel" aria-labelledby="schedule-tab">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-calendar me-2"></i>Program Schedule
                </h5>
                <p class="card-text small text-muted">Weekly schedule and upcoming sessions</p>
            </div>
            <div class="card-body">
                <!-- Weekly Schedule -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Weekly Schedule</h6>
                        <div class="list-group">
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Monday</strong><br>
                                    <small class="text-muted">Theory & Fundamentals</small>
                                </div>
                                <span class="badge bg-primary">9:00 AM - 12:00 PM</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Wednesday</strong><br>
                                    <small class="text-muted">Practical Application</small>
                                </div>
                                <span class="badge bg-primary">9:00 AM - 12:00 PM</span>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>Friday</strong><br>
                                    <small class="text-muted">Review & Assessment</small>
                                </div>
                                <span class="badge bg-primary">9:00 AM - 12:00 PM</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted mb-3">Upcoming Sessions</h6>
                        <div class="list-group">
                            @for($i = 0; $i < 5; $i++)
                                @php
                                $date=now()->addDays($i * 2);
                                $sessions = ['Theory Session', 'Practical Workshop', 'Assessment Day', 'Group Project', 'Skills Practice'];
                                @endphp
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $date->format('M d, Y') }}</strong><br>
                                        <small class="text-muted">{{ $sessions[$i] }}</small>
                                    </div>
                                    <span class="badge bg-outline-secondary">{{ $date->format('l') }}</span>
                                </div>
                                @endfor
                        </div>
                    </div>
                </div>

                <!-- Calendar Placeholder -->
                <div class="text-center py-5 bg-light rounded">
                    <i class="fas fa-calendar-alt fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">Program Calendar</h5>
                    <p class="text-muted">Interactive calendar view of all program sessions</p>
                    <small class="text-muted">Calendar implementation would go here using FullCalendar or similar</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
<!-- Enroll Inmate Modal -->
<div class="modal fade" id="enrollInmateModal" tabindex="-1" aria-labelledby="enrollInmateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="enrollInmateModalLabel">
                    <i class="fas fa-user-plus me-2"></i>Enroll Inmate in Program
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('programs.enrollInmates', $program) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="inmate_ids" class="form-label">Select Inmates</label>
                        <select class="form-select" id="inmate_ids" name="inmate_ids[]" multiple required>
                            @foreach($availableInmates ?? [] as $inmate)
                            <option value="{{ $inmate->id }}">
                                {{ $inmate->name }} ({{ $inmate->inmate_id }})
                            </option>
                            @endforeach
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple inmates</small>
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
                        <i class="fas fa-user-plus me-1"></i>Enroll Inmates
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<style>
    .program-icon {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

    .bg-primary-light {
        background-color: rgba(13, 110, 253, 0.1) !important;
    }

    .bg-success-light {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }

    .bg-info-light {
        background-color: rgba(13, 202, 240, 0.1) !important;
    }

    .bg-warning-light {
        background-color: rgba(255, 193, 7, 0.1) !important;
    }

    .list-group-item {
        border-left: none;
        border-right: none;
    }

    .list-group-item:first-child {
        border-top: none;
    }

    .list-group-item:last-child {
        border-bottom: none;
    }
</style>
@endsection