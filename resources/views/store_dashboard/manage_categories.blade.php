@extends('layouts.master_store_admin')
@section('content_admin')
    <link rel="stylesheet" href="{{ asset('assets/datatables.min.css') }}" />
    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/datatables.min.js') }}"></script>

   
    <div class="content-wrapper " style="text-align: center">
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

        <div class="d-flex  justify-content-between  align-items-center m-4">
            <h2>إدارة الاقسام</h2>
            <a href="{{ route('category.create.view',$store->id)}}" class="btn btn-success btn_add">
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

                            
                            <td> <img src="{{ asset($categ->image) }}" style="    height: 90px;"
                                alt="{{ $categ->name }}"></td>
                            <td>{{ $categ->name }}</td>

                            <td>
                                <a href="{{-- route('category_update', $categ->id) --}}" class="btn btn-primary btn_edit">
                                    <i class="la la-edit"></i> تعديل
                                </a>
                                <a href="{{-- route('category_delete', $categ->id) --}}"class="btn btn-danger btn_delete" onclick="return confirmDelete(event, '{{ $categ->name }}')">
                                    <i class="la la-trash"></i> حذف
                                </a>
                            </td>

                           
                        </tr>
                 
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
        function confirmDelete(event, categoryName) {
            // عرض رسالة تأكيد مع اسم الفئة
            const confirmation = confirm(`هل أنت متأكد أنك تريد حذف المنتج "${categoryName}"؟`);

            // إذا اختار "إلغاء" يتم منع الانتقال للرابط
            if (!confirmation) {
                event.preventDefault(); // منع الإجراء الافتراضي
            }

            return confirmation; // يسمح بالإجراء فقط عند اختيار "موافق"
        }
    </script>




@endsection
