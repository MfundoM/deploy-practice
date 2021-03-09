<?php

namespace App\Http\Requests\Guest;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            'name'    => ['required', 'string', 'min:2', 'max:255'],
            'email'   => ['required', 'email', 'min:6', 'max:255'],
            'mobile'  => ['nullable', 'starts_with:0', 'digits_between:9,11'],
            'message' => ['required', 'string', 'min:10', 'max:5120'],
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
            //
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

        $validated['ip'] = $this->header('X-Forwarded-For') ?? $this->ip();

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
        // Validated data for POST request (store)

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
        // Validated data for PUT request (update)

        return $validated;
    }
}
