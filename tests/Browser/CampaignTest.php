<?php

declare(strict_types=1);

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Campaign;

class CampaignTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testListPageLoading(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Add New');
        });
    }

    public function testAddNewPage(): void
    {
        $today = date('m-d-Y');
        $next = date('m-d-Y', strtotime(date('Y-m-d') . ' + 3 days'));

        $this->browse(function (Browser $browser) use ($today, $next) {
            $browser->visit('/new')
                ->waitForText('New Campaign')
                ->type('name', 'New Add')
                ->type('from', $today)
                ->type('to', $next)
                ->type('dailyBudget', 500)
                ->type('totalBudget', 5000)
                ->attach('creative', __DIR__ . '/photos/bolaji.jpg')
                ->press("Create")
                ->waitFor('.alert-success')
                ->assertSee('Success!');
        });
    }

    public function testCreativeViewOnList(): void
    {
        Campaign::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->waitForText('Name')
                ->assertSee('View')
                ->press("View")
                ->whenAvailable('.modal', function ($modal) {
                    $modal->assertSee('Close')
                        ->press('Close');
                });
        });
    }

    public function testEditCampaignSuccessfully(): void
    {
        $this->artisan("cache:clear");

        $campaign = Campaign::factory()->create();

        $this->browse(function (Browser $browser) use ($campaign) {
            $browser->visit('/')
                ->waitForText($campaign->name)
                ->assertSee('Edit')
                ->press(".btn-outline-info")
                ->assertPathIs("/edit/{$campaign->id}")
                ->type("dailyBudget", 100)
                ->press("Update")
                ->waitFor('.alert-success')
                ->assertSee('Success!');
        });
    }

    public function testEditCampaignValidationError(): void
    {
        $this->artisan("cache:clear");

        $campaign = Campaign::factory()->create();

        $this->browse(function (Browser $browser) use ($campaign) {
            $browser->visit('/')
                ->waitForText($campaign->name)
                ->assertSee('Edit')
                ->press(".btn-outline-info")
                ->assertPathIs("/edit/{$campaign->id}")
                ->type("dailyBudget", "goat")
                ->press("Update")
                ->waitFor('.alert-warning')
                ->assertSee('Warning!');
        });
    }

    public function testDeleteCampaignOnList(): void
    {
        $this->artisan("cache:clear");

        Campaign::factory()->create();

        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->waitForText("Delete")
                ->assertSee("Delete")
                ->press(".btn-outline-danger");
        });

        $this->artisan("cache:clear");
    }
}
