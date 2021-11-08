<?php

namespace Modules\Auth\Http\Requests;

use Exception;
use App\Http\Requests\FormRequest;

class LoginSuperUserRequest extends FormRequest
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
            'username' => 'required|string',
            'password' => 'required',
        ];
    }

    /**
     * Get the messages for the rules
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Please give username',
            'password.required' => 'Please give password',
        ];
    }
}
