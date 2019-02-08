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

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('config:cache');
    $exitCode = Artisan::call('view:clear');
    // return what you want
});

Route::get('/', function () {
    return view('auth.login');
});


Route::get('/home','DashboardController@index')->name('dashboard');
Route::get('/password/change', array('uses' => 'ProfileController@changePassword'));
 //after user login
Route::group(array('middleware' => 'revalidate','middleware' => 'auth'), function() {    
    //Route::get('/', 'DashboardController@index');

    Route::get('password/change', array('uses' => 'ProfileController@changePassword', 'as' => 'user.password.change'));
    Route::post('password/change', array('uses' => 'ProfileController@updatePassword', 'as' => 'user.password.change'));
    Route::get('profile/edit','ProfileController@profile');
    Route::post('profile/update','ProfileController@update');
    // Route::get('dashboard', 'DashboardController@index');


    // Route::get('users', 'UserController@index');
    // Route::resource('users','UserController');


    Route::get('/dashboard/connect_to_twitter', 'DashboardController@connecttotwitter');

    Route::post('/dashboard/connect_to_twitter', 'DashboardController@connect_to_twitter')->name('connect_to_twitter');

    Route::post('twitter/update','DashboardController@update_twitter');



    Route::get('/dashboard/connect_to_facebook', 'DashboardController@connecttofacebook');

    Route::post('/dashboard/connect_to_facebook', 'DashboardController@connect_to_facebook')->name('connect_to_facebook');

    Route::post('facebook/update', 'DashboardController@update_facebook');



 
    Route::get('/dashboard/connect_to_instagram', 'DashboardController@connecttoinstagram');

    Route::post('/dashboard/connect_to_instagram', 'DashboardController@connect_to_instagram')->name('connect_to_instagram');

    Route::post('instagram/update', 'DashboardController@update_instagram')->name('update_instagram');


    Route::post('dashboard/updated_token', 'DashboardController@instagram_feeds')->name('updated_instagram_token');


    Route::get('/instagram_feeds', 'DashboardController@instagram_feeds')->name('instagram_feeds');
   

    //feeds Routes 

    Route::get('/twitter_feeds', 'DashboardController@twitter_feeds')->name('twitter_feeds');


});




Auth::routes();

Route::group(['middleware' => 'revalidate', 'prefix' => 'admin', 'namespace' => 'Admin'], function () {
    // Auth::routes();
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('login', 'Auth\LoginController@login')->name('admin.login');
    Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout');

    Route::get('/register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Auth\RegisterController@register')->name('admin.register');

    Route::get('/passwords/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.passwords.email');
    Route::post('/passwords/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.passwords.email');

    //after login
    Route::group(array('middleware' => 'auth.admin'), function() {
        Route::get('password/change', array('uses' => 'ProfileController@changePassword', 'as' => 'admin.password.change'));
        Route::post('password/change', array('uses' => 'ProfileController@updatePassword', 'as' => 'admin.password.change'));
        Route::get('dashboard', 'DashboardController@index');
        Route::get('users/login-as/{id}', 'DashboardController@dologin');

        Route::get('marketplaces', 'MarketplaceController@index');
        Route::post('marketplaces/data', 'MarketplaceController@data');
        Route::resource('marketplaces','MarketplaceController');
        Route::get('marketplaces/searchcategory/{search}/{ids}', 'MarketplaceController@searchcategory');
        Route::get('marketplaces/export_products/{id}', 'MarketplaceController@export_products');
        Route::post('marketplaces/export_marketplace_products', 'MarketplaceController@export_marketplace_products')->name('marketplace.export_marketplace_products');

        Route::get('users', 'UserController@index');
        Route::resource('users','UserController');

        Route::get('sub_admin', 'AdminController@index');
        Route::resource('sub_admin','AdminController');

        Route::get('attributes', 'AttributeController@index');
        Route::post('attributes/data', 'AttributeController@data');
        Route::resource('attributes','AttributeController');

        Route::get('productattributes', 'ProductAttributeController@index');
        Route::post('productattributes/data', 'ProductAttributeController@data');
        Route::resource('productattributes','ProductAttributeController');

        Route::get('categories', 'CategoryController@index');
        Route::post('categories/data', 'CategoryController@data');
        Route::resource('categories','CategoryController');

        Route::get('products', 'ProductController@index');
        Route::post('products/data', 'ProductController@data');
        Route::resource('products','ProductController');


        Route::get('sub_categories', 'SubCategoryController@index');
        Route::post('sub_categories/data', 'SubCategoryController@data');
        Route::resource('sub_categories','SubCategoryController');
    });
});

defined('USER_IMAGE_DIR') or define('USER_IMAGE_DIR', base_path() . '/uploads/users/');
defined('USER_IMAGE_URL') or define('USER_IMAGE_URL', url('uploads/users').'/');

defined('PRODUCT_IMAGE_DIR') or define('PRODUCT_IMAGE_DIR', base_path() . '/uploads/products/');
defined('PRODUCT_IMAGE_URL') or define('PRODUCT_IMAGE_URL', url('uploads/products').'/');


defined('CATEGORY_IMAGE_DIR') or define('CATEGORY_IMAGE_DIR', base_path() . '/uploads/categories/');
defined('CATEGORY_IMAGE_URL') or define('CATEGORY_IMAGE_URL', url('uploads/categories').'/');


defined('SUB_CATEGORY_IMAGE_DIR') or define('SUB_CATEGORY_IMAGE_DIR', base_path() . '/uploads/sub_categories/');
defined('SUB_CATEGORY_IMAGE_URL') or define('SUB_CATEGORY_IMAGE_URL', url('uploads/sub_categories').'/');

defined('MARKETPLACES_IMAGE_DIR') or define('MARKETPLACES_IMAGE_DIR', base_path() . '/uploads/marketplaces/');
defined('MARKETPLACES_IMAGE_URL') or define('MARKETPLACES_IMAGE_URL', url('uploads/marketplaces').'/');

Auth::routes();


Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/twitter_feeds', 'DashboardController@twitter_feeds')->name('twitter_feeds');

Route::get('/facebook_feeds', 'DashboardController@facebook_feeds')->name('facebook_feeds');

Route::post('/instagram_feeds', 'DashboardController@instagram_feeds');

Route::post('/facebook_feeds', 'DashboardController@facebook_feeds');