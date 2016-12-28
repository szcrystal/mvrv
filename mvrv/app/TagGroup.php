<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagGroup extends Model
{
    protected $fillable = [ //varchar:文字数
    	'name',
        'slug',
        'open_status',
    ];

}
