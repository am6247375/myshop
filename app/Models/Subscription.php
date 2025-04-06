<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Model: Subscription
class Subscription extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'duration', 'features', 'payment_link'];
    public function getFeaturesArrayAttribute()
    {
        // مثال: إذا كانت القيم مخزنة هكذا: "الميزة الأولى,الميزة الثانية,الميزة الثالثة"
        // يمكن تحويلها إلى مصفوفة بهذا الشكل:
        return explode(',', $this->features);
    }
}