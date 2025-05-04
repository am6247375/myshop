@extends('layouts.template.master')

@section('content')
    <!-- cart -->
    <div class="cart-section mt-150 mb-150">
        <div class="container" dir="{{ trans('string.dir') }}" style="text-align:center">
            <div class="row">
                <div class="col-lg-8 col-md-12">
                    <div class="cart-table-wrap">
                        <table class="cart-table">
                            <thead class="cart-table-head">
                                <tr class="table-head-row">
                                    <th class="product-image">{{ trans('string.product-image') }}</th>
                                    <th class="product-name">{{ trans('string.product-name') }}</th>
                                    <th class="product-price">{{ trans('string.product-price') }}</th>
                                    <th class="product-quantity">{{ trans('string.product-quantity') }}</th>
                                    <th class="product-total">{{ trans('string.product-total') }}</th>
                                    <th class="product-remove"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($store)
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach ($cart as $item)
                                        @php
                                            $subtotal += $item->quantity * $item->product->price;
                                        @endphp
                                        <tr>
                                            <td class="product-image">

                                                <img id="cartProductImage-{{ $item->id }}"
                                                    src="{{ asset($item->product->image) }}" alt="">
                                            </td>
                                            <td class="product-name">{{ $item->product->name }}</td>
                                            <td class="product-price">{{ $store->currency->code }}    {{ $item->product->price }}</td>
                                            <td class="product-quantity">
                                                <input type="number" class="quantity-input" min="1"
                                                    value="{{ $item->quantity }}" data-cart-id="{{ $item->id }}"
                                                    data-price="{{ $item->product->price }}" data-store="{{ $store->id }}">
                                            </td>
                                            <td class="product-total">
                                                {{ $store->currency->code }}    {{ number_format($item->quantity * $item->product->price, 2) }}</td>
                                            <td>
                                                <form action="{{ route('delete.cart') }}" method="POST"
                                                    style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="cart_id" value="{{ $item->id }}">
                                                    <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">
                                                        {{ trans('string.product-delete') }}
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="product-image">
                                            <img src="{{ asset('storage\logos\f84budWAgsbly0FBU5qyBk6myFEnqRuXPgznPwNt.png') }}"
                                                alt="">
                                        </td>
                                        <td class="product-name">ايفون 13 برو ماكس</td>
                                        <td class="product-price">$1500.00</td>
                                        <td class="product-quantity">
                                            <input type="number" class="quantty-input" value="2" min="2">
                                        </td>
                                        <td class="product-total">
                                            $ 3000.00</td>
                                        <td>
                                            <form action="{{--  --}}" method="POST" style="display: inline;">
                                                <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">
                                                    {{ trans('string.product-delete') }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="product-image">
                                            <img src="{{ asset('assets\products\b74886df-a88e-4b23-be6d-372b8a379645_Apple 2022 MacBook Air laptop with M2 chip.png') }}"
                                                alt="">
                                        </td>
                                        <td class="product-name">لابتوب ماك توب</td>
                                        <td class="product-price">$500.00</td>
                                        <td class="product-quantity">
                                            <input type="number" class="quantty-input" value="1" min="1">
                                        </td>
                                        <td class="product-total">
                                            $ 500.00</td>
                                        <td>
                                            <button type="submit" class="btn btn-danger btn-sm fas fa-trash-alt">
                                                {{ trans('string.product-delete') }}
                                            </button>
                                        </td>
                                    </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="total-section">
                        <table class="total-table">
                            <thead class="total-table-head">
                                <tr class="table-total-row">
                                    <th>{{ trans('string.invoice') }}</th>
                                    <th>{{ trans('string.price') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($store)
                                    <tr class="total-data">
                                        <td><strong>{{ trans('string.sub-total') }}</strong></td>
                                        <td class="total-price">${{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                    @php
                                        $shipping = $subtotal >= 250 || $subtotal == 0 ? 0 : 10;
                                    @endphp
                                    <tr class="total-data">
                                        <td><strong>{{ trans('string.shipping') }}</strong></td>
                                        <td class="shipping-price">${{ number_format($shipping, 2) }}</td>
                                    </tr>
                                    <tr class="total-data">
                                        <td><strong>{{ trans('string.total') }}</strong></td>
                                        <td class="final-total">${{ number_format($shipping + $subtotal, 2) }}</td>
                                    </tr>
                                @else
                                    <tr class="total-data">
                                        <td><strong>{{ trans('string.sub-total') }}</strong></td>
                                        <td class="total-price">$3500.00</td>
                                    </tr>
                                    <tr class="total-data">
                                        <td><strong>{{ trans('string.shipping') }}</strong></td>
                                        <td class="shipping-price">$10.00</td>
                                    </tr>
                                    <tr class="total-data">
                                        <td><strong>{{ trans('string.total') }}</strong></td>
                                        <td class="final-total">$3510.00</td>
                                    </tr>
                                @endisset
                            </tbody>
                        </table>
                        <div class="cart-buttons" style="text-align: center">
                            @isset($store)
                                <a href="{{ route('checkout.view',['name'=>$store->name]) }}" class="boxed-btn black">{{ trans('string.checkout') }}</a>
                                <a href="{{ route('show.orders',$store->name) }}"class="boxed-btn black">{{ trans('string.previous-orders') }}</a>
                            @else
                                <a href="{{--  --}}" class="boxed-btn black">{{ trans('string.checkout') }}</a>
                                <a href="{{--  --}}" class="boxed-btn black">{{ trans('string.previous-orders') }}</a>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end cart -->
@endsection
