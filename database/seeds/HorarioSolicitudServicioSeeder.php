<?php

use Illuminate\Database\Seeder;

class HorarioSolicitudServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\HorarioSolicitudServicio::class)->create();
    }
}
