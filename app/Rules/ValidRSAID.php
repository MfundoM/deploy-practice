<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRSAID implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return \App\Helpers\Validate::RSAID($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'RSA ID number is invalid.';
    }
}
