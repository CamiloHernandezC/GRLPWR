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
class FitDefenseTypeAchievement extends Achievement
{
    public $name = "Fit Defense achievement";
    public $slug = "Fit-Defense-achievement";
    public $description = "pudiste crear el logro Fit Defense";
}
