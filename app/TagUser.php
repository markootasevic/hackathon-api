<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TagUser extends Model
{
    public $timestamps = false;
    protected $table = 'tag_user';
    protected $primaryKey = 'tag_id';
    protected $guarded  = [
        'tag_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'user_id');
    }
    public function tag()
    {
        return $this->belongsTo('App\Tag', 'tag_id', 'tag_id');
    }
}