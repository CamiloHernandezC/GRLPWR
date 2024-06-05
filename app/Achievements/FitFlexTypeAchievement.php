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
class FitFlexTypeAchievement extends Achievement
{
    public $name = "Fit Flex achievement";
    public $slug = "Fit-Flex-achievement";
    public $description = "pudiste crear el logro Fit Flex";
}
