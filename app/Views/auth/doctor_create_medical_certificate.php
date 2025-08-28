<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Create Medical Certificate - Doctor Dashboard</title>
	<style>
		* { margin:0; padding:0; box-sizing:border-box }
		body { font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background:#f5f7fa }
		.container { display:flex; min-height:100vh }
		.sidebar { width:250px; background:linear-gradient(180deg,#2c3e50 0%, #34495e 100%); color:#fff; position:fixed; height:100vh }
		.sidebar-header { padding:20px; border-bottom:1px solid #34495e; display:flex; align-items:center; gap:12px }
		.admin-icon { width:32px; height:32px; background:#3498db; border-radius:6px; display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px }
		.sidebar-title { font-size:18px; font-weight:600 }
		.sidebar-menu { padding:12px 0 }
		.menu-item { display:flex; align-items:center; gap:12px; padding:12px 20px; color:#bdc3c7; text-decoration:none; border-left:3px solid transparent }
		.menu-item:hover { background:rgba(255,255,255,.08); color:#fff; border-left-color:#3498db }
		.menu-item.active { background:rgba(52,152,219,.2); color:#fff; border-left-color:#3498db }
		.menu-icon { width:20px; height:20px; display:flex; align-items:center; justify-content:center }
		.main-content { flex:1; margin-left:250px }
		.header { background:#fff; padding:18px 24px; box-shadow:0 2px 4px rgba(0,0,0,.08) }
		.header h1 { font-size:22px; color:#2c3e50; font-weight:700; margin:0 }
		.dashboard-content { padding:24px }
		.card { background:#fff; border-radius:12px; box-shadow:0 2px 4px rgba(0,0,0,.08); padding:24px; max-width:800px; margin:0 auto }
		.form-group { margin-bottom:20px }
		.form-group label { display:block; margin-bottom:8px; font-weight:600; color:#374151 }
		.form-group input, .form-group select, .form-group textarea { width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px }
		.form-group textarea { height:100px; resize:vertical }
		.btn { padding:12px 24px; border-radius:8px; text-decoration:none; font-weight:600; font-size:14px; border:none; cursor:pointer; display:inline-flex; align-items:center; gap:8px }
		.btn-primary { background:#2563eb; color:#fff }
		.btn-secondary { background:#64748b; color:#fff; margin-right:12px }
		.btn:hover { opacity:0.9 }
		.form-row { display:grid; grid-template-columns:1fr 1fr; gap:20px }
		@media (max-width: 768px) { .form-row { grid-template-columns:1fr } }
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<main class="main-content">
			<header class="header">
				<h1>Create Medical Certificate</h1>
			</header>

			<div class="dashboard-content">
				<div class="card">
					<form action="<?= site_url('doctor/medical-certificates/store') ?>" method="POST">
						<div class="form-row">
							<div class="form-group">
								<label for="patient_id">Patient *</label>
								<select name="patient_id" id="patient_id" required>
									<option value="">Select Patient</option>
									<?php foreach ($patients as $patient): ?>
									<option value="<?= $patient['id'] ?>">
										<?= $patient['first_name'] . ' ' . $patient['last_name'] ?> (<?= $patient['dob'] ? date_diff(date_create($patient['dob']), date_create('today'))->y : 'N/A' ?> years, <?= $patient['gender'] ?>)
									</option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group">
								<label for="issue_date">Issue Date *</label>
								<input type="date" name="issue_date" id="issue_date" value="<?= date('Y-m-d') ?>" required>
							</div>
						</div>

						<div class="form-group">
							<label for="diagnosis">Diagnosis *</label>
							<textarea name="diagnosis" id="diagnosis" placeholder="Enter patient diagnosis..." required></textarea>
						</div>

						<div class="form-group">
							<label for="medications">Medications</label>
							<textarea name="medications" id="medications" placeholder="Enter prescribed medications..."></textarea>
						</div>

						<div class="form-row">
							<div class="form-group">
								<label for="pregnancy_details">Pregnancy Details (if applicable)</label>
								<input type="text" name="pregnancy_details" id="pregnancy_details" placeholder="e.g., G1 P0 Pregnancy Uterine 23 Weeks">
							</div>
							<div class="form-group">
								<label for="lmp">Last Menstrual Period (LMP)</label>
								<input type="text" name="lmp" id="lmp" placeholder="e.g., Unrecalled">
							</div>
						</div>

						<div class="form-group">
							<label for="edd">Expected Due Date (EDD)</label>
							<input type="text" name="edd" id="edd" placeholder="e.g., June 16, 2023">
						</div>

						<div class="form-group">
							<label for="notes">Additional Notes</label>
							<textarea name="notes" id="notes" placeholder="Enter any additional notes..."></textarea>
						</div>

						<div style="margin-top:24px">
							<a href="<?= site_url('doctor/medical-certificates') ?>" class="btn btn-secondary">Cancel</a>
							<button type="submit" class="btn btn-primary">Create Certificate</button>
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>
</body>
</html>
