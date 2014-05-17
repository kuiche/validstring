<?php

class UserTableSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{

		DB::table('users')->delete();

		User::create(
			array(
				'firstname' => "Samuel",
				'surname' => "Trangmar-Keates",
				'username' => "Kuiche",
				'email' => "samtkeates@gmail.com",
				'password' => Hash::make('pr1v2t3'),
			)
		);
	}

}