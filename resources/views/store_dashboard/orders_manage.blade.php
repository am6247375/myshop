@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container-fluid py-3">
        <div class="card shadow-lg border-0">
            <div class="card-body px-4">
                <div class="tab-content mt-4">
                    <!-- الطلبات -->
                    <div class="tab-pane fade show active" id="orders">
                        <div class="policy-card card mb-4" style="margin-top: 20px; margin-bottom: 50px">
                            <div class="card-body">

                                <!-- العنوان + الفلتر -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2">
                                    <h3 class="fw-bold mb-0">ادارة الطلبات</h3>

                                    <div class="mb-3 mt-2" dir="ltr" style="text-align: center;">
                                        <label style="    display: block;" for="status-filter" class="form-label fw-bold">فلاتر حسب حالة الطلب</label>
                                        <select name="status" class="form-select border-primary fw-bold text-center"
                                            id="status-filter">
                                            <option value="">جميع الحالات</option>
                                            <option value="pending">⏳ قيد الانتظار</option>
                                            <option value="Shipped">🚚 تم الشحن</option>
                                            <option value="Delivered">✅ تم التسليم</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- جدول الطلبات -->
                                <div class="table-responsive" style="text-align: center">
                                    <table id="myTable" class="table table-striped table-bordered text-center mt-2 mb-4">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>اسم العميل</th>
                                                <th>رقم الجوال</th>
                                                <th>العنوان</th>
                                                <th>حالة الطلب</th>
                                                <th>المبلغ الإجمالي</th>
                                                <th>تاريخ الطلب</th>
                                                <th>العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders as $order)
                                               
                                                <tr>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->recipient_name }}</td>
                                                    <td>{{ $order->recipient_phone }}</td>
                                                    <td class="address-cell" title="{{ $order->recipient_address }}">
                                                        {{ $order->recipient_address }}
                                                    </td>


                                                    <td data-search="{{ $order->status }}">
                                                        {{ $order->status == 'pending'
                                                            ? '⏳ قيد الانتظار'
                                                            : ($order->status == 'Shipped'
                                                                ? '🚚 تم الشحن'
                                                                : ($order->status == 'Delivered'
                                                                    ? '✅ تم التسليم'
                                                                    : $order->status)) }}
                                                    </td>
                                                    <td>{{ $store->currency->code.' '. number_format($order->total_price, 2)}} </td>
                                                    <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                                    <td>
                                                        <a href="{{ route('order.show', ['store_id' => $store->id, 'order_id' => $order->id]) }}"
                                                            class="btn btn-info btn-sm w-100 text-center">
                                                            <i class="fas fa-eye"></i> عرض
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- نهاية جدول الطلبات -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
