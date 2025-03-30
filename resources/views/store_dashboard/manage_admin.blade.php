@extends('layouts.master_store_admin')

@section('content_admin')
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <!-- Card Header -->
            <div class="card-header bg-gradient-primary text-white py-4" id="card-header">
                <h2 class="mb-0 fw-bold">
                    <i class="fas fa-users-cog me-2"></i>
                    إدارة المدراء والموظفين
                </h2>
            </div>

            <!-- Tabs Navigation -->

            <!-- Form Container -->
            <div class="card-body px-4">
                <div class="tab-content mt-4">
                    <!-- Admins Tab -->
                    <div class="tab-pane fade show active" id="admins">
                        <div class="policy-card card mb-4"
                            style="text-align: center ; margin-top: 20px; margin-bottom: 50px">
                            <div class="card-body">
                                <table id="myTable" class="table table-striped table-bordered text-center mt-2 mb-4">
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
                                            $permissions = $adminGroup->pluck('permission.name')->filter()->unique()->join(', ');
                                        @endphp
                                        <tr>
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            <td>{{ $user->sex }}</td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ $roles ?: 'بدون دور' }}</td>
                                            <td>{{ $permissions ?: 'بدون صلاحيات' }}</td>
                                            <td><button class="btn btn-danger btn-sm">إزالة</button></td>
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
@endsection
