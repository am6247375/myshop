@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <!-- Card Header -->
            <div class="card-header bg-gradient-primary text-white py-4" id="card-header">
                <h2 class="mb-0 fw-bold">
                    <i class="fas fa-sliders-h me-2"></i>
                    إدارة إعدادات المتجر
                </h2>
            </div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs settings-tabs px-3 pt-3" id="settingsTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#general" type="button">
                        <i class="fas fa-cogs me-2"></i>
                        الإعدادات العامة
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#contact" type="button">
                        <i class="fas fa-headset me-2"></i>
                        معلومات الدعم الفني
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#aboutt" type="button">
                        <i class="fas fa-info-circle me-2"></i>
                        نبذة المتجر
                    </button>
                </li>
            </ul>

            <!-- Form Container -->
            <div class="card-body px-4">
                <form action="{{ route('store.settings') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                    <!-- Tab Contents -->
                    <div class="tab-content mt-4">
                        <!-- General Settings Tab -->
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="settings-section">
                                <div class="row g-4">
                                    <!-- العمود الأيسر - المعلومات الأساسية -->
                                    <div class="col-md-7">
                                        <!-- اسم المتجر -->
                                        <div class="card config-card mb-4">
                                            <div class="card-header bg-light">
                                                <div class="form-group mb-4">
                                                    <h5 class="mb-0">
                                                        <i class="fas fa-store me-2 text-primary"></i>
                                                        اسم المتجر الرسمي
                                                    </h5>
                                                </div>
                                                <input type="text" name="name"
                                                    class="form-control form-control-lg border-primary"
                                                    value="{{ old('name', $store->name) }}" required>
                                            </div>
                                        </div>


                                        <!-- العملة -->
                                        <div class="card config-card mb-4">
                                            <div class="card-header bg-light">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-coins me-2 text-warning"></i>
                                                    العملة الأساسية
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <select name="currency_id" class="form-select" required>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}"
                                                            {{ $store->currency_id == $currency->id ? 'selected' : '' }}>
                                                            {{ $currency->name }} ({{ $currency->code }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <!-- اللغات -->
                                        <div class="card config-card">
                                            <div class="card-header bg-light">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-globe me-2 text-success"></i>
                                                    اللغات المدعومة
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                @foreach ($languages as $language)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="languages[]"
                                                            value="{{ $language->id }}"
                                                            {{ in_array($language->id, $store->languages->pluck('id')->toArray()) ? 'checked' : '' }}>
                                                        <label class="form-check-label">
                                                            {{ $language->name }} ({{ $language->code }})
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <!-- العمود الأيمن - الشعار -->
                                    <div class="col-md-5">
                                        <div class="card config-card">

                                            <div class="card-header bg-light">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-camera-retro me-2 text-success"></i>
                                                    شعار المتجر
                                                </h5>
                                            </div>
                                            <div class="logo-uploader card border-2 border-dashed border-primary-hover">
                                                <div class="card-body p-3 text-center">
                                                    <div id="logoPreviewContainer" class="position-relative mb-3">
                                                        @if ($store->logo)
                                                            <div class="logo-preview-wrapper">
                                                                <img src="{{ asset($store->logo) }}"
                                                                    class="store-logo-preview img-thumbnail rounded"
                                                                    alt="شعار المتجر">
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm position-absolute top-0 end-0 m-1 shadow"
                                                                    onclick="removeLogo()" title="حذف الشعار">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        @else
                                                            <div class="upload-placeholder" onclick="triggerUpload()">
                                                                <div
                                                                    class="store-logo-placeholder d-flex flex-column align-items-center justify-content-center">
                                                                    <i
                                                                        class="fas fa-cloud-upload-alt fa-3x text-muted mb-2"></i>
                                                                    <span class="text-muted">اختر صورة الشعار</span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <input type="file" name="logo" id="logoInput"
                                                        class="form-control d-none" accept="image/*"
                                                        onchange="previewLogo(event)">
                                                    <input type="hidden" name="delete_logo" id="deleteLogo"
                                                        value="0">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Contact Information Tab -->
                        <div class="tab-pane fade" id="contact" role="tabpanel">
                            <h5 class="mb-5">أضف معلومات الاتصال حتى يتمكن الأشخاص من التواصل معك.
                            </h5>
                            <div class="settings-section">
                                <div class="row g-4">

                                    <!-- WhatsApp -->
                                    <div class="col-md-6">
                                        <div class="card contact-card">
                                            <div class="card-header bg-light">
                                                <h5 class="mb-0">
                                                    <i class="fab fa-whatsapp me-2 text-success"></i>
                                                    رقم الواتساب الخاص بالدعم
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-phone"></i>
                                                    </span>
                                                    <input type="tel" name="whatsapp_link" class="form-control"
                                                        value="{{ old('whatsapp_link', $store->whatsapp_link) }}"
                                                        placeholder="أدخل رقم الواتساب">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-6">
                                        <div class="card contact-card">
                                            <div class="card-header bg-light">
                                                <h5 class="mb-0">
                                                    <i class="fas fa-envelope me-2 text-danger"></i>
                                                    البريد الإلكتروني
                                                </h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-at"></i>
                                                    </span>
                                                    <input type="email" name="email_link" class="form-control"
                                                        value="{{ old('email_link', $store->email_link) }}"
                                                        placeholder="أدخل البريد الإلكتروني">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- About Store Tab -->
                        <div class="tab-pane fade" id="aboutt" role="tabpanel">
                            <div class="settings-section">
                                <div class="card about-card">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-info-circle me-2 text-info"></i>
                                            قم بإضافة وصف لمتجرك
                                            اجعل زوار متجرك يعرفون عن المتجر أكثر
                                        </h5>
                                    </div>
                                    <div class="card-body position-relative">
                                        <textarea name="about" id="about" class="form-control auto-expand" rows="6"
                                            placeholder="أدخل نص وصف لمتجرك هنا..." maxlength="2000">{{ old('about', $store->about) }}</textarea>
                                        <div class="char-counter text-muted">
                                            <span id="charCountabout">0</span>/2000
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <button type="button" onclick="fillDefault('about')"
                                            class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-magic me-2"></i>
                                            استخدام النص الافتراضي
                                        </button>
                                    </div>
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
