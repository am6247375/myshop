@extends('layouts.template.master')
@section('content')
    <!-- Products Section -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-filters">
                        <ul dir="{{ trans('string.dir') }}">
                            @isset($store)
                                @isset($category_id)
                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            let link = document.querySelector("li[data-id='{{ $category_id }}']");
                                            if (link) {
                                                link.classList.add("active");
                                                setTimeout(() => {
                                                    link.click();
                                                }, 200);
                                            }
                                        });
                                    </script>
                                @endisset
                                <li class="{{ !isset($cat_id) ? 'active' : '' }}" data-filter="*" style="text-align: right;">
                                    {{ trans('string.all') }}
                                </li>
                                @foreach ($store->categories as $categ)
                                    <li data-id="{{ $categ->id }}" data-filter=".category-{{ $categ->id }}">
                                        {{ $categ->name }}</li>
                                @endforeach
                            @else
                            <li class="active" data-filter="*" style="text-align: right;">
                                {{ trans('string.all') }}
                            </li>
                            
                                <li data-filter=".phone">جوالات</li>
                                <li data-filter=".laptopss">لابتوبات</li>
                                <li data-filter=".elctron">اكسسوارات</li>
                            @endisset
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Brands Dropdown -->
            {{-- <div class="row">
                <div class="col-md-12 text-center ">
                    <div class="brand-filters">
                        <h4>Brands</h4>
                        <select id="brand-filter" class="form-control w-50 mx-auto">
                            <option data-filter="*">ALL</option>
                            @foreach ($brands as $brand)
                                <option data-filter=".brand-{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div> --}}


            <div class="row product-lists">
                @isset($store)
                    @foreach ($store->categories as $category)
                        @foreach ($category->products as $item)
                            <div
                                class="col-lg-4 col-md-6 text-center product-item category-{{ $item->category_id }} brand-{{ $item->brand_id }}">
                                <div class="single-product-item">
                                    <div class="product-image">
                                        <a href="{{-- route('single_product', $item->id) --}}">
                                            <img src="{{ asset($item->image) }}" alt="{{ $item->name }}">
                                        </a>
                                    </div>
                                    <h3>{{ $item->name }}</h3>
                                    <form hidden action="{{--  --}}" method="POST"
                                        id="aaddtocart-{{ $item->id }}">
                                        @csrf
                                        <input type="hidden" name="color" id="selectedColor-{{ $item->id }}"
                                            value="اللون">
                                        <input type="hidden" name="price" id="selectedPrice-{{ $item->id }}"
                                            value="{{ $item->price }}">
                                        <input type="hidden" name="product_id" value="{{ $item->id }}">
                                        <select id="colorSelect-{{ $item->id }}" class="form-control">
                                        </select>
                                    </form>

                                    <p class="product-price">${{ $item->price }} </p>
                                    <a href="#"
                                        onclick="event.preventDefault(); 
                      document.getElementById('aaddtocart-{{ $item->id }}').submit();"
                                        class="cart-btn">
                                        <i class="fas fa-shopping-cart"></i> {{ trans('string.cart') }}
                                    </a>

                                </div>
                            </div>
                        @endforeach
                    @endforeach
                @else
                    <div class="col-lg-4 col-md-6 text-center product-item phone">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{-- route('single_product', $item->id) --}}">
                                    <img src="{{ asset('assets/products/33dbb531-2ed5-43c1-8f9a-736d14a22868_Apple iPhone 16 Plus.png') }}"
                                        >
                                </a>
                            </div>
                            <h3>ايفون 16 بلس</h3>


                            <p class="product-price">$1650 </p>
                            <a href='#'
                                class="cart-btn"><i class="fas fa-shopping-cart"></i>
                                {{ trans('string.cart') }}</a>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center product-item laptopss">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{-- route('single_product', $item->id) --}}">
                                    <img src="{{ asset('assets/products/HP 255 G10 Business Laptop, 15.6FHD IPS Display.png') }}"
                                        >
                                </a>
                            </div>
                            <h3>لابتوب HP </h3>


                            <p class="product-price">$1650 </p>
                            <a href='#'
                                class="cart-btn"><i class="fas fa-shopping-cart"></i>
                                {{ trans('string.cart') }}</a>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 text-center product-item elctron">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{-- route('single_product', $item->id) --}}">
                                    <img src="{{ asset('assets/products/product05.png') }}"
                                        >
                                </a>
                            </div>
                            <h3>سماعة لاسلكي</h3>
                            <p class="product-price">$12</p>
                            <a href='#'
                                class="cart-btn"><i class="fas fa-shopping-cart"></i>
                                {{ trans('string.cart') }}</a>

                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>

{{-- 
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let $grid = $(".product-lists").isotope({
                itemSelector: ".product-item",
                layoutMode: "fitRows"
            });

            // فلترة التصنيفات عند النقر على القائمة
            $(".product-filters li").on("click", function() {
                $(".product-filters li").removeClass("active");
                $(this).addClass("active");

                let categoryFilter = $(this).attr("data-filter");
                let brandFilter = $("#brand-filter").find(":selected").attr("data-filter");

                setTimeout(() => {
                    applyFilters(categoryFilter, brandFilter);
                }, 20); // تأخير بسيط لضمان تحديث الفلترة
            });

            // فلترة البراندات عند اختيار قيمة من القائمة المنسدلة
            $("#brand-filter").on("change", function() {
                let categoryFilter = $(".product-filters li.active").attr("data-filter");
                let brandFilter = $(this).find(":selected").attr("data-filter");

                setTimeout(() => {
                    applyFilters(categoryFilter, brandFilter);
                }, 20); // تأخير بسيط لضمان تحديث الفلترة
            });

            function applyFilters(category, brand) {
                let filterValue = "*"; // عرض كل المنتجات كافتراضي

                if (category !== "*" && brand !== "*") {
                    filterValue = category + brand; // فلترة مزدوجة (تصنيف + براند)
                } else if (category !== "*") {
                    filterValue = category;
                } else if (brand !== "*") {
                    filterValue = brand;
                }

                $grid.isotope({
                    filter: filterValue
                });
            }
        });
    </script> --}}
@endsection
