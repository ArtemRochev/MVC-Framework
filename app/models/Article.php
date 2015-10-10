<?php

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

	public static function saveArticle($params) {
		if ( isset($params['id']) ) {
			$article = Article::findById($params['id']);
		} else {
			$article = new Article;
		}

		if ( $article->checkRequiredColumns($params) ) {
			$url = Text::translitUrl($params['title']);

			$article->author_id = 1;
			$article->title = $params['title'];
			$article->url = $url;
			$article->url_md5 = md5($url);
			$article->content = $params['content'];
			$article->img_preview_url = $params['img_preview_url'];

			$article->save();
		}
	}

	public function deleteArticle($id) {
		if ( isset($id) ) {
			$article = new Article($id);
			$article->delete();
		}
	}
}
