<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Requirements extends Model
{
    public $timestamps = false;
    protected $table = 'requirements';
    protected $primaryKey = 'requirements_id';
    protected $guarded  = [
        'requirements_id',
    ];
    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'company_id');
    }


}