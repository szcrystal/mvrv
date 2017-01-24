<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
    	'ask_category',
        'delete_id',
        'user_name',
        'user_email',
        'context',
        'done_status',
    ];
}
