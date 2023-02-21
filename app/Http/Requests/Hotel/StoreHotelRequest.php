<?php

namespace App\Http\Requests\Hotel;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreHotelRequest extends FormRequest
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
            'name'          => 'required|max:300',
            'title'         => 'required|min:2',
            'city_id'       => 'required|exists:cities,id',
            'host_id'       => 'required|exists:hosts,id',
            'description'   => 'required|max:2000',
            'motto'          => "required|min:5",
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
            'required'          => 'تمامی فیلد هارا پر کنید',
            'name.max'          => 'نام بیش از حد طولانی است',
            'city_id.exists'    => 'این شهر وجود ندارد',
        ];
    }
}
