<?php

namespace App\Http\Requests\Process;

use App\Http\Requests\Request;

class BuildConcreteRequest extends Request
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
            'building_id' => 'required|numeric',
            'kind' => 'required|string',
            'title' => 'required|string',
        ];
    }
}
