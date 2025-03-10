@extends('layouts.master_store_admin')
@section('content_admin')
    <div style="text-align: center ; margin-top: 20px; margin-bottom: 50px">
        <div class="d-flex  justify-content-between  align-items-center m-4">
            <h2>إدارة الاقسام</h2>
            <a href="{{ route('category.create.view', $store->id) }}" class="btn btn-success btn_add">
                <i class="la la-plus"></i> اضافة قسم </a>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th style="text-align: center"> صورة القسم</th>
                        <th style="text-align: center">اسم القسم</th>
                        <th style="text-align: center">عمليات </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $categ)
                        <tr>
                            <td> <img src="{{ asset($categ->image) }}" style="    height: 90px;" alt="{{ $categ->name }}">
                            </td>
                            <td>{{ $categ->name }}</td>
                            <td>
                                <a href="{{-- route('category_update', $categ->id) --}}" class="btn btn-primary btn_edit">
                                    <i class="la la-edit"></i> تعديل
                                </a>
                                <a href="{{-- route('category_delete', $categ->id) --}}"class="btn btn-danger btn_delete"
                                    onclick="return confirmDelete(event, '{{ $categ->name }}')">
                                    <i class="la la-trash"></i> حذف
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
