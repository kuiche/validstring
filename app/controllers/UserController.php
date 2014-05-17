<?php

class UserController extends \BaseController {

	public function login() {
		$username = Input::get('username');
		$password = Input::get('password');

		if ( Auth::attempt(array('username' => $username, 'password' => $password), true) ) {
			$user = Auth::user();
			return Response::json(array('name' => $user->name, 'email' => $user->email), 200);
		} else {
			return Response::make(array(), 401);
		}
	}

	public function logout() {
		Auth::logout();
	}
}
