@extends('layouts.master_store_admin')
@section('content_admin')
    <div class="container-fluid px-4 py-5">
        <div class="glassmorphism-card mx-auto" style="max-width: 90%;">
            <div class="card-header text-white py-4" id="card-header">
                <h2 class="mb-0 fw-bold">
                    <i class="fas fa-users-cog fa-2x text-white"></i>
                    اضافة موظف جديد
                </h2>
            </div>
            <!-- جسم النموذج مع تخطيط متقدم -->
            <div class="card-body p-4">
                <form action="{{ route('admin.create', ['store_id' => $store->id]) }}" method="POST" id="registerForm" class="needs-validation"
                    novalidate>
                    @csrf
                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                    <!-- شبكة متجاوبة بعرض عمودين لكل حقلين -->
                    <div class="grid-layout">
                        <!-- الاسم الأول -->
                        <div class="floating-input-group">
                            <input type="text" name="first_name"
                                class="form-control modern-input @error('first_name') is-invalid @enderror" placeholder=" "
                                value="{{ old('first_name') }}" required>
                            <label class="floating-label">
                                <i class="fas fa-user me-2"></i>الاسم الأول
                            </label>
                            <div class="invalid-tooltip">
                                @error('first_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <!-- الاسم الأخير -->
                        <div class="floating-input-group">
                            <input type="text" name="last_name"
                                class="form-control modern-input @error('last_name')  is-invalid @enderror" placeholder=" "
                                value="{{ old('last_name') }}" required>
                            <label class="floating-label">
                                <i class="fas fa-user-tag me-2"></i>الاسم الأخير
                            </label>
                            <div class="invalid-tooltip">
                                @error('last_name')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <!-- البريد الإلكتروني -->
                        <div class="floating-input-group">
                            <input type="email" name="email"
                                class="form-control modern-input @error('email') is-invalid @enderror" placeholder=" "
                                value="{{ old('email') }}" required>
                            <label class="floating-label">
                                <i class="fas fa-at me-2"></i>البريد الإلكتروني
                            </label>
                            <div class="invalid-tooltip">
                                @error('email')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="floating-input-group with-eye">
                            <input type="password" name="password"
                                class="form-control modern-input @error('password') is-invalid @enderror" placeholder=" "
                                required>
                            <label class="floating-label">
                                <i class="fas fa-fingerprint me-2"></i>كلمة المرور
                            </label>
                            <div class="invalid-tooltip">
                                @error('password')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>

                        <!-- رقم الجوال -->
                        <div class="floating-input-group with-flag">
                            <div class="input-group">
                                <input type="tel" name="phone" id="phone"
                                    class="form-control modern-input @error('phone') is-invalid @enderror" placeholder=" "
                                    value="{{ old('phone') }}"  required
                                    style="direction: ltr !important;
    text-align: end;" required>
                            </div>
                            <label class="floating-label">
                                <i class="fas fa-mobile-alt me-2"></i>رقم الجوال
                            </label>
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
                                <div class="invalid-tooltip d-block text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- الجنس -->
                        <div class="floating-input-group">
                            <select name="sex" class="form-select modern-select @error('sex') is-invalid @enderror"
                                required>
                                <option value="" disabled {{ old('sex') ? '' : 'selected' }}>يرجى اختيار الجنس
                                </option>
                                <option value="male" {{ old('sex') == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('sex') == 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                            @error('sex')
                                <div class="invalid-tooltip d-block text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <!-- قسم الصلاحيات مع تصميم كروي -->
                    <div class="permissions-section mt-5 {{ $errors->has('permissions') ? 'is-invalid' : '' }}">
                        <h5 class="section-title mb-4">
                            <i class="fas fa-shield-alt me-2"></i>الصلاحيات الممنوحة
                            @error('permissions')
                                <div class="invalid-tooltip d-block text-danger mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </h5>

                        <div class="permissions-grid">
                            @foreach ($permissions as $permission)
                                <div
                                    class="permission-card {{ $errors->has('permissions') ? 'border border-danger rounded' : '' }}">
                                    <input type="checkbox" name="permissions[]" id="perm-{{ $permission->id }}"
                                        value="{{ $permission->id }}" class="permission-checkbox"
                                        {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                    <label for="perm-{{ $permission->id }}" class="permission-label">
                                        <div class="permission-icon">
                                            <i class="{{ $permission->icon }} fa-2x"></i>
                                        </div>
                                        <span class="permission-name">{{ $permission->name }}</span>
                                        <p class="permission-desc">{{ $permission->description }}</p>
                                    </label>
                                </div>
                            @endforeach
                        </div>


                    </div>


                    <!-- زر الحفظ مع تأثيرات متقدمة -->
                    <div class="form-footer mt-5">
                        <button type="submit" class="btn btn-save">
                            <span class="btn-text">حفظ العضو الجديد</span>
                            <i class="fas fa-user-plus btn-icon"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
