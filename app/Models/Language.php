<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    // العلاقة مع المتاجر عبر `store_language`
    public function stores()
    {
        return $this->belongsToMany(Store::class, 'store_language')->withTimestamps();
    }
}
