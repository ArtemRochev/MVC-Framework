<?php

require_once(CORE_PATH . 'base/Model.php');

class User extends Model {
	protected $columns = ['id', 'name', 'email'];
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
