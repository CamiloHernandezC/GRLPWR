<?php

namespace App\Achievements;

use App\User;
use Assada\Achievements\Achievement;


class LeisureAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Leisure pin";
    public $slug = "Wheel-of-life-pin";
    public $description = "Felicidades, tienes tu pin por ser feliz!";
    public $points = 1;
}
