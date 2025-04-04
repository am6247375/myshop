<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

    <!-- title -->
    <title>{{ trans('string.elctronn') }}</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/assets_template1/img/logo2.png') }}">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/assets_template1/css/all.min.css') }}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/assets_template1/bootstrap/css/bootstrap.min.css') }}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets/assets_template1/css/owl.carousel.css') }}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{ asset('assets/assets_template1/css/magnific-popup.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/assets_template1/css/animate.css') }}">
    <!-- mean menu css -->
    <link rel="stylesheet" href="{{ asset('assets/assets_template1/css/meanmenu.min.css') }}">
    <!-- main style -->
    <link rel="stylesheet" href="{{ asset('assets/assets_template1/css/main.css') }}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('assets/assets_template1/css/responsive.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>

<body>

    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->


    <!-- header -->
    <div class="top-header-area" id="sticker" style="height: 100px;">
        <div class="container-fluid ">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                        <div class="site-logo" style="    width: 250px !important;     max-width: 250px !important; ">
                            @isset($store)
                                @if ($store->logo)
                                    <a href="{{ route('home_store', $store->name) }}">
                                        <img src="{{ asset($store->logo) }}" alt="">
                                    </a>
                                @else
                                    <li style="    text-align: left;">
                                        <a href={{ route('home_store', $store->name) }}" class="logoo">
                                            {{ $store->name }}
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li style="    text-align: left;">
                                    <a href="#" class="logoo">متجري
                                    </a>
                                </li>
                            @endisset

                        </div>
                        <!-- logo -->

                        <!-- menu start -->
                        <nav class="main-menu">
                            <ul dir="{{ trans('string.dir') }}">
                                @isset($store)
                                    <li><a href="{{ route('home_store', $store->name) }}"> {{ trans('string.home') }} </a>
                                    </li>
                                    <li><a href="{{ route('products', $store->name) }}"> {{ trans('string.products') }}
                                        </a></li>
                                    <li><a href="{{ route('conditions',$store->name) }}">سياسة الخصوصية</a></li>
                                    <li><a href="#abut">{{ trans('string.about') }}</a></li>

                                    <li>
                                        <div class="header-icons" style="text-align:center;">
                                            <a class="shopping-cart" href="{{ route('cart.view',['name'=>$store->name]) }}"><i
                                                    class="fas fa-shopping-cart"></i></a>
                                            <a class="mobile-hide search-bar-icon" href="#"><i
                                                    class="fas fa-search"></i></a>

                                            @guest
                                                @if (Route::has('login'))
                                                    <a class="shopping-cart" href="{{ route('login', ['redirectTo' => url()->current()]) }}"><i
                                                            class="fas fa-user"></i></a>
                                                @endif
                                            @else
                                                <a class="shopping-cart" href="{{-- route('logout') --}}"
                                                    onclick="event.preventDefault();
																	 document.getElementById('logout-form').submit();">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                    <input type="hidden" name="redirectTo" value="{{ route('home_store', ['name' => $store->name]) }}">
                                                </form>


                                            @endguest
                                            <!-- تغيير اللغة -->
                                            <div class="dropdown">
                                                <a class="shopping-cart" href="#" title="تغيير اللغة">
                                                    <i class="fas fa-globe"></i>
                                                </a>
                                                <ul class="dropdown-menu" style="text-align:center">
                                                    @foreach ($store->languages as $lang)
                                                        <li>
                                                            <a href="{{ route('lang', $lang->code) }}">
                                                                {{ $lang->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                                
                                            </div>
                                        </div>
                                    </li>
                                @else
                                    <li><a href="{{ route('template.show', [$template->id, 'welcome']) }}">
                                            {{ trans('string.home') }}
                                        </a></li>
                                    <li><a href="{{ route('template.show', [$template->id, 'products_all']) }}">
                                            {{ trans('string.products') }}
                                        </a></li>
                                    <li><a href="#brandd">{{ trans('string.brand') }}</a></li>
                                    <li><a href="#abut">{{ trans('string.about') }}</a></li>

                                    <li>
                                        <div class="header-icons" style="text-align:center;">
                                            <a class="shopping-cart" href="{{-- route('cart') --}}"><i
                                                    class="fas fa-shopping-cart"></i></a>
                                            <a class="mobile-hide search-bar-icon" href="#"><i
                                                    class="fas fa-search"></i></a>
                                            @guest
                                                @if (Route::has('login'))
                                                    <a class="shopping-cart" href="{{-- route('login') --}}"><i
                                                            class="fas fa-user"></i></a>
                                                @endif
                                            @else
                                                <a class="shopping-cart" href="{{-- route('logout') --}}"
                                                    onclick="event.preventDefault();
																	 document.getElementById('logout-form').submit();">
                                                    <i class="fas fa-sign-out-alt"></i>
                                                </a>
                                                <form id="logout-form" hidden action="{{-- route('logout') --}}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            @endguest
                                            <!-- تغيير اللغة -->
                                            <div class="dropdown">
                                                <a class="shopping-cart" href="#" title="تغيير اللغة">
                                                    <i class="fas fa-globe"></i>
                                                </a>
                                                <ul class="dropdown-menu" style="text-align:center">
                                                    <li>
                                                        <a style="color: #000" class="lang"
                                                            href="{{ route('lang', ['locale' => 'en']) }}">English</a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('lang', ['locale' => 'ar']) }}">العربية</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                @endisset

                            </ul>
                        </nav>
                        <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>

                        <div class="mobile-menu"></div>
                        <!-- menu end -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end header -->

    <!-- search area -->
    <div class="search-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <span class="close-btn"><i class="fas fa-window-close"></i></span>
                    <div class="search-bar">
                        <div class="search-bar-tablecell">
                            <form action="{{-- route('search') --}}" method="post">
                                @csrf()
                                <input placeholder="{{ trans('string.search') }}" type="text" id="name"
                                    name="name">
                                <button type="submit">{{ trans('string.search') }}<i
                                        class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end search area -->





    @yield('content');







    <!-- testimonail-section -->
    <div id="abut" class="testimonail-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-10 offset-lg-1 text-center">
                    <div class="testimonial-sliders">
                        @foreach ($reviews as $item)
                            <div class="single-testimonial-slider">
                                <div class="client-avater">
                                    <img src="{{ asset($item->image) }}" alt="">
                                </div>
                                <div class="client-meta">
                                    <h3>{{ $item->name }}</h3>
                                    <p class="testimonial-body" style="text-align: center">" {{ $item->review }} "
                                    </p>
                                    <div class="last-icon">
                                        <i class="fas fa-quote-right"></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <!-- end testimonail-section -->





    <!-- logo carousel -->
    {{-- <div  class="logo-carousel-section" id="brandd">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="logo-carousel-inner">
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/assets_template1/img/company-logos/br1.jpg') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/assets_template1/img/company-logos/br2.jpg') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/assets_template1/img/company-logos/br3.jpg') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/assets_template1/img/company-logos/br4.jpg') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/assets_template1/img/company-logos/br5.jpg') }}" alt="">
                        </div>
                        <div class="single-logo-item">
                            <img src="{{ asset('assets/assets_template1/img/company-logos/br6.jpg') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- end logo carousel -->

    <!-- footer -->
    <div id="contact" class="footer-area">
        <div class="container" dir="rtl">
            <div class="row">
                @if (isset($store) && $store->about !== null)
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-box about-widget">
                            <h2 class="widget-title">{{ trans('string.about') }}</h2>
                            <p style="text-align: center">{{ $store->about }}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6" id="abut">
                        <div class="footer-box get-in-touch">
                            <h2 class="widget-title">{{ trans('string.contact') }}</h2>
                            <ul>
                                @if (isset($store) && ($store->email_link !== null || $store->whatsapp_link !== null))
                                    @if ($store->email_link !== null)
                                        <li>
                                            <a href="mailto:{{ $store->email_link }}">
                                                <i class="fas fa-envelope"></i>
                                                {{ $store->email_link }}
                                            </a>
                                        </li>
                                    @endif
                                    @if ($store->whatsapp_link !== null)
                                        <li>
                                            <a href="https://wa.me/967{{ $store->whatsapp_link }}">
                                                <i class="fab fa-whatsapp"></i>
                                                {{ $store->whatsapp_link }}
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    <li>لايوجد معلومات لتواصل</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-box subscribe">
                            <h2 class="widget-title">{{ trans('string.review_add') }}</h2>
                            <form action="{{-- route('review_add') --}}" method="POST" style="text-align: center">
                                @csrf()
                                <input class="name_review" type="text" name="name"
                                    placeholder="{{ trans('string.name_review') }}">
                                <textarea class="review" name="review" id="" cols="30" placeholder="{{ trans('string.review') }}"
                                    rows="3"></textarea>
                                <button type="submit"><i class="fas fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="col-lg-6 col-md-6" id="abut">
                        <div class="footer-box get-in-touch">
                            <h2 class="widget-title">{{ trans('string.contact') }}</h2>
                            <ul>
                                @if (isset($store) && ($store->email_link !== null || $store->whatsapp_link !== null))
                                    @if ($store->email_link !== null)
                                        <li>
                                            <a href="mailto:{{ $store->email_link }}">
                                                <i class="fas fa-envelope"></i>
                                                {{ $store->email_link }}
                                            </a>
                                        </li>
                                    @endif
                                    @if ($store->whatsapp_link !== null)
                                        <li>
                                            <a href="https://wa.me/967{{ $store->whatsapp_link }}">
                                                <i class="fab fa-whatsapp"></i>
                                                {{ $store->whatsapp_link }}
                                            </a>
                                        </li>
                                    @endif
                                @else
                                    <li>لايوجد معلومات لتواصل</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="footer-box subscribe">
                            <h2 class="widget-title">{{ trans('string.review_add') }}</h2>
                            <form action="{{-- route('review_add') --}}" method="POST" style="text-align: center">
                                @csrf()
                                <input class="name_review" type="text" name="name"
                                    placeholder="{{ trans('string.name_review') }}">
                                <textarea class="review" name="review" id="" cols="30" placeholder="{{ trans('string.review') }}"
                                    rows="3"></textarea>
                                <button type="submit"><i class="fas fa-paper-plane"></i></button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- end footer -->
    <!-- jquery -->
    <script src="{{ asset('assets/assets_template1/js/jquery-1.11.3.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('assets/assets_template1/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- count down -->
    <script src="{{ asset('assets/assets_template1/js/jquery.countdown.js') }}"></script>
    <!-- isotope -->
    <script src="{{ asset('assets/assets_template1/js/jquery.isotope-3.0.6.min.js') }}"></script>
    <!-- waypoints -->
    <script src="{{ asset('assets/assets_template1/js/waypoints.js') }}"></script>
    <!-- owl carousel -->
    <script src="{{ asset('assets/assets_template1/js/owl.carousel.min.js') }}"></script>
    <!-- magnific popup -->
    <script src="{{ asset('assets/assets_template1/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- mean menu -->
    <script src="{{ asset('assets/assets_template1/js/jquery.meanmenu.min.js') }}"></script>
    <!-- sticker js -->
    <script src="{{ asset('assets/assets_template1/js/sticker.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/assets_template1/js/main.js') }}"></script>

</body>

</html>
