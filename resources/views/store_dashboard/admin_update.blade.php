@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container-fluid px-4 py-5">
        <div class="glassmorphism-card mx-auto" style="max-width: 90%;">
            <div class="card-header text-white py-4" id="card-header">
                <h2 class="mb-0 fw-bold">
                    <i class="fas fa-user-edit fa-2x text-white"></i>
                    تعديل بيانات الموظف
                </h2>
            </div>

            <div class="card-body p-4">
                <form action="{{ route('admin.edit',['store_id'=>$store->id]) }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="grid-layout">
                        <!-- الاسم الأول -->
                        <div class="floating-input-group">
                            <input type="text" name="first_name"
                                class="form-control modern-input @error('first_name') is-invalid @enderror" placeholder=" "
                                value="{{ old('first_name', $user->first_name) }}" required>
                            <label class="floating-label">
                                <i class="fas fa-user me-2"></i>الاسم الأول
                            </label>
                            <div class="invalid-tooltip">@error('first_name') {{ $message }} @enderror</div>
                        </div>

                        <!-- الاسم الأخير -->
                        <div class="floating-input-group">
                            <input type="text" name="last_name"
                                class="form-control modern-input @error('last_name') is-invalid @enderror" placeholder=" "
                                value="{{ old('last_name', $user->last_name) }}" required>
                            <label class="floating-label">
                                <i class="fas fa-user-tag me-2"></i>الاسم الأخير
                            </label>
                            <div class="invalid-tooltip">@error('last_name') {{ $message }} @enderror</div>
                        </div>

                        <!-- البريد الإلكتروني -->
                        <div class="floating-input-group">
                            <input type="email" name="email"
                                class="form-control modern-input @error('email') is-invalid @enderror" placeholder=" "
                                value="{{ old('email', $user->email) }}" required>
                            <label class="floating-label">
                                <i class="fas fa-at me-2"></i>البريد الإلكتروني
                            </label>
                            <div class="invalid-tooltip">@error('email') {{ $message }} @enderror</div>
                        </div>

                        <!-- كلمة المرور -->
                        <div class="floating-input-group with-eye">
                            <input type="password" name="password"
                                class="form-control modern-input @error('password') is-invalid @enderror" placeholder=" ">
                            <label class="floating-label">
                                <i class="fas fa-fingerprint me-2"></i>كلمة المرور (اتركها فارغة إذا لم ترغب في تغييرها)
                            </label>
                            <div class="invalid-tooltip">@error('password') {{ $message }} @enderror</div>
                        </div>

                        <!-- رقم الجوال -->
                        <div class="floating-input-group with-flag">
                            <input type="tel" name="phone"
                                class="form-control modern-input @error('phone') is-invalid @enderror" placeholder=" "
                                value="{{ old('phone', $user->phone) }}" pattern="[5-7]{1}[0-9]{7}" required>
                            <label class="floating-label">
                                <i class="fas fa-mobile-alt me-2"></i>رقم الجوال
                            </label>
                            @error('phone')
                                <div class="invalid-tooltip d-block text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الجنس -->
                        <div class="floating-input-group">
                            <select name="sex" class="form-select modern-select @error('sex') is-invalid @enderror" required>
                                <option value="" disabled>اختر الجنس</option>
                                <option value="male" {{ old('sex', $user->sex) == 'male' ? 'selected' : '' }}>ذكر</option>
                                <option value="female" {{ old('sex', $user->sex) == 'female' ? 'selected' : '' }}>أنثى</option>
                            </select>
                            @error('sex')
                                <div class="invalid-tooltip d-block text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                       
                    </div>

                    <!-- الصلاحيات -->
                    <div class="permissions-section mt-5 {{ $errors->has('permissions') ? 'is-invalid' : '' }}">
                        <h5 class="section-title mb-4">
                            <i class="fas fa-shield-alt me-2"></i>الصلاحيات الممنوحة
                            @error('permissions')
                                <div class="invalid-tooltip d-block text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </h5>

                        <div class="permissions-grid">
                            @foreach ($permissions as $permission)
                                <div class="permission-card {{ $errors->has('permissions') ? 'border border-danger rounded' : '' }}">
                                    <input type="checkbox" name="permissions[]" id="perm-{{ $permission->id }}"
                                        value="{{ $permission->id }}" class="permission-checkbox"
                                        {{ in_array($permission->id, old('permissions', $storeManagement->pluck('permission_id')->toArray())) ? 'checked' : '' }}>
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

                    <!-- زر الحفظ -->
                    <div class="form-footer mt-5">
                        <button type="submit" class="btn btn-save">
                            <span class="btn-text">حفظ التعديلات</span>
                            <i class="fas fa-save btn-icon"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
