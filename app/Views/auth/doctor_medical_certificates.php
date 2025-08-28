<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Medical Certificates - Doctor Dashboard</title>
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
		.metric-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:24px }
		.metric { background:#fff; padding:20px; border-radius:12px; box-shadow:0 2px 4px rgba(0,0,0,.08) }
		.metric-value { font-size:28px; font-weight:700; color:#0f172a }
		.metric-title { font-size:12px; color:#64748b; margin-bottom:8px }
		.card { background:#fff; border-radius:12px; box-shadow:0 2px 4px rgba(0,0,0,.08); padding:24px }
		.btn { padding:8px 16px; border-radius:8px; text-decoration:none; font-weight:600; background:#2563eb; color:#fff }
		.table { width:100%; border-collapse:collapse }
		.table th, .table td { padding:12px; text-align:left; border-bottom:1px solid #f1f5f9 }
		.link { color:#2563eb; text-decoration:none }
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>
		<main class="main-content">
			<header class="header">
				<h1>Medical Certificates</h1>
			</header>
			<div class="dashboard-content">
				<div class="metric-grid">
					<div class="metric">
						<div class="metric-title">Total Certificates</div>
						<div class="metric-value"><?= $stats['total_certificates'] ?? 0 ?></div>
					</div>
					<div class="metric">
						<div class="metric-title">Active Certificates</div>
						<div class="metric-value"><?= $stats['active_certificates'] ?? 0 ?></div>
					</div>
					<div class="metric">
						<div class="metric-title">This Month</div>
						<div class="metric-value"><?= $stats['this_month'] ?? 0 ?></div>
					</div>
					<div class="metric">
						<div class="metric-title">Patients</div>
						<div class="metric-value"><?= count(array_unique(array_column($certificates, 'patient_id'))) ?></div>
					</div>
				</div>
				<div class="card">
					<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px">
						<h2>Recent Medical Certificates</h2>
						<a href="<?= site_url('doctor/medical-certificates/create') ?>" class="btn">➕ Create Certificate</a>
					</div>
					<?php if (empty($certificates)): ?>
						<div style="text-align:center; padding:40px; color:#64748b">
							<div style="font-size:48px; margin-bottom:16px">📋</div>
							<div style="font-size:18px; font-weight:600; margin-bottom:8px">No certificates yet</div>
							<a href="<?= site_url('doctor/medical-certificates/create') ?>" class="btn">Create Certificate</a>
						</div>
					<?php else: ?>
						<table class="table">
							<thead>
								<tr>
									<th>Certificate ID</th>
									<th>Patient Name</th>
									<th>Issue Date</th>
									<th>Diagnosis</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($certificates as $certificate): ?>
								<tr>
									<td><strong><?= $certificate['certificate_id'] ?></strong></td>
									<td><?= $certificate['patient_name'] ?></td>
									<td><?= date('M d, Y', strtotime($certificate['issue_date'])) ?></td>
									<td><?= substr($certificate['diagnosis'], 0, 50) . (strlen($certificate['diagnosis']) > 50 ? '...' : '') ?></td>
									<td>
										<a href="<?= site_url('doctor/medical-certificates/view/' . $certificate['id']) ?>" class="link">View</a>
										<a href="<?= site_url('doctor/medical-certificates/print/' . $certificate['id']) ?>" class="link">Print</a>
									</td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					<?php endif; ?>
				</div>
			</div>
		</main>
	</div>
</body>
</html>
