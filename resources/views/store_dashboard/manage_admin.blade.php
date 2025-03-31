@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container-fluid py-5">
        <div class="card shadow-lg border-0">
            <div class="card-body px-4">
                <div class="tab-content mt-4">
                    <!-- Admins Tab -->
                    <div class="tab-pane fade show active" id="admins">
                        <div class="policy-card card mb-4" style="margin-top: 20px; margin-bottom: 50px">
                            <div class="card-body">
                                <!-- عنوان الزر + العنوان -->
                                <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
                                    <h3 class="fw-bold mb-0">قائمة الموظفين</h3>
                                    <a href="{{ route('admin.create.view', ['store_id' => $store->id])}}" class="btn btn-success btn-lg">
                                        <i class="fas fa-plus"></i> إضافة موظف جديد
                                    </a>
                                </div>  

                                <!-- الجدول مع خاصية التمرير -->
                                <div class="table-responsive" style="text-align: center">
                                    <table id="myTable"class="table table-striped table-bordered text-center mt-2 mb-4">
                                        <thead>
                                            <tr>
                                                <th>الاسم</th>
                                                <th>الجنس</th>
                                                <th>الهاتف</th>
                                                <th>الدور</th>
                                                <th>الصلاحيات</th>
                                                <th>الإجراء</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($admins as $adminGroup)
                                                @php
                                                    $user = $adminGroup->first()->user; // الحصول على المستخدم الفعلي
                                                    $roles = $adminGroup->pluck('role.name')->filter()->unique()->join(', ');
                                                    $permissions = $adminGroup->pluck('permission.name')->filter()->unique()->join(' , ');
                                                @endphp
                                                <tr>
                                                    <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                                    <td>{{ $user->sex }}</td>
                                                    <td style="text-align: center">{{ $user->phone }}</td>
                                                    <td>{{ $roles ?: 'بدون دور' }}</td>
                                                    <td>{{ $permissions ?: 'بدون صلاحيات' }}</td>
                                                    <td>
                                                        <button class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash-alt"></i> إزالة
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div> <!-- نهاية div الجدول -->
                            </div>
                        </div> <!-- نهاية div البطاقة -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
