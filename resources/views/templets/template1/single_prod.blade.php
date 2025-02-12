@extends('layouts.template.master')

@section('content')
    <div class="single-product" style="margin-top: 130px;">
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success text-center fade show">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger text-center fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                        <h3 id="productPrice-{{ $product->id }}">{{ $product->price }} $</h3>
                        <p>{{ $product->description }}</p>
                        <div class="form-group">
                            <label for="colorSelect-{{ $product->id }}">اختر اللون:</label>
                            <form action="{{ route('cart_store') }}" method="POST" id="addToCartForm-{{ $product->id }}">
                                @csrf
                                <input type="hidden" name="color" id="selectedColor-{{ $product->id }}" value="اللون الافتراضي">
                                <input type="hidden" name="price" id="selectedPrice-{{ $product->id }}" value="{{ $product->price }}">
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <select id="colorSelect-{{ $product->id }}" class="form-control colorSelect" data-product-id="{{ $product->id }}">
                                    <option value="{{ asset($product->image) }}" data-name="اللون الافتراضي" data-price="{{ $product->price }}" selected>
                                        اللون الافتراضي
                                    </option>
                                    @foreach ($product->colorImages as $color)
                                        <option value="{{ asset($color->image) }}" data-name="{{ $color->color_name }}" data-price="{{ $color->price }}">
                                            {{ $color->color_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                        <a href="#" class="boxed-btn" onclick="event.preventDefault(); document.getElementById('addToCartForm-{{ $product->id }}').submit();">
                            <i class="fas fa-shopping-cart"></i> {{ __('string.cart') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.colorSelect').forEach(select => {
                select.addEventListener("change", function() {
                    let productId = this.getAttribute("data-product-id");
                    let selectedOption = this.options[this.selectedIndex];
    
                    setTimeout(() => {
                        document.getElementById("productImage-" + productId).src = selectedOption.value;
                        document.getElementById("selectedColor-" + productId).value = selectedOption.getAttribute("data-name");
                        document.getElementById("selectedPrice-" + productId).value = selectedOption.getAttribute("data-price");
                        document.getElementById("productPrice-" + productId).textContent = selectedOption.dataset.price + " $";
                    }, 200); // تأخير 200 مللي ثانية لضمان التحديث السلس
                });
            });
        });
    </script>
    
@endsection
