<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laboratory Dashboard</title>
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
		.sev-low { background:#dcfce7; color:#16a34a }
		.appt { display:flex; align-items:center; justify-content:space-between; padding:12px 0; border-bottom:1px solid #f1f5f9 }
		.appt:last-child { border-bottom:none }
		.appt-left { display:flex; align-items:center; gap:12px }
		.badge-time { background:#eef2ff; color:#1d4ed8; padding:4px 8px; border-radius:8px; font-weight:600; font-size:12px }
		.link { color:#2563eb; text-decoration:none; font-size:12px }

		/* Table Styles */
		.table-container { overflow-x: auto; }
		.data-table { width:100%; border-collapse:collapse; font-size:14px; }
		.data-table th { background:#f9fafb; padding:12px 16px; text-align:left; font-weight:600; color:#374151; border-bottom:1px solid #e5e7eb; }
		.data-table td { padding:12px 16px; border-bottom:1px solid #f3f4f6; color:#374151; }
		.data-table tr:hover { background:#f9fafb; }
		.priority-badge { padding:4px 8px; border-radius:12px; font-size:10px; font-weight:600; text-transform:uppercase; }
		.priority-high { background:#fef2f2; color:#dc2626; }
		.priority-medium { background:#fffbeb; color:#d97706; }
		.priority-low { background:#f0fdf4; color:#16a34a; }
		.status-badge { padding:4px 8px; border-radius:12px; font-size:10px; font-weight:600; text-transform:uppercase; }
		.status-in-progress { background:#dbeafe; color:#2563eb; }
		.status-sample-receive { background:#f3e8ff; color:#7c3aed; }
		.status-pending { background:#f3f4f6; color:#6b7280; }

		/* Quick Actions */
		.quick-action-item { display:flex; align-items:center; gap:12px; padding:12px 0; border-bottom:1px solid #f1f5f9; cursor:pointer; transition:background 0.2s; }
		.quick-action-item:hover { background:#f9fafb; }
		.quick-action-item:last-child { border-bottom:none; }
		.quick-action-icon { width:40px; height:40px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:18px; color:white; }
		.quick-action-icon.blue { background:#3b82f6; }
		.quick-action-icon.green { background:#10b981; }
		.quick-action-icon.purple { background:#8b5cf6; }
		.quick-action-icon.orange { background:#f59e0b; }
		.quick-action-content { flex:1; }
		.quick-action-title { font-weight:600; color:#1f2937; font-size:14px; margin-bottom:2px; }
		.quick-action-desc { font-size:12px; color:#6b7280; }

		@media (max-width: 1200px){ .metric-grid{grid-template-columns:repeat(2,1fr)} .grid-2{grid-template-columns:1fr} .grid-2b{grid-template-columns:1fr} }
	</style>
</head>
<body>
	<div class="container">
		<nav class="sidebar">
			<div class="sidebar-header">
				<div class="admin-icon">🧪</div>
				<div style="display:flex;flex-direction:column">
					<span class="sidebar-title">Laboratory</span>
					<span class="sidebar-sub">Lab Department</span>
				</div>
			</div>
			<div class="sidebar-menu">
				<a href="<?= site_url('laboratory') ?>" class="menu-item active"><span class="menu-icon">📊</span>Dashboard</a>
				<a href="<?= site_url('laboratory/test/request') ?>" class="menu-item"><span class="menu-icon">📋</span>Test Requests</a>
				<a href="<?= site_url('laboratory/test/results') ?>" class="menu-item"><span class="menu-icon">📄</span>Test Results</a>
				<a href="<?= site_url('laboratory/equipment/status') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Equipment Status</a>
				<a href="<?= site_url('laboratory/tracking') ?>" class="menu-item"><span class="menu-icon">📈</span>Sample Tracking</a>
				<a href="<?= site_url('laboratory/reports') ?>" class="menu-item"><span class="menu-icon">📋</span>Lab Reports</a>
				<a href="<?= site_url('laboratory/quality') ?>" class="menu-item"><span class="menu-icon">🛡️</span>Quality Control</a>
				<a href="<?= site_url('laboratory/inventory') ?>" class="menu-item"><span class="menu-icon">📦</span>Lab Inventory</a>
				<a href="<?= site_url('laboratory/settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
			</div>
		</nav>

		<main class="main-content">
			<header class="header">
				<div class="header-left">
					<h1>Laboratory Management</h1>
					<span class="subtext">Today: <span id="current-date"></span></span>
				</div>
				<div class="actions">
					<div class="notif-wrap">
						<button class="icon-btn" aria-label="Notifications" id="notifBtn">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5l-2 2v1h16v-1l-2-2Z" stroke="#475569" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="badge">3</span>
						</button>
					</div>
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" id="userBtn" style="cursor:pointer">
							<div class="avatar">LT</div>
							<div class="user-meta">
								<div class="user-name">Lab Technician</div>
								<div class="user-role">Laboratory Staff</div>
							</div>
						</div>
						<div class="user-pop" id="userPop" style="display:none; position:absolute; right:0; top:44px; width:260px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); overflow:hidden; z-index:30;">
							<div style="display:flex; gap:10px; padding:12px 14px; border-bottom:1px solid #f1f5f9">
								<div class="big" style="width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#6366f1;color:#fff;font-weight:800">LT</div>
								<div><div style="font-weight:700">Lab Technician</div><div style="color:#64748b;font-size:12px">Laboratory Staff</div><div style="color:#94a3b8;font-size:12px">ID: LT-2024-001</div></div>
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
				<!-- Main Title -->
				<h2 style="font-size:24px; font-weight:700; color:#1f2937; margin-bottom:20px;">Laboratory Dashboard</h2>

				<!-- KPI Metrics -->
				<div class="metric-grid">
					<div class="metric">
						<div class="metric-title">Tests Today</div>
						<div class="metric-value">42</div>
						<div class="metric-sub">+8 from yesterday</div>
						<div class="metric-icon icon-blue">🧪</div>
					</div>
					<div class="metric">
						<div class="metric-title">Pending Results</div>
						<div class="metric-value">18</div>
						<div class="metric-sub">Awaiting processing</div>
						<div class="metric-icon icon-orange">⏰</div>
					</div>
					<div class="metric">
						<div class="metric-title">Completed Tests</div>
						<div class="metric-value">156</div>
						<div class="metric-sub">This week</div>
						<div class="metric-icon icon-green">✅</div>
					</div>
					<div class="metric">
						<div class="metric-title">Critical Results</div>
						<div class="metric-value">3</div>
						<div class="metric-sub">Requires attention</div>
						<div class="metric-icon icon-purple">⚠️</div>
					</div>
				</div>

				<!-- Bottom Row: Pending Test Requests and Quick Actions -->
				<div class="grid-2b">
					<div class="card">
						<div class="card-header" style="display:flex;justify-content:space-between;align-items:center">Pending Test Requests <a class="link" href="#">View All</a></div>
						<div class="card-content">
							<div class="table-container">
								<table class="data-table">
									<thead>
										<tr>
											<th>TEST ID</th>
											<th>PATIENT</th>
											<th>TEST TYPE</th>
											<th>PRIORITY</th>
											<th>STATUS</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><strong>LAB-001</strong></td>
											<td>Maria Santos<br><small style="color:#6b7280;">Requested by Dr. Rodriguez</small></td>
											<td>Complete Blood Count (Blood)</td>
											<td><span class="priority-badge priority-high">high</span></td>
											<td><span class="status-badge status-in-progress">In Progress</span></td>
										</tr>
										<tr>
											<td><strong>LAB-002</strong></td>
											<td>Juan Dela Cruz<br><small style="color:#6b7280;">Requested by Dr. Garcia</small></td>
											<td>Lipid Profile (Blood)</td>
											<td><span class="priority-badge priority-medium">medium</span></td>
											<td><span class="status-badge status-sample-receive">Sample Receive</span></td>
										</tr>
										<tr>
											<td><strong>LAB-003</strong></td>
											<td>Ana Reyes<br><small style="color:#6b7280;">Requested by Dr. Martinez</small></td>
											<td>Urinalysis (Urine)</td>
											<td><span class="priority-badge priority-low">low</span></td>
											<td><span class="status-badge status-pending">Pending</span></td>
										</tr>
										<tr>
											<td><strong>LAB-004</strong></td>
											<td>Carlos Mendoza<br><small style="color:#6b7280;">Requested by Dr. Lopez</small></td>
											<td>Chest X-Ray (Imaging)</td>
											<td><span class="priority-badge priority-high">high</span></td>
											<td><span class="status-badge status-in-progress">In Progress</span></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header" style="display:flex;justify-content:space-between;align-items:center">Quick Actions <a class="link" href="#">View All</a></div>
						<div class="card-content">
							<div class="quick-action-item">
								<div class="quick-action-icon blue">➕</div>
								<div class="quick-action-content">
									<div class="quick-action-title">New Test Request</div>
									<div class="quick-action-desc">Create a new laboratory test request</div>
								</div>
							</div>
							<div class="quick-action-item">
								<div class="quick-action-icon green">📝</div>
								<div class="quick-action-content">
									<div class="quick-action-title">Enter Results</div>
									<div class="quick-action-desc">Input test results and reports</div>
								</div>
							</div>
							<div class="quick-action-item">
								<div class="quick-action-icon purple">📈</div>
								<div class="quick-action-content">
									<div class="quick-action-title">Sample Tracking</div>
									<div class="quick-action-desc">Track sample collection and processing</div>
								</div>
							</div>
							<div class="quick-action-item">
								<div class="quick-action-icon orange">⚙️</div>
								<div class="quick-action-content">
									<div class="quick-action-title">Equipment Status</div>
									<div class="quick-action-desc">Check laboratory equipment status</div>
								</div>
							</div>
							<div class="quick-action-item">
								<div class="quick-action-icon blue">📄</div>
								<div class="quick-action-content">
									<div class="quick-action-title">Generate Report</div>
									<div class="quick-action-desc">Generate laboratory reports</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>
	</div>

    <script>
    // Update date and time
    function updateDateTime() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('en-US', { 
            month: 'numeric', 
            day: 'numeric', 
            year: 'numeric' 
        });
        
        document.getElementById('current-date').textContent = dateStr;
    }

    // Update time every second
    updateDateTime();
    setInterval(updateDateTime, 1000);

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
    </script>
</body>
</html>
