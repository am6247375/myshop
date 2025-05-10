@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="auth-card shadow-lg rounded-4 overflow-hidden">
                    <div class="auth-header bg-primary text-white text-center py-4">
                        <h2 class="mb-3 fw-bold">انشاء حساب جديد</h2>
                    </div>
                    {{-- <div class="auth-header bg-primary text-white text-center py-4">
                        <h2 class="mb-3 fw-bold">مرحبًا بك في منصة متجري</h2>
                        <p class="mb-0">ابدأ تجارتك بإنشاء حساب جديد</p>
                    </div> --}}

                    <div class="auth-body p-4">
                        <form method="POST" id="registerForm" action="{{ route('register') }}">
                            @csrf

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="first_name" id="first_name"
                                            class="form-control @error('first_name') is-invalid @enderror"
                                            placeholder="الاسم " value="{{ old('first_name') }}" autofocus>
                                        <label for="first_name" class="text-secondary">
                                            <i class="fas fa-user me-2"></i>الاسم
                                        </label>
                                        @error('first_name')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="last_name" id="last_name"
                                            class="form-control @error('last_name') is-invalid @enderror"
                                            placeholder="الاسم الأخير" value="{{ old('last_name') }}">
                                        <label for="last_name" class="text-secondary">
                                            <i class="fas fa-user me-2"></i>الاسم الأخير
                                        </label>
                                        @error('last_name')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-4">
                                <input style="text-align: right" type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="البريد الإلكتروني" value="{{ old('email') }}">
                                <label for="email" class="text-secondary">
                                    <i class="fas fa-envelope me-2"></i>البريد الإلكتروني
                                </label>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-floating mb-4 ">

                                <input type="password" name="password" id="password" class="form-control"
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

                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select name="sex" id="sex"
                                            class="form-select @error('sex') is-invalid @enderror">
                                            <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>ذكر</option>
                                            <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>أنثى
                                            </option>
                                        </select>
                                        <label for="sex" class="text-secondary">
                                            <i class="fas fa-venus-mars me-2"></i>الجنس
                                        </label>
                                        @error('sex')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <!-- HTML -->
                                        <input type="tel" name="phone" id="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="رقم الهاتف" value="{{ old('phone') }}" maxlength="11">
                                        <label for="phone" class="text-secondary">
                                            <i class="fas fa-phone me-2"></i>رقم الهاتف
                                        </label>

                                        <!-- JavaScript -->
                                            <script>
                                                document.addEventListener("DOMContentLoaded", function() {
                                                    const phoneInput = document.getElementById("phone");
                                                    const form = document.getElementById("registerForm");

                                                    // قناع الإدخال أثناء الكتابة
                                                    phoneInput.addEventListener("input", function(e) {
                                                        let value = e.target.value.replace(/\D/g, ""); // إزالة الأحرف غير الرقمية
                                                        value = value.slice(0, 9); // تحديد الطول بـ 9 أرقام فقط

                                                        // تنسيق: 3 أرقام + مسافة + 3 أرقام + مسافة + 3 أرقام
                                                        let formatted = '';
                                                        if (value.length <= 3) {
                                                            formatted = value;
                                                        } else if (value.length <= 6) {
                                                            formatted = value.slice(0, 3) + ' ' + value.slice(3);
                                                        } else {
                                                            formatted = value.slice(0, 3) + ' ' + value.slice(3, 6) + ' ' + value.slice(6);
                                                        }

                                                        e.target.value = formatted;
                                                    });

                                                    // التحقق عند إرسال النموذج
                                                    form.addEventListener("submit", function(e) {
                                                        const rawValue = phoneInput.value.replace(/\s/g, ""); // إزالة المسافات للتحقق
                                                        const validPrefixes = ["70", "71", "73", "77", "78"];

                                                        if (rawValue.length !== 9 || !validPrefixes.includes(rawValue.substring(0, 2))) {
                                                            e.preventDefault(); // منع الإرسال
                                                            alert("رقم الهاتف يجب أن يتكون من 9 أرقام ويبدأ بـ 70 أو 71 أو 73 أو 77 أو 78");
                                                            phoneInput.focus();
                                                        }
                                                    });
                                                });
                                            </script>

                                        @error('phone')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary auth-header w-100 py-3 rounded-pill fw-bold">
                                <i class="fas fa-user-plus me-2"></i>إنشاء حساب
                            </button>

                            <div class="text-center mt-4">
                                <p class="mb-0">لديك حساب بالفعل؟
                                    <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                        سجل الدخول الآن
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
