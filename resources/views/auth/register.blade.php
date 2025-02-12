@extends('layouts.app')
@section('content')
    
        <div class="register-container">
            <h3 class="text-center">إنشاء حساب جديد</h3>
            <form action="{{ route('register') }}" method="POST">
                @csrf()
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">الاسم الأول</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="أدخل الاسم الأول" value="{{ old('first_name') }}">
                        @error('first_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">الاسم الأخير</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="أدخل الاسم الأخير" value="{{ old('last_name') }}">
                        @error('last_name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
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
                <div class="mb-3">
                    <label class="form-label">الجنس</label>
                    <select name="sex" class="form-control @error('sex') is-invalid @enderror">
                        <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>ذكر</option>
                        <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>أنثى</option>
                    </select>
                    @error('sex')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">الهاتف</label>
                    <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" placeholder="أدخل رقم الهاتف" value="{{ old('phone') }}">
                    @error('phone')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary w-100">إنشاء حساب جديد</button>
                <div class="text-center">
                   
                    <a href="{{ route('login') }}" class="btn btn-link">{{ __('لديك حساب؟ تسجيل الدخول') }}</a>
                </div>       
            </form>
        </div>
    </div>
    @endsection

   