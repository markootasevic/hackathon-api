<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class TagCompany extends Model
{
    public $timestamps = false;
    protected $table = 'tag_company';
    protected $primaryKey = 'tag_id';
    protected $guarded  = [
        'tag_id',
    ];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'company_id');
    }
    public function tag()
    {
        return $this->belongsTo('App\Tag', 'tag_id', 'tag_id');
    }
}