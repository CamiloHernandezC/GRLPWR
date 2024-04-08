<?php

namespace Database\Factories;

use App\EventHour;
use App\Evento;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Evento>
 */
class EventoFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nombre' => fake()->text(20),
            'descripcion' => fake()->text(255),
            'imagen' => fake()->text(20),
            'lugar' => fake()->text(20),
            'info_adicional' => fake()->text(250),
            'branch_id' => random_int(DB::table('branches')->min('id'), DB::table('branches')->max('id')),
            'class_type_id' => random_int(DB::table('class_types')->min('id'), DB::table('class_types')->max('id')),
            'cupos' => random_int(1, 20),
            'precio' => random_int(20000, 1000000),
            'repeatable' => fake()->boolean,
            /*'fecha_inicio' => Carbon::now()->addDays(random_int(1, 30))->format('Y-m-d'),
            'fecha_fin' => Carbon::now()->addDays(random_int(1, 30))->format('Y-m-d')*/
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Evento $event) {
            if($event->repeatable){
                EventHour::factory()->count(random_int(1, 3))->create();
            }
            else{
                $fechaInicio = Carbon::now()->addDays(random_int(1, 30));
                $fechaFin = $fechaInicio->addDays(random_int(1, 30));
                $hour = random_int(0, 23);
                $minute = random_int(0, 59);
                $second = random_int(0, 59);
                $startHour = ($hour < 10 ? '0' : '') . $hour . ':';
                $startHour .= ($minute < 10 ? '0' : '') . $minute . ':';
                $startHour .= ($second < 10 ? '0' : '') . $second;
                $endHour = Carbon::createFromTimeString($startHour)->addHours(random_int(1, 4))->format('H:i:s');
                $event->fecha_inicio = $fechaInicio->format('Y-m-d');
                $event->fecha_fin = $fechaFin->format('Y-m-d');
                $event->start_hour = $startHour;
                $event->end_hour = $endHour;

            }
        });
    }
}
