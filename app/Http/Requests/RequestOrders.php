<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestOrders extends FormRequest
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
            'store_id' => 'required|exists:stores,id',
            'recipient_name' => 'required|string|max:255',
            'recipient_phone' => 'required|string|max:9|min:9',
            'recipient_address' => 'required|string',
            'note' => 'nullable|string|max:500',
        ];
    }
    public function messages()
    {
        return [
            'store_id.required' => 'رقم المتجر مطلوب.',
            'store_id.exists' => 'رقم المتجر غير صالح.',
            'recipient_name.required' => 'اسم المستلم مطلوب.',
            'recipient_phone.required' => 'رقم الهاتف مطلوب.',
            'recipient_phone.max' => 'يجب رقم الهاتف لايتجاوز عن 9 ارقام',
            'recipient_phone.min' => 'يجب رقم الهاتف لايقل عن 9 ارقام',
            'recipient_address.required' => 'عنوان المستلم مطلوب.',
            'note.max'=>'الحد الاقصى لعدد حروف الملاحظة 500 حرف'
        ];
    }
}
