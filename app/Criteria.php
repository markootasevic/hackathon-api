<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Criteria extends Model
{
    public $timestamps = false;
    protected $table = 'criteria';
    protected $primaryKey = 'criteria_id';
    protected $guarded  = [
        'criteria_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
}