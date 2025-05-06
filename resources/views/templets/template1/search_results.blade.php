@extends('layouts.template.master')

@section('content')
<!-- product section -->
<div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">{{ $query }}</span>: نتائج البحث</h3>
                </div>
            </div>
        </div>

        @if($products->isEmpty())
            <div class="row">
                <div class="col-12 text-center">
                    <p>لم يتم العثور على منتجات تطابق كلمة البحث.</p>
                </div>
            </div>
        @else
            <div class="row product-lists">
                @foreach ($products as $item)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('single.product', ['name' => $store->name, 'product_id' => $item->id]) }}">
                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                                </a>
                            </div>
                            <h3>{{ $item->name }}</h3>
                            <form hidden action="{{ route('add.cart') }}" method="POST" id="addtocart-{{ $item->id }}">
                                @csrf
                                <input type="hidden" name="color" value="اللون الافتراضي">
                                <input type="hidden" name="price" value="{{ $item->price }}">
                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                            </form>
                            <p class="product-price">{{ $store->currency->code }} {{ $item->price }}</p>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('addtocart-{{ $item->id }}').submit();" class="cart-btn">
                                <i class="fas fa-shopping-cart"></i> {{ trans('string.cart') }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<!-- end product section -->
@endsection
