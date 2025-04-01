@extends('layouts.master_store_admin')

@section('content_admin')
<style>
    .form-section {
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        padding: 2rem;
    }
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: block;
    }
    .input-field {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ced4da;
        padding-bottom: 0.5rem;
        margin-bottom: 0.5rem;
    }
    .input-field i {
        color: #17a2b8;
        font-size: 1.1rem;
        margin-right: 0.75rem;
        width: 1.5rem;
        text-align: center;
    }
    .form-control-custom {
        border: none;
        background: transparent;
        padding: 0.375rem 0;
        flex-grow: 1;
    }
    .form-control-custom:focus {
        outline: none;
        box-shadow: none;
    }
    .form-select-custom {
        border: none;
        background: transparent;
        padding: 0.375rem 0;
        width: 100%;
    }
    .form-select-custom:focus {
        outline: none;
        box-shadow: none;
    }
    .permissions-container {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .permission-item {
        flex: 0 0 calc(50% - 0.5rem);
        padding: 0.5rem 0;
    }
   
    .btn-submit {
        background-color: #28a745;
        color: white;
        padding: 0.5rem 2rem;
        border-radius: 0.25rem;
        font-weight: 600;
    }
    .btn-submit:hover {
        background-color: #218838;
    }
    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
    }
    .header-card {
        background: linear-gradient(135deg, #17a2b8 0%, #1abc9c 100%);
        border-radius: 0.5rem 0.5rem 0 0 !important;
    }
</style>
<div class="container-fluid py-4">
    <div class="card border-0 shadow-lg">
        <!-- Header with Gradient Background -->
        <div class="card-header header-card text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h5 fw-bold mb-0">
                    <i class="fas fa-user-edit me-2"></i> تعديل بيانات العضو
                </h2>
            </div>
        </div>

        <!-- Form Content -->
        <div class="card-body form-section">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-exclamation-triangle me-3"></i>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('admin.edit') }}" method="POST" class="needs-validation" novalidate>
                @csrf
               

                <input type="hidden" name="store_id" value="{{ $store->id }}">
                <input type="hidden" name="user_id" value="{{ $user->id }}">

                <div class="row g-3">
                    <!-- First Name -->
                    <div class="col-md-6">
                        <label class="form-label">الاسم الأول</label>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="first_name"
                                class="form-control-custom @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name', $user->first_name) }}" required>
                        </div>
                        @error('first_name')
                           <span>{{$message}}</span>
                        @enderror
                    </div>

                    <!-- Last Name -->
                    <div class="col-md-6">
                        <label class="form-label">الاسم الأخير</label>
                        <div class="input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" name="last_name"
                                class="form-control-custom @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name', $user->last_name) }}" required>
                        </div>
                        @error('last_name')
                           <span>{{$message}}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <label class="form-label">البريد الإلكتروني</label>
                        <div class="input-field">
                            <i class="fas fa-at"></i>
                            <input type="email" name="email"
                                class="form-control-custom @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                        </div>
                        @error('email')
                           <span>{{$message}}</span>
                        @enderror
                    </div>

                    <!-- Password (اختياري) -->
                    <div class="col-md-6">
                        <label class="form-label">كلمة المرور (اتركها فارغة إذا لم ترغب في تغييرها)</label>
                        <div class="input-field">
                            <i class="fas fa-key"></i>
                            <input type="password" name="password" class="form-control-custom"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div class="col-md-6">
                        <label class="form-label">رقم الجوال</label>
                        <div class="input-field">
                            <span style="color: #17a2b8; margin-right: 0.75rem;">+967</span>
                            <input type="tel" name="phone"
                                class="form-control-custom @error('phone') is-invalid @enderror"
                                value="{{ old('phone', $user->phone) }}" required>
                        </div>
                        @error('phone')
                           <span>{{$message}}</span>
                        @enderror
                    </div>

                    <!-- Gender -->
                    <div class="col-md-6">
                        <label class="form-label">الجنس</label>
                        <div class="input-field">
                            <i class="fas fa-venus-mars"></i>
                            <select name="sex" class="form-select-custom" required>
                                <option value="male" {{ old('sex', $user->sex) == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('sex', $user->sex) == 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                        </div>
                    </div>

                    <!-- Role Selection -->
                    <div class="col-md-6">
                        <label class="form-label">الدور الوظيفي</label>
                        <div class="input-field">
                            <i class="fas fa-user-shield"></i>
                            <select name="role_id" class="form-select-custom" required>
                                @foreach ($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        @error('role_id')
                           <span>{{$message}}</span>
                        @enderror
                    </div>

                    <!-- Permissions -->
                    <div class="col-12">
                        <label class="form-label">الصلاحيات</label>
                        <div class="input-field">
                            <i class="fas fa-user-shield"></i>
                            <div class="w-100 permissions-container">
                                @foreach ($permissions as $permission)
                                <div class="permission-item">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="permissions[]" 
                                            value="{{ $permission->id }}" id="perm-{{ $permission->id }}"
                                            {{ in_array($permission->id, old('permissions', $storeManagement->pluck('permission_id')->toArray())) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm-{{ $permission->id }}">
                                            <span class="fw-medium">{{ $permission->name }}</span>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                            
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-submit">
                        <i class="fas fa-save me-2"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
