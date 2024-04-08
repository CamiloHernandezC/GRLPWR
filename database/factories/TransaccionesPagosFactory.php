<?php

namespace Database\Factories;

use App\PaymentMethod;
use App\TransaccionesPagos;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends Factory<TransaccionesPagos>
 */
class  TransaccionesPagosFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
            return [
                'payment_method_id' => PaymentMethod::factory(),
                'ref_payco' =>  fake()->text(140),
                'codigo_respuesta' => random_int(1, 4),
                'respuesta' => fake()->text(140),
                'amount' => random_int(1, 1000000),
                'data' => fake()->text(140),
                'user_id' => random_int(DB::table('usuarios')->min('id'), DB::table('usuarios')->max('id')),
            ];
    }
}
