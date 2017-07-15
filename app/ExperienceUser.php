<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ExperienceUser extends Model
{
    public $timestamps = false;
    protected $table = 'experience_user';
    protected $primaryKey = 'experience_user_id';
    protected $guarded  = [
        'experience_user_id',
    ];
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}