<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalizeAll extends Model
{
    protected $fillable = [
    	'atcl_id',
        'view_date',
        'view_last',
        'total_count',
    ];
}
