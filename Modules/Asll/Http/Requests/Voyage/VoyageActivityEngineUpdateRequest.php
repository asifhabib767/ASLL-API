<?php

namespace Modules\Asll\Http\Requests\Voyage;

use App\Http\Requests\FormRequest;

class VoyageActivityEngineUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // New
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
            'dteCreatedAt' => 'required|integer',
            'strRPM' => 'required|string',
            'decEngineSpeed' => 'required|integer',
            'decSlip' => 'required|integer',
            'intShipEngineID' => 'required|integer',
            'strShipEngineName' => 'required|string',

            'dceJacketTemp1' => 'required|integer',
            'dceJacketTemp2' => 'required|integer',
            'dcePistonTemp1' => 'required|integer',
            'dcePistonTemp2' => 'required|integer',
            'dceExhtTemp1' => 'required|integer',
            'dceExhtTemp2' => 'required|integer',
            'dceScavTemp1' => 'required|integer',
            'dceScavTemp2' => 'required|integer',
            'dceTurboCharger1Temp1' => 'required|integer',
            'dceTurboCharger1Temp2' => 'required|integer',
            'dceEngineLoad' => 'required|integer',
            'dceJacketCoolingTemp1' => 'required|integer',
            'dcePistonCoolingTemp1' => 'required|integer',
            'dceLubOilCoolingTemp1' => 'required|integer',
            'dceFuelCoolingTemp1' => 'required|integer',
            'dceScavCoolingTemp1' => 'required|integer',
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

            'dceJacketTemp1.required' => 'Please give dceJacketTemp1',
            'dceJacketTemp2.required' => 'Please give dceJacketTemp2',
            'dcePistonTemp1.required' => 'Please give dcePistonTemp1',
            'dcePistonTemp2.required' => 'Please give dcePistonTemp2',
            'dceExhtTemp1.required' => 'Please give dceExhtTemp1',
            'dceExhtTemp2.required' => 'Please give dceExhtTemp2',
            'dceScavTemp1.required' => 'Please give dceScavTemp1',
            'dceScavTemp2.required' => 'Please give dceScavTemp2',
            'dceTurboCharger1Temp1.required' => 'Please give dceTurboCharger1Temp1',
            'dceTurboCharger1Temp2.required' => 'Please give dceTurboCharger1Temp2',
            'dceEngineLoad.required' => 'Please give dceEngineLoad',
            'dceJacketCoolingTemp1.required' => 'Please give dceJacketCoolingTemp1',
            'dcePistonCoolingTemp1.required' => 'Please give dcePistonCoolingTemp1',
            'dceLubOilCoolingTemp1.required' => 'Please give dceLubOilCoolingTemp1',
            'dceFuelCoolingTemp1.required' => 'Please give dceFuelCoolingTemp1',
            'dceScavCoolingTemp1.required' => 'Please give dceScavCoolingTemp1',
            'intCreatedBy.required' => 'Please give Create Date',

        ];
    }
}
