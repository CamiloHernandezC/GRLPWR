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
class SpecialTypeAchievement extends Achievement
{
    public $name = "Special achievement";
    public $slug = "Special-achievement";
    public $description = "pudiste crear el logro Special";
}
