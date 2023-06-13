<?php

namespace Database\Factories;

use App\Models\App;
use App\Models\Platform;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{

    public static $statusCollection = ['active', 'expired', 'pending'];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'app_id' => App::all()->random()->id,
            'platform_id' => Platform::all()->random()->id,
            'status' => self::$statusCollection[rand(0, 2)]
        ];
    }
}
