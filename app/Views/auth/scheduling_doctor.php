<?php echo view('auth/partials/header', ['title' => 'Doctor Scheduling']); ?>
<style>
.schedule-grid {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.grid-header {
    border-bottom: 2px solid #e2e8f0;
}

.grid-header-cell {
    font-weight: 600;
    color: #374151;
    background: #f8fafc;
    border-right: 1px solid #e2e8f0;
}

.schedule-row {
    border-bottom: 1px solid #f1f5f9;
}

.time-slot {
    background: #f8fafc;
    border-right: 1px solid #e2e8f0;
    font-weight: 500;
    color: #64748b;
}

.schedule-cell {
    border-right: 1px solid #f1f5f9;
    background: #fff;
    min-height: 40px;
    position: relative;
}

.appointment-card {
    transition: all 0.2s ease;
}

.appointment-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.btn.primary {
    background: #2563eb;
    color: #fff;
    border: none;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
}

.btn {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #d1d5db;
    padding: 8px 16px;
    border-radius: 6px;
    font-weight: 500;
    cursor: pointer;
}

.btn:hover {
    background: #e5e7eb;
}

.sub {
    color: #6b7280;
    font-size: 14px;
    margin-top: 2px;
}
</style>
<div class="container">
	<?php echo view('auth/partials/sidebar'); ?>
	<main class="main-content">
		<header class="header">
			<h1>Doctor Scheduling</h1>
			<div class="user-info" style="gap:12px">
				<a class="btn" href="<?= site_url('patients/create') ?>">Register Patient</a>
				<a class="btn" href="<?= site_url('scheduling-management') ?>">Back to Scheduling</a>
				<a class="btn primary" href="#" onclick="openAddToScheduleModal(); return false;">+ Add Appointment</a>
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

<!-- Add to Schedule Modal -->
<div id="addToScheduleModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000;">
	<div style="background: white; border-radius: 12px; padding: 24px; width: 90%; max-width: 800px; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
		<!-- Modal Header -->
		<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
			<h3 style="margin: 0; color: #1f2937; font-size: 20px; font-weight: 600;">Add to Schedule</h3>
			<button onclick="closeAddToScheduleModal()" style="background: none; border: none; font-size: 24px; color: #6b7280; cursor: pointer; padding: 0; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">×</button>
		</div>
		
		<!-- Modal Content - Two Column Layout -->
		<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
			<!-- Left Column -->
			<div>
				<label style="display: block; margin-bottom: 8px; color: #374151; font-weight: 500; font-size: 14px;">Activity Type</label>
				<select id="modalActivityType" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #fff;">
					<option value="">Select type</option>
					<option value="consultation">Consultation</option>
					<option value="follow_up">Follow-up</option>
					<option value="treatment_procedure">Treatment / Procedure</option>
					<option value="laboratory_request">Laboratory Request / Result Review</option>
					<option value="surgery_operation">Surgery / Operation</option>
					<option value="rest_day">Rest Day</option>
				</select>
				
				<label style="display: block; margin: 20px 0 8px 0; color: #374151; font-weight: 500; font-size: 14px;">Day</label>
				<select id="modalDay" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #fff;">
					<option value="">Select day</option>
					<option value="1">Monday</option>
					<option value="2">Tuesday</option>
					<option value="3">Wednesday</option>
					<option value="4">Thursday</option>
					<option value="5">Friday</option>
					<option value="6">Saturday</option>
					<option value="0">Sunday</option>
				</select>
				
				<label style="display: block; margin: 20px 0 8px 0; color: #374151; font-weight: 500; font-size: 14px;">Start Time</label>
				<select id="modalStartTime" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #fff;">
					<option value="">Select time</option>
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
				
				<label style="display: block; margin: 20px 0 8px 0; color: #374151; font-weight: 500; font-size: 14px;">Duration</label>
				<select id="modalDuration" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #fff;">
					<option value="">Select duration</option>
					<option value="30">30 minutes</option>
					<option value="60" selected>1 hour</option>
					<option value="90">1.5 hours</option>
					<option value="120">2 hours</option>
					<option value="180">3 hours</option>
					<option value="240">4 hours</option>
					<option value="480">8 hours</option>
					<option value="1440">1 day (24 hours)</option>
				</select>
			</div>
			
			<!-- Right Column -->
			<div>
				<label style="display: block; margin-bottom: 8px; color: #374151; font-weight: 500; font-size: 14px;">Patient/Activity</label>
				<select id="modalPatientActivity" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #fff;">
					<option value="">Select patient or enter activity</option>
					<option value="" disabled>Loading patients...</option>
				</select>
				
				<!-- Color Pickers -->
				<div style="margin: 20px 0; display: flex; gap: 8px;">
					<button type="button" class="modal-color-picker selected" data-color="#6b7280" style="width: 32px; height: 32px; border: 2px solid #6b7280; border-radius: 6px; background: #6b7280; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">■</button>
					<button type="button" class="modal-color-picker" data-color="#ef4444" style="width: 32px; height: 32px; border: 2px solid #ef4444; border-radius: 6px; background: #ef4444; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">■</button>
					<button type="button" class="modal-color-picker" data-color="#22c55e" style="width: 32px; height: 32px; border: 2px solid #22c55e; border-radius: 6px; background: #22c55e; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">■</button>
					<button type="button" class="modal-color-picker" data-color="#8b5cf6" style="width: 32px; height: 32px; border: 2px solid #8b5cf6; border-radius: 6px; background: #8b5cf6; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">■</button>
					<button type="button" class="modal-color-picker" data-color="#eab308" style="width: 32px; height: 32px; border: 2px solid #eab308; border-radius: 6px; background: #eab308; cursor: pointer; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px;">■</button>
				</div>
				
				<label style="display: block; margin: 20px 0 8px 0; color: #374151; font-weight: 500; font-size: 14px;">Room/Location</label>
				<select id="modalRoomLocation" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #fff;">
					<option value="">Select room</option>
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
					<option value="Doctor Room">Doctor Room</option>
				</select>
				
				<label style="display: block; margin: 20px 0 8px 0; color: #374151; font-weight: 500; font-size: 14px;">Notes</label>
				<textarea id="modalNotes" placeholder="Additional notes or details" style="width: 100%; padding: 10px 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; background: #fff; min-height: 80px; resize: vertical;"></textarea>
			</div>
		</div>
		
		<!-- Action Buttons -->
		<div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px; padding-top: 20px; border-top: 1px solid #e5e7eb;">
			<button onclick="closeAddToScheduleModal()" style="background: #f3f4f6; color: #374151; border: 1px solid #d1d5db; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer;">Cancel</button>
			<button onclick="addToScheduleFromModal()" style="background: #2563eb; color: #fff; border: none; padding: 10px 20px; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer;">Add to Schedule</button>
		</div>
	</div>
</div>

<script>
(function(){
	let selectedDate = new Date();
	// Set to today's date at midnight (start of day)
	selectedDate.setHours(0, 0, 0, 0);
	let currentDoctorKey = null;
	
	// Add to Schedule Modal Functions
	window.openAddToScheduleModal = function() {
		console.log('Opening Add to Schedule Modal - Function called!');
		alert('Modal function called!'); // Temporary test
		
		const modal = document.getElementById('addToScheduleModal');
		if (!modal) {
			console.error('Modal element not found!');
			alert('Modal element not found!');
			return;
		}
		
		modal.style.display = 'flex';
		modal.style.alignItems = 'center';
		modal.style.justifyContent = 'center';
		initializeModalColorPickers();
		loadModalPatients();
	}
	
	window.closeAddToScheduleModal = function() {
		console.log('Closing Add to Schedule Modal');
		document.getElementById('addToScheduleModal').style.display = 'none';
		clearModalForm();
	}
	
	function loadModalPatients() {
		// Only load patients if the modal is actually open
		const modal = document.getElementById('addToScheduleModal');
		if (!modal || modal.style.display === 'none') {
			console.log('Modal not open, skipping patient load');
			return;
		}
		
		if (!currentDoctorKey) {
			console.log('No doctor selected, showing message');
			const patientSelect = document.getElementById('modalPatientActivity');
			if (patientSelect) {
				patientSelect.innerHTML = '<option value="">Please select a doctor first</option>';
			}
			return;
		}
		
		const patientSelect = document.getElementById('modalPatientActivity');
		if (!patientSelect) return;
		
		console.log('Loading patients for doctor:', currentDoctorKey);
		
		// Clear existing options except the first one
		patientSelect.innerHTML = '<option value="">Select patient or enter activity</option>';
		
		// Load patients from database
		fetch(`<?= site_url('scheduling/getAvailablePatients') ?>/${currentDoctorKey}/${selectedDate.toISOString().slice(0, 10)}`)
			.then(response => response.json())
			.then(data => {
				if (data.success && data.patients) {
					// Add available patients
					data.patients.forEach(patient => {
						const option = document.createElement('option');
						option.value = patient.id;
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
				} else {
					// Fallback: load all patients if no specific date filtering
					fetch(`<?= site_url('scheduling/getAllPatients') ?>`)
						.then(response => response.json())
						.then(patientData => {
							if (patientData.success && patientData.patients) {
								patientData.patients.forEach(patient => {
									const option = document.createElement('option');
									option.value = patient.id;
									option.textContent = (patient.first_name || 'Unknown') + ' ' + (patient.last_name || 'Patient');
									if (patient.phone) {
										option.textContent += ' (' + patient.phone + ')';
									}
									patientSelect.appendChild(option);
								});
							}
						})
						.catch(error => {
							console.error('Error loading all patients:', error);
						});
				}
			})
			.catch(error => {
				console.error('Error loading available patients:', error);
				// Fallback: load all patients
				fetch(`<?= site_url('scheduling/getAllPatients') ?>`)
					.then(response => response.json())
					.then(patientData => {
						if (patientData.success && patientData.patients) {
							patientData.patients.forEach(patient => {
								const option = document.createElement('option');
								option.value = patient.id;
								option.textContent = (patient.first_name || 'Unknown') + ' ' + (patient.last_name || 'Patient');
								option.textContent += ' (' + patient.phone + ')';
								patientSelect.appendChild(option);
							});
						}
					})
					.catch(fallbackError => {
						console.error('Error loading fallback patients:', fallbackError);
					});
			});
	}
	
	function initializeModalColorPickers() {
		const colorPickers = document.querySelectorAll('.modal-color-picker');
		colorPickers.forEach(picker => {
			picker.addEventListener('click', function() {
				// Remove selected class from all pickers
				colorPickers.forEach(p => p.classList.remove('selected'));
				// Add selected class to clicked picker
				this.classList.add('selected');
			});
		});
	}
	
	function clearModalForm() {
		document.getElementById('modalActivityType').value = '';
		document.getElementById('modalDay').value = '';
		document.getElementById('modalStartTime').value = '';
		document.getElementById('modalDuration').value = '60';
		document.getElementById('modalPatientActivity').value = '';
		document.getElementById('modalRoomLocation').value = '';
		document.getElementById('modalNotes').value = '';
		
		// Reset color picker selection
		const colorPickers = document.querySelectorAll('.modal-color-picker');
		colorPickers.forEach(p => p.classList.remove('selected'));
		document.querySelector('.modal-color-picker[data-color="#6b7280"]').classList.add('selected');
	}
	
	window.addToScheduleFromModal = async function() {
		const activityType = document.getElementById('modalActivityType').value;
		const day = document.getElementById('modalDay').value;
		const startTime = document.getElementById('modalStartTime').value;
		const duration = document.getElementById('modalDuration').value;
		const patientSelect = document.getElementById('modalPatientActivity');
		const patientId = patientSelect.value;
		const patientText = patientSelect.options[patientSelect.selectedIndex].textContent;
		const roomLocation = document.getElementById('modalRoomLocation').value;
		const notes = document.getElementById('modalNotes').value;
		const selectedColor = document.querySelector('.modal-color-picker.selected')?.dataset.color || '#6b7280';
		
		if (!activityType || !day || !startTime || !duration || !patientId) {
			alert('Please fill in all required fields');
			return;
		}
		
		if (!currentDoctorKey || !doctors[currentDoctorKey]) {
			alert('Please select a doctor first');
			return;
		}
		
		// Calculate the actual date based on selected day
		const today = new Date();
		const currentWeek = new Date(today);
		currentWeek.setDate(today.getDate() - today.getDay() + 1); // Monday
		
		const targetDay = parseInt(day);
		const dayOffset = targetDay === 0 ? 6 : targetDay - 1; // Adjust for Sunday (0) to be last day of week
		const appointmentDate = new Date(currentWeek);
		appointmentDate.setDate(currentWeek.getDate() + dayOffset);
		
		// Calculate end time based on duration
		const startTimeObj = new Date(`2000-01-01T${startTime}`);
		const durationMinutes = parseInt(duration);
		const endTime = new Date(startTimeObj.getTime() + durationMinutes * 60 * 1000);
		const endTimeString = endTime.toTimeString().slice(0, 5);
		
		try {
			const formData = new FormData();
			formData.append('title', patientText);
			formData.append('type', activityType);
			formData.append('date', appointmentDate.toISOString().slice(0, 10));
			formData.append('start_time', startTime);
			formData.append('end_time', endTimeString);
			formData.append('room', roomLocation);
			formData.append('description', `${activityType} appointment for ${patientText}. ${notes ? 'Notes: ' + notes : ''}`);
			
			const response = await fetch('<?= site_url('schedule/addSchedule') ?>', {
				method: 'POST',
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: formData
			});
			
			const result = await response.json();
			
			if (result.success) {
				const appointmentData = {
					patient: patientText,
					type: activityType,
					date: appointmentDate.toISOString().slice(0, 10),
					time: startTime,
					room: roomLocation,
					status: 'Confirmed',
					duration: `${durationMinutes} minutes`,
					endTime: endTimeString,
					id: result.schedule_id || 'db_' + Date.now(),
					notes: notes,
					color: selectedColor
				};
				
				// Add to local appointments array
				if (doctors[currentDoctorKey]) {
					doctors[currentDoctorKey].appointments.push(appointmentData);
					// Refresh the display
					if (typeof renderDetail === 'function') {
						renderDetail(currentDoctorKey);
					}
				}
				
				closeAddToScheduleModal();
				alert('Appointment added successfully to schedule!');
			} else {
				alert('Error saving to database: ' + (result.error || 'Unknown error'));
			}
		} catch (error) {
			console.error('Error saving appointment:', error);
			alert('Error saving appointment to database. Please try again.');
		}
	}
	
	// Close modal when clicking outside
	document.addEventListener('DOMContentLoaded', function() {
		const modal = document.getElementById('addToScheduleModal');
		if (modal) {
			modal.addEventListener('click', function(e) {
				if (e.target === modal) {
					closeAddToScheduleModal();
				}
			});
		}
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
	
	// Add sample appointment data for demonstration
	// This will be replaced with real data from database
	async function addSampleAppointments() {
		// Check if we already added sample appointments in this session
		if (localStorage.getItem('sampleAppointmentsAdded')) {
			console.log('Sample appointments already added in this session, skipping...');
			return;
		}
		
		Object.keys(doctors).forEach(async (doctorId) => {
			const doctor = doctors[doctorId];
			
			// Get current week dates
			const today = new Date();
			const monday = new Date(today);
			monday.setDate(today.getDate() - today.getDay() + 1); // Monday
			
			// Sample appointment: Tuesday 9:30 AM - 10:30 AM
			const tuesday = new Date(monday);
			tuesday.setDate(monday.getDate() + 1); // Tuesday
			
			// Create sample appointment
			const sampleAppointment = {
				id: 'sample1',
				time: '9:30',
				patient: 'yoy gen',
				type: 'Consultation',
				status: 'Confirmed',
				room: 'Doctor Room',
				date: tuesday.toISOString().slice(0, 10),
				duration: '1 hour',
				endTime: '10:30'
			};
			
			// Add to local array for display
			doctor.appointments.push(sampleAppointment);
			
			// Try to save to database
			try {
				const formData = new FormData();
				formData.append('title', 'yoy gen');
				formData.append('type', 'Consultation');
				formData.append('date', tuesday.toISOString().slice(0, 10));
				formData.append('start_time', '09:30');
				formData.append('end_time', '10:30');
				formData.append('room', 'Doctor Room');
				formData.append('description', 'Sample consultation appointment for yoy gen');
				
				const response = await fetch('<?= site_url('schedule/addSchedule') ?>', {
					method: 'POST',
					headers: {
						'X-Requested-With': 'XMLHttpRequest'
					},
					body: formData
				});
				
				const result = await response.json();
				if (result.success) {
					console.log('Sample appointment saved to database with ID:', result.schedule_id);
					// Update the local appointment with database ID
					sampleAppointment.id = result.schedule_id;
				}
			} catch (error) {
				console.log('Sample appointment already exists or error occurred:', error);
			}
		});
		
		// Mark that sample appointments have been added
		localStorage.setItem('sampleAppointmentsAdded', 'true');
	}
	
	// Function to add new appointment dynamically
	function addNewAppointment(doctorId, appointmentData) {
		if (!doctors[doctorId]) return false;
		
		const newAppointment = {
			id: 'appt_' + Date.now(),
			time: appointmentData.time,
			patient: appointmentData.patient,
			type: appointmentData.type,
			status: appointmentData.status || 'Pending',
			room: appointmentData.room || 'Consultation Room',
			date: appointmentData.date,
			duration: appointmentData.duration || '1 hour',
			endTime: appointmentData.endTime || '1 hour'
		};
		
		doctors[doctorId].appointments.push(newAppointment);
		
		// Refresh the view
		renderDetail(doctorId);
		
		return newAppointment.id;
	}
	
	// Function to handle form submission for new appointments
	async function addNewAppointmentFromForm() {
		const patientName = document.getElementById('newPatientName').value;
		const appointmentType = document.getElementById('newAppointmentType').value;
		const appointmentDate = document.getElementById('newAppointmentDate').value;
		const appointmentTime = document.getElementById('newAppointmentTime').value;
		const appointmentRoom = document.getElementById('newAppointmentRoom').value;
		
		if (!patientName || !appointmentDate || !appointmentTime) {
			alert('Please fill in all required fields');
			return;
		}
		
		// Calculate end time (1 hour duration)
		const startTime = new Date(`2000-01-01T${appointmentTime}`);
		const endTime = new Date(startTime.getTime() + 60 * 60 * 1000); // Add 1 hour
		const endTimeString = endTime.toTimeString().slice(0, 5);
		
		try {
			// Create form data for database
			const formData = new FormData();
			formData.append('title', patientName);
			formData.append('type', appointmentType);
			formData.append('date', appointmentDate);
			formData.append('start_time', appointmentTime);
			formData.append('end_time', endTimeString);
			formData.append('room', appointmentRoom);
			formData.append('description', `${appointmentType} appointment for ${patientName}`);
			
			// Send to database
			const response = await fetch('<?= site_url('schedule/addSchedule') ?>', {
				method: 'POST',
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: formData
			});
			
			const result = await response.json();
			
			if (result.success) {
				// Add to local JavaScript array for immediate display
				const appointmentData = {
					patient: patientName,
					type: appointmentType,
					date: appointmentDate,
					time: appointmentTime,
					room: appointmentRoom,
					status: 'Confirmed',
					duration: '1 hour',
					endTime: endTimeString,
					id: result.schedule_id || 'db_' + Date.now()
				};
				
				addNewAppointment(currentDoctorKey, appointmentData);
				
				// Clear form
				document.getElementById('newPatientName').value = '';
				document.getElementById('newAppointmentDate').value = '';
				document.getElementById('newAppointmentTime').value = '';
				document.getElementById('newAppointmentRoom').value = '';
				
				alert('Appointment added successfully to database!');
			} else {
				alert('Error saving to database: ' + (result.error || 'Unknown error'));
			}
		} catch (error) {
			console.error('Error saving appointment:', error);
			alert('Error saving appointment to database. Please try again.');
		}
	}

	// Load appointments from database
	async function loadAppointmentsFromDatabase(doctorId) {
		try {
			const response = await fetch('<?= site_url('schedule/getWeeklySchedules') ?>', {
				method: 'POST',
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				}
			});
			
			const result = await response.json();
			
			if (result.success && result.schedules) {
				const doctor = doctors[doctorId];
				if (doctor) {
					// Clear existing appointments
					doctor.appointments = [];
					
					// Add appointments from database
					result.schedules.forEach(schedule => {
						// Check if this appointment is already in the array
						const existingAppointment = doctor.appointments.find(apt => 
							apt.patient === schedule.title && 
							apt.date === schedule.date && 
							apt.time === schedule.start_time
						);
						
						if (!existingAppointment) {
							doctor.appointments.push({
								id: schedule.id,
								time: schedule.start_time,
								patient: schedule.title,
								type: schedule.type,
								status: schedule.status,
								room: schedule.room || 'No Room',
								date: schedule.date,
								duration: '1 hour',
								endTime: schedule.end_time
							});
						}
					});
					
					console.log('Loaded appointments from database:', doctor.appointments);
				}
			}
		} catch (error) {
			console.error('Error loading appointments from database:', error);
		}
	}
	
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
	
	// Helper functions for calendar views
	function generateTimeSlots() {
		const timeSlots = [];
		
		// Generate time slots from 8:00 AM to 5:00 PM with 30-minute intervals
		for (let hour = 8; hour <= 17; hour++) {
			for (let minute = 0; minute < 60; minute += 30) {
				if (hour === 17 && minute === 30) break; // Stop at 5:30 PM
				
				const time = formatTime(hour, minute);
				const timeSlot = document.createElement('div');
				timeSlot.className = 'schedule-row';
				timeSlot.style.display = 'grid';
				timeSlot.style.gridTemplateColumns = '120px repeat(7,1fr)';
				timeSlot.style.borderBottom = '1px solid #f1f5f9';
				
				// Time column
				const timeCell = document.createElement('div');
				timeCell.className = 'time-slot';
				timeCell.style.padding = '8px 16px';
				timeCell.style.borderRight = '1px solid #e2e8f0';
				timeCell.style.borderBottom = '1px solid #f1f5f9';
				timeCell.style.fontSize = '12px';
				timeCell.style.color = '#64748b';
				timeCell.style.fontWeight = '500';
				timeCell.style.display = 'flex';
				timeCell.style.alignItems = 'center';
				timeCell.style.backgroundColor = '#f8fafc';
				timeCell.textContent = time;
				timeSlot.appendChild(timeCell);
				
				// Day columns (Monday to Sunday)
				for (let day = 0; day < 7; day++) {
					const dayCell = document.createElement('div');
					dayCell.className = 'schedule-cell';
					dayCell.style.borderRight = '1px solid #f1f5f9';
					dayCell.style.borderBottom = '1px solid #f1f5f9';
					dayCell.style.padding = '4px';
					dayCell.style.position = 'relative';
					dayCell.style.minHeight = '40px';
					dayCell.style.backgroundColor = '#fff';
					
					// Check if there are appointments for this time and day
					const date = new Date(selectedDate);
					// Adjust to start from Monday (1) instead of Sunday (0)
					const dayOffset = day === 0 ? 1 : day === 6 ? 0 : day + 1;
					date.setDate(date.getDate() - date.getDay() + dayOffset);
					const appointmentsForTime = getAppointmentsForTimeAndDay(hour, minute, date);
					
					if (appointmentsForTime.length > 0) {
						appointmentsForTime.forEach(appointment => {
							const appointmentCard = createAppointmentCard(appointment);
							dayCell.appendChild(appointmentCard);
						});
					}
					
					timeSlot.appendChild(dayCell);
				}
				
				timeSlots.push(timeSlot.outerHTML);
			}
		}
		return timeSlots.join('');
	}
	
	// Helper function to format time
	function formatTime(hour, minute) {
		if (hour === 0) return '12:00 AM';
		if (hour < 12) return `${hour}:${minute.toString().padStart(2, '0')} AM`;
		if (hour === 12) return `12:${minute.toString().padStart(2, '0')} PM`;
		return `${hour - 12}:${minute.toString().padStart(2, '0')} PM`;
	}
	
	function generateCalendarDays() {
		const year = selectedDate.getFullYear();
		const month = selectedDate.getMonth();
		const firstDay = new Date(year, month, 1);
		const lastDay = new Date(year, month + 1, 0);
		const startDay = firstDay.getDay();
		const daysInMonth = lastDay.getDate();
		
		let calendarDays = '';
		
		// Empty cells for days before the month starts
		for (let i = 0; i < startDay; i++) {
			calendarDays += '<div style="background:#f8fafc; padding:20px 8px; text-align:center; color:#9ca3af; font-size:14px; min-height:60px;"></div>';
		}
		
		// Days of the month
		for (let day = 1; day <= daysInMonth; day++) {
			const date = new Date(year, month, day);
			const isToday = date.toDateString() === new Date().toDateString();
			const isSelected = date.toDateString() === selectedDate.toDateString();
			
			let dayClass = 'background:#fff; padding:20px 8px; text-align:center; color:#374151; font-size:14px; min-height:60px; cursor:pointer; border:1px solid #e5e7eb;';
			
			if (isToday) {
				dayClass = 'background:#eff6ff; padding:20px 8px; text-align:center; color:#1d4ed8; font-size:14px; min-height:60px; cursor:pointer; border:1px solid #3b82f6; font-weight:600;';
			} else if (isSelected) {
				dayClass = 'background:#fef3c7; padding:20px 8px; text-align:center; color:#92400e; font-size:14px; min-height:60px; cursor:pointer; border:1px solid #f59e0b; font-weight:600;';
			}
			
			// Get appointments for this day
			const appointmentsForDay = getAppointmentsForDay(date);
			const appointmentCount = appointmentsForDay.length;
			
			calendarDays += `<div style="${dayClass}" onclick="selectDate('${date.toISOString().slice(0,10)}')">
				<div style="font-weight:600; margin-bottom:4px">${day}</div>
				${appointmentCount > 0 ? `<div style="font-size:11px; color:#6b7280; background:#f3f4f6; padding:2px 6px; border-radius:4px; display:inline-block">${appointmentCount} appt${appointmentCount > 1 ? 's' : ''}</div>` : ''}
			</div>`;
		}
		
		return calendarDays;
	}
	
	function getAppointmentsForTimeAndDay(hour, minute, date) {
		if (!currentDoctorKey || !doctors[currentDoctorKey] || !doctors[currentDoctorKey].appointments) {
			return [];
		}
		
		return doctors[currentDoctorKey].appointments.filter(appointment => {
			const appointmentDate = new Date(appointment.date);
			const appointmentTime = appointment.time.split(':');
			const appointmentHour = parseInt(appointmentTime[0]);
			const appointmentMinute = parseInt(appointmentTime[1] || 0);
			return appointmentDate.toDateString() === date.toDateString() && appointmentHour === hour && appointmentMinute === minute;
		});
	}
	
	function getAppointmentsForDay(date) {
		if (!currentDoctorKey || !doctors[currentDoctorKey] || !doctors[currentDoctorKey].appointments) {
			return [];
		}
		
		return doctors[currentDoctorKey].appointments.filter(appointment => {
			const appointmentDate = new Date(appointment.date);
			return appointmentDate.toDateString() === date.toDateString();
		});
	}
	
	function createAppointmentCard(appointment) {
		const card = document.createElement('div');
		card.className = 'appointment-card';
		card.style.cssText = 'background:#ecfdf5; border-left:4px solid #22c55e; padding:8px; margin:2px; border-radius:8px; font-size:11px; line-height:1.4; cursor:pointer; position:relative; overflow:hidden; min-height:60px; display:flex; flex-direction:column; justify-content:space-between; box-shadow:0 2px 4px rgba(0,0,0,0.1);';
		
		card.innerHTML = `
			<div style="font-weight:700; color:#166534; margin-bottom:4px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-size:12px;">${appointment.type}</div>
			<div style="color:#166534; font-size:11px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis; font-weight:600;">${appointment.patient}</div>
			<div style="color:#6b7280; font-size:10px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${appointment.duration || '1 hour'}</div>
			<div style="color:#6b7280; font-size:9px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${appointment.room || 'No Room'}</div>
		`;
		
		card.onclick = function() {
			// Show appointment details or edit modal
			alert(`Appointment Details:\n\nTitle: ${appointment.type}\nPatient: ${appointment.patient}\nTime: ${appointment.time} - ${appointment.endTime || '1 hour'}\nDuration: ${appointment.duration || '1 hour'}\nRoom: ${appointment.room || 'No Room'}\nStatus: ${appointment.status}`);
		};
		
		return card;
	}
	
	function selectDate(dateString) {
		selectedDate = new Date(dateString);
		// Switch back to day view to show the selected date
		setView('day');
		// Update the calendar button text
		const calendarBtn = document.getElementById('openCalendar');
		if (calendarBtn) {
			calendarBtn.textContent = '📅 ' + selectedDate.toLocaleDateString();
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
					<button class=\"btn\" type=\"button\" id=\"btnCalendar\">Calendar</button>
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
					<div style=\"display:flex; align-items:center; justify-content:space-between; margin-bottom:10px\">
						<div class=\"sub\">Weekly Calendar View</div>
						<div style=\"display:flex; gap:8px;\">
							<button onclick=\"checkAppointmentCount()\" style=\"background:#6b7280; color:#fff; border:none; border-radius:6px; padding:6px 12px; font-size:12px; cursor:pointer;\">📊 Count</button>
							<button onclick=\"resetSampleAppointments()\" style=\"background:#ef4444; color:#fff; border:none; border-radius:6px; padding:6px 12px; font-size:12px; cursor:pointer;\">🔄 Reset</button>
							<button onclick=\"refreshAppointmentsFromDatabase()\" style=\"background:#3b82f6; color:#fff; border:none; border-radius:6px; padding:6px 12px; font-size:12px; cursor:pointer;\">🔄 Refresh</button>
						</div>
					</div>
					<div class=\"schedule-grid\" style=\"background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.1); overflow:hidden\">
						<div class=\"grid-header\" style=\"display:grid; grid-template-columns:120px repeat(7,1fr); background:#f8fafc; border-bottom:1px solid #e2e8f0\">
							<div class=\"grid-header-cell\" style=\"padding:16px 12px; text-align:left; font-weight:600; color:#374151; font-size:14px; border-right:1px solid #e2e8f0\">Time</div>
							${['Mon','Tue','Wed','Thu','Fri','Sat','Sun'].map((dname,i)=>{
								const date = new Date(selectedDate);
								// Adjust to start from Monday (1) instead of Sunday (0)
								const dayOffset = i === 0 ? 1 : i === 6 ? 0 : i + 1;
								date.setDate(date.getDate() - date.getDay() + dayOffset);
								const isToday = date.toDateString() === new Date().toDateString();
								return `<div class=\"grid-header-cell\" style=\"padding:16px 12px; text-align:center; font-weight:600; color:#374151; font-size:14px; border-right:1px solid #e2e8f0; ${isToday ? 'background:#eff6ff; color:#1d4ed8;' : ''}\">
									<div>${dname}</div>
									<div style=\"font-size:12px; color:#6b7280; margin-top:2px\">${date.getDate()}</div>
								</div>`;
							}).join('')}
						</div>
						<div class=\"grid-body\" style=\"display:flex; flex-direction:column\">
							${generateTimeSlots()}
						</div>
					</div>
				</div>
				<div id=\"calendarSection\" style=\"display:none\">
					<div class=\"sub\" style=\"margin-bottom:10px\">Monthly Calendar View</div>
					<div class=\"monthly-calendar\" style=\"background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,0.1); padding:20px\">
						<div style=\"display:flex; align-items:center; justify-content:space-between; margin-bottom:20px\">
							<button class=\"btn\" id=\"prevMonth\">‹</button>
							<div style=\"font-weight:700; font-size:18px; color:#1f2937\">
								${new Date(selectedDate).toLocaleDateString(undefined,{month:'long', year:'numeric'})}
							</div>
							<button class=\"btn\" id=\"nextMonth\">›</button>
						</div>
						<div class=\"calendar-grid\" style=\"display:grid; grid-template-columns:repeat(7,1fr); gap:1px; background:#e5e7eb; border:1px solid #e5e7eb; border-radius:8px; overflow:hidden\">
							${['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].map(day=>`<div style=\"background:#f8fafc; padding:12px 8px; text-align:center; font-weight:600; color:#374151; font-size:12px\">${day}</div>`).join('')}
							${generateCalendarDays()}
						</div>
					</div>
				</div>
			</div>
		`;
		// Wire inline Add Appointment button
		panel.querySelector('#inlineAddAppt')?.addEventListener('click', function(e){ e.preventDefault(); openAddToScheduleModal(); });

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
			const calendarSection = document.getElementById('calendarSection');
			
			// Reset all buttons
			dayBtn.classList.remove('primary');
			weekBtn.classList.remove('primary');
			calendarBtn.classList.remove('primary');
			
			// Hide all sections
			daySection.style.display = 'none';
			weekSection.style.display = 'none';
			calendarSection.style.display = 'none';
			
			if (mode === 'day') {
				dayBtn.classList.add('primary');
				daySection.style.display = 'block';
			} else if (mode === 'week') {
				weekBtn.classList.add('primary');
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
		
		// Calendar button functionality
		const calendarBtn = panel.querySelector('#btnCalendar');
		calendarBtn?.addEventListener('click', function(){ setView('calendar'); });
		
		// Month navigation
		const prevMonthBtn = panel.querySelector('#prevMonth');
		const nextMonthBtn = panel.querySelector('#nextMonth');
		
		prevMonthBtn?.addEventListener('click', function(){
			const newDate = new Date(selectedDate);
			newDate.setMonth(newDate.getMonth() - 1);
			selectedDate = newDate;
			renderDetail(id);
		});
		
		nextMonthBtn?.addEventListener('click', function(){
			const newDate = new Date(selectedDate);
			newDate.setMonth(newDate.getMonth() + 1);
			selectedDate = newDate;
			renderDetail(id);
		});
		
		dayBtn?.addEventListener('click', function(){ setView('day'); });
		weekBtn?.addEventListener('click', function(){ setView('week'); });
		setView('week');
		
		// Set default values for new appointment form
		const today = new Date();
		const nextWeek = new Date(today);
		nextWeek.setDate(today.getDate() + 7);
		
		// Set default date to next week Monday
		const monday = new Date(nextWeek);
		monday.setDate(nextWeek.getDate() - nextWeek.getDay() + 1);
		
		// Set form defaults
		const newDateInput = panel.querySelector('#newAppointmentDate');
		const newTimeInput = panel.querySelector('#newAppointmentTime');
		if (newDateInput) newDateInput.value = monday.toISOString().slice(0, 10);
		if (newTimeInput) newTimeInput.value = '09:00';

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
		el.addEventListener('click', async function(){
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
			await loadAppointmentsFromDatabase(doctorId);
			loadDoctorAppointments(doctorId);
		});
	});
	
	// Initialize with sample appointments and database loading
	async function initializeAppointments() {
		// Clear any existing appointments first
		Object.keys(doctors).forEach(doctorId => {
			doctors[doctorId].appointments = [];
		});
		
		// Check if sample appointments were already added in this session
		const sampleAdded = localStorage.getItem('sampleAppointmentsAdded');
		
		if (!sampleAdded) {
			// Add sample appointments only once per session
			await addSampleAppointments();
		} else {
			console.log('Sample appointments already added in this session');
		}
		
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
			
			// Load appointments from database and render detail
			await loadAppointmentsFromDatabase(firstDoctorId);
			loadDoctorAppointments(firstDoctorId);
		}
	}
	
	// Start initialization
	initializeAppointments();
	
	// Ensure modal is hidden on page load
	document.addEventListener('DOMContentLoaded', function() {
		const modal = document.getElementById('addToScheduleModal');
		if (modal) {
			modal.style.display = 'none';
			console.log('Modal hidden on page load');
		}
	});
	
	// Function to refresh appointments from database
	async function refreshAppointmentsFromDatabase() {
		if (currentDoctorKey) {
			await loadAppointmentsFromDatabase(currentDoctorKey);
			renderDetail(currentDoctorKey);
			alert('Appointments refreshed from database!');
		}
	}
	
	// Function to reset sample appointments (for testing)
	function resetSampleAppointments() {
		localStorage.removeItem('sampleAppointmentsAdded');
		location.reload();
	}
	
	// Function to check current appointment count
	function checkAppointmentCount() {
		if (currentDoctorKey && doctors[currentDoctorKey]) {
			const count = doctors[currentDoctorKey].appointments.length;
			console.log(`Current appointment count for doctor ${currentDoctorKey}: ${count}`);
			doctors[currentDoctorKey].appointments.forEach((apt, index) => {
				console.log(`${index + 1}. ${apt.patient} - ${apt.type} at ${apt.time}`);
			});
		}
	}

	// Edit Appointment Modal (inline, uses existing appointments/update/:id)
})();

	// Add patient dropdown functionality
	document.addEventListener('DOMContentLoaded', function() {
	// Auto-fill patient details when patient is selected in the Add Appointment modal
	const patientSelect = document.querySelector('#addApptModal select[name="patient_id"]');
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
