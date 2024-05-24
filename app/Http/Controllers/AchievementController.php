<?php

namespace App\Http\Controllers;

use Assada\Achievements\Model\AchievementProgress;



class AchievementController extends Controller
{
    public function showAchievements()
    {
        $achievements = AchievementProgress::where('achievement_id', 7)->with('achiever')->orderBy('points', 'desc')->get();
        return view('cliente.weekachievements', compact('achievements'));
    }
}
