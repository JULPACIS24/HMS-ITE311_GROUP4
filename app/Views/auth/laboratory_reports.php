<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lab Reports - Laboratory</title>
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
		.menu-icon { width:20px; text-align:center }
		.main-content { flex:1; margin-left:250px }
		.header { background:#fff; padding:18px 24px; box-shadow:0 2px 4px rgba(0,0,0,.08); display:flex; justify-content:space-between; align-items:center }
		.header h1 { font-size:22px; color:#2c3e50; font-weight:700; margin:0 }
		.content { padding:24px }
		.card { background:#fff; border-radius:12px; padding:24px; box-shadow:0 2px 4px rgba(0,0,0,.08); margin-bottom:20px }
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
				<a href="<?= site_url('laboratory') ?>" class="menu-item"><span class="menu-icon">📊</span>Dashboard</a>
				<a href="<?= site_url('laboratory/test/request') ?>" class="menu-item"><span class="menu-icon">📋</span>Test Requests</a>
				<a href="<?= site_url('laboratory/test/results') ?>" class="menu-item"><span class="menu-icon">📄</span>Test Results</a>
				<a href="<?= site_url('laboratory/equipment/status') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Equipment Status</a>
				<a href="<?= site_url('laboratory/tracking') ?>" class="menu-item"><span class="menu-icon">📈</span>Sample Tracking</a>
				<a href="<?= site_url('laboratory/reports') ?>" class="menu-item active"><span class="menu-icon">📋</span>Lab Reports</a>
				<a href="<?= site_url('laboratory/quality') ?>" class="menu-item"><span class="menu-icon">🛡️</span>Quality Control</a>
				<a href="<?= site_url('laboratory/inventory') ?>" class="menu-item"><span class="menu-icon">📦</span>Lab Inventory</a>
				<a href="<?= site_url('laboratory/settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
			</div>
		</nav>

		<main class="main-content">
			<header class="header">
				<div class="header-left">
					<h1>Lab Reports</h1>
					<span class="subtext">Generate and manage laboratory reports</span>
				</div>
			</header>

			<div class="content">
				<div class="card">
					<h2>Laboratory Reports</h2>
					<p>This page will show laboratory reports and analytics.</p>
					<p><strong>Status:</strong> Under development</p>
				</div>
			</div>
		</main>
	</div>
</body>
</html>
