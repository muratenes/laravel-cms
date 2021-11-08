<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (bool) loggedAdminUser();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'     => 'required|min:3|max:50',
            'email'    => 'email|max:100|string|unique:users',
            'surname'  => 'required|min:3|max:50',
            'password' => 'required|string|min:6|max:30',
            'role_id'  => 'required|numeric',
            'phone'    => 'string|nullable',
            'locale'   => 'string|nullable',
        ];
    }

    public function validated(): array
    {
        $validated = parent::validated();
        $validated['is_active'] = $this->request->has('is_active');

        if ($this->filled('password')) {
            $validated['password'] = Hash::make($this->input('password'));
        }

        return $validated;
    }
}
