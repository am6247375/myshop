@extends('layouts.master')

@section('content')
<div class="container mb-5" style="margin-top: 150px">
    <h1 class="page-title text-center mb-5 fw-bold  ">قائمة المتاجر</h1>
    <div class="row g-4">
        @foreach ($allStores as $store)
        <div class="col-md-6 col-lg-4">
            <div class="store-card shadow-sm border rounded-4 p-4 position-relative h-100 bg-white">
                {{-- حالة المتجر --}}
                <div class="position-absolute top-0 end-0 m-3">
                    @if ($store->active == 0)
                        <span class="badge bg-danger">غير نشط</span>
                    @else
                        <span class="badge bg-success">نشط</span>
                    @endif
                </div>

                {{-- معلومات المتجر --}}
                <h5 class="store-name mb-3 text-dark fw-semibold">اسم المتجر: {{ $store->name }}</h5>
                <p class="text-muted mb-2">تاريخ الإنشاء: <strong>{{ $store->created_at->format('d-m-Y') }}</strong></p>
 
                {{-- حالة الاشتراك --}}
                @php
                    $remainingTime = $store->remainingTime();
                    $days  = $remainingTime['days'];
                    $hours = $remainingTime['hours'];
                    $type  = $remainingTime['type'];
                @endphp

                <div class="mt-3">
                    @if ($type === 'free_trial')
                        @if ($days <= 0 && $hours <= 0)
                            <div class="alert alert-danger" id="alertt">
                                <strong>تنبيه:</strong> 
                                انتهى الاشتراك. يرجى التجديد.
                            </div>
                            @php
                                $store->active = 0;
                                $store->save();
                            @endphp
                            <a href="{{ route('subscribe.view', ['store_id' => $store->id, 'store_name' => $store->name]) }}" class="btn btn-renew w-100">
                                <i class="fas fa-sync-alt me-2"></i> تجديد الاشتراك
                            </a>
                        @elseif ($days <= 3)
                            <div class="alert alert-danger" id="alertt">
                                <strong>تنبيه:</strong> تنتهي فترة التجربة خلال {{ $days }} يوم و{{ $hours }} ساعة.
                            </div>
                            <a href="{{ route('subscribe.view', ['store_id' => $store->id, 'store_name' => $store->name]) }}" class="btn btn-renew w-100">
                                <i class="fas fa-shopping-cart me-2"></i> اشترك الآن
                            </a>
                        @else
                            <div class="alert alert-warning" id="alertt">
                                <strong>تنبيه:</strong> تنتهي فترة التجربة خلال {{ $days }} يوم و{{ $hours }} ساعة.
                            </div>
                        @endif
                    @elseif($type === 'subscription')
                        @if ($days < 0 || $hours < 0)
                            <div class="alert alert-danger" id="alertt">
                                <strong>تنبيه:</strong> انتهى الاشتراك. يرجى التجديد.
                            </div>
                            @php
                                $store->active = 0;
                                $store->save();
                            @endphp
                            <a href="{{ route('subscribe.view', ['store_id' => $store->id, 'store_name' => $store->name]) }}" class="btn btn-renew w-100">
                                <i class="fas fa-sync-alt me-2"></i> تجديد الاشتراك
                            </a>
                        @elseif ($days <= 3)
                            <div class="alert alert-danger" id="alertt">
                                <strong>تنبيه:</strong> ينتهي الاشتراك خلال {{ $days }} يوم و{{ $hours }} ساعة.
                            </div>
                            <a href="{{ route('subscribe.view', ['store_id' => $store->id, 'store_name' => $store->name]) }}" class="btn btn-renew w-100">
                                <i class="fas fa-sync-alt me-2"></i> تجديد الاشتراك
                            </a>
                        @else
                            <div class="alert alert-info" id="alertt" >
                                <strong>تنبيه:</strong> ينتهي الاشتراك خلال {{ $days }} يوم و{{ $hours }} ساعة.
                            </div>
                        @endif
                    @endif
                </div>

                {{-- زر لوحة التحكم --}}
                @if ($store->active == 1)
                    <a href="{{ route('dashboard.index', ['store_id' => $store->id]) }}" class="btn btn-dashboard w-100 mt-3">
                        <i class="fas fa-cogs me-2"></i> لوحة التحكم
                    </a>
                @endif

            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- تنسيقات CSS --}}
<style>
    #alertt {
        font-size: 20px;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 20px;
        height: 100px;
        text-align: center;
    }
    .btn-renew {
        background: linear-gradient(90deg, #ffca28, #ffc107);
        color: #212529;
        font-weight: bold;
        border-radius: 10px;
        transition: 0.3s ease;
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
    }

    .btn-renew:hover {
        background: #ffb300;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(255, 193, 7, 0.5);
    }

    .btn-dashboard {
        background: white;
        color: #007bff;
        font-weight: bold;
        border: 2px solid #007bff;
        border-radius: 10px;
        transition: 0.3s ease;
    }

    .btn-dashboard:hover {
        background: #007bff;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.4);
    }

    .store-card {
        background: #fefefe;
        transition: box-shadow 0.3s ease;
    }

    .store-card:hover {
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
    }
</style>
@endsection
