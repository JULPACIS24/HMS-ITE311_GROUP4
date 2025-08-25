<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • Lab Requests</title>
	<style>
		*{margin:0;padding:0;box-sizing:border-box}
		body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,sans-serif;background:#f5f7fa}
		.container{display:flex;min-height:100vh}
		.sidebar{width:250px;background:linear-gradient(180deg,#2c3e50 0%,#34495e 100%);color:#fff;position:fixed;height:100vh;overflow-y:auto}
		.sidebar-header{padding:20px;border-bottom:1px solid #34495e;display:flex;align-items:center;gap:12px}
		.admin-icon{width:36px;height:36px;border-radius:8px;background:#3498db;display:grid;place-items:center}
		.sidebar-title{font-size:16px;font-weight:700}
		.sidebar-sub{font-size:12px;color:#cbd5e1;margin-top:2px}
		.sidebar-menu{padding:20px 0}
		.menu-item{display:flex;align-items:center;gap:12px;padding:12px 20px;color:#cbd5e1;text-decoration:none;border-left:3px solid transparent}
		.menu-item:hover{background:rgba(255,255,255,.1);color:#fff;border-left-color:#3498db}
		.menu-item.active{background:rgba(52,152,219,.2);color:#fff;border-left-color:#3498db}
		.menu-icon{width:20px;text-align:center}
		.main{flex:1;margin-left:250px}
		.header{background:#fff;padding:18px 24px;box-shadow:0 2px 4px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center}
		.header-left{display:flex;flex-direction:column}
		.header h1{font-size:22px;font-weight:700;color:#2c3e50;margin:0}
		.header .sub{font-size:12px;color:#64748b}
		.actions{display:flex;align-items:center;gap:14px}
		.icon-btn{position:relative;width:34px;height:34px;border-radius:10px;background:#f8fafc;border:1px solid #e5e7eb;display:grid;place-items:center}
		.badge{position:absolute;top:-4px;right:-4px;background:#ef4444;color:#fff;border-radius:999px;font-size:10px;padding:2px 6px;font-weight:700}
		.avatar{width:34px;height:34px;border-radius:50%;background:#2563eb;color:#fff;display:grid;place-items:center;font-weight:800}
		.user-meta{line-height:1.1}
		.user-name{font-weight:700;font-size:13px;color:#0f172a}
		.user-role{font-size:11px;color:#64748b}
		.user-chip{display:flex;align-items:center;gap:10px}

		.page{padding:24px}
		.overview{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-bottom:32px}
		.stat-card{background:#fff;border-radius:12px;padding:20px;box-shadow:0 2px 10px rgba(0,0,0,.08)}
		.stat-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
		.stat-title{font-size:12px;color:#64748b;font-weight:600}
		.stat-icon{width:32px;height:32px;border-radius:8px;display:grid;place-items:center;font-size:16px}
		.stat-value{font-size:28px;font-weight:700;color:#0f172a;margin-bottom:4px}
		.stat-sub{font-size:11px;color:#64748b}
		
		.content-section{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden}
		.section-header{padding:20px;border-bottom:1px solid #ecf0f1;display:flex;justify-content:space-between;align-items:center}
		.section-title{font-size:18px;font-weight:700;color:#0f172a}
		.section-controls{display:flex;align-items:center;gap:12px}
		.filter-select{padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;background:#fff}
		.btn{display:inline-block;padding:10px 20px;border:none;border-radius:8px;font-weight:600;text-decoration:none;cursor:pointer;font-size:14px}
		.btn-primary{background:#2563eb;color:#fff}
		.btn:hover{opacity:0.9}
		
		.lab-requests-list{padding:20px}
		.empty-state{text-align:center;padding:60px 20px;color:#64748b}
		.empty-icon{font-size:48px;margin-bottom:16px;opacity:0.5}
		.empty-title{font-size:18px;font-weight:600;margin-bottom:8px;color:#374151}
		.empty-sub{font-size:14px;margin-bottom:24px}
		
		.lab-request-card{background:#f8fafc;border-radius:10px;padding:16px;margin-bottom:16px;border:1px solid #e5e7eb}
		.request-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px}
		.patient-info{display:flex;align-items:center;gap:12px}
		.patient-avatar{width:40px;height:40px;border-radius:8px;background:#8b5cf6;color:#fff;display:grid;place-items:center;font-weight:700;font-size:14px}
		.patient-details{line-height:1.3}
		.patient-name{font-weight:600;color:#0f172a;font-size:14px}
		.patient-id{font-size:12px;color:#64748b}
		.request-actions{display:flex;gap:8px}
		.action-btn{width:32px;height:32px;border-radius:6px;border:none;cursor:pointer;display:grid;place-items:center;font-size:14px}
		.action-view{background:#ecfdf5;color:#059669}
		.action-edit{background:#eff6ff;color:#2563eb}
		.action-print{background:#fef3c7;color:#d97706}
		.action-delete{background:#fef2f2;color:#dc2626}
		
		.request-details{margin-bottom:12px}
		.tests{font-size:13px;color:#374151;margin-bottom:8px;line-height:1.4}
		.reason{font-size:12px;color:#64748b;margin-bottom:8px}
		.request-meta{display:flex;justify-content:space-between;align-items:center}
		.request-info{display:flex;gap:16px;font-size:12px;color:#64748b}
		.status-tags{display:flex;gap:8px}
		.status-tag{padding:4px 8px;border-radius:6px;font-size:11px;font-weight:600}
		.status-completed{background:#ecfdf5;color:#059669}
		.status-pending{background:#fef3c7;color:#d97706}
		.status-progress{background:#eff6ff;color:#2563eb}
		.status-cancelled{background:#fef2f2;color:#dc2626}
		.priority-routine{background:#f3f4f6;color:#374151}
		.priority-urgent{background:#fef3c7;color:#d97706}
		.priority-stat{background:#fef2f2;color:#dc2626}
		
		.alert{padding:12px 16px;border-radius:8px;margin-bottom:20px}
		.alert-success{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
		.alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<div class="main">
			<div class="header">
				<div class="header-left">
					<h1>Lab Requests</h1>
					<div class="sub">Manage laboratory test orders and review results</div>
				</div>
				<div class="actions">
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" id="userBtn" style="cursor:pointer">
							<div class="avatar">DR</div>
							<div class="user-meta">
								<div class="user-name"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></div>
								<div class="user-role"><?= session('specialty') ?? session('department') ?? 'Medical' ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="page">
				<?php if (session('error')): ?>
					<div class="alert alert-error"><?= session('error') ?></div>
				<?php endif; ?>
				
				<?php if (session('message')): ?>
					<div class="alert alert-success"><?= session('message') ?></div>
				<?php endif; ?>

				<!-- Overview Cards -->
				<div class="overview">
					<div class="stat-card">
						<div class="stat-header">
							<div class="stat-title">Total Requests</div>
							<div class="stat-icon" style="background:#eff6ff;color:#2563eb">🧪</div>
						</div>
						<div class="stat-value"><?= $stats['total_requests'] ?></div>
						<div class="stat-sub">This month</div>
					</div>
					
					<div class="stat-card">
						<div class="stat-header">
							<div class="stat-title">Pending Results</div>
							<div class="stat-icon" style="background:#fef3c7;color:#d97706">⏰</div>
						</div>
						<div class="stat-value"><?= $stats['pending_results'] ?></div>
						<div class="stat-sub">Awaiting lab</div>
					</div>
					
					<div class="stat-card">
						<div class="stat-header">
							<div class="stat-title">STAT Orders</div>
							<div class="stat-icon" style="background:#fef2f2;color:#dc2626">🚨</div>
						</div>
						<div class="stat-value"><?= $stats['stat_orders'] ?></div>
						<div class="stat-sub">Urgent priority</div>
					</div>
					
					<div class="stat-card">
						<div class="stat-header">
							<div class="stat-title">Completed Today</div>
							<div class="stat-icon" style="background:#ecfdf5;color:#059669">✅</div>
						</div>
						<div class="stat-value"><?= $stats['completed_today'] ?></div>
						<div class="stat-sub">Results ready</div>
					</div>
				</div>

				<!-- Lab Requests Section -->
				<div class="content-section">
					<div class="section-header">
						<div class="section-title">Laboratory Requests</div>
						<div class="section-controls">
							<select class="filter-select">
								<option>All Status</option>
								<option>Pending</option>
								<option>In Progress</option>
								<option>Completed</option>
								<option>Cancelled</option>
							</select>
							<a href="<?= site_url('doctor/lab-requests/create') ?>" class="btn btn-primary">+ New Lab Request</a>
						</div>
					</div>
					
					<div class="lab-requests-list">
						<?php if (empty($labRequests ?? [])): ?>
							<div class="empty-state">
								<div class="empty-icon">🧪</div>
								<div class="empty-title">No Lab Requests Yet</div>
								<div class="empty-sub">Start by creating your first laboratory test request for a patient</div>
								<a href="<?= site_url('doctor/lab-requests/create') ?>" class="btn btn-primary">Create First Request</a>
							</div>
						<?php else: ?>
							<?php foreach ($labRequests as $request): ?>
								<div class="lab-request-card">
									<div class="request-header">
										<div class="patient-info">
											<?php 
												$initials = '';
												$nameParts = explode(' ', $request['patient_name']);
												if (count($nameParts) >= 2) {
													$initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
												} else {
													$initials = strtoupper(substr($request['patient_name'], 0, 2));
												}
											?>
											<div class="patient-avatar"><?= $initials ?></div>
											<div class="patient-details">
												<div class="patient-name"><?= esc($request['patient_name']) ?></div>
												<div class="patient-id"><?= esc($request['patient_id']) ?></div>
											</div>
										</div>
										<div class="request-actions">
											<a href="<?= site_url('doctor/lab-requests/view/' . $request['id']) ?>" class="action-btn action-view" title="View Details">👁️</a>
											<a href="<?= site_url('doctor/lab-requests/edit/' . $request['id']) ?>" class="action-btn action-edit" title="Edit Request">✏️</a>
											<button class="action-btn action-print" title="Print Request">🖨️</button>
											<button onclick="deleteLabRequest(<?= $request['id'] ?>)" class="action-btn action-delete" title="Delete Request">🗑️</button>
										</div>
									</div>
									
									<div class="request-details">
										<div class="tests"><?= esc($request['tests']) ?></div>
										<div class="reason"><?= esc($request['clinical_notes'] ?? 'No clinical notes provided') ?></div>
									</div>
									
									<div class="request-meta">
										<div class="request-info">
											<span><?= esc($request['lab_id']) ?></span>
											<span><?= date('Y-m-d', strtotime($request['created_at'])) ?></span>
										</div>
										<div class="status-tags">
											<span class="status-tag status-<?= strtolower(str_replace(' ', '-', $request['status'])) ?>"><?= $request['status'] ?></span>
											<span class="status-tag priority-<?= strtolower($request['priority']) ?>"><?= $request['priority'] ?></span>
										</div>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		function deleteLabRequest(requestId) {
			if (confirm('Are you sure you want to delete this lab request?')) {
				fetch(`<?= site_url('doctor/lab-requests/delete') ?>/${requestId}`, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					}
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						alert('Lab request deleted successfully!');
						location.reload();
					} else {
						alert('Error: ' + data.message);
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('Error deleting lab request.');
				});
			}
		}
	</script>
</body>
</html>

