<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Subscriber extends Model
{
    use HasFactory;
    protected $fillable = ['store_id', 'start_date', 'end_date'];
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
