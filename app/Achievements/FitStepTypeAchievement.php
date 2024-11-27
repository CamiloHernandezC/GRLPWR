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
class FitStepTypeAchievement extends Achievement
{
    public $name = "Fit Step achievement";
    public $slug = "Fit-Step-achievement";
    public $description = "pudiste crear el logro Fit Step";
}
