<?php

require_once(CORE_PATH . 'base/Model.php');

class Article extends Model {
	protected $columns = ['title', 'content', 'created'];
	protected $parent = 'author';

	public static function getArticles() {
		return Article::all();
	}

	public static function getArticle($id = null) {
		if ( $id ) {
			return Article::findOne($id);
		}
	}
}
