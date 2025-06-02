@extends('layouts.app')

@section('title', 'Inmate Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Inmate Management</h2>
    <a href="{{ route('inmates.create') }}" class="btn btn-primary">
        <i class="fas fa-user-plus me-2"></i> Add New Inmate
    </a>
</div>

<!-- Search and Filters -->
<div class="card mb-4">
    <div class="card-header">
        <h5 class="card-title mb-0">Search & Filter Inmates</h5>
        <p class="card-text small text-muted">Find and filter inmates by various criteria</p>
    </div>
    <div class="card-body">
        <form action="{{ route('inmates.index') }}" method="GET" class="row g-3">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input type="text" class="form-control" name="search" placeholder="Search by name or ID..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="parole-eligible" {{ request('status') == 'parole-eligible' ? 'selected' : '' }}>Parole Eligible</option>
                    <option value="high-readiness" {{ request('status') == 'high-readiness' ? 'selected' : '' }}>High Readiness</option>
                    <option value="reintegration-ready" {{ request('status') == 'reintegration-ready' ? 'selected' : '' }}>Reintegration Ready</option>
                    <option value="in-program" {{ request('status') == 'in-program' ? 'selected' : '' }}>In Program</option>
                </select>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="{{ route('inmates.index') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Inmates Table -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Inmates Overview</h5>
        <p class="card-text small text-muted">
            Showing {{ $inmates->count() }} {{ Str::plural('inmate', $inmates->count()) }}
        </p>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Inmate Details</th>
                        <th>Sentence Info</th>
                        <th>Programs</th>
                        <th>Readiness Score</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inmates as $inmate)
                    <tr>
                        <td>
                            <div>
                                <div class="fw-medium">{{ $inmate->name }}</div>
                                <div class="small text-muted">ID: {{ $inmate->inmate_id }}</div>
                                <div class="small text-muted">Age: {{ $inmate->age }}</div>
                                <div class="small text-muted">{{ $inmate->facility }}</div>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="small">Sentence: {{ $inmate->sentence }}</div>
                                <div class="small text-muted">Remaining: {{ $inmate->remaining_time }}</div>
                                <div class="small text-muted">
                                    Parole Eligible: {{ $inmate->parole_date ? $inmate->parole_date->format('Y-m-d') : 'N/A' }}
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <i class="fas fa-book-open text-primary me-2"></i>
                                <span>{{ $inmate->programs->count() }} programs</span>
                            </div>
                        </td>
                        <td>
                            <div>
                                <div class="d-flex justify-content-between small mb-1">
                                    <span>Score</span>
                                    <span>{{ $inmate->readiness_score }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" @style(['width'=> $inmate->readiness_score . '%']) aria-valuenow="{{ $inmate->readiness_score }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($inmate->is_parole_eligible)
                            <span class="badge bg-primary-light text-primary">Parole Eligible</span>
                            @elseif($inmate->readiness_score >= 85)
                            <span class="badge bg-success-light text-success">High Readiness</span>
                            @elseif($inmate->readiness_score >= 90)
                            <span class="badge bg-info-light text-info">Reintegration Ready</span>
                            @else
                            <span class="badge bg-secondary-light text-secondary">In Program</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('inmates.show', $inmate) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                <button class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-calendar"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No inmates found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $inmates->links() }}
        </div>
    </div>
</div>
@endsection