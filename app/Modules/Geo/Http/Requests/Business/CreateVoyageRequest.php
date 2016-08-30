<?php

namespace App\Modules\Geo\Http\Requests\Business;

use App\Http\Requests\Request;

class CreateVoyageRequest extends Request
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
            'route_id' => 'required|numeric',
            'ship_id'  => 'required|numeric',
        ];
    }
}
