@extends('layouts.template.master')
{{-- قسم الأنماط الخاصة بهذه الصفحة --}}
@section('content')

    <div class="product-section mt-150 mb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3>
                            <span class="orange-text">{{ trans('string.dept') }}</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row"  >
                @isset($store)
                    @foreach ($store->categories as $category)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('products', [$store->name, $category->id]) }}">
                                <div class="category">
                                    <div class="product-image">
                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}">
                                    </div>
                                    <h3>{{ $category->name }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-4 col-md-6">
                        <a href="#">
                            <div class="category">
                                <div class="product-image">
                                    <img src="{{ asset('assets\assets_template1\img\laptop.png') }}">
                                </div>
                                <h3>لابتوبات</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a href="#">
                            <div class="category">
                                <div class="product-image">
                                    <img src="{{ asset('assets\assets_template1\img\phone.png') }}">
                                </div>
                                <h3>جوالات</h3>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <a href="#">
                            <div class="category">
                                <div class="product-image">
                                    <img src="{{ asset('assets\assets_template1\img\elctron.png') }}">
                                </div>
                                <h3>اكسسوارات</h3>
                            </div>
                        </a>
                    </div>
                @endisset

            </div>
        </div>
    </div>
    <!-- نهاية قسم الفئات -->

    <!-- قسم آخر الأخبار (المنتجات الجديدة) -->

    <div class="latest-news pt-100 pb-10">
        <div class="container">
            <div class="row" >
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3>
                            {{ trans('string.products') }}
                            <span class="orange-text">{{ trans('string.new') }}</span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="row product-lists"  >
                @isset($new_products)
                    @foreach ($new_products as $new)
                        <div class="col-lg-4 col-md-6 text-center">
                            <div class="single-product-item">
                                <div class="product-image">
                                    <a href="{{ route('single.product',['name'=>$store->name,'product_id'=> $new['id']]) }}">
                                        <img src="{{ asset($new['image']) }}" alt="{{ $new['name'] }}">
                                    </a>
                                </div>
                                <h3>{{ $new['name'] }}</h3>
                                <form action="{{ route('add.cart') }}" method="POST" id="addtocart_{{ $new['id'] }}">
                                    @csrf
                                    <input type="hidden" name="store_id" value="{{ $store->id }}">
                                    <input type="hidden" name="product_id" value="{{ $new['id'] }}">
                                </form>
                                
                                <p class="product-price">{{  $store->currency->code}}      {{ $new['price'] }}</p>
                                <a href='#'
                                onclick="event.preventDefault(); 
                                document.getElementById('addtocart_{{ $new['id'] }}').submit();"
                                class="cart-btn"><i class="fas fa-shopping-cart"></i>
                                {{ trans('string.cart') }}</a>
                             
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="#">
                                    <img src="{{ asset('storage\logos\f84budWAgsbly0FBU5qyBk6myFEnqRuXPgznPwNt.png') }}" alt="">
                                </a>
                            </div>
                            <h3>ايفون 13 برو ماكس</h3>
                            <p class="product-price">$1500.00</p>
                            <a href='#'
                                class="cart-btn"><i class="fas fa-shopping-cart"></i>
                                {{ trans('string.cart') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="#">
                                    <img src="{{ asset('assets\products\b74886df-a88e-4b23-be6d-372b8a379645_Apple 2022 MacBook Air laptop with M2 chip.png') }}" alt="">
                                </a>
                            </div>
                            <h3>لابتوب ماك توب</h3>
                            <p class="product-price">$500.00</p>
                            <a href='#'
                                class="cart-btn"><i class="fas fa-shopping-cart"></i>
                                {{ trans('string.cart') }}</a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="#">
                                    <img src="{{ asset('assets\logo\8431b7f7-61ec-4ade-8b2e-391cce8cf22c_Apple iPhone 16 Pro1.png') }}" alt="">
                                </a>
                            </div>
                            <h3>ايفون 15 برو ماكس</h3>
                            <p class="product-price">$1600.00</p>
                            <a href='#'
                                class="cart-btn"><i class="fas fa-shopping-cart"></i>
                                {{ trans('string.cart') }}</a>
                        </div>
                    </div>
                @endisset

            </div>
        </div>
    </div>

    <!-- نهاية قسم آخر الأخبار -->
@endsection
