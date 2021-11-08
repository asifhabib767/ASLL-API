<?php

namespace Modules\Asll\Http\Requests;

use Exception;
use App\Http\Requests\FormRequest;

class VesselCreateRequest extends FormRequest
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
            'strVesselName' => 'required|string',
            'intVesselTypeID' => 'required|integer',
            'intYardCountryId' => 'required|integer',
            'strVesselFlag' => 'required|string',
            'numDeadWeight' => 'required',
            'strBuildYear' => 'required|string',
            'strEngineName' => 'required|string',
            'intTotalCrew' => 'required|integer'
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
            'strVesselName.required' => 'Please give vessel name',
            'intVesselTypeID.required' => 'Please select a vessel type',
            'intYardCountryId.required' => 'Please select a country',
            'strVesselFlag.required' => 'Please give vessel flag',
            'numDeadWeight.required' => 'Please give dead weight',
            'strBuildYear.required' => 'Please give build time',
            'strEngineName.required' => 'Please give vessel engine name',
            'intTotalCrew.required' => 'Please give vessel total crew'
        ];
    }
}
