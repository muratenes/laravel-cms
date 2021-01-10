<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContentManagementRequest extends FormRequest
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
            'title' => 'required|max:100',
            'spot'=>'max:255',
            'desc'=>'max:65000',
        ];
    }
}
