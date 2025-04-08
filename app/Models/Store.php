<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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


    public function subscribers()
    {
        return $this->hasMany(Subscriber::class);
    }

    // نهاية فترة التجربة المجانية
    public function freeEnd()
    {
        return $this->created_at->copy()->addDays(30); // أو 5 حسب النظام
    }

    // هل انتهت فترة التجربة المجانية؟
    public function hasfreeEnd(): bool
    {
        return now()->greaterThan($this->freeEnd());
    }

    // الاشتراك الفعّال الحالي
    public function activeSub()
    {
        return $this->subscribers()
            ->where('end_date', '>=', now())
            ->latest('end_date')
            ->first();
    }
    public function Subtime(): ?array
    {

        $subscription = $this->activeSub();

        if (!$subscription) {
            return null; // لا يوجد اشتراك فعّال
        }

        $now = now();
        $end = $subscription->end_date;
        return [
            'days' => $now->diffInDays($end, false),
            'hours' => $now->diffInHours($end, false) % 24,
        ];
    }

    // الفرق بين الآن ونهاية التجربة
    public function freetime(): array
    {
        $now = now();
        $end = $this->freeEnd();
        return [
            'days' => $now->diffInDays($end, false),
            'hours' => $now->diffInHours($end, false) % 24,
        ];
    }
    // في موديل Store
    public function remainingTime(): ?array
    {
        // إذا كان هناك اشتراك فعّال
        $subscription = $this->activeSub();
        if ($subscription) {
            $now = now();
            $end = $subscription->end_date;

            return [
                'type' => 'subscription',
                'days' => $now->diffInDays($end, false),
                'hours' => $now->diffInHours($end, false) % 24,
            ];
        }

        // إذا انتهت فترة التجربة المجانية ولم يكن هناك اشتراك فعّال
        $freeTime = $this->freetime();
        return [
            'type' => 'free_trial',
            'days' => $freeTime['days'],
            'hours' => $freeTime['hours'],
        ];
    }
}
