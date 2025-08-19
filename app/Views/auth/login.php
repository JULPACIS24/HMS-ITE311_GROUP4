<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Secure Access - San Miguel Hospital Inc.</title>
	<link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
	<div class="auth-wrap">
		<div>
			<div class="brand">
				<div class="logo-circle">🏥</div>
				<h1 class="brand-title">San Miguel Hospital Inc.</h1>
				<p class="brand-subtitle">Centralized Management System</p>
			</div>

			<div class="card">
				<h2>Secure Access</h2>
				<p class="lead">Please enter your credentials to continue</p>

				<?php if (session()->getFlashdata('message')): ?>
					<div class="message"><?= esc(session()->getFlashdata('message')) ?></div>
				<?php endif ?>
				<?php if (session()->getFlashdata('errors')): ?>
					<div class="errors">
						<ul style="margin: 0 0 0 18px;">
							<?php foreach (session()->getFlashdata('errors') as $e): ?>
								<li><?= esc($e) ?></li>
							<?php endforeach ?>
						</ul>
					</div>
				<?php endif ?>

				<form method="post" action="<?= site_url('login') ?>">
					<?= csrf_field() ?>

					<div class="field">
						<label class="label">Username / Employee ID</label>
						<div class="input-wrap">
							<span class="input-icon">👤</span>
							<input type="text" name="email" value="<?= old('email') ?>" placeholder="Enter your username">
						</div>
					</div>

					<div class="field">
						<label class="label">Password</label>
						<div class="input-wrap">
							<span class="input-icon">🔒</span>
							<input type="password" name="password" placeholder="Enter your password">
						</div>
					</div>


					<div class="row">
						<label style="display:flex; align-items:center; gap:8px; font-size:12px; color:#374151;">
							<input type="checkbox" name="remember"> Remember me
						</label>
						<a class="muted-link" href="#">Forgot password?</a>
					</div>

					<button class="btn btn-primary" type="submit">Sign In to Dashboard</button>

					<div class="divider"></div>
					<p class="center-note">Need access to the system?</p>
					<a href="<?= site_url('register') ?>" class="btn btn-success" style="text-decoration:none;">Create New Account</a>
					<a class="tiny-link" href="#">Request Account Access</a>
				</form>
			</div>
		</div>
	</div>

</body>
</html>


