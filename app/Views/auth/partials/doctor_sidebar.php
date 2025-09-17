<?php $path = (string) current_url(true)->getPath(); ?>
<nav class="sidebar">
	<div class="sidebar-header">
		<div class="admin-icon">🏥</div>
		<div style="display:flex;flex-direction:column">
			<span class="sidebar-title"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></span>
			<span class="sidebar-sub"><?= session('specialty') ?? session('department') ?? 'Medical' ?></span>
		</div>
	</div>
	<div class="sidebar-menu">
		<a href="http://localhost/HMS-ITE311_GROUP4/doctor" class="menu-item<?= $path === 'doctor' ? ' active' : '' ?>"><span class="menu-icon">📊</span>Dashboard</a>
		<a href="http://localhost/HMS-ITE311_GROUP4/doctor/patients" class="menu-item<?= strpos($path,'doctor/patients')===0 ? ' active' : '' ?>"><span class="menu-icon">📁</span>Patient Records</a>
		<a href="http://localhost/HMS-ITE311_GROUP4/doctor/appointments" class="menu-item <?= strpos(current_url(), '/doctor/appointments') !== false ? 'active' : '' ?>">
			<div class="menu-icon">📅</div>
			<div>Appointments</div>
		</a>
		<a href="http://localhost/HMS-ITE311_GROUP4/doctor/prescriptions" class="menu-item <?= strpos(current_url(), '/doctor/prescriptions') !== false ? 'active' : '' ?>">
			<div class="menu-icon">💊</div>
			<div>Prescriptions</div>
		</a>
		<a href="http://localhost/HMS-ITE311_GROUP4/doctor/lab-requests" class="menu-item <?= strpos(current_url(), '/doctor/lab-requests') !== false ? 'active' : '' ?>">
			<div class="menu-icon">🧪</div>
			<div>Lab Requests</div>
		</a>
			<a href="http://localhost/HMS-ITE311_GROUP4/doctor/consultations" class="menu-item<?= strpos($path,'doctor/consultations')===0 ? ' active' : '' ?>"><span class="menu-icon">🩺</span>Consultations</a>
		<a href="http://localhost/HMS-ITE311_GROUP4/doctor/medical-certificates" class="menu-item <?= strpos(current_url(), '/doctor/medical-certificates') !== false ? 'active' : '' ?>">
			<div class="menu-icon">📋</div>
			<div>Medical Reports</div>
		</a>
		<a href="http://localhost/HMS-ITE311_GROUP4/unified-scheduling/doctor" class="menu-item<?= strpos($path,'unified-scheduling/doctor')===0 ? ' active' : '' ?>"><span class="menu-icon">🗓️</span>My Schedule</a>
	</div>
</nav>


