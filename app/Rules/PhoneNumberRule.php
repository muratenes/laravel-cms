<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use function GuzzleHttp\Psr7\str;

class PhoneNumberRule implements Rule
{
    private $_phone;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($phone)
    {
        $this->_phone = $phone;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (substr($this->_phone, 0, 1) == "0")
            return false;
        if (intval(strlen($this->_phone)) == 10)
            return true;
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
