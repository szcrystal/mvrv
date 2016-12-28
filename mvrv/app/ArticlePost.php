<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticlePost extends Model
{
    protected $fillable = [ //varchar:文字数
		'user_id',
        'base_id',
        'title',
    	'sub_title',
        'text',
        'image_title',
        'image_path',
        'image_url',
        'image_comment',
        'link_title',
        'link_url',
        'link_image_url',
    	'link_option',
        'open_status',
        'open_date',
    ];
}
