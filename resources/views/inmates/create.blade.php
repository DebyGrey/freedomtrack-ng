@extends('layouts.app')

@section('title', 'Add New Inmate')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mb-1">Add New Inmate</h2>
                    <p class="text-muted mb-0">Enter inmate information and admission details</p>
                </div>
                <div>
                    <a href="{{ route('inmates.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Inmates
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('inmates.store') }}" method="POST" id="inmateForm">
        @csrf
        <div class="row">
            <!-- Personal Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-user me-2"></i>Personal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="inmate_id" class="form-label">Inmate ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('inmate_id') is-invalid @enderror"
                                    id="inmate_id" name="inmate_id" value="{{ old('inmate_id') }}"
                                    placeholder="e.g., INM001" required>
                                @error('inmate_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Unique identifier for the inmate</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="age" class="form-label">Age <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('age') is-invalid @enderror"
                                    id="age" name="age" value="{{ old('age') }}" min="18" max="100" required>
                                @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror"
                                    id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                                @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nationality" class="form-label">Nationality</label>
                                <input type="text" class="form-control @error('nationality') is-invalid @enderror"
                                    id="nationality" name="nationality" value="{{ old('nationality', 'Nigerian') }}">
                                @error('nationality')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="state_of_origin" class="form-label">State of Origin</label>
                                <select class="form-select @error('state_of_origin') is-invalid @enderror"
                                    id="state_of_origin" name="state_of_origin">
                                    <option value="">Select State</option>
                                    <option value="Lagos" {{ old('state_of_origin') == 'Lagos' ? 'selected' : '' }}>Lagos</option>
                                    <option value="Abuja" {{ old('state_of_origin') == 'Abuja' ? 'selected' : '' }}>Abuja (FCT)</option>
                                    <option value="Kano" {{ old('state_of_origin') == 'Kano' ? 'selected' : '' }}>Kano</option>
                                    <option value="Rivers" {{ old('state_of_origin') == 'Rivers' ? 'selected' : '' }}>Rivers</option>
                                    <option value="Oyo" {{ old('state_of_origin') == 'Oyo' ? 'selected' : '' }}>Oyo</option>
                                    <option value="Kaduna" {{ old('state_of_origin') == 'Kaduna' ? 'selected' : '' }}>Kaduna</option>
                                    <!-- Add more states as needed -->
                                </select>
                                @error('state_of_origin')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Legal Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-gavel me-2"></i>Legal Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="crime_category" class="form-label">Crime Category <span class="text-danger">*</span></label>
                                <select class="form-select @error('crime_category') is-invalid @enderror"
                                    id="crime_category" name="crime_category" required>
                                    <option value="">Select Crime Category</option>
                                    <option value="violent" {{ old('crime_category') == 'violent' ? 'selected' : '' }}>Violent Crime</option>
                                    <option value="property" {{ old('crime_category') == 'property' ? 'selected' : '' }}>Property Crime</option>
                                    <option value="drug" {{ old('crime_category') == 'drug' ? 'selected' : '' }}>Drug-Related</option>
                                    <option value="financial" {{ old('crime_category') == 'financial' ? 'selected' : '' }}>Financial Crime</option>
                                    <option value="cyber" {{ old('crime_category') == 'cyber' ? 'selected' : '' }}>Cyber Crime</option>
                                    <option value="other" {{ old('crime_category') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('crime_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sentence_length" class="form-label">Sentence Length <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('sentence_length') is-invalid @enderror"
                                    id="sentence_length" name="sentence_length" value="{{ old('sentence_length') }}"
                                    placeholder="e.g., 5 years, 18 months" required>
                                @error('sentence_length')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="offense_description" class="form-label">Offense Description</label>
                            <textarea class="form-control @error('offense_description') is-invalid @enderror"
                                id="offense_description" name="offense_description" rows="3"
                                placeholder="Brief description of the offense">{{ old('offense_description') }}</textarea>
                            @error('offense_description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="admission_date" class="form-label">Admission Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('admission_date') is-invalid @enderror"
                                    id="admission_date" name="admission_date" value="{{ old('admission_date', date('Y-m-d')) }}" required>
                                @error('admission_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="release_date" class="form-label">Expected Release Date</label>
                                <input type="date" class="form-control @error('release_date') is-invalid @enderror"
                                    id="release_date" name="release_date" value="{{ old('release_date') }}">
                                @error('release_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="parole_date" class="form-label">Parole Eligible Date</label>
                                <input type="date" class="form-control @error('parole_date') is-invalid @enderror"
                                    id="parole_date" name="parole_date" value="{{ old('parole_date') }}">
                                @error('parole_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contact -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-phone me-2"></i>Emergency Contact
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_name" class="form-label">Contact Name</label>
                                <input type="text" class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                    id="emergency_contact_name" name="emergency_contact_name"
                                    value="{{ old('emergency_contact_name') }}">
                                @error('emergency_contact_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_relationship" class="form-label">Relationship</label>
                                <select class="form-select @error('emergency_contact_relationship') is-invalid @enderror"
                                    id="emergency_contact_relationship" name="emergency_contact_relationship">
                                    <option value="">Select Relationship</option>
                                    <option value="parent" {{ old('emergency_contact_relationship') == 'parent' ? 'selected' : '' }}>Parent</option>
                                    <option value="spouse" {{ old('emergency_contact_relationship') == 'spouse' ? 'selected' : '' }}>Spouse</option>
                                    <option value="sibling" {{ old('emergency_contact_relationship') == 'sibling' ? 'selected' : '' }}>Sibling</option>
                                    <option value="child" {{ old('emergency_contact_relationship') == 'child' ? 'selected' : '' }}>Child</option>
                                    <option value="friend" {{ old('emergency_contact_relationship') == 'friend' ? 'selected' : '' }}>Friend</option>
                                    <option value="other" {{ old('emergency_contact_relationship') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('emergency_contact_relationship')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                    id="emergency_contact_phone" name="emergency_contact_phone"
                                    value="{{ old('emergency_contact_phone') }}" placeholder="+234 XXX XXX XXXX">
                                @error('emergency_contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="emergency_contact_address" class="form-label">Address</label>
                                <input type="text" class="form-control @error('emergency_contact_address') is-invalid @enderror"
                                    id="emergency_contact_address" name="emergency_contact_address"
                                    value="{{ old('emergency_contact_address') }}">
                                @error('emergency_contact_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Initial Assessment -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line me-2"></i>Initial Assessment
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="behavior_score" class="form-label">Initial Behavior Score <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range me-3" id="behavior_score" name="behavior_score"
                                    min="1" max="10" value="{{ old('behavior_score', 5) }}"
                                    oninput="this.nextElementSibling.value = this.value">
                                <output class="badge bg-primary">{{ old('behavior_score', 5) }}</output>
                            </div>
                            <small class="text-muted">1 = Poor, 10 = Excellent</small>
                            @error('behavior_score')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="readiness_score" class="form-label">Initial Readiness Score <span class="text-danger">*</span></label>
                            <div class="d-flex align-items-center">
                                <input type="range" class="form-range me-3" id="readiness_score" name="readiness_score"
                                    min="0" max="100" value="{{ old('readiness_score', 30) }}"
                                    oninput="this.nextElementSibling.value = this.value + '%'">
                                <output class="badge bg-warning text-dark">{{ old('readiness_score', 30) }}%</output>
                            </div>
                            <small class="text-muted">Overall reintegration readiness</small>
                            @error('readiness_score')
                            <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="parole" {{ old('status') == 'parole' ? 'selected' : '' }}>On Parole</option>
                                <option value="released" {{ old('status') == 'released' ? 'selected' : '' }}>Released</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="facility" class="form-label">Facility Assignment</label>
                            <select class="form-select @error('facility') is-invalid @enderror" id="facility" name="facility">
                                <option value="">Select Facility</option>
                                <option value="Lagos Correctional Center" {{ old('facility') == 'Lagos Correctional Center' ? 'selected' : '' }}>Lagos Correctional Center</option>
                                <option value="Abuja Correctional Facility" {{ old('facility') == 'Abuja Correctional Facility' ? 'selected' : '' }}>Abuja Correctional Facility</option>
                                <option value="Port Harcourt Correctional Center" {{ old('facility') == 'Port Harcourt Correctional Center' ? 'selected' : '' }}>Port Harcourt Correctional Center</option>
                                <option value="Kano Correctional Facility" {{ old('facility') == 'Kano Correctional Facility' ? 'selected' : '' }}>Kano Correctional Facility</option>
                            </select>
                            @error('facility')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Medical Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-heartbeat me-2"></i>Medical Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="medical_conditions" class="form-label">Medical Conditions</label>
                            <textarea class="form-control @error('medical_conditions') is-invalid @enderror"
                                id="medical_conditions" name="medical_conditions" rows="3"
                                placeholder="List any known medical conditions">{{ old('medical_conditions') }}</textarea>
                            @error('medical_conditions')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="medications" class="form-label">Current Medications</label>
                            <textarea class="form-control @error('medications') is-invalid @enderror"
                                id="medications" name="medications" rows="2"
                                placeholder="List current medications">{{ old('medications') }}</textarea>
                            @error('medications')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="mental_health_support"
                                name="mental_health_support" value="1" {{ old('mental_health_support') ? 'checked' : '' }}>
                            <label class="form-check-label" for="mental_health_support">
                                Requires Mental Health Support
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="card">
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Inmate Record
                            </button>
                            <button type="button" class="btn btn-outline-secondary" onclick="resetForm()">
                                <i class="fas fa-undo me-2"></i>Reset Form
                            </button>
                            <a href="{{ route('inmates.index') }}" class="btn btn-outline-danger">
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
    // Auto-generate inmate ID
    document.getElementById('name').addEventListener('input', function() {
        const name = this.value;
        const inmateIdField = document.getElementById('inmate_id');

        if (name && !inmateIdField.value) {
            // Generate ID based on first 3 letters of name + random number
            const prefix = name.substring(0, 3).toUpperCase();
            const randomNum = Math.floor(Math.random() * 1000).toString().padStart(3, '0');
            inmateIdField.value = `INM${prefix}${randomNum}`;
        }
    });

    // Calculate age from date of birth
    document.getElementById('date_of_birth').addEventListener('change', function() {
        const dob = new Date(this.value);
        const today = new Date();
        const age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));

        if (age > 0 && age < 120) {
            document.getElementById('age').value = age;
        }
    });

    // Auto-calculate release date based on sentence length and admission date
    function calculateReleaseDate() {
        const admissionDate = document.getElementById('admission_date').value;
        const sentenceLength = document.getElementById('sentence_length').value;

        if (admissionDate && sentenceLength) {
            const admission = new Date(admissionDate);
            let releaseDate = new Date(admission);

            // Simple parsing for common sentence formats
            if (sentenceLength.includes('year')) {
                const years = parseInt(sentenceLength.match(/\d+/)[0]);
                releaseDate.setFullYear(releaseDate.getFullYear() + years);
            } else if (sentenceLength.includes('month')) {
                const months = parseInt(sentenceLength.match(/\d+/)[0]);
                releaseDate.setMonth(releaseDate.getMonth() + months);
            }

            document.getElementById('release_date').value = releaseDate.toISOString().split('T')[0];

            // Set parole date to 2/3 of sentence
            const paroleDate = new Date(admission);
            const totalTime = releaseDate - admission;
            paroleDate.setTime(admission.getTime() + (totalTime * 0.67));
            document.getElementById('parole_date').value = paroleDate.toISOString().split('T')[0];
        }
    }

    document.getElementById('admission_date').addEventListener('change', calculateReleaseDate);
    document.getElementById('sentence_length').addEventListener('input', calculateReleaseDate);

    // Form validation
    document.getElementById('inmateForm').addEventListener('submit', function(e) {
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

        if (!isValid) {
            e.preventDefault();
            alert('Please fill in all required fields.');
        }
    });

    // Reset form function
    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All entered data will be lost.')) {
            document.getElementById('inmateForm').reset();
            // Reset range outputs
            document.querySelector('#behavior_score + output').value = '5';
            document.querySelector('#readiness_score + output').value = '30%';
        }
    }

    // Update range outputs
    document.getElementById('behavior_score').addEventListener('input', function() {
        this.nextElementSibling.value = this.value;
    });

    document.getElementById('readiness_score').addEventListener('input', function() {
        this.nextElementSibling.value = this.value + '%';
    });
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

    .form-range {
        cursor: pointer;
    }

    .badge {
        min-width: 50px;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        display: block;
    }
</style>
@endsection