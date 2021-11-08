<?php

namespace Modules\Asll\Http\Requests\Voyage;

use App\Http\Requests\FormRequest;

class VoyageGasNChemicalUpdateRequest extends FormRequest
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
            'intVoyageID' => 'required|integer',
            'intVoyageActivityID' => 'required|integer',
            'intGasNChemicalId' => 'required|integer',
            'strGasNChemicalName' => 'required|string',
            'decBFWD' => 'required|string',
            'decRecv' => 'required|integer',
            'decCons' => 'required|integer',
            'dectotal' => 'required|integer',
            'intCreatedBy' => 'required|integer',
            'intUpdatedBy' => 'required|integer',
            'intDeletedBy' => 'required|integer',

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
            'intVoyageID.required' => 'Please give a valid Voyage Id',
            'intVoyageActivityID.required' => 'Please select a intVoyageActivityID',
            'intGasNChemicalId.required' => 'Please select Ship Condition Type',
            'strGasNChemicalName.required' => 'Please give correct date',
            'decBFWD.required' => 'Please give RPM',
            'decRecv.required' => 'Please give a valid decEngine Speed',
            'decCons.required' => 'Please give decSlip',
            'dectotal.required' => 'Please give Ship Engine ID',
            'intCreatedBy.required' => 'Please give Create Date',
            'intUpdatedBy.required' => 'Please give Create Date',
            'intDeletedBy.required' => 'Please give Create Date',

        ];
    }
}
