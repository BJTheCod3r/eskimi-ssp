<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Campaign;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class CampaignObserver
{
    /**
     * Handle the Campaign "created" event.
     *
     * @return void
     */
    public function created():void
    {
        Cache::forget(Campaign::CACHE_PREFIX);
    }

    /**
     * Handle the Campaign "updated" event.
     *
     * @return void
     */
    public function updated():void
    {
        Cache::forget(Campaign::CACHE_PREFIX);
    }

    /**
     * Handle the Campaign "deleted" event.
     *
     * @param  \App\Models\Campaign  $campaign
     * @return void
     */
    public function deleted(Campaign $campaign):void
    {
        foreach ($campaign->creatives as $creative) {
            Storage::disk('public')->delete($creative['file_path']);
        }

        Cache::forget(Campaign::CACHE_PREFIX);
    }
}
