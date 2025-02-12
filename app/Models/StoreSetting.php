<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model: StoreSetting
class StoreSetting extends Model
{
    use HasFactory;
    protected $fillable = ['logo', 'languages', 'currency', 'whatsapp_link', 'facebook_link', 'instagram_link', 'store_id'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
