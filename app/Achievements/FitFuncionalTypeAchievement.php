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
class FitFuncionalTypeAchievement extends Achievement
{
    public $name = "Fit Funcional achievement";
    public $slug = "Fit-Funcional-achievement";
    public $description = "pudiste crear el logro Fit Funcional";
}
