<?php

namespace Modules\Asll\Http\Requests\Voyage;

use App\Http\Requests\FormRequest;

class GasNChemicalUpdateRequest extends FormRequest
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
            'intId' => 'required|integer',
            'strName' => 'required|string',
            
            'intCreatedBy' => 'required|integer',

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
            'intId.required' => 'Please select a id first to edit',
            'strName.required' => 'Please give a valid Name',
            'intCreatedBy.required' => 'Please give Create Date',

        ];
    }
}
