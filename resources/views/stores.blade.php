@extends('layouts.master')
@section('content')
    <div class="container mb-5 " style="margin-top: 120px">
        <h1 class="page-title text-center mb-4">المتاجر</h1>
        <div class="row">
            @foreach ($allStores as $store)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="store-card shadow-lg rounded-3 h-100">
                    
                        @if ($store->active == 0)
                        <div class="store-status text-end">
                            <span class="badge bg-danger"> المتجر غير نشط</span>
                        </div>
                    @else
                        <div class="store-status text-end">
                            <span class="badge bg-success">المتجر نشط</span>
                        </div>
                    @endif
                        <div class="store-body">
                            <h2 class="store-name mb-3 fs-5">اسم المتجر: {{ $store->name }}</h2>
                            <div class="mb-3">
                                <span class="text-muted">تاريخ الإنشاء:</span>
                                <strong>{{ $store->created_at->format('d-m-Y') }}</strong>
                            </div>
                        </div>

                        <div class="store-footer border-top pt-3">
                            <div class="text-center">
                                @php
                                    $remainingTime = $store->remainingTime();
                                    $days  = $remainingTime['days'];
                                    $hours = $remainingTime['hours'];
                                    $type  = $remainingTime['type'];
                                @endphp
                            
                                @if ($type === 'free_trial')
                                    {{-- حالة التجربة المجانية --}}
                                    @if ($days < 0 && $hours < 0)
                                        <div class="alert alert-danger mb-3">
                                            <strong>تنبيه:</strong>  انتهت صلاحية المتجر
                                            <br> يرجى الاشتراك.
                                        </div>
                                        @php
                                            $store->active = 0;
                                            $store->save();
                                        @endphp
                                        <a href="{{ route('subscribe.view', ['store_id' => $store->id, 'store_name' => $store->name]) }}"
                                           class="btn btn-outline-renew py-2 px-4">
                                            تجديد الاشتراك
                                        </a>
                                    @else
                                        <div class="alert alert-warning mb-3">
                                            <strong>تنبيه:</strong> فترة التجربة المجانية تنتهي بعد
                                            {{ $days }} يوم و{{ $hours }} ساعة.
                                        </div>
                                    @endif
                                @elseif($type === 'subscription')
                                    {{-- حالة الاشتراك الفعّال --}}
                                    @if ($days < 0 || $hours < 0)
                                        <div class="alert alert-danger mb-3">
                                            <strong>تنبيه:</strong> اشتراكك انتهى.
                                            <br> يرجى تجديد الاشتراك.
                                        </div>
                                        @php
                                            $store->active = 0;
                                            $store->save();
                                        @endphp
                                        <a href="{{ route('subscribe.view', ['store_id' => $store->id, 'store_name' => $store->name]) }}"
                                           class="btn btn-outline-renew py-2 px-4">
                                            تجديد الاشتراك
                                        </a>
                                    @else
                                        <div class="alert alert-info mb-3">
                                            <strong>تنبيه:</strong>  فترة اشتراك متجرك ينتهي بعد
                                            {{ $days }} يوم و{{ $hours }} ساعة.
                                        </div>
                                    @endif
                                @endif
                            
                                @if ($store->active == 1)
                                    <a href="{{ route('dashboard.index', ['store_id' => $store->id]) }}"
                                       class="btn btn-outline-primary py-2 px-4">
                                        لوحة التحكم
                                    </a>
                                @endif
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        .btn-outline-renew {
            border: 2px solid #ffc107;
            /* إطار بلون أصفر */
            color: #ffc107;
            /* لون النص أصفر */
            background-color: transparent;
            font-weight: bold;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
            position: relative;
            text-decoration: none;
            display: inline;
        }

        /* تأثير hover: يصبح الخلفية أصفر والنص أبيض */
        .btn-outline-renew:hover {
            background-color: #ffc107;
            color: #fff;
        }

        /* إضافة أيقونة قبل نص الزر باستخدام pseudo-element */


        .store-card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 1.5rem;
        }

        .store-name {
            color: #2c3e50;
            font-weight: 600;
        }

        .verified-icon {
            color: #28a745;
            font-size: 1.2em;
        }

        .crown-icon {
            color: #ffd700;
            font-size: 1.1em;
        }

        .store-id code {
            background: #e9ecef;
            padding: 0.2rem 0.4rem;
            border-radius: 3px;
            font-size: 0.9em;
        }
    </style>
@endsection
