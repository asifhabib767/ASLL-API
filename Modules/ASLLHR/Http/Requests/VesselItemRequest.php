<?php

namespace Modules\ASLLHR\Http\Requests;


class VesselItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'intVesselId' => 'required',
            'strVesselItemName' => 'required|max:5000',
            'strVesselName' => 'nullable|max:5000',
            'decQtyAvailable' => 'nullable',
            'decDefaultPurchasePrice' => 'nullable',
            'decDefaultSalePrice' => 'nullable',
            'intItemTypeId' => 'nullable',
            'strItemTypeName' => 'nullable',
            'intCreatedBy' => 'nullable',
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
            'intVesselId.required' => 'Please select vessel',
        ];
    }
}
