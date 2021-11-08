<?php

namespace Modules\Auth\Http\Requests;

use App\Http\Requests\FormRequest;

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
            'first_name' => 'required|max:30',
            'last_name' => 'nullable|max:20|string',
            'email' => 'nullable|email|max:50|unique:users',
            'phone_no' => 'required|max:15|unique:users',
            'password' => 'required|min:6|confirmed',
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
            'first_name.required' => trans('auth.first_name.required'),
            'first_name.max' => trans('auth.first_name.max'),
            'last_name.max' => trans('auth.last_name.max'),
            'email.email' => trans('auth.email.email'),
            'email.unique' => trans('auth.email.unique'),
            'phone_no.required' => trans('auth.phone_no.required'),
            'phone_no.unique' => trans('auth.phone_no.unique'),
            'password.required' => trans('auth.password.required'),
            'password.confirmed' => trans('auth.password.confirmed'),
        ];
    }
}
