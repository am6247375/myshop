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
                                @php
                                    $subtotal = 0;
                                @endphp
                                @foreach ($cart as $item)
                                    @php
                                        $subtotal += $item->quantity * $item->product->price;
                                    @endphp
                                    <td class="product-image">
                                     
                                        <img id="cartProductImage-{{ $item->id }}" src="{{ asset($item->product->image) }}"
                                            alt="">
                                    </td>
                                    <td class="product-name">{{ $item->product->name }}</td>
                                    <td class="product-price">${{ $item->product->price }}</td>
                                    <td class="product-quantity">
                                        <input type="number" class="quantity-input" min="1"
                                            value="{{ $item->quantity }}" data-cart-id="{{ $item->id }}"
                                            data-price="{{ $item->product->price }}" data-store="{{ $store->id }}">
                                    </td>
                                    <td class="product-total">${{ $item->quantity * $item->product->price }}</td>
                                    <td>
                                        <form action="{{--  --}}" method="POST" style="display: inline;">
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
                                <tr class="total-data">
                                    <td><strong>{{ trans('string.sub-total') }}</strong></td>
                                    <td class="total-price">${{ $subtotal }}</td>
                                </tr>
                                @php
                                    $shipping = $subtotal >= 250 || $subtotal == 0 ? 0 : 100;
                                @endphp
                                <tr class="total-data">
                                    <td><strong>{{ trans('string.shipping') }}</strong></td>
                                    <td class="shipping-price">${{ $shipping }}</td>
                                </tr>
                                <tr class="total-data">
                                    <td><strong>{{ trans('string.total') }}</strong></td>
                                    <td class="final-total">${{ $shipping + $subtotal }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="cart-buttons" style="text-align: center">
                            <a href="{{--  --}}" class="boxed-btn black">{{ trans('string.checkout') }}</a>
                            <a href="{{--  --}}"
                                class="boxed-btn black">{{ trans('string.previous-orders') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script defer>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    let cartId = this.dataset.cartId;
                    let quantity = this.value;
                    let price = this.dataset.price;
                    let storeId = this.dataset.store;
                    let totalCell = this.closest('tr').querySelector('.product-total');
    
                    let totalPrice = quantity * price;
                    totalCell.textContent = `$${totalPrice}`;
    
                    let csrfToken = document.querySelector('meta[name="csrf-token"]');
                    if (!csrfToken) {
                        console.error("CSRF token not found.");
                        return;
                    }
    
                    fetch("{{ route('update.cart') }}", {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken.getAttribute('content'),
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                cart_id: cartId,
                                quantity: quantity,
                                store_id: storeId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.querySelector('.total-price').textContent = `$${data.newSubtotal}`;
                                document.querySelector('.shipping-price').textContent = `$${data.shipping}`;
                                document.querySelector('.final-total').textContent = `$${data.newTotal}`;
                            }
                        })
                        .catch(error => console.error("Error:", error));
                });
            });
        });
    </script>
    
    <!-- end cart -->
@endsection
