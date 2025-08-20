<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Secure Access - San Miguel Hospital Inc.</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
	<style>
		body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial; }
		.bg-hospital {
			background-image: url('<?= base_url('assets/images/WALL.jpg') ?>');
			background-size: cover;
			background-position: center;
		}
		.logo-circle {
			width: 84px;
			height: 84px;
			border-radius: 50%;
			background: rgba(255,255,255,0.9);
			display: grid;
			place-items: center;
			font-size: 36px;
			box-shadow: 0 8px 24px rgba(0,0,0,0.15);
		}
	</style>
</head>
<body>
	<div class="container-fluid">
		<div class="row g-0">
			<div class="col-lg-6 d-none d-lg-flex min-vh-100 bg-hospital">
				<div class="w-100 d-flex align-items-center justify-content-center">
					<div class="text-center text-white">
						<div class="logo-circle mx-auto mb-3">🏥</div>
						<h1 class="fw-bold">San Miguel Hospital Inc.</h1>
						<p class="mb-0" style="opacity:.95;">Centralized Management System</p>
					</div>
				</div>
			</div>

			<div class="col-lg-6 d-flex align-items-center min-vh-100">
				<div class="w-100 px-3 px-md-5 py-5">
					<div class="mx-auto" style="max-width: 420px;">
						<div class="card shadow-sm border-0 rounded-4">
							<div class="card-body p-4 p-md-5">
								<h2 class="h4 fw-bold mb-1">Secure Access</h2>
								<p class="text-muted mb-4">Please enter your credentials to continue</p>

								<?php if (session()->getFlashdata('message')): ?>
									<div class="alert alert-success" role="alert"><?= esc(session()->getFlashdata('message')) ?></div>
								<?php endif ?>
								<?php if (session()->getFlashdata('errors')): ?>
									<div class="alert alert-danger mb-4" role="alert">
										<ul class="mb-0 ps-3">
											<?php foreach (session()->getFlashdata('errors') as $e): ?>
												<li><?= esc($e) ?></li>
											<?php endforeach ?>
										</ul>
									</div>
								<?php endif ?>

								<form method="post" action="<?= site_url('login') ?>" class="mt-2">
									<?= csrf_field() ?>
									<div class="mb-3">
										<label class="form-label">Email</label>
										<input type="email" name="email" value="<?= old('email') ?>" class="form-control form-control-lg" placeholder="you@example.com" required>
									</div>
									<div class="mb-3">
										<label class="form-label">Password</label>
										<input type="password" name="password" class="form-control form-control-lg" placeholder="••••••••" required>
									</div>
									<button type="submit" class="btn btn-primary btn-lg w-100">Login</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>


