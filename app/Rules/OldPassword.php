<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;

class OldPassword implements Rule
{
    /**
     * User changing the password.
     *
     * @var \Illuminate\Foundation\Auth\User $user
     */
    protected $user;

    /**
     * Create a new rule instance.
     *
     * @param \Illuminate\Foundation\Auth\User|null $user
     */
    public function __construct(User $user = null)
    {
        $this->user = $user ?? auth()->user();
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
        return Hash::check($value, $this->user->password);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your old password is incorrect.';
    }
}
