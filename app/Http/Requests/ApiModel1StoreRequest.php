<?php

namespace App\Http\Requests;

use App\Http\Requests\ValidatedFormRequest;
use Illuminate\Validation\Rule;

class ApiModel1StoreRequest extends ValidatedFormRequest
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
            'fname' => 'required',
            'lname' => 'required',
            'email' => ['required', 'email', Rule::unique('api_model1s')->ignore($this->id)],
            'town' => 'required',
        ];
    }

    /**
     * messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            'fname.required' => 'You must add a first name',
            'lname.required' => 'You must add a last name',
            'email.required' => 'An email is required',
            'email.unique' => 'That email address is already in use',
            'email.email' => 'The email address is not valid',
            'town.required' => 'You must add a town',
        ];
    }

}
