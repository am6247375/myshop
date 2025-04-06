@extends('layouts.master_store_admin')
@section('content_admin')
<div class="container my-5">
    <!-- بطاقة التحكم في حالة الطلب وإجراءات إضافية -->
    <div class="card order-management-card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class="fas fa-shopping-cart me-2"></i>
                <h5 class="mb-0">إدارة الطلب رقم #{{ $order->id }}</h5>
            </div>
            <span class="status-badge">
                @if($order->status == 'pending')
                    <i class="fas fa-clock text-warning me-1"></i> قيد الانتظار
                @elseif($order->status == 'Shipped')
                    <i class="fas fa-truck text-info me-1"></i> تم الشحن
                @else
                    <i class="fas fa-check-circle text-success me-1"></i> تم التسليم
                @endif
            </span>
        </div>
    
        <div class="card-body">
            <!-- الموظف المسؤول -->
            <section class="employee-info">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-tie icon me-3"></i>
                    <div>
                        <p class="text-muted mb-1">تم تحديث حالة الطلب بواسطة الموظف:</p>
                        <p class="fw-bold mb-0">
                            {{ $order->user ? $order->user->first_name . ' ' . $order->user->last_name : 'غير محدد' }}
                        </p>
                    </div>
                </div>
            </section>
    
            <!-- التحكم في الحالة -->
            <section class="status-control">
                <h6 class="section-title">
                    <i class="fas fa-cog me-2 text-primary"></i>
                    تغيير حالة الطلب
                </h6>
    
                <form action="{{ route('order.update') }}" method="POST" class="row g-3 align-items-end">
                    @csrf
                    <input  type="hidden" name="order_id" value="{{ $order->id }}">
    
                    <div class="col-md-7" >
                        <label for="orderStatus" class="form-label">الحالة الحالية</label>
                        <select name="status" id="orderStatus" style="width: 70%; text-align:center; height:30px " class="form-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="Shipped" {{ $order->status == 'Shipped' ? 'selected' : '' }}>تم الشحن</option>
                            <option value="Delivered" {{ $order->status == 'Delivered' ? 'selected' : '' }}>تم التسليم</option>
                        </select>
                    </div>
    
                    <div class="col-md-5">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-sync-alt me-2"></i> تحديث الحالة
                        </button>
                    </div>
                </form>
            </section>
    
            <!-- طباعة الفاتورة -->
            <div class="text-center mt-4">
                <button onclick="printInvoice()" class="btn btn-primary">
                    <i class="fas fa-print me-2"></i> طباعة الفاتورة
                </button>
            </div>
        </div>
    </div>
    
    <!-- بطاقة الفاتورة وتفاصيل الطلب -->
    <div class="card shadow-sm mb-4 border-0" id="invoice">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <div>
                @if ($store->logo)
                    <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}" style="max-height: 60px;">
                @else
                    <h2 class="text-primary mb-0">{{ $store->name }}</h2>
                @endif
            </div>
            <div>
                <h4 class="mb-0">فاتورة الطلب رقم {{ $order->id }}</h4>
            </div>
        </div>
        <div class="card-body">
            <hr>
            <div class="row">
                <!-- تفاصيل الطلب (المنتجات) -->
                <div class="col-lg-12 mb-4">
                    <h5 class="text-secondary text-center mb-4">📦 تفاصيل الطلب</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered text-center">
                            <thead >
                                <tr>
                                    <th>المنتج</th>
                                    <th>السعر</th>
                                    <th>الكمية</th>
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                    $shipping = 0;
                                @endphp
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>{{ optional($item->product)->name ?? 'غير متوفر' }}</td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->total_price, 2) }}</td>
                                    </tr>
                                    @php
                                        $total += $item->total_price;
                                    @endphp
                                @endforeach
                            </tbody>
                            <tfoot>
                                @php
                                    if ($total > 0 && $total < 100) {
                                        $shipping = 10;
                                    }
                                @endphp
                                <tr>
                                    <th colspan="3" class="text-end">مبلغ التوصيل:</th>
                                    <th>${{ number_format($shipping, 2) }}</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="text-end">الإجمالي الكلي:</th>
                                    <th>${{ number_format($order->total_price, 2) }}</th>
                                </tr>
                                <tr class="table-danger">
                                    <th colspan="4" class="text-center">الدفع عند الاستلام</th>
                                </tr>                                
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- تفاصيل المستلم -->
                <hr>
                <div class="col-lg-12">
                    <h5 class="text-secondary text-center mb-4">👤 تفاصيل المستلم</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="width: 40%">الاسم:</th>
                                    <td>{{ $order->recipient_name ?? 'غير متوفر' }}</td>
                                </tr>
                                <tr>
                                    <th>الهاتف:</th>
                                    <td>{{ $order->recipient_phone ?? 'غير متوفر' }}</td>
                                </tr>
                                <tr>
                                    <th>العنوان:</th>
                                    <td>{{ $order->recipient_address ?? 'غير متوفر' }}</td>
                                </tr>
                                <tr>
                                    <th>تاريخ الطلب:</th>
                                    <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                </tr>
                                @if(!empty($order->note))
                                <tr>
                                    <th>ملاحظات:</th>
                                    <td>{{ $order->note }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> <!-- نهاية الصف -->
        </div>
    </div>
</div>

<!-- أنماط إضافية لتحسين التصميم -->
<style>
    .card {
        border-radius: 12px;
    }
    .table th, .table td {
        vertical-align: middle;
    }
    @media print {
        body * {
            visibility: hidden;
        }
        #invoice, #invoice * {
            visibility: visible;
        }
        #invoice {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
    }
    .order-management-card {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    border: none;
}

.order-management-card .card-header {
    background: linear-gradient(to left, #007bff, #0056b3);
    color: white;
    padding: 1rem 1.5rem;
}

.order-management-card .status-badge {
    background-color: #ffffff;
    color: #333;
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-weight: 500;
    font-size: 0.95rem;
}

.employee-info {
    background-color: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.employee-info .icon {
    font-size: 1.6rem;
    color: #0d6efd;
}

.status-control {
    border: 1px solid #dee2e6;
    padding: 1.2rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
}

.status-control .section-title {
    margin-bottom: 1rem;
    font-weight: 600;
    color: #0d6efd;
    display: flex;
    align-items: center;
}

</style>

<!-- سكربتات الوظائف -->
<script>
    function printInvoice() {
        let invoiceContent = document.getElementById("invoice").innerHTML;
        let originalContent = document.body.innerHTML;
        document.body.innerHTML = invoiceContent;
        window.print();
        document.body.innerHTML = originalContent;
        location.reload();
    }
</script>
@endsection
