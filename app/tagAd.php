<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TagAd extends Model
{
    public $timestamps = false;
    protected $table = 'tag_ad';
    protected $primaryKey = 'tag_id';
    protected $guarded  = [
        'tag_id',
    ];

    public function ad()
    {
        return $this->belongsTo('App\Ad', 'ad_id', 'ad_id');
    }
    public function tag()
    {
        return $this->belongsTo('App\Tag', 'tag_id', 'tag_id');
    }
}