@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container-fluid px-4 py-5">
        <div class="glassmorphism-card mx-auto" style="max-width: 90%;">
            <div class="card-header text-white py-4" id="card-header">
                <h2 class="mb-0 fw-bold">
                    <i class="fas fa-box fa-2x text-white"></i>
                    إضافة قسم جديد
                </h2>
            </div>

            <form action="{{ route('category.create',['store_id'=> $store->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                <input type="hidden" name="store_id" value="{{ $store->id }}">

                <div class="">
                    <!-- صورة القسم -->
                    <div class="form-group text-center">
                        <input type="file" class="d-none" id="image" name="image" accept="image/*"
                            onchange="previewImage(event, 'currentImage')">
                        <div class="image-preview mt-3">
                            <img id="currentImage" src="{{ asset(old('image', 'default-placeholder.png')) }}"
                                alt="إضافة صورة" class="img-thumbnail" style="height: 100px;">
                        </div>
                        <label for="image" class="btn btn-success mt-2">اختيار صورة</label>
                        <div>
                            <span class="text-danger" style=" right: 1rem;">
                                @error('image')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>

                    <!-- اسم القسم -->
                    <div class="floating-input-group ">
                        <input type="text" name="name"
                            class="form-control modern-input @error('name') is-invalid @enderror" placeholder=" "
                            value="{{ old('name') }}">
                        <label class="floating-label">
                            <i class="fas fa-tags me-2"></i>اسم القسم
                        </label>
                        <div style="text-align: center">
                            <span class="text-danger" style=" ">
                                @error('name')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>


                    <!-- وصف القسم -->
                    <div class="floating-input-group">
                        <textarea name="description" class="form-control modern-input @error('description') is-invalid @enderror"
                            placeholder=" " rows="4" >{{ old('description') }}</textarea>
                        <label class="floating-label">
                            <i class="fas fa-info-circle me-2"></i>وصف القسم
                        </label>
                        <div>
                            <span class="text-danger" style=" right: 1rem;">
                                @error('description')
                                    {{ $message }}
                                @enderror
                            </span>
                        </div>
                    </div>
                </div>

                <!-- زر الحفظ -->
                <div class="form-footer mt-5">
                    <button type="submit" class="btn btn-save">
                        <span class="btn-text">إضافة قسم</span>
                        <i class="fas fa-plus-circle btn-icon"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
