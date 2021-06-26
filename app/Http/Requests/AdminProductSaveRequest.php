<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminProductSaveRequest extends FormRequest
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
        // initial values
        $this->request->set('categories', $this->request->get('categories') ?? []);
        $this->request->set('properties', $this->request->get('properties') ?? []);

        $rule = [
            'title'        => 'required|max:90',
            'slug'         => 'nullable|string|max:150',
            'active'       => 'nullable',
            'desc'         => 'nullable',
            'tags'         => 'nullable|array',
            'buying_price' => 'nullable|numeric|min:0',
            'company_id'   => 'nullable|numeric',
            'brand_id'     => 'nullable|numeric',
            'spot'         => 'nullable|string',
            'properties'   => 'nullable|array',
            'qty'          => 'nullable|numeric|min:0',
            'code'         => 'max:50',
        ];

        // single category
        if (admin('modules.product.category')) {
            if (! admin('modules.product.multiple_category')) {
                $rule['parent_category_id'] = 'required|numeric';
                $rule['sub_category_id'] = 'required|numeric';
            }
        }
        // prices
        if (admin('modules.product.prices')) {
            $rule['tl_price'] = 'required|numeric|min:1,max:99999';
            $rule['tl_discount_price'] = 'nullable|numeric|min:1,max:99999';

            if (admin('multi_currency')) {
                $rule['usd_price'] = 'required|numeric|min:1,max:99999';
                $rule['usd_discount_price'] = 'nullable|numeric|min:1,max:99999';
                $rule['eur_price'] = 'required|numeric|min:1,max:99999';
                $rule['eur_discount_price'] = 'nullable|numeric|min:1,max:99999';
            }
        }
        if (admin('modules.product.cargo_price')) {
            $rule['cargo_price'] = 'nullable|numeric|min:0,max:99999';
        }

        return $rule;
    }

    public function messages()
    {
        return parent::messages();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'active' => (bool) $this->has('active'),
        ]);
    }
}
