<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model: Template
class Template extends Model
{
    use HasFactory;
    protected $fillable = ['name','path_temp'];
    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}