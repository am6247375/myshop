@extends('layouts.master')

@section('content')
<div class="container py-5 ">
    <div class="row justify-content-center">
        <!-- الباقة الأساسية -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 border-0" style="background: #e3f2fd;">
                <div class="card-header bg-primary text-white py-4">
                    <h3 class="text-center mb-0">الباقة الأساسية</h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="font-weight-bold my-4">US$ 250</h1>
                    <p class="text-muted"></p>
                    <button class="btn btn-primary btn-lg mb-4 w-75" style="color: white;">
                        جرب الآن
                    </button>
                    <ul class="list-unstyled text-right">
                        <li class="mb-3">✔️ ربط النتائج الخاصة بك</li>
                        <li class="mb-3">✔️ إضافة المنتجات (حد أقصى 100 منتج)</li>
                        <li class="mb-3">✔️ إنشاء حسابين للفريق</li>
                        <li class="mb-3">✔️ ربط متجر عبر منصة تواصل واحدة</li>
                        <li class="mb-3">✔️ ربط بوابة دفع إلكتروني واحدة</li>
                        <li class="mb-3">✔️ مستويات مناطق الشحن</li>
                        <li>✔️ البيع بلغة واحدة</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- الباقة المحترفية -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 border-0" style="background: #fff3cd;">
                <div class="card-header bg-warning py-4 position-relative">
                    <h3 class="text-center mb-0">الباقة المحترفية 🔥</h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="font-weight-bold my-4" style="color: #856404;">US$ 800</h1>
                    <p class="text-muted">سنويًا</p>
                    <button class="btn btn-warning btn-lg mb-4 w-75" style="color: white;">
                        جرب الآن
                    </button>
                    <ul class="list-unstyled text-right">
                        <li class="mb-3">✔️ جميع ميزات الباقة الأساسية +</li>
                        <li class="mb-3">✔️ إضافة عدد غير محدود من المنتجات</li>
                        <li class="mb-3">✔️ إنشاء حسابات فريق غير محدودة</li>
                        <li class="mb-3">✔️ البيع بجميع اللغات</li>
                        <li class="mb-3">✔️ مسؤول مختصص للدعم الفني</li>
                        <li>✔️ ربط بوابات دفع إلكتروني غير محدودة</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- الباقة المميزة -->
        <div class="col-md-4 mb-4">
            <div class="card shadow h-100 border-0" style="background: #e8d6ff;">
                <div class="card-header text-white py-4" style="background: #6f42c1;">
                    <h3 class="text-center mb-0">الباقة المميزة</h3>
                </div>
                <div class="card-body text-center">
                    <h1 class="font-weight-bold my-4" style="color: #6f42c1;">US$ 600</h1>
                    <p class="text-muted">سنويًا</p>
                    <button class="btn btn-lg mb-4 w-75" style="background: #6f42c1; color: white;">
                        جرب الآن
                    </button>
                    <ul class="list-unstyled text-right">
                        <li class="mb-3">✔️ جميع ميزات الباقة الأساسية +</li>
                        <li class="mb-3">✔️ ربط متجر بجميع منصات التواصل</li>
                        <li class="mb-3">✔️ مستويات مناطق شحن متقدمة</li>
                        <li>✔️ دعم لغات متعددة</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
        border-radius: 15px;
        transition: transform 0.3s;
    }
    .card:hover {
        transform: translateY(-10px);
    }
    ul li {
        font-size: 16px;
        padding-right: 1.5rem;
    }
    body {
        font-family: 'Noto Sans Arabic', Arial, sans-serif;
    }
</style>
@endsection