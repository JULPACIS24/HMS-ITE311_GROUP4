<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Admin Dashboard</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css">
    <style>
		* { margin:0; padding:0; box-sizing:border-box }
		body { font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; background:#f5f7fa }
		.container { display:flex; min-height:100vh }

		/* Sidebar (kept) */
		.sidebar { width:250px; background:linear-gradient(180deg,#2c3e50 0%, #34495e 100%); color:#fff; position:fixed; height:100vh; overflow-y:auto; z-index:1000 }
		.sidebar-header { padding:20px; border-bottom:1px solid #34495e; display:flex; align-items:center; gap:12px }
		.admin-icon { width:32px; height:32px; background:#3498db; border-radius:6px; display:grid; place-items:center; font-weight:700; font-size:14px }
		.sidebar-title { font-size:18px; font-weight:700 }
		.sidebar-menu { padding:20px 0 }
		.menu-item { display:flex; align-items:center; gap:12px; padding:12px 20px; color:#cbd5e1; text-decoration:none; border-left:3px solid transparent }
		.menu-item:hover { background:rgba(255,255,255,.1); color:#fff; border-left-color:#3498db }
		.menu-item.active { background:rgba(52,152,219,.2); color:#fff; border-left-color:#3498db }
		.menu-icon { width:20px; text-align:center }

		/* Main area */
		.main-content { flex:1; margin-left:250px }
		.topbar { background:#fff; padding:16px 22px; box-shadow:0 2px 4px rgba(0,0,0,.08); display:flex; align-items:center; justify-content:space-between }
		.top-left { display:flex; flex-direction:column }
		.top-title { font-size:20px; color:#0f172a; font-weight:800 }
		.top-sub { color:#64748b; font-size:12px; margin-top:2px }
		.top-actions { display:flex; align-items:center; gap:16px }
		.icon-btn { position:relative; width:36px; height:36px; border-radius:12px; background:#f8fafc; display:grid; place-items:center; border:1px solid #e5e7eb; cursor:pointer }
		.badge { position:absolute; top:-4px; right:-4px; background:#ef4444; color:#fff; border-radius:999px; font-size:10px; padding:2px 6px; font-weight:800 }
		.user-chip { display:flex; align-items:center; gap:10px; cursor:pointer }
		.avatar { width:36px; height:36px; border-radius:50%; background:#6366f1; color:#fff; display:grid; place-items:center; font-weight:800 }
		.user-meta { line-height:1.1 }
		.user-name { font-weight:700; font-size:13px; color:#0f172a }
		.user-role { font-size:12px; color:#64748b }

		/* Popovers */
		.pop { position:absolute; right:0; top:46px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); display:none; overflow:hidden; z-index:30 }
		.pop.show { display:block }
		.notif-pop { width:320px }
		.user-pop { width:260px }
		.pop-header { padding:12px 14px; font-weight:800; border-bottom:1px solid #f1f5f9 }
		.notif-item { display:flex; gap:10px; padding:12px 14px; border-left:4px solid transparent; align-items:flex-start }
		.notif-item + .notif-item { border-top:1px solid #f8fafc }
		.notif-icon { width:28px; height:28px; border-radius:8px; display:grid; place-items:center; background:#f1f5f9 }
		.notif-title { font-size:13px; color:#0f172a; font-weight:600 }
		.notif-time { font-size:12px; color:#94a3b8; margin-top:2px }
		.notif-success { border-left-color:#bbf7d0 }
		.notif-warning { border-left-color:#fde68a }
		.notif-info { border-left-color:#bae6fd }
		.view-all { text-align:center; padding:10px; border-top:1px solid #f1f5f9; font-size:13px }
		.view-all a { color:#2563eb; text-decoration:none }
		.menu-link { display:block; padding:10px 14px; text-decoration:none; color:#0f172a; font-size:14px }
		.menu-link:hover { background:#f8fafc }

		/* Page content */
		.page { padding:24px 26px }
		.kpi-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:18px }
		.kpi { background:#fff; border-radius:12px; padding:18px; box-shadow:0 2px 10px rgba(0,0,0,.08); position:relative }
		.kpi-title { color:#64748b; font-size:13px; font-weight:600 }
		.kpi-value { font-size:28px; font-weight:800; color:#0f172a; margin-top:6px }
		.kpi-sub { display:flex; align-items:center; gap:6px; color:#16a34a; font-size:12px; margin-top:6px }
		.kpi-icon { position:absolute; right:14px; top:14px; width:34px; height:34px; border-radius:10px; display:grid; place-items:center; background:#f1f5f9 }

		.grid-2 { display:grid; grid-template-columns:2fr 1.1fr; gap:18px }
		.card { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.08); overflow:hidden }
		.card-header { padding:16px 20px; border-bottom:1px solid #ecf0f1; font-weight:800; color:#0f172a; display:flex; align-items:center; justify-content:space-between }
		.card-content { padding:16px 20px }
		.select { border:1px solid #e5e7eb; border-radius:8px; padding:6px 10px; font-size:12px; color:#475569; background:#fff }

		.activities { display:grid; gap:14px }
		.act { display:flex; align-items:center; gap:12px }
		.dot { width:10px; height:10px; border-radius:999px }
		.dot-blue { background:#3b82f6 }
		.dot-red { background:#ef4444 }
		.dot-green { background:#22c55e }
		.dot-amber { background:#f59e0b }
		.act-title { font-size:13px; color:#0f172a; font-weight:600 }
		.act-time { font-size:12px; color:#94a3b8 }

		@media (max-width: 1100px){ .kpi-grid{grid-template-columns:repeat(2,1fr)} .grid-2{grid-template-columns:1fr} }
	</style>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script>
		function togglePop(id){
			const el = document.getElementById(id);
			el.classList.toggle('show');
		}
		function closeAllPops(){
			document.querySelectorAll('.pop').forEach(p=>p.classList.remove('show'));
		}
		document.addEventListener('click', (e)=>{
			const wrap = document.getElementById('topActions');
			if (!wrap.contains(e.target)) closeAllPops();
		});
		document.addEventListener('keydown', (e)=>{ if(e.key==='Escape') closeAllPops(); });
		window.addEventListener('DOMContentLoaded', ()=>{
			// active menu highlight
			const path = window.location.pathname;
			document.querySelectorAll('.menu-item').forEach(a=>{
				if (a.getAttribute('href') && path.endsWith(a.getAttribute('href'))) a.classList.add('active');
			});
			// chart
			const ctx = document.getElementById('patientsChart');
			if (ctx){
				new Chart(ctx, {
					type: 'line',
					data: { labels: ['Jan','Feb','Mar','Apr','May','Jun'], datasets:[{ label:'Patients', data:[1200,1350,1380,1340,1480,1600], borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,.08)', tension:.4, fill:true, pointRadius:3 }] },
					options: { scales:{ y:{ grid:{ color:'#f1f5f9' } }, x:{ grid:{ display:false } } }, plugins:{ legend:{ display:false } }, responsive:true, maintainAspectRatio:false }
				});
			}
		});
	</script>
</head>
<body>
    <div class="container">
		<?php echo view('auth/partials/sidebar'); ?>

        <main class="main-content">
			<!-- Top bar with notifications and user pop -->
			<header class="topbar">
				<div class="top-left">
					<div class="top-title">Dashboard</div>
					<div class="top-sub">Welcome back, Dr. Maria Santos</div>
                </div>
				<div class="top-actions" id="topActions">
					<div class="notif-wrap" style="position:relative">
						<button class="icon-btn" aria-label="Notifications" onclick="togglePop('notifPop')">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5l-2 2v1h16v-1l-2-2Z" stroke="#475569" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="badge">5</span>
						</button>
						<div class="pop notif-pop" id="notifPop">
							<div class="pop-header">Notifications</div>
							<div style="max-height:320px; overflow:auto">
								<div class="notif-item notif-success"><div class="notif-icon">🧾</div><div><div class="notif-title">New patient registered: Juan Dela Cruz</div><div class="notif-time">5 mins ago</div></div></div>
								<div class="notif-item notif-warning"><div class="notif-icon">🏥</div><div><div class="notif-title">Emergency admission in ICU</div><div class="notif-time">12 mins ago</div></div></div>
								<div class="notif-item notif-info"><div class="notif-icon">🧪</div><div><div class="notif-title">Lab results ready for Patient ID: 12845</div><div class="notif-time">25 mins ago</div></div></div>
								<div class="notif-item notif-warning"><div class="notif-icon">💊</div><div><div class="notif-title">Low stock alert: Paracetamol 500mg</div><div class="notif-time">1 hour ago</div></div></div>
								<div class="notif-item notif-success"><div class="notif-icon">💵</div><div><div class="notif-title">Payment received: ₱15,000 - Patient ID: 12834</div><div class="notif-time">2 hours ago</div></div></div>
                        </div>
							<div class="view-all"><a href="#">View all notifications</a></div>
                    </div>
                </div>
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" onclick="togglePop('userPop')"><div class="avatar">AD</div><div class="user-meta"><div class="user-name">Dr. Maria Santos</div><div class="user-role">Hospital Administrator</div></div></div>
						<div class="pop user-pop" id="userPop">
							<div style="display:flex; gap:10px; padding:12px 14px; border-bottom:1px solid #f1f5f9"><div style="width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#6366f1;color:#fff;font-weight:800">AD</div><div><div style="font-weight:800">Dr. Maria Santos</div><div style="color:#64748b;font-size:12px">Hospital Administrator</div><div style="color:#94a3b8;font-size:12px">ID: ADM-001</div></div></div>
							<div><a href="#" class="menu-link">👤 Admin Info</a><a href="#" class="menu-link">⚙️ Settings</a></div>
							<div style="border-top:1px solid #f1f5f9"></div>
							<div><a href="<?= site_url('logout') ?>" class="menu-link" style="color:#ef4444">🚪 Logout</a></div>
                                </div>
                                </div>
                            </div>
			</header>

			<div class="page">
				<!-- KPI cards -->
				<div class="kpi-grid">
					<div class="kpi">
						<div class="kpi-icon">👥</div>
						<div class="kpi-title">Total Patients</div>
						<div class="kpi-value">2,847</div>
						<div class="kpi-sub"><span>▲ +12% from last month</span></div>
                                </div>
					<div class="kpi">
						<div class="kpi-icon">📅</div>
						<div class="kpi-title">Today's Appointments</div>
						<div class="kpi-value">156</div>
						<div class="kpi-sub" style="color:#475569"><a href="#" style="color:#2563eb; text-decoration:none">78 completed</a></div>
                                </div>
					<div class="kpi">
						<div class="kpi-icon">💵</div>
						<div class="kpi-title">Revenue (Monthly)</div>
						<div class="kpi-value">₱165,000</div>
						<div class="kpi-sub"><span>▲ +8.5% from last month</span></div>
                            </div>
					<div class="kpi">
						<div class="kpi-icon">🧑‍⚕️</div>
						<div class="kpi-title">Active Staff</div>
						<div class="kpi-value">94</div>
						<div class="kpi-sub" style="color:#475569">45 doctors, 49 nurses</div>
                                </div>
                            </div>
                            
				<div class="grid-2">
                    <div class="card">
						<div class="card-header">Patient Trends <select class="select"><option>This year</option><option>This month</option></select></div>
						<div class="card-content" style="height:320px">
							<canvas id="patientsChart"></canvas>
                    </div>
                </div>
                    <div class="card">
                        <div class="card-header">Recent Activities</div>
                        <div class="card-content">
							<div class="activities">
								<div class="act"><div class="dot dot-blue"></div><div><div class="act-title">New patient registered: Juan Dela Cruz</div><div class="act-time">5 mins ago</div></div></div>
								<div class="act"><div class="dot dot-amber"></div><div><div class="act-title">Emergency admission in ICU</div><div class="act-time">12 mins ago</div></div></div>
								<div class="act"><div class="dot dot-green"></div><div><div class="act-title">Lab results ready for Patient ID: 12845</div><div class="act-time">25 mins ago</div></div></div>
								<div class="act"><div class="dot dot-red"></div><div><div class="act-title">Low stock alert: Paracetamol 500mg</div><div class="act-time">1 hour ago</div></div></div>
								<div class="act"><div class="dot dot-blue"></div><div><div class="act-title">Payment received: ₱15,000 - Patient ID: 12834</div><div class="act-time">2 hours ago</div></div></div>
							</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
