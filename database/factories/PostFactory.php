<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $randomUser = DB::table('users')
            ->inRandomOrder()
            ->first();

        return [
            'title' => $this->faker->title(),
            'content' => $this->faker->paragraph(),
            'user_id' => $randomUser->id
        ];
    }
}
