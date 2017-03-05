<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Totalize extends Model
{
    protected $fillable = [
    	'atcl_id',
        'view_date',
        'view_last',
        'view_count',
    ];
}
