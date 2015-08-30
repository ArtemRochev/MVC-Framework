<?php

use core\config;

require_once(PROJ_PATH . 'app/core/Model.php');

class Comment extends Model {
	protected $columns = ['id', 'text', 'time'];
	protected $parent = 'user';

	public static function getComments() {
		return Comment::all();
	}
	
	public static function saveComment($userId) {
		$comment = new Comment;
		
		$comment->text = $_POST['text'];
		$comment->user_id = $userId;
		$comment->save();
	}
}
