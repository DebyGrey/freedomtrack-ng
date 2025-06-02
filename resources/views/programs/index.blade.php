@extends('layouts.app')

@section('title', 'Rehabilitation Programs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="mb-1">Rehabilitation Programs</h2>
        <p class="text-muted mb-0">Manage and track rehabilitation programs across all facilities</p>
    </div>
    <div class="d-flex gap-2">
        <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#programStatsModal">
            <i class="fas fa-chart-bar me-2"></i> View Analytics
        </button>
        <a href="{{ route('programs.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Create New Program
        </a>
    </div>
</div>

<!-- Program Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 opacity-75">Total Programs</h6>
                        <h2 class="card-title mb-0">{{ $programs->count() }}</h2>
                    </div>
                    <i class="fas fa-book-open fa-2x opacity-75"></i>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">All rehabilitation programs</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 opacity-75">Active Programs</h6>
                        <h2 class="card-title mb-0">{{ $activePrograms->count() }}</h2>
                    </div>
                    <i class="fas fa-play-circle fa-2x opacity-75"></i>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">Currently running</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-info text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 opacity-75">Total Participants</h6>
                        <h2 class="card-title mb-0">{{ $programs->sum('participants_count') }}</h2>
                    </div>
                    <i class="fas fa-users fa-2x opacity-75"></i>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">Across all programs</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="card-subtitle mb-2 opacity-75">Avg Success Rate</h6>
                        <h2 class="card-title mb-0">{{ round($programs->avg('completion_rate')) }}%</h2>
                    </div>
                    <i class="fas fa-trophy fa-2x opacity-75"></i>
                </div>
                <div class="mt-2">
                    <small class="opacity-75">Program completion rate</small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Program Category Distribution Chart -->
<div class="row mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Programs by Category</h5>
                <p class="card-text small text-muted">Distribution of rehabilitation programs</p>
            </div>
            <div class="card-body">
                <canvas id="categoryChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Program Completion Rates</h5>
                <p class="card-text small text-muted">Success rates by program category</p>
            </div>
            <div class="card-body">
                <canvas id="completionChart" width="400" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Search and Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Search & Filter Programs</h5>
        <p class="card-text small text-muted">Find rehabilitation programs by name, category, or instructor</p>
    </div>
    <div class="card-body">
        <form action="{{ route('programs.index') }}" method="GET" class="row g-3">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" placeholder="Search programs or instructors..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="vocational" {{ request('category') == 'vocational' ? 'selected' : '' }}>Vocational</option>
                    <option value="education" {{ request('category') == 'education' ? 'selected' : '' }}>Education</option>
                    <option value="therapy" {{ request('category') == 'therapy' ? 'selected' : '' }}>Therapy</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Programs Tabs -->
<ul class="nav nav-tabs mb-4" id="programTabs" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active"
            type="button" role="tab" aria-controls="active" aria-selected="true">
            Active Programs ({{ $activePrograms->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="upcoming-tab" data-bs-toggle="tab" data-bs-target="#upcoming"
            type="button" role="tab" aria-controls="upcoming" aria-selected="false">
            Upcoming ({{ $upcomingPrograms->count() }})
        </button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#all"
            type="button" role="tab" aria-controls="all" aria-selected="false">
            All Programs ({{ $programs->count() }})
        </button>
    </li>
</ul>

<div class="tab-content" id="programTabsContent">
    <!-- Active Programs Tab -->
    <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
        <div class="row">
            @forelse($activePrograms as $program)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-start border-success border-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="card-title mb-0">{{ $program->name }}</h6>
                            <div class="d-flex gap-1">
                                @if($program->category == 'vocational')
                                <span class="badge bg-primary">Vocational</span>
                                @elseif($program->category == 'education')
                                <span class="badge bg-success">Education</span>
                                @elseif($program->category == 'therapy')
                                <span class="badge bg-info">Therapy</span>
                                @endif
                                <span class="badge bg-success">Active</span>
                            </div>
                        </div>
                        <p class="card-text small text-muted mt-2">{{ Str::limit($program->description, 80) }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row text-sm mb-3">
                            <div class="col-6">
                                <strong>Duration:</strong><br>
                                <span class="text-muted">{{ $program->duration }}</span>
                            </div>
                            <div class="col-6">
                                <strong>Instructor:</strong><br>
                                <span class="text-muted">{{ $program->instructor }}</span>
                            </div>
                        </div>

                        <div class="row text-sm mb-3">
                            <div class="col-6">
                                <strong>Start Date:</strong><br>
                                <span class="text-muted">{{ $program->start_date->format('M d, Y') }}</span>
                            </div>
                            <div class="col-6">
                                <strong>End Date:</strong><br>
                                <span class="text-muted">{{ $program->end_date->format('M d, Y') }}</span>
                            </div>
                        </div>

                        <!-- Enrollment Progress -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span><strong>Enrollment</strong></span>
                                <span>{{ $program->participants_count }}/{{ $program->capacity }}</span>
                            </div>
                            <div class="progress mb-1" style="height: 8px;">
                                <div class="progress-bar bg-info" role="progressbar"
                                    @style(['width'=> ($program->participants_count / $program->capacity) * 100 . '%'])
                                    aria-valuenow="{{ $program->participants_count }}"
                                    aria-valuemin="0"
                                    aria-valuemax="{{ $program->capacity }}"></div>
                            </div>
                        </div>

                        <!-- Completion Rate -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between small mb-1">
                                <span><strong>Success Rate</strong></span>
                                <span>{{ $program->completion_rate }}%</span>
                            </div>
                            <div class="progress" style="height: 8px;">
                                <div class="progress-bar bg-success" role="progressbar"
                                    @style(['width'=> $program->completion_rate . '%'])
                                    aria-valuenow="{{ $program->completion_rate }}"
                                    aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <a href="{{ route('programs.show', $program) }}" class="btn btn-sm btn-outline-primary flex-fill">
                                <i class="fas fa-eye me-1"></i> View Details
                            </a>
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#enrollModal{{ $program->id }}">
                                <i class="fas fa-user-plus me-1"></i> Enroll
                            </button>
                            <a href="{{ route('programs.edit', $program) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Active Programs</h5>
                    <p class="text-muted">There are currently no active rehabilitation programs.</p>
                    <a href="{{ route('programs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i> Create New Program
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Upcoming Programs Tab -->
    <div class="tab-pane fade" id="upcoming" role="tabpanel" aria-labelledby="upcoming-tab">
        <div class="row">
            @forelse($upcomingPrograms as $program)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-start border-warning border-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <h6 class="card-title mb-0">{{ $program->name }}</h6>
                            <div class="d-flex gap-1">
                                @if($program->category == 'vocational')
                                <span class="badge bg-primary">Vocational</span>
                                @elseif($program->category == 'education')
                                <span class="badge bg-success">Education</span>
                                @elseif($program->category == 'therapy')
                                <span class="badge bg-info">Therapy</span>
                                @endif
                                <span class="badge bg-warning text-dark">Upcoming</span>
                            </div>
                        </div>
                        <p class="card-text small text-muted mt-2">{{ Str::limit($program->description, 80) }}</p>
                    </div>
                    <div class="card-body">
                        <div class="row text-sm mb-3">
                            <div class="col-6">
                                <strong>Duration:</strong><br>
                                <span class="text-muted">{{ $program->duration }}</span>
                            </div>
                            <div class="col-6">
                                <strong>Instructor:</strong><br>
                                <span class="text-muted">{{ $program->instructor }}</span>
                            </div>
                        </div>

                        <div class="row text-sm mb-3">
                            <div class="col-6">
                                <strong>Start Date:</strong><br>
                                <span class="text-muted">{{ $program->start_date->format('M d, Y') }}</span>
                            </div>
                            <div class="col-6">
                                <strong>Capacity:</strong><br>
                                <span class="text-muted">{{ $program->capacity }} inmates</span>
                            </div>
                        </div>

                        <div class="alert alert-info d-flex align-items-center">
                            <i class="fas fa-clock me-2"></i>
                            <small>Enrollment opens {{ $program->start_date->diffForHumans() }}</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-primary flex-fill">
                                <i class="fas fa-door-open me-1"></i> Open Enrollment
                            </button>
                            <a href="{{ route('programs.edit', $program) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-edit"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-calendar-plus fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Upcoming Programs</h5>
                    <p class="text-muted">There are no programs scheduled to start soon.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- All Programs Tab -->
    <div class="tab-pane fade" id="all" role="tabpanel" aria-labelledby="all-tab">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Program Details</th>
                        <th>Category</th>
                        <th>Schedule</th>
                        <th>Enrollment</th>
                        <th>Success Rate</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($programs as $program)
                    <tr>
                        <td>
                            <div>
                                <div class="fw-medium">{{ $program->name }}</div>
                                <div class="small text-muted">{{ $program->instructor }}</div>
                                <div class="small text-muted">{{ $program->duration }}</div>
                            </div>
                        </td>
                        <td>
                            @if($program->category == 'vocational')
                            <span class="badge bg-primary">Vocational</span>
                            @elseif($program->category == 'education')
                            <span class="badge bg-success">Education</span>
                            @elseif($program->category == 'therapy')
                            <span class="badge bg-info">Therapy</span>
                            @endif
                        </td>
                        <td>
                            <div class="small">
                                <div><strong>Start:</strong> {{ $program->start_date->format('M d, Y') }}</div>
                                <div><strong>End:</strong> {{ $program->end_date->format('M d, Y') }}</div>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div>{{ $program->participants_count }}/{{ $program->capacity }}</div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar"
                                        @style(['width'=> ($program->participants_count / $program->capacity) * 100 . '%'])>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small">
                                <div>{{ $program->completion_rate }}%</div>
                                <div class="progress mt-1" style="height: 4px;">
                                    <div class="progress-bar bg-success" role="progressbar"
                                        @style(['width'=> $program->completion_rate . '%'])>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($program->status == 'active')
                            <span class="badge bg-success">Active</span>
                            @elseif($program->status == 'upcoming')
                            <span class="badge bg-warning text-dark">Upcoming</span>
                            @elseif($program->status == 'completed')
                            <span class="badge bg-secondary">Completed</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('programs.show', $program) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('programs.edit', $program) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No programs found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Program Analytics Modal -->
<div class="modal fade" id="programStatsModal" tabindex="-1" aria-labelledby="programStatsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="programStatsModalLabel">
                    <i class="fas fa-chart-bar me-2"></i> Program Analytics
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <canvas id="modalCategoryChart" width="300" height="200"></canvas>
                    </div>
                    <div class="col-md-6">
                        <canvas id="modalCompletionChart" width="300" height="200"></canvas>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Top Performing Programs</h6>
                        <div class="list-group list-group-flush">
                            @foreach($programs->sortByDesc('completion_rate')->take(3) as $program)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <div class="fw-medium">{{ $program->name }}</div>
                                    <small class="text-muted">{{ $program->category }}</small>
                                </div>
                                <span class="badge bg-success">{{ $program->completion_rate }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6>Most Popular Programs</h6>
                        <div class="list-group list-group-flush">
                            @foreach($programs->sortByDesc('participants_count')->take(3) as $program)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <div class="fw-medium">{{ $program->name }}</div>
                                    <small class="text-muted">{{ $program->category }}</small>
                                </div>
                                <span class="badge bg-primary">{{ $program->participants_count }} participants</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@php
$categoryStats = $programs->groupBy('category')->map(fn($g) => $g->count());
$completionStats = $programs->groupBy('category')->map(fn($g) => round($g->avg('completion_rate')));

// Prepare JSON-safe versions
$categoryDataJson = json_encode([
'labels' => $categoryStats->keys()->values(),
'data' => $categoryStats->values()->values()
]);

$completionDataJson = json_encode([
'labels' => $completionStats->keys()->values(),
'data' => $completionStats->values()->values()
]);
@endphp



@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const categoryRaw = $categoryDataJson;
    const completionRaw = $completionDataJson;

    const categoryData = {
        labels: categoryRaw.labels,
        datasets: [{
            data: categoryRaw.data,
            backgroundColor: ['#0d6efd', '#198754', '#0dcaf0'],
            borderColor: '#fff',
            borderWidth: 2
        }]
    };

    const completionData = {
        labels: completionRaw.labels,
        datasets: [{
            label: 'Completion Rate (%)',
            data: completionRaw.data,
            backgroundColor: [
                'rgba(13, 110, 253, 0.8)',
                'rgba(25, 135, 84, 0.8)',
                'rgba(13, 202, 240, 0.8)'
            ],
            borderColor: ['#0d6efd', '#198754', '#0dcaf0'],
            borderWidth: 2
        }]
    };

    new Chart(document.getElementById('categoryChart'), {
        type: 'doughnut',
        data: categoryData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    new Chart(document.getElementById('completionChart'), {
        type: 'bar',
        data: completionData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection