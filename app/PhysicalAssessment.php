<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalAssessment extends model
{

    protected $table = 'physical_assessments';
    protected $fillable = [
        'id',
        'user_id',
        'muscle',
        'visceral_fat',
        'body_fat',
        'water_level',
        'proteins',
        'basal_metabolism',
        'bone_mass',
        'body_score',
        'created_at',
        'updated_at'
    ];
    use HasFactory;



}