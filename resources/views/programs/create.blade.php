@extends('layouts.app')

@section('title', 'Create New Program')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Create New Program</h2>
                    <p class="text-muted mb-0">Set up a new rehabilitation program for inmates</p>
                </div>
                <div>
                    <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Programs
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('programs.store') }}" method="POST" id="programForm">
        @csrf
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Basic Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label for="name" class="form-label">Program Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}"
                                    placeholder="e.g., Carpentry Skills Training" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('category') is-invalid @enderror"
                                    id="category" name="category" required onchange="updateCategoryInfo()">
                                    <option value="">Select Category</option>
                                    <option value="vocational" {{ old('category') == 'vocational' ? 'selected' : '' }}>Vocational</option>
                                    <option value="education" {{ old('category') == 'education' ? 'selected' : '' }}>Education</option>
                                    <option value="therapy" {{ old('category') == 'therapy' ? 'selected' : '' }}>Therapy</option>
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Program Description <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="4"
                                placeholder="Provide a detailed description of the program objectives, methods, and expected outcomes" required>{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Minimum 50 characters recommended</small>
                        </div>

                        <!-- Category-specific suggestions -->
                        <div id="category-suggestions" class="alert alert-info d-none">
                            <h6 class="alert-heading">Suggestions for this category:</h6>
                            <div id="suggestion-content"></div>
                        </div>
                    </div>
                </div>

                <!-- Program Details -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs me-2"></i>Program Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="instructor" class="form-label">Instructor/Facilitator <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('instructor') is-invalid @enderror"
                                    id="instructor" name="instructor" value="{{ old('instructor') }}"
                                    placeholder="e.g., Dr. Sarah Ogundimu" required>
                                @error('instructor')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="duration_weeks" class="form-label">Duration (Weeks) <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('duration_weeks') is-invalid @enderror"
                                    id="duration_weeks" name="duration_weeks" value="{{ old('duration_weeks', 12) }}"
                                    min="1" max="52" required onchange="calculateEndDate()">
                                @error('duration_weeks')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="capacity" class="form-label">Capacity <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('capacity') is-invalid @enderror"
                                    id="capacity" name="capacity" value="{{ old('capacity', 20) }}"
                                    min="1" max="100" required>
                                @error('capacity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Max participants</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('start_date') is-invalid @enderror"
                                    id="start_date" name="start_date" value="{{ old('start_date') }}"
                                    required onchange="calculateEndDate()">
                                @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('end_date') is-invalid @enderror"
                                    id="end_date" name="end_date" value="{{ old('end_date') }}" required readonly>
                                @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Auto-calculated</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="upcoming" {{ old('status', 'upcoming') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule & Requirements -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>Schedule & Requirements
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="meeting_days" class="form-label">Meeting Days</label>
                                <div class="form-check-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="monday" name="meeting_days[]" value="monday">
                                        <label class="form-check-label" for="monday">Mon</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="tuesday" name="meeting_days[]" value="tuesday">
                                        <label class="form-check-label" for="tuesday">Tue</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="wednesday" name="meeting_days[]" value="wednesday" checked>
                                        <label class="form-check-label" for="wednesday">Wed</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="thursday" name="meeting_days[]" value="thursday">
                                        <label class="form-check-label" for="thursday">Thu</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="friday" name="meeting_days[]" value="friday" checked>
                                        <label class="form-check-label" for="friday">Fri</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="meeting_time" class="form-label">Meeting Time</label>
                                <div class="row">
                                    <div class="col-6">
                                        <input type="time" class="form-control" id="start_time" name="start_time" value="{{ old('start_time', '09:00') }}">
                                        <small class="text-muted">Start time</small>
                                    </div>
                                    <div class="col-6">
                                        <input type="time" class="form-control" id="end_time" name="end_time" value="{{ old('end_time', '12:00') }}">
                                        <small class="text-muted">End time</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="prerequisites" class="form-label">Prerequisites</label>
                                <textarea class="form-control @error('prerequisites') is-invalid @enderror"
                                    id="prerequisites" name="prerequisites" rows="3"
                                    placeholder="List any requirements for participation">{{ old('prerequisites') }}</textarea>
                                @error('prerequisites')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="learning_objectives" class="form-label">Learning Objectives</label>
                                <textarea class="form-control @error('learning_objectives') is-invalid @enderror"
                                    id="learning_objectives" name="learning_objectives" rows="3"
                                    placeholder="Key learning outcomes and goals">{{ old('learning_objectives') }}</textarea>
                                @error('learning_objectives')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Program Preview -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-eye me-2"></i>Program Preview
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div id="category-icon" class="program-icon bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                style="width: 80px; height: 80px;">
                                <i class="fas fa-question fa-2x text-white"></i>
                            </div>
                            <h6 id="preview-name" class="text-muted">Program Name</h6>
                            <span id="preview-category" class="badge bg-secondary">Category</span>
                        </div>

                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Duration:</span>
                                <span id="preview-duration">12 weeks</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Capacity:</span>
                                <span id="preview-capacity">20 participants</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Instructor:</span>
                                <span id="preview-instructor">TBD</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Status:</span>
                                <span id="preview-status" class="badge bg-warning text-dark">Upcoming</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resources & Materials -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-box me-2"></i>Resources & Materials
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="required_materials" class="form-label">Required Materials</label>
                            <textarea class="form-control @error('required_materials') is-invalid @enderror"
                                id="required_materials" name="required_materials" rows="3"
                                placeholder="List materials, tools, or resources needed">{{ old('required_materials') }}</textarea>
                            @error('required_materials')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="budget_estimate" class="form-label">Budget Estimate (₦)</label>
                            <input type="number" class="form-control @error('budget_estimate') is-invalid @enderror"
                                id="budget_estimate" name="budget_estimate" value="{{ old('budget_estimate') }}"
                                min="0" step="1000" placeholder="0">
                            @error('budget_estimate')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Estimated program cost</small>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="certification_available"
                                name="certification_available" value="1" {{ old('certification_available') ? 'checked' : '' }}>
                            <label class="form-check-label" for="certification_available">
                                Certification Available
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Program
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-undo me-2"></i>Reset Form
                            </button>
                            <a href="{{ route('programs.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    // Category information and suggestions
    const categoryInfo = {
        vocational: {
            icon: 'fas fa-tools',
            color: 'bg-primary',
            suggestions: [
                'Focus on practical, hands-on skills training',
                'Include industry-standard tools and equipment',
                'Provide certification opportunities',
                'Connect with local employers for job placement'
            ]
        },
        education: {
            icon: 'fas fa-graduation-cap',
            color: 'bg-success',
            suggestions: [
                'Emphasize literacy and numeracy skills',
                'Include critical thinking development',
                'Provide continuing education pathways',
                'Use interactive learning methods'
            ]
        },
        therapy: {
            icon: 'fas fa-heart',
            color: 'bg-info',
            suggestions: [
                'Focus on emotional regulation and coping skills',
                'Include group and individual sessions',
                'Emphasize mental health and wellbeing',
                'Provide ongoing support mechanisms'
            ]
        }
    };

    // Update category information
    function updateCategoryInfo() {
        const category = document.getElementById('category').value;
        const iconElement = document.querySelector('#category-icon i');
        const iconContainer = document.getElementById('category-icon');
        const previewCategory = document.getElementById('preview-category');
        const suggestionsDiv = document.getElementById('category-suggestions');
        const suggestionContent = document.getElementById('suggestion-content');

        if (category && categoryInfo[category]) {
            const info = categoryInfo[category];

            // Update icon
            iconElement.className = `${info.icon} fa-2x text-white`;
            iconContainer.className = `program-icon ${info.color} rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2`;

            // Update preview
            previewCategory.textContent = category.charAt(0).toUpperCase() + category.slice(1);
            previewCategory.className = `badge ${info.color}`;

            // Show suggestions
            suggestionContent.innerHTML = info.suggestions.map(s => `<li>${s}</li>`).join('');
            suggestionsDiv.classList.remove('d-none');
        } else {
            // Reset to default
            iconElement.className = 'fas fa-question fa-2x text-white';
            iconContainer.className = 'program-icon bg-secondary rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2';
            previewCategory.textContent = 'Category';
            previewCategory.className = 'badge bg-secondary';
            suggestionsDiv.classList.add('d-none');
        }
    }

    // Calculate end date based on start date and duration
    function calculateEndDate() {
        const startDate = document.getElementById('start_date').value;
        const duration = parseInt(document.getElementById('duration_weeks').value);

        if (startDate && duration) {
            const start = new Date(startDate);
            const end = new Date(start);
            end.setDate(end.getDate() + (duration * 7));

            document.getElementById('end_date').value = end.toISOString().split('T')[0];
        }
    }

    // Update preview in real-time
    function updatePreview() {
        const name = document.getElementById('name').value || 'Program Name';
        const duration = document.getElementById('duration_weeks').value || '12';
        const capacity = document.getElementById('capacity').value || '20';
        const instructor = document.getElementById('instructor').value || 'TBD';
        const status = document.getElementById('status').value || 'upcoming';

        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-duration').textContent = `${duration} weeks`;
        document.getElementById('preview-capacity').textContent = `${capacity} participants`;
        document.getElementById('preview-instructor').textContent = instructor;

        const statusElement = document.getElementById('preview-status');
        statusElement.textContent = status.charAt(0).toUpperCase() + status.slice(1);

        // Update status badge color
        const statusColors = {
            upcoming: 'bg-warning text-dark',
            active: 'bg-success',
            completed: 'bg-secondary',
            cancelled: 'bg-danger'
        };
        statusElement.className = `badge ${statusColors[status] || 'bg-secondary'}`;
    }

    // Add event listeners for real-time preview updates
    document.getElementById('name').addEventListener('input', updatePreview);
    document.getElementById('duration_weeks').addEventListener('input', updatePreview);
    document.getElementById('capacity').addEventListener('input', updatePreview);
    document.getElementById('instructor').addEventListener('input', updatePreview);
    document.getElementById('status').addEventListener('change', updatePreview);

    // Form validation
    document.getElementById('programForm').addEventListener('submit', function(e) {
        const requiredFields = this.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Validate end date is after start date
        const startDate = new Date(document.getElementById('start_date').value);
        const endDate = new Date(document.getElementById('end_date').value);

        if (endDate <= startDate) {
            document.getElementById('end_date').classList.add('is-invalid');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields and ensure dates are valid.');
        }
    });

    // Reset form function
    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            document.getElementById('programForm').reset();
            updateCategoryInfo();
            updatePreview();
        }
    }

    // Initialize
    updatePreview();
</script>

<style>
    .form-label {
        font-weight: 500;
        color: #495057;
    }

    .text-danger {
        color: #dc3545 !important;
    }

    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    }

    .program-icon {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .form-check-group {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .form-check-inline {
        margin-right: 0;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        display: block;
    }

    .alert-info {
        background-color: #e7f3ff;
        border-color: #b8daff;
        color: #004085;
    }

    .alert-info ul {
        margin-bottom: 0;
        padding-left: 20px;
    }
</style>
@endsection