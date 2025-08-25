<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • Prescriptions</title>
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
		.list{padding:20px}
		.empty-state{text-align:center;padding:60px 20px;color:#64748b}
		.empty-icon{font-size:48px;margin-bottom:16px}
		.empty-title{font-weight:700;color:#0f172a;margin-bottom:8px}
		.empty-subtitle{font-size:14px}
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
				<a href="<?= site_url('doctor/prescriptions') ?>" class="menu-item active">
					<span class="menu-icon">💊</span>
					<span>Prescriptions</span>
				</a>
				<a href="<?= site_url('doctor/lab-requests') ?>" class="menu-item">
					<span class="menu-icon">🧪</span>
					<span>Lab Requests</span>
				</a>
				<a href="<?= site_url('doctor/consultations') ?>" class="menu-item">
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
					<h1>Prescriptions</h1>
					<div class="sub">Manage patient prescriptions and medication orders</div>
				</div>
				<div class="header-right">
					<div class="search-box">
						<input type="text" class="search-input" placeholder="Search patients, appointments...">
						<span class="search-icon">🔍</span>
					</div>
					<div class="actions">
						<div class="icon-btn">
							🔔
							<span class="badge">3</span>
						</div>
						<div class="icon-btn" style="background:#fef2f2;color:#ef4444;">
							ℹ️
						</div>
						<div class="user-chip">
							<div class="avatar">DR</div>
							<div class="user-meta">
								<div class="user-name"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Maria Santos') : 'Dr. Maria Santos' ?></div>
								<div class="user-role"><?= session('specialty') ?? 'Cardiology' ?></div>
							</div>
							<span>▼</span>
						</div>
					</div>
				</div>
			</div>

			<div class="page">
				<!-- Statistics Cards -->
				<div class="kpi-grid">
					<div class="kpi">
						<div class="k-title">Total Prescriptions</div>
						<div class="k-value"><?= $stats['total_prescriptions'] ?? 0 ?></div>
						<div class="k-sub">This month</div>
						<div class="k-icon i-blue">💊</div>
					</div>
					<div class="kpi">
						<div class="k-title">Active Prescriptions</div>
						<div class="k-value"><?= $stats['active_prescriptions'] ?? 0 ?></div>
						<div class="k-sub">Currently active</div>
						<div class="k-icon i-green">❤️</div>
					</div>
					<div class="kpi">
						<div class="k-title">Pending Approvals</div>
						<div class="k-value"><?= $stats['pending_approvals'] ?? 0 ?></div>
						<div class="k-sub">Awaiting pharmacy</div>
						<div class="k-icon i-orange">⏰</div>
					</div>
					<div class="kpi">
						<div class="k-title">Refills Needed</div>
						<div class="k-value"><?= $stats['refills_needed'] ?? 0 ?></div>
						<div class="k-sub">Due this week</div>
						<div class="k-icon i-purple">🔄</div>
					</div>
				</div>

				<!-- Prescription History -->
				<div class="card">
					<div class="card-header">
						<span>Prescription History</span>
						<button class="btn btn-primary" id="newPrescriptionBtn">+ New Prescription</button>
					</div>
					<div class="list">
						<?php if (!empty($prescriptions)): ?>
							<?php foreach ($prescriptions as $prescription): ?>
								<?php 
								$medications = json_decode($prescription['medications'], true) ?? [];
								$statusClass = $prescription['status'] === 'Pending' ? 'status-pending' : 'status-active';
								?>
								<div class="prescription-item" style="border:1px solid #e5e7eb; border-radius:8px; padding:16px; margin-bottom:16px;">
									<div style="display:flex; justify-content:space-between; align-items:flex-start;">
										<div>
											<h4 style="margin:0 0 8px 0; color:#1f2937;"><?= esc($prescription['prescription_id']) ?></h4>
											<p style="margin:0 0 4px 0; color:#6b7280; font-size:14px;">Patient: <?= esc($prescription['patient_name']) ?></p>
											<p style="margin:0 0 4px 0; color:#6b7280; font-size:14px;">Diagnosis: <?= esc($prescription['diagnosis']) ?></p>
											<p style="margin:0 0 4px 0; color:#6b7280; font-size:14px;">Created: <?= date('M d, Y', strtotime($prescription['created_date'])) ?></p>
										</div>
										<div style="text-align:right;">
											<span class="status-badge <?= $statusClass ?>" style="padding:4px 8px; border-radius:4px; font-size:12px; font-weight:600; background:#fef3c7; color:#d97706;"><?= esc($prescription['status']) ?></span>
											<p style="margin:4px 0 0 0; color:#6b7280; font-size:12px;">₱<?= number_format($prescription['total_amount'], 2) ?></p>
										</div>
									</div>
									<?php if (!empty($medications)): ?>
										<div style="margin-top:12px; padding-top:12px; border-top:1px solid #f3f4f6;">
											<p style="margin:0 0 8px 0; font-size:12px; font-weight:600; color:#374151;">Medications:</p>
											<?php foreach ($medications as $medication): ?>
												<div style="font-size:12px; color:#6b7280; margin-bottom:4px;">
													• <?= esc($medication['name']) ?> - <?= esc($medication['dosage']) ?> <?= esc($medication['frequency']) ?>
												</div>
											<?php endforeach; ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<div class="empty-state">
								<div class="empty-icon">💊</div>
								<div class="empty-title">No Prescriptions Yet</div>
								<div class="empty-subtitle">Start creating prescriptions for your patients. Click the "+ New Prescription" button to get started.</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Create New Prescription Modal -->
	<div id="createPrescriptionModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
		<div style="background:#fff; border-radius:16px; width:90%; max-width:700px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
			<div style="padding:24px 32px; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
				<h2 style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">Create New Prescription</h2>
				<button id="closePrescriptionModal" style="background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">×</button>
			</div>
			
			<form id="prescriptionForm" style="padding:32px;">
				<!-- Patient Information -->
				<div style="margin-bottom:24px;">
					<h3 style="font-size:16px; font-weight:600; color:#374151; margin-bottom:16px;">Patient Information</h3>
					<div style="display:grid; grid-template-columns:1fr 1fr; gap:16px;">
						<div>
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Patient Name *</label>
							<select id="patientName" name="patient_name" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
								<option value="">Select Patient</option>
								<?php if (!empty($patients)): ?>
									<?php foreach ($patients as $patient): ?>
										<option value="<?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?>" data-patient-id="<?= $patient['id'] ?>">
											<?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?> (ID: P-<?= str_pad($patient['id'], 6, '0', STR_PAD_LEFT) ?>)
										</option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						</div>
						<div>
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Patient ID *</label>
							<input type="text" id="patientId" name="patient_id" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
						</div>
					</div>
				</div>

				<!-- Diagnosis -->
				<div style="margin-bottom:24px;">
					<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Diagnosis *</label>
					<input type="text" id="diagnosis" name="diagnosis" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;" placeholder="Enter patient diagnosis...">
				</div>

				<!-- Medications Section -->
				<div style="margin-bottom:24px;">
					<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:16px;">
						<h3 style="font-size:16px; font-weight:600; color:#374151; margin:0;">Medications</h3>
						<button type="button" id="addMedicationBtn" style="background:none; border:none; color:#2563eb; font-weight:600; cursor:pointer; font-size:14px;">+ Add Medication</button>
					</div>
					
					<div id="medicationsContainer">
						<div class="medication-item" style="border:1px solid #e5e7eb; border-radius:8px; padding:16px; margin-bottom:16px;">
							<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
								<div>
									<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Medication Name *</label>
									<select name="medications[0][name]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
										<option value="">Select Medication</option>
										<option value="Paracetamol">Paracetamol</option>
										<option value="Ibuprofen">Ibuprofen</option>
										<option value="Amoxicillin">Amoxicillin</option>
										<option value="Lisinopril">Lisinopril</option>
										<option value="Metformin">Metformin</option>
										<option value="Atorvastatin">Atorvastatin</option>
										<option value="Omeprazole">Omeprazole</option>
										<option value="Amlodipine">Amlodipine</option>
										<option value="Aspirin">Aspirin</option>
										<option value="Simvastatin">Simvastatin</option>
										<option value="Losartan">Losartan</option>
										<option value="Metoprolol">Metoprolol</option>
										<option value="Furosemide">Furosemide</option>
										<option value="Warfarin">Warfarin</option>
										<option value="Insulin">Insulin</option>
									</select>
								</div>
								<div>
									<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Dosage *</label>
									<input type="text" name="medications[0][dosage]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;" placeholder="e.g., 500mg">
								</div>
								<div>
									<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Frequency *</label>
									<select name="medications[0][frequency]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
										<option value="">Select frequency</option>
										<option value="Once daily">Once daily</option>
										<option value="Twice daily">Twice daily</option>
										<option value="Three times daily">Three times daily</option>
										<option value="Four times daily">Four times daily</option>
										<option value="As needed">As needed</option>
										<option value="Every 6 hours">Every 6 hours</option>
										<option value="Every 8 hours">Every 8 hours</option>
										<option value="Every 12 hours">Every 12 hours</option>
									</select>
								</div>
							</div>
							<div style="margin-top:16px;">
								<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Duration *</label>
								<input type="text" name="medications[0][duration]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;" placeholder="e.g., 7 days, 30 days">
							</div>
						</div>
					</div>
				</div>

				<!-- Additional Notes -->
				<div style="margin-bottom:24px;">
					<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Additional Notes</label>
					<textarea id="notes" name="notes" rows="4" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; resize:vertical;" placeholder="Special instructions, warnings, or additional information..."></textarea>
				</div>
				
				<div style="display:flex; gap:12px; justify-content:flex-end; margin-top:32px; padding-top:24px; border-top:1px solid #e5e7eb;">
					<button type="button" id="cancelPrescriptionBtn" style="padding:12px 24px; background:#f3f4f6; color:#374151; border:1px solid #d1d5db; border-radius:8px; font-weight:600; cursor:pointer;">Cancel</button>
					<button type="submit" style="padding:12px 24px; background:#2563eb; color:#fff; border:none; border-radius:8px; font-weight:600; cursor:pointer;">Create Prescription</button>
				</div>
			</form>
		</div>
	</div>

	<script>
	(function(){
		// Modal elements
		const newPrescriptionBtn = document.getElementById('newPrescriptionBtn');
		const createPrescriptionModal = document.getElementById('createPrescriptionModal');
		const closePrescriptionModal = document.getElementById('closePrescriptionModal');
		const cancelPrescriptionBtn = document.getElementById('cancelPrescriptionBtn');
		const prescriptionForm = document.getElementById('prescriptionForm');
		const addMedicationBtn = document.getElementById('addMedicationBtn');
		const medicationsContainer = document.getElementById('medicationsContainer');
		
		let medicationCount = 1;
		
		// Open modal
		newPrescriptionBtn.addEventListener('click', () => {
			createPrescriptionModal.style.display = 'flex';
			createPrescriptionModal.style.alignItems = 'center';
			createPrescriptionModal.style.justifyContent = 'center';
		});
		
		// Close modal functions
		function closePrescriptionModalFunc() {
			createPrescriptionModal.style.display = 'none';
			prescriptionForm.reset();
			// Reset medications to just one
			medicationsContainer.innerHTML = `
				<div class="medication-item" style="border:1px solid #e5e7eb; border-radius:8px; padding:16px; margin-bottom:16px;">
					<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
						<div>
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Medication Name *</label>
							<select name="medications[0][name]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
								<option value="">Select Medication</option>
								<option value="Paracetamol">Paracetamol</option>
								<option value="Ibuprofen">Ibuprofen</option>
								<option value="Amoxicillin">Amoxicillin</option>
								<option value="Lisinopril">Lisinopril</option>
								<option value="Metformin">Metformin</option>
								<option value="Atorvastatin">Atorvastatin</option>
								<option value="Omeprazole">Omeprazole</option>
								<option value="Amlodipine">Amlodipine</option>
								<option value="Aspirin">Aspirin</option>
								<option value="Simvastatin">Simvastatin</option>
								<option value="Losartan">Losartan</option>
								<option value="Metoprolol">Metoprolol</option>
								<option value="Furosemide">Furosemide</option>
								<option value="Warfarin">Warfarin</option>
								<option value="Insulin">Insulin</option>
							</select>
						</div>
						<div>
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Dosage *</label>
							<input type="text" name="medications[0][dosage]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;" placeholder="e.g., 500mg">
						</div>
						<div>
							<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Frequency *</label>
							<select name="medications[0][frequency]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
								<option value="">Select frequency</option>
								<option value="Once daily">Once daily</option>
								<option value="Twice daily">Twice daily</option>
								<option value="Three times daily">Three times daily</option>
								<option value="Four times daily">Four times daily</option>
								<option value="As needed">As needed</option>
								<option value="Every 6 hours">Every 6 hours</option>
								<option value="Every 8 hours">Every 8 hours</option>
								<option value="Every 12 hours">Every 12 hours</option>
							</select>
						</div>
					</div>
					<div style="margin-top:16px;">
						<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Duration *</label>
						<input type="text" name="medications[0][duration]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;" placeholder="e.g., 7 days, 30 days">
					</div>
				</div>
			`;
			medicationCount = 1;
		}
		
		closePrescriptionModal.addEventListener('click', closePrescriptionModalFunc);
		cancelPrescriptionBtn.addEventListener('click', closePrescriptionModalFunc);
		
		// Close modal when clicking outside
		createPrescriptionModal.addEventListener('click', (e) => {
			if (e.target === createPrescriptionModal) {
				closePrescriptionModalFunc();
			}
		});
		
		// Add medication functionality
		addMedicationBtn.addEventListener('click', () => {
			const newMedication = document.createElement('div');
			newMedication.className = 'medication-item';
			newMedication.style.cssText = 'border:1px solid #e5e7eb; border-radius:8px; padding:16px; margin-bottom:16px; position:relative;';
			
			newMedication.innerHTML = `
				<button type="button" class="remove-medication" style="position:absolute; top:8px; right:8px; background:#ef4444; color:#fff; border:none; border-radius:50%; width:24px; height:24px; cursor:pointer; font-size:12px;">×</button>
				<div style="display:grid; grid-template-columns:1fr 1fr 1fr; gap:16px;">
					<div>
						<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Medication Name *</label>
						<select name="medications[${medicationCount}][name]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
							<option value="">Select Medication</option>
							<option value="Paracetamol">Paracetamol</option>
							<option value="Ibuprofen">Ibuprofen</option>
							<option value="Amoxicillin">Amoxicillin</option>
							<option value="Lisinopril">Lisinopril</option>
							<option value="Metformin">Metformin</option>
							<option value="Atorvastatin">Atorvastatin</option>
							<option value="Omeprazole">Omeprazole</option>
							<option value="Amlodipine">Amlodipine</option>
							<option value="Aspirin">Aspirin</option>
							<option value="Simvastatin">Simvastatin</option>
							<option value="Losartan">Losartan</option>
							<option value="Metoprolol">Metoprolol</option>
							<option value="Furosemide">Furosemide</option>
							<option value="Warfarin">Warfarin</option>
							<option value="Insulin">Insulin</option>
						</select>
					</div>
					<div>
						<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Dosage *</label>
						<input type="text" name="medications[${medicationCount}][dosage]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;" placeholder="e.g., 500mg">
					</div>
					<div>
						<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Frequency *</label>
						<select name="medications[${medicationCount}][frequency]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
							<option value="">Select frequency</option>
							<option value="Once daily">Once daily</option>
							<option value="Twice daily">Twice daily</option>
							<option value="Three times daily">Three times daily</option>
							<option value="Four times daily">Four times daily</option>
							<option value="As needed">As needed</option>
							<option value="Every 6 hours">Every 6 hours</option>
							<option value="Every 8 hours">Every 8 hours</option>
							<option value="Every 12 hours">Every 12 hours</option>
						</select>
					</div>
				</div>
				<div style="margin-top:16px;">
					<label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Duration *</label>
					<input type="text" name="medications[${medicationCount}][duration]" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;" placeholder="e.g., 7 days, 30 days">
				</div>
			`;
			
			medicationsContainer.appendChild(newMedication);
			medicationCount++;
			
			// Add remove functionality to the new medication
			const removeBtn = newMedication.querySelector('.remove-medication');
			removeBtn.addEventListener('click', () => {
				newMedication.remove();
			});
		});
		
		// Handle form submission
		prescriptionForm.addEventListener('submit', (e) => {
			e.preventDefault();
			
			const formData = new FormData(prescriptionForm);
			
			// Add doctor information
			formData.append('doctor_id', '<?= session('user_id') ?? '' ?>');
			formData.append('doctor_name', '<?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Maria Santos') : 'Dr. Maria Santos' ?>');
			formData.append('status', 'Pending');
			formData.append('created_date', new Date().toISOString().split('T')[0]);
			
			// Send to backend
			fetch('<?= site_url('doctor/prescriptions/create') ?>', {
				method: 'POST',
				body: formData
			})
			.then(response => response.json())
			.then(data => {
				if (data.success) {
					alert('Prescription created successfully!');
					closePrescriptionModalFunc();
					location.reload(); // Refresh to show new prescription
				} else {
					alert('Error: ' + (data.message || 'Failed to create prescription'));
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error creating prescription. Please try again.');
			});
		});
		
		// Search functionality
		const searchInput = document.querySelector('.search-input');
		searchInput.addEventListener('input', (e) => {
			const searchTerm = e.target.value.toLowerCase();
			// TODO: Implement search functionality
			console.log('Searching for:', searchTerm);
		});
		
		// User dropdown (placeholder)
		const userChip = document.querySelector('.user-chip');
		userChip.addEventListener('click', () => {
			alert('User menu coming soon!');
		});
		
		// Auto-fill patient ID when patient is selected
		const patientNameSelect = document.getElementById('patientName');
		const patientIdInput = document.getElementById('patientId');
		
		patientNameSelect.addEventListener('change', function() {
			const selectedOption = this.options[this.selectedIndex];
			const patientId = selectedOption.getAttribute('data-patient-id');
			
			if (patientId) {
				patientIdInput.value = 'P-' + patientId.padStart(6, '0');
			} else {
				patientIdInput.value = '';
			}
		});
		
		// Notification bell
		const notificationBtn = document.querySelector('.icon-btn');
		notificationBtn.addEventListener('click', () => {
			alert('Notifications coming soon!');
		});
	})();
	</script>
</body>
</html>

