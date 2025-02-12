@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">إنشاء متجر جديد</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('store.ceate') }}" method="POST" enctype="multipart/form-data">
        @csrf()
<input type="text" name="template_id" value="{{$template_id}}" hidden>
        <div class="mb-3">
            <label for="name" class="form-label">اسم المتجر</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="active" class="form-label">الحالة</label>
            <select name="active" id="active" class="form-control">
                <option value="1">نشط</option>
                <option value="0">غير نشط</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="logo" class="form-label">شعار المتجر</label>
            <input type="file" name="logo" id="logo" class="form-control">
        </div>

        

        <div class="mb-3">
            <label for="languages" class="form-label">اللغات المدعومة</label>
            <div id="languages">
                @foreach($languages as $language)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="languages[]" value="{{ $language->id }}" id="language_{{ $language->id }}">
                        <label class="form-check-label" for="language_{{ $language->id }}">
                            {{ $language->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>
        
        <div class="mb-3">
            <label for="currency" class="form-label">العملة</label>
            <select name="currency" id="currency" class="form-control" required>
                <option value="SAR">الريال السعودي</option>
                <option value="USD">الدولار الأمريكي</option>
                <option value="YER">الريال اليمني</option>
            </select>
        </div>
        

        <div class="mb-3">
            <label for="whatsapp_link" class="form-label">رابط واتساب</label>
            <input type="tel" name="whatsapp_link" id="whatsapp_link" class="form-control">
        </div>

        <div class="mb-3">
            <label for="facebook_link" class="form-label">رابط فيسبوك</label>
            <input type="text" name="facebook_link" id="facebook_link" class="form-control">
        </div>

        <div class="mb-3">
            <label for="instagram_link" class="form-label">رابط انستجرام</label>
            <input type="text" name="instagram_link" id="instagram_link" class="form-control">
        </div>
       

        <button type="submit" class="btn btn-primary">إنشاء المتجر</button>
    </form>
</div>
@endsection
