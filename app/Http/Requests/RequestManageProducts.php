<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestManageProducts extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم المنتج.',
            'name.string' => 'يجب أن يكون اسم المنتج نصًا.',
            'name.max' => 'يجب ألا يتجاوز اسم المنتج 255 حرفًا.',
            
            'image.required' => 'يرجى تحميل صورة المنتج.',
            'image.image' => 'يجب أن يكون الملف المرفق صورة.',
            'image.mimes' => 'يجب أن تكون الصورة بصيغة: jpeg, png, jpg, gif.',
            'image.max' => 'يجب ألا يتجاوز حجم الصورة 2MB.',
    
            'description.string' => 'يجب أن يكون الوصف نصيًا.',
    
            'price.required' => 'يرجى إدخال سعر المنتج.',
            'price.numeric' => 'يجب أن يكون السعر رقمًا.',
            'price.min' => 'يجب ألا يكون السعر أقل من 0.',
    
            'category_id.required' => 'يرجى اختيار القسم.',
            'category_id.exists' => 'القسم المحدد غير موجود.',
        ];
    }
    
}
