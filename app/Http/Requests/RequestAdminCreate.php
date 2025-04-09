<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestAdminCreate extends FormRequest
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
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
            'email' => 'required|email',
            'phone' => 'required|string|max:20|regex:/^\+?[0-9\s\-]+$/',
            'sex' => 'required|in:male,female',
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array|min:1',
'permissions.*' => 'exists:permissions,id',
            'store_id' => 'required|exists:stores,id',
        ];
    }
    
   public function messages()
{
    return [
        'first_name.required' => 'يرجى إدخال الاسم الأول.',
        'first_name.string' => 'يجب أن يكون الاسم الأول نصًا.',
        'first_name.max' => 'يجب ألا يتجاوز الاسم الأول 255 حرفًا.',

        'last_name.required' => 'يرجى إدخال الاسم الأخير.',
        'last_name.string' => 'يجب أن يكون الاسم الأخير نصيًا.',
        'last_name.max' => 'يجب ألا يتجاوز الاسم الأخير 255 حرفًا.',

        'password.required' => 'يرجى إدخال كلمة المرور.',
        'password.string' => 'يجب أن تكون كلمة المرور نصًا.',
        'password.min' => 'يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل.',

        'phone.required' => 'يرجى إدخال رقم الهاتف.',
        'phone.string' => 'يجب أن يكون رقم الهاتف نصيًا.',
        'phone.max' => 'يجب ألا يتجاوز رقم الهاتف 20 رقمًا.',
        'phone.regex' => 'يرجى إدخال رقم هاتف صالح باستخدام الأرقام فقط.',

        'sex.required' => 'يرجى تحديد الجنس.',
        'sex.in' => 'يجب أن يكون الجنس إما male أو female.',

        'role_id.required' => 'يرجى اختيار دور المستخدم.',
        'role_id.exists' => 'الدور المحدد غير موجود.',

        'permissions.required' => 'يرجى اختيار صلاحية واحدة على الأقل.',
        'permissions.array' => 'الرجاء تحديد صلاحيات صحيحة.',
        'permissions.min' => 'يرجى اختيار صلاحية واحدة على الأقل.',
        'permissions.*.exists' => 'صلاحية غير صالحة.',

        'store_id.required' => 'يرجى تحديد المتجر.',
        'store_id.exists' => 'المتجر المحدد غير موجود.',
    ];
}
   
}
