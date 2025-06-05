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
class QueenAchivement extends Achievement
{
    public $name = "Queen achievement";
    public $slug = "Fit-Queen-achievement";
    public $description = "Felicidades, tienes tu pin de reina de las clases";
    public $points = 12; /*Cambiar el puntaje si se quiere adicionar o eliminar un class_type*/

}
