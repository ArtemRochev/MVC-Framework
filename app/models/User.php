<?php

require_once(CORE_PATH . 'base/Model.php');

class User extends Model {
	public function checkUserExists($userEmail) {
		return User::checkExists("user", "email", $userEmail)['isExist'];
	}

	public function addUser($userName, $userEmail) {
		$user = new User;

		$user->name = $userName;
		$user->email = $userEmail;
		$user->save();

		return $user->getColumn('id');
	}
}
