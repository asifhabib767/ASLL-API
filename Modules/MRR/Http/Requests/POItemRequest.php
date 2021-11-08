<?php

namespace Modules\MRR\Http\Requests;

use Exception;
use App\Http\Requests\FormRequest;

class POItemRequest extends FormRequest
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
            'intPOID' => 'required|integer',
            'intWHId' => 'required|integer',
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
            'intPOID.required' => 'Please Give PO ID',
            'intPOID.integer' => 'Please Give PO ID',
            'intWHId.required' => 'Please Give Wearehouse',
        ];
    }
}
