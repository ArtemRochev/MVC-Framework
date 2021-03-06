<?php

require_once(CORE_PATH . 'base/Model.php');

class Comment extends Model {
	protected $parent = 'author';
	protected $childrens = [];
	
	public static function saveComment($data, $isGuest = false) {
		$comment = new Comment();

		if ( $isGuest ) {
			$comment->author_id = 2; //Guest
		} else {
			$comment->author_id = $data['author_id'];
		}
		$comment->article_id = $data['article_id'];
		$comment->text = $data['text'];
		$comment->save();
	}

	public static function deleteComment($id) {
		$comment = Comment::findById($id);
		$comment->delete();
	}
}
