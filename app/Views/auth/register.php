<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Register</title>
</head>
<body>
	<h1>Register</h1>

	<?php if (session()->getFlashdata('errors')): ?>
		<ul style="color:red;">
			<?php foreach (session()->getFlashdata('errors') as $e): ?>
				<li><?= esc($e) ?></li>
			<?php endforeach ?>
		</ul>
	<?php endif ?>

	<form method="post" action="<?= site_url('register') ?>">
		<?= csrf_field() ?>
		<label>Name</label><br>
		<input type="text" name="name" value="<?= old('name') ?>"><br><br>

		<label>Email</label><br>
		<input type="email" name="email" value="<?= old('email') ?>"><br><br>

		<label>Password</label><br>
		<input type="password" name="password"><br><br>

		<label>Confirm Password</label><br>
		<input type="password" name="password_confirm"><br><br>

		<button type="submit">Create account</button>
	</form>

	<p>Already have an account? <a href="<?= site_url('login') ?>">Login</a></p>
</body>
</html>


