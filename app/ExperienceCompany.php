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
        return $this->belongsTo('App\Company', 'company_id', 'company_id');
    }
}