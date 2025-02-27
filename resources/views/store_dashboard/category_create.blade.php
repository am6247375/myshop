@extends('layouts.master_store_admin')
@section('content_admin')
<div style="text-align: center">
<div class="container mt-5 mb-5">
    <div class="form-container p-4 shadow rounded bg-white">
        <h2 class="form-title text-center">إضافة قسم جديد</h2>

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

        <form action="{{ route('category.create') }}" method="POST" enctype="multipart/form-data" id="categoryForm">
            @csrf
            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
            <input type="text" name="store_id" value="{{ $store->id  }}" hidden>
            {{-- <input type="text" name="store_id" value="{{ Auth::user()->store->id }}" hidden> --}}
            <div class="form-group text-center">
                <input type="file" class="d-none" id="image" name="image" accept="image/*" onchange="previewImage(event)">
                <div class="image-preview mt-3">
                    <img id="currentImage" src="{{ asset(old('image', 'default-placeholder.png')) }}" 
                         alt="إضافة صورة" class="img-thumbnail" style="height: 100px;">
                </div>
                <label for="image" class="btn btn-success mt-2">اختيار صورة</label>
            </div>

            <div class="form-group">
                <label for="name" class="form-label">اسم القسم</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="form-group">
                <label for="description" class="form-label">وصف القسم</label>
                <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary btn-block">إضافة قسم</button>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            document.getElementById('currentImage').src = reader.result;
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

    document.getElementById('categoryForm').addEventListener('submit', function(event) {
        if (!confirm('هل أنت متأكد أنك تريد إضافة هذا القسم؟')) {
            event.preventDefault();
        }
    });
</script>
@endsection
