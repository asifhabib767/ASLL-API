<?php

namespace Modules\Asll\Http\Requests\Voyage;

use App\Http\Requests\FormRequest;

class VoyageActivityBoilerUpdateRequest extends FormRequest
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
            'intID' => 'required|integer',
            'intVoyageID' => 'required|integer',
            'intShipPositionID' => 'required|integer',
            'intShipConditionTypeID' => 'required|integer',
            'dteCreatedAt' => 'required|string',
            'strRPM' => 'required|string',
            'decEngineSpeed' => 'required|integer',
            'decSlip' => 'required|integer',
            'intShipEngineID' => 'required|integer',
            'strShipEngineName' => 'required|string',

            'decWorkingPressure' => 'required|integer',
            'decPhValue' => 'required|integer',
            'decChloride' => 'required|integer',
            'decAlkalinity' => 'required|string',
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
            'intID.required' => 'Please select a boiler first to edit',
            'intVoyageID.required' => 'Please give a valid Voyage Id',
            'intShipPositionID.required' => 'Please select a Ship Position id',
            'intShipConditionTypeID.required' => 'Please select Ship Condition Type',
            'dteCreatedAt.required' => 'Please give correct date',
            'strRPM.required' => 'Please give RPM',
            'decEngineSpeed.required' => 'Please give a valid decEngine Speed',
            'decSlip.required' => 'Please give boiler decSlip',
            'intShipEngineID.required' => 'Please give Ship Engine ID',
            'strShipEngineName.required' => 'Please give Ship Engine Name',

            'decWorkingPressure.required' => 'Please give decWorking Pressure',
            'decPhValue.required' => 'Please give decPh Value',
            'decChloride.required' => 'Please give decChloride',
            'decAlkalinity.required' => 'Please give decAlkalinity',
            'intCreatedBy.required' => 'Please give Create Date',

        ];
    }
}
