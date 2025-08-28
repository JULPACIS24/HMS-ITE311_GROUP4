<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pharmacy Dashboard</title>
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

		/* Quick Actions Grid */
		.quick-actions-grid { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:20px }
		.quick-action-btn { display:flex; flex-direction:column; align-items:center; padding:20px; border:2px solid #f3f4f6; border-radius:12px; background:white; cursor:pointer; transition:all 0.2s; text-decoration:none; color:#374151 }
		.quick-action-btn:hover { border-color:#3b82f6; transform:translateY(-2px); box-shadow:0 4px 8px rgba(59, 130, 246, 0.1) }
		.quick-action-icon { width:40px; height:40px; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:18px; color:white; margin-bottom:8px }
		.quick-action-icon.blue { background:#3b82f6 }
		.quick-action-icon.green { background:#10b981 }
		.quick-action-icon.purple { background:#8b5cf6 }
		.quick-action-icon.orange { background:#f59e0b }
		.quick-action-text { font-size:12px; font-weight:500; text-align:center }

		/* Recent Activity */
		.activity-item { display:flex; align-items:center; gap:10px; padding:8px 0; font-size:13px; color:#374151 }
		.activity-bullet { width:8px; height:8px; border-radius:50% }
		.activity-bullet.green { background:#10b981 }
		.activity-bullet.blue { background:#3b82f6 }
		.activity-bullet.orange { background:#f59e0b }
		.activity-bullet.purple { background:#8b5cf6 }

		@media (max-width: 1200px){ .metric-grid{grid-template-columns:repeat(2,1fr)} .grid-2{grid-template-columns:1fr} .grid-2b{grid-template-columns:1fr} }
	</style>
</head>
<body>
	<div class="container">
		<nav class="sidebar">
			<div class="sidebar-header">
				<div class="admin-icon">💊</div>
				<div style="display:flex;flex-direction:column">
					<span class="sidebar-title">Pharmacist</span>
					<span class="sidebar-sub">Pharmacy Department</span>
				</div>
			</div>
			<div class="sidebar-menu">
				<a href="<?= site_url('pharmacy') ?>" class="menu-item active"><span class="menu-icon">📊</span>Dashboard</a>
				<a href="<?= site_url('pharmacy/inventory') ?>" class="menu-item"><span class="menu-icon">💊</span>Medicine Inventory</a>
				<a href="<?= site_url('pharmacy/prescriptions') ?>" class="menu-item"><span class="menu-icon">📄</span>Prescriptions</a>
				<a href="<?= site_url('pharmacy/dispensing') ?>" class="menu-item"><span class="menu-icon">🤲</span>Dispensing</a>
				<a href="<?= site_url('pharmacy/pos') ?>" class="menu-item"><span class="menu-icon">🛒</span>Point of Sale</a>
				<a href="<?= site_url('pharmacy/stock') ?>" class="menu-item"><span class="menu-icon">📦</span>Stock Management</a>
				<a href="<?= site_url('pharmacy/suppliers') ?>" class="menu-item"><span class="menu-icon">🚚</span>Suppliers</a>
				<a href="<?= site_url('pharmacy/reports') ?>" class="menu-item"><span class="menu-icon">📈</span>Reports</a>
				<a href="<?= site_url('pharmacy/settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
			</div>
		</nav>

		<main class="main-content">
			<header class="header">
				<div class="header-left">
					<h1>Pharmacy Dashboard</h1>
					<span class="subtext">Welcome back, manage your pharmacy operations.</span>
				</div>
				<div class="actions">
					<div class="date-time" id="currentDateTime" style="text-align:right; color:#6b7280; font-size:14px; margin-right:20px;">
						<div id="current-date"></div>
						<div id="current-time"></div>
					</div>
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" id="userBtn" style="cursor:pointer">
							<div class="avatar">P</div>
							<div class="user-meta">
								<div class="user-name">Pharmacist</div>
								<div class="user-role">Pharmacy Staff</div>
							</div>
						</div>
						<div class="user-pop" id="userPop" style="display:none; position:absolute; right:0; top:44px; width:260px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); overflow:hidden; z-index:30;">
							<div style="display:flex; gap:10px; padding:12px 14px; border-bottom:1px solid #f1f5f9">
								<div class="big" style="width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#6366f1;color:#fff;font-weight:800">P</div>
								<div><div style="font-weight:700">Pharmacist</div><div style="color:#64748b;font-size:12px">Pharmacy Department</div><div style="color:#94a3b8;font-size:12px">ID: PH-2024-001</div></div>
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
				<!-- KPI Metrics -->
				<div class="metric-grid">
					<div class="metric">
						<div class="metric-title">Prescriptions Today</div>
						<div class="metric-value">42</div>
						<div class="metric-sub">+5 from yesterday</div>
						<div class="metric-icon icon-blue">📄</div>
					</div>
					<div class="metric">
						<div class="metric-title">Medicines Dispensed</div>
						<div class="metric-value">128</div>
						<div class="metric-sub">This week</div>
						<div class="metric-icon icon-green">💊</div>
					</div>
					<div class="metric">
						<div class="metric-title">Low Stock Items</div>
						<div class="metric-value">8</div>
						<div class="metric-sub">Requires attention</div>
						<div class="metric-icon icon-orange">⚠️</div>
					</div>
					<div class="metric">
						<div class="metric-title">Expired Items</div>
						<div class="metric-value">3</div>
						<div class="metric-sub">Need disposal</div>
						<div class="metric-icon icon-purple">🚫</div>
					</div>
				</div>

				<!-- Bottom Row: Pending Tasks & Alerts and Quick Actions + Recent Activity -->
				<div class="grid-2b">
					<div class="card">
						<div class="card-header" style="display:flex;justify-content:space-between;align-items:center">Pending Tasks & Alerts <a class="link" href="#">View All</a></div>
						<div class="card-content">
							<div class="task">
								<div class="task-icon">📄</div>
								<div style="flex:1">
									<div class="task-title">Verify prescription</div>
									<div class="task-meta">Patient: John Rodriguez - Prescription ID: #RX-2024-001</div>
									<div style="color:#6b7280; font-size:12px; margin-top:4px;">Assigned to: Dr. Maria Santos</div>
								</div>
								<span class="sev sev-high">HIGH</span>
								<button style="padding:6px 12px; border:none; border-radius:6px; background:#3b82f6; color:white; font-size:12px; font-weight:500; cursor:pointer; margin-left:10px;">Review</button>
							</div>
							<div class="task">
								<div class="task-icon">📦</div>
								<div style="flex:1">
									<div class="task-title">Restock antibiotics</div>
									<div class="task-meta">Amoxicillin 500mg - Current stock: 15 units</div>
									<div style="color:#6b7280; font-size:12px; margin-top:4px;">Assigned to: Supplier: MedCorp</div>
								</div>
								<span class="sev sev-medium">MEDIUM</span>
								<button style="padding:6px 12px; border:none; border-radius:6px; background:#3b82f6; color:white; font-size:12px; font-weight:500; cursor:pointer; margin-left:10px;">Review</button>
							</div>
							<div class="task">
								<div class="task-icon">📊</div>
								<div style="flex:1">
									<div class="task-title">Update inventory</div>
									<div class="task-meta">Monthly inventory reconciliation due</div>
									<div style="color:#6b7280; font-size:12px; margin-top:4px;">Assigned to: System Admin</div>
								</div>
								<span class="sev sev-medium">MEDIUM</span>
								<button style="padding:6px 12px; border:none; border-radius:6px; background:#3b82f6; color:white; font-size:12px; font-weight:500; cursor:pointer; margin-left:10px;">Review</button>
							</div>
							<div class="task">
								<div class="task-icon">🛡️</div>
								<div style="flex:1">
									<div class="task-title">Process insurance claim</div>
									<div class="task-meta">Patient: Lisa Chen - Claim #INS-2024-089</div>
									<div style="color:#6b7280; font-size:12px; margin-top:4px;">Assigned to: Insurance Dept</div>
								</div>
								<span class="sev sev-low">LOW</span>
								<button style="padding:6px 12px; border:none; border-radius:6px; background:#3b82f6; color:white; font-size:12px; font-weight:500; cursor:pointer; margin-left:10px;">Review</button>
							</div>
						</div>
					</div>
					<div class="card">
						<div class="card-header" style="display:flex;justify-content:space-between;align-items:center">Quick Actions <a class="link" href="#">View All</a></div>
						<div class="card-content">
							<div class="quick-actions-grid">
								<a href="#" class="quick-action-btn">
									<div class="quick-action-icon blue">➕</div>
									<div class="quick-action-text">Add Medicine</div>
								</a>
								<a href="#" class="quick-action-btn">
									<div class="quick-action-icon green">💊</div>
									<div class="quick-action-text">Process Prescription</div>
								</a>
								<a href="#" class="quick-action-btn">
									<div class="quick-action-icon purple">📊</div>
									<div class="quick-action-text">Generate Report</div>
								</a>
								<a href="#" class="quick-action-btn">
									<div class="quick-action-icon orange">⚙️</div>
									<div class="quick-action-text">Settings</div>
								</a>
							</div>
							
							<div style="margin-top:20px;">
								<h3 style="font-size:14px; font-weight:600; color:#1f2937; margin-bottom:12px;">Recent Activity</h3>
								<div class="activity-item">
									<div class="activity-bullet green"></div>
									<span>Dispensed Paracetamol to Patient #P-001</span>
								</div>
								<div class="activity-item">
									<div class="activity-bullet blue"></div>
									<span>Updated inventory for Amoxicillin</span>
								</div>
								<div class="activity-item">
									<div class="activity-bullet orange"></div>
									<span>Low stock alert: Ibuprofen 400mg</span>
								</div>
								<div class="activity-item">
									<div class="activity-bullet purple"></div>
									<span>Processed prescription #RX-2024-089</span>
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
        const timeStr = now.toLocaleTimeString('en-US', { 
            hour: 'numeric', 
            minute: '2-digit', 
            second: '2-digit',
            hour12: true 
        });
        
        document.getElementById('current-date').textContent = dateStr;
        document.getElementById('current-time').textContent = timeStr;
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
