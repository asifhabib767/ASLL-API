<?php

namespace Modules\Asll\Http\Requests\Voyage;

use App\Http\Requests\FormRequest;

class VoyageActivityExhtEngineUpdateRequest extends FormRequest
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

            'dceMainEngineFuelRPM' => 'required|integer',
            'dceRH' => 'required|integer',
            'dceLoad' => 'required|integer',
            'dceExhtTemp1' => 'required|string',
            'dceExhtTemp2' => 'required|integer',
            'dceJacketTemp' => 'required|integer',
            'dceScavTemp' => 'required|integer',
            'dceLubOilTemp' => 'required|string',
            'dceTCRPM' => 'required|integer',
            'dceJacketPressure' => 'required|integer',
            'dceScavPressure' => 'required|integer',
            'dceLubOilPressure' => 'required|integer',
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

            'dceMainEngineFuelRPM.required' => 'Please give  dceMainEngineFuelRPM',
            'dceRH.required' => 'Please give dceRH',
            'dceLoad.required' => 'Please give dceLoad',
            'dceExhtTemp1.required' => 'Please give dceExhtTemp1',
            'dceExhtTemp2.required' => 'Please givedceExhtTemp2',
            'dceJacketTemp.required' => 'Please give dceJacketTemp',
            'dceScavTemp.required' => 'Please give dceScavTemp',
            'dceLubOilTemp.required' => 'Please give dceLubOilTemp',
            'dceTCRPM.required' => 'Please give dceTCRPM',
            'dceJacketPressure.required' => 'Please give dceJacketPressure',
            'dceScavPressure.required' => 'Please give dceScavPressure',
            'dceLubOilPressure.required' => 'Please give dceLubOilPressure',
            'intCreatedBy.required' => 'Please give Create Date',

        ];
    }
}
