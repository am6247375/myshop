@extends('layouts.template.master')
@section('content')
 <!-- product section -->
 <div class="product-section mt-150 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">  {{$search}}</span>:  نتائج البحث </h3>
                </div>
            </div>
        </div>
       
        <div class="row product-lists">
            @foreach ($product as $item)
            <div class="col-lg-4 col-md-6 text-center">
             <div class="single-product-item">
                 <div class="product-image">
                     <a href="{{route('single_product', $item->id)}}">
                        <img src="{{asset($item->image)}}" alt=""></a>
                 </div>
                 <h3>{{$item->name}}</h3>
                 <form hidden action="{{ route('cart_store') }}" method="POST" id="addtocart">
                    @csrf
                    <input type="hidden" name="color" id="selectedColor" value="اللون الافتراضي">
                    <input type="hidden" name="price" id="selectedPrice" value="{{ $store->currency->code }}{{ $item->price }}">
                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                    <select id="colorSelect" class="form-control">
                    </select>
                </form>
                <p class="product-price">{{ $store->currency->code }}    {{ $item->price }} </p>
                <a href='#' onclick="event.preventDefault(); 
                document.getElementById('addtocart').submit();"
                 class="cart-btn"><i
                        class="fas fa-shopping-cart"></i>
                    {{ trans('string.cart') }}</a>
                  </div>
         </div>
            @endforeach
         </div>
    </div>
</div>
<!-- end product section -->
    
@endsection