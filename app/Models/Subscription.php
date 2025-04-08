<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Model: Subscription
class Subscription extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'duration', 'features', 'payment_link'];
    
    public function subscribers()
    {
        return $this->hasMany(Subscriber::class, 'subscrip_id');
    }
}