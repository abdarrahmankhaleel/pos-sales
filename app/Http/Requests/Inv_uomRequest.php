<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Inv_uomRequest extends FormRequest
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
         'name'=>'required',
         'is_master'=>'required',
         'active'=>'required',
        ];
    }

    public function messages()
    {
        return [
        'name.required'=>'اسم الموحدة مطلوب',
        'is_master.required'=>'نوع الوحدة مطلوب',
        'active.required'=>'حالة تفعيل الوحدة مطلوب',
        ];
    }

}