@extends('layouts.master_store_admin')

@section('content_admin')
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <!-- Card Header -->
        <div class="card-header bg-gradient-primary text-white py-4">
            <h2 class="mb-0 fw-bold">
                <i class="fas fa-user-plus me-2"></i>
                إنشاء موظف جديد
            </h2>
        </div>

        <!-- Form Container -->
        <div class="card-body px-4">
            <form action="{{ route('admin.create', ['store_id' => $store->id]) }}" method="POST">
                @csrf
                
                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Personal Info Section -->
                <div class="policy-card card mb-4">
                    <div class="card-header bg-light">
                        <h4 class="mb-0">
                            <i class="fas fa-id-card me-2"></i>
                            المعلومات الشخصية
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="first_name" id="first_name"
                                        class="form-control @error('first_name') is-invalid @enderror"
                                        placeholder="الاسم الأول" required>
                                    <label for="first_name" class="text-secondary">
                                        <i class="fas fa-signature me-2"></i>
                                        الاسم الأول
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="text" name="last_name" id="last_name"
                                        class="form-control @error('last_name') is-invalid @enderror"
                                        placeholder="الاسم الأخير" required>
                                    <label for="last_name" class="text-secondary">
                                        <i class="fas fa-signature me-2"></i>
                                        الاسم الأخير
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="البريد الإلكتروني" required>
                                    <label for="email" class="text-secondary">
                                        <i class="fas fa-at me-2"></i>
                                        البريد الإلكتروني
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        placeholder="كلمة المرور" required>
                                    <label for="password" class="text-secondary">
                                        <i class="fas fa-lock me-2"></i>
                                        كلمة المرور
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact & Role Section -->
                <div class="policy-card card mb-4">
                    <div class="card-header bg-light">
                        <h4 class="mb-0">
                            <i class="fas fa-user-cog me-2"></i>
                            إعدادات الحساب
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="tel" name="phone" id="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="رقم الهاتف" required>
                                    <label for="phone" class="text-secondary">
                                        <i class="fas fa-mobile-alt me-2"></i>
                                        رقم الهاتف
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="sex" id="sex" 
                                        class="form-select @error('sex') is-invalid @enderror" required>
                                        <option value="male">ذكر</option>
                                        <option value="female">أنثى</option>
                                    </select>
                                    <label for="sex" class="text-secondary">
                                        <i class="fas fa-venus-mars me-2"></i>
                                        الجنس
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="role_id" id="role_id" 
                                        class="form-select @error('role_id') is-invalid @enderror" required>
                                        <option value="">اختر الدور</option>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="role_id" class="text-secondary">
                                        <i class="fas fa-user-tag me-2"></i>
                                        الدور الوظيفي
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <select name="permissions[]" id="permissions" 
                                        class="form-select @error('permissions') is-invalid @enderror" 
                                        multiple="multiple" required
                                        style="height: 150px">
                                        @foreach ($permissions as $permission)
                                            <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                        @endforeach
                                    </select>
                                    <label for="permissions" class="text-secondary">
                                        <i class="fas fa-key me-2"></i>
                                        الصلاحيات الممنوحة
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Save Button -->
                <div class="sticky-save">
                    <button type="submit" class="btn btn-success btn-lg w-100 shadow">
                        <i class="fas fa-save me-2"></i>
                        حفظ الموظف الجديد
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .policy-card {
        border: 1px solid rgba(0,0,0,0.1);
        border-radius: 15px;
        overflow: hidden;
    }

    .form-floating label {
        transition: all 0.3s ease;
        right: auto !important;
        left: 0;
    }

    .form-control:focus~label,
    .form-control:not(:placeholder-shown)~label {
        transform: translateY(-1.5rem) scale(0.85);
        opacity: 0.8;
    }

    select[multiple] {
        min-height: 150px;
        padding: 10px 0;
    }

    select[multiple] option {
        padding: 8px 15px;
        border-bottom: 1px solid #eee;
        transition: all 0.3s;
    }

    select[multiple] option:hover {
        background: #f8f9fa !important;
    }

    select[multiple] option:checked {
        background: #e9ecef !important;
        font-weight: bold;
    }

    .sticky-save {
        position: sticky;
        bottom: 20px;
        background: white;
        padding: 15px 0;
        margin-top: 20px;
        z-index: 1000;
    }
</style>

<script>
    // Auto-expand textareas
    document.querySelectorAll('.auto-expand').forEach(element => {
        element.addEventListener('input', () => {
            element.style.height = 'auto';
            element.style.height = element.scrollHeight + 'px';
        });
    });

    // Character counter
    document.querySelectorAll('textarea').forEach(textarea => {
        const counterId = textarea.id.replace('_policy', '');
        const counter = document.querySelector(`#charCount${counterId.charAt(0).toUpperCase() + counterId.slice(1)}`);
        
        textarea.addEventListener('input', () => {
            counter.textContent = textarea.value.length;
        });
    });
</script>
@endsection