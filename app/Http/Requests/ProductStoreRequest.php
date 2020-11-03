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
            'name' => 'required',
            'price' => 'required|numeric'
        ];

    }
    public function messages()
    {
        return [
            'name.required' => 'ကျေးဇူးပြူပြီး ထုတ်ကုန်အမည်ထည့်ပေးပါ',
            // 'name.alpha' => 'ထုတ်ကုန်အမည်သည် စာသားများသာ ဖြစ်ရမည်',
            'price.required' => 'ကျေးဇူးပြုပြီး ငွေပမာဏထည့်ပေးပါ',
            'price.numeric' => 'ငွေပမာဏသည် ဂဏန်းများသာ ဖြစ်ရမည်',
        ];
    }
}
