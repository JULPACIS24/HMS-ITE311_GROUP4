<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor Dashboard</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<style>
		* { margin:0; padding:0; box-sizing:border-box }
		body { font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; background:#f5f7fa }
		.container { display:flex; min-height:100vh }
		.sidebar { width:250px; background:linear-gradient(180deg,#2c3e50 0%, #34495e 100%); color:#fff; position:fixed; height:100vh; overflow-y:auto }
		.sidebar-header { padding:20px; border-bottom:1px solid #34495e; display:flex; align-items:center; gap:12px }
		.admin-icon { width:36px; height:36px; background:#3498db; border-radius:8px; display:grid; place-items:center; font-weight:700 }
		.sidebar-title { font-size:16px; font-weight:700 }
		.sidebar-sub { font-size:12px; color:#cbd5e1; margin-top:2px }
		.sidebar-menu { padding:20px 0 }
		.menu-item { display:flex; align-items:center; gap:12px; padding:12px 20px; color:#cbd5e1; text-decoration:none; border-left:3px solid transparent }
		.menu-item:hover { background:rgba(255,255,255,.1); color:#fff; border-left-color:#3498db }
		.menu-item.active { background:rgba(52,152,219,.2); color:#fff; border-left-color:#3498db }
		.menu-item.disabled { pointer-events:none; opacity:.6 }
		.menu-icon { width:20px; text-align:center }
		.main-content { flex:1; margin-left:250px }
		.header { background:#fff; padding:18px 24px; box-shadow:0 2px 4px rgba(0,0,0,.08); display:flex; justify-content:space-between; align-items:center }
		.header h1 { font-size:22px; color:#2c3e50; font-weight:700; margin:0 }
		.header .subtext { color:#64748b; font-size:12px; margin-top:2px }
		.header-left { display:flex; flex-direction:column }
		.actions { display:flex; align-items:center; gap:14px }
		.icon-btn { position:relative; width:34px; height:34px; border-radius:10px; background:#f8fafc; display:grid; place-items:center; border:1px solid #e5e7eb; cursor:default }
		.badge { position:absolute; top:-4px; right:-4px; background:#ef4444; color:#fff; border-radius:999px; font-size:10px; padding:2px 6px; font-weight:700 }
		.user-chip { display:flex; align-items:center; gap:10px }
		.avatar { width:34px; height:34px; border-radius:50%; background:#2563eb; color:#fff; display:grid; place-items:center; font-weight:800 }
		.user-meta { line-height:1.1 }
		.user-name { font-weight:700; font-size:13px; color:#0f172a }
		.user-role { font-size:11px; color:#64748b }

		/* Notification popup */
		.notif-wrap { position:relative }
		.notif-pop { position:absolute; right:0; top:44px; width:320px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); display:none; overflow:hidden; z-index:30 }
		.notif-pop.show { display:block }
		.notif-pop .menu-header { padding:12px 14px; font-weight:700; border-bottom:1px solid #f1f5f9 }
		.notifs { max-height:320px; overflow:auto }
		.notif-item { display:flex; gap:10px; padding:12px 14px; border-left:4px solid transparent; align-items:flex-start }
		.notif-item + .notif-item { border-top:1px solid #f8fafc }
		.notif-icon { width:28px; height:28px; border-radius:8px; display:grid; place-items:center; background:#f1f5f9 }
		.notif-title { font-size:13px; color:#0f172a; font-weight:600 }
		.notif-time { font-size:12px; color:#94a3b8; margin-top:2px }
		.notif-danger { border-left-color:#fecaca }
		.notif-warning { border-left-color:#fde68a }
		.notif-info { border-left-color:#bae6fd }
		.view-all { text-align:center; padding:10px; border-top:1px solid #f1f5f9; font-size:13px }
		.view-all a { color:#2563eb; text-decoration:none }
		.dashboard-content { padding:24px 30px }
		.metric-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:18px }
		.metric { background:#fff; border-radius:12px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,.08); position:relative; display:flex; flex-direction:column; gap:6px }
		.metric-title { color:#64748b; font-size:14px }
		.metric-value { font-size:28px; font-weight:800; color:#0f172a }
		.metric-sub { font-size:12px; color:#6b7280 }
		.metric-icon { position:absolute; right:14px; top:14px; width:34px; height:34px; border-radius:10px; display:grid; place-items:center; color:#fff }
		.icon-blue { background:#2563eb }
		.icon-green { background:#16a34a }
		.icon-orange { background:#f59e0b }
		.icon-purple { background:#8b5cf6 }

		.grid-2 { display:grid; grid-template-columns:2fr 1.2fr; gap:18px; margin-bottom:18px }
		.card { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.08); overflow:hidden }
		.card-header { padding:16px 20px; border-bottom:1px solid #ecf0f1; font-weight:700 }
		.card-content { padding:16px 20px }
		.chart-area { height:260px; position:relative; border-radius:10px; background:#ffffff; }
		.chart-area canvas{ position:absolute; inset:0; }
		.donut { width:240px; height:240px; margin:0 auto; }
		.legend { margin-top:12px; display:grid; gap:8px }
		.legend-item { display:flex; align-items:center; gap:8px; font-size:13px; color:#475569 }
		.legend-dot { width:10px; height:10px; border-radius:999px }

		.grid-2b { display:grid; grid-template-columns:1.4fr 1fr; gap:18px }
		.task { display:flex; align-items:flex-start; gap:12px; padding:12px 0; border-bottom:1px solid #f1f5f9 }
		.task:last-child { border-bottom:none }
		.task-icon { width:32px; height:32px; border-radius:10px; background:#eef2ff; display:grid; place-items:center }
		.task-title { font-weight:600; color:#0f172a }
		.task-meta { font-size:12px; color:#64748b; margin-top:2px }
		.sev { padding:2px 8px; border-radius:999px; font-size:11px; font-weight:700 }
		.sev-high { background:#fee2e2; color:#b91c1c }
		.sev-critical { background:#ffe4e6; color:#be123c }
		.sev-medium { background:#fef9c3; color:#a16207 }
		.appt { display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f1f5f9 }
		.appt:last-child { border-bottom:none }
		.appt-left { display:flex; align-items:center; gap:12px }
		.badge-time { background:#eef2ff; color:#1d4ed8; padding:4px 8px; border-radius:8px; font-weight:600; font-size:12px }
		.link { color:#2563eb; text-decoration:none; font-size:12px }

		/* Consultation specific styles */
		.consultation-section { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.08); overflow:hidden; margin-bottom:18px }
		.section-header { padding:16px 20px; border-bottom:1px solid #ecf0f1; display:flex; justify-content:space-between; align-items:center }
		.section-title { font-size:18px; font-weight:700; color:#2c3e50 }
		.filter-tabs { display:flex; gap:5px }
		.filter-tab { padding:8px 20px; border:none; background:#f7fafc; color:#64748b; border-radius:20px; cursor:pointer; font-size:14px; font-weight:500; transition:all 0.3s ease }
		.filter-tab.active { background:#2563eb; color:white }
		.new-consultation-btn { background:#2563eb; color:white; border:none; padding:10px 20px; border-radius:8px; font-size:14px; font-weight:600; cursor:pointer; transition:all 0.3s ease }
		.new-consultation-btn:hover { background:#1d4ed8; transform:translateY(-1px) }
		
		.consultation-list { padding:20px }
		.consultation-item { display:flex; align-items:center; padding:16px; border:1px solid #e2e8f0; border-radius:8px; margin-bottom:12px; background:#fafbfc }
		.patient-avatar { width:40px; height:40px; background:linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius:50%; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:14px; margin-right:16px }
		.consultation-details { flex:1 }
		.patient-name { font-size:15px; font-weight:600; color:#2c3e50; margin-bottom:4px }
		.patient-id { font-size:13px; color:#64748b; margin-bottom:6px }
		.consultation-type { color:#2563eb; font-weight:600; font-size:13px; margin-bottom:4px }
		.consultation-reason { color:#4a5568; font-size:13px }
		.consultation-status { margin-left:16px }
		.status-badge { background:#fef9c3; color:#a16207; padding:4px 12px; border-radius:16px; font-size:11px; font-weight:600; margin-bottom:8px; display:inline-block }
		.consultation-meta { text-align:right; margin-left:16px }
		.meta-item { font-size:11px; color:#64748b; margin-bottom:2px }
		.action-buttons { display:flex; gap:8px; margin-left:16px }
		.action-btn { width:32px; height:32px; border:none; border-radius:6px; cursor:pointer; font-size:14px; transition:all 0.3s ease }
		.action-btn.view { background:#dcfce7; color:#166534 }
		.action-btn.edit { background:#dbeafe; color:#1e40af }
		.action-btn.print { background:#f3e8ff; color:#7c3aed }

		/* Modal Styles */
		.modal { display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); overflow-y:auto }
		.modal.show { display:block }
		.modal-content { background-color:white; margin:2% auto; padding:0; border-radius:12px; width:90%; max-width:700px; max-height:90vh; box-shadow:0 4px 20px rgba(0,0,0,0.3); display:flex; flex-direction:column }
		.modal-header { padding:20px 25px; border-bottom:1px solid #e2e8f0; display:flex; justify-content:space-between; align-items:center }
		.modal-header h3 { font-size:18px; font-weight:600; color:#2c3e50; margin:0 }
		.close { color:#a0aec0; font-size:28px; font-weight:bold; cursor:pointer; line-height:1 }
		.close:hover { color:#2d3748 }
		.modal-body { padding:25px; flex:1; overflow-y:auto }
		.modal-footer { padding:20px 25px; border-top:1px solid #e2e8f0; display:flex; justify-content:flex-end; gap:12px }
		.form-group { margin-bottom:18px }
		.form-group label { display:block; margin-bottom:6px; font-weight:500; color:#2c3e50; font-size:13px }
		.form-group input, .form-group select, .form-group textarea { width:100%; padding:10px 12px; border:2px solid #e2e8f0; border-radius:6px; font-size:13px; transition:border-color 0.3s ease; background:#f7fafc }
		.form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline:none; border-color:#2563eb; background:white }
		.form-group textarea { resize:vertical; min-height:70px }
		.vital-signs-grid { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:8px }
		.vital-item label { font-size:11px; color:#64748b; margin-bottom:4px }
		.vital-item input { font-size:12px; padding:8px 10px }
		.btn { padding:10px 20px; border-radius:6px; text-decoration:none; font-size:13px; font-weight:600; cursor:pointer; border:none; transition:all 0.3s ease }
		.btn-primary { background:#2563eb; color:white }
		.btn-primary:hover { background:#1d4ed8 }
		.btn-secondary { background:#94a3b8; color:white }
		.btn-secondary:hover { background:#64748b }

		@media (max-width: 1200px){ .metric-grid{grid-template-columns:repeat(2,1fr)} .grid-2{grid-template-columns:1fr} .grid-2b{grid-template-columns:1fr} }

		/* Consultation item styles matching the image design */
		.consultation-item {
			display: flex;
			align-items: center;
			padding: 16px;
			border: 1px solid #e2e8f0;
			border-radius: 8px;
			margin-bottom: 12px;
			background: #fafbfc;
			transition: all 0.3s ease;
		}

		.consultation-item:hover {
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
			transform: translateY(-1px);
		}

		.appointment-item {
			border-left: 4px solid #10b981;
		}

		.patient-avatar {
			width: 40px;
			height: 40px;
			background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			color: white;
			font-weight: 700;
			font-size: 14px;
			margin-right: 16px;
			flex-shrink: 0;
		}

		.consultation-details {
			flex: 1;
			min-width: 0;
		}

		.patient-name {
			font-size: 15px;
			font-weight: 600;
			color: #2c3e50;
			margin-bottom: 4px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.patient-id {
			font-size: 13px;
			color: #64748b;
			margin-bottom: 6px;
		}

		.consultation-type {
			color: #2563eb;
			font-weight: 600;
			font-size: 13px;
			margin-bottom: 4px;
		}

		.consultation-reason {
			color: #4a5568;
			font-size: 13px;
			white-space: nowrap;
			overflow: hidden;
			text-overflow: ellipsis;
		}

		.consultation-status {
			margin-left: 16px;
			flex-shrink: 0;
		}

		.status-badge {
			background: #fef9c3;
			color: #a16207;
			padding: 4px 12px;
			border-radius: 16px;
			font-size: 11px;
			font-weight: 600;
			display: inline-block;
			white-space: nowrap;
		}

		.consultation-meta {
			text-align: right;
			margin-left: 16px;
			flex-shrink: 0;
			min-width: 80px;
		}

		.meta-item {
			font-size: 11px;
			color: #64748b;
			margin-bottom: 2px;
			white-space: nowrap;
		}

		.action-buttons {
			display: flex;
			gap: 8px;
			margin-left: 16px;
			flex-shrink: 0;
		}

		.action-btn {
			width: 32px;
			height: 32px;
			border: none;
			border-radius: 6px;
			cursor: pointer;
			font-size: 14px;
			transition: all 0.3s ease;
			display: flex;
			align-items: center;
			justify-content: center;
		}

		.action-btn.view { background: #dcfce7; color: #166534; }
		.action-btn.edit { background: #dbeafe; color: #1e40af; }
		.action-btn.print { background: #f3e8ff; color: #7c3aed; }
		.action-btn.start { background: #d1fae5; color: #065f46; }

		.action-btn:hover {
			opacity: 0.8;
			transform: translateY(-1px);
		}

		.section-subtitle {
			margin-bottom: 16px;
			color: #6b7280;
			font-size: 14px;
		}

		/* Responsive adjustments */
		@media (max-width: 768px) {
			.consultation-item {
				flex-direction: column;
				align-items: flex-start;
				gap: 12px;
			}
			
			.patient-avatar {
				margin-right: 0;
				margin-bottom: 8px;
			}
			
			.consultation-meta {
				text-align: left;
				margin-left: 0;
			}
			
			.action-buttons {
				margin-left: 0;
				width: 100%;
				justify-content: flex-end;
			}
		}
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<main class="main-content">
			<header class="header">
				<div class="header-left">
					<h1>Consultations</h1>
					<div class="subtext">Manage patient consultations and medical encounters</div>
				</div>
				<div class="actions">
					<div class="icon-btn notif-wrap">
						🔔
						<span class="badge">3</span>
						<div class="notif-pop">
							<div class="menu-header">Notifications</div>
							<div class="notifs">
								<div class="notif-item notif-danger">
									<div class="notif-icon">🚨</div>
									<div>
										<div class="notif-title">Emergency case admitted</div>
										<div class="notif-time">2 minutes ago</div>
									</div>
								</div>
								<div class="notif-item notif-warning">
									<div class="notif-icon">⚠️</div>
									<div>
										<div class="notif-title">Lab results ready</div>
										<div class="notif-time">15 minutes ago</div>
									</div>
								</div>
								<div class="notif-item notif-info">
									<div class="notif-icon">ℹ️</div>
									<div>
										<div class="notif-title">New appointment scheduled</div>
										<div class="notif-time">1 hour ago</div>
									</div>
								</div>
							</div>
							<div class="view-all">
								<a href="#">View all notifications</a>
							</div>
						</div>
					</div>
					<div class="icon-btn">🚨</div>
					<div class="user-chip">
						<div class="avatar">DR</div>
						<div class="user-meta">
							<div class="user-name"><?= session('user_name') ?? 'Doctor' ?></div>
							<div class="user-role"><?= session('specialty') ?? session('department') ?? 'Medical' ?></div>
						</div>
					</div>
				</div>
			</header>

			<div class="dashboard-content">
				<!-- KPI Cards -->
				<div class="metric-grid">
					<div class="metric">
						<div class="metric-title">Today's Consultations</div>
						<div class="metric-value"><?= isset($stats['completed']) ? $stats['completed'] : 0 ?></div>
						<div class="metric-sub"><?= isset($stats['completed']) && $stats['completed'] > 0 ? 'Scheduled today' : 'No consultations yet' ?></div>
						<div class="metric-icon icon-blue">🩺</div>
					</div>
					<div class="metric">
						<div class="metric-title">Average Duration</div>
						<div class="metric-value"><?= isset($stats['avg_duration']) ? $stats['avg_duration'] : '-' ?></div>
						<div class="metric-sub"><?= isset($stats['avg_duration']) && $stats['avg_duration'] > 0 ? 'minutes' : 'No data available' ?></div>
						<div class="metric-icon icon-green">⏰</div>
					</div>
					<div class="metric">
						<div class="metric-title">Follow-ups Scheduled</div>
						<div class="metric-value"><?= isset($stats['follow_ups']) ? $stats['follow_ups'] : 0 ?></div>
						<div class="metric-sub"><?= isset($stats['follow_ups']) && $stats['follow_ups'] > 0 ? 'This week' : 'No follow-ups yet' ?></div>
						<div class="metric-icon icon-purple">📅</div>
					</div>
				</div>

				<!-- Consultation Section -->
				<div class="consultation-section">
					<div class="section-header">
						<div class="section-title">Patient Consultations</div>
						<div style="display: flex; align-items: center; gap: 16px;">
							<div class="filter-tabs">
								<button class="filter-tab active">Active</button>
								<button class="filter-tab">Completed</button>
								<button class="filter-tab">All</button>
							</div>
							<button class="new-consultation-btn" onclick="openNewConsultationModal()">+ New Consultation</button>
						</div>
					</div>
					<div class="consultation-list">
						<?php if (!empty($consultations)): ?>
							<?php foreach ($consultations as $consultation): ?>
								<div class="consultation-item">
									<div class="patient-avatar">
										<?php 
										$patientName = $consultation['patient_name'] ?? 'Unknown';
										$initials = '';
										if ($patientName !== 'Unknown') {
											$nameParts = explode(' ', $patientName);
											$initials = strtoupper(substr($nameParts[0] ?? '', 0, 1) . substr($nameParts[1] ?? '', 0, 1));
										}
										echo $initials ?: 'UN';
										?>
									</div>
									<div class="consultation-details">
										<div class="patient-name"><?= htmlspecialchars($consultation['patient_name'] ?? 'Unknown Patient') ?></div>
										<div class="patient-id"><?= htmlspecialchars($consultation['patient_id_formatted'] ?? 'N/A') ?></div>
										<div class="consultation-type"><?= htmlspecialchars($consultation['consultation_type'] ?? 'Consultation') ?></div>
										<?php if (!empty($consultation['chief_complaint'])): ?>
											<div class="consultation-reason"><?= htmlspecialchars($consultation['chief_complaint']) ?></div>
										<?php endif; ?>
									</div>
									<div class="consultation-status">
										<span class="status-badge"><?= htmlspecialchars($consultation['status'] ?? 'Active') ?></span>
									</div>
									<div class="consultation-meta">
										<div class="meta-item"><?= date('Y-m-d', strtotime($consultation['date_time'])) ?></div>
										<div class="meta-item"><?= date('g:i A', strtotime($consultation['date_time'])) ?></div>
										<div class="meta-item"><?= ($consultation['duration'] ?? 30) ?> minutes</div>
									</div>
									<div class="action-buttons">
										<button class="action-btn view" onclick="viewConsultation(<?= $consultation['id'] ?>)" title="View">👁️</button>
										<button class="action-btn edit" onclick="editConsultation(<?= $consultation['id'] ?>)" title="Edit">✏️</button>
										<button class="action-btn print" onclick="printConsultation(<?= $consultation['id'] ?>)" title="Print">🖨️</button>
									</div>
								</div>
							<?php endforeach; ?>
						<?php elseif (!empty($upcomingAppointments)): ?>
							<!-- Show upcoming appointments that can be converted to consultations -->
							<div class="section-subtitle" style="margin-bottom: 16px; color: #6b7280; font-size: 14px;">
								Upcoming Appointments (Click to start consultation)
							</div>
							<?php foreach ($upcomingAppointments as $appointment): ?>
								<div class="consultation-item appointment-item">
									<div class="patient-avatar">
										<?php 
										$patientName = ($appointment['first_name'] ?? '') . ' ' . ($appointment['last_name'] ?? '');
										$initials = '';
										if (trim($patientName)) {
											$nameParts = explode(' ', trim($patientName));
											$initials = strtoupper(substr($nameParts[0] ?? '', 0, 1) . substr($nameParts[1] ?? '', 0, 1));
										}
										echo $initials ?: 'AP';
										?>
									</div>
									<div class="consultation-details">
										<div class="patient-name"><?= htmlspecialchars(trim($patientName) ?: 'Unknown Patient') ?></div>
										<div class="patient-id">Appointment</div>
										<div class="consultation-type">Scheduled</div>
										<div class="consultation-reason">Ready for consultation</div>
									</div>
									<div class="consultation-status">
										<span class="status-badge">Confirmed</span>
									</div>
									<div class="consultation-meta">
										<div class="meta-item"><?= date('Y-m-d', strtotime($appointment['date_time'])) ?></div>
										<div class="meta-item"><?= date('g:i A', strtotime($appointment['date_time'])) ?></div>
										<?php if (!empty($appointment['room'])): ?>
											<div class="meta-item">Room: <?= htmlspecialchars($appointment['room']) ?></div>
										<?php endif; ?>
									</div>
									<div class="action-buttons">
										<button class="action-btn start" onclick="startConsultationFromAppointment(<?= $appointment['id'] ?>, <?= $appointment['patient_id'] ?? 'null' ?>)" title="Start Consultation">▶️</button>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<!-- No consultations yet -->
							<div class="empty-state" style="text-align: center; padding: 40px; color: #6b7280;">
								<div style="font-size: 48px; margin-bottom: 16px;">📋</div>
								<div style="font-size: 18px; font-weight: 600; margin-bottom: 8px;">No consultations yet</div>
								<div style="font-size: 14px;">Click "+ New Consultation" to create your first consultation record</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</main>
	</div>

	<!-- Consultation Modal -->
	<div id="consultationModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<h3>New Consultation Record</h3>
				<span class="close" onclick="closeConsultationModal()">&times;</span>
			</div>
			<div class="modal-body">
				<form id="consultationForm">
					<div class="form-group">
						<label for="patientSelect">Patient</label>
						<select id="patientSelect" name="patient_id" required onchange="updatePatientId()">
							<option value="">Select a patient</option>
							<!-- Patients will be loaded dynamically from database -->
						</select>
					</div>
					
					<div class="form-group">
						<label for="patientId">Patient ID</label>
						<input type="text" id="patientId" name="patient_id_display" placeholder="Patient ID will be auto-filled" readonly>
					</div>
					
					<div class="form-group">
						<label for="consultationType">Consultation Type</label>
						<select id="consultationType" name="consultation_type" required>
							<option value="">Select type</option>
							<option value="Initial" selected>Initial Consultation</option>
							<option value="Follow-up">Follow-up</option>
							<option value="Emergency">Emergency</option>
							<option value="Routine">Routine Check-up</option>
						</select>
					</div>
					
					<div class="form-group">
						<label for="consultationDate">Date & Time</label>
						<input type="datetime-local" id="consultationDate" name="date_time" required>
					</div>
					
					<div class="form-group">
						<label>Vital Signs</label>
						<div class="vital-signs-grid">
							<div class="vital-item">
								<label for="bloodPressure">Blood Pressure</label>
								<input type="text" id="bloodPressure" name="blood_pressure" value="120/80" placeholder="120/80">
							</div>
							<div class="vital-item">
								<label for="heartRate">Heart Rate</label>
								<input type="text" id="heartRate" name="heart_rate" value="72 bpm" placeholder="72 bpm">
							</div>
							<div class="vital-item">
								<label for="temperature">Temperature</label>
								<input type="text" id="temperature" name="temperature" value="36.5°C" placeholder="36.5°C">
							</div>
							<div class="vital-item">
								<label for="weight">Weight</label>
								<input type="text" id="weight" name="weight" value="70 kg" placeholder="70 kg">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="chiefComplaint">Chief Complaint</label>
						<textarea id="chiefComplaint" name="chief_complaint" rows="3" placeholder="Patient's main complaint or reason for visit"></textarea>
					</div>
					
					<div class="form-group">
						<label for="historyIllness">History of Present Illness</label>
						<textarea id="historyIllness" name="history_illness" rows="3" placeholder="Detailed history of the present illness"></textarea>
					</div>
					
					<div class="form-group">
						<label for="physicalExam">Physical Examination</label>
						<textarea id="physicalExam" name="physical_exam" rows="3" placeholder="Physical examination findings"></textarea>
					</div>
					
					<div class="form-group">
						<label for="assessment">Assessment & Diagnosis</label>
						<textarea id="assessment" name="assessment" rows="3" placeholder="Assessment and diagnosis"></textarea>
					</div>
					
					<div class="form-group">
						<label for="treatmentPlan">Treatment Plan</label>
						<textarea id="treatmentPlan" name="treatment_plan" rows="3" placeholder="Treatment plan and recommendations"></textarea>
					</div>
					
					<div class="form-group">
						<label for="notes">Additional Notes</label>
						<textarea id="notes" name="notes" rows="2" placeholder="Any additional notes or observations"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" onclick="closeConsultationModal()">Cancel</button>
				<button type="button" class="btn btn-primary" onclick="saveNewConsultation()">Save Consultation</button>
			</div>
		</div>
	</div>

	<script>
		// Initialize when page loads
		document.addEventListener('DOMContentLoaded', function() {
			console.log('Page loaded!');
			
			// Set default consultation date to current date/time
			const now = new Date();
			const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
			const dateInput = document.getElementById('consultationDate');
			if (dateInput) {
				dateInput.value = localDateTime;
			}
		});
		
		// Function to update patient ID when patient is selected
		function updatePatientId() {
			const patientSelect = document.getElementById('patientSelect');
			const patientIdInput = document.getElementById('patientId');
			
			if (patientSelect.value) {
				patientIdInput.value = patientSelect.value;
			} else {
				patientIdInput.value = '';
			}
		}

		// Modal functions
		async function openNewConsultationModal() {
			console.log('Opening consultation modal...');
			const modal = document.getElementById('consultationModal');
			if (modal) {
				modal.classList.add('show');
				modal.style.display = 'block';
				console.log('Modal opened successfully');
				
				// Set default consultation date to current date/time
				const now = new Date();
				const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
				const dateInput = document.getElementById('consultationDate');
				if (dateInput) {
					dateInput.value = localDateTime;
				}
				
				// Load patients from database
				await loadPatientsForConsultation();
			} else {
				console.error('Modal element not found!');
			}
		}
		
		// Load patients from database for consultation modal
		async function loadPatientsForConsultation() {
			try {
				console.log('🔄 Loading patients for consultation...');
				
				const response = await fetch('<?= base_url('schedule/getPatients') ?>', {
					method: 'POST',
					headers: { 
						'X-Requested-With': 'XMLHttpRequest',
						'Content-Type': 'application/x-www-form-urlencoded'
					},
					body: 'ajax=1'
				});
				
				if (!response.ok) {
					throw new Error(`HTTP error! status: ${response.status}`);
				}
				
				const data = await response.json();
				console.log('📥 Patient data received:', data);
				
				if (data.success && data.patients && data.patients.length > 0) {
					const patientSelect = document.getElementById('patientSelect');
					
					// Clear existing options except the first one
					patientSelect.innerHTML = '<option value="">Select a patient</option>';
					
					// Add real patients from database
					data.patients.forEach(patient => {
						const option = document.createElement('option');
						const patientName = (patient.first_name || '') + ' ' + (patient.last_name || '');
						option.value = patient.id;
						option.textContent = patientName.trim();
						option.dataset.patientName = patientName.trim();
						patientSelect.appendChild(option);
						console.log('✅ Added patient:', patientName.trim(), 'ID:', patient.id);
					});
					
					console.log('✅ Real patients loaded into consultation modal');
				} else {
					console.log('⚠️ No patients found in database');
				}
			} catch (error) {
				console.error('💥 Error loading patients for consultation:', error);
			}
		}

		function closeConsultationModal() {
			const modal = document.getElementById('consultationModal');
			if (modal) {
				modal.classList.remove('show');
				modal.style.display = 'none';
			}
			
			document.getElementById('consultationForm').reset();
			
			// Reset consultation date to current time
			const now = new Date();
			const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
			const dateInput = document.getElementById('consultationDate');
			if (dateInput) {
				dateInput.value = localDateTime;
			}
			
			// Reset patient ID field
			const patientIdInput = document.getElementById('patientId');
			if (patientIdInput) {
				patientIdInput.value = '';
			}
			
			// Reset vital signs to default values
			const bloodPressureInput = document.getElementById('bloodPressure');
			const heartRateInput = document.getElementById('heartRate');
			const temperatureInput = document.getElementById('temperature');
			const weightInput = document.getElementById('weight');
			
			if (bloodPressureInput) bloodPressureInput.value = '120/80';
			if (heartRateInput) heartRateInput.value = '72 bpm';
			if (temperatureInput) temperatureInput.value = '36.5°C';
			if (weightInput) weightInput.value = '70 kg';
		}

		function saveNewConsultation() {
			const form = document.getElementById('consultationForm');
			const formData = new FormData(form);
			
			// Validate required fields
			if (!formData.get('patient_id') || !formData.get('consultation_type') || !formData.get('date_time')) {
				alert('Please fill in all required fields');
				return;
			}
			
			// Add doctor_id to form data
			formData.append('doctor_id', '<?= session('user_id') ?>');
			
			// Debug: Log what we're sending
			console.log('Sending consultation data:');
			for (let [key, value] of formData.entries()) {
				console.log(key + ': ' + value);
			}
			
			// Submit consultation data to the save endpoint
			const url = '<?= site_url('doctor/consultations/save') ?>?t=' + Date.now();
			console.log('Sending to URL:', url);
			
			fetch(url, {
				method: 'POST',
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: formData
			})
			.then(response => {
				console.log('Response status:', response.status);
				return response.json();
			})
			.then(data => {
				console.log('Response data:', data);
				if (data.success) {
					alert('Consultation created successfully!');
					closeConsultationModal();
					// Refresh the consultation list instead of reloading the page
					refreshConsultationList();
				} else {
					alert('Error: ' + (data.message || 'Failed to create consultation'));
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error creating consultation. Please try again.');
			});
		}

		// Function to refresh the consultation list
		function refreshConsultationList() {
			// Reload the page to get fresh data
			location.reload();
		}

		// Function to start consultation from appointment
		function startConsultationFromAppointment(appointmentId, patientId) {
			if (!patientId) {
				alert('Patient ID not found for this appointment. Please create a new consultation instead.');
				return;
			}
			
			// Open the consultation modal and pre-fill with appointment data
			openNewConsultationModal();
			
			// Set the patient ID
			const patientSelect = document.getElementById('patientSelect');
			if (patientSelect) {
				patientSelect.value = patientId;
				updatePatientId();
			}
			
			// Set consultation type to "Initial"
			const consultationType = document.getElementById('consultationType');
			if (consultationType) {
				consultationType.value = 'Initial';
			}
		}

		// Function to update patient ID field when patient is selected
		function updatePatientId() {
			const patientSelect = document.getElementById('patientSelect');
			const patientIdField = document.getElementById('patientId');
			
			if (patientSelect && patientIdField) {
				const selectedOption = patientSelect.options[patientSelect.selectedIndex];
				if (selectedOption && selectedOption.value) {
					patientIdField.value = 'P-' + selectedOption.value;
				} else {
					patientIdField.value = '';
				}
			}
		}

		// Close modal when clicking outside
		window.onclick = function(event) {
			const modal = document.getElementById('consultationModal');
			if (event.target === modal) {
				closeConsultationModal();
			}
		}

		function viewConsultation(id) {
			alert('View Consultation ' + id + ' - To be implemented');
		}

		function editConsultation(id) {
			alert('Edit Consultation ' + id + ' - To be implemented');
		}
		
		function printConsultation(id) {
			alert('Print Consultation ' + id + ' - To be implemented');
		}
	</script>
</body>
</html>
