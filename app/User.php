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
    public function educations()
    {
        return $this->hasMany('App\Education','user_id','user_id');
    }
    public function experrience()
    {
        return $this->hasMany('App\Experience','user_id','user_id');
    }
    public function criteria()
    {
        return $this->hasMany('App\Criteria','user_id','user_id');
    }
}
