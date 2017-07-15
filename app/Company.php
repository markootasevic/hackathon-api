<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Company extends Model
{
    public $timestamps = false;
    protected $table = 'company';
    protected $primaryKey = 'company_id';
    protected $guarded  = [
        'company_id',
    ];
    public function ads()
    {
        return $this->hasMany('App\Ad','company_id','company_id');
    }
}