@extends('layouts.app')
@section('content')  
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="auth-card shadow-lg rounded-4 overflow-hidden">
                    <div class="auth-header bg-primary text-white text-center py-4">
                        <h2 class="mb-3 fw-bold">تسجيل الدخول</h2>
                    </div>

                    <div class="auth-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-floating mb-4">
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="البريد الإلكتروني" value="{{ old('email') }}" autofocus>
                                <label for="email" class="text-secondary">
                                    <i class="fas fa-envelope me-2"></i>البريد الإلكتروني
                                </label>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-floating mb-4">
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="كلمة المرور">
                                <label for="password" class="text-secondary">
                                    <i class="fas fa-lock me-2"></i>كلمة المرور
                                </label>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary auth-header w-100 py-3 rounded-pill fw-bold">
                                <i class="fas fa-sign-in-alt me-2"></i>تسجيل الدخول
                            </button>

                            <div class="text-center mt-4">
                                <p class="mb-0">ليس لديك حساب؟
                                    <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                        أنشئ حساب جديد
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
