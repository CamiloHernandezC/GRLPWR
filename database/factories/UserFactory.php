<?php

namespace Database\Factories;

use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'email' => fake()->unique()->safeEmail,
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
            'rol' => 'cliente',//fake()->randomElement(['cliente', 'entrenador']),
            'nombre' => fake()->name,
            'apellido_1' => fake()->lastName,
            'apellido_2' => fake()->lastName,
            'descripcion' => fake()->text(140),
            'telefono' => \Faker\Provider\de_CH\PhoneNumber::mobileNumber(),
            'fecha_nacimiento' => fake()->date(),
            'nivel' => fake()->randomDigit,
            'slug' => User::all()->max('id') + 1,//por defecto se coloca el id como la URL (slug) inicial
            'remember_token' => str_random(10)
        ];
    }
}
