<?php

namespace Modules\Asll\Http\Requests\Voyage;

use App\Http\Requests\FormRequest;

class VoyageActivityVlsfUpdateRequest extends FormRequest
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

            'intVoyageID' => 'required|integer',
            'intShipPositionID' => 'required|integer',
            'intShipConditionTypeID' => 'required|integer',
            'dteCreatedAt' => 'required|string',
            'strRPM' => 'required|string',
            'decEngineSpeed' => 'required|integer',
            'decSlip' => 'required|integer',

            'decBunkerVlsfoCon' => 'required|integer',
            'decBunkerVlsfoAdj' => 'required|integer',
            'decBunkerVlsfoRob' => 'required|integer',
            'decBunkerLsmgoCon' => 'required|integer',
            'decBunkerLsmgoAdj' => 'required|string',
            'decBunkerLsmgoRob' => 'required|integer',
            'decLubMeccCon' => 'required|integer',
            'decLubMeccAdj' => 'required|integer',
            'decLubMeccRob' => 'required|string',
            'decLubMecylCon' => 'required|string',
            'decLubMecylAdj' => 'required|integer',
            'decLubMecylRob' => 'required|integer',
            'decLubAeccCon' => 'required|integer',
            'decLubAeccAdj' => 'required|string',
            'decLubAeccRob' => 'required|string',
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
            'intVoyageID.required' => 'Please give a valid Voyage Id',
            'intShipPositionID.required' => 'Please select a Ship Position id',
            'intShipConditionTypeID.required' => 'Please select Ship Condition Type',
            'dteCreatedAt.required' => 'Please give correct date',
            'strRPM.required' => 'Please give RPM',
            'decEngineSpeed.required' => 'Please give a valid decEngine Speed',
            'decSlip.required' => 'Please give boiler decSlip',
            'intShipEngineID.required' => 'Please give Ship Engine ID',
            'strShipEngineName.required' => 'Please give Ship Engine Name',

            'decBunkerVlsfoCon.required' => 'Please give decBunkerVlsfoCon',
            'decBunkerVlsfoAdj.required' => 'Please give decBunkerVlsfoAdj',
            'decBunkerVlsfoRob.required' => 'Please give decBunkerVlsfoRob',
            'decBunkerLsmgoCon.required' => 'Please give decBunkerLsmgoCon',
            'decBunkerLsmgoAdj.required' => 'Please give decBunkerLsmgoAdj',
            'decBunkerLsmgoRob.required' => 'Please give decBunkerLsmgoRob',
            'decLubMeccCon.required' => 'Please give decLubMeccCon',
            'decLubMeccAdj.required' => 'Please give decLubMeccAdj',
            'decLubMeccRob.required' => 'Please give decLubMeccRob',
            'decLubMecylCon.required' => 'Please give decLubMecylCon',
            'decLubMecylAdj.required' => 'Please give decLubMecylAdj',
            'decLubMecylRob.required' => 'Please give decLubMecylRob',
            'decLubAeccCon.required' => 'Please give decLubAeccCon',
            'decLubAeccAdj.required' => 'Please give decLubAeccAdj',
            'decLubAeccRob.required' => 'Please give decLubAeccRob',
            'intCreatedBy.required' => 'Please give Create Date',

        ];
    }
}
