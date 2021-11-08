<?php

namespace Modules\ASLLHR\Http\Requests;


class EmployeeApplicationCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'intApplicationTypeId' => 'required',
            'intEmployeeId' => 'required',
            'intRankId' => 'required',
            'intVesselId' => 'required',
            'strReceiverName' => 'required|max:191',
            'dteFromDate' => 'nullable',
            'strPortName' => 'nullable',
            'strApplicationBody' => 'nullable',
            'strCommencementTenure' => 'nullable',
            'dteDateOfCompletion' => 'nullable',
            'dteExtensionRequested' => 'nullable',
            'dteRejoiningDate' => 'nullable',
            'strRemarks' => 'nullable',
            'strApplicationSubject' => 'nullable',
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
            'intApplicationTypeId.required' => 'Please select application type',
            'intEmployeeId.required' => 'Please select employee',
            'intRankId.required' => 'Please select rank',
            'intVesselId.required' => 'Please select vessel',
            'strReceiverName.required' => 'Please give receiver name',
        ];
    }
}
