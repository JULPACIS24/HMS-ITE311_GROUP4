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
		@media (max-width: 1200px){ .metric-grid{grid-template-columns:repeat(2,1fr)} .grid-2{grid-template-columns:1fr} .grid-2b{grid-template-columns:1fr} }
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<main class="main-content">
			<header class="header">
				<div class="header-left">
					<h1>Dashboard</h1>
					<span class="subtext">Welcome back, Dr. Santos. Here's your overview for today.</span>
				</div>
				<div class="actions">
					<div class="notif-wrap">
						<button class="icon-btn" aria-label="Notifications" id="notifBtn">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5l-2 2v1h16v-1l-2-2Z" stroke="#475569" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="badge">3</span>
						</button>
						<div class="notif-pop" id="notifPop" style="display:none; position:absolute; right:0; top:44px; width:320px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); overflow:hidden; z-index:30;">
							<div class="menu-header" style="padding:12px 14px; font-weight:700; border-bottom:1px solid #f1f5f9">Notifications</div>
							<div class="notifs" style="max-height:320px; overflow:auto">
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fecaca; align-items:flex-start; background:#fff7f7">
									<div class="notif-icon" style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff0f0">🧪</div>
									<div><div class="notif-title" style="font-size:13px;color:#0f172a;font-weight:600">Lab results ready for Patient #1234</div><div class="notif-time" style="font-size:12px;color:#94a3b8;margin-top:2px">5 min ago</div></div>
								</div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fde68a; align-items:flex-start">
									<div class="notif-icon" style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff7e6">📅</div>
									<div><div class="notif-title" style="font-size:13px;color:#0f172a;font-weight:600">New appointment scheduled for 2:00 PM</div><div class="notif-time" style="font-size:12px;color:#94a3b8;margin-top:2px">10 min ago</div></div>
								</div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fecaca; align-items:flex-start; background:#fff7f7">
									<div class="notif-icon" style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff0f0">💊</div>
									<div><div class="notif-title" style="font-size:13px;color:#0f172a;font-weight:600">Prescription approval needed</div><div class="notif-time" style="font-size:12px;color:#94a3b8;margin-top:2px">15 min ago</div></div>
								</div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #bae6fd; align-items:flex-start">
									<div class="notif-icon" style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#ebf8ff">🔔</div>
									<div><div class="notif-title" style="font-size:13px;color:#0f172a;font-weight:600">System maintenance scheduled for tonight</div><div class="notif-time" style="font-size:12px;color:#94a3b8;margin-top:2px">1 hour ago</div></div>
								</div>
							</div>
							<div class="view-all" style="text-align:center;padding:10px;border-top:1px solid #f1f5f9;font-size:13px"><a href="#" style="color:#2563eb;text-decoration:none">View All Notifications</a></div>
						</div>
					</div>
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" id="userBtn" style="cursor:pointer">
							<div class="avatar">DR</div>
							<div class="user-meta">
								<div class="user-name">Dr. Maria Santos</div>
								<div class="user-role">Cardiology</div>
							</div>
						</div>
						<div class="user-pop" id="userPop" style="display:none; position:absolute; right:0; top:44px; width:260px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); overflow:hidden; z-index:30;">
							<div style="display:flex; gap:10px; padding:12px 14px; border-bottom:1px solid #f1f5f9">
								<div class="big" style="width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#6366f1;color:#fff;font-weight:800">DR</div>
								<div><div style="font-weight:700">Dr. Maria Santos</div><div style="color:#64748b;font-size:12px">Cardiology Department</div><div style="color:#94a3b8;font-size:12px">ID: DOC-2024-001</div></div>
							</div>
							<div class="menu-list" style="padding:6px 0">
								<a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">👤 My Profile</a>
								<a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">⚙️ Settings</a>
								<a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">🕒 Work Schedule</a>
							</div>
							<div style="border-top:1px solid #f1f5f9"></div>
							<div class="menu-list" style="padding:6px 0">
								<a href="<?= site_url('logout') ?>" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#ef4444;font-size:14px">🚪 Sign Out</a>
							</div>
						</div>
					</div>
				</div>
			</header>

			<div class="dashboard-content">
				<!-- top subtext already shown in header -->

				<!-- KPI Metrics -->
				<div class="metric-grid">
					<div class="metric">
						<div class="metric-title">Today's Appointments</div>
						<div class="metric-value">12</div>
						<div class="metric-sub">+2 from yesterday</div>
						<div class="metric-icon icon-blue">📅</div>
					</div>
					<div class="metric">
						<div class="metric-title">Active Patients</div>
						<div class="metric-value">248</div>
						<div class="metric-sub">Under your care</div>
						<div class="metric-icon icon-green">🧑‍⚕️</div>
					</div>
					<div class="metric">
						<div class="metric-title">Pending Lab Results</div>
						<div class="metric-value">6</div>
						<div class="metric-sub">Awaiting review</div>
						<div class="metric-icon icon-orange">🧪</div>
					</div>
					<div class="metric">
						<div class="metric-title">Prescriptions</div>
						<div class="metric-value">18</div>
						<div class="metric-sub">This week</div>
						<div class="metric-icon icon-purple">💊</div>
					</div>
				</div>

				<!-- Charts Row -->
				<div class="grid-2">
					<div class="card">
						<div class="card-header">Weekly Consultation Trends</div>
						<div class="card-content">
							<div class="chart-area"><canvas id="consultationChart"></canvas></div>
						</div>
					</div>
					<div class="card">
						<div class="card-header">Patient Conditions Distribution</div>
						<div class="card-content" style="display:grid; justify-items:center">
							<div class="donut"><canvas id="conditionsChart"></canvas></div>
							<div class="legend">
								<div class="legend-item"><span class="legend-dot" style="background:#3b82f6"></span>Hypertension <span style="margin-left:6px;color:#94a3b8">35%</span></div>
								<div class="legend-item"><span class="legend-dot" style="background:#10b981"></span>Diabetes <span style="margin-left:6px;color:#94a3b8">28%</span></div>
								<div class="legend-item"><span class="legend-dot" style="background:#f59e0b"></span>Heart Disease <span style="margin-left:6px;color:#94a3b8">20%</span></div>
								<div class="legend-item"><span class="legend-dot" style="background:#8b5cf6"></span>Others <span style="margin-left:6px;color:#94a3b8">17%</span></div>
							</div>
						</div>
					</div>
				</div>

				<!-- Bottom Row: Urgent Tasks and Today's Appointments -->
				<div class="grid-2b">
					<div class="card">
						<div class="card-header" style="display:flex;justify-content:space-between;align-items:center">Urgent Tasks <a class="link" href="#">View All</a></div>
						<div class="card-content">
							<div class="task"><div class="task-icon">🧪</div><div style="flex:1"><div class="task-title">John Rodriguez</div><div class="task-meta">Review cardiac enzyme results • 2 hours ago</div></div><span class="sev sev-high">HIGH</span></div>
							<div class="task"><div class="task-icon">💊</div><div style="flex:1"><div class="task-title">Maria Garcia</div><div class="task-meta">Update medication dosage • 1 hour ago</div></div><span class="sev sev-high">HIGH</span></div>
							<div class="task"><div class="task-icon">⚠️</div><div style="flex:1"><div class="task-title">Carlos Martinez</div><div class="task-meta">Emergency consultation request • 30 min ago</div></div><span class="sev sev-critical">CRITICAL</span></div>
							<div class="task"><div class="task-icon">📍</div><div style="flex:1"><div class="task-title">Ana Dela Cruz</div><div class="task-meta">Post-surgery checkup • 45 min ago</div></div><span class="sev sev-medium">MEDIUM</span></div>
						</div>
					</div>
					<div class="card">
						<div class="card-header" style="display:flex;justify-content:space-between;align-items:center">Today's Appointments <a class="link" href="#">Manage Schedule</a></div>
						<div class="card-content">
							<div class="appt"><div class="appt-left"><div class="task-icon" style="background:#eef2ff">RS</div><div><div class="task-title">Robert Santos</div><div class="task-meta">Routine Checkup • Room 201</div></div></div><div class="badge-time">9:00 AM</div></div>
							<div class="appt"><div class="appt-left"><div class="task-icon" style="background:#f5f3ff">LF</div><div><div class="task-title">Lisa Fernandez</div><div class="task-meta">Follow-up • Room 203</div></div></div><div class="badge-time">10:30 AM</div></div>
							<div class="appt"><div class="appt-left"><div class="task-icon" style="background:#fff7ed">MT</div><div><div class="task-title">Michael Torres</div><div class="task-meta">Consultation • Room 201</div></div></div><div class="badge-time">11:15 AM</div></div>
							<div class="appt"><div class="appt-left"><div class="task-icon" style="background:#e0f7ef">SR</div><div><div class="task-title">Sarah Reyes</div><div class="task-meta">Emergency • Emergency Room</div></div></div><div class="badge-time">2:00 PM</div></div>
							<div class="appt"><div class="appt-left"><div class="task-icon" style="background:#ecfeff">DC</div><div><div class="task-title">David Cruz</div><div class="task-meta">Routine Checkup • Room 205</div></div></div><div class="badge-time">3:30 PM</div></div>
						</div>
					</div>
				</div>
			</div>
			</div>
		</main>
	</div>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
    (function(){
        // Toggle notif popup
        const nbtn = document.getElementById('notifBtn');
        const npop = document.getElementById('notifPop');
        function hideNotif(){ if(npop) npop.style.display='none'; }
        if (nbtn && npop){
            nbtn.addEventListener('click', (e)=>{
                e.stopPropagation();
                npop.style.display = (npop.style.display==='none' || npop.style.display==='') ? 'block' : 'none';
            });
            document.addEventListener('click', ()=> hideNotif());
        }
        // Toggle user pop
        const ubtn = document.getElementById('userBtn');
        const upop = document.getElementById('userPop');
        function hideUser(){ if(upop) upop.style.display='none'; }
        if (ubtn && upop){
            ubtn.addEventListener('click', (e)=>{
                e.stopPropagation();
                upop.style.display = (upop.style.display==='none' || upop.style.display==='') ? 'block' : 'none';
            });
            document.addEventListener('click', ()=> hideUser());
        }

        const ctx1 = document.getElementById('consultationChart');
        if (ctx1 && window.Chart) {
            new Chart(ctx1, {
                type: 'line',
                data: {
                    labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
                    datasets: [
                        { label: 'New Consultations', data: [10,14,18,15,22,16,8], fill: true, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,.25)', tension: .35 },
                        { label: 'Follow-ups', data: [6,6,9,9,10,7,3], fill: true, borderColor: '#10b981', backgroundColor: 'rgba(16,185,129,.25)', tension: .35 }
                    ]
                },
                options: { plugins:{legend:{position:'top'}}, maintainAspectRatio:false, scales:{ y:{ beginAtZero:true } } }
            });
        }

        const ctx2 = document.getElementById('conditionsChart');
        if (ctx2 && window.Chart) {
            new Chart(ctx2, {
                type: 'doughnut',
                data: { labels:['Hypertension','Diabetes','Heart Disease','Others'], datasets:[{ data:[35,28,20,17], backgroundColor:['#3b82f6','#10b981','#f59e0b','#8b5cf6'], borderWidth:0 }] },
                options: { cutout:'60%', plugins:{legend:{display:false}}, maintainAspectRatio:false }
            });
        }
    })();
    </script>
</body>
</html>



