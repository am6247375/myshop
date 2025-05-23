@extends('layouts.master')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container text-center mb-5" style="margin-top: 120px">
        <div style="margin-bottom: 50px; margin-top: 150px;">
            <h2 class="fw-bold mb-3">باقات وأسعار منصة متجري</h2>
        </div>
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

                            <div class="modal fade mt-5" id="paymentModal-{{ $subscription->id }}" tabindex="-1"
                                aria-labelledby="paymentModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content rounded-4">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="paymentModalLabel">
                                                تنبيه!</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="إغلاق"></button>
                                        </div>
                                        <div class="modal-body text-end">
                                            <form action="{{ route('subscribe') }}" method="POST">
                                                @csrf

                                                @php
                                                    $user = Auth::user();
                                                @endphp

                                                @if (!Auth::check())
                                                    <div class="alert alert-warning text-center">
                                                        الرجاء <a href="{{ route('login') }}">تسجيل الدخول</a> لاختيار
                                                        المتجر وإتمام الاشتراك.
                                                        <a href="{{ route('login') }}"
                                                            class="btn btn-primary mt-5 mb-5">تسجيل الدخول</a>
                                                        @php
                                                            session(['subscribe' => route('subscribe.view')]);
                                                        @endphp
                                                    </div>
                                                @else
                                                    @php
                                                        $allStores = collect([$user->store])
                                                            ->filter()
                                                            ->merge($user->stores)
                                                            ->unique('id');
                                                    @endphp

                                                    @if ($allStores->isEmpty())
                                                        <div class="alert alert-info text-center">
                                                            لا يوجد لديك متاجر حالياً. <a>قم بإنشاء متجر الآن</a> لإكمال
                                                            الاشتراك.
                                                            <a href="{{ route('templates') }}"
                                                                class="btn btn-primary mt-5 mb-5">إنشاء متجر</a>
                                                        </div>
                                                    @else
                                                        <div class="mb-3">
                                                            <label class="form-label">اختر المتجر</label>
                                                            <select name="store_id" class="form-select" required>
                                                                @foreach ($allStores as $store)
                                                                    <option value="{{ $store->id }}">
                                                                        {{ $store->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <input type="hidden" name="subscrip_id" value="{{ $subscription->id }}">

                                                     <h5 class="mt-4 mb-3 fw-bold text-center">بيانات الدفع</h5>

<div class="mb-3">
    <label class="form-label">اسم حامل البطاقة</label>
    <input type="text" name="card_name" class="form-control" placeholder="مثال: محمد أحمد" required oninput="this.value=this.value.replace(/[^أ-يa-zA-Z\s]/g,'')">
</div>

<div class="mb-3">
    <label class="form-label">رقم البطاقة</label>
    <input type="text" name="card_number" class="form-control" placeholder="**** **** **** ****" required maxlength="19" oninput="formatCardNumber(this)">
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">تاريخ الانتهاء</label>
        <input type="text" name="expiry_date" class="form-control" placeholder="MM/YY" required maxlength="5" oninput="formatExpiry(this)">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">CVV</label>
        <input type="text" name="cvv" class="form-control" placeholder="***" required maxlength="4" oninput="this.value=this.value.replace(/[^0-9]/g,'')">
    </div>
</div>

                                                        <button type="submit" class="btn btn-success w-100">
                                                            تأكيد الاشتراك والدفع
                                                        </button>
                                                    @endif
                                                @endif
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>


<script>
    function formatCardNumber(input) {
        // إزالة أي حرف غير رقم
        let value = input.value.replace(/\D/g, '');
        // تقسيم كل 4 أرقام بمسافة
        value = value.match(/.{1,4}/g)?.join(' ') || '';
        input.value = value;
    }

    function formatExpiry(input) {
        let value = input.value.replace(/\D/g, '');
        if (value.length > 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        input.value = value;
    }
</script>
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
