<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>خطأ {{ $statusCode }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background: #f4f4f4;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        .error-container {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: inline-block;
        }

        h1 {
            color: #c0392b;
            font-size: 40px;
        }

        h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: #007bff;
            color: white;
            border-radius: 6px;
            text-decoration: none;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>⚠️ خطأ {{ $statusCode }}</h1>
        <h2>{{ $errorMessage }}</h2>
        <a href="javascript:history.back()">🔙 العودة إلى الصفحة السابقة</a>
    </div>
</body>
</html>
