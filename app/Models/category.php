<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image', 'description', 'store_id'];
    
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
