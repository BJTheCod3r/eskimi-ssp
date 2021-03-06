<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Campaign;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Campaign::factory()->count(5)->create();
    }
}
