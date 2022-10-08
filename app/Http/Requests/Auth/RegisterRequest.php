<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\Facades\Hash;

class RegisterRequest extends FormRequest
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


    public function rules()
    {
        return  [
            'email' =>  'required|email|unique:users',
            'password'  =>  'required|min:5|confirmed',
        ];
    }


    public function failedValidation(Validator $validator)
    {
       throw new HttpResponseException(response()->json([
         'success'   => false,
         'message'   => 'Validation errors',
         'data'      => $validator->errors()
       ]));
    }


    public function messages()
    {
        return [
            'required'              => 'تمامی فیلد هارا پر کنید',
            'email.unique'          => 'این ایمیل قبلا استفاده شده است',
            'password.min'          => 'پسورد کوتاه و ضعیف است',
            'password.confirmed'    => 'پسوردهای وارد شده یکسان نیستند',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
}
