<?php

namespace Modules\ASLLHR\Http\Requests;


class UploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'uploadFile' => 'required|max:5000|mimes:doc,docx,jpeg,png,jpg,gif,svg'
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
            // 'intVesselId.required' => 'Please select vessel',
        ];
    }
}
