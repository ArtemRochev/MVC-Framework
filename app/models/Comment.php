<?php

require_once(CORE_PATH . 'base/Model.php');

class Comment extends Model {
	protected $parent = 'author';
	protected $childrens = [];
	
	public static function saveComment($userId) {
		$comment = new Comment;
		
		$comment->text = $_POST['text'];
		$comment->user_id = $userId;
		$comment->save();
	}
}
