<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Education extends Model
{
    public $timestamps = false;
    protected $table = 'education';
    protected $primaryKey = 'education_id';
    protected $guarded  = [
        'education_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}