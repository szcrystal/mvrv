<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'Main\HomeController@index');
Route::get('m/{postId}', 'Main\HomeController@showSingle');


//Category
Route::get('category', 'Main\CategoryController@index');
Route::get('category/{slug}', 'Main\CategoryController@show');

//Tag
if(Schema::hasTable('tag_groups')) {
    $groupSlugs = DB::table('tag_groups')->where('open_status', 1)->get();
    foreach($groupSlugs as $gs) {
        Route::group(['prefix' => $gs->slug], function(){
            Route::get('/', 'Main\TagController@index');
            Route::get('{tagSlug}', 'Main\TagController@show');
        });
    }
}

//Contact
Route::get('contact/{id}', 'Main\ContactController@index');
Route::resource('contact', 'Main\ContactController');

//Fix
if(Schema::hasTable('fixes')) {
    $fixes = DB::table('fixes')->get();
    foreach($fixes as $fix) {
        Route::get($fix->slug, 'Main\HomeController@showFix');
    }
}

//Search
Route::get('search', 'Main\SearchController@index');


//MyPage
Route::get('mypage/{atclId}/create', 'MyPage\HomeController@create');
Route::get('mypage/newmovie', 'MyPage\HomeController@newMovie');
Route::group(['prefix' => 'mypage/base'], function(){
    Route::get('/', 'MyPage\HomeController@base');
    Route::get('{atclId}', 'MyPage\HomeController@base');
    Route::post('/', 'MyPage\HomeController@postBase');
});
Route::resource('mypage', 'MyPage\HomeController');


//DashBoard
Route::get('dashboard', 'dashboard\MainController@index');

Route::get('dashboard/login', 'dashboard\LoginController@index');
Route::post('dashboard/login', 'dashboard\LoginController@postLogin');

Route::get('dashboard/register', 'dashboard\MainController@getRegister');
Route::post('dashboard/register', 'dashboard\MainController@postRegister');
Route::get('dashboard/logout', 'dashboard\MainController@getLogout');

//User
Route::get('dashboard/userlogin/{userId}', 'dashboard\UserController@userLogin');
Route::resource('dashboard/users', 'dashboard\UserController');

//Article
Route::resource('dashboard/articles', 'dashboard\ArticleController');

//Tag
Route::resource('dashboard/taggroups', 'dashboard\TagGroupController');
Route::resource('dashboard/tags', 'dashboard\TagController');

//Category
Route::resource('dashboard/categories', 'dashboard\CategoryController');

//Fix
Route::resource('dashboard/fixes', 'dashboard\FixController');

//Contact
Route::get('dashboard/contacts/cate/{cateId}', 'dashboard\ContactController@getEditCate');
Route::post('dashboard/contacts/cate/{cateId}', 'dashboard\ContactController@postEditCate');
Route::resource('dashboard/contacts', 'dashboard\ContactController');


//Auth
Route::get('register/confirm/{key}', 'auth\RegisterController@registerConfirm');
Auth::routes();

//Route::get('/home', 'HomeController@index');
//
//Route::get('/auth/register', function () {
//	return view('auth/register');
//});





