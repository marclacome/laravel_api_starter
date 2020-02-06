<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class ValidatedFormRequest extends FormRequest
{

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
