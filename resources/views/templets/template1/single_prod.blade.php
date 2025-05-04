@extends('layouts.template.master')

@section('content')
    <div class="single-product" style="margin-top: 130px;">
        <div class="container">

            {{-- إشعار نجاح --}}
            @if (session('success'))
                <div class="alert alert-success text-center fade show">{{ session('success') }}</div>
            @endif

            {{-- عرض الأخطاء --}}
            @if ($errors->any())
                <div class="alert alert-danger text-center fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- تفاصيل المنتج --}}
            <div class="row align-items-center single-product">
                <div class="col-lg-6 text-center text-lg-start">
                    <div class="single-product-img">
                        <img style="max-height: 65%; max-width: 70%;" id="productImage-{{ $product->id }}"
                            src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="single-product-content">
                        <h3>{{ $product->name }}</h3>
                        <h3 id="productPrice-{{ $product->id }}">
                            {{ $store->currency->code }} {{ $product->price }}
                        </h3>
                        <p>{{ $product->description }}</p>

                        {{-- نموذج إضافة للسلة --}}
                        <form hidden action="{{ route('add.cart') }}" method="POST" id="addtocart-{{ $product->id }}">
                            @csrf
                            <input type="hidden" name="store_id" value="{{ $store->id }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </form>

                        {{-- زر إضافة للسلة --}}
                        <a href="#" onclick="event.preventDefault(); document.getElementById('addtocart-{{ $product->id }}').submit();" class="cart-btn">
                            <i class="fas fa-shopping-cart"></i> {{ trans('string.cart') }}
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
