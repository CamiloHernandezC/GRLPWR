<?php

namespace App\View\Composers;

use App\Achievements\FamilyAndFriendsAchievement;
use App\Achievements\HealthAchievement;
use App\Achievements\HomeAchievement;
use App\Achievements\LeisureAchievement;
use App\Achievements\LoveAchievement;
use App\Achievements\MoneyAchievement;
use App\Achievements\PersonalGrowthAchievement;
use App\Achievements\RecordWeeksTrained;
use App\Achievements\WeeksTrained;
use App\Achievements\WorkAchievement;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class AchievementsComposer
{
    /**
    * Bind data to the view.
    */
    public function compose(View $view): void
    {
        $route = Route::current();
        $user = $route->parameter('user');
        $weeksStreak = $user->achievementStatus(new WeeksTrained());
        $recordWeeksStreak = $user->achievementStatus(new RecordWeeksTrained());
        $healthAchievement = $user->achievementStatus (new HealthAchievement());
        $loveAchievement = $user->achievementStatus (new LoveAchievement());
        $familyAndFriendsAchievement = $user->achievementStatus (new FamilyAndFriendsAchievement());
        $homeAchievement = $user->achievementStatus (new HomeAchievement());
        $leisureAchievement = $user->achievementStatus (new LeisureAchievement());
        $moneyAchievement = $user->achievementStatus (new MoneyAchievement());
        $workAchievement = $user->achievementStatus (new WorkAchievement());
        $personalGrowthAchievement = $user->achievementStatus (new PersonalGrowthAchievement());

        $view->with([
            'weeksStreak' => $weeksStreak,
            'recordWeeksStreak' => $recordWeeksStreak,
            'healthAchievement' => $healthAchievement,
            'loveAchievement' => $loveAchievement,
            'familyAndFriendsAchievement' => $familyAndFriendsAchievement,
            'homeAchievement' => $homeAchievement,
            'leisureAchievement' => $leisureAchievement,
            'moneyAchievement' => $moneyAchievement,
            'workAchievement' => $workAchievement,
            'personalGrowthAchievement' => $personalGrowthAchievement
        ]);
    }
}