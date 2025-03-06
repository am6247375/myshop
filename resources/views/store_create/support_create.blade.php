@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <!-- Card Header -->
            <div class="card-header bg-gradient-primary text-white py-4">
                <h2 class="mb-0 fw-bold">
                    <i class="fas fa-headset me-2"></i>
                    إعدادات الدعم ووصف المتجر
                </h2>
            </div>

            <!-- Tabs Navigation -->
            <ul class="nav nav-tabs policy-tabs px-3 pt-3" id="supportTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#contact" type="button">
                        <i class="fas fa-phone-alt me-2"></i>
                        معلومات الاتصال
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#aboutt" type="button">
                        <i class="fas fa-info-circle me-2"></i>
                        نبذة عن المتجر
                    </button>
                </li>
            </ul>

            <!-- Form Container -->
            <div class="card-body px-4">
                <form action="{{ route('support.create', $store->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                    <input type="hidden" name="previous_url" value="{{ url()->previous() }}">

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
                        <!-- Contact Tab -->
                        <div class="tab-pane fade show active" id="contact">
                            <div class="row g-4 mb-5">
                                <!-- WhatsApp Card -->
                                <div class="col-md-6">
                                    <div class="policy-card card h-100">
                                        <div class="card-header bg-light">
                                            <h4 class="mb-0">
                                                <i class="fab fa-whatsapp me-2 text-success"></i>
                                                اتصال الواتساب
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-floating">
                                                <input type="tel" id="whatsapp_link" name="whatsapp_link"
                                                    class="form-control @error('whatsapp_link') is-invalid @enderror"
                                                    value="{{ old('whatsapp_link', $store->whatsapp_link) }}"
                                                    placeholder=" "
                                                    pattern="^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$">
                                                <label for="whatsapp_link">رقم الواتساب للدعم الفني</label>
                                                @error('whatsapp_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Card -->
                                <div class="col-md-6">
                                    <div class="policy-card card h-100">
                                        <div class="card-header bg-light">
                                            <h4 class="mb-0">
                                                <i class="fas fa-envelope me-2 text-danger"></i>
                                                البريد الإلكتروني
                                            </h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-floating">
                                                <input type="email" id="email_link" name="email_link"
                                                    class="form-control @error('email_link') is-invalid @enderror"
                                                    value="{{ old('email_link', $store->email_link) }}" placeholder=" ">
                                                <label for="email_link">بريد الدعم الفني</label>
                                                @error('email_link')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- About Tab -->
                        <div class="tab-pane fade" id="aboutt">
                            <div class="policy-card card mb-5">
                                <div class="card-header bg-light">
                                    <h4 class="mb-0">
                                        <i class="fas fa-info-circle me-2 text-info"></i>
                                        نبذة عن المتجر
                                    </h4>
                                </div>
                                <div class="card-body position-relative">
                                    <textarea name="about" id="about" class="form-control auto-expand" rows="6"
                                        maxlength="2000">{{ old('about', $store->about) }}</textarea>
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

                    <!-- Sticky Save Button -->
                    <div class="sticky-save">
                        <button type="submit" class="btn btn-success btn-lg w-100 shadow">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        window.StoreName = "{{ $store->name }}";
    </script>
    <style>
     
    </style>
@endsection
