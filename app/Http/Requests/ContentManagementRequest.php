<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentManagementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'     => 'required|max:100',
            'spot'      => 'nullable|string|max:255',
            'desc'      => 'nullable|string|max:65000',
            'lang'      => 'nullable|numeric',
            'parent_id' => 'nullable|numeric',
        ];
    }
}
