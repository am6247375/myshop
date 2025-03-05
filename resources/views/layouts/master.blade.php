<!DOCTYPE html>
{{-- <html lang="ar" dir="rtl"> --}}
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متجري - منصة إنشاء المتاجر الإلكترونية</title>
    <!-- Bootstrap RTL & أيقونات -->
    <!-- 1) ملفّ Bootstrap RTL الأساسي -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap.rtl.min.css') }}">

    <!-- 2) مكتبة الأيقونات (مثلاً Font Awesome) -->
    <link rel="stylesheet" href="{{ asset('assets/all.min.css') }}">
    <!-- 3) أيقونات أو ملفات إضافية أخرى (icon.css مثلاً) -->
    <link rel="stylesheet" href="{{ asset('assets/icon.css') }}">

    <!-- 4) مكتبة الأنيميشن (إن كنت تستخدمها) -->
    <link rel="stylesheet" href="{{ asset('assets/animate.min.css') }}">
    <link href="{{ asset('assets/css22.css') }}" rel="stylesheet">


    <!-- 5) ملفات التنسيق المخصّصة بمشروعك -->
    <link rel="stylesheet" href="{{ asset('assets/css2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/main.css') }}">
</head>

<body>
    <!-- شريط التقدّم -->
    <div id="progress-bar"></div>

    <!-- شريط التنقّل -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('assets/logoo-removebg.png') }}" alt="شعار المنصّة">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav mx-auto text-center">
                    <li class="nav-item">
                        <a class="nav-link " href="/">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            المميزات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">الآراء</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#use">الدعم</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="nav-link d-flex align-items-center">
                        <span class="material-icons me-1">language</span> English
                    </a>
                    <a href="#" class="btn btn-success">ابدأ تجربتك المجانية</a>
                    @guest
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="nav-link d-flex align-items-center">
                                <span class="material-icons me-1">login</span>تسجيل دخول
                            </a>
                        @endif
                    @else
                        <a class="nav-link d-flex align-items-center" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                            <span class="material-icons me-1">logout</span> تسجيل الخروج
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <!-- الفوتر -->
    <footer class="footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <h4 class="mb-3">عن وبلت</h4>
                    <p>نساعدك في بناء وجودك الرقمي باحترافية وسهولة</p>
                </div>
                <div class="col-md-2">
                    <h4 class="mb-3">روابط سريعة</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="#">المميزات</a></li>
                        <li class="mb-2"><a href="#">الأسعار</a></li>
                        <li class="mb-2"><a href="#">المدونة</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="mb-3">الدعم</h4>
                    <ul id="use" class="list-unstyled">
                        <li class="mb-2"><a href="#">الأسئلة الشائعة</a></li>
                        <li class="mb-2"><a href="#">الدردشة المباشرة</a></li>
                        <li class="mb-2"><a href="#">تواصل معنا</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="mb-3">تابعنا</h4>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 pt-4 border-top border-secondary">
                <p class="mb-0">© 2024 . جميع الحقوق محفوظة</p>
            </div>
        </div>
    </footer>

    <!-- سكريبتات -->
    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap.bundle.min.js') }}"></script>
   <script src="{{ asset('assets/styleJS.js') }}"></script>
</body>

</html>
