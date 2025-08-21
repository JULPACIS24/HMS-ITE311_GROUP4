<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Schedule Appointment</title>
	<link rel="stylesheet" href="<?= base_url('assets/css/appointments.css') ?>">
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/sidebar'); ?>

		<main class="main-content">
			<header class="header">
				<h1>Schedule Appointment</h1>
				<div class="user-info">
					<div class="user-avatar">A</div>
					<span>Admin</span>
				</div>
			</header>

			<div class="page-content">
				<form class="card form" method="post" action="<?= site_url('appointments/store') ?>">
					<div class="grid-2">
						<label>
							<span>Appointment Code (optional)</span>
							<input type="text" name="appointment_code" placeholder="APT001">
						</label>
						<label>
							<span>Type</span>
							<select name="type" required>
								<option>Consultation</option>
								<option>Follow-up</option>
								<option>Checkup</option>
								<option>Emergency</option>
							</select>
						</label>
					</div>

					<div class="grid-2">
						<label>
							<span>Patient Name</span>
							<input type="text" name="patient_name" required>
						</label>
						<label>
							<span>Patient Phone</span>
							<input type="text" name="patient_phone" placeholder="+1 (555) 123-4567">
						</label>
					</div>

					<div class="grid-2">
						<label>
							<span>Doctor</span>
							<input type="text" name="doctor_name" required>
						</label>
						<label>
							<span>Status</span>
							<select name="status" required>
								<option>Confirmed</option>
								<option selected>Pending</option>
								<option>Completed</option>
							</select>
						</label>
					</div>

					<div class="grid-2">
						<label>
							<span>Date</span>
							<input type="date" name="date" required>
						</label>
						<label>
							<span>Time</span>
							<input type="time" name="time" required>
						</label>
					</div>

					<div class="form-actions">
						<a href="<?= site_url('appointments') ?>" class="btn">Cancel</a>
						<button class="btn primary" type="submit">Save</button>
					</div>
				</form>
			</div>
		</main>
	</div>
</body>
</html>


