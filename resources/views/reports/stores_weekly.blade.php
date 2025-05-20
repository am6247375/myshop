<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تقرير المتاجر</title>
    <style>
        body {
            font-family: DejaVu Sans;
            direction: rtl;
            text-align: right;
            margin: 40px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #bbb;
            padding: 10px;
            font-size: 14px;
        }

        th {
            background-color: #3498db;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        footer {
            position: fixed;
            bottom: 10px;
            text-align: center;
            width: 100%;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <h2>📊 تقرير المتاجر الأسبوعي</h2>

    <table>
        <thead>
            <tr>
                <th>اسم المتجر</th>
                <th>الحالة</th>
                <th>اسم المالك</th>
                <th>البريد الإلكتروني</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stores as $store)
                <tr>
                    <td>{{ $store->name }}</td>
                    <td style="color: {{ $store->active ? 'green' : 'red' }};">
                        {{ $store->active ? 'مفعل' : 'غير مفعل' }}
                    </td>
                    <td>{{ $store->owner->first_name . ' ' . $store->owner->last_name }}</td>
                    <td>{{ $store->owner->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        تم إنشاء هذا التقرير بواسطة منصة إدارة المتاجر - {{ now()->format('Y-m-d') }}
    </footer>
</body>
</html>
