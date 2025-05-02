<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Model: Store
class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'active',
        'logo',
        'currency',
        'whatsapp_link',
        'email_link',
        'template_id',
        'owner_id',
        'about'
    ];
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function storeManagement()
    {
        return $this->hasMany(StoreManagement::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
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
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

// في موديل Store

public function subscribers()
{
    return $this->hasMany(Subscriber::class);
}

// نهاية فترة التجربة المجانية
public function freeEnd()
{
    return $this->created_at->copy()->addDays(14); // غيّر إلى 5 إذا كانت التجربة 5 أيام
}

// هل انتهت فترة التجربة المجانية؟
public function hasfreeEnd(): bool
{
    return now()->greaterThan($this->freeEnd());
}

// آخر اشتراك (حتى لو منتهي)
public function latestSub()
{
    return $this->subscribers()
        ->latest('end_date')
        ->first();
}

// الاشتراك الفعّال فقط
public function activeSub()
{
    return $this->subscribers()
        ->where('end_date', '>=', now())
        ->latest('end_date')
        ->first();
}
public function typesub()
{
    return $this->subscribers();
    
}

// الوقت المتبقي للاشتراك الفعّال (أو التجربة المجانية)
public function remainingTime(): ?array
{
    $subscription = $this->latestSub(); // نأخذ آخر اشتراك، حتى لو منتهي

    if ($subscription) {
        $now = now();
        $end = $subscription->end_date;

        return [
            'type' => 'subscription',
            'days' => $now->diffInDays($end, false),
            'hours' => $now->diffInHours($end, false) % 24,
        ];
    }

    // إذا لا يوجد أي اشتراك → نرجع معلومات التجربة المجانية
    $freeTime = $this->freetime();
    return [
        'type' => 'free_trial',
        'days' => $freeTime['days'],
        'hours' => $freeTime['hours'],
    ];
}

// الفرق بين الآن ونهاية التجربة المجانية
public function freetime(): array
{
    $now = now();
    $end = $this->freeEnd();
    return [
        'days' => $now->diffInDays($end, false),
        'hours' => $now->diffInHours($end, false) % 24,
    ];
}

}
