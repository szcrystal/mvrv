<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TotalizeAll extends Model
{
    protected $fillable = [
    	'atcl_id',
        'total_count',
    ];
}
