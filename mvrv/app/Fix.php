<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fix extends Model
{
	protected $fillable = [
    	'not_open',
    	'title',
        'sub_title',
        'slug',
        'contents',
    ];
    
//    public function getRouteKeyName()
//    {
//        return 'slug';
//    }
    
}

