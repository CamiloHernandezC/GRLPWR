<?php

use Illuminate\Database\Seeder;

class TagSolicitudServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\TagsSolicitudServicio::class)->times(2)->create();
    }
}
