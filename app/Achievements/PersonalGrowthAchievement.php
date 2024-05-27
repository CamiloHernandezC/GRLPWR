<?php

namespace App\Achievements;

use Assada\Achievements\Achievement;


class PersonalGrowthAchievement extends Achievement
{
    /**
     * Class Registered
     *
     * @package App\Achievements
     */
    public $name = "Personal Growth pin";
    public $slug = "Wheel-of-life-pin";
    public $description = "Felicidades, tienes tu pin por ser feliz!";
    public $points = 1;
}
