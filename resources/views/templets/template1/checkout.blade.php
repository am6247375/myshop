@extends('layouts.template.master')

@section('content')

    <!-- csheck out section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row" style="text-align:{{trans('string.text-align')}}" dir="{{trans('string.dir')}}">
                <div class="col-lg-8">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            <div class="card single-accordion">
                                <div class="card-header" id="headingOne">
                                    <h5 class="mb-0" style="    width: 100%;">
                                        <button class="btn btn-link" type="button" data-toggle="collapse"
                                            data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        {{ trans('string.shipping-data') }} 
                                        </button>
                                    </h5>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="billing-address-form">
                                            <form id="addorder"  action="{{ route('checkout') }}" method="POST">
                                                @csrf
                                                <input type="text" hidden name="store_id"  value="{{ $store->id }}">
                                                 <p>
                                                    <label style="font-size: 20px"  for="">{{ trans('string.name') }}</label>
                                                    <input name="recipient_name" type="text" value="{{ old('recipient_name') }}" placeholder="{{ trans('string.name') }}">
                                                    <span class="text-danger">
                                                        @error('recipient_name')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </p>
                                                <p>
                                                    <label style="font-size: 20px" for="">{{ trans('string.address') }}</label>
                                                    <input name="recipient_address" type="text" value="{{ old('recipient_address') }}" placeholder="{{ trans('string.address') }}">
                                                    <span class="text-danger">
                                                        @error('recipient_address')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </p>

                                                <p>
                                                    <label style="font-size: 20px" for=""> {{ trans('string.phone') }}</label>
                                                    <input name="recipient_phone"
                                                    type="text"
                                                    value="{{ old('recipient_phone') }}"
                                                    style="text-align:{{ trans('string.text-align') }}"
                                                    placeholder="{{ trans('string.phone') }}"
                                                    maxlength="9"
                                                    pattern="\d{9}"
                                                    inputmode="numeric"
                                                    oninput="this.value = this.value.replace(/\D/g, '')"
                                                    title="يرجى إدخال 9 أرقام فقط">
                                             
                                                    <span class="text-danger">
                                                        @error('recipient_phone')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </p>
                                                <p>
                                                    <label style="font-size: 20px" for="">{{ trans('string.note') }} </label>
                                                    <textarea name="note" id="bill" cols="30" rows="10" placeholder="{{ trans('string.note') }}"> {{ old('note') }}</textarea>
                                                    <span class="text-danger">
                                                        @error('note')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card single-accordion">
                                <div class="card-header" id="headingThree">
                                    <h5 class="mb-0" style="    width: 100%;">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
                                            data-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">   {{ trans('string.order-detals') }}
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                    data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="card-details">
                                            <div class="cart-table-wrap">
                                                <table class="cart-table">
                                                    <thead class="cart-table-head">
                                                        <tr class="table-head-row">

                                                            <th class="product-image">{{ trans('string.product-image') }}</th>
                                                            <th class="product-name">{{ trans('string.product-name') }}</th>
                                                            <th class="product-price">{{ trans('string.product-price') }}</th>
                                                            <th class="product-quantity">{{ trans('string.product-quantity') }}</th>
                                                            <th class="product-total">{{ trans('string.product-total') }}</th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                                $subtotal = 0;
                                                        @endphp
                                                        @foreach ($cart as $item)
                                                            @php
                                                                $subtotal += $item->quantity * $item->product->price;
                                                            @endphp
                                                            <tr class="table-body-row">
                                                                <td class="product-image">
                                                                    <img id="cartProductImage-{{ $item->id }}" src="{{ asset($item->product->image) }}"
                                                                        alt="">
                                                                </td>
                                                                <td class="product-name">{{ $item->product->name }}</td>
                                                                <td class="product-price">{{ $store->currency->code }}    {{ $item->product->price }}</td>
                                                                <td class="product-quantity">{{ $item->quantity }} </td>
                                                                <td class="product-total">
                                                                    {{ $store->currency->code }}    {{ $item->quantity * $item->product->price }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                                <tr class="total-data">
                                    <td><strong>{{ trans('string.sub-total') }}</strong></td>
                                    <td>${{ $subtotal }}</td>
                                </tr>
                                @php
                                    $shipping;
                                    if ($subtotal >= 250) {
                                        $shipping = 0;
                                    } elseif ($subtotal == 0) {
                                        $shipping = 0;
                                    } else {
                                        $shipping = 10;
                                    }

                                @endphp
                                <tr class="total-data">
                                    <td><strong>{{ trans('string.shipping') }}</strong></td>
                                    <td>${{ $shipping }}</td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>{{ trans('string.total') }}</strong></td>
                                    <td>${{ $shipping + $subtotal }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-buttons" style="text-align: center">
                            <!-- زر الدفع عند الاستلام -->
                            <a href="#" class="boxed-btn black"
                                onclick="event.preventDefault(); document.getElementById('addorder').submit();">
                                ارسال الطلب

                            </a>

                            {{-- <!-- زر الدفع الآن -->
                            <a href="#" class="boxed-btn black" onclick="submitForm('paypal')">
                                ادفع الآن
                                <img style="height: 35px; margin-right: 5px;" src="{{ asset('assets/img/pay.png') }}"
                                    alt="PayPal Logo">
                            </a> --}}
                        </div>
                        <div class="cart-buttons" style="text-align: center">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
