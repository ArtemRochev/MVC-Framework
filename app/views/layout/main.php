<!DOCTYPE html>
<html>
<head>
	<base href="<?= App::$host ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test</title>

	<link rel="stylesheet" type="text/css" href="/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/style.css">
	<link href='http://fonts.googleapis.com/css?family=Play&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
	
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
</head>
<body>
	<div id="topPanel">
		<div class="w-limmiter main-col">
			<ul>
				<li><a href="/" class="title">Home</a></li>
				<li><a href="/article" class="title">Article</a></li>
				<li><a href="/admin" class="title">Admin</a></li>
			</ul>

			<div id="user">
				<p>
					Вы вошли как, <?= App::isAdmin() ? 'admin' : 'гость' ?>
				</p>
			</div>
		</div>
	</div>

	<div id="content" class="w-limmiter main-col">
		<?php
			include $view;
		?>
	</div>
</body>
</html>
