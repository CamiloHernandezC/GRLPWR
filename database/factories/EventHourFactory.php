<?php

namespace Database\Factories;

use App\EventHour;
use App\Evento;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\EventHour>
 */
class EventHourFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $hour = random_int(0, 23);
        $minute = random_int(0, 59);
        $second = random_int(0, 59);
        $startHour = ($hour < 10 ? '0' : '') . $hour . ':';
        $startHour .= ($minute < 10 ? '0' : '') . $minute . ':';
        $startHour .= ($second < 10 ? '0' : '') . $second;
        $endHour = Carbon::createFromTimeString($startHour)->addHours(random_int(1, 4))->format('H:i:s');
        if(Evento::where('repeatable', 1)->count() > 0){
            $eventId = random_int(DB::table('eventos')->where('repeatable', 1)->min('id'), DB::table('eventos')->where('repeatable', 1)->max('id'));
        }else{
            $eventId = Evento::factory()->create(['repeatable'=> 1])->id;
        }
        /*This logic will create two event hours if:
         * EventHourFactory is called and there are no Events with repetable,
         * therefore EventoFactory is called from line above with repeatable = 1
         * in EventoFactory callback EventHourFactory is called again,
         * this time an event with repeatable = 1 does exist, therefore another EventHour is created (but there is no infinite loop)
        */

        return [
            'event_id' => $eventId,
            'day' => ucfirst($this->faker->dayOfWeek),
            'start_hour'=> $startHour,
            'end_hour'=> $endHour,
        ];
    }
}
