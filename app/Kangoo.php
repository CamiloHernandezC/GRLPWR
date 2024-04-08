<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kangoo extends Model
{
    protected $table = 'kangoos';
    use SoftDeletes;
}
