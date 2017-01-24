<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [ //varchar:文字数
    	'atcl_id',
        'item_type',

        'main_title',
        'title_option',
    
        'main_text',
    
        'image_path',
        'image_title',
        'image_orgurl',
        'image_comment',
		
    	'link_title',
        'link_url',
        'link_imgurl',
        'link_option',
    
        'item_sequence',
    
        'delete_key',
    ];
    

}

