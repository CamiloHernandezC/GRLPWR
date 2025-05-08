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
class FitFuryTypeAchievement extends Achievement
{
    public $name = "Fit Fury achievement";
    public $slug = "Fit-Fury-achievement";
    public $description = "pudiste crear el logro Fit Fury";
}
