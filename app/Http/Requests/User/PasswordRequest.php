<?php

namespace App\Http\Requests\User;

use App\Rules\OldPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class PasswordRequest extends FormRequest
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
     * Get data to be validated from the request.
     *
     * @return array
     */
    public function validationData() : array
    {
        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'old_password' => ['required', 'string', new OldPassword($this->user('user'))],
            'password'     => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages() : array
    {
        return [];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes() : array
    {
        return [];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array
     */
    public function validated() : array
    {
        $validated = $this->validator->validated();

        $validated['password'] = Hash::make($validated['password']);

        return $validated;
    }
}
