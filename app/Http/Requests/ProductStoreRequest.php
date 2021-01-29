<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            "name"=>"required|string",
            "price"=>"required|numeric"
        ];
    }
    public function messages()
    {
        return[
            "name.required"=>"နာမည် ထည့်ရန်လိုအပ်ပါသည်",
            "name.string"=>"နာမည် သည်စာသားဖြစ်ရပါမည်",
            "price.required"=>"စျေးနှုန်း ထည့်ရန်လိုအပ်ပါသည်",
            "price.numeric"=>"စျေးနှုန်း သည်နံပါတ်ဖြစ်ရပါမည်",
        ];
    }
}
