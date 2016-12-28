<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomController extends Controller
{
    
    
    static function changeDate($arg)
    {
        return date('Y/m/d H:i', strtotime($arg));
    }
    
}
