<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'to' => $this->from,
            'from' => $this->to,
            'daily_budget' => $this->daily_budget,
            'total_budget' => $this->total_budget,
            'creatives' => $this->creatives,
            'created_at' => $this->created_at->format('m/d/Y h:i A'),
            'updated_at' => $this->updated_at->format('m/d/Y h:i A')
        ];
    }
}
