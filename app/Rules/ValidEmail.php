<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidEmail implements Rule
{
    /**
     * Check MX record in DNS for hostname.
     *
     * @var bool $check_dns
     */
    protected $check_dns;

    /**
     * Create a new rule instance.
     *
     * @param bool $check_dns
     */
    public function __construct(bool $check_dns = false)
    {
        $this->check_dns = $check_dns;
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
        return \App\Helpers\Validate::email($value, $this->check_dns);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->check_dns
            ? 'Invalid email address or email server doesn\'t exist.'
            : 'The :attribute must be a valid email address.';
    }
}
