<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Receptionist • Patients</title>
	<style>
		* { margin: 0; padding: 0; box-sizing: border-box; }
		body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; background-color: #f5f7fa; overflow-x: hidden; }
		.container { display: flex; min-height: 100vh; }
		.sidebar { width: 250px; background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%); color: white; position: fixed; height: 100vh; overflow-y: auto; z-index: 1000; }
		.sidebar-header { padding: 20px; border-bottom: 1px solid #34495e; display: flex; align-items: center; gap: 12px; }
		.admin-icon { width: 32px; height: 32px; background: #3498db; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 14px; }
		.sidebar-title { font-size: 18px; font-weight: 600; }
		.sidebar-menu { padding: 20px 0; }
		.menu-item { display: block; padding: 12px 20px; color: #bdc3c7; text-decoration: none; transition: all 0.3s ease; border-left: 3px solid transparent; display: flex; align-items: center; gap: 12px; }
		.menu-item:hover { background-color: rgba(255,255,255,0.1); color: white; border-left-color: #3498db; }
		.menu-item.active { background-color: rgba(52,152,219,0.2); color: white; border-left-color: #3498db; }
		.menu-icon { width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; }
		.main-content { flex: 1; margin-left: 250px; padding: 0; }
		.header { background: white; padding: 20px 30px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center; }
		.header h1 { font-size: 24px; color: #2c3e50; font-weight: 600; }
		.dashboard-content { padding: 30px; }
		.card { background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); overflow: hidden; }
		.card-header { padding: 20px 24px; border-bottom: 1px solid #ecf0f1; font-size: 18px; font-weight: 600; color: #2c3e50; }
		.card-content { padding: 20px 24px; }
	</style>
</head>
<body>
	<div class="container">
		<nav class="sidebar">
			<div class="sidebar-header">
				<div class="admin-icon">R</div>
				<span class="sidebar-title">Receptionist</span>
			</div>
			<div class="sidebar-menu">
				<a href="<?= site_url('receptionist') ?>" class="menu-item"><span class="menu-icon">📊</span>Dashboard</a>
				<a href="<?= site_url('receptionist/patients') ?>" class="menu-item active"><span class="menu-icon">👥</span>Patients</a>
				<a href="<?= site_url('receptionist/appointments') ?>" class="menu-item"><span class="menu-icon">📅</span>Appointments</a>
				<a href="<?= site_url('receptionist/reports') ?>" class="menu-item"><span class="menu-icon">📈</span>Reports</a>
				<a href="<?= site_url('receptionist/settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
				<a href="<?= site_url('logout') ?>" class="menu-item"><span class="menu-icon">🚪</span>Logout</a>
			</div>
		</nav>

		<main class="main-content">
			<header class="header">
				<h1>Patients</h1>
			</header>
			<div class="dashboard-content">
				<div style="display:flex; align-items:center; gap:16px; color:#7f8c8d; margin-bottom:16px;">
					<div style="display:flex; align-items:center; gap:8px;">
						<span>📅</span>
						<span><?= esc(date('l, F j, Y')) ?></span>
					</div>
					<div style="height:6px; width:6px; background:#3498db; border-radius:50%;"></div>
					<div>
						<span>Receptionist</span>
						<span style="margin:0 6px;">•</span>
						<span>Admin</span>
					</div>
				</div>

				<div class="card">
					<div class="card-header">Patients Module</div>
					<div class="card-content">
						<p style="color:#7f8c8d">Build your receptionist-facing patients list/table here.</p>
					</div>
				</div>
			</div>
		</main>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const currentPath = window.location.pathname;
			document.querySelectorAll('.menu-item').forEach(item => {
				if (item.getAttribute('href') && currentPath.includes(item.getAttribute('href').split('/').pop())) {
					document.querySelectorAll('.menu-item').forEach(mi => mi.classList.remove('active'));
					item.classList.add('active');
				}
			});
		});
	</script>
</body>
</html>


