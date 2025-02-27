@extends('layouts.master_store_admin')
@section('content_admin')
    <div class="text-center">
        <div class="container mt-5 mb-5">
            <div class="form-container p-4 shadow rounded bg-white">
                <h2 class="form-title text-center mb-4">إضافة منتج جديد</h2>

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

                <form action="{{ route('product.ceate') }}" method="POST" enctype="multipart/form-data" id="productForm">
                    @csrf
                    <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
                    <input type="text" name="store_id" value="{{ $store->id }}" hidden>
                    <!-- ✅ تحميل الصورة الرئيسية -->
                    <div class="form-group text-center">
                        <input type="file" class="d-none" id="image" name="image" accept="image/*"
                            onchange="previewImage(event, 'currentImage')">
                        <div class="image-preview mb-3">
                            <img id="currentImage" src="{{ asset('default-image.jpg') }}" class="rounded border"
                                alt="إضافة صورة" style="height: 100px;">
                        </div>
                        <label for="image" class="btn btn-success">إضافة الصورة الرئيسية</label>
                    </div>

                    <div class="form-group">
                        <label for="name">اسم المنتج</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="price">سعر المنتج</label>
                        <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">القسم</label>
                        <select class="form-control" id="category_id" name="category_id" required>
                            <option value="" disabled selected>اختر القسم</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select> 
                        
                    </div>

                    {{-- <div class="form-group">
                        <label for="brand_id">الماركة</label>
                        <select class="form-control" id="brand_id" name="brand_id">
                            <option value="" disabled selected>اختر الماركة</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                           
                        </select>
                    </div> --}}

                    <div class="form-group">
                        <label for="description">وصف المنتج</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                    </div>

                    {{-- <!-- ✅ قسم إضافة الألوان -->
                    <div id="color-options">
                        <h5 class="text-center mt-4">إضافة ألوان المنتج</h5>
                        <button type="button" class="btn btn-info mb-3" id="addColor">إضافة لون جديد</button>

                        <div id="colors-container"></div>
                    </div> --}}

                    <button type="submit" class="btn btn-primary btn-block">إضافة المنتج</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // ✅ عرض الصورة المحددة قبل الرفع
        function previewImage(event, targetId) {
            const reader = new FileReader();
            reader.onload = function() {
                document.getElementById(targetId).src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // ✅ إخفاء رسائل التنبيه بعد 2 ثانية
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.querySelectorAll('.fade-out').forEach(alert => {
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 2000);
        });

        // ✅ إدارة الألوان المضافة
        document.addEventListener("DOMContentLoaded", function() {
            const colorsContainer = document.getElementById("colors-container");
            const addColorBtn = document.getElementById("addColor");

            // 🟢 إضافة لون جديد
            addColorBtn.addEventListener("click", function() {
                const colorIndex = document.querySelectorAll('.color-group').length;
                const newColorGroup = document.createElement("div");
                newColorGroup.classList.add("color-group", "border", "p-3", "rounded", "mb-3");

                newColorGroup.innerHTML = `
                    <div class="form-group">
                        <label>اسم اللون</label>
                        <input type="text" class="form-control" name="color_name[]" required>
                    </div>
                    <div class="form-group">
                        <label>سعر المنتج بهذا اللون</label>
                        <input type="number" class="form-control" name="color_price[]" required>
                    </div>
                    <div class="form-group text-center">
                        <input type="file" class="d-none color-image-input" name="color_image[]" id="color_image_${colorIndex}" accept="image/*"
                            onchange="previewColorImage(event, 'colorPreview_${colorIndex}')">
                        <div class="image-preview mb-3">
                            <img class="colorPreview rounded border" id="colorPreview_${colorIndex}" src="{{ asset('default-image.jpg') }}" 
                                alt="إضافة صورة" style="height: 100px;">
                        </div>
                        <label for="color_image_${colorIndex}" class="btn btn-success upload-label">إضافة صورة اللون</label>
                    </div>
                    <button type="button" class="btn btn-danger remove-color">حذف اللون</button>
                `;

                colorsContainer.appendChild(newColorGroup);
            });

            // 🔴 حذف لون معين
            colorsContainer.addEventListener("click", function(event) {
                if (event.target.classList.contains("remove-color")) {
                    event.target.parentElement.remove();
                }
            });

            // ✅ عرض صورة اللون المحددة قبل الرفع
            window.previewColorImage = function(event, targetId) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById(targetId).src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            };
        });
    </script>
@endsection
