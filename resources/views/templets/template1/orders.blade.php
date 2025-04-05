@extends('layouts.template.master')

@section('content')
    <!-- Checkout Section -->
    <div class="checkout-section mt-150 mb-150">
        <div class="container">
            <div class="row"  style="text-align:{{trans('string.text-align')}}" dir="{{trans('string.dir')}}">
                <div class="col-lg-12">
                    <div class="checkout-accordion-wrap">
                        <div class="accordion" id="accordionExample">
                            @foreach ($orders as $order)
                                <div class="card single-accordion">
                                    <div class="card-header" id="heading{{ $loop->index }}">
                                        <h5 class="mb-0" style="width: 100%" >
                                            <button class="btn btn-link" type="button" data-toggle="collapse"
                                                data-target="#collapse{{ $loop->index }}" aria-expanded="true"
                                                aria-controls="collapse{{ $loop->index }}" style="direction: ltr"> <h5>{{ trans('string.order-date') }}</h5> {{ $order->created_at }}
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
                                                          
                                                            @foreach ($order->orderItems as $item)
                                                               
                                                                <tr class="table-body-row">
                                                                    <td class="product-image">
                                                                      
                                                                        <img  src="{{ asset($item->product->image) }}"
                                                                            alt="">
                                                                    </td>
                                                                    <td class="product-name">{{ $item->product->name }}</td>
                                                                    <td class="product-price">${{ $item->price }}
                                                                    </td>
                                                                    <td class="product-quantity">
                                                                        {{ $item->quantity }}
                                                                    </td>
                                                                    <td class="product-total">
                                                                        ${{ $item->total_price }}</td>

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
                                                                <td>{{ $order->recipient_name }}</td>
                                                            </tr>
                                                            <tr class="total-data">
                                                                <td><strong>{{ trans('string.phone') }}</strong></td>
                                                                <td>{{ $order->recipient_phone }}</td>
                                                            </tr>
                                                            <tr class="total-data">
                                                                <td><strong>{{ trans('string.address') }}</strong></td>
                                                                <td>{{ $order->recipient_address }}</td>
                                                            </tr>
                                                            <tr class="total-data">
                                                                <td><strong>{{ trans('string.order-status') }}</strong></td>
                                                                <td>{{ $order->status }}</td>
                                                            </tr>
                                                            <tr class="total-data">
                                                                <td><strong>{{ trans('string.sub-total') }}</strong></td>
                                                                <td>${{ $order->total_price }}</td>
                                                            </tr>
                                                           
                                                            {{-- <tr class="total-data">
                                                                <td><strong>{{ trans('string.shipping') }}</strong></td>
                                                                <td>${{  $order->total_price  }}</td>
                                                            </tr>
                                                            <tr class="total-data">
                                                                <td><strong>{{ trans('string.total') }}</strong></td>
                                                                <td>${{ $order->total_price }}</td>
                                                            </tr> --}}
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
