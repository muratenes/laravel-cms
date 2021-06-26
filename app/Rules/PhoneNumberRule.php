<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class PhoneNumberRule implements Rule
{
    private $_phone;

    /**
     * Create a new rule instance.
     *
     * @param mixed $phone
     */
    public function __construct($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if ('0' === mb_substr($this->_phone, 0, 1)) {
            return false;
        }
        if (10 === (int) (\mb_strlen($this->_phone))) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute 10 haneli olmalıdır ve 0 ile başlamamalıdır';
    }
}
