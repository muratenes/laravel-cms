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
        return [
            'name' => 'required|max:90',
            'is_active' => 'nullable',
            'price' => 'numeric|min:0',
            'purchase_price' => 'numeric|min:0',
            'qty' => 'nullable|numeric|min:0',
        ];
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
            'is_active' => (bool) $this->has('is_active'),
        ]);
    }
}
