@extends('layouts.master_store_admin')
@section('content_admin')
    <link rel="stylesheet" href="{{ asset('assets/datatables.min.css') }}" />
    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/datatables.min.js') }}"></script>

    @if (session('success'))
        <div class="alert alert-success text-center text-white" style="background-color: #007910 !important;">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger text-center text-white">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="content-wrapper " style="text-align: center">
        <div class="d-flex  justify-content-between  align-items-center m-4">
            <h2>إدارة المنتجات</h2>
            <a href="{{ route('product.create.view',$store->id)}}" class="btn btn-success btn_add">
                <i class="la la-plus"></i> اضافة منتج
            </a>
        </div>

        <div class="table-responsive">
            <table id="myTable" class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
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
                            <td><img src="{{ asset($item->image) }}" class="img-thumbnail" style="height: 90px;" alt="{{ $item->name }}"></td>
                            <td>{{ $item->name }}</td>
                            <td> {{ $item->price }}.$</td>
                            <td>{{ $category->name }}</td>
                            <td>
                                <a href="{{-- route('products_update', $item->id) --}}" class="btn btn-primary btn_edit">
                                    <i class="la la-edit"></i> تعديل
                                </a>
                                <a href="{{-- route('products_delete', $item->id) --}}" class="btn btn-danger btn_delete" onclick="return confirmDelete(event, '{{ $item->name }}')">
                                    <i class="la la-trash"></i> حذف
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function() {
    let table = new DataTable('#myTable', {
        "dom": 'Bfrtip', 
        "language": {
            "search": "🔍 ابحث: ",
            "lengthMenu": "عرض _MENU_ سجل لكل صفحة",
            "info": "عرض _START_ إلى _END_ من _TOTAL_ سجل",
            "infoEmpty": "لا توجد سجلات متاحة",
            "zeroRecords": "لم يتم العثور على نتائج",
            "paginate": {
                "first": "الأول",
                "last": "الأخير",
                "next": "التالي",
                "previous": "السابق"
            }
        }
    });

    // ضمان إعادة تنسيق عنصر البحث بعد تحميل الجدول
    setTimeout(() => {
        document.querySelector('.dataTables_filter').style.textAlign = "center";
    }, 500);
});



    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            setTimeout(() => {
                document.querySelectorAll('.alert').forEach(alert => {
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                });
            }, 2000);
        });
    </script>

    <script>
        function confirmDelete(event, productName) {
            if (!confirm(`هل أنت متأكد أنك تريد حذف المنتج "${productName}"؟`)) {
                event.preventDefault();
            }
        }
    </script>
@endsection
