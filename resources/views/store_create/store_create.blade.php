@extends('layouts.master')
@section('content')
    <div class="container" style="margin-top: 77px;">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="store-card shadow-lg rounded-4 overflow-hidden">
                    <div class="store-header bg-primary text-white text-center py-4">
                        <h2 class="mb-2 fw-bold">إنشاء متجر جديد</h2>
                        <p class="mb-0">املأ التفاصيل لإنشاء متجرك الإلكتروني</p>
                    </div>
                    <div class="store-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('store.create') }}" method="POST" enctype="multipart/form-data"
                            id="storeForm">
                            @csrf
                            <input type="hidden" name="template_id" value="{{ $template_id }}">
                            <input type="hidden" name="owner_id" value="{{ Auth::user()->id }}">
                            <!-- اسم المتجر -->
                            <div class="form-floating mb-4">
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="اسم المتجر" required>
                                <label for="name"><i class="fas fa-store me-2"></i>اسم المتجر</label>
                                <small class="form-text text-muted">يجب أن يكون الاسم فريدًا ويمثل علامتك التجارية</small>
                                @error('name')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <!-- اللغات والعملة -->
                                <div class=" mb-3 " >
                                    <label class="form-label fw-bold"> <i class="material-icons">translate</i>اللغات
                                        المدعومة</label>
                                    <div class="bg-light p-3 rounded-3">
                                        @foreach ($languages as $language)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="languages[]"
                                                    value="{{ $language->id }}" id="language_{{ $language->id }}">
                                                <label class="form-check-label" for="language_{{ $language->id }}">
                                                    {{ $language->name }} <span
                                                        class="text-muted">({{ $language->code }})</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('languages')
                                        <div class="invalid-feedback d-block">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class=" mb-4 ">
                                    <label class="form-label fw-bold"><i class="fas fa-money-bill-wave me-2"></i> العملات
                                        المدعومة</label>
                                    <div class="form-floating">
                                        <select name="currency" id="currency" class="form-select" required>
                                            <option value="SAR">🇸🇦 الريال السعودي</option>
                                            <option value="USD">🇺🇸 الدولار الأمريكي</option>
                                            <option value="YER" selected>🇾🇪 الريال اليمني</option>
                                        </select>
                                        <label for="currency"><i class="fas fa-money-bill-wave me-2"></i>العملة</label>
                                        <small class="form-text text-muted">يمكن تغيير العملة لاحقًا من الإعدادات</small>
                                        @error('currency')
                                            <div class="invalid-feedback d-block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            <!-- زر الإرسال -->
                            <button type="submit" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">
                                <i class="fas fa-plus-circle me-2"></i>إنشاء المتجر
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
