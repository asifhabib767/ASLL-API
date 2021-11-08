<?php

namespace Modules\Asset\Http\Requests;

use App\Http\Requests\FormRequest;

class VoyageLighterMainRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        'dteDate'=>'nullable',
        'intLoadingPointId'=>'nullable',
        'strLoadingPointName'=>'nullable',
        'intLighterId'=>'nullable',
        'strLighterName'=>'nullable',
        'strCode'=>'nullable',
        'intLighterVoyageNo'=>'nullable',
        'intMasterId'=>'nullable',
        'strMasterName'=>'nullable',
        'strUnloadStartDate'=>'nullable',
        'strUnloadCompleteDate'=>'nullable',
        'intDriverId'=>'nullable',
        'strComments'=>'nullable',
        'intCreatedBy'=>'nullable',
        'intUpdatedBy'=>'nullable',
        'intDeletedBy'=>'nullable',
        'ysnActive'=>'nullable',
        'ysnCompleted'=>'nullable',
        'synced'=>'nullable',
        'decTripCost'=>'nullable',
        'decPilotCoupon'=>'nullable',
        'decFreightRate'=>'nullable',
        'intSurveyNumber'=>'nullable',
        'strPartyName'=>'nullable',
        'strPartyCode'=>'nullable',
        'intMotherVesselID'=>'nullable',
        'strMotherVesselName'=>'nullable',
        'dteVoyageCommencedDate'=>'nullable',
        'dteVoyageCompletionDate'=>'nullable',
        'strDischargePortName'=>'nullable',
        'intDischargePortID'=>'nullable',
        'created_at'=>'nullable',
        'updated_at'=>'nullable'

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

    /**
     * @return array
     * Custom validation message
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
