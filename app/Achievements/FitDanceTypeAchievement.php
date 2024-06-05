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
class FitDanceTypeAchievement extends Achievement
{
    public $name = "Fit Dance achievement";
    public $slug = "Fit-Dance-achievement";
    public $description = "pudiste crear el logro Fit Dance";
}
