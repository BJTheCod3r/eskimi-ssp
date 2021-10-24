<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Campaign;
use Illuminate\Http\UploadedFile;

class CampaignTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function testRequiredFieldsForNewCampaign()
    {
        $this->postJson("/api/campaigns")
            ->assertStatus(422)
            ->assertJsonStructure([
                "message",
                "errors"
            ]);
    }

    public function testCreateNewCampaignSuccessfully()
    {
        $this->post("/api/campaigns", [
            'name' => $this->faker->name(),
            'from' => date('Y-m-d'),
            'to' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 3 days')),
            'total_budget' => $this->faker->randomFloat(2, 5000, 8000),
            'daily_budget' => $this->faker->randomFloat(2, 300, 500),
            'creatives' => [UploadedFile::fake()->image('creative.jpg')]
        ])->assertStatus(201)
            ->assertJsonStructure([
                "message",
                "data"
            ]);
    }

    public function testRequiredFieldsForUpdateCampaign()
    {
        $campaign = Campaign::factory()->create();

        $this->postJson("/api/campaigns/{$campaign->id}")
            ->assertStatus(422)
            ->assertJsonStructure([
                "message",
                "errors"
            ]);
    }

    public function testUpdateNotFound()
    {
        $this->post("/api/campaigns/300", [
            'name' => $this->faker->name(),
            'from' => date('Y-m-d'),
            'to' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 3 days')),
            'total_budget' => $this->faker->randomFloat(2, 5000, 8000),
            'daily_budget' => $this->faker->randomFloat(2, 300, 500),
            'creatives' => [UploadedFile::fake()->image('creative.jpg')]
        ])->assertStatus(404);
    }

    public function testCanUpdateSuccessfully()
    {
        $campaign = Campaign::factory()->create();

        $this->post("/api/campaigns/{$campaign->id}", [
            'name' => $this->faker->name(),
            'from' => date('Y-m-d'),
            'to' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 3 days')),
            'total_budget' => $this->faker->randomFloat(2, 5000, 8000),
            'daily_budget' => $this->faker->randomFloat(2, 300, 500),
            'creatives' => [UploadedFile::fake()->image('creative.jpg')]
        ])->assertStatus(200)
            ->assertJsonStructure([
                "message",
                "data"
            ]);
    }

    public function testCanDeleteCampaignSuccessfully()
    {
        $campaign = Campaign::factory()->create();

        $this->delete("/api/campaigns/{$campaign->id}")
            ->assertStatus(200)
            ->assertJsonStructure([
                "message"
            ]);
    }

    public function testCanDeleteNotFound()
    {
        $this->delete("/api/campaigns/80")
            ->assertStatus(404);
    }
}
