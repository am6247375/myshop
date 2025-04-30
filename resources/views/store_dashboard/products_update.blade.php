@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container-fluid py-3">
        <div class="glassmorphism-card mx-auto" style="max-width: 90%;">
            <div class="card-header text-white py-4" id="card-header">
                <h2 class="mb-0 fw-bold">
                    <i class="fas fa-edit fa-2x text-white"></i>
                    تعديل المنتج
                </h2>
            </div>

            <form action="{{ route('product.edit', ['store_id'=> $store->id, 'product_id' => $product->id]) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="store_id" value="{{ $store->id }}">

                <!-- صورة المنتج -->
                <div class="form-group text-center">
                    <input type="file" class="d-none" id="image" name="image" accept="image/*"
                        onchange="previewImage(event, 'currentImage')">
                    <div class="image-preview mt-3">
                        <img id="currentImage" src="{{ asset($product->image ?? 'default-image.jpg') }}"
                            alt="صورة المنتج" class="img-thumbnail" style="height: 100px;">
                    </div>
                    <label for="image" class="btn btn-success mt-2">تغيير صورة المنتج</label>
                    <div>
                        <span class="text-danger">@error('image') {{ $message }} @enderror</span>
                    </div>
                </div>

                <!-- اسم المنتج -->
                <div class="d-flex justify-content-center">
                    <div class="floating-input-group w-75">
                        <input type="text" name="name" class="form-control modern-input @error('name') is-invalid @enderror"
                            placeholder=" " value="{{ old('name', $product->name) }}">
                        <label class="floating-label"><i class="fas fa-tag me-2"></i>اسم المنتج</label>
                        <div class="text-center">
                            <span class="text-danger">@error('name') {{ $message }} @enderror</span>
                        </div>
                    </div>
                </div>

                <!-- سعر المنتج -->
                <div class="d-flex justify-content-center">
                    <div class="floating-input-group w-75">
                        <input type="number" name="price" min="1"
                            class="form-control modern-input @error('price') is-invalid @enderror"
                            placeholder=" " value="{{ old('price', $product->price) }}">
                        <label class="floating-label"><i class="fas fa-dollar-sign me-2"></i>سعر المنتج</label>
                        <div class="text-center">
                            <span class="text-danger">@error('price') {{ $message }} @enderror</span>
                        </div>
                    </div>
                </div>

                <!-- القسم -->
                <div class="d-flex justify-content-center">
                    <div class="floating-input-group w-75">
                        <select name="category_id" class="form-select modern-input @error('category_id') is-invalid @enderror">
                            <option value="" disabled></option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="floating-label"><i class="fas fa-layer-group me-2"></i>القسم</label>
                        <div class="text-center">
                            <span class="text-danger">@error('category_id') {{ $message }} @enderror</span>
                        </div>
                    </div>
                </div>

                <!-- وصف المنتج -->
                <div class="d-flex justify-content-center">
                    <div class="floating-input-group w-75">
                        <textarea name="description" rows="4"
                            class="form-control modern-input @error('description') is-invalid @enderror"
                            placeholder=" ">{{ old('description', $product->description) }}</textarea>
                        <label class="floating-label"><i class="fas fa-info-circle me-2"></i>وصف المنتج</label>
                        <div>
                            <span class="text-danger">@error('description') {{ $message }} @enderror</span>
                        </div>
                    </div>
                </div>

                <!-- زر التحديث -->
                <div class="d-flex justify-content-center mt-3">
                    <div class="floating-input-group w-75">
                        <button type="submit" class="btn btn-save">
                            <span class="btn-text">حفظ التعديلات</span>
                            <i class="fas fa-check-circle btn-icon"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
