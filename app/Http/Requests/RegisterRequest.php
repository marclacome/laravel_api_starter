<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    /**
     * messages
     *
     * @return void
     */
    public function messages()
    {
        return [
            'email.required' => 'An email is required',
            'email.unique' => 'That email address is already in use',
            'email.email' => 'The email address is not valid',
            'password.required' => 'You must enter a password',
            'password.min' => 'The password must be at least 8 characters',
            'password.confirmed' => 'The passwords do not match',
        ];
    }

/**
 *
 * @param  \Illuminate\Contracts\Validation\Validator  $validator
 * @return void
 *
 * @throws \Illuminate\Validation\ValidationException
 */
    protected function failedValidation(Validator $validator)
    {
        $err = ValidationException::withMessages($validator->errors()->all());
        throw ($err);
    }

}
