<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleBase extends Model
{
    protected $fillable = [ //varchar:文字数
    	'owner_id',
        'post_id',
        'del_status',
        'up_date',
        'category',
        'title',
    	'sumbnail',
    	'sumbnail_url',
    	'tag_1',
        'tag_2',
        'tag_3',
        'movie_site',
    	'movie_url',
        'view_count',
    ];
}
