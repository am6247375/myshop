@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container-fluid py-3">
        <div class="card shadow-lg border-0">
            <div class="card-body px-4">
                <div class="tab-content mt-4">
                    <div class="tab-pane fade show active" id="categoryories">
                        <div class="policy-card card mb-4" style="margin-top: 20px; margin-bottom: 50px">
                            <div class="card-body">
                                <!-- العنوان والزر -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                    <h3 class="fw-bold mb-0">إدارة الأقسام</h3>
                                    <a href="{{ route('category.create.view', $store->id) }}" class="btn btn-success btn-lg">
                                        <i class="fas fa-plus"></i>  إضافة قسم
                                    </a>
                                </div>

                                <!-- جدول عرض الأقسام -->
                                <div class="table-responsive text-center">
                                    <table id="myTable" class="table table-striped table-bordered text-center mt-2 mb-4" style="table-layout: fixed;">

                                        <thead>
                                            <tr>
                                                <th>صورة القسم</th>
                                                <th>اسم القسم</th>
                                                <th>الإجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td>
                                                        <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" style="height: 90px; border-radius: 10px;">
                                                    </td>
                                                    <td>{{ $category->name }}</td>
                                                    <td>
                                                        <div class="d-flex gap-2 justify-content-center">
                                                            <a href="{{ route('category.edit.view',['store_id'=> $store->id,'category_id'=>$category->id]) }}" class="btn btn-primary btn-sm m-1">
                                                                <i class="fas fa-edit"></i> تعديل
                                                            </a>
                                                            <a href="{{ route('category.delete',['store_id'=> $store->id,'category_id'=>$category->id]) }}" class="btn btn-danger btn-sm m-1"
                                                                onclick="return confirmDelete(event, 'القسم الذي يحمل الاسم : {{ $category->name }}')">
                                                                <i class="fas fa-trash"></i> حذف
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
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
