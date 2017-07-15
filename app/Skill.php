<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Skill extends Model
{
    public $timestamps = false;
    protected $table = 'skill';
    protected $primaryKey = 'skill_id';
    protected $guarded  = [
        'skill_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}