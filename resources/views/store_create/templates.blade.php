
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select a Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }

        .template-card {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s ease;
        }

        .template-card:hover {
            transform: scale(1.05);
        }

        .template-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }

        .template-name {
            font-size: 18px;
            font-weight: bold;
            margin: 15px 0;
        }

        .select-button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .select-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <h1>Select a Template for Your Store</h1>

    <div class="container">
        @foreach ($templates as $template)
            <div class="template-card">
                <!-- صورة القالب -->
            <img src="{{asset('temp2/imgg.jpg')}}" alt="Template Image" class="template-image">

                <!-- اسم القالب -->
                <div class="template-name">{{ $template->name }}</div>

                <!-- زر اختيار القالب -->
                <form action="{{ route('store.create.view')}}" method="POST">
                    @csrf
                    <input type="hidden" name="template_id" value="{{ $template->id }}">
                    <button type="submit" class="select-button">اختر هذا القالب</button>
                </form>
            </div>
        @endforeach
    </div>
</body>
</html>
