<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Picture extends Model
{
    public $timestamps = false;
    protected $table = 'picture';
    protected $primaryKey = 'picture_id';
    protected $guarded  = [
        'picture_id',
    ];

    public function company()
    {
        return $this->belongsTo('App\Company', 'company_id', 'company_id');
    }
}