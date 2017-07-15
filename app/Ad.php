<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Ad extends Model
{
    public $timestamps = false;
    protected $table = 'ad';
    protected $primaryKey = 'ad_id';
    protected $guarded  = [
        'ad_id',
    ];
    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'company_id');
    }
    public function experience()
    {
        return $this->hasMany('App\ExperienceCompany','ad_id','ad_id');
    }
    public function requirements()
    {
        return $this->hasMany('App\Requirements','ad_id','ad_id');
    }
}