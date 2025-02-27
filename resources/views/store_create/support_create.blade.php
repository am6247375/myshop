@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container py-5">
        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0">
                    <i class="fas fa-cog me-2"></i>
                    إعدادات الدعم الفني و وصف المتجر
                </h3>
            </div>

            <div class="card-body">
                <form action="{{ route('support.create', $store->id) }}" method="POST">
                    @csrf
            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
            <input type="text" name="store_id" value="{{ $store->id  }}" hidden>

                    <div class="row g-4">
                        <!-- اتصال الواتساب -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="tel" id="whatsapp_link" name="whatsapp_link"
                                    class="form-control @error('whatsapp_link') is-invalid @enderror"
                                    value="{{ old('whatsapp_link', $store->whatsapp_link) }}" placeholder=" "
                                    pattern="^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$">
                                <label for="whatsapp_link">
                                    <i class="fab fa-whatsapp me-2"></i>
                                     رقم الواتساب الخاص بالدعم الفني
                                                                </label>
                                @error('whatsapp_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- البريد الإلكتروني -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="email" id="email_link" name="email_link"
                                    class="form-control @error('email_link') is-invalid @enderror"
                                    value="{{ old('email_link', $store->email_link) }}" placeholder=" ">
                                <label for="email_link">
                                    <i class="fas fa-envelope me-2"></i>
                                    البريد الإلكتروني  رقم الواتساب الخاص بالدعم الفني
                                </label>
                                @error('email_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- نبذة عن المتجر -->
                        <div class="col-12">
                            <div class="form-floating">
                                <textarea id="about" name="about" class="form-control @error('about') is-invalid @enderror" placeholder=" "
                                    style="height: 150px" maxlength="500">{{ old('about', $store->about) }}</textarea>
                                <label for="about">
                                    <i class="fas fa-info-circle me-2"></i>
                                    نبذة عن المتجر
                                </label>
                                <div class="form-text text-muted text-end">
                                    <span id="charCount">0</span>/500 حرف
                                </div>
                                @error('about')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- أزرار التحكم -->
                    <div class="mt-5 d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-primary" onclick="fillDefaultAbout()">
                            <i class="fas fa-magic me-2"></i>
                            استخدام النص الافتراضي
                        </button>

                        <button type="submit" class="btn btn-success px-5">
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
@endsection
