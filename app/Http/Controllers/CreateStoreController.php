<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRequest;
use App\Models\Language;
use App\Models\languages;
use App\Models\Store;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateStoreController extends Controller
{

    public function templates()
    {
        $templates = Template::all();
        return view('store_create.templates', compact('templates'));
    }
    public function template_show($template_id, $page_name)
    {
        $template = Template::findOrFail($template_id);

        return view($template->path_temp . '.' . $page_name, compact('template'));
    }
    public function store_create_view($template_id)
    {
        $template_id = $template_id;
        $languages = Language::all();
        return view('store_create.store_create', compact('template_id', 'languages'));
    }
    public function store_create(StoreRequest $request)
    {
        // إنشاء كائن المتجر
        $store = new Store();
        $store->name = $request->name;
        $store->template_id = $request->template_id;
        $store->currency = $request->currency;
        $store->owner_id = $request->owner_id;
        // حفظ المتجر في قاعدة البيانات
        $store->save();
        // ربط المتجر باللغات المختارة
        $store->languages()->attach($request->languages);
        $store_id = $store->id;
        return redirect()->route('dashboard.index', compact('store_id'))
            ->with('success', 'تم إنشاء المتجر بنجاح!');
    }

    public function store_settings_view($store_id)
    {
        $store = Store::findOrFail($store_id);
        $languages = Language::all();
        return view('store_dashboard.store_settings', compact('store','languages'));
    }

    public function support_create_view($store_id)
    {
        $store = Store::findOrFail($store_id);
        $languages = Language::all();
        return view('store_create.support_create', compact('store','languages'));
    }
    public function store_settings(Request $request)
    {
        $store = Store::findOrFail($request->store_id);
        $store->email_link = $request->email_link;
        $store->whatsapp_link = $request->whatsapp_link;
        $store->about = $request->about;
        $store->name = $request->name;
        $store->currency = $request->currency;
        // معالجة رفع الشعار
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = Str::uuid()->toString() . '_' . $request->file('logo')->getClientOriginalName();
            $request->file('logo')->move(public_path('assets/logo'), $logoPath);
            $store->logo = 'assets/logo/' . $logoPath;
        } else {
            $store->logo = $logoPath;
        }
        // حفظ المتجر في قاعدة البيانات
        $store->save();
        // ربط المتجر باللغات المختارة
        if ($request->has('languages')) {
            $store->languages()->sync($request->languages);
        } else {
            // في حال لم يتم تحديد أية لغة، يمكن إلغاء جميع اللغات المرتبطة
            $store->languages()->sync([]);
        }
        $store_id=$store->id;
        return redirect()->route('dashboard.index', compact('store_id'))->with('success', 'تم الامر بنجاح');
    }
    public function conditions_create_view($store_id)
    {
        $store = Store::findOrFail($store_id);
        return view('store_create.conditions_create', compact('store'));
    }

    public function conditions_create(Request $request, $store_id)
    {
        $store = Store::findOrFail($store_id);
        $store->privacy_policy = $request->privacy_policy;
        $store->terms_and_conditions = $request->terms_and_conditions;
        $store->return__policy = $request->return__policy;
        $store->save();
        return redirect()->route('dashboard.index', compact('store_id'))->with('success', 'تم الامر بنجاح');
    }
}
