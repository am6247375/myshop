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


    <link rel="stylesheet" href="{{ asset('assets/animate.min.css') }}">
    <link href="{{ asset('assets/css22.css') }}" rel="stylesheet">


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
                <img src="{{ asset('assets/logoo-removebg.png') }}"  alt="شعار المنصّة">
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
                        <a class="nav-link" href="#features">
                            المميزات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">الآراء</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('subscribe.view') }}">الاسعار</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#use">تواصل معنا</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cont">من نحن</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">

                 
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
    <!-- الفوتر -->
    <footer class="footer mt-5">
        <div class="container text-start text-md-center">
            <div class="row">
                <!-- معلومات المنصة -->
                <div class="col-md-4 mb-4" id="cont">
                    <h5>منصة متجري</h5>
                    <p>متجري هي منصة عربية مبتكرة تتيح لأي شخص إنشاء متجر إلكتروني
                        احترافي خلال دقائق، دون الحاجة لأي خبرة تقنية.
                        صممت لتكون سهلة، سريعة، وآمنة،
                        لتناسب احتياجاتك.</p>
                </div>
                <!-- روابط سريعة -->
                <div class="col-md-4 mb-4">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="/">الرئيسية</a></li>
                        <li><a href="#features">المميزات</a></li>
                        <li><a href="#testimonials">الآراء</a></li>
                        <li><a href="#use">تواصل معنا</a></li>
                    </ul>
                </div>
                <!-- تواصل اجتماعي -->
                <div class="col-md-4 mb-4" id="use">
                    <h5>تواصل معنا</h5>
                    <div class="social-icons d-flex justify-content-md-center justify-content-center">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="https://wa.me/123456789" target="_blank"><i class="fab fa-whatsapp"></i></a>
                    </div>
                    <p class="mt-3"><i class="fas fa-envelope me-2"></i> info@matjary.com</p>
                    <p><i class="fas fa-phone me-2"></i> 123456789</p>
                </div>
            </div>
            <div class="copyright text-center mt-3">
                <small>جميع الحقوق محفوظة &copy; {{ date('Y') }} متجري</small>
            </div>
        </div>
    </footer>


    <!-- سكريبتات -->
    <script src="{{ asset('assets/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/styleJS.js') }}"></script>
    <script>
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');
    
        window.addEventListener("scroll", () => {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
    
            if (currentScroll > lastScrollTop) {
                navbar.style.top = "-100px"; // إخفاء الشريط
            } else {
                navbar.style.top = "0"; // إظهار الشريط
            }
    
            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });
    </script>
    
</body>

</html>
