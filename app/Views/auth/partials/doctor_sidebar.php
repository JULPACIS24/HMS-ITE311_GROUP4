<?php $path = (string) current_url(true)->getPath(); ?>
<nav class="sidebar">
	<div class="sidebar-header">
		<div class="admin-icon">🏥</div>
		<div style="display:flex;flex-direction:column">
			<span class="sidebar-title">San Miguel HMS</span>
			<span class="sidebar-sub">Doctor Portal</span>
		</div>
	</div>
	<div class="sidebar-menu">
		<a href="<?= site_url('doctor') ?>" class="menu-item<?= $path === 'doctor' ? ' active' : '' ?>"><span class="menu-icon">📊</span>Dashboard</a>
		<a href="<?= site_url('doctor/patients') ?>" class="menu-item<?= strpos($path,'doctor/patients')===0 ? ' active' : '' ?>"><span class="menu-icon">📁</span>Patient Records</a>
		<a href="<?= site_url('doctor/appointments') ?>" class="menu-item<?= strpos($path,'doctor/appointments')===0 ? ' active' : '' ?>"><span class="menu-icon">📅</span>Appointments</a>
		<a href="<?= site_url('doctor/prescriptions') ?>" class="menu-item<?= strpos($path,'doctor/prescriptions')===0 ? ' active' : '' ?>"><span class="menu-icon">💊</span>Prescriptions</a>
		<a href="<?= site_url('doctor/lab-requests') ?>" class="menu-item<?= strpos($path,'doctor/lab-requests')===0 ? ' active' : '' ?>"><span class="menu-icon">🧪</span>Lab Requests</a>
		<a href="<?= site_url('doctor/consultations') ?>" class="menu-item<?= strpos($path,'doctor/consultations')===0 ? ' active' : '' ?>"><span class="menu-icon">🩺</span>Consultations</a>
		<a href="<?= site_url('doctor/schedule') ?>" class="menu-item<?= strpos($path,'doctor/schedule')===0 ? ' active' : '' ?>"><span class="menu-icon">🗓️</span>My Schedule</a>
		<a href="<?= site_url('doctor/reports') ?>" class="menu-item<?= strpos($path,'doctor/reports')===0 ? ' active' : '' ?>"><span class="menu-icon">📈</span>Medical Reports</a>
	</div>
</nav>


