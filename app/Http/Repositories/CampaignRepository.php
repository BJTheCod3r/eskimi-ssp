<?php

declare(strict_types=1);


namespace App\Http\Repositories;


use App\Models\Campaign;
use App\Http\Resources\CampaignCollection;
use Illuminate\Support\Facades\Cache;

/**
 * Class CampaignRepository
 * 
 * 
 */
class CampaignRepository extends BaseRepository
{
    /**
     * CampaignRepository constructor.
     */
    public function __construct()
    {
        parent::__construct(Campaign::class);
    }

    /**
     * List campaigns
     * 
     * @return \Illuminate\Http\ResourceCollection
     */
    public function listCampaigns(): CampaignCollection
    {
        return Cache::remember(Campaign::CACHE_PREFIX, now()->addMinutes(60), function () {
            return new CampaignCollection(Campaign::all());
        });
    }
}
