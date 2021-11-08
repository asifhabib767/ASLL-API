<?php

namespace Modules\HR\Http\Requests;

use App\Http\Requests\FormRequest;

// use Illuminate\Foundation\Http\FormRequest;

class GetMealRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'intEmployeeId' => 'required|integer',
            'ysnConsumed' => 'required|string',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
