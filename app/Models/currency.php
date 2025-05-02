<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    /**
     * العلاقة مع المتاجر: عملة لها عدة متاجر
     */
    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
