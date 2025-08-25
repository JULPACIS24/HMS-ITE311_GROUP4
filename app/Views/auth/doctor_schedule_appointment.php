<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • Schedule Appointment</title>
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
		.grid{display:grid;grid-template-columns:1fr 1fr;gap:24px}
		.card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden}
		.card-header{padding:16px 20px;border-bottom:1px solid #ecf0f1;font-weight:700}
		.card-body{padding:20px}
		.form-group{margin-bottom:20px}
		.form-label{display:block;margin-bottom:8px;font-weight:600;color:#374151}
		.form-input{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px}
		.form-input:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
		.form-select{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;background:#fff}
		.form-textarea{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;min-height:100px;resize:vertical}
		.btn{display:inline-block;padding:12px 24px;border:none;border-radius:8px;font-weight:600;text-decoration:none;cursor:pointer;font-size:14px}
		.btn-primary{background:#2563eb;color:#fff}
		.btn-secondary{background:#6b7280;color:#fff;margin-right:12px}
		.btn:hover{opacity:0.9}
		
		/* Calendar Styles */
		.calendar{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden}
		.calendar-header{padding:16px 20px;border-bottom:1px solid #ecf0f1;display:flex;justify-content:space-between;align-items:center}
		.calendar-nav{display:flex;gap:8px}
		.calendar-nav-btn{padding:8px 12px;border:1px solid #d1d5db;border-radius:6px;background:#fff;cursor:pointer}
		.calendar-nav-btn:hover{background:#f9fafb}
		.calendar-title{font-weight:700;font-size:16px}
		.calendar-grid{display:grid;grid-template-columns:repeat(7,1fr)}
		.calendar-day-header{padding:12px 8px;text-align:center;font-weight:600;color:#374151;background:#f9fafb;border-bottom:1px solid #e5e7eb}
		.calendar-day{padding:12px 8px;text-align:center;border-bottom:1px solid #f3f4f6;cursor:pointer;min-height:60px;display:flex;flex-direction:column;justify-content:center}
		.calendar-day:hover{background:#f9fafb}
		.calendar-day.other-month{color:#9ca3af}
		.calendar-day.today{background:#eff6ff;color:#1d4ed8;font-weight:600}
		.calendar-day.selected{background:#2563eb;color:#fff;font-weight:600}
		.calendar-day.busy{background:#fef2f2;color:#dc2626;position:relative}
		.calendar-day.busy::after{content:'';position:absolute;top:4px;right:4px;width:6px;height:6px;background:#dc2626;border-radius:50%}
		.calendar-day.free{background:#ecfdf5;color:#059669}
		
		.time-slots{margin-top:16px}
		.time-slot{padding:8px 12px;margin:4px 0;border-radius:6px;cursor:pointer;font-size:14px}
		.time-slot.available{background:#ecfdf5;color:#059669;border:1px solid #a7f3d0}
		.time-slot.available:hover{background:#d1fae5}
		.time-slot.busy{background:#fef2f2;color:#dc2626;border:1px solid #fecaca;cursor:not-allowed}
		.time-slot.selected{background:#2563eb;color:#fff;border:1px solid #2563eb}
		
		.alert{padding:12px 16px;border-radius:8px;margin-bottom:20px}
		.alert-success{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
		.alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<div class="main">
			<div class="header">
				<div class="header-left">
					<h1>Schedule Appointment</h1>
					<div class="sub">Select patient, date, and time for new appointment</div>
				</div>
				<div class="actions">
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" id="userBtn" style="cursor:pointer">
							<div class="avatar">DR</div>
							<div class="user-meta">
								<div class="user-name"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></div>
								<div class="user-role"><?= session('specialty') ?? session('department') ?? 'Medical' ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="page">
				<?php if (session('error')): ?>
					<div class="alert alert-error"><?= session('error') ?></div>
				<?php endif; ?>
				
				<?php if (session('message')): ?>
					<div class="alert alert-success"><?= session('message') ?></div>
				<?php endif; ?>

				<div class="grid">
					<!-- Appointment Form -->
					<div class="card">
						<div class="card-header">New Appointment Details</div>
						<div class="card-body">
							<form method="post" action="<?= site_url('doctor/appointments/create') ?>">
								<div class="form-group">
									<label class="form-label">Patient</label>
									<select name="patient_id" class="form-select" required>
										<option value="">Select Patient</option>
										<?php foreach ($patients as $patient): ?>
											<option value="<?= $patient['id'] ?>">
												<?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?>
											</option>
										<?php endforeach; ?>
									</select>
								</div>

								<div class="form-group">
									<label class="form-label">Date</label>
									<input type="date" name="date" id="selectedDate" class="form-input" required>
								</div>

								<div class="form-group">
									<label class="form-label">Time</label>
									<select name="time" id="selectedTime" class="form-select" required>
										<option value="">Select Time</option>
									</select>
								</div>

								<div class="form-group">
									<label class="form-label">Appointment Type</label>
									<select name="type" class="form-select" required>
										<option value="">Select Type</option>
										<option value="Consultation">Consultation</option>
										<option value="Follow-up">Follow-up</option>
										<option value="Checkup">Checkup</option>
										<option value="Emergency">Emergency</option>
									</select>
								</div>

								<div class="form-group">
									<label class="form-label">Room</label>
									<input type="text" name="room" class="form-input" placeholder="Enter room number">
								</div>

								<div class="form-group">
									<label class="form-label">Notes</label>
									<textarea name="notes" class="form-textarea" placeholder="Enter appointment notes"></textarea>
								</div>

								<div style="text-align:right">
									<a href="<?= site_url('doctor/appointments') ?>" class="btn btn-secondary">Cancel</a>
									<button type="submit" class="btn btn-primary">Schedule Appointment</button>
								</div>
							</form>
						</div>
					</div>

					<!-- Calendar -->
					<div class="calendar">
						<div class="calendar-header">
							<div class="calendar-nav">
								<button class="calendar-nav-btn" onclick="previousMonth()">‹</button>
								<button class="calendar-nav-btn" onclick="nextMonth()">›</button>
							</div>
							<div class="calendar-title" id="calendarTitle">August 2025</div>
						</div>
						<div class="calendar-grid" id="calendarGrid">
							<!-- Calendar will be generated by JavaScript -->
						</div>
						<div class="time-slots" id="timeSlots">
							<!-- Time slots will be generated by JavaScript -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		let currentDate = new Date();
		let selectedDate = null;
		let selectedTime = null;
		
		// Available time slots (9 AM to 5 PM, 30-minute intervals)
		const timeSlots = [
			'09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
			'12:00', '12:30', '13:00', '13:30', '14:00', '14:30',
			'15:00', '15:30', '16:00', '16:30', '17:00'
		];
		
		// Existing appointments data from PHP
		const existingAppointments = <?= json_encode($existingAppointments) ?>;
		
		function generateCalendar() {
			const year = currentDate.getFullYear();
			const month = currentDate.getMonth();
			
			// Update calendar title
			document.getElementById('calendarTitle').textContent = 
				new Date(year, month).toLocaleDateString('en-US', { month: 'long', year: 'numeric' });
			
			const firstDay = new Date(year, month, 1);
			const lastDay = new Date(year, month + 1, 0);
			const startDate = new Date(firstDay);
			startDate.setDate(startDate.getDate() - firstDay.getDay());
			
			let calendarHTML = '';
			
			// Day headers
			const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
			days.forEach(day => {
				calendarHTML += `<div class="calendar-day-header">${day}</div>`;
			});
			
			// Calendar days
			for (let i = 0; i < 42; i++) {
				const date = new Date(startDate);
				date.setDate(startDate.getDate() + i);
				
				const isCurrentMonth = date.getMonth() === month;
				const isToday = date.toDateString() === new Date().toDateString();
				const isSelected = selectedDate && date.toDateString() === selectedDate.toDateString();
				
				// Check if date has appointments
				const dateStr = date.toISOString().split('T')[0];
				const dayAppointments = existingAppointments.filter(apt => 
					apt.date_time && apt.date_time.startsWith(dateStr)
				);
				
				let dayClass = 'calendar-day';
				if (!isCurrentMonth) dayClass += ' other-month';
				if (isToday) dayClass += ' today';
				if (isSelected) dayClass += ' selected';
				if (dayAppointments.length > 0) dayClass += ' busy';
				if (isCurrentMonth && dayAppointments.length === 0) dayClass += ' free';
				
				calendarHTML += `
					<div class="${dayClass}" onclick="selectDate('${dateStr}')">
						${date.getDate()}
						${dayAppointments.length > 0 ? `<small style="font-size:10px;display:block;">${dayAppointments.length} apt</small>` : ''}
					</div>
				`;
			}
			
			document.getElementById('calendarGrid').innerHTML = calendarHTML;
		}
		
		function selectDate(dateStr) {
			selectedDate = new Date(dateStr);
			document.getElementById('selectedDate').value = dateStr;
			generateTimeSlots(dateStr);
			generateCalendar(); // Refresh to show selection
		}
		
		function generateTimeSlots(dateStr) {
			const dayAppointments = existingAppointments.filter(apt => 
				apt.date_time && apt.date_time.startsWith(dateStr)
			);
			
			const bookedTimes = dayAppointments.map(apt => {
				const time = new Date(apt.date_time);
				return time.getHours().toString().padStart(2, '0') + ':' + 
					   time.getMinutes().toString().padStart(2, '0');
			});
			
			let timeSlotsHTML = '<h4 style="margin-bottom:12px;">Available Times</h4>';
			
			timeSlots.forEach(time => {
				const isBooked = bookedTimes.includes(time);
				const isSelected = selectedTime === time;
				
				let slotClass = 'time-slot';
				if (isBooked) {
					slotClass += ' busy';
				} else if (isSelected) {
					slotClass += ' selected';
				} else {
					slotClass += ' available';
				}
				
				timeSlotsHTML += `
					<div class="${slotClass}" onclick="${!isBooked ? `selectTime('${time}')` : ''}">
						${time}
						${isBooked ? ' (Booked)' : ''}
					</div>
				`;
			});
			
			document.getElementById('timeSlots').innerHTML = timeSlotsHTML;
		}
		
		function selectTime(time) {
			selectedTime = time;
			document.getElementById('selectedTime').value = time;
			generateTimeSlots(selectedDate.toISOString().split('T')[0]);
		}
		
		function previousMonth() {
			currentDate.setMonth(currentDate.getMonth() - 1);
			generateCalendar();
		}
		
		function nextMonth() {
			currentDate.setMonth(currentDate.getMonth() + 1);
			generateCalendar();
		}
		
		// Initialize calendar
		generateCalendar();
		
		// Set today as default selected date
		const today = new Date().toISOString().split('T')[0];
		selectDate(today);
	</script>
</body>
</html>
