@extends('layouts.master_admin')

@section('content_admin')
<div class="content-wrapper text-center">
    <div class="container mt-5 mb-5">
        <div class="form-container p-4 shadow rounded bg-white">
            <h2 class="form-title text-center">إضافة ماركة جديدة</h2>

            <!-- رسائل النجاح أو الأخطاء -->
            @if (session('success'))
                <div class="alert alert-success text-center fade show">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger text-center fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('brands_store') }}" method="POST" enctype="multipart/form-data" id="brandForm">
                @csrf
                <!-- تحميل صورة الماركة -->
                <div class="form-group text-center">
                    <input type="file" class="d-none" id="brandImage" name="image" accept="image/*" onchange="previewBrandImage(event)">
                    <div class="image-preview mt-3">
                        <img id="brandPreview" src="{{ asset(old('image', 'default-placeholder.png')) }}" 
                             alt="إضافة صورة" class="img-thumbnail" style="height: 100px;">
                    </div>
                    <label for="brandImage" class="btn btn-success mt-2">اختيار صورة</label>
                </div>

                <!-- اسم الماركة -->
                <div class="form-group">
                    <label for="name" class="form-label">اسم الماركة</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                </div>

                <button type="submit" class="btn btn-primary btn-block">إضافة ماركة</button>
            </form>
        </div>
    </div>
</div>

<script>
    function previewBrandImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('brandPreview').src = reader.result;
        };
        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
                alert.classList.add('fade');
                setTimeout(() => alert.remove(), 500);
            });
        }, 2000);
    });

    document.getElementById('brandForm').addEventListener('submit', function(event) {
        if (!confirm('هل أنت متأكد أنك تريد إضافة هذه الماركة؟')) {
            event.preventDefault();
        }
    });
</script>
@endsection
