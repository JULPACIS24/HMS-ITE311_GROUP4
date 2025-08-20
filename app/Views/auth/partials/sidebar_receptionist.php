<nav class="sidebar">
	<div class="sidebar-header">
		<div class="admin-icon">R</div>
		<span class="sidebar-title">Receptionist</span>
	</div>
	<div class="sidebar-menu">
		<?php $path = (string) current_url(true)->getPath(); ?>
		<a href="<?= site_url('receptionist') ?>" class="menu-item<?= $path === 'receptionist' ? ' active' : '' ?>"><span class="menu-icon">📊</span>Dashboard</a>
		<a href="<?= site_url('receptionist/patients') ?>" class="menu-item<?= str_starts_with($path, 'receptionist/patients') ? ' active' : '' ?>"><span class="menu-icon">👥</span>Patients</a>
		<a href="<?= site_url('receptionist/appointments') ?>" class="menu-item<?= str_starts_with($path, 'receptionist/appointments') ? ' active' : '' ?>"><span class="menu-icon">📅</span>Appointments</a>
		<a href="<?= site_url('receptionist/reports') ?>" class="menu-item<?= str_starts_with($path, 'receptionist/reports') ? ' active' : '' ?>"><span class="menu-icon">📈</span>Reports</a>
		<a href="<?= site_url('receptionist/settings') ?>" class="menu-item<?= str_starts_with($path, 'receptionist/settings') ? ' active' : '' ?>"><span class="menu-icon">⚙️</span>Settings</a>
		<a href="#" class="menu-item" id="logoutLink"><span class="menu-icon">🚪</span>Logout</a>
	</div>
</nav>


