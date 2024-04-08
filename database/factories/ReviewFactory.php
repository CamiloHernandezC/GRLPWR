<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Review>
 */
class  ReviewFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
            return [
                'rating' => random_int(0, 5),
                'review' =>  fake()->text(140),
                'reviewer_id' => random_int(DB::table('usuarios')->min('id'), DB::table('usuarios')->max('id')),
            ];
    }
}
