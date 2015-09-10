<?php

require_once(CORE_PATH . 'base/Model.php');

class Article extends Model {
	protected $parent = 'author';
	protected $childrens = ['comment'];

	private $requiredColumns = ['title', 'content'];

	public function getComments() {
		return Comment::allWhere(['article_id' => $this->id]);
	}

	public function checkRequiredColumns($params) {
		foreach ( $this->requiredColumns as $column ) {
			if ( empty($params[$column]) ) {
				return false;
			}
		}

		return true;
	}

	public function getCommentCount() {
		return Article::getCount('comment', ['article_id' => $this->id]);
	}
}
