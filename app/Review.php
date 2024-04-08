<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Review extends Model
{
    use HasFactory;
    //protected $table = "reviews";//sobra porque si cumple la convencion

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reviewer_id','rating','review',
    ];

    public function tiempo(){
        return (Carbon::parse($this->created_at)->diffForHumans());
    }

    public function reviewer(){
        return $this->belongsTo(User::class, 'reviewer_id', 'id');
    }

}
