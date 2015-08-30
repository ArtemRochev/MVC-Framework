<?php

require_once(PROJ_PATH . 'app/core/Model.php');

class Article extends Model {
	protected $columns = ['id', 'title', 'content', 'created'];
	protected $parent = 'author';

	public static function getArticles() {
		return Article::all();
	}
}
