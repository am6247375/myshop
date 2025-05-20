<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 3 | Dashboard</title>
    <!-- جعل التصميم متوافق مع مختلف الشاشات -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('assets_admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('assets_admin/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/daterangepicker/daterangepicker.cs') }}s">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Bootstrap 4 RTL -->
    <link rel="stylesheet" href="{{ asset('assets_admin/plugins/bootstrap/bootstrap.min.css') }}">
    <!-- ملف التنسيقات المخصص -->
    <link rel="stylesheet" href="{{ asset('assets_admin/dist/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets_admin/css/main.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/datatables.min.css') }}" />

</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">

        <!-- Navbar أعلى الصفحة -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- زر إخفاء وإظهار القائمة الجانبية -->
            <ul class="navbar-nav">
                <li class="nav-item" style="text-align: center; margin: 10px 10px;">
                    <a class="nav-link menuu" data-widget="pushmenu" href="#">
                        <i class="fas fa-bars"></i>
                    </a>
                </li>
                <li class="nav-item" style="text-align: center; margin: 10px 0;">
                    <a class="nav-link" id="copy-link" href="#"
                        onclick="copyToClipboard('http://127.0.0.1:8000/store/{{ $store->name }}')">
                        <i class="fas fa-copy" style="margin-right: 8px; font-size: 18px;"></i>
                        <span>
                            {{ 'http://127.0.0.1:/store/' . $store->name }}
                            نسخ رابط المتجر
                        </span>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4" id="uu">
            <!-- معاينة المتجر -->
            <div class="brand-container text-center py-3">
                <div class="mt-2">
                    <a href="{{ route('home_store', $store->name) }}" target="_blank"
                        class="btn btn-outline-light btn-med ">
                        <i class="fas fa-eye mr-1"></i>
                        معاينة المتجر
                    </a>
                </div>
            </div>
            <div class="sidebar">
                <!-- Sidebar Menu -->
                @php
                    $permissionMap = [
                        'ادارة الاقسام' => ['route' => 'manage.categories', 'icon' => 'fa-list-alt'],
                        'ادارة المنتجات' => ['route' => 'manage.products', 'icon' => 'fa-boxes'],
                        'ادارة الطلبات' => ['route' => 'orders.manage', 'icon' => 'fa-shopping-bag'],
                        'ادارة الصفحات القانونية' => [
                            'route' => 'conditions.create.view',
                            'icon' => 'fa-balance-scale-left',
                        ],
                        'ادارة الموظفين' => ['route' => 'manage.admin', 'icon' => 'fa-users'],
                        'الاعدادات' => ['route' => 'store.settings.view', 'icon' => 'fa-cogs'],
                    ];
                @endphp

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- الرئيسية -->
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index', $store->id) }}" class="nav-link">
                                <i class="fas fa-home nav-icon"></i>
                                <p>الرئيسية</p>
                            </a>
                        </li>

                        @foreach ($permissions ?? [] as $permission)
                            @php
                                $config = $permissionMap[$permission->name] ?? null;
                            @endphp

                            @if ($config)
                                <li class="nav-item">
                                    <a href="{{ route($config['route'], ['store_id' => $store->id]) }}"
                                        class="nav-link">
                                        <i class="fas {{ $config['icon'] }} nav-icon"></i>
                                        <p>{{ $permission->name }}</p>
                                    </a>
                                </li>
                            @endif
                        @endforeach

                        <!-- تسجيل الخروج -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt nav-icon"></i>
                                <p>تسجيل الخروج</p>
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </nav>

                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- /القائمة الجانبية --> 

        <!-- المحتوى الرئيسي -->
        <div class="content-wrapper">
            @if (session('success'))
            <div class="alert alert-custom alert-success alert-dismissible fade show" role="alert" id="success-alert">
                <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close-custom" onclick="closeAlert('success-alert')" aria-label="Close">
                        &times;
                    </button>
                </div>
            </div>
        @endif
        
        @if ($errors->any())
            <div class="alert alert-custom alert-danger alert-dismissible fade show" role="alert" id="error-alert">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>حدثت الأخطاء التالية:</strong>
                        </div>
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close-custom" onclick="closeAlert('error-alert')" aria-label="Close">
                        &times;
                    </button>
                </div>
            </div>
        @endif
        
            @yield('content_admin')
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar (اختياري) -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- محتوى جانبي إضافي -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <script src="{{ asset('assets_admin/main.js') }}"></script>

    <!-- jQuery -->
    <script src="{{ asset('assets_admin/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('assets_admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script>
        window.StoreName = "{{ $store->name }}";
    </script>

    <!-- Bootstrap 4 rtl -->
    <script src="{{ asset('assets/bootstrap.min.css') }}"></script>
    <script src="{{ asset('assets_admin/plugins/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/bootstrap.bundle.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets_admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('assets_admin/plugins/chart.js/Chart.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('assets_admin/plugins/sparklines/sparkline.js') }}"></script>
    <!-- JQVMap -->
    <script src="{{ asset('assets_admin/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('assets_admin/plugins/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('assets_admin/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('assets_admin/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('assets_admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('assets_admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <!-- Summernote -->
    <script src="{{ asset('assets_admin/plugins/summernote/summernote-bs4.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets_admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets_admin/dist/js/adminlte.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets_admin/dist/js/demo.js') }}"></script>
    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/datatables.min.js') }}"></script>

</body>

</html>
