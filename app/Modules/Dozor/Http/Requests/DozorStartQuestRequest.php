<?php

namespace App\Modules\Dozor\Http\Requests;

use App\Http\Requests\Request;

class DozorStartQuestRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
        ];
    }
}
