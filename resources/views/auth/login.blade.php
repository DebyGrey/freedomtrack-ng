@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="fas fa-user-check me-2"></i>
                    FreedomTrack NG Login
                </h4>
                <p class="mb-0 mt-2 opacity-75">Digital Justice Platform</p>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-1"></i> Email Address
                        </label>
                        <input type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            placeholder="Enter your email">
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-1"></i> Password
                        </label>
                        <input type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            id="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            placeholder="Enter your password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            Remember me
                        </label>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </button>
                    </div>
                </form>

                <hr class="my-4">

                <div class="text-center">
                    <h6 class="text-muted mb-3">Demo Accounts</h6>
                    <div class="row g-2">
                        <div class="col-6">
                            <button class="btn btn-outline-secondary btn-sm w-100" onclick="fillCredentials('admin@freedomtrack.ng', 'password')">
                                <i class="fas fa-user-shield me-1"></i> Admin
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary btn-sm w-100" onclick="fillCredentials('officer@freedomtrack.ng', 'password')">
                                <i class="fas fa-user-tie me-1"></i> Officer
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary btn-sm w-100" onclick="fillCredentials('judge@freedomtrack.ng', 'password')">
                                <i class="fas fa-gavel me-1"></i> Judge
                            </button>
                        </div>
                        <div class="col-6">
                            <button class="btn btn-outline-secondary btn-sm w-100" onclick="fillCredentials('ngo@freedomtrack.ng', 'password')">
                                <i class="fas fa-hands-helping me-1"></i> NGO
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <p class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                This is a demo application for hackathon purposes
            </p>
        </div>
    </div>
</div>

<script>
    function fillCredentials(email, password) {
        document.getElementById('email').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection