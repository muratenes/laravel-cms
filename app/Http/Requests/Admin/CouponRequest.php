<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
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
            'code'             => 'required|max:20|unique:kuponlar,code,' . $this->route('id'),
            'start_date'       => 'required|date',
            'end_date'         => 'required|date',
            'qty'              => 'required|integer|min:0',
            'discount_price'   => 'required|between:0,999.99',
            'min_basket_price' => 'nullable|between:0,99999999.99',
            'currency_id'      => 'required|integer',
        ];
    }
}
