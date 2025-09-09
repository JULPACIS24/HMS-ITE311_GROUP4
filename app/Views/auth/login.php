<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Secure Access - San Miguel Hospital Inc.</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
	<style>
		/* Reset and Base Styles */
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}
		
		body { 
			font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
			line-height: 1.6;
		}
		
		/* Custom Bootstrap Grid System */
		.container-fluid {
			width: 100%;
			padding-right: 0;
			padding-left: 0;
			margin-right: auto;
			margin-left: auto;
		}
		
		.row {
			display: flex;
			flex-wrap: wrap;
			margin-right: 0;
			margin-left: 0;
		}
		
		.g-0 {
			--bs-gutter-x: 0;
			--bs-gutter-y: 0;
		}
		
		.col-lg-6 {
			flex: 0 0 auto;
			width: 100%;
		}
		
		@media (min-width: 992px) {
			.col-lg-6 {
				flex: 0 0 auto;
				width: 50%;
			}
		}
		
		/* Display Utilities */
		.d-none {
			display: none !important;
		}
		
		.d-flex {
			display: flex !important;
		}
		
		@media (min-width: 992px) {
			.d-lg-flex {
				display: flex !important;
			}
		}
		
		/* Flexbox Utilities */
		.align-items-center {
			align-items: center !important;
		}
		
		.justify-content-center {
			justify-content: center !important;
		}
		
		/* Height Utilities */
		.min-vh-100 {
			min-height: 100vh !important;
		}
		
		/* Width Utilities */
		.w-100 {
			width: 100% !important;
		}
		
		/* Spacing Utilities */
		.px-3 {
			padding-left: 1rem !important;
			padding-right: 1rem !important;
		}
		
		.px-md-5 {
			padding-left: 3rem !important;
			padding-right: 3rem !important;
		}
		
		.py-5 {
			padding-top: 3rem !important;
			padding-bottom: 3rem !important;
		}
		
		.p-4 {
			padding: 1.5rem !important;
		}
		
		.p-md-5 {
			padding: 3rem !important;
		}
		
		.mb-0 {
			margin-bottom: 0 !important;
		}
		
		.mb-1 {
			margin-bottom: 0.25rem !important;
		}
		
		.mb-3 {
			margin-bottom: 1rem !important;
		}
		
		.mb-4 {
			margin-bottom: 1.5rem !important;
		}
		
		.mt-2 {
			margin-top: 0.5rem !important;
		}
		
		.mx-auto {
			margin-left: auto !important;
			margin-right: auto !important;
		}
		
		.ps-3 {
			padding-left: 1rem !important;
		}
		
		/* Text Utilities */
		.text-center {
			text-align: center !important;
		}
		
		.text-white {
			color: #fff !important;
		}
		
		.text-muted {
			color: #6c757d !important;
		}
		
		.fw-bold {
			font-weight: 700 !important;
		}
		
		.h4 {
			font-size: 1.5rem;
		}
		
		/* Background */
		.bg-hospital {
			background-image: url('<?= base_url('assets/images/WALL.jpg') ?>');
			background-size: cover;
			background-position: center;
		}
		
		/* Logo */
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
		
		/* Card */
		.card {
			position: relative;
			display: flex;
			flex-direction: column;
			min-width: 0;
			word-wrap: break-word;
			background-color: #fff;
			background-clip: border-box;
		}
		
		.shadow-sm {
			box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075) !important;
		}
		
		.border-0 {
			border: 0 !important;
		}
		
		.rounded-4 {
			border-radius: 0.5rem !important;
		}
		
		.card-body {
			flex: 1 1 auto;
			padding: 1rem;
		}
		
		/* Form Styles */
		.form-label {
			margin-bottom: 0.5rem;
			font-weight: 500;
			color: #212529;
		}
		
		.form-control {
			display: block;
			width: 100%;
			padding: 0.375rem 0.75rem;
			font-size: 1rem;
			font-weight: 400;
			line-height: 1.5;
			color: #212529;
			background-color: #fff;
			background-image: none;
			border: 1px solid #ced4da;
			border-radius: 0.375rem;
			transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
		}
		
		.form-control:focus {
			color: #212529;
			background-color: #fff;
			border-color: #86b7fe;
			outline: 0;
			box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
		}
		
		.form-control-lg {
			padding: 0.5rem 1rem;
			font-size: 1.25rem;
			border-radius: 0.5rem;
		}
		
		/* Button Styles */
		.btn {
			display: inline-block;
			font-weight: 400;
			line-height: 1.5;
			color: #212529;
			text-align: center;
			text-decoration: none;
			vertical-align: middle;
			cursor: pointer;
			user-select: none;
			background-color: transparent;
			border: 1px solid transparent;
			padding: 0.375rem 0.75rem;
			font-size: 1rem;
			border-radius: 0.375rem;
			transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
		}
		
		.btn-primary {
			color: #fff;
			background-color: #0d6efd;
			border-color: #0d6efd;
		}
		
		.btn-primary:hover {
			color: #fff;
			background-color: #0b5ed7;
			border-color: #0a58ca;
		}
		
		.btn-lg {
			padding: 0.5rem 1rem;
			font-size: 1.25rem;
			border-radius: 0.5rem;
		}
		
		/* Alert Styles */
		.alert {
			position: relative;
			padding: 0.75rem 1.25rem;
			margin-bottom: 1rem;
			border: 1px solid transparent;
			border-radius: 0.375rem;
		}
		
		.alert-success {
			color: #0f5132;
			background-color: #d1e7dd;
			border-color: #badbcc;
		}
		
		.alert-danger {
			color: #842029;
			background-color: #f8d7da;
			border-color: #f5c2c7;
		}
		
		/* List Styles */
		ul {
			list-style: none;
		}
		
		/* Responsive Design */
		@media (max-width: 991.98px) {
			.px-md-5 {
				padding-left: 1rem !important;
				padding-right: 1rem !important;
			}
			
			.p-md-5 {
				padding: 1.5rem !important;
			}
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

</body>
</html>


