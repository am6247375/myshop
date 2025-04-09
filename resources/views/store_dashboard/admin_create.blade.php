@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container-fluid px-4 py-5">
        <div class="glassmorphism-card mx-auto" style="max-width: 800px;">
            <!-- الهيدر مع تأثير الزجاج المضيء -->
            <div class="card-header glassmorphism-header p-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="icon-wrapper bg-primary p-2 rounded-circle">
                        <i class="fas fa-users-cog fa-2x text-white"></i>
                    </div>
                    <h1 class="mb-0 fw-bold text-primary">إدارة أعضاء الفريق</h1>
                </div>
            </div>

            <!-- جسم النموذج مع تخطيط متقدم -->
            <div class="card-body p-4">
                <form action="{{ route('admin.create') }}" method="POST" class="needs-validation" novalidate>
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
                                class="form-control modern-input @error('last_name') is-invalid @enderror" placeholder=" "
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

                        <!-- كلمة المرور -->
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
                                <input type="tel" name="phone"
                                    class="form-control modern-input @error('phone') is-invalid @enderror" placeholder=" "
                                    value="{{ old('phone') }}" pattern="[5-7]{1}[0-9]{7}" required>
                            </div>
                            <label class="floating-label">
                                <i class="fas fa-mobile-alt me-2"></i>رقم الجوال
                            </label>
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

                        <div class="floating-input-group">
                            <select name="role_id" class="form-select modern-select @error('role_id') is-invalid @enderror"
                                required>
                                <option value="" disabled {{ old('role_id') ? '' : 'selected' }}>يرجى اختيار الدور
                                    الوظيفي</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
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
                                <div class="permission-card {{ $errors->has('permissions') ? 'border border-danger rounded' : '' }}">
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


    <!-- CSS مع اللمسات النهائية -->
    <style>
        :root {
            --primary-color: #2A5C82;
            --secondary-color: #3A86FF;
            --accent-color: #FFBE0B;
            --glass-bg: rgba(255, 255, 255, 0.9);
            --shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* تأثير الزجاج المضيء */
        .glassmorphism-card {
            background: var(--glass-bg);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow);
            overflow: hidden;
        }

        .glassmorphism-header {
            background: linear-gradient(135deg, rgba(42, 92, 130, 0.9) 0%, rgba(58, 134, 255, 0.8) 100%) !important;
            border-bottom: 2px solid rgba(255, 255, 255, 0.1);
        }

        /* شبكة العرض بحيث يظهر حقلان في كل صف */
        .grid-layout {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .grid-layout {
                grid-template-columns: 1fr;
            }
        }

        /* أنماط الحقول بنظام الإدخال العائم */
        .floating-input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .modern-input {
            height: 56px;
            width: 100%;
            border: 2px solid #e0e0e0 !important;
            border-radius: 12px !important;
            padding: 1rem 1.5rem !important;
            background: transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modern-input:focus,
        .modern-input:not(:placeholder-shown) {
            border-color: var(--secondary-color) !important;
            box-shadow: 0 4px 12px rgba(58, 134, 255, 0.2);
        }

        .floating-label {
            position: absolute;
            top: 18px;
            right: 1.5rem;
            color: #666;
            pointer-events: none;
            background: var(--glass-bg);
            padding: 0 0.5rem;
            transition: all 0.3s;
        }

        .modern-input:focus~.floating-label,
        .modern-input:not(:placeholder-shown)~.floating-label {
            top: -10px;
            right: 1rem;
            font-size: 0.875rem;
            color: var(--secondary-color);
        }

        /* تنسيق select بنفس أسلوب الإدخال */
        .modern-select {
            height: 56px;
            width: 100%;
            border: 2px solid #e0e0e0 !important;
            border-radius: 12px !important;
            padding: 1rem 1.5rem !important;
            background: transparent;
            transition: all 0.3s;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .modern-select:focus {
            border-color: var(--secondary-color) !important;
            box-shadow: 0 4px 12px rgba(58, 134, 255, 0.2);
        }

        /* التحقق من صحة الحقول (Tooltips) */
        .invalid-tooltip {
            position: absolute;
            right: 1rem;
            bottom: -22px;
            font-size: 0.85rem;
            color: #dc3545;
            background: rgba(220, 53, 69, 0.1);
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            z-index: 10;
        }

        /* قسم الصلاحيات */
        .permissions-section {
            margin-top: 2rem;
        }

        .permissions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 1rem;
        }

        .permission-card {
            position: relative;
            border: 2px solid #eee;
            border-radius: 16px;
            padding: 1.5rem;
            transition: all 0.3s;
            cursor: pointer;
        }

        .permission-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(58, 134, 255, 0.15);
        }

        .permission-label {
            display: block;
            border: 2px solid transparent;
            border-radius: 12px;
            padding: 1rem;
            transition: all 0.3s;
            position: relative;
        }

        .permission-checkbox:checked+.permission-label {
            border-color: var(--secondary-color);
            background: rgba(58, 134, 255, 0.05);
        }

        .permission-icon {
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }

        .permission-name {
            font-weight: bold;
            color: #333;
        }

        .permission-desc {
            font-size: 0.85rem;
            color: #666;
        }

        /* زر الحفظ مع تأثيرات متقدمة */
        .btn-save {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            color: white;
            font-weight: 600;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s;
            overflow: hidden;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(58, 134, 255, 0.3);
        }

        .btn-icon {
            font-size: 1.2rem;
        }

        /* حركة ظهور النموذج */
        .card-body {
            animation: fadeInUp 0.8s;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: none;
            }
        }
    </style>
@endsection
