<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // يمكنك تحديد الجداول والخصائص حسب الحاجة
    protected $fillable = [
        'order_id', 
        'product_id', 
        'quantity', 
        'price', 
        'total_price'
    ];

    // تحديد العلاقة مع الطلب
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // تحديد العلاقة مع المنتج
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
