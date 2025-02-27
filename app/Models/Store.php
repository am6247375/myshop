<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Model: Store
class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'active', 'logo', 'currency', 'whatsapp_link', 
        'email_link', 'template_id', 'owner_id','about'
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    // العلاقة مع اللغات عبر `store_language`
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'store_language')->withTimestamps();
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    
}
