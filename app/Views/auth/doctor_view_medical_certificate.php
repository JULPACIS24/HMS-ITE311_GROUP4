<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>View Medical Certificate - Doctor Dashboard</title>
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
		.info-row { display:flex; margin-bottom:16px; border-bottom:1px solid #f1f5f9; padding-bottom:16px }
		.info-label { font-weight:600; color:#64748b; width:150px; flex-shrink:0 }
		.info-value { color:#0f172a; flex:1 }
		.btn { padding:8px 16px; border-radius:8px; text-decoration:none; font-weight:600; margin-right:12px; display:inline-block }
		.btn-primary { background:#2563eb; color:#fff }
		.btn-secondary { background:#64748b; color:#fff }
		.actions { margin-top:24px; text-align:center }
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>
		<main class="main-content">
			<header class="header">
				<h1>View Medical Certificate</h1>
			</header>
			<div class="dashboard-content">
				<div class="card">
					<div class="info-row">
						<div class="info-label">Certificate ID:</div>
						<div class="info-value"><?= $certificate['certificate_id'] ?></div>
					</div>
					<div class="info-row">
						<div class="info-label">Patient Name:</div>
						<div class="info-value"><?= $certificate['patient_name'] ?></div>
					</div>
					<div class="info-row">
						<div class="info-label">Age & Gender:</div>
						<div class="info-value"><?= $certificate['patient_age'] ?> years old, <?= $certificate['patient_gender'] ?></div>
					</div>
					<div class="info-row">
						<div class="info-label">Address:</div>
						<div class="info-value"><?= $certificate['patient_address'] ?></div>
					</div>
					<div class="info-row">
						<div class="info-label">Issue Date:</div>
						<div class="info-value"><?= date('F d, Y', strtotime($certificate['issue_date'])) ?></div>
					</div>
					<div class="info-row">
						<div class="info-label">Diagnosis:</div>
						<div class="info-value"><?= $certificate['diagnosis'] ?></div>
					</div>
					<?php if (!empty($certificate['medications'])): ?>
					<div class="info-row">
						<div class="info-label">Medications:</div>
						<div class="info-value"><?= nl2br($certificate['medications']) ?></div>
					</div>
					<?php endif; ?>
					<?php if (!empty($certificate['pregnancy_details'])): ?>
					<div class="info-row">
						<div class="info-label">Pregnancy Details:</div>
						<div class="info-value"><?= $certificate['pregnancy_details'] ?></div>
					</div>
					<?php endif; ?>
					<?php if (!empty($certificate['lmp'])): ?>
					<div class="info-row">
						<div class="info-label">LMP:</div>
						<div class="info-value"><?= $certificate['lmp'] ?></div>
					</div>
					<?php endif; ?>
					<?php if (!empty($certificate['edd'])): ?>
					<div class="info-row">
						<div class="info-label">EDD:</div>
						<div class="info-value"><?= $certificate['edd'] ?></div>
					</div>
					<?php endif; ?>
					<?php if (!empty($certificate['notes'])): ?>
					<div class="info-row">
						<div class="info-label">Notes:</div>
						<div class="info-value"><?= nl2br($certificate['notes']) ?></div>
					</div>
					<?php endif; ?>
					<div class="info-row">
						<div class="info-label">Doctor:</div>
						<div class="info-value"><?= $certificate['doctor_name'] ?>, MD (License: <?= $certificate['doctor_license'] ?>)</div>
					</div>
					<div class="actions">
						<a href="<?= site_url('doctor/medical-certificates') ?>" class="btn btn-secondary">← Back to Certificates</a>
						<a href="<?= site_url('doctor/medical-certificates/print/' . $certificate['id']) ?>" class="btn btn-primary">🖨️ Print Certificate</a>
					</div>
				</div>
			</div>
		</main>
	</div>
</body>
</html>
