<?php

declare(strict_types=1);

namespace App\Http\Requests;

class StoreCampaignRequest extends GuestFormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'creatives' => 'required|array|min:1',
            'creatives.*' => 'mimes:jpg,jpeg,png,svg,webp,gif',
            'name' => 'required|string',
            'total_budget' => 'numeric|required|gte:daily_budget',
            'daily_budget' => 'numeric|required',
            'from' => ["date_format:Y-m-d", "required", "after_or_equal:today"],
            'to' => ["date_format:Y-m-d", "after:from", "required"]
        ];
    }
}
