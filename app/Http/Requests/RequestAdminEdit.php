<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestAdminEdit extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', 'regex:/@.+\.[a-zA-Z]{1,}$/i'],
            'phone' => 'required|string|max:20|regex:/^\+?[0-9\s\-]+$/',
             'sex' => 'required|in:male,female',
           
            'permissions' => 'required|array|min:1',
            'permissions.*' => 'exists:permissions,id',
            'nullable|min:6', 
        ];
    }
    
    public function messages()
    {
        return [
            'first_name.required' => 'يرجى إدخال الاسم الأول.',
            'first_name.string' => 'يجب أن يكون الاسم الأول نصًا.',
            'first_name.max' => 'يجب ألا يتجاوز الاسم الأول 255 حرفًا.',
    
            'last_name.required' => 'يرجى إدخال الاسم الأخير.',
            'last_name.string' => 'يجب أن يكون الاسم الأخير نصًا.',
            'last_name.max' => 'يجب ألا يتجاوز الاسم الأخير 255 حرفًا.',
    
            'phone.required' => 'يرجى إدخال رقم الهاتف.',
            'phone.string' => 'يجب أن يكون رقم الهاتف نصيًا.',
            'phone.max' => 'يجب ألا يتجاوز رقم الهاتف 9  رقمًا.',
            'phone.regex' => 'يرجى إدخال رقم هاتف صالح باستخدام الأرقام فقط.',
    
            'sex.required' => 'يرجى تحديد الجنس.',
            'sex.in' => 'يجب أن يكون الجنس إما male أو female.',
    
            'email.regex' => 'يجب أن يحتوي البريد الإلكتروني على نقطة (.) بعد @ ويتبعها حرف واحد على الأقل.',
            'email.required' => 'يرجى إدخال البريد الإلكتروني.',
    
            'sex.required' => 'يرجى تحديد الجنس.',
            'sex.in' => 'يجب أن يكون الجنس إما male أو female.',
    
          
    
            'permissions.required' => 'يرجى تحديد الصلاحيات.',
            'permissions.array' => 'يجب أن تكون الصلاحيات في شكل قائمة.',
            'permissions.min' => 'يجب اختيار صلاحية واحدة على الأقل.',
            'permissions.*.exists' => 'إحدى الصلاحيات المحددة غير صحيحة.',
    
            'password.required' => 'يرجى إدخال كلمة المرور.',
            'password.min' => 'يجب أن تحتوي كلمة المرور على 6 أحرف على الأقل.',
        ];
    }
    
}
