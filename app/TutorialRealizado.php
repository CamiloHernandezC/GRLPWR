<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TutorialRealizado extends Model
{
    protected $table = 'tutoriales_realizados';

    protected $fillable = [
        'usuario_id',
        'tutorial_id',
    ];
}
