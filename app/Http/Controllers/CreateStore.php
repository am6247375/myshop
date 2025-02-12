<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\languages;
use App\Models\Store;
use App\Models\Template;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class CreateStore extends Controller
{

    public function templates()
    {
        $templates = Template::all();
        return view('store_create.templates', compact('templates'));
    }
    public function store_create_view(Request $request)
    {
        $template_id = $request->template_id;
        $languages = Language::all();
        return view('store_create.store_create', compact('template_id', 'languages'));
    }

    public function store_create(Request $request)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'name' => 'required|string|max:100|unique:stores,name',
            'active' => 'boolean',
           
            'template_id' => 'required|exists:templates,id',
            'languages' => 'required|array',
            'currency' => 'required|string|max:10'
        ]);
     
    
        // التحقق مما إذا كان المستخدم يمتلك متجرًا بالفعل
        if (auth()->user()->store) {
            return redirect()->back()->withErrors(['error' => 'لا يمكنك امتلاك أكثر من متجر.']);
        }
        // رفع الشعار إذا كان موجودًا
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = Str::uuid()->toString() . '_' . $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move(public_path('assets/logo'), $logoPath);

        }
    
        // إنشاء المتجر في قاعدة البيانات
        $store = Store::create([
            'name' => $request->name,
            'active' => 1,  // التأكد من أن `active` إما 1 أو 0
            'logo' => 'assets/logo/'.$logoPath,
            'template_id' => $request->template_id,
            'currency' => $request->currency,
            'whatsapp_link' => $request->whatsapp_link,
            'facebook_link' => $request->facebook_link,
            'instagram_link' => $request->instagram_link,
            'about' => "خييمسىيم",
            'owner_id' => auth()->id(), // ربط المتجر بالمستخدم الحالي
        ]);
 $store->languages()->attach($request->languages);
        $store_id = $store->id;
        // توجيه المستخدم بعد إنشاء المتجر بنجاح
        return redirect()->route('manage.categories', compact('store_id'))->with('success', 'تم إنشاء المتجر بنجاح!');
    }
    
}
