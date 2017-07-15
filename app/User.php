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
}
