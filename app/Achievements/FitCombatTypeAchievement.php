<?php
declare(strict_types=1);

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;

/**
 * Class Registered
 *
 * @package App\Achievements
 */
class FitCombatTypeAchievement extends Achievement
{
    public $name = "Fit Combat achievement";
    public $slug = "Fit-Combat-achievement";
    public $description = "pudiste crear el logro Fit Combat";
}
