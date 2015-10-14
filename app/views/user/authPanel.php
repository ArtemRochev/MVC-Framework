<form id="adminPanelEnter" role="form" method="post" action="<?= Url::to('/admin/log-in') ?>">
	<h3>Вход</h3>
	<div class="form-group">
		<input type="text" id="email" name="email" placeholder="Email" required><br>
		<input type="password" id="pass" name="pass" placeholder="Password" required>
	</div>
	<p style="color: lightcoral">
		<?= !empty($_GET['error']) ? 'Email or Password is incorrect' : '' ?>
	</p>

	<button type="submit" class="btn btn-success">Войти</button>
</form>
