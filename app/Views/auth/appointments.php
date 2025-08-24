<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Appointments</title>
	<link rel="stylesheet" href="<?= base_url('assets/css/appointments.css') ?>">
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/sidebar'); ?>

		<main class="main-content">
			<header class="header">
				<h1>Appointments</h1>
			</header>

			<div class="page-content">
				<div class="card form" style="display:flex; gap:12px; align-items:center; justify-content:space-between; padding:16px 20px">
					<div style="display:flex; gap:12px; align-items:center">
						<input type="date" class="search-input" style="width:auto" id="dateFilter" value="<?= date('Y-m-d') ?>">
						<select class="search-input" style="width:auto" id="statusFilter">
							<option value="">All Status</option>
							<option>Confirmed</option>
							<option>Pending</option>
							<option>Completed</option>
						</select>
					</div>
					<a class="btn primary" href="<?= site_url('appointments/schedule') ?>">New Appointment</a>
				</div>

				<?php foreach ($appointments as $a): ?>
				<div class="patients-table-container appt-card" data-date="<?= date('Y-m-d', strtotime($a['date_time'])) ?>" data-status="<?= esc($a['status']) ?>" style="padding:0; overflow:visible">
					<div style="display:flex; gap:16px; padding:16px 18px; align-items:flex-start">
						<div style="min-width:120px">
							<div style="font-size:22px; font-weight:800; color:#1d4ed8;">
								<?= date('g:i A', strtotime($a['date_time'])) ?>
							</div>
							<span class="badge <?= strtolower($a['status']) ?>" style="margin-top:6px; display:inline-block"><?= esc($a['status']) ?></span>
						</div>
						<div style="flex:1">
							<div class="table-title" style="margin:0 0 6px">Patient Information</div>
							<div class="sub" style="color:#0f172a"><strong>Name:</strong> <?= esc($a['patient_name']) ?></div>
							<div class="sub"><strong>Phone:</strong> <?= esc($a['patient_phone'] ?: '—') ?></div>
							<div class="sub"><strong>Type:</strong> <?= esc($a['type']) ?></div>
						</div>
						<div style="flex:1">
							<div class="table-title" style="margin:0 0 6px">Appointment Details</div>
							<div class="sub"><strong>Doctor:</strong> <?= esc($a['doctor_name']) ?></div>
							<div class="sub"><strong>Department:</strong> <?= esc('') ?></div>
							<div class="sub"><strong>Reason:</strong> <?= esc(isset($a['notes']) && $a['notes'] !== '' ? $a['notes'] : '—') ?></div>
						</div>
						<div style="display:flex; gap:10px; align-items:center">
							<a href="#" class="icon" title="Edit" onclick="openEditDoc(<?= (int)$a['id'] ?>);return false;">✏️</a>
							<a href="tel:<?= esc($a['patient_phone']) ?>" class="icon" title="Call">📞</a>
							<a href="<?= site_url('appointments/delete/'.$a['id']) ?>" class="icon danger" title="Delete" onclick="return confirm('Delete appointment?')">🗑️</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>

			<!-- Modal -->
			<div class="modal" id="scheduleModal" aria-hidden="true">
				<div class="modal-backdrop" id="closeBackdrop"></div>
				<div class="modal-dialog">
					<div class="modal-header">
						<h3>Schedule New Appointment</h3>
						<button class="modal-close" id="closeModal" aria-label="Close">×</button>
					</div>
					<form method="post" action="<?= site_url('appointments/store') ?>">
						<div class="modal-body">
							<div class="grid-2 modal-grid">
								<label>
									<span>Patient Name *</span>
									<input type="text" name="patient_name" required>
								</label>
								<label>
									<span>Doctor *</span>
									<select name="doctor_name" required>
										<option value="">Select Doctor</option>
										<?php 
										// Get doctors from UserModel for the dropdown
										$userModel = new \App\Models\UserModel();
										$doctors = $userModel->where('role', 'doctor')
															->where('status', 'Active')
															->orderBy('name', 'ASC')
															->findAll();
										?>
										<?php foreach ($doctors as $doctor): ?>
											<option value="<?= esc($doctor['name']) ?>">
												<?= esc($doctor['name']) ?>
												<?php if (!empty($doctor['specialty'])): ?>
													(<?= esc($doctor['specialty']) ?>)
												<?php endif; ?>
											</option>
										<?php endforeach; ?>
									</select>
								</label>
							</div>

							<div class="grid-2 modal-grid">
								<label>
									<span>Date *</span>
									<input type="date" name="date" required>
								</label>
								<label>
									<span>Time *</span>
									<input type="time" name="time" required>
								</label>
							</div>

							<div class="grid-2 modal-grid">
								<label>
									<span>Appointment Type *</span>
									<select name="type" required>
										<option>Consultation</option>
										<option>Follow-up</option>
										<option>Checkup</option>
										<option>Emergency</option>
									</select>
								</label>
								<label>
									<span>Status *</span>
									<select name="status" required>
										<option selected>Pending</option>
										<option>Confirmed</option>
										<option>Completed</option>
									</select>
								</label>
							</div>

							<label>
								<span>Notes</span>
								<textarea name="notes" placeholder="Additional details..."></textarea>
							</label>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" id="cancelModal">Cancel</button>
							<button class="btn primary" type="submit">Schedule Appointment</button>
						</div>
					</form>
				</div>
			</div>

			<!-- View Appointment Modal -->
			<div class="modal" id="viewApptModal" aria-hidden="true">
				<div class="modal-backdrop" id="closeViewApptBackdrop"></div>
				<div class="modal-dialog">
					<div class="modal-header">
						<h3>Appointment Details</h3>
						<button class="modal-close" id="closeViewAppt" aria-label="Close">×</button>
					</div>
					<div class="modal-body">
						<p><strong>ID:</strong> <span id="vaId"></span></p>
						<p><strong>Patient:</strong> <span id="vaPatient"></span></p>
						<p><strong>Doctor:</strong> <span id="vaDoctor"></span></p>
						<p><strong>Date & Time:</strong> <span id="vaDateTime"></span></p>
						<p><strong>Type:</strong> <span id="vaType"></span></p>
						<p><strong>Status:</strong> <span id="vaStatus"></span></p>
						<p><strong>Notes:</strong> <span id="vaNotes"></span></p>
					</div>
					<div class="modal-footer">
						<button class="btn" type="button" id="closeViewApptFooter">Close</button>
					</div>
				</div>
			</div>

			<!-- Edit Doctor Modal -->
			<div class="modal" id="editDocModal" aria-hidden="true">
				<div class="modal-backdrop" id="closeEditDocBackdrop"></div>
				<div class="modal-dialog">
					<div class="modal-header">
						<h3>Edit Doctor</h3>
						<button class="modal-close" id="closeEditDoc" aria-label="Close">×</button>
					</div>
					<form method="post" id="editDocForm">
						<div class="modal-body">
							<label>
								<span>Doctor</span>
								<select name="doctor_name" id="editDoctor" required>
									<option value="">Select Doctor</option>
									<?php 
									// Get doctors from UserModel for the dropdown
									$userModel = new \App\Models\UserModel();
									$doctors = $userModel->where('role', 'doctor')
														->where('status', 'Active')
														->orderBy('name', 'ASC')
														->findAll();
									?>
									<?php foreach ($doctors as $doctor): ?>
										<option value="<?= esc($doctor['name']) ?>">
											<?= esc($doctor['name']) ?>
											<?php if (!empty($doctor['specialty'])): ?>
												(<?= esc($doctor['specialty']) ?>)
											<?php endif; ?>
										</option>
									<?php endforeach; ?>
								</select>
							</label>
						</div>
						<div class="modal-footer">
							<button class="btn" type="button" id="cancelEditDoc">Cancel</button>
							<button class="btn primary" type="submit">Save</button>
						</div>
					</form>
				</div>
			</div>
		</main>
	</div>

	<script>
		// Filters for date and status
		const dateFilter = document.getElementById('dateFilter');
		const statusFilter = document.getElementById('statusFilter');
		function applyFilters(){
			const d = dateFilter.value;
			const s = statusFilter.value;
			document.querySelectorAll('.appt-card').forEach(c => {
				const okDate = !d || c.getAttribute('data-date') === d;
				const okStatus = !s || c.getAttribute('data-status') === s;
				c.style.display = (okDate && okStatus) ? '' : 'none';
			});
		}
		dateFilter?.addEventListener('change', applyFilters);
		statusFilter?.addEventListener('change', applyFilters);
		applyFilters();

		// View appointment (kept for edit/delete icons)
		const vAppt = document.getElementById('viewApptModal');
		function openViewAppt(id){
			fetch(`<?= site_url('appointments/json') ?>/${id}`)
				.then(r => r.json())
				.then(a => {
					document.getElementById('vaId').textContent = a.appointment_code ?? `APT${String(a.id).padStart(3,'0')}`;
					document.getElementById('vaPatient').textContent = `${a.patient_name ?? ''} ${a.patient_phone ? '('+a.patient_phone+')' : ''}`;
					document.getElementById('vaDoctor').textContent = a.doctor_name ?? '';
					document.getElementById('vaDateTime').textContent = a.date_time ?? '';
					document.getElementById('vaType').textContent = a.type ?? '';
					document.getElementById('vaStatus').textContent = a.status ?? '';
					document.getElementById('vaNotes').textContent = a.notes ?? '';
					vAppt.classList.add('open');
				})
				.catch(() => vAppt.classList.add('open'));
		}
		function closeViewAppt(){ vAppt.classList.remove('open'); }
		document.querySelectorAll('.js-appt-view').forEach(b=>b.addEventListener('click',e=>{e.preventDefault();openViewAppt(b.getAttribute('data-id'));}));
		document.getElementById('closeViewAppt')?.addEventListener('click', closeViewAppt);
		document.getElementById('closeViewApptBackdrop')?.addEventListener('click', closeViewAppt);
		document.getElementById('closeViewApptFooter')?.addEventListener('click', closeViewAppt);

		// Edit doctor only
		const eDoc = document.getElementById('editDocModal');
		const editDoctor = document.getElementById('editDoctor');
		const editDocForm = document.getElementById('editDocForm');
		let editingApptId = null;
		function openEditDoc(id){
			editingApptId = id;
			fetch(`<?= site_url('appointments/json') ?>/${id}`).then(r=>r.json()).then(a=>{
				editDoctor.value = a.doctor_name ?? '';
				eDoc.classList.add('open');
			});
		}
		function closeEditDoc(){ eDoc.classList.remove('open'); }
		document.querySelectorAll('.js-appt-edit').forEach(b=>b.addEventListener('click',e=>{e.preventDefault();openEditDoc(b.getAttribute('data-id'));}));
		document.getElementById('closeEditDocBackdrop')?.addEventListener('click', closeEditDoc);
		document.getElementById('closeEditDoc')?.addEventListener('click', closeEditDoc);
		document.getElementById('cancelEditDoc')?.addEventListener('click', closeEditDoc);
		editDocForm?.addEventListener('submit', () => {
			if (!editingApptId) return;
			editDocForm.setAttribute('action', `<?= site_url('appointments/update') ?>/${editingApptId}`);
		});
	</script>
</body>
</html>


