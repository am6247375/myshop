@extends('layouts.master_admin')
@section('content_admin')
<div class="content-wrapper " style="text-align: center">
<div class="container mt-5 mb-5">
    <div class="form-container p-4 shadow rounded bg-white">
        <h2 class="form-title text-center mb-4">إضافة قسم جديد</h2>
            <!-- عرض رسائل النجاح أو الأخطاء -->
            @if (session('success'))
                <div class="alert alert-success fade-out"
                    style="background-color: #007910 !important; text-align: center; color: #fff;">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger fade-out" style="text-align: center; color: #fff;">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- JavaScript لإخفاء الرسائل بعد ثانيتين -->


            <form action="{{ route('category_save_update',$categories) }}" method="POST" enctype="multipart/form-data" id="productForm">
                @csrf

                <div class="form-group">
                    <input type="file" class="form-control custom-file-input" id="image" hidden name="image"
                        accept="image/*" onchange="previewImage(event)">
                    <!-- عرض الصورة الحالية -->
                    <div class="image-preview mt-3" style="text-align: center">
                        <img id="currentImage" src="{{ asset($categories->image) }}" alt=" اضافة صورة جديد"
                            style="       height: 100px; border: 1px solid #ccc; border-radius: 5px;">

                    </div>
                    <label for="image" class="btn btn-primary btn-success">تغير الصورة</label>
                </div>
                <div class="form-group">
                    <label for="name" class="form-label">اسم القسم</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{$categories->name}}"
                        required>
                </div>

              

                <div class="form-group">
                    <label for="description" class="form-label">وصف القسم</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{$categories->description}}</textarea>
                </div>
                <button type="submit" class="btn btn-primary btn-block">اضافة قسم</button>
            </form>
        </div>
    </div>
</div>
    <!-- JavaScript لعرض الصورة الجديدة -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const reader = new FileReader();

            reader.onload = function() {
                const currentImage = document.getElementById('currentImage');
                currentImage.src = reader.result;
            };

            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <!-- CSS لتنسيق زر رفع الصورة -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const alerts = document.querySelectorAll('.alert');
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500); // إزالة العنصر بعد انتهاء التلاشي
                });
            }, 2000); // بعد ثانيتين
        });
    </script>


@endsection


<style>
    .container {
        max-width: 600px;
        margin: auto;
    }

    .form-container {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-label {
        font-weight: bold;
        display: block;
        margin-bottom: 5px;
        color: #555;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 16px;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        outline: none;
    }

    .btn {
        background-color: #007910 !important;
        color: #fff !important;
        border: none;
        padding: 10px 15px;
        font-size: 16px !important;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #007910 !important;
        color: #fff;
    }

    .btn-block {
        width: 100%;

    }
</style>

<script>
    $(document).ready(function() {
        // تفاعل عند تقديم النموذج
        $('#productForm').on('submit', function(e) {
            if (!confirm('هل أنت متأكد أنك تريد إضافة هذا المنتج؟')) {
                e.preventDefault();
            }
        });

        // معاينة الصورة عند اختيارها
        $('#image').on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').remove();
                    $('<img>', {
                        id: 'imagePreview',
                        src: e.target.result,
                        class: 'img-thumbnail mt-3',
                        style: 'max-width: 100%; height: auto;  text-align: center; ',

                    }).insertAfter('#image');
                };
                reader.readAsDataURL(file);
            }
        });
    });
</script>
