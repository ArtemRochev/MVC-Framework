<?php

require_once(CORE_PATH . 'base/Model.php');

class Article extends Model {
	protected $columns = ['title', 'content', 'img_preview_url', 'created'];
	protected $parent = 'author';

	private $requiredColumns = ['title', 'content'];

	public static function getArticles() {
		return Article::all();
	}

	public static function getArticle($id = null) {
		if ( $id ) {
			return Article::findOne($id);
		}
	}

	public function checkRequiredColumns($params) {
		foreach ( $this->requiredColumns as $column ) {
			if ( !isset($param[$column]) ) {
				return false;
			}
		}

		return true;
	}
}
