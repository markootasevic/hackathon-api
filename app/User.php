<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    public $timestamps = false;
    protected $table = 'user';
    protected $primaryKey = 'user_id';
    protected $guarded  = [
        'user_id',
    ];

    public function skills()
    {
        return $this->hasMany('App\Skill','user_id','user_id');
    }
    public function education()
    {
        return $this->hasMany('App\Education','user_id','user_id');
    }
    public function experrience()
    {
        return $this->hasMany('App\ExperienceUser','user_id','user_id');
    }
    public function criteria()
    {
        return $this->hasMany('App\Criteria','user_id','user_id');
    }

    public function tags()
    {
        return $this->hasMany('App\TagUser','user_id','user_id');
    }
}
