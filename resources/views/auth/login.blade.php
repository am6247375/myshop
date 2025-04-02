@extends('layouts.app')
@section('content')    
        <div class="login-container">
            <h3 class="text-center">تسجيل الدخول</h3>
            <form action="{{ route('login') }}" method="POST">
                @csrf()
                <div class="mb-3">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="أدخل بريدك الإلكتروني" value="{{ old('email') }}">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">كلمة المرور</label>
                    <div class="input-group">
                        <input type="password" name="password" id="passwordField" class="form-control @error('password') is-invalid @enderror" placeholder="أدخل كلمة المرور">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePassword()">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                    @error('password')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
                <div class="text-center mt-2">
                    <a href="{{ route('register') }}" class="btn btn-link">إنشاء حساب جديد</a>
                </div>
            </form>
        </div>
    </div>
@endsection
 