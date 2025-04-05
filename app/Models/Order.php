<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // يمكنك تحديد الجداول والخصائص حسب الحاجة
    protected $fillable = [
        'user_id', 
        'store_id',
        'customer_id', 
        'recipient_name', 
        'recipient_phone', 
        'recipient_address', 
        'note',
        'status', 
        'total_price'
    ];
    
    // تحديد العلاقات إذا لزم الأمر
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
