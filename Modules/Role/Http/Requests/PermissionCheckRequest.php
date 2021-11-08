<?php

namespace Modules\Role\Http\Requests;

use Exception;
use App\Http\Requests\FormRequest;

class PermissionCheckRequest extends FormRequest
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
            'permission' => 'required|string'
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
            'permission.required' => 'Please give permission name',
        ];
    }
}
