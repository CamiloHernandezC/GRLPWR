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
class FitPoundTypeAchievement extends Achievement
{
    public $name = "Fit Pound achievement";
    public $slug = "Fit-Pound-achievement";
    public $description = "pudiste crear el logro Fit Pound";
}
