<nav class="sidebar">
	<!-- Brand -->
	<div class="sidebar-header" style="display:flex; align-items:center; gap:10px">
		<div class="admin-icon">A</div>
		<div style="display:flex; flex-direction:column; line-height:1.1">
			<span class="sidebar-title" style="font-weight:800">San Miguel HMS</span>
			<span style="font-size:12px; color:#cbd5e1">Admin Portal</span>
		</div>
		<div style="margin-left:auto; opacity:.8">≡</div>
	</div>

	<style>
		/* Light theme overrides */
		.sidebar { background:#fff !important; color:#0f172a !important; border-right:1px solid #e5e7eb }
		.sidebar-header { border-bottom:1px solid #e5e7eb !important }
		.admin-icon { background:#2563eb !important; color:#fff }
		.sidebar-title { color:#0f172a }
		.sidebar-header span[style*="color:#cbd5e1"]{ color:#64748b !important }

		/* Collapsible groups */
		.menu-group { margin-top:2px }
		.group-toggle { width:100%; display:flex; align-items:center; gap:12px; padding:12px 20px; color:#334155; background:transparent; border:0; text-align:left; cursor:pointer; border-left:3px solid transparent }
		.group-toggle:hover { background:#f1f5f9; color:#0f172a; border-left-color:#2563eb }
		.group-toggle .chev { margin-left:auto; transition:transform .2s ease }
		.menu-group.open .chev { transform:rotate(90deg) }
		.submenu { display:none; padding:6px 0 8px 46px }
		.menu-group.open .submenu { display:block }
		.subitem { display:block; padding:8px 0; color:#334155; text-decoration:none; font-size:14px }
		.subitem:hover { color:#0f172a }
		.menu-item { display:flex; align-items:center; gap:12px; padding:12px 20px; color:#334155; text-decoration:none; border-left:3px solid transparent }
		.menu-item:hover { background:#f1f5f9; color:#0f172a; border-left-color:#2563eb }
		.menu-item.active { background:#eef2ff; color:#1d4ed8; border-left-color:#2563eb }
		.menu-icon { width:20px; text-align:center }
	</style>

	<div class="sidebar-menu" id="sidebarMenu">
		<?php $role = session('role') ?? 'admin'; ?>
		<?php if ($role === 'it_staff'): ?>
			<a href="<?= site_url('it') ?>" class="menu-item"><span class="menu-icon">🖥️</span>IT Dashboard</a>
			<a href="<?= site_url('it/monitoring') ?>" class="menu-item"><span class="menu-icon">📡</span>System Monitoring</a>
			<a href="<?= site_url('it/security') ?>" class="menu-item"><span class="menu-icon">🔐</span>Security & Access</a>
			<a href="<?= site_url('it/backup') ?>" class="menu-item"><span class="menu-icon">💾</span>Backup & Recovery</a>
			<a href="<?= site_url('users') ?>" class="menu-item"><span class="menu-icon">👤</span>User Management</a>
			<a href="<?= site_url('it/logs') ?>" class="menu-item"><span class="menu-icon">📜</span>System Logs</a>
			<a href="<?= site_url('reports') ?>" class="menu-item"><span class="menu-icon">📈</span>IT Reports</a>
			<a href="<?= site_url('settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
		<?php else: ?>
			<a href="<?= site_url('dashboard') ?>" class="menu-item"><span class="menu-icon">🟦</span>Dashboard</a>

			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">👤</span>Patient Management <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="<?= site_url('patients/records') ?>">Patient Records</a>
					<a class="subitem" href="<?= site_url('patients/add') ?>">Registration</a>
					<a class="subitem" href="<?= site_url('patients/history') ?>">Medical History</a>
				</div>
			</div>

			<!-- Scheduling (restored minimal) -->
			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">🗓️</span>Scheduling <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="<?= site_url('scheduling/doctor') ?>">Doctor Schedule</a>
					<a class="subitem" href="<?= site_url('scheduling/nurse') ?>">Nurse Schedule</a>
					<a class="subitem" href="<?= site_url('appointments') ?>">Appointments</a>
				</div>
			</div>

			<!-- Billing & Payments -->
			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">🧾</span>Billing & Payments <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="#">Generate Bills</a>
					<a class="subitem" href="#">Payment Tracking</a>
					<a class="subitem" href="#">Insurance Claims</a>
				</div>
			</div>

			<!-- Laboratory -->
			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">🧪</span>Laboratory <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="#">Test Requests</a>
					<a class="subitem" href="#">Results Management</a>
					<a class="subitem" href="#">Equipment Status</a>
				</div>
			</div>

			<!-- Pharmacy -->
			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">💊</span>Pharmacy <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="#">Inventory Management</a>
					<a class="subitem" href="#">Prescription Orders</a>
					<a class="subitem" href="#">Stock Alerts</a>
				</div>
			</div>

			<!-- Reports & Analytics -->
			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">📊</span>Reports & Analytics <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="#">Performance Reports</a>
					<a class="subitem" href="#">Financial Reports</a>
					<a class="subitem" href="#">Patient Analytics</a>
				</div>
			</div>

			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">👥</span>Staff Management <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="#">Employee Records</a>
					<a class="subitem" href="#">Role Management</a>
					<a class="subitem" href="#">Access Control</a>
				</div>
			</div>

			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">🏢</span>Branch Management <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="#">Branches</a>
					<a class="subitem" href="#">Departments</a>
				</div>
			</div>

			<!-- Keep direct User Management link as requested -->
			<a href="<?= site_url('users') ?>" class="menu-item"><span class="menu-icon">👤</span>User Management</a>

			<div class="menu-group" data-group>
				<button class="group-toggle" type="button"><span class="menu-icon">⚙️</span>System Settings <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="<?= site_url('settings') ?>">General</a>
					<a class="subitem" href="<?= site_url('settings') ?>">Security</a>
				</div>
			</div>
		<?php endif; ?>

		<a href="<?= site_url('logout') ?>" class="menu-item"><span class="menu-icon">🚪</span>Logout</a>
	</div>

	<script>
		(function(){
			const groups = document.querySelectorAll('[data-group]');
			groups.forEach(g=>{
				const btn = g.querySelector('.group-toggle');
				btn.addEventListener('click', ()=>{ g.classList.toggle('open'); });
			});
			// Active highlight for routes (top-level and subitems) and auto-open group
			const path = window.location.pathname;
			let activeSet = false;
			document.querySelectorAll('.menu-item').forEach(a=>{
				const href = a.getAttribute('href') || '';
				if(href && path.indexOf(href) !== -1){ a.classList.add('active'); activeSet = true; }
			});
			document.querySelectorAll('.submenu .subitem').forEach(a=>{
				const href = a.getAttribute('href') || '';
				if(href && path.indexOf(href) !== -1){
					a.style.color = '#fff';
					const group = a.closest('[data-group]');
					group && group.classList.add('open');
					activeSet = true;
				}
			});
			// No default open; groups open only on user click
		})();
	</script>
</nav>

