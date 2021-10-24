<?php
declare(strict_types=1);

namespace App\Http\Requests;

class UpdateCampaignRequest extends GuestFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'creatives' => 'array',
            'creatives.*' => 'mimes:jpg,jpeg,png,svg,webp,gif',
            'name' => 'required|string',
            'total_budget' => 'numeric|required|gte:daily_budget',
            'daily_budget' => 'numeric|required',
            'from' => ["date_format:Y-m-d", "required"],
            'to' => ["date_format:Y-m-d", "after:from", "required"]
        ];
    }
}
