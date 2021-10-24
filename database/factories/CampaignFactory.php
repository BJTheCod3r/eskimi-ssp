<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'to' => date('Y-m-d', strtotime(date('Y-m-d') . ' + 3 days')),
            'from' => date('Y-m-d'),
            'total_budget' => $this->faker->randomFloat(2, 5000, 8000),
            'daily_budget' => $this->faker->randomFloat(2, 300, 500),
            'creatives' => [
                [
                    'file_name' => $this->faker->word(),
                    'file_path' => '/file/to/path',
                    'url' => $this->faker->imageUrl(640, 480, 'animals', true),
                    'id' => $this->faker->randomNumber(8, true)
                ]
            ]
        ];
    }
}
