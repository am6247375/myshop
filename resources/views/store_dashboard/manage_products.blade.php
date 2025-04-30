@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container-fluid py-3">
        <div class="card shadow-lg border-0">
            <div class="card-body px-4">
                <div class="tab-content mt-4">
                    <div class="tab-pane fade show active" id="products">
                        <div class="policy-card card mb-4" style="margin-top: 20px; margin-bottom: 50px">
                            <div class="card-body">
                                <!-- العنوان وزر الإضافة -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                    <h3 class="fw-bold mb-0">إدارة المنتجات</h3>
                                    <a href="{{ route('product.create.view',['store_id'=> $store->id]) }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-plus"></i> إضافة منتج
                                    </a>
                                </div>

                                <!-- جدول عرض المنتجات -->
                                <div class="table-responsive text-center">
                                    <table id="myTable" class="table table-striped table-bordered text-center mt-2 mb-4">
                                        <thead >
                                            <tr>
                                                <th>صورة المنتج</th>
                                                <th>اسم المنتج</th>
                                                <th>سعر المنتج</th>
                                                <th>القسم</th>
                                                <th>العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                                @foreach ($category->products as $item)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ asset($item->image) }}" class="img-thumbnail rounded" style="height: 90px;" alt="{{ $item->name }}">
                                                        </td>
                                                        <td>{{ $item->name }}</td>
                                                        <td>{{ $item->price }} $</td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                <a href="{{ route('product.edit.view', ['store_id'=> $store->id,'product_id'=>$item->id]) }}" class="btn btn-primary btn-sm m-1">
                                                                    <i class="fas fa-edit"></i> تعديل
                                                                </a>
                                                                <a href="{{ route('product.delete', ['store_id'=> $store->id,'product_id'=>$item->id]) }}" class="btn btn-danger btn-sm m-1"
                                                                    onclick="return confirmDelete(event, 'المنتج الذي يحمل الاسم : {{ $item->name }}')">
                                                                    <i class="fas fa-trash"></i> حذف
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- نهاية الجدول -->
                            </div> <!-- نهاية جسم البطاقة -->
                        </div> <!-- نهاية البطاقة -->
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
