<?php

namespace App\Providers;

use App\Tag;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('same_tag', function($attribute, $value, $parameters, $validator) {
            //$parameters -> varidationの引数 $parameters[0]:tagId $parameters[1]:groupId
        	$obj = Tag::whereNotIn('id',[$parameters[0]])->where(['group_id'=>$parameters[1], 'name'=>$value])->get();
            return $obj->isEmpty();
        });
        
        Validator::extend('date_check', function($attribute, $value, $parameters) {
            $dp = date_parse_from_format('Y-m-d', $value); //dateからパースする関数 おかしい書式にはwarningが返されるのでそれを利用
            return $dp['warning_count'] == 0;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
