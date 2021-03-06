<?php

namespace App\Modules\Auction\Http\Requests;

use App\Http\Requests\Request;

class AuctionBuyLotRequest extends Request
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
            'lot_id' => 'required|numeric',
        ];
    }
}
