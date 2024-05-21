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
class WheelOfLifeAchievement extends Achievement
{
    public $name = "Wheel of life pin";
    public $slug = "Wheel-of-life-pin";
    public $description = "Felicidades, tienes tu pin por ser feliz!";
    public $points = 8;
}
