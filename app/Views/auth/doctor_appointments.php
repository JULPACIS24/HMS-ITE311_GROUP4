<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • Appointments</title>
	<style>
		*{margin:0;padding:0;box-sizing:border-box}
		body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,sans-serif;background:#f5f7fa}
		.container{display:flex;min-height:100vh}
		.sidebar{width:250px;background:linear-gradient(180deg,#2c3e50 0%,#34495e 100%);color:#fff;position:fixed;height:100vh;overflow-y:auto}
		.sidebar-header{padding:20px;border-bottom:1px solid #34495e;display:flex;align-items:center;gap:12px}
		.admin-icon{width:36px;height:36px;border-radius:8px;background:#3498db;display:grid;place-items:center}
		.sidebar-title{font-size:16px;font-weight:700}
		.sidebar-sub{font-size:12px;color:#cbd5e1;margin-top:2px}
		.sidebar-menu{padding:20px 0}
		.menu-item{display:flex;align-items:center;gap:12px;padding:12px 20px;color:#cbd5e1;text-decoration:none;border-left:3px solid transparent}
		.menu-item:hover{background:rgba(255,255,255,.1);color:#fff;border-left-color:#3498db}
		.menu-item.active{background:rgba(52,152,219,.2);color:#fff;border-left-color:#3498db}
		.menu-icon{width:20px;text-align:center}
		.main{flex:1;margin-left:250px}
		.header{background:#fff;padding:18px 24px;box-shadow:0 2px 4px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center}
		.header-left{display:flex;flex-direction:column}
		.header h1{font-size:22px;font-weight:700;color:#2c3e50;margin:0}
		.header .sub{font-size:12px;color:#64748b}
		.actions{display:flex;align-items:center;gap:14px}
		.icon-btn{position:relative;width:34px;height:34px;border-radius:10px;background:#f8fafc;border:1px solid #e5e7eb;display:grid;place-items:center}
		.badge{position:absolute;top:-4px;right:-4px;background:#ef4444;color:#fff;border-radius:999px;font-size:10px;padding:2px 6px;font-weight:700}
		.avatar{width:34px;height:34px;border-radius:50%;background:#2563eb;color:#fff;display:grid;place-items:center;font-weight:800}
		.user-meta{line-height:1.1}
		.user-name{font-weight:700;font-size:13px;color:#0f172a}
		.user-role{font-size:11px;color:#64748b}
		.user-chip{display:flex;align-items:center;gap:10px}

		.page{padding:24px}
		.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
		.kpi{background:#fff;border-radius:12px;padding:18px;box-shadow:0 2px 10px rgba(0,0,0,.08);position:relative}
		.k-title{color:#64748b;font-size:14px}
		.k-value{font-size:28px;font-weight:800;color:#0f172a}
		.k-sub{font-size:12px;color:#16a34a;margin-top:6px}
		.k-icon{position:absolute;right:14px;top:14px;width:34px;height:34px;border-radius:10px;display:grid;place-items:center;color:#fff}
		.i-blue{background:#2563eb}.i-green{background:#10b981}.i-red{background:#ef4444}.i-purple{background:#8b5cf6}

		.card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden}
		.card-header{padding:16px 20px;border-bottom:1px solid #ecf0f1;font-weight:700;display:flex;justify-content:space-between;align-items:center}
		.tabs{display:flex;gap:4px}
		.tab{padding:8px 12px;border-radius:8px;font-size:13px;cursor:pointer;background:#f1f5f9;color:#64748b}
		.tab.active{background:#2563eb;color:#fff}
		.list{padding:20px}
		.appointment-item{display:flex;align-items:center;gap:12px;padding:16px;border-bottom:1px solid #f1f5f9;border-radius:10px;margin-bottom:12px;background:#f8fafc;cursor:default;user-select:none}
		.appointment-item:last-child{border-bottom:none;margin-bottom:0}
		.appointment-item:hover{background:#f8fafc}
		.appointment-avatar{width:40px;height:40px;border-radius:50%;display:grid;place-items:center;font-weight:700;color:#fff}
		.appointment-details{flex:1}
		.appointment-name{font-weight:700;color:#0f172a;margin-bottom:4px}
		.appointment-info{font-size:12px;color:#64748b}
		.appointment-time{font-weight:700;color:#2563eb;font-size:14px}
		.appointment-status{padding:4px 8px;border-radius:999px;font-size:11px;font-weight:700}
		.status-scheduled{background:#eef2ff;color:#2563eb}
		.status-in-progress{background:#fff7ed;color:#f59e0b}
		.status-completed{background:#ecfdf5;color:#16a34a}
		.status-urgent{background:#fef2f2;color:#ef4444}
		.appointment-actions{display:flex;gap:8px}
		.action-btn{padding:6px;border-radius:6px;text-decoration:none;font-size:12px}
		.action-edit{background:#eef2ff;color:#2563eb}
		.action-view{background:#ecfdf5;color:#16a34a}
		.empty-state{text-align:center;padding:60px 20px;color:#64748b}
		.empty-icon{font-size:48px;margin-bottom:16px}
		.empty-title{font-weight:700;color:#0f172a;margin-bottom:8px}
		.empty-subtitle{font-size:14px}
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<div class="main">
			<div class="header">
				<div class="header-left">
					<h1>Appointments</h1>
					<div class="sub">Manage your daily schedule and patient appointments</div>
				</div>
				<div class="actions">
					<div class="notif-wrap" style="position:relative">
						<button class="icon-btn" aria-label="Notifications" id="notifBtn">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5l-2 2v1h16v-1l-2-2Z" stroke="#475569" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
							</svg>
							<span class="badge">3</span>
						</button>
						<div class="notif-pop" id="notifPop" style="display:none; position:absolute; right:0; top:44px; width:320px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); overflow:hidden; z-index:30;">
							<div class="menu-header" style="padding:12px 14px; font-weight:700; border-bottom:1px solid #f1f5f9">Notifications</div>
							<div class="notifs" style="max-height:320px; overflow:auto">
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fecaca; align-items:flex-start; background:#fff7f7"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff0f0">🧪</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">Lab results ready for Patient #1234</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">5 min ago</div></div></div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fde68a; align-items:flex-start"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff7e6">📅</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">New appointment scheduled for 2:00 PM</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">10 min ago</div></div></div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #fecaca; align-items:flex-start; background:#fff7f7"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff0f0">💊</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">Prescription approval needed</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">15 min ago</div></div></div>
								<div class="notif-item" style="display:flex; gap:10px; padding:12px 14px; border-left:4px solid #bae6fd; align-items:flex-start"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#ebf8ff">🔔</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">System maintenance scheduled for tonight</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">1 hour ago</div></div></div>
							</div>
							<div style="text-align:center;padding:10px;border-top:1px solid #f1f5f9;font-size:13px"><a href="#" style="color:#2563eb;text-decoration:none">View All Notifications</a></div>
						</div>
					</div>
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" id="userBtn" style="cursor:pointer">
							<div class="avatar">DR</div>
							<div class="user-meta">
								<div class="user-name"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></div>
								<div class="user-role"><?= session('specialty') ?? session('department') ?? 'Medical' ?></div>
							</div>
						</div>
						<div class="user-pop" id="userPop" style="display:none; position:absolute; right:0; top:44px; width:260px; background:#fff; border:1px solid #e5e7eb; border-radius:12px; box-shadow:0 12px 30px rgba(0,0,0,.12); overflow:hidden; z-index:30;">
							<div style="display:flex; gap:10px; padding:12px 14px; border-bottom:1px solid #f1f5f9"><div style="width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#6366f1;color:#fff;font-weight:800">DR</div><div><div style="font-weight:700"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></div><div style="color:#64748b;font-size:12px"><?= session('specialty') ?? session('department') ?? 'Medical' ?> Department</div><div style="color:#94a3b8;font-size:12px">ID: <?= session('user_id') ?? 'DOC-2024-001' ?></div></div></div>
							<div style="padding:6px 0"><a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">👤 My Profile</a><a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">⚙️ Settings</a><a href="#" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px">🕒 Work Schedule</a></div>
							<div style="border-top:1px solid #f1f5f9"></div>
							<div style="padding:6px 0"><a href="<?= site_url('logout') ?>" class="menu-link" style="display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#ef4444;font-size:14px">🚪 Sign Out</a></div>
						</div>
					</div>
				</div>
			</div>

			<div class="page">
				<div class="kpi-grid">
					<div class="kpi"><div class="k-title">Today's Appointments</div><div class="k-value"><?= $stats['today_appointments'] ?? 0 ?></div><div class="k-sub"><?= ($stats['today_appointments'] ?? 0) - ($stats['completed_today'] ?? 0) ?> remaining</div><div class="k-icon i-blue">📅</div></div>
					<div class="kpi"><div class="k-title">Completed</div><div class="k-value"><?= $stats['completed_today'] ?? 0 ?></div><div class="k-sub" style="color:#16a34a">On schedule</div><div class="k-icon i-green">✅</div></div>
					<div class="kpi"><div class="k-title">Urgent Cases</div><div class="k-value"><?= $stats['urgent_cases'] ?? 0 ?></div><div class="k-sub" style="color:#ef4444">Need attention</div><div class="k-icon i-red">⏰</div></div>
					<div class="kpi"><div class="k-title">Available Slots</div><div class="k-value"><?= $stats['available_slots'] ?? 0 ?></div><div class="k-sub">This afternoon</div><div class="k-icon i-purple">⏲️</div></div>
				</div>

				<div class="card">
					<div class="card-header">
						<span>Appointment Schedule</span>
						<div class="tabs">
							<div class="tab active" id="tabToday">Today</div>
							<div class="tab" id="tabWeek">This Week</div>
							<button id="scheduleApptBtn" style="margin-left:8px;background:#2563eb;color:#fff;border:none;border-radius:10px;padding:8px 12px;font-weight:700;cursor:pointer;">+ Schedule Appointment</button>
						</div>
					</div>
					<div class="list" id="listToday">
						<?php if (!empty($appointments)): ?>
							<?php foreach ($appointments as $appointment): ?>
								<?php 
									// Get initials for avatar
									$nameParts = explode(' ', $appointment['patient_full_name']);
									$initials = '';
									if (count($nameParts) >= 2) {
										$initials = strtoupper(substr($nameParts[0], 0, 1) . substr($nameParts[1], 0, 1));
									} else {
										$initials = strtoupper(substr($appointment['patient_full_name'], 0, 2));
									}
									
									// Determine status class
									$statusClass = 'status-scheduled';
									if ($appointment['status'] === 'In Progress') $statusClass = 'status-in-progress';
									elseif ($appointment['status'] === 'Completed') $statusClass = 'status-completed';
									elseif ($appointment['type'] === 'Emergency' || $appointment['status'] === 'Urgent') $statusClass = 'status-urgent';
									
									// Determine avatar color based on status
									$avatarColor = '#2563eb'; // default blue
									if ($appointment['status'] === 'Completed') $avatarColor = '#16a34a'; // green
									elseif ($appointment['status'] === 'In Progress') $avatarColor = '#f59e0b'; // orange
									elseif ($appointment['type'] === 'Emergency' || $appointment['status'] === 'Urgent') $avatarColor = '#ef4444'; // red
								?>
								<div class="appointment-item">
									<div class="appointment-avatar" style="background: <?= $avatarColor ?>"><?= $initials ?></div>
									<div class="appointment-details">
										<div class="appointment-name"><?= esc($appointment['patient_full_name']) ?></div>
										<div class="appointment-info"><?= esc($appointment['patient_id_formatted']) ?> • <?= esc($appointment['type'] ?? 'Consultation') ?></div>
										<div class="appointment-info"><?= esc($appointment['notes'] ?? 'Regular checkup') ?> • <?= esc($appointment['room_info']) ?></div>
									</div>
									<div class="appointment-time"><?= $appointment['formatted_time'] ?></div>
									<div class="appointment-status <?= $statusClass ?>"><?= esc($appointment['status'] ?? 'Scheduled') ?></div>
									<div class="appointment-actions">
										<a href="<?= site_url('doctor/appointments/edit/' . $appointment['id']) ?>" class="action-btn action-edit" title="Edit Appointment">✏️</a>
										<a href="#" class="action-btn action-view" title="View Details">👁️</a>
										<button onclick="markCompleted(<?= $appointment['id'] ?>)" class="action-btn" style="background:#ecfdf5;color:#16a34a;border:none;cursor:pointer;" title="Mark as Completed">✅</button>
									</div>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<div class="empty-state">
								<div class="empty-icon">📅</div>
								<div class="empty-title">No Appointments Today</div>
								<div class="empty-subtitle">You have no appointments scheduled for today. Enjoy your free time!</div>
							</div>
						<?php endif; ?>
					</div>
					<div class="list" id="listWeek" style="display:none">
						<div class="empty-state">
							<div class="empty-icon">📊</div>
							<div class="empty-title">Weekly View Coming Soon</div>
							<div class="empty-subtitle">This feature will show your appointments for the entire week.</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Schedule New Appointment Modal -->
	<div id="scheduleModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
		<div style="background:#fff; border-radius:16px; width:90%; max-width:800px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
			<div style="padding:24px 32px; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
				<h2 style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">Schedule New Appointment</h2>
				<button id="closeModal" style="background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">×</button>
			</div>
			
			<form id="appointmentForm" style="padding:32px;">
				<div style="display:grid; grid-template-columns:1fr 1fr; gap:24px;">
					<!-- Left Column -->
					<div>
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Patient Name *</label>
							<input type="text" id="patientName" name="patient_name" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
						</div>
						
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Date *</label>
							<input type="date" id="appointmentDate" name="date" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
						</div>
						
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Appointment Type *</label>
							<select id="appointmentType" name="type" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
								<option value="Routine Checkup">Routine Checkup</option>
								<option value="Consultation">Consultation</option>
								<option value="Follow-up">Follow-up</option>
								<option value="Emergency">Emergency</option>
								<option value="Surgery">Surgery</option>
							</select>
						</div>
						
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Room *</label>
							<select id="room" name="room" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
								<option value="Room 201">Room 201</option>
								<option value="Room 202">Room 202</option>
								<option value="Room 203">Room 203</option>
								<option value="Room 101">Room 101</option>
								<option value="Room 102">Room 102</option>
								<option value="Emergency Room">Emergency Room</option>
								<option value="Consultation Room A">Consultation Room A</option>
								<option value="Consultation Room B">Consultation Room B</option>
							</select>
						</div>
						
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Notes</label>
							<textarea id="notes" name="notes" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; resize:vertical;" placeholder="Additional notes..."></textarea>
						</div>
					</div>
					
					<!-- Right Column -->
					<div>
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Patient ID *</label>
							<input type="text" id="patientId" name="patient_id" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
						</div>
						
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Time *</label>
							<select id="appointmentTime" name="time" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
								<option value="08:00">8:00 AM</option>
								<option value="08:30">8:30 AM</option>
								<option value="09:00">9:00 AM</option>
								<option value="09:30">9:30 AM</option>
								<option value="10:00">10:00 AM</option>
								<option value="10:30">10:30 AM</option>
								<option value="11:00">11:00 AM</option>
								<option value="11:30">11:30 AM</option>
								<option value="13:00">1:00 PM</option>
								<option value="13:30">1:30 PM</option>
								<option value="14:00">2:00 PM</option>
								<option value="14:30">2:30 PM</option>
								<option value="15:00">3:00 PM</option>
								<option value="15:30">3:30 PM</option>
								<option value="16:00">4:00 PM</option>
								<option value="16:30">4:30 PM</option>
							</select>
						</div>
						
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Duration *</label>
							<select id="duration" name="duration" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
								<option value="30">30 minutes</option>
								<option value="45">45 minutes</option>
								<option value="60">1 hour</option>
								<option value="90">1.5 hours</option>
								<option value="120">2 hours</option>
							</select>
						</div>
						
						<div style="margin-bottom:20px;">
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Priority *</label>
							<select id="priority" name="priority" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
								<option value="Normal">Normal</option>
								<option value="High">High</option>
								<option value="Urgent">Urgent</option>
								<option value="Emergency">Emergency</option>
							</select>
						</div>
					</div>
				</div>
				
				<div style="display:flex; gap:12px; justify-content:flex-end; margin-top:32px; padding-top:24px; border-top:1px solid #e5e7eb;">
					<button type="button" id="cancelBtn" style="padding:12px 24px; background:#f3f4f6; color:#374151; border:1px solid #d1d5db; border-radius:8px; font-weight:600; cursor:pointer;">Cancel</button>
					<button type="submit" style="padding:12px 24px; background:#2563eb; color:#fff; border:none; border-radius:8px; font-weight:600; cursor:pointer;">Schedule Appointment</button>
				</div>
			</form>
		</div>
	</div>

	<script>
	(function(){
		// Toggle notification popup
		const nbtn = document.getElementById('notifBtn');
		const npop = document.getElementById('notifPop');
		function hideN(){ if(npop) npop.style.display='none'; }
		if(nbtn && npop){
			nbtn.addEventListener('click', (e)=>{ e.stopPropagation(); npop.style.display = (npop.style.display==='none'||npop.style.display==='')?'block':'none'; });
			document.addEventListener('click', ()=> hideN());
		}
		
		// Toggle user popup
		const ubtn = document.getElementById('userBtn');
		const upop = document.getElementById('userPop');
		function hideU(){ if(upop) upop.style.display='none'; }
		if(ubtn && upop){
			ubtn.addEventListener('click', (e)=>{ e.stopPropagation(); upop.style.display = (upop.style.display==='none'||upop.style.display==='')?'block':'none'; });
			document.addEventListener('click', ()=> hideU());
		}
		
		// Tab switching
		const tabToday = document.getElementById('tabToday');
		const tabWeek = document.getElementById('tabWeek');
		const listToday = document.getElementById('listToday');
		const listWeek = document.getElementById('listWeek');
		
		if(tabToday && tabWeek && listToday && listWeek){
			tabToday.addEventListener('click', () => {
				tabToday.classList.add('active');
				tabWeek.classList.remove('active');
				listToday.style.display = 'block';
				listWeek.style.display = 'none';
			});
			
			tabWeek.addEventListener('click', () => {
				tabWeek.classList.add('active');
				tabToday.classList.remove('active');
				listWeek.style.display = 'block';
				listToday.style.display = 'none';
			});
		}
		
		// Function to mark appointment as completed
		function markCompleted(appointmentId) {
			if (confirm('Mark this appointment as completed?')) {
				fetch(`<?= site_url('doctor/appointments/complete') ?>/${appointmentId}`, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					}
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						alert('Appointment marked as completed!');
						location.reload(); // Refresh the page to show updated status
					} else {
						alert('Error: ' + data.message);
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('Error updating appointment status.');
				});
			}
		}
		
		// Schedule Appointment Modal Functions
		const scheduleBtn = document.getElementById('scheduleApptBtn');
		const scheduleModal = document.getElementById('scheduleModal');
		const closeModal = document.getElementById('closeModal');
		const cancelBtn = document.getElementById('cancelBtn');
		const appointmentForm = document.getElementById('appointmentForm');
		
		// Set default date to today
		document.getElementById('appointmentDate').value = new Date().toISOString().split('T')[0];
		
		// Open modal - only when schedule button is clicked
		scheduleBtn.addEventListener('click', (e) => {
			e.preventDefault();
			e.stopPropagation();
			scheduleModal.style.display = 'flex';
			scheduleModal.style.alignItems = 'center';
			scheduleModal.style.justifyContent = 'center';
		});
		
		// Close modal functions
		function closeScheduleModal() {
			scheduleModal.style.display = 'none';
			appointmentForm.reset();
		}
		
		closeModal.addEventListener('click', closeScheduleModal);
		cancelBtn.addEventListener('click', closeScheduleModal);
		
		// Close modal when clicking outside
		scheduleModal.addEventListener('click', (e) => {
			if (e.target === scheduleModal) {
				closeScheduleModal();
			}
		});
		
		// Handle form submission
		appointmentForm.addEventListener('submit', (e) => {
			e.preventDefault();
			
			const formData = new FormData(appointmentForm);
			
			// Add doctor information
			formData.append('doctor_id', '<?= session('user_id') ?? '' ?>');
			formData.append('doctor_name', '<?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?>');
			formData.append('status', 'Scheduled');
			
			// Send to backend
			fetch('<?= site_url('doctor/appointments/create') ?>', {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					alert('Appointment scheduled successfully!');
					closeScheduleModal();
					location.reload(); // Refresh to show new appointment
				} else {
					alert('Error: ' + (data.message || 'Failed to schedule appointment'));
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error scheduling appointment. Please try again.');
			});
		});
		
		// Prevent clicks on appointment items from triggering any actions
		document.querySelectorAll('.appointment-item').forEach(item => {
			item.addEventListener('click', (e) => {
				// Only allow clicks on action buttons, prevent clicks on the item itself
				if (!e.target.closest('.appointment-actions')) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();
					return false;
				}
			});
			
			// Also prevent any mouse events
			item.addEventListener('mousedown', (e) => {
				if (!e.target.closest('.appointment-actions')) {
					e.preventDefault();
					e.stopPropagation();
					e.stopImmediatePropagation();
					return false;
				}
			});
		});
	})();
	</script>
</body>
</html>

