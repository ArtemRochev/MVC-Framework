<?php

require_once(PROJ_PATH . 'app/core/Model.php');

class User extends Model {
	protected $columns = ['name', 'email'];
	protected $parent = '';

	function checkUserExists($userEmail) {
		return User::checkExists("user", "email", $userEmail)['isExist'];
	}

	function addUser($userName, $userEmail) {
		$user = new User;

		$user->name = $userName;
		$user->email = $userEmail;
		$user->save();

		return $user->getColumn('id');
	}
}
