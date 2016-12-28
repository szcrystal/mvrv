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

Route::get('/single/{postId}', 'Main\HomeController@showSingle');

//Tag
Route::get('tag', 'Main\TagController@index');
Route::get('tag/{slug}', 'Main\TagController@show');

//Category
Route::get('category', 'Main\CategoryController@index');
Route::get('category/{slug}', 'Main\CategoryController@show');


//Contact
Route::resource('contact', 'Main\ContactController');




//DashBoard
Route::get('dashboard', 'dashboard\MainController@index');

Route::get('dashboard/login', 'dashboard\LoginController@index');
Route::post('dashboard/login', 'dashboard\LoginController@postLogin');

Route::get('dashboard/register', 'dashboard\MainController@getRegister');
Route::post('dashboard/register', 'dashboard\MainController@postRegister');
Route::get('dashboard/logout', 'dashboard\MainController@getLogout');

//User
Route::resource('dashboard/users', 'dashboard\UserController');

//Article
Route::resource('dashboard/articles', 'dashboard\ArticleController');

//Tag
Route::resource('dashboard/taggroups', 'dashboard\TagGroupController');
Route::resource('dashboard/tags', 'dashboard\TagController');

//Category
Route::resource('dashboard/categories', 'dashboard\CategoryController');

//Contact
Route::get('dashboard/contacts/cate/{cateId}', 'dashboard\ContactController@getEditCate');
Route::post('dashboard/contacts/cate/{cateId}', 'dashboard\ContactController@postEditCate');
Route::resource('dashboard/contacts', 'dashboard\ContactController');


//Route::get('/dashboard/register', function () {
//	return view('dashboard/register');
//});

//MyPage
Route::get('mypage/{atclId}/create', 'MyPage\HomeController@create');
Route::resource('mypage', 'MyPage\HomeController');




Auth::routes();

Route::get('/home', 'HomeController@index');

Route::get('/auth/register', function () {
	return view('auth/register');
});
