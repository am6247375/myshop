<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إنشاء حساب</title>
    <link href="{{asset('assets/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/bootstrap-icons.css')}}" rel="stylesheet">
   <style>
      body {
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .register-container {
            max-width: 500px;
            margin: auto;
            margin-top: 50px;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container" dir="rtl">
       

        <main class="py-4">
            @yield('content')
        </main>
    </div>
  
    <script src="{{asset('assets/bootstrap.bundle.min.js')}}"></script>
</body>
</html>
