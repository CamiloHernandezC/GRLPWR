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
class FitBoxTypeAchievement extends Achievement
{
    public $name = "Fit Box achievement";
    public $slug = "Fit-Box-achievement";
    public $description = "pudiste crear el logro Fit Box";
}
