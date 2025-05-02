<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        // التحقق من البيانات المدخلة
        return [
            'name' => 'required|string|max:100|unique:stores,name',
            'owner_id' => 'unique:stores,owner_id',
            'template_id' => 'required|exists:templates,id',
            'languages' => 'required|array',
            'currency_id' => 'required|exists:currencies,id'
        ];
    }
    public function messages()
    {
        return [
            'name.required'        => 'يرجى إدخال اسم المتجر.',
            'name.string'          => 'اسم المتجر يجب أن يكون نصاً.',
            'name.max'             => 'اسم المتجر يجب ألا يتجاوز 100 حرف.',
            'name.unique'          => 'اسم المتجر مستخدم بالفعل. يرجى اختيار اسم آخر.',
            'owner_id.unique'      => 'لقد قمت بإنشاء متجر مسبقاً.',
            'template_id.required' => 'يرجى اختيار قالب للمتجر.',
            'template_id.exists'   => 'القالب المحدد غير موجود.',
            'languages.required'   => 'يجب اختيار لغة واحدة على الأقل.',
            'languages.array'      => 'صيغة اللغات المختارة غير صحيحة.',
            'currency_id.required'    => 'يرجى تحديد العملة.',
            'currency_id.exists'      => 'العملة المحددة غير موجودة.',
        ];
    }
}
