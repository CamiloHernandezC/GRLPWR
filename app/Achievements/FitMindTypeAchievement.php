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
class FitMindTypeAchievement extends Achievement
{
    public $name = "Fit Mind achievement";
    public $slug = "Fit-Mind-achievement";
    public $description = "pudiste crear el logro Fit Mind";
}
