<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'kana'=> ['required','max:50',], //'regex:/^[ァ-ヴ]+$/u'
            'tel'=> ['required',],
            'email'=> ['required','max:255',],
            'postcode'=> ['required', 'numeric'],
            'address'=> ['required', 'max:100'],
            'birthday'=> ['date', 'nullable'],
            'gender'=> ['required'],
            'memo' => ['max:255'],
        ];
    }
}
