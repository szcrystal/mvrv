<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [ //varchar:文字数
    	'group_id',
    	'name',
        'slug',
        'view_count',
    ];
}
