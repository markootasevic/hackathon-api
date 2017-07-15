<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tag extends Model
{
    public $timestamps = false;
    protected $table = 'tag';
    protected $primaryKey = 'tag_id';
    protected $guarded  = [
        'tag_id',
    ];

    public function userTags()
    {
        return $this->hasMany('App\TagUser','tag_id','tag_id');
    }
    public function companyTags()
    {
        return $this->hasMany('App\TagCompany','tag_id','tag_id');
    }
    public function adTags()
    {
        return $this->hasMany('App\TagAd','tag_id','tag_id');
    }
}