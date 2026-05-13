@extends('layouts.guest')

@section('content')

<h1>Create Account</h1>

<p>
    Daftar akun untuk mulai belanja furniture premium
</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="input-group">
        <label>Full Name</label>

        <div class="input-wrapper">
            <i class="fas fa-user"></i>

            <input type="text"
                   name="name"
                   value="{{ old('name') }}"
                   placeholder="Enter your full name"
                   required>
        </div>

        @error('name')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <!-- Email -->
    <div class="input-group">
        <label>Email Address</label>

        <div class="input-wrapper">
            <i class="fas fa-envelope"></i>

            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="your@email.com"
                   required>
        </div>

        @error('email')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <!-- Password -->
    <div class="input-group">
        <label>Password</label>

        <div class="input-wrapper">
            <i class="fas fa-lock"></i>

            <input type="password"
                   name="password"
                   placeholder="Create password"
                   required>
        </div>

        @error('password')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="input-group">
        <label>Confirm Password</label>

        <div class="input-wrapper">
            <i class="fas fa-lock"></i>

            <input type="password"
                   name="password_confirmation"
                   placeholder="Repeat password"
                   required>
        </div>
    </div>

    <!-- Button -->
    <button type="submit" class="auth-btn">
        <i class="fas fa-user-plus mr-2"></i>
        Create Account
    </button>

    <!-- Bottom -->
    <div class="bottom-link">
        Sudah punya akun?
        <a href="{{ route('login') }}">
            Sign In
        </a>
    </div>

</form>

@endsection