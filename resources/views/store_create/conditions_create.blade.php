@extends('layouts.master_store_admin')

@section('content_admin')
<div class="container py-5">
    <div class="card shadow-lg border-0">
        <!-- Card Header -->
        <div class="card-header bg-gradient-primary text-white py-4">
            <h2 class="mb-0 fw-bold">
                <i class="fas fa-cogs me-2"></i>
                إدارة سياسات المتجر
            </h2>
        </div>

        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs policy-tabs px-3 pt-3" id="policyTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#privacy" type="button">
                    <i class="fas fa-user-shield me-2"></i>
                    الخصوصية
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#terms" type="button">
                    <i class="fas fa-balance-scale-left me-2"></i>
                    الشروط
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#returns" type="button">
                    <i class="fas fa-undo-alt me-2"></i>
                    الاسترجاع
                </button>
            </li>
        </ul>

        <!-- Form Container -->
        <div class="card-body px-4">
            <form action="{{ route('conditions.create', $store->id) }}" method="POST">
                @csrf
                <input type="hidden" name="store_id" value="{{ $store->id }}">

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

                <!-- Tab Contents -->
                <div class="tab-content mt-4">
                    <!-- Privacy Policy Tab -->
                    <div class="tab-pane fade show active" id="privacy">
                        <div class="policy-card card mb-4">
                            <div class="card-header bg-light">
                                <h4 class="mb-0">
                                    <i class="fas fa-file-contract me-2"></i>
                                    سياسة الخصوصية
                                </h4>
                            </div>
                            <div class="card-body position-relative">
                                <textarea name="privacy_policy" id="privacy_policy" class="form-control auto-expand" rows="6"
                                    placeholder="أدخل نص سياسة الخصوصية هنا..." maxlength="2000">{{ old('privacy_policy', $store->privacy_policy) }}</textarea>
                                <div class="char-counter text-muted">
                                    <span id="charCountPrivacy">0</span>/2000
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button type="button" onclick="fillDefault('privacy_policy')"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-magic me-2"></i>
                                    استخدام النص الافتراضي
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Terms & Conditions Tab -->
                    <div class="tab-pane fade" id="terms">
                        <div class="policy-card card mb-4">
                            <div class="card-header bg-light">
                                <h4 class="mb-0">
                                    <i class="fas fa-gavel me-2"></i>
                                    الشروط والأحكام
                                </h4>
                            </div>
                            <div class="card-body position-relative">
                                <textarea name="terms_and_conditions" id="terms_and_conditions" class="form-control auto-expand" rows="6"
                                    placeholder="أدخل نص الشروط والأحكام هنا..." maxlength="2000">{{ old('terms_and_conditions', $store->terms_and_conditions) }}</textarea>
                                <div class="char-counter text-muted">
                                    <span id="charCountTerms">0</span>/2000
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button type="button" onclick="fillDefault('terms_and_conditions')"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-magic me-2"></i>
                                    استخدام النص الافتراضي
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Return Policy Tab -->
                    <div class="tab-pane fade" id="returns">
                        <div class="policy-card card mb-4">
                            <div class="card-header bg-light">
                                <h4 class="mb-0">
                                    <i class="fas fa-truck-loading me-2"></i>
                                    سياسة الاسترجاع
                                </h4>
                            </div>
                            <div class="card-body position-relative">
                                <textarea name="return__policy" id="return__policy" class="form-control auto-expand" rows="6"
                                    placeholder="أدخل نص سياسة الاسترجاع هنا..." maxlength="2000">{{ old('return__policy', $store->return__policy) }}</textarea>
                                <div class="char-counter text-muted">
                                    <span id="charCountReturn">0</span>/2000
                                </div>
                            </div>
                            <div class="card-footer bg-transparent">
                                <button type="button" onclick="fillDefault('return__policy')"
                                  class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-magic me-2"></i>
                                    استخدام النص الافتراضي
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sticky Save Button -->
                <div class="sticky-save">
                    <button type="submit" class="btn btn-success btn-lg w-100 shadow">
                        <i class="fas fa-save me-2"></i>
                        حفظ جميع التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.StoreName = "{{ $store->name }}";
    
</script>

@endsection
