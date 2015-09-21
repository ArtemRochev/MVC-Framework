<form id="adminPanelEnter" role="form" method="post" action="/admin/main/log-in">
	<h3>Вход</h3>
	<div class="form-group">
		<input type="text" id="email" name="email" placeholder="Email" required><br>
		<input type="password" id="pass" name="pass" placeholder="Password" required>
	</div>
	<p style="color: lightcoral">
		<?= isset($_GET['error']) ? $_GET['error'] : '' ?>
	</p>

	<button type="submit" class="btn btn-success">Войти</button>
</form>
