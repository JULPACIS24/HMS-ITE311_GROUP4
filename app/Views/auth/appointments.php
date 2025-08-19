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
		<nav class="sidebar">
			<div class="sidebar-header">
				<div class="admin-icon">A</div>
				<span class="sidebar-title">Administrator</span>
			</div>
			<div class="sidebar-menu">
				<a href="<?= site_url('dashboard') ?>" class="menu-item">
					<span class="menu-icon">📊</span>
					Dashboard
				</a>
				<a href="<?= site_url('patients') ?>" class="menu-item">
					<span class="menu-icon">👥</span>
					Patients
				</a>
				<a href="<?= site_url('appointments') ?>" class="menu-item active">
					<span class="menu-icon">📅</span>
					Appointments
				</a>
				<a href="<?= site_url('billing') ?>" class="menu-item">
					<span class="menu-icon">💳</span>
					Billing & Payments
				</a>
				<a href="<?= site_url('laboratory') ?>" class="menu-item">
					<span class="menu-icon">🧪</span>
					Laboratory
				</a>
				<a href="<?= site_url('pharmacy') ?>" class="menu-item">
					<span class="menu-icon">💊</span>
					Pharmacy & Inventory
				</a>
				<a href="<?= site_url('reports') ?>" class="menu-item">
					<span class="menu-icon">📈</span>
					Reports
				</a>
				<a href="<?= site_url('users') ?>" class="menu-item">
					<span class="menu-icon">👤</span>
					User Management
				</a>
				<a href="<?= site_url('settings') ?>" class="menu-item">
					<span class="menu-icon">⚙️</span>
					Settings
				</a>
				<a href="<?= site_url('logout') ?>" class="menu-item">
					<span class="menu-icon">🚪</span>
					Logout
				</a>
			</div>
		</nav>

		<main class="main-content">
			<header class="header">
				<h1>Appointments</h1>
				<div class="user-info">
					<div class="user-avatar">A</div>
					<span>Admin</span>
				</div>
			</header>

			<div class="page-content">
				<div class="stats-grid">
					<div class="stat-card">
						<div class="stat-header"><span class="stat-title">Today's Appointments</span><div class="stat-icon">📅</div></div>
						<div class="stat-value"><?= count(array_filter($appointments, fn($a) => date('Y-m-d', strtotime($a['date_time'])) === date('Y-m-d'))) ?></div>
					</div>
					<div class="stat-card">
						<div class="stat-header"><span class="stat-title">Confirmed</span><div class="stat-icon">✅</div></div>
						<div class="stat-value"><?= count(array_filter($appointments, fn($a) => $a['status'] === 'Confirmed')) ?></div>
					</div>
					<div class="stat-card">
						<div class="stat-header"><span class="stat-title">Pending</span><div class="stat-icon">⏳</div></div>
						<div class="stat-value"><?= count(array_filter($appointments, fn($a) => $a['status'] === 'Pending')) ?></div>
					</div>
					<div class="stat-card">
						<div class="stat-header"><span class="stat-title">This Week</span><div class="stat-icon">📈</div></div>
						<?php $start = strtotime('monday this week'); $end = strtotime('sunday this week 23:59:59'); ?>
						<div class="stat-value"><?= count(array_filter($appointments, fn($a) => ($t=strtotime($a['date_time'])) >= $start && $t <= $end)) ?></div>
					</div>
				</div>

				<div class="action-bar">
					<div class="search-box">
						<input type="text" class="search-input" id="search" placeholder="Search appointments...">
					</div>
					<button class="btn primary" id="openModal" type="button">+ Schedule Appointment</button>
				</div>

				<div class="patients-table-container">
					<table class="patients-table">
						<thead>
							<tr>
								<th>Appointment ID</th>
								<th>Patient</th>
								<th>Doctor</th>
								<th>Date & Time</th>
								<th>Type</th>
								<th>Status</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($appointments as $a): ?>
						<tr>
							<td class="muted"><?= esc($a['appointment_code'] ?: sprintf('APT%03d', $a['id'])) ?></td>
							<td>
								<div class="patient"><?= esc($a['patient_name']) ?></div>
								<div class="sub"><?= esc($a['patient_phone'] ?: '') ?></div>
							</td>
							<td class="muted"><?= esc($a['doctor_name']) ?></td>
							<td>
								<div class="muted"><?= date('n/j/Y', strtotime($a['date_time'])) ?></div>
								<div class="sub"><?= date('g:i A', strtotime($a['date_time'])) ?></div>
							</td>
							<td class="muted"><?= esc($a['type']) ?></td>
							<td><span class="badge <?= strtolower($a['status']) ?>"><?= esc($a['status']) ?></span></td>
							<td class="actions">
								<a href="#" data-id="<?= $a['id'] ?>" class="btn js-appt-view" style="background:#1e88e5;color:#fff">View</a>
								<a href="#" data-id="<?= $a['id'] ?>" class="btn js-appt-edit" style="background:#f39c12;color:#fff">Edit</a>
								<form action="<?= site_url('appointments/status/' . $a['id']) ?>" method="post" class="inline">
									<select name="status" onchange="this.form.submit()">
										<option <?= $a['status']==='Confirmed'?'selected':'' ?>>Confirmed</option>
										<option <?= $a['status']==='Pending'?'selected':'' ?>>Pending</option>
										<option <?= $a['status']==='Completed'?'selected':'' ?>>Completed</option>
									</select>
								</form>
								<a href="<?= site_url('appointments/delete/' . $a['id']) ?>" class="btn" style="background:#e74c3c;color:#fff" onclick="return confirm('Delete appointment?')">Delete</a>
							</td>
						</tr>
						<?php endforeach; ?>
						</tbody>
					</table>
				</div>
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
									<input type="text" name="doctor_name" placeholder="Select Doctor" required>
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
								<input type="text" name="doctor_name" id="editDoctor" required>
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
		const search = document.getElementById('search');
		search?.addEventListener('input', () => {
			const q = search.value.toLowerCase();
			for (const row of document.querySelectorAll('.trow')) {
				row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
			}
		});

		// Modal wiring
		const modal = document.getElementById('scheduleModal');
		const openBtn = document.getElementById('openModal');
		const closeBtn = document.getElementById('closeModal');
		const cancelBtn = document.getElementById('cancelModal');
		const closeBackdrop = document.getElementById('closeBackdrop');
		function openModal(){ modal.classList.add('open'); }
		function closeModal(){ modal.classList.remove('open'); }
		openBtn?.addEventListener('click', openModal);
		closeBtn?.addEventListener('click', closeModal);
		cancelBtn?.addEventListener('click', closeModal);
		closeBackdrop?.addEventListener('click', closeModal);

		// View appointment
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


