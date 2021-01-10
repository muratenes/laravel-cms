<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumberRule;
use Illuminate\Foundation\Http\FormRequest;

class UserDetailSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|min:3|max:50',
            'surname' => 'required|min:3|max:50',
            'phone' => new PhoneNumberRule(request('phone'))
        ];
        if (request()->has('changePasswordCheckbox'))
            $rules['password'] = 'required|min:5|confirmed';
        return $rules;
    }
}
