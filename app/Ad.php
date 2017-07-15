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
}