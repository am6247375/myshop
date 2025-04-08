@extends('layouts.master')

@section('content')
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <div class="container text-center mb-5" style="margin-top: 120px">
        <h2 class="fw-bold mb-3">باقات وأسعار منصة متجري</h2>

        <div class="row justify-content-center">
            @foreach ($subscriptions as $index => $subscription)
                @php
                    switch ($index) {
                        case 2:
                            $cardBg = '#F7931E';
                            $priceColor = '#fff';
                            $cardTextColor = '#fff';
                            $bottomTextColor = '#F7931E';
                            $title = $subscription->name ?? 'الباقة الأساسية';
                            break;
                        case 1:
                            $cardBg = '#FFEFC3';
                            $priceColor = '#F7931E';
                            $cardTextColor = '#000';
                            $bottomTextColor = '#fff';
                            $title = $subscription->name ?? 'الباقة المتقدمة';
                            break;
                        case 0:
                            $cardBg = '#f8f9fa';
                            $priceColor = 'black';
                            $cardTextColor = '#000';
                            $bottomTextColor = '#fff';
                            $title = $subscription->name ?? 'الباقة المتميزة';
                            break;
                        default:
                            $cardBg = '#fff';
                            $priceColor = '#000';
                            $cardTextColor = '#000';
                            $title = $subscription->name ?? 'باقة أخرى';
                            break;
                    }

                    $features = explode(',', $subscription->features);
                @endphp

                <div class="col-md-4 mb-4 d-flex">
                    <div class="card flex-fill shadow border-0"
                        style="background-color: {{ $cardBg }}; border-radius: 15px;">
                        <div class="card-header text-center py-4" style="background-color: transparent; border: none;">
                            <h3 class="fw-bold mb-0" style="color: {{ $cardTextColor }};">
                                {{ $title }}
                            </h3>
                        </div>
                        <div class="card-body text-center" style="color: {{ $cardTextColor }};">
                            <h1 class="fw-bold my-4" style="color: {{ $priceColor }};">
                                $ {{ $subscription->price }}
                            </h1>
                            <p class="text-dark">
                                {{ $subscription->duration == 12 ? $subscription->duration . ' شهر' : $subscription->duration . ' أشهر' }}
                            </p>

                            <button class="btn mb-4 px-4 py-2 fw-bold"
                                style="background-color: {{ $priceColor }}; color: {{ $bottomTextColor }}; border-radius: 30px;"
                                data-bs-toggle="modal" data-bs-target="#paymentModal-{{ $subscription->id }}">
                                اشترك الآن
                            </button>

                            <!-- Modal الدفع -->
                            <div class="modal fade mt-5" id="paymentModal-{{ $subscription->id }}" tabindex="-1"
                                aria-labelledby="paymentModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentModalLabel">بيانات الدفع -
                                                {{ $subscription->name }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body text-end">
                                            <form action="{{ route('subscribe') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="store_id" value="{{$store_id }}">
                                                <input type="hidden" name="subscrip_id" value="{{ $subscription->id }}">
                                            
                                                <!-- بيانات البطاقة (وهمية فقط للعرض) -->
                                                <div class="mb-3">
                                                    <label class="form-label">رقم البطاقة</label>
                                                    <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">تاريخ الانتهاء</label>
                                                    <input type="text" class="form-control" placeholder="MM/YY" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">رمز الأمان (CVV)</label>
                                                    <input type="text" class="form-control" placeholder="123" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">اسم حامل البطاقة</label>
                                                    <input type="text" class="form-control" placeholder="الاسم كما هو على البطاقة" required>
                                                </div>
                                            
                                                <button type="submit" class="btn btn-success w-100">
                                                    تأكيد الاشتراك
                                                </button>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- قائمة المميزات -->
                            <ul class="list-unstyled text-start mx-auto" style="max-width: 200px;">
                                @foreach ($features as $feature)
                                    <li class="mb-2">
                                        <span style="font-size: 1.2rem;">✔️</span> {{ trim($feature) }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- تنسيقات إضافية -->
    <style>
        .card:hover {
            transform: translateY(-5px);
            transition: transform 0.3s ease-in-out;
        }
        body.modal-open .card:hover {
    transform: none !important;
}

    </style>
    
@endsection
