<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	protected $fillable = [ //varchar:文字数
    	'owner_id',
        'del_status',

        'cate_id',
        'title',
        'movie_site',
    	'movie_url',
    
        'sumbnail',
    	'sumbnail_org',
    	'content',
    
		'open_status',
        'open_history',
        'open_date',
        'view_count',

    ];

	//protected $connection = 'connection-name';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
//    protected $hidden = [
//        'password', 'remember_token',
//    ];

}


