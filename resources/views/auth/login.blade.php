@extends('layouts.guest')

@section('content')

<h1>Welcome Back</h1>

<p>
    Login untuk melanjutkan belanja furniture premium
</p>

<form method="POST" action="{{ route('login') }}">
    @csrf

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
    </div>

    <div class="input-group">
        <label>Password</label>

        <div class="input-wrapper">
            <i class="fas fa-lock"></i>

            <input type="password"
                   name="password"
                   placeholder="Enter your password"
                   required>
        </div>
    </div>

    <button type="submit" class="auth-btn">
        <i class="fas fa-right-to-bracket mr-2"></i>
        Sign In
    </button>

    <div class="bottom-link">
        Belum punya akun?
        <a href="{{ route('register') }}">
            Create Account
        </a>
    </div>
</form>

@endsection