<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagRelation extends Model
{
    protected $fillable = [
    	'atcl_id',
    	'tag_id',
        'tag_name',
    ];
}
