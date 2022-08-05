<?php

namespace Database\Factories;

use App\Services\RepoService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SocialPost>
 */
class SocialPostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'issue_repo' => (string) app(RepoService::class)->reposToCrawl()->random(),
            'issue_number' => $this->faker->numberBetween(1, 1000),
            'issue_id' => $this->faker->numberBetween(1_000_000_000, 2_000_000_000),
        ];
    }

    public function tweeted()
    {
        return $this->state(function (array $attributes) {
            return [
                'tweet_id' => $this->faker->numberBetween(1_000_000_000_000_000_000, 2_000_000_000_000_000_000),
                'twitter_sent_at' => $this->faker->dateTime,
            ];
        });
    }
}
