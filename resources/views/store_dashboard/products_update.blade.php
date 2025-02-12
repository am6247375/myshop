@extends('layouts.master_admin')
@section('content_admin')
<div class="content-wrapper " style="text-align: center">
    <div class="container mt-5 mb-5">
        <div class="form-container p-4 shadow rounded bg-white">
            <h2 class="form-title text-center mb-4">تعديل المنتج</h2>

            @if (session('success'))
                <div class="alert alert-success text-center fade-out">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger text-center fade-out">
                    <ul class="list-unstyled mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('products_save_update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf

                <!-- تحميل الصورة الرئيسية -->
                <div class="form-group text-center">
                    <input type="file" class="d-none" id="image" name="image" accept="image/*" onchange="previewImage(event, 'currentImage')">
                    <div class="image-preview mb-3">
                        <img id="currentImage" src="{{ asset($product->image ?? 'default-image.jpg') }}" class="rounded border" alt="صورة المنتج" style="height: 100px;">
                    </div>
                    <label for="image" class="btn btn-success">تغيير الصورة</label>
                </div>

                <!-- اسم المنتج -->
                <div class="form-group">
                    <label for="name" class="form-label">اسم المنتج</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                </div>

                <!-- سعر المنتج -->
                <div class="form-group">
                    <label for="price" class="form-label">سعر المنتج</label>
                    <input type="number" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                </div>

                <!-- القسم -->
                <div class="form-group">
                    <label for="category_id" class="form-label">القسم</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <option value="" disabled>اختر القسم</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- الماركة -->
                <div class="form-group">
                    <label for="brand_id" class="form-label">الماركة</label>
                    <select class="form-control" id="brand_id" name="brand_id" required>
                        <option value="" disabled>اختر الماركة</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                {{ $brand->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- وصف المنتج -->
                <div class="form-group">
                    <label for="description" class="form-label">وصف المنتج</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- الألوان المتاحة -->
                <div class="form-group">
                    <label class="form-label">الألوان المتاحة</label>
                    <div class="d-flex flex-wrap">
                        @foreach ($colors as $color)
                            <div class="form-check me-3">
                                <input class="form-check-input color-checkbox" type="checkbox"
                                    id="color_{{ $color->id }}" name="colors[]" value="{{ $color->id }}"
                                    {{ in_array($color->id, $product->colors->pluck('id')->toArray()) ? 'checked' : '' }}
                                    onchange="toggleColorImage('{{ $color->id }}')">
                                <label class="form-check-label" for="color_{{ $color->id }}">{{ $color->name }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- تحميل صورة لكل لون محدد -->
                <div id="colorImagesContainer" class="mt-3">
                    @foreach ($product->colors as $color)
                        <div id="colorImageDiv_{{ $color->id }}" class="form-group mt-2">
                            <label class="form-label">صورة للون {{ $color->name }}</label>
                            <input type="file" class="form-control" name="color_images[{{ $color->id }}]" accept="image/*">
                            <img src="{{ asset($color->pivot->image) }}" class="mt-2 rounded border" style="height: 80px;">
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary btn-block">حفظ التعديلات</button>

            </form>
        </div>
    </div>
</div>

<script>
    // عرض الصورة المحددة قبل التحميل
    function previewImage(event, targetId) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById(targetId).src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function toggleColorImage(colorId) {
        let container = document.getElementById('colorImagesContainer');
        let checkbox = document.getElementById(`color_${colorId}`);
        let existingDiv = document.getElementById(`colorImageDiv_${colorId}`);

        if (checkbox.checked) {
            if (!existingDiv) {
                let div = document.createElement('div');
                div.id = `colorImageDiv_${colorId}`;
                div.classList.add('form-group', 'mt-2');

                let label = document.createElement('label');
                label.textContent = `صورة للون ${checkbox.nextElementSibling.textContent}`;
                label.classList.add('form-label');

                let input = document.createElement('input');
                input.type = 'file';
                input.name = `color_images[${colorId}]`;
                input.accept = 'image/*';
                input.classList.add('form-control');

                div.appendChild(label);
                div.appendChild(input);
                container.appendChild(div);
            }
        } else {
            if (existingDiv) {
                existingDiv.remove();
            }
        }
    }

    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            document.querySelectorAll('.fade-out').forEach(alert => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 2000);
    });
</script>
@endsection
