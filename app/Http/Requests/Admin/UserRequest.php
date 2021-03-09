<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    /**
     * Check if it's a PUT (update) request.
     *
     * @var bool $is_updating
     */
    protected $is_updating = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
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
        $this->is_updating = $this->isMethod('put');

        return $this->all();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return $this->is_updating ? $this->updateRules() : $this->createRules();
    }

    /**
     * Get the create validation rules.
     *
     * @return array
     */
    public function createRules() : array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'min:6', 'max:255', Rule::unique('users', 'email')],
            'avatar'     => ['nullable', 'image', 'max:5120'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * Get the update validation rules.
     *
     * @return array
     */
    public function updateRules() : array
    {
        return [
            'model_id'   => ['required', 'integer', 'exists:users,id'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'min:6', 'max:255', Rule::unique('users', 'email')->ignore($this->model_id)],
            'avatar'     => ['nullable', 'image', 'max:5120'],
            'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
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

        // Validated data for POST and PUT requests

        return $this->is_updating ? $this->updateData($validated) : $this->createData($validated);
    }

    /**
     * Manipulate the validated data before storing.
     *
     * @param array $validated
     * @return array
     */
    private function createData(array $validated) : array
    {
        $validated['password'] = Hash::make($validated['password']);

        return $validated;
    }

    /**
     * Manipulate the validated data before updating.
     *
     * @param array $validated
     * @return array
     */
    private function updateData(array $validated) : array
    {
        if ($validated['password'] ?? null) {
            $validated['password'] = Hash::make($validated['password']);
        }

        return $validated;
    }
}
