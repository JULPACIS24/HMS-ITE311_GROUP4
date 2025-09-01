<?php echo view('auth/partials/header', ['title' => 'Doctor Scheduling']); ?>
<div class="container">
	<?php echo view('auth/partials/sidebar'); ?>
	<main class="main-content">
		<header class="header">
			<h1>Doctor Scheduling</h1>
			<div class="user-info" style="gap:12px">
				<a class="btn" href="<?= site_url('patients/create') ?>">Register Patient</a>
				<a class="btn" href="<?= site_url('scheduling-management') ?>">Back to Scheduling</a>
				<a class="btn primary" href="#" id="addApptBtn">+ Add Appointment</a>
			</div>
		</header>
		<div class="page-content" style="display:grid; grid-template-columns:360px 1fr; gap:18px;">
			<!-- Left: Doctor list -->
			<div class="patients-table-container">
				<div class="table-header"><h2 class="table-title">Doctors</h2></div>
				<div id="doctorList" style="padding:10px 0">
					<?php if (!empty($doctors)): ?>
						<?php foreach ($doctors as $doctor): ?>
							<div class="doc-item" data-id="<?= $doctor['id'] ?>" style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-left:3px solid transparent; cursor:pointer; border-bottom:1px solid #ecf0f1">
								<div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:grid;place-items:center;color:#2563eb;font-weight:800">
									<?= esc(strtoupper(substr($doctor['name'] ?? 'D', 0, 1))) ?>
								</div>
								<div style="flex:1">
									<div style="font-weight:700;color:#0f172a"><?= esc($doctor['name'] ?? 'Unknown Doctor') ?></div>
									<div class="sub">
										<?= esc($doctor['specialty'] ?? 'General Medicine') ?>
									</div>
								</div>
						<span class="badge completed">Available</span>
					</div>
						<?php endforeach; ?>
					<?php else: ?>
						<div style="text-align:center; padding:20px; color:#94a3b8">
							<div style="font-size:24px">👥</div>
							<div style="font-weight:600; margin-top:8px">No Doctors Found</div>
							<div class="sub">Add doctors in Staff Management first</div>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<!-- Right: Doctor details + schedule -->
			<div class="patients-table-container" id="detailPanel" style="min-height:420px">
				<!-- Filled by JS -->
				<div style="display:grid; place-items:center; height:100%">
					<div style="text-align:center; color:#94a3b8"><div style="font-size:52px">👥</div><div style="font-weight:700; color:#0f172a; margin-top:6px">Select a Doctor</div><div class="sub">Choose a doctor from the list to view their schedule</div></div>
				</div>
			</div>
		</div>
	</main>
</div>

<!-- Add Appointment Modal -->
<div class="modal" id="addApptModal" aria-hidden="true">
	<div class="modal-backdrop" data-close="addApptModal"></div>
	<div class="modal-dialog" style="max-width:620px">
		<div class="modal-header"><h3>Add Appointment</h3><button class="modal-close" data-close="addApptModal">×</button></div>
		<form id="apptForm">
			<div class="modal-body">
						<label><span>Patient Name *</span>
			<select name="patient_id" required>
				<option value="">Select Patient</option>
				<option value="" disabled>Loading patients...</option>
			</select>
		</label>
				<div class="grid-2 modal-grid">
					<label><span>Appointment Type</span>
						<select name="type" required>
							<option>Consultation</option>
							<option>Follow-up</option>
							<option>Checkup</option>
							<option>Emergency</option>
						</select>
					</label>
					<label><span>Status</span>
						<select name="status" required>
							<option selected>Pending</option>
							<option>Confirmed</option>
							<option>Completed</option>
						</select>
					</label>
				</div>
				<div class="grid-2 modal-grid">
					<label><span>Date</span><input type="date" name="date" required></label>
					<label><span>Time</span><input type="time" name="time" required></label>
				</div>
				<div class="grid-2 modal-grid">
					<label><span>Room</span>
						<select name="room" required>
							<option value="">Select Room</option>
							<option value="Room 101">Room 101</option>
							<option value="Room 102">Room 102</option>
							<option value="Room 103">Room 103</option>
							<option value="Room 201">Room 201</option>
							<option value="Room 202">Room 202</option>
							<option value="Room 203">Room 203</option>
							<option value="Emergency Room">Emergency Room</option>
							<option value="Consultation Room A">Consultation Room A</option>
							<option value="Consultation Room B">Consultation Room B</option>
							<option value="Surgery Room 1">Surgery Room 1</option>
							<option value="Surgery Room 2">Surgery Room 2</option>
						</select>
					</label>
					<label><span>Notes</span><textarea name="notes" placeholder="Additional notes..."></textarea></label>
				</div>
				<input type="hidden" name="doctor_name" value="On Duty Doctor">
			</div>
			<div class="modal-footer"><button class="btn" type="button" data-close="addApptModal">Cancel</button><button class="btn primary" type="submit">Add Appointment</button></div>
		</form>
	</div>
</div>

<script>
(function(){
	const addApptBtn = document.getElementById('addApptBtn');
	const apptModal = document.getElementById('addApptModal');
	let selectedDate = new Date();
	// Set to today's date at midnight (start of day)
	selectedDate.setHours(0, 0, 0, 0);
	let currentDoctorKey = null;
	function openAppt(){ 
		// Set the current doctor's name in the hidden field
		if (currentDoctorKey && doctors[currentDoctorKey]) {
			document.querySelector('[name="doctor_name"]').value = doctors[currentDoctorKey].name;
			
			// Load available patients for this doctor and date
			loadAvailablePatients(currentDoctorKey, selectedDate);
		}
		apptModal.classList.add('open'); 
	}
	function closeAppt(){ apptModal.classList.remove('open'); }
	addApptBtn?.addEventListener('click', (e)=>{ e.preventDefault(); openAppt(); });
	document.querySelectorAll('[data-close="addApptModal"]').forEach(el=>el.addEventListener('click', closeAppt));
	document.getElementById('apptForm')?.addEventListener('submit', function(ev){
		ev.preventDefault();
		
		if (!currentDoctorKey || !doctors[currentDoctorKey]) {
			alert('Please select a doctor first');
			return;
		}
		
			const f = ev.target;
		const formData = new FormData(f);
		
		// Set the doctor name in the hidden field
		formData.set('doctor_name', doctors[currentDoctorKey].name);
		
		// Send AJAX request to create appointment
		fetch('<?= site_url('scheduling/createAppointment') ?>', {
			method: 'POST',
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			console.log('Appointment creation response:', data);
			if (data.success) {
				// Reload appointments from database
				loadDoctorAppointments(currentDoctorKey);
				closeAppt();
				// Reset form
				f.reset();
				alert('Appointment created successfully!');
			} else {
				alert('Error: ' + data.message);
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error creating appointment. Please try again.');
		});
	});

	// Dynamic doctor data based on real doctors from database
	const doctors = {};
	
	// Get real doctor data from PHP
	<?php if (!empty($doctors)): ?>
		<?php foreach ($doctors as $doctor): ?>
			doctors[<?= $doctor['id'] ?? '0' ?>] = {
				name: '<?= esc($doctor['name'] ?? 'Unknown Doctor') ?>',
				dept: '<?= esc($doctor['specialty'] ?? 'General Medicine') ?>',
				email: '<?= esc($doctor['email'] ?? '') ?>',
				date: new Date().toLocaleDateString(),
				appointments: [], // Will be populated from database
				weekly: [0,0,0,0,0,0,0] // Will be calculated from appointments
			};
		<?php endforeach; ?>
	<?php endif; ?>

	// Don't load appointments here - let loadDoctorAppointments handle it
	// This prevents duplicates

	// Calculate weekly counts for each doctor
	Object.keys(doctors).forEach(doctorId => {
		const doctor = doctors[doctorId];
		doctor.weekly = [0,0,0,0,0,0,0]; // Reset weekly counts
		
		doctor.appointments.forEach(appointment => {
			const appointmentDate = new Date(appointment.date);
			const dayOfWeek = appointmentDate.getDay(); // 0 = Sunday, 1 = Monday, etc.
			doctor.weekly[dayOfWeek]++;
		});
	});

	// Function to load available patients (those without appointments for the selected doctor and date)
	function loadAvailablePatients(doctorId, date) {
		if (!doctorId || !doctors[doctorId]) return;
		
		const currentDate = date ? new Date(date).toISOString().slice(0, 10) : new Date().toISOString().slice(0, 10);
		
		fetch(`<?= site_url('scheduling/getAvailablePatients') ?>/${doctorId}/${currentDate}`)
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					// Update the patient dropdown
					const patientSelect = document.querySelector('#addApptModal select[name="patient_id"]');
					if (patientSelect) {
						// Clear existing options except the first one
						patientSelect.innerHTML = '<option value="">Select Patient</option>';
						
						// Add available patients
						data.patients.forEach(patient => {
							const option = document.createElement('option');
							option.value = patient.id; // Use patient ID as value
							option.textContent = (patient.first_name || 'Unknown') + ' ' + (patient.last_name || 'Patient');
							if (patient.phone) {
								option.textContent += ' (' + patient.phone + ')';
							}
							patientSelect.appendChild(option);
						});
						
						// If no available patients, show message
						if (data.patients.length === 0) {
							const option = document.createElement('option');
							option.value = "";
							option.disabled = true;
							option.textContent = "No available patients for this date";
							patientSelect.appendChild(option);
						}
					}
				}
			})
			.catch(error => {
				console.error('Error loading available patients:', error);
			});
	}

	// Function to load appointments from database for a specific doctor
	function loadDoctorAppointments(doctorId) {
		if (!doctorId || !doctors[doctorId]) return;
		
		const doctor = doctors[doctorId];
		// Use selectedDate instead of current date
		const currentDate = selectedDate.toISOString().slice(0, 10);
		
		console.log('Loading appointments for doctor:', doctorId, 'on date:', currentDate);
		console.log('selectedDate object:', selectedDate);
		console.log('selectedDate ISO string:', selectedDate.toISOString());
		
		fetch(`<?= site_url('scheduling/getDoctorAppointments') ?>/${doctorId}/${currentDate}`)
			.then(response => response.json())
			.then(data => {
				console.log('Appointment data received:', data);
				if (data.success) {
					// Clear existing appointments
					doctor.appointments = [];
					
					// Add appointments from database
					data.appointments.forEach(appointment => {
						console.log('Processing appointment:', appointment);
						const appointmentTime = new Date(appointment.date_time);
						const appointmentDate = appointmentTime.toLocaleDateString();
						
						doctor.appointments.push({
							id: appointment.id,
							time: appointmentTime.toTimeString().slice(0, 5),
							patient: appointment.patient_name || 'Unknown Patient',
							type: appointment.type || 'Consultation',
							status: appointment.status || 'Pending',
							room: appointment.room || 'No Room',
							date: appointmentDate
						});
					});
					
					console.log('Processed appointments:', doctor.appointments);
					
					// Recalculate weekly counts
					doctor.weekly = [0,0,0,0,0,0,0];
					doctor.appointments.forEach(appointment => {
						const appointmentDate = new Date(appointment.date);
						const dayOfWeek = appointmentDate.getDay();
						doctor.weekly[dayOfWeek]++;
					});
					
					// Update the display
					renderDetail(doctorId);
				}
			})
			.catch(error => {
				console.error('Error loading appointments:', error);
			});
	}

			// Function to open edit modal with appointment data
		function openEditModal(appointmentId) {
			// Find the appointment in the current doctor's appointments
			const doctor = doctors[currentDoctorKey];
			if (!doctor) return;
			
			const appointment = doctor.appointments.find(apt => apt.id == appointmentId);
			if (appointment) {
				// Populate edit form
				document.getElementById('eaPatient').value = appointment.patient || '';
				document.getElementById('eaDoctor').value = doctor.name || '';
				document.getElementById('eaDate').value = new Date(selectedDate).toISOString().slice(0, 10);
				document.getElementById('eaTime').value = appointment.time || '';
				document.getElementById('eaType').value = appointment.type || 'Consultation';
				document.getElementById('eaStatus').value = appointment.status || 'Pending';
				document.getElementById('eaRoom').value = appointment.room || 'Room 101';
				document.getElementById('eaNotes').value = ''; // Notes not stored in frontend object
				
				// Set form action for update
				document.getElementById('editApptForm').setAttribute('data-appointment-id', appointmentId);
				
				// Open modal
				document.getElementById('editApptModal').classList.add('open');
			}
		}

	// Function to delete appointment
	function deleteAppointment(appointmentId) {
		fetch(`<?= site_url('scheduling/deleteAppointment') ?>/${appointmentId}`, {
			method: 'POST'
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				// Reload appointments from database
				loadDoctorAppointments(currentDoctorKey);
				alert('Appointment deleted successfully!');
			} else {
				alert('Error: ' + data.message);
			}
		})
		.catch(error => {
			console.error('Error deleting appointment:', error);
			alert('Error deleting appointment. Please try again.');
		});
	}

	function badgeClass(status){
		switch((status||'').toLowerCase()){
			case 'confirmed': return 'completed';
			case 'pending': return 'pending';
			case 'urgent': return '';
			default: return '';
		}
	}

	function renderDetail(id){
		const d = doctors[id];
		if(!d) return;
		currentDoctorKey = id;

		console.log('Rendering detail for doctor:', id, 'with appointments:', d.appointments);

		const panel = document.getElementById('detailPanel');
		panel.innerHTML = `
			<div style=\"padding:16px 18px; border-bottom:1px solid #ecf0f1; display:flex; align-items:center; gap:12px\">
				<div style=\"width:42px;height:42px;border-radius:12px;background:#eef2ff;display:grid;place-items:center;color:#2563eb;font-weight:800\">👤</div>
				<div style=\"flex:1\"><div style=\"font-weight:800;color:#0f172a\">${d.name}</div><div class=\"sub\">${d.dept}</div><div class=\"sub\">${d.email}</div></div>
				<div style=\"display:flex; gap:8px; align-items:center; position:relative\">
					<button class=\"btn primary\" type=\"button\" id=\"btnDay\">Day</button>
					<button class=\"btn\" type=\"button\" id=\"btnWeek\">Week</button>
					<button class=\"btn\" id=\"openCalendar\" type=\"button\">📅 ${new Date(selectedDate).toLocaleDateString()} </button>
					<div id=\"calendarPopover\" style=\"position:absolute; top:42px; right:0; background:#fff; border:1px solid #e5e7eb; border-radius:10px; box-shadow:0 10px 30px rgba(0,0,0,.1); width:280px; padding:10px; display:none; z-index:50\"></div>
				</div>
			</div>
			<div style=\"padding:16px 18px\">
				<div id=\"daySection\" style=\"display:block\">
					<div style=\"display:flex; align-items:center; justify-content:space-between; margin-bottom:10px\">
						<div class=\"sub\" id=\"scheduleFor\">Schedule for ${new Date(selectedDate).toLocaleDateString(undefined,{weekday:'long', month:'long', day:'numeric', year:'numeric'})}</div>
						<div class=\"sub\" id=\"apptCount\">${d.appointments.length} appointments scheduled</div>
					</div>
					${d.appointments.length? d.appointments.map((ap, i)=>`
						<div style=\"border-left:4px solid ${ap.status==='Pending'?'#f59e0b': ap.status==='Urgent'?'#ef4444':'#22c55e'}; background:${ap.status==='Pending'?'#fff7ed': ap.status==='Urgent'?'#fef2f2':'#ecfdf5'}; padding:12px 14px; border-radius:10px; display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:10px\">
							<div style=\"width:120px;color:#475569\">${ap.time}</div>
							<div style=\"flex:1\"><div style=\"font-weight:700;color:#0f172a\">${ap.patient}</div><div class=\"sub\">${ap.type} • ${ap.room || 'No Room'}</div></div>
							<div><span class=\"badge ${badgeClass(ap.status)}\">${ap.status}</span></div>
							<div class=\"actions\" data-appt-id=\"${ap.id||''}\" data-index=\"${i}\"><a class=\"btn edit\" href=\"#\">✏️</a> <a class=\"btn delete\" href=\"#\">🗑️</a></div>
						</div>
					`).join('') : `
						<div style=\"text-align:center; color:#94a3b8; padding:40px 0\">
							<div style=\"font-size:48px\">📅</div>
							<div style=\"font-weight:700; color:#0f172a; margin-top:6px\">No Appointments Scheduled</div>
							<div class=\"sub\">This doctor has no appointments for the selected date</div>
							<div style=\"margin-top:12px\"><a class=\"btn primary\" href=\"#\" id=\"inlineAddAppt\">+ Add Appointment</a></div>
						</div>
					`}
				</div>
				<div id=\"weekSection\" style=\"display:none\">
					<div class=\"sub\" style=\"margin-bottom:10px\">Weekly Overview</div>
					<div style=\"display:grid; grid-template-columns:repeat(7,1fr); gap:10px\" id=\"weekGrid\">
						${['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].map((dname,i)=>`<button type=\"button\" data-weekday=\"${i}\" style=\"text-align:center; background:#f8fafc; border:1px solid #eef2f6; border-radius:10px; padding:12px 10px; cursor:pointer\"><div class=\"sub\">${dname}</div><div style=\"font-weight:700\">${(d.weekly||[])[i]||0}</div><div class=\"sub\">appointments</div></button>`).join('')}
					</div>
				</div>
			</div>
		`;
		// Wire inline Add Appointment button
		panel.querySelector('#inlineAddAppt')?.addEventListener('click', function(e){ e.preventDefault(); openAppt(); });

		// Wire actions: edit/delete for appointments
		panel.querySelectorAll('.actions').forEach(function(box){
			const appointmentId = box.getAttribute('data-appt-id');
			const edit = box.querySelector('.edit');
			const del = box.querySelector('.delete');
			
			if (appointmentId) {
				// Edit appointment
				edit.addEventListener('click', function(ev){
					ev.preventDefault();
					openEditModal(appointmentId);
				});
				
				// Delete appointment
				del.addEventListener('click', function(ev){
					ev.preventDefault();
					if (confirm('Delete this appointment?')) {
						deleteAppointment(appointmentId);
					}
				});
			}
		});

		// Day/Week toggle behavior (visual state like screenshot)
		const dayBtn = panel.querySelector('#btnDay');
		const weekBtn = panel.querySelector('#btnWeek');
		function setView(mode){
			const daySection = document.getElementById('daySection');
			const weekSection = document.getElementById('weekSection');
			if (mode === 'day') {
				dayBtn.classList.add('primary');
				weekBtn.classList.remove('primary');
				daySection.style.display = 'block';
				weekSection.style.display = 'none';
			} else {
				weekBtn.classList.add('primary');
				dayBtn.classList.remove('primary');
				daySection.style.display = 'none';
				weekSection.style.display = 'block';
				// setup week day clicks
				const weekStart = new Date(selectedDate);
				weekStart.setHours(0,0,0,0);
				weekStart.setDate(weekStart.getDate() - weekStart.getDay());
				weekSection.querySelectorAll('[data-weekday]')?.forEach(function(btn){
					btn.onclick = function(){
						const idx = parseInt(btn.getAttribute('data-weekday'), 10) || 0;
						const dsel = new Date(weekStart);
						dsel.setDate(weekStart.getDate() + idx);
						selectedDate = dsel;
						setView('day');
						
						// Update available patients for the new date
						if (currentDoctorKey) {
							loadAvailablePatients(currentDoctorKey, selectedDate);
						}
					};
				});
			}
		}
		dayBtn?.addEventListener('click', function(){ setView('day'); });
		weekBtn?.addEventListener('click', function(){ setView('week'); });
		setView('day');

		// Calendar popover
		const cal = panel.querySelector('#calendarPopover');
		const calBtn = panel.querySelector('#openCalendar');
		let shownMonth = new Date(selectedDate);
		function fmt(d){ const x = new Date(d); x.setHours(0,0,0,0); return x; }
		function renderCalendar(base){
			const year = base.getFullYear();
			const month = base.getMonth();
			const first = new Date(year, month, 1);
			const startDay = first.getDay(); // 0..6
			const daysInMonth = new Date(year, month+1, 0).getDate();
			const dayNames = ['Su','Mo','Tu','We','Th','Fr','Sa'];
			let header = '<div style="display:grid;grid-template-columns:repeat(7,1fr);gap:6px;margin-bottom:6px;color:#64748b">' + dayNames.map(function(n){return '<div style="text-align:center">'+n+'</div>';}).join('') + '</div>';
			let grid = '';
			for (let i=0; i<startDay; i++) grid += '<div></div>';
			for (let dnum=1; dnum<=daysInMonth; dnum++){
				const dd = new Date(year, month, dnum);
				const isSel = fmt(dd).getTime() === fmt(selectedDate).getTime();
				grid += '<button type="button" data-date="'+ dd.toISOString().slice(0,10) +'" style="border:1px solid '+(isSel?'#1d4ed8':'#e5e7eb')+';background:'+(isSel?'#eff6ff':'#fff')+';border-radius:8px;padding:8px;cursor:pointer;text-align:center">'+ dnum +'</button>';
			}
			cal.innerHTML = `
				<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
					<button id="calPrev" class="btn">‹</button>
					<div style="font-weight:700">${base.toLocaleString(undefined,{month:'long'})} ${year}</div>
					<button id="calNext" class="btn">›</button>
				</div>
				${header}
				<div style="display:grid;grid-template-columns:repeat(7,1fr);gap:6px">${grid}</div>
				<div style="margin-top:8px;display:flex;justify-content:space-between">
					<button id="calClear" class="btn">Close</button>
					<button id="calToday" class="btn">Today</button>
				</div>
			`;
			cal.querySelector('#calPrev').onclick = function(){ shownMonth = new Date(year, month-1, 1); renderCalendar(shownMonth); };
			cal.querySelector('#calNext').onclick = function(){ shownMonth = new Date(year, month+1, 1); renderCalendar(shownMonth); };
			cal.querySelector('#calClear').onclick = function(){ cal.style.display = 'none'; };
			cal.querySelector('#calToday').onclick = function(){ 
				selectedDate = new Date(); 
				calBtn.textContent = '📅 ' + new Date(selectedDate).toLocaleDateString(); 
				renderDetail(id); 
				cal.style.display='none';
				
				// Update available patients for the new date
				if (currentDoctorKey) {
					loadAvailablePatients(currentDoctorKey, selectedDate);
				}
			};
			cal.querySelectorAll('[data-date]').forEach(function(btn){
				btn.addEventListener('click', function(){ 
					selectedDate = new Date(btn.getAttribute('data-date')); 
					calBtn.textContent = '📅 ' + new Date(selectedDate).toLocaleDateString(); 
					
					// Reload appointments for the new date
					if (currentDoctorKey) {
						loadDoctorAppointments(currentDoctorKey);
					}
					
					cal.style.display='none';
					
					// Update available patients for the new date
					if (currentDoctorKey) {
						loadAvailablePatients(currentDoctorKey, selectedDate);
					}
				});
			});
		}
		if (calBtn){
			calBtn.addEventListener('click', function(){
				cal.style.display = (cal.style.display==='none' || !cal.style.display) ? 'block' : 'none';
				if (cal.style.display==='block') renderCalendar(shownMonth);
			});
		}
	}

	// Click handlers
	document.querySelectorAll('#doctorList .doc-item').forEach(el=>{
		el.addEventListener('click', function(){
			const doctorId = this.dataset.id;
			currentDoctorKey = doctorId; // Set the current doctor key
			
			// Highlight the selected doctor
			document.querySelectorAll('#doctorList .doc-item').forEach(item => {
				item.style.borderLeftColor = 'transparent';
				item.style.background = 'transparent';
			});
			this.style.borderLeftColor = '#2563eb';
			this.style.background = '#eef2ff';
			
			// Load appointments from database and render detail
			loadDoctorAppointments(doctorId);
		});
	});
	
	// Default select first available doctor
	const firstDoctorId = Object.keys(doctors)[0];
	if (firstDoctorId) {
		currentDoctorKey = firstDoctorId; // Set the first doctor as current
		
		console.log('Initial selectedDate:', selectedDate);
		console.log('Initial selectedDate ISO:', selectedDate.toISOString());
		console.log('Initial selectedDate slice:', selectedDate.toISOString().slice(0, 10));
		
		// Highlight the first doctor
		const firstDoctorElement = document.querySelector(`#doctorList .doc-item[data-id="${firstDoctorId}"]`);
		if (firstDoctorElement) {
			firstDoctorElement.style.borderLeftColor = '#2563eb';
			firstDoctorElement.style.background = '#eef2ff';
		}
		
		// Load appointments and render detail
		loadDoctorAppointments(firstDoctorId);
	}

	// Edit Appointment Modal (inline, uses existing appointments/update/:id)
})();

// Add patient dropdown functionality
document.addEventListener('DOMContentLoaded', function() {
	// Auto-fill patient details when patient is selected in the Add Appointment modal
	const patientSelect = document.querySelector('#addApptModal select[name="patient_name"]');
	if (patientSelect) {
		patientSelect.addEventListener('change', function() {
			const selectedOption = this.options[this.selectedIndex];
			
			if (this.value) {
				// Extract phone number from the option text (format: "Name (Phone)")
				const phoneMatch = selectedOption.text.match(/\(([^)]+)\)/);
				
				// You can add more patient details here if needed
				console.log('Selected patient:', this.value);
				if (phoneMatch) {
					console.log('Patient phone:', phoneMatch[1]);
				}
			}
		});
	}
});
</script>
<!-- Edit Appointment Modal -->
<div class="modal" id="editApptModal" aria-hidden="true">
	<div class="modal-backdrop" id="closeEditApptBackdrop"></div>
	<div class="modal-dialog">
		<div class="modal-header">
			<h3>Edit Appointment</h3>
			<button class="modal-close" id="closeEditAppt" aria-label="Close">×</button>
		</div>
		<form method="post" id="editApptForm">
			<div class="modal-body">
				<div class="grid-2 modal-grid">
					<label><span>Patient Name</span><input type="text" name="patient_name" id="eaPatient" required></label>
					<label><span>Doctor</span><input type="text" name="doctor_name" id="eaDoctor" required></label>
				</div>
				<div class="grid-2 modal-grid">
					<label><span>Date</span><input type="date" name="date" id="eaDate" required></label>
					<label><span>Time</span><input type="time" name="time" id="eaTime" required></label>
				</div>
				<div class="grid-2 modal-grid">
					<label><span>Type</span>
						<select name="type" id="eaType" required>
							<option>Consultation</option>
							<option>Follow-up</option>
							<option>Checkup</option>
							<option>Emergency</option>
						</select>
					</label>
					<label><span>Status</span>
						<select name="status" id="eaStatus" required>
							<option>Pending</option>
							<option>Confirmed</option>
							<option>Completed</option>
						</select>
					</label>
				</div>
				<div class="grid-2 modal-grid">
					<label><span>Room</span>
						<select name="room" id="eaRoom" required>
							<option value="">Select Room</option>
							<option value="Room 101">Room 101</option>
							<option value="Room 102">Room 102</option>
							<option value="Room 103">Room 103</option>
							<option value="Room 201">Room 201</option>
							<option value="Room 202">Room 202</option>
							<option value="Room 203">Room 203</option>
							<option value="Emergency Room">Emergency Room</option>
							<option value="Consultation Room A">Consultation Room A</option>
							<option value="Consultation Room B">Consultation Room B</option>
							<option value="Surgery Room 1">Surgery Room 1</option>
							<option value="Surgery Room 2">Surgery Room 2</option>
						</select>
					</label>
				<label><span>Notes</span><textarea name="notes" id="eaNotes"></textarea></label>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" type="button" id="cancelEditAppt">Cancel</button>
				<button class="btn primary" type="submit">Save Changes</button>
			</div>
		</form>
	</div>
</div>
<script>
(function(){
	const m = document.getElementById('editApptModal');
	const form = document.getElementById('editApptForm');
	const fPatient = document.getElementById('eaPatient');
	const fDoctor = document.getElementById('eaDoctor');
	const fDate = document.getElementById('eaDate');
	const fTime = document.getElementById('eaTime');
	const fType = document.getElementById('eaType');
	const fStatus = document.getElementById('eaStatus');
	const fRoom = document.getElementById('eaRoom');
	const fNotes = document.getElementById('eaNotes');
	let currentId = null;

	function open(){ m.classList.add('open'); }
	function close(){ m.classList.remove('open'); }
	document.getElementById('closeEditAppt')?.addEventListener('click', close);
	document.getElementById('closeEditApptBackdrop')?.addEventListener('click', close);
	document.getElementById('cancelEditAppt')?.addEventListener('click', close);

	// Handle edit form submission
	form?.addEventListener('submit', function(ev){
			ev.preventDefault();
		
		const appointmentId = this.getAttribute('data-appointment-id');
		if (!appointmentId) {
			alert('No appointment selected for editing');
			return false;
		}
		
		const formData = new FormData(this);
		
		// Send AJAX request to update appointment
		fetch(`<?= site_url('scheduling/updateAppointment') ?>/${appointmentId}`, {
			method: 'POST',
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				// Reload appointments from database
				loadDoctorAppointments(currentDoctorKey);
				close();
				// Reset form
				this.reset();
				alert('Appointment updated successfully!');
			} else {
				alert('Error: ' + data.message);
			}
		})
		.catch(error => {
			console.error('Error:', error);
			alert('Error updating appointment. Please try again.');
		});
	});
})();
</script>
<?php echo view('auth/partials/footer'); ?>
