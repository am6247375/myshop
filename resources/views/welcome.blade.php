<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>منصة التجارة الإلكترونية</title>
    <script src="{{asset('assets/tailwindcss.js')}}"></script>
</head>
<body class="bg-[#F8FCFB]">
    {{-- <header class="bg-white shadow-md p-4 flex justify-between items-center px-10">
        <div class="flex items-center space-x-6">
            <img src="{{asset('assets/logo.png')}}" alt="Logo" class="h-20">
            <nav class="flex space-x-4">
                <a href="#" class="text-gray-600 hover:text-green-600 font-medium">الرئيسية</a>
                <a href="#" class="text-gray-600 hover:text-green-600 font-medium">المتجر</a>
                <a href="#" class="text-gray-600 hover:text-green-600 font-medium">الأسعار</a>
                <a href="#" class="text-gray-600 hover:text-green-600 font-medium">أدوات</a>
            </nav>
        </div>
        <button class="bg-green-500 text-white px-6 py-2 rounded-lg font-medium shadow-md">ابدأ 7 أيام مجانًا</button>
    </header> --}}

    <section class=" text-center  justify-between px-20 py-16 ">
        <div class=" text-center">
            <h1 class="text-5xl font-extrabold text-green-700 leading-tight">أفضل بديل عربي لإنشاء متجرك بنفسك في 5 دقائق!</h1>
            <ul class="mt-6 space-y-2 text-gray-600 font-medium">
                <li> لا حاجة لأي خبرة في البرمجة والتصميم ✔️</li>
                <li> دعم فني مميز✔️</li>
                <li> ميزانية بسيطة ✔️</li>
            </ul>
            <a href="{{route('register')}}"><button class="mt-8 bg-green-500 text-white px-8 py-3 rounded-lg font-medium shadow-lg">ابدأ تجربتك المجانية الآن</button></a>
        </div>
        {{-- <div class="lg:w-1/2 mt-10 lg:mt-0">
            <img src="hero-image.png" alt="منصة التجارة" class="rounded-lg shadow-lg">
        </div> --}}
    </section>

    <section class="p-12 bg-white text-center">
        <h2 class="text-3xl font-semibold text-gray-700">+350 ألف عميل حول العالم يثقون في منصتنا</h2>
        <p class="text-gray-500 mt-4">انضم لأكثر من 200 ألف متجر إلكتروني ناجح</p>
        <div class="mt-6 flex justify-center items-center space-x-4">
            <span class="text-yellow-500 text-3xl font-bold">⭐ 4.9/5</span>
            <span class="text-gray-600 font-medium">معدل رضا العملاء</span>
        </div>
        {{-- <div class="mt-4 flex justify-center space-x-6">
            <img src="capterra.png" alt="Capterra" class="h-10">
            <img src="crowd.png" alt="Crowd" class="h-10">
            <img src="google.png" alt="Google" class="h-10">
        </div> --}}
    </section>
</body>
</html>
