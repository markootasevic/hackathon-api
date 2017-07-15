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
}