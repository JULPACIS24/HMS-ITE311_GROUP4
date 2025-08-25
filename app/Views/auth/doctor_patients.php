<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • Patient Records</title>
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

		.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin:18px 24px}
		.kpi{background:#fff;border-radius:12px;padding:18px;box-shadow:0 2px 10px rgba(0,0,0,.08);position:relative}
		.kpi-title{color:#64748b;font-size:14px}
		.kpi-value{font-size:28px;font-weight:800;color:#0f172a}
		.kpi-sub{font-size:12px;color:#16a34a;margin-top:6px}
		.kpi-icon{position:absolute;right:14px;top:14px;width:34px;height:34px;border-radius:10px;display:grid;place-items:center;color:#fff}
		.i-blue{background:#2563eb}.i-green{background:#10b981}.i-red{background:#ef4444}.i-purple{background:#8b5cf6}

		.card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);margin:0 24px 24px 24px;overflow:hidden}
		.card-header{padding:16px 20px;border-bottom:1px solid #ecf0f1;font-weight:700}
		.table{width:100%;border-collapse:collapse}
		.table th,.table td{padding:14px 16px;border-bottom:1px solid #f1f5f9;text-align:left;font-size:14px}
		.status{padding:4px 8px;border-radius:999px;font-size:12px;font-weight:700}
		.s-active{background:#e7f5ef;color:#16a34a}
		.s-critical{background:#fee2e2;color:#b91c1c}
		.s-stable{background:#eff6ff;color:#2563eb}
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<div class="main">
			<div class="header">
				<div class="header-left">
					<h1>Patient Records</h1>
					<div class="sub">Manage and view all patient information and medical history</div>
				</div>
				<div class="actions">
					<div class="notif-wrap" style="position:relative">
						<button class="icon-btn" aria-label="Notifications" id="notifBtn">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5l-2 2v1h16v-1l-2-2Z" stroke="#475569" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="badge">3</span>
						</button>
						<div class="notif-pop" id="notifPop" style="display:none; position:absolute; right:0; top:44px; width:320px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); overflow:hidden; z-index:30;">
							<div class="menu-header" style="padding:12px 14px; font-weight:700; border-bottom:1px solid #f1f5f9">Notifications</div>
							<div class="notifs" style="max-height:320px; overflow:auto">
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fecaca; align-items:flex-start; background:#fff7f7"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff0f0">🧪</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">Lab results ready for Patient #1234</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">5 min ago</div></div></div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fde68a; align-items:flex-start"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff7e6">📅</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">New appointment scheduled for 2:00 PM</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">10 min ago</div></div></div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fecaca; align-items:flex-start; background:#fff7f7"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff0f0">💊</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">Prescription approval needed</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">15 min ago</div></div></div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #bae6fd; align-items:flex-start"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#ebf8ff">🔔</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">System maintenance scheduled for tonight</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">1 hour ago</div></div></div>
							</div>
							<div style="text-align:center;padding:10px;border-top:1px solid #f1f5f9;font-size:13px"><a href="#" style="color:#2563eb;text-decoration:none">View All Notifications</a></div>
						</div>
					</div>
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" id="userBtn" style="cursor:pointer">
							<div class="avatar">DR</div>
							<div class="user-meta">
								<div class="user-name"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></div>
								<div class="user-role"><?= session('specialty') ?? session('department') ?? 'Medical' ?></div>
							</div>
						</div>
						<div class="user-pop" id="userPop" style="display:none; position:absolute; right:0; top:44px; width:260px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); overflow:hidden; z-index:30;">
							<div style="display:flex; gap:10px; padding:12px 14px; border-bottom:1px solid #f1f5f9"><div style="width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#6366f1;color:#fff;font-weight:800">DR</div><div><div style="font-weight:700"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></div><div style="color:#64748b;font-size:12px"><?= session('specialty') ?? session('department') ?? 'Medical' ?> Department</div><div style="color:#94a3b8;font-size:12px">ID: <?= session('user_id') ?? 'DOC-2024-001' ?></div></div></div>
							<div style="padding:6px 0"><a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">👤 My Profile</a><a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">⚙️ Settings</a><a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">🕒 Work Schedule</a></div>
							<div style="border-top:1px solid #f1f5f9"></div>
							<div style="padding:6px 0"><a href="<?= site_url('logout') ?>" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#ef4444;font-size:14px">🚪 Sign Out</a></div>
						</div>
					</div>
				</div>
			</div>

			<!-- KPIs -->
			<div class="kpi-grid">
				<div class="kpi"><div class="kpi-title">Total Patients</div><div class="kpi-value"><?= $stats['total_patients'] ?? 0 ?></div><div class="kpi-sub">+12 this week</div><div class="kpi-icon i-blue">👥</div></div>
				<div class="kpi"><div class="kpi-title">Active Cases</div><div class="kpi-value"><?= $stats['active_cases'] ?? 0 ?></div><div class="kpi-sub" style="color:#64748b">Currently admitted</div><div class="kpi-icon i-green">📈</div></div>
				<div class="kpi"><div class="kpi-title">Critical Patients</div><div class="kpi-value"><?= $stats['critical_patients'] ?? 0 ?></div><div class="kpi-sub" style="color:#ef4444">Require attention</div><div class="kpi-icon i-red">⏰</div></div>
				<div class="kpi"><div class="kpi-title">Discharged Today</div><div class="kpi-value"><?= $stats['discharged_today'] ?? 0 ?></div><div class="kpi-sub" style="color:#64748b">Recovery completed</div><div class="kpi-icon i-purple">✅</div></div>
			</div>

			<!-- Controls Row (moved below KPIs) -->
			<div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin:14px 24px 0 24px;flex-wrap:wrap">
				<div></div>
				<button style="background:#2563eb;color:#fff;border:none;border-radius:10px;padding:10px 14px;font-weight:700;">+ Add New Patient</button>
			</div>
			<div style="display:flex;justify-content:space-between;align-items:center;gap:12px;margin:10px 24px 18px 24px;flex-wrap:wrap">
				<input type="text" placeholder="Search by name or patient ID..." style="flex:1;min-width:240px;height:40px;border:1px solid #e5e7eb;border-radius:10px;padding:0 12px;">
				<select style="height:40px;border:1px solid #e5e7eb;border-radius:10px;padding:0 10px;min-width:140px;">
					<option>All Status</option>
					<option>Active</option>
					<option>Critical</option>
					<option>Stable</option>
				</select>
			</div>

			<!-- Patient table -->
			<div class="card">
				<div class="card-header">Patient Records</div>
				<div class="card-body">
					<table class="table">
						<thead>
							<tr>
								<th>Patient ID</th>
								<th>Name</th>
								<th>Age/Gender</th>
								<th>Contact</th>
								<th>Blood Type</th>
								<th>Emergency Contact</th>
								<th>Last Updated</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php if (!empty($patients)): ?>
								<?php foreach ($patients as $patient): ?>
									<tr>
										<td>P-<?= str_pad($patient['id'], 3, '0', STR_PAD_LEFT) ?></td>
										<td><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></td>
										<td><?= $patient['age'] ?? 'N/A' ?> / <?= esc($patient['gender']) ?></td>
										<td><?= esc($patient['phone']) ?></td>
										<td><?= esc($patient['blood_type'] ?? 'N/A') ?></td>
										<td><?= esc($patient['emergency_name'] ?? 'N/A') ?></td>
										<td><?= date('Y-m-d', strtotime($patient['updated_at'] ?? $patient['created_at'])) ?></td>
										<td>
											<a href="<?= site_url('doctor/patients/view/' . $patient['id']) ?>" style="text-decoration:none;color:#2563eb;margin-right:8px;">👁️</a>
											<a href="<?= site_url('doctor/patients/edit/' . $patient['id']) ?>" style="text-decoration:none;color:#10b981;">✎</a>
										</td>
									</tr>
								<?php endforeach; ?>
							<?php else: ?>
								<tr>
									<td colspan="8" style="text-align:center;padding:40px;color:#64748b;">
										<div style="font-size:16px;margin-bottom:8px;">👥</div>
										<div>No patients found</div>
										<div style="font-size:12px;margin-top:4px;">Add your first patient to get started</div>
									</td>
								</tr>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

	<script>
	(function(){
		const nbtn = document.getElementById('notifBtn');
		const npop = document.getElementById('notifPop');
		function hideN(){ if(npop) npop.style.display='none'; }
		if(nbtn && npop){
			nbtn.addEventListener('click', (e)=>{ e.stopPropagation(); npop.style.display = (npop.style.display==='none'||npop.style.display==='')?'block':'none'; });
			document.addEventListener('click', ()=> hideN());
		}
		const ubtn = document.getElementById('userBtn');
		const upop = document.getElementById('userPop');
		function hideU(){ if(upop) upop.style.display='none'; }
		if(ubtn && upop){
			ubtn.addEventListener('click', (e)=>{ e.stopPropagation(); upop.style.display = (upop.style.display==='none'||upop.style.display==='')?'block':'none'; });
			document.addEventListener('click', ()=> hideU());
		}
	})();
	</script>
</body>
</html>


