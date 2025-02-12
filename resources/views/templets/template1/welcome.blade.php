@extends('layouts.template.master')
{{-- قسم الأنماط الخاصة بهذه الصفحة --}}
@section('content')
    <!-- منطقة الهيرو -->
    <div class="hero-area hero-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 offset-lg-2 text-center">
                    <div class="hero-text">
                        <!-- يمكنك وضع رسالة ترحيبية أو عنوان رئيسي هنا -->
                        <div class="hero-text-tablecell">

                            <div class="hero-btns">


                                <a href="{{-- route('product_all') --}}"class="boxed-btn">
                                    {{ trans('string.shop') }}
                                </a>
                                <a href="#contact" class="bordered-btn">
                                    {{ trans('string.contact') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="hero-area hero-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 offset-lg-2 text-center">
                    <div class="hero-text">
                        <div class="hero-text-tablecell">
                            <p class="subtitle">Fresh & Organic</p>
                            <h1>Delicious Seasonal Fruits</h1>
                            <div class="hero-btns">
                                <a href="shop.html" class="boxed-btn">Fruit Collection</a>
                                <a href="contact.html" class="bordered-btn">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- قسم الفئات (المنتجات حسب القسم) -->
    <div class="product-section mt-80 mb-50">
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
            <div class="row">
                @foreach ($store->categories as $categ)
                    <div class="col-lg-4 col-md-6">
                        <a href="{{-- route('product_all', $categ->id) --}}">
                            <div class="category">
                                <div class="product-image">
                                    <img src="{{ asset($categ->image) }}" alt="{{ $categ->name }}">
                                </div>
                                <h3>{{ $categ->name }}</h3>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- نهاية قسم الفئات -->

    <!-- قسم آخر الأخبار (المنتجات الجديدة) -->

    <div class="latest-news pt-100 pb-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3>
                            {{ trans('string.elctron') }}
                            <span class="orange-text">{{ trans('string.new') }}</span>
                        </h3>
                    </div>
                </div>
            </div>
            {{-- <div class="row product-lists">
                @foreach ($new_product as $new)
                    <div class="col-lg-4 col-md-6 text-center ">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('single_product', $new->id) }}">
                                    <img src="{{ asset($new->image) }}" alt="{{ $new->name }}">
                                </a>
                            </div>
                            <h3>{{ $new->name }}</h3>
                            <form hidden action="{{ route('cart_store') }}" method="POST" id="addtocart">
                                @csrf
                                <input type="hidden" name="color" id="selectedColor" value="اللون الافتراضي">
                                <input type="hidden" name="price" id="selectedPrice" value="{{ $new->price }}">
                                <input type="hidden" name="product_id" value="{{ $new->id }}">
                                <select id="colorSelect" class="form-control">
                                </select>
                            </form>
                            <p class="product-price">${{ $new->price }} </p>
                            <a href='#'
                                onclick="event.preventDefault(); 
                    document.getElementById('addtocart').submit();"
                                class="cart-btn"><i class="fas fa-shopping-cart"></i>
                                {{ trans('string.cart') }}</a>
                        </div>
                    </div>
                @endforeach
            </div> --}}
        </div>
    </div>



    <style>
        .category {
            border: 1px solid #ddd !important;
            padding: 15px !important;
            margin-bottom: 30px !important;
            border-radius: 5px !important;
            background-color: #fff !important;
            text-align: center !important;
        }
    </style>
    <!-- نهاية قسم آخر الأخبار -->
@endsection
