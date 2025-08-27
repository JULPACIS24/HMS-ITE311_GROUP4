<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Expires" content="0">
	<title>Doctor • Consultations</title>
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
		.header-right{display:flex;align-items:center;gap:16px}
		.search-box{position:relative}
		.search-input{padding:8px 12px 8px 36px;border:1px solid #e5e7eb;border-radius:8px;font-size:14px;width:280px}
		.search-icon{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#64748b}
		.actions{display:flex;align-items:center;gap:14px}
		.icon-btn{position:relative;width:34px;height:34px;border-radius:10px;background:#f8fafc;border:1px solid #e5e7eb;display:grid;place-items:center;cursor:pointer}
		.badge{position:absolute;top:-4px;right:-4px;background:#ef4444;color:#fff;border-radius:999px;font-size:10px;padding:2px 6px;font-weight:700}
		.avatar{width:34px;height:34px;border-radius:50%;background:#8b5cf6;color:#fff;display:grid;place-items:center;font-weight:800}
		.user-meta{line-height:1.1}
		.user-name{font-weight:700;font-size:13px;color:#0f172a}
		.user-role{font-size:11px;color:#64748b}
		.user-chip{display:flex;align-items:center;gap:10px;cursor:pointer}

		.page{padding:24px}
		.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:24px}
		.kpi{background:#fff;border-radius:12px;padding:18px;box-shadow:0 2px 10px rgba(0,0,0,.08);position:relative}
		.k-title{color:#64748b;font-size:14px}
		.k-value{font-size:28px;font-weight:800;color:#0f172a}
		.k-sub{font-size:12px;color:#16a34a;margin-top:6px}
		.k-icon{position:absolute;right:14px;top:14px;width:34px;height:34px;border-radius:10px;display:grid;place-items:center;color:#fff}
		.i-blue{background:#2563eb}.i-green{background:#10b981}.i-orange{background:#f59e0b}.i-purple{background:#8b5cf6}

		.card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden}
		.card-header{padding:16px 20px;border-bottom:1px solid #ecf0f1;font-weight:700;display:flex;justify-content:space-between;align-items:center}
		.btn{padding:8px 16px;border-radius:8px;text-decoration:none;font-size:14px;font-weight:600;cursor:pointer;border:none}
		.btn-primary{background:#2563eb;color:#fff}
		.btn-secondary{background:#6b7280;color:#fff}
		.list{padding:20px}
		.empty-state{text-align:center;padding:60px 20px;color:#64748b}
		.empty-icon{font-size:48px;margin-bottom:16px}
		.empty-title{font-weight:700;color:#0f172a;margin-bottom:8px}
		.empty-subtitle{font-size:14px}



		/* Consultation Card Styles - UPDATED DESIGN */
		.consultation-card{background:#f8fafc;border-radius:10px;padding:16px;margin-bottom:16px;border:1px solid #e5e7eb}
		.consultation-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px}
		.patient-info{display:flex;align-items:center;gap:12px}
		.patient-avatar{width:40px;height:40px;border-radius:8px;background:#8b5cf6;color:#fff;display:grid;place-items:center;font-weight:700;font-size:14px}
		.patient-details{line-height:1.3}
		.patient-name{font-weight:600;color:#0f172a;font-size:14px}
		.patient-id{font-size:12px;color:#64748b}
		.consultation-status{padding:4px 8px;border-radius:6px;font-size:11px;font-weight:600}
		.status-active{background:#fef3c7;color:#92400e}
		.status-completed{background:#ecfdf5;color:#059669}
		.status-cancelled{background:#fef2f2;color:#dc2626}
		.consultation-details{margin-bottom:12px}
		.consultation-type{color:#2563eb;font-weight:600;font-size:13px;margin-bottom:6px}
		.consultation-type:hover{text-decoration:underline;cursor:pointer}
		.chief-complaint{color:#374151;font-size:13px;margin-bottom:8px;line-height:1.4}
		.consultation-meta{display:flex;gap:16px;font-size:12px;color:#6b7280;flex-wrap:wrap}
		.consultation-date,.consultation-time,.consultation-duration,.consultation-room{font-weight:500}
		.consultation-room{color:#8b5cf6}
		.consultation-actions{display:flex;gap:8px}
		.action-btn{width:32px;height:32px;border-radius:6px;border:none;cursor:pointer;display:grid;place-items:center;font-size:14px}
		.action-view{background:#ecfdf5;color:#059669}
		.action-edit{background:#eff6ff;color:#2563eb}
		.action-print{background:#f0f9ff;color:#0369a1}

		/* Modal Styles - FIXED FOR BUTTON VISIBILITY */
		.modal{display:none;position:fixed;z-index:1000;left:0;top:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);overflow-y:auto}
		.modal-content{background-color:#fff;margin:2% auto;padding:0;border-radius:12px;width:90%;max-width:600px;max-height:90vh;box-shadow:0 4px 20px rgba(0,0,0,0.3);display:flex;flex-direction:column}
		.modal-header{padding:20px;border-bottom:1px solid #e5e7eb;display:flex;justify-content:space-between;align-items:center;flex-shrink:0}
		.modal-header h3{font-size:18px;font-weight:600;color:#1f2937;margin:0}
		.close{color:#aaa;font-size:28px;font-weight:bold;cursor:pointer;line-height:1}
		.close:hover{color:#000}
		.modal-body{padding:20px;flex:1;overflow-y:auto}
		.modal-footer{padding:20px;border-top:1px solid #e5e7eb;display:flex;justify-content:flex-end;gap:12px;flex-shrink:0}
		
		.form-group{margin-bottom:16px}
		.form-group label{display:block;margin-bottom:6px;font-weight:500;color:#374151;font-size:14px}
		.form-group input,.form-group select,.form-group textarea{width:100%;padding:8px 12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;transition:border-color 0.2s}
		.form-group input:focus,.form-group select:focus,.form-group textarea:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,0.1)}
		.form-group textarea{resize:vertical;min-height:60px}
		
		/* Vital Signs Grid */
		.vital-signs-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:8px}
		.vital-item label{font-size:12px;color:#6b7280;margin-bottom:4px}
		.vital-item input{font-size:13px;padding:6px 10px}
	</style>
</head>
<body>
	<div class="container">
		<!-- Sidebar -->
		<div class="sidebar">
			<div class="sidebar-header">
				<div class="admin-icon">🏥</div>
				<div>
					<div class="sidebar-title">San Miguel HMS</div>
					<div class="sidebar-sub">Doctor Portal</div>
				</div>
			</div>
			<div class="sidebar-menu">
				<a href="<?= site_url('doctor/dashboard') ?>" class="menu-item">
					<span class="menu-icon">🕒</span>
					<span>Dashboard</span>
				</a>
				<a href="<?= site_url('doctor/patients') ?>" class="menu-item">
					<span class="menu-icon">👤</span>
					<span>Patient Records</span>
				</a>
				<a href="<?= site_url('doctor/appointments') ?>" class="menu-item">
					<span class="menu-icon">📅</span>
					<span>Appointments</span>
				</a>
				<a href="<?= site_url('doctor/prescriptions') ?>" class="menu-item">
					<span class="menu-icon">💊</span>
					<span>Prescriptions</span>
				</a>
				<a href="<?= site_url('doctor/lab-requests') ?>" class="menu-item">
					<span class="menu-icon">🧪</span>
					<span>Lab Requests</span>
				</a>
				<a href="<?= site_url('doctor/consultations') ?>" class="menu-item active">
					<span class="menu-icon">🩺</span>
					<span>Consultations</span>
				</a>
				<a href="<?= site_url('doctor/schedule') ?>" class="menu-item">
					<span class="menu-icon">📋</span>
					<span>My Schedule</span>
				</a>
				<a href="<?= site_url('doctor/reports') ?>" class="menu-item">
					<span class="menu-icon">📊</span>
					<span>Medical Reports</span>
				</a>
			</div>
		</div>

		<div class="main">
			<div class="header">
				<div class="header-left">
					<h1>Consultations</h1>
					<div class="sub">Manage patient consultations and medical records</div>
				</div>
				<div class="header-right">
					<div class="search-box">
						<input type="text" class="search-input" placeholder="Search patients, consultations...">
						<span class="search-icon">🔍</span>
					</div>
					<div class="actions">
						<div class="icon-btn">
							🔔
							<span class="badge">3</span>
						</div>
						<div class="icon-btn">ℹ️</div>
						<div class="user-chip">
							<div class="avatar">DR</div>
							<div class="user-meta">
								<div class="user-name">Dr. ivan</div>
								<div class="user-role">Cardiology</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="page">
				<!-- KPI Overview -->
				<div class="kpi-grid">
					<div class="kpi">
						<div class="k-title">Total Consultations</div>
						<div class="k-value"><?= $stats['total'] ?? 0 ?></div>
						<div class="k-sub">This month</div>
						<div class="k-icon i-blue">🩺</div>
					</div>
					<div class="kpi">
						<div class="k-title">Active Cases</div>
						<div class="k-value"><?= $stats['active'] ?? 0 ?></div>
						<div class="k-sub">Currently active</div>
						<div class="k-icon i-green">📋</div>
					</div>
					<div class="kpi">
						<div class="k-title">Completed Today</div>
						<div class="k-value"><?= $stats['completed'] ?? 0 ?></div>
						<div class="k-sub">Finished today</div>
						<div class="k-icon i-orange">✅</div>
					</div>
					<div class="kpi">
						<div class="k-title">Emergency Cases</div>
						<div class="k-value"><?= $stats['emergency'] ?? 0 ?></div>
						<div class="k-sub">Last 24 hours</div>
						<div class="k-icon i-purple">🚨</div>
					</div>
				</div>



				<!-- Patient Consultations -->
				<div class="card">
					<div class="card-header">
						Patient Consultations
						<button class="btn btn-primary" onclick="openNewConsultationModal()">+ New Consultation</button>
					</div>
					<div class="list" id="consultationsList">
						<?php if (empty($consultations)): ?>
							<div class="empty-state">
								<div class="empty-icon">🩺</div>
								<div class="empty-title">No consultations yet</div>
								<div class="empty-subtitle">Start by creating a consultation from an appointment or click 'New Consultation'</div>
							</div>
						<?php else: ?>
							<?php foreach ($consultations as $consultation): ?>
								<div class="consultation-card">
									<div class="consultation-header">
										<div class="patient-info">
											<div class="patient-avatar"><?= strtoupper(substr($consultation['first_name'] . ' ' . $consultation['last_name'], 0, 1)) ?></div>
											<div class="patient-details">
												<div class="patient-name"><?= $consultation['first_name'] . ' ' . $consultation['last_name'] ?></div>
												<div class="patient-id">ID: <?= $consultation['patient_id'] ?></div>
											</div>
										</div>
										<div class="consultation-status <?= $consultation['status'] ?>">
											<?= ucfirst($consultation['status']) ?>
										</div>
									</div>
									<div class="consultation-details">
										<div class="consultation-type"><?= $consultation['consultation_type'] ?></div>
										<div class="chief-complaint"><?= $consultation['chief_complaint'] ?? 'No complaint recorded' ?></div>
										<div class="consultation-meta">
											<span class="consultation-date"><?= date('Y-m-d', strtotime($consultation['date_time'])) ?></span>
											<span class="consultation-time"><?= date('g:i A', strtotime($consultation['date_time'])) ?></span>
											<span class="consultation-duration"><?= $consultation['duration'] ?? '60' ?> minutes</span>
											<?php if (!empty($consultation['room'])): ?>
												<span class="consultation-room">📍 <?= $consultation['room'] ?></span>
											<?php endif; ?>
										</div>
									</div>
									<div class="consultation-actions">
										<button class="action-btn action-view" onclick="viewConsultation(<?= $consultation['id'] ?>)" title="View Details">👁️</button>
										<button class="action-btn action-edit" onclick="continueConsultation(<?= $consultation['id'] ?>)" title="Edit">✏️</button>
										<button class="action-btn action-print" onclick="printConsultation(<?= $consultation['id'] ?>)" title="Print">🖨️</button>
									</div>
								</div>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Consultation Modal - UPDATED DESIGN -->
	<div id="consultationModal" class="modal">
		<div class="modal-content">
			<div class="modal-header">
				<h3>New Consultation Record</h3>
				<span class="close" onclick="closeConsultationModal()">&times;</span>
			</div>
			<div class="modal-body">
				<form id="consultationForm">
					<div class="form-group">
						<label for="patientSelect">Patient</label>
						<select id="patientSelect" name="patient_id" required onchange="updatePatientId()">
							<option value="">Select a patient</option>
							<?php if (!empty($upcomingAppointments)): ?>
								<?php foreach ($upcomingAppointments as $appointment): ?>
									<option value="<?= $appointment['patient_db_id'] ?>" data-patient-name="<?= $appointment['patient_full_name'] ?>">
										<?= $appointment['patient_full_name'] ?> - <?= date('M d, Y', strtotime($appointment['date_time'])) ?>
									</option>
								<?php endforeach; ?>
							<?php endif; ?>
						</select>
					</div>
					
					<div class="form-group">
						<label for="patientId">Patient ID</label>
						<input type="text" id="patientId" name="patient_id_display" placeholder="Patient ID will be auto-filled" readonly>
					</div>
					
					<div class="form-group">
						<label for="consultationType">Consultation Type</label>
						<select id="consultationType" name="consultation_type" required>
							<option value="">Select type</option>
							<option value="Initial" selected>Initial Consultation</option>
							<option value="Follow-up">Follow-up</option>
							<option value="Emergency">Emergency</option>
							<option value="Routine">Routine Check-up</option>
						</select>
					</div>
					
					<div class="form-group">
						<label for="consultationDate">Date & Time</label>
						<input type="datetime-local" id="consultationDate" name="date_time" required>
					</div>
					
					<div class="form-group">
						<label>Vital Signs</label>
						<div class="vital-signs-grid">
							<div class="vital-item">
								<label for="bloodPressure">Blood Pressure</label>
								<input type="text" id="bloodPressure" name="blood_pressure" value="120/80" placeholder="120/80">
							</div>
							<div class="vital-item">
								<label for="heartRate">Heart Rate</label>
								<input type="text" id="heartRate" name="heart_rate" value="72 bpm" placeholder="72 bpm">
							</div>
							<div class="vital-item">
								<label for="temperature">Temperature</label>
								<input type="text" id="temperature" name="temperature" value="36.5°C" placeholder="36.5°C">
							</div>
							<div class="vital-item">
								<label for="weight">Weight</label>
								<input type="text" id="weight" name="weight" value="70 kg" placeholder="70 kg">
							</div>
						</div>
					</div>
					
					<div class="form-group">
						<label for="chiefComplaint">Chief Complaint</label>
						<textarea id="chiefComplaint" name="chief_complaint" rows="3" placeholder="Patient's main complaint or reason for visit"></textarea>
					</div>
					
					<div class="form-group">
						<label for="historyIllness">History of Present Illness</label>
						<textarea id="historyIllness" name="history_illness" rows="3" placeholder="Detailed history of the present illness"></textarea>
					</div>
					
					<div class="form-group">
						<label for="physicalExam">Physical Examination</label>
						<textarea id="physicalExam" name="physical_exam" rows="3" placeholder="Physical examination findings"></textarea>
					</div>
					
					<div class="form-group">
						<label for="assessment">Assessment & Diagnosis</label>
						<textarea id="assessment" name="assessment" rows="3" placeholder="Assessment and diagnosis"></textarea>
					</div>
					
					<div class="form-group">
						<label for="treatmentPlan">Treatment Plan</label>
						<textarea id="treatmentPlan" name="treatment_plan" rows="3" placeholder="Treatment plan and recommendations"></textarea>
					</div>
					

					
					<div class="form-group">
						<label for="notes">Additional Notes</label>
						<textarea id="notes" name="notes" rows="2" placeholder="Any additional notes or observations"></textarea>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" onclick="closeConsultationModal()">Cancel</button>
				<button type="button" class="btn btn-primary" onclick="saveNewConsultation()">Save Consultation</button>
			</div>
		</div>
	</div>

	<script>
		// Initialize when page loads
		document.addEventListener('DOMContentLoaded', function() {
			console.log('Page loaded!');
			
			// Set default consultation date to current date/time
			const now = new Date();
			const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
			document.getElementById('consultationDate').value = localDateTime;
		});
		
		// Function to update patient ID when patient is selected
		function updatePatientId() {
			const patientSelect = document.getElementById('patientSelect');
			const patientIdInput = document.getElementById('patientId');
			
			if (patientSelect.value) {
				patientIdInput.value = patientSelect.value;
			} else {
				patientIdInput.value = '';
			}
		}

		// Modal functions
		function openNewConsultationModal() {
			document.getElementById('consultationModal').style.display = 'block';
		}

		function closeConsultationModal() {
			document.getElementById('consultationModal').style.display = 'none';
			document.getElementById('consultationForm').reset();
			
			// Reset consultation date to current time
			const now = new Date();
			const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
			document.getElementById('consultationDate').value = localDateTime;
			
			// Reset patient ID field
			document.getElementById('patientId').value = '';
			
			// Reset vital signs to default values
			document.getElementById('bloodPressure').value = '120/80';
			document.getElementById('heartRate').value = '72 bpm';
			document.getElementById('temperature').value = '36.5°C';
			document.getElementById('weight').value = '70 kg';
		}

		function saveNewConsultation() {
			const form = document.getElementById('consultationForm');
			const formData = new FormData(form);
			
			// Validate required fields
			if (!formData.get('patient_id') || !formData.get('consultation_type') || !formData.get('date_time')) {
				alert('Please fill in all required fields');
				return;
			}
			
			// Add doctor_id to form data
			formData.append('doctor_id', '<?= session('user_id') ?>');
			
			// Debug: Log what we're sending
			console.log('Sending consultation data:');
			for (let [key, value] of formData.entries()) {
				console.log(key + ': ' + value);
			}
			
			// Submit consultation data to the save endpoint
			const url = '<?= site_url('doctor/consultations/save') ?>?t=' + Date.now();
			console.log('Sending to URL:', url);
			
			fetch(url, {
				method: 'POST',
				headers: {
					'X-Requested-With': 'XMLHttpRequest'
				},
				body: formData
			})
			.then(response => {
				console.log('Response status:', response.status);
				return response.json();
			})
			.then(data => {
				console.log('Response data:', data);
				if (data.success) {
					alert('Consultation created successfully!');
					closeConsultationModal();
					// Refresh the page to show new consultation
					location.reload();
				} else {
					alert('Error: ' + (data.message || 'Failed to create consultation'));
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error creating consultation. Please try again.');
			});
		}

		// Close modal when clicking outside
		window.onclick = function(event) {
			const modal = document.getElementById('consultationModal');
			if (event.target === modal) {
				closeConsultationModal();
			}
		}

		function viewConsultation(id) {
			alert('View Consultation ' + id + ' - To be implemented');
		}

		function continueConsultation(id) {
			alert('Continue Consultation ' + id + ' - To be implemented');
		}
		
		function printConsultation(id) {
			alert('Print Consultation ' + id + ' - To be implemented');
		}
	</script>
</body>
</html>
