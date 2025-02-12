@extends('layouts.template.master')

@section('content')
    <!-- Checkout Section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row"  style="text-align:{{trans('string.text-align')}}" dir="{{trans('string.dir')}}">
                <div class="col-lg-12">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            @foreach ($orders as $item => $group)
                                <div class="card single-accordion">
                                    <div class="card-header" id="heading{{ $loop->index }}">
                                        <h5 class="mb-0">
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $loop->index }}" aria-expanded="true"
                                                aria-controls="collapse{{ $loop->index }}" style="direction: ltr"> <h5>{{ trans('string.order-date') }}</h5> {{ $item }}
                                            </button>
                                            
                                        </h5>
                                    </div>

                                    <div id="collapse{{ $loop->index }}" class="collapse m-5"
                                        aria-labelledby="heading{{ $loop->index }}" data-parent="#accordionExample">
                                        <div class="row">
                                            <div class="col-lg-6 col-md-12">
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
                                                            @foreach ($group as $item)
                                                                @php
                                                                    $subtotal +=
                                                                        $item->quantity * $item->product->price;
                                                                @endphp
                                                                <tr class="table-body-row">
                                                                    <td class="product-image">
                                                                        @php
                                                                            $productImage = $item->product->image; // الصورة الافتراضية
                                                                            $colorImage = $item->product->colorImages
                                                                                ->where('color_name', $item->color)
                                                                                ->first(); // جلب صورة اللون المحدد
                                                                            if ($colorImage) {
                                                                                $productImage = $colorImage->image;
                                                                            }
                                                                        @endphp
                                                                        <img id="cartProductImage-{{ $item->id }}" src="{{ asset($productImage) }}"
                                                                            alt="">
                                                                    </td>
                                                                    <td class="product-name">{{ $item->product->name }}</td>
                                                                    <td class="product-price">${{ $item->price }}
                                                                    </td>
                                                                    <td class="product-quantity">
                                                                        {{ $item->quantity }}
                                                                    </td>
                                                                    <td class="product-total">
                                                                        ${{ $item->quantity * $item->product->price }}</td>

                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
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
                                                                <td><strong>{{ trans('string.name') }}</strong></td>
                                                                <td>{{ $item->name }}</td>
                                                            </tr>
                                                            <tr class="total-data">
                                                                <td><strong>{{ trans('string.phone') }}</strong></td>
                                                                <td>{{ $item->phone }}</td>
                                                            </tr>
                                                            <tr class="total-data">
                                                                <td><strong>{{ trans('string.address') }}</strong></td>
                                                                <td>{{ $item->address }}</td>
                                                            </tr>
                                                            <tr class="total-data">
                                                                <td><strong>{{ trans('string.order-status') }}</strong></td>
                                                                <td>{{ $item->status }}</td>
                                                            </tr>
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
                                                                    $shipping = 100;
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
                                                   
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
