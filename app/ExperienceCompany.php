<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ExperienceCompany extends Model
{
    public $timestamps = false;
    protected $table = 'experience_company';
    protected $primaryKey = 'experience_company_id';
    protected $guarded  = [
        'experience_company_id',
    ];

    public function company()
    {
        return $this->belongsTo('App\Ad', 'ad_id', 'ad_id');
    }
}