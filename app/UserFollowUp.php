<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowUp extends Model
{
    use HasFactory;

    protected $table = 'users_follow_up';

    protected $fillable = [
        'user_id',
        'follower_id',
        'level_of_interes',
        'contact_date',
        'next_contact_date',
        'response',
        'notes',
    ];
}
