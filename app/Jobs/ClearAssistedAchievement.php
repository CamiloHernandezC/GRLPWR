<?php

namespace App\Jobs;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClearAssistedAchievement
{
    public function __construct()
    {}

    /**
     * This job clears the assisted class achievement progress for all users to start a new week progress
     *
     * @return void
     */
    public function __invoke(): void
    {
        Log::info('Cleaning the assisted class achievement progress');
        DB::table('achievement_progress')->where('achievement_id', env('ASSISTED_TO_CLASS_ACHIEVEMENT_ID'))->update(['points' => 0]);
        //TODO Se debe inicializar el campo unlocked_at a null cuando se borra el job
        Log::info('Successfully cleared assisted class achievement progress');
    }
}
