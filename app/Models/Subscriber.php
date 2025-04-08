<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'subscrip_id',
        'start_date',
        'end_date',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function subscription()
    {
        return $this->belongsTo(Subscription::class, 'subscrip_id');
    }

    public function isActive()
    {
        return $this->end_date >= now();
    }
}

