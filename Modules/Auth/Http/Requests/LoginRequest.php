<?php

namespace Modules\Auth\Http\Requests;

use Exception;
use App\Http\Requests\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email',
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
            'email.required' => trans('auth.email.required'),
            'email.email' => trans('auth.email.email'),
            'password.required' => trans('auth.password.required'),
        ];
    }
}
