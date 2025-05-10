<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            [
                'first_name' => ['required', 'string', 'alpha', 'max:255'],
                'last_name' => ['required', 'string', 'alpha', 'max:255'],
                'phone'      => ['required', '', 'max:255'],
                'sex'        => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/@.+\.[a-zA-Z]{1,}$/i'],
                'password'   => ['required', 'string'],
            ],
            $this->messages() // تمرير رسائل التحقق المخصصة
        );
    }

    public function messages()
    {
        return [
            'first_name.required' => 'يرجى إدخال الاسم الأول.',
            'first_name.string'   => 'الاسم الأول يجب أن يكون نصاً.',
            'first_name.alpha'   => 'الاسم يجب أن يكون مكون من حروف فقط.',
            'first_name.max'      => 'يجب ألا يتجاوز الاسم الأول 255 حرفاً.',

            'last_name.required'  => 'يرجى إدخال الاسم الأخير.',
            'last_name.string'    => 'الاسم الأخير يجب أن يكون نصاً.',
            'last_name.alpha'   => 'الاسم يجب أن يكون مكون من حروف فقط.',
            'last_name.max'       => 'يجب ألا يتجاوز الاسم الأخير 255 حرفاً.',

            'phone.required'      => 'يرجى إدخال رقم الهاتف.',
            'phone.string'        => 'رقم الهاتف يجب أن يكون نصاً.',
            'phone.max'           => 'يجب ألا يتجاوز رقم الهاتف 255 حرفاً.',

            'sex.required'        => 'يرجى تحديد الجنس.',

            'email.required'      => 'يرجى إدخال البريد الإلكتروني.',
            'email.string'        => 'البريد الإلكتروني يجب أن يكون نصاً.',
            'email.email'         => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.max'           => 'يجب ألا يتجاوز البريد الإلكتروني 255 حرفاً.',
            'email.unique'        => 'البريد الإلكتروني مستخدم بالفعل.',
            'email.regex' => 'يجب أن يحتوي البريد الإلكتروني على نقطة (.) بعد @ ويتبعها حرف واحد على الأقل.',
            'password.required'   => 'يرجى إدخال كلمة المرور.',
            'password.string'     => 'كلمة المرور يجب أن تكون نصاً.',
        ];
    }

    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'phone'      => $data['phone'],
            'sex'        => $data['sex'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);
    }
}
