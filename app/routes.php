<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/* API routes */
Route::group(array('prefix'=>'api/v1'), function()
{
	// Resources
	Route::group(array('before' => 'auth'), function(){
	    Route::resource('blog', 'BlogController');
	});

	// Public
	Route::resource('blog', 'BlogController', array( 'only' => array('index', 'show') ));

    // User Handling
    Route::post('login', 'UserController@login');
	Route::get('logout', 'UserController@logout');
	Route::get('loginstatus', function(){
		$user = Auth::user();
		if(Auth::check()){
			return Response::json(array('status' => true, 'name' => $user->name, 'email' => $user->email));
		}
		else{
			return Response::json(array('status' => false));
		}
	});
});


/* All other routes are handled by js */
Route::get('{any}', function($uri)
{
    return View::make('index');
})->where('any', '.*');
