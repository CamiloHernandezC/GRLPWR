<?php

use Illuminate\Database\Seeder;

class OfrecimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Ofrecimientos::class)->times(2)->create();
    }
}
