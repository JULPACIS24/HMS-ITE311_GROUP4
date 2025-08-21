<?php echo view('auth/partials/header', ['title' => 'Nurse Scheduling']); ?>
<div class="container">
	<?php echo view('auth/partials/sidebar'); ?>
	<main class="main-content">
		<header class="header"><h1>Nurse Scheduling</h1></header>
		<div class="page-content">
			<div class="card form" style="display:flex; gap:12px; align-items:center; justify-content:space-between; padding:16px 20px">
				<div style="display:flex; gap:12px; align-items:center">
					<input type="date" class="search-input" style="width:auto" value="<?= date('Y-m-d') ?>">
					<select class="search-input" style="width:auto"><option>All Departments</option><option>Emergency</option><option>ICU</option><option>Pediatrics</option><option>Surgery</option><option>Maternity</option></select>
				</div>
				<button class="btn primary" id="addNurseSchedBtn">Add Nurse Schedule</button>
			</div>
			<div class="patients-table-container">
				<table class="patients-table">
					<thead><tr><th>Nurse Details</th><th>Department</th><th>Shift & Time</th><th>Status</th><th>Patients Assigned</th><th>Actions</th></tr></thead>
					<tbody>
						<tr><td><strong>Maria Santos</strong><div class="sub">5 years experience</div></td><td>Emergency</td><td>Morning Shift<div class="sub">6:00 AM - 2:00 PM</div></td><td><span class="badge completed">Active</span></td><td>8 patients</td><td class="actions"><a class="btn" href="#">Edit</a> <a class="btn" href="#">Remove</a></td></tr>
						<tr><td><strong>Ana Rodriguez</strong><div class="sub">8 years experience</div></td><td>ICU</td><td>Night Shift<div class="sub">10:00 PM - 6:00 AM</div></td><td><span class="badge completed">Active</span></td><td>4 patients</td><td class="actions"><a class="btn" href="#">Edit</a> <a class="btn" href="#">Remove</a></td></tr>
						<tr><td><strong>Carmen Lopez</strong><div class="sub">3 years experience</div></td><td>Pediatrics</td><td>Evening Shift<div class="sub">2:00 PM - 10:00 PM</div></td><td><span class="badge pending">On Leave</span></td><td>0 patients</td><td class="actions"><a class="btn" href="#">Edit</a> <a class="btn" href="#">Remove</a></td></tr>
					</tbody>
				</table>
			</div>
		</div>
	</main>
</div>

<!-- Add Nurse Schedule Modal -->
<div class="modal" id="addNurseSchedModal" aria-hidden="true">
	<div class="modal-backdrop" data-close="addNurseSchedModal"></div>
	<div class="modal-dialog" style="max-width:620px">
		<div class="modal-header"><h3>Add Nurse Schedule</h3><button class="modal-close" data-close="addNurseSchedModal">×</button></div>
		<form id="nurseSchedForm">
			<div class="modal-body">
				<label><span>Select Nurse</span>
					<select required>
						<option selected disabled>Choose a nurse...</option>
						<option>Maria Santos</option>
						<option>Ana Rodriguez</option>
						<option>Carmen Lopez</option>
					</select>
				</label>
				<div class="grid-2 modal-grid">
					<label><span>Department</span>
						<select required><option>Emergency</option><option>ICU</option><option>Pediatrics</option><option>Surgery</option><option>Maternity</option></select>
					</label>
					<label><span>Shift</span>
						<select required>
							<option>Morning (6:00 AM - 2:00 PM)</option>
							<option>Evening (2:00 PM - 10:00 PM)</option>
							<option>Night (10:00 PM - 6:00 AM)</option>
						</select>
					</label>
				</div>
			</div>
			<div class="modal-footer"><button class="btn" type="button" data-close="addNurseSchedModal">Cancel</button><button class="btn primary" type="submit">Add Schedule</button></div>
		</form>
	</div>
</div>

<script>
(function(){
	const openBtn = document.getElementById('addNurseSchedBtn');
	const modal = document.getElementById('addNurseSchedModal');
	function open(){ modal.classList.add('open'); }
	function close(){ modal.classList.remove('open'); }
	openBtn?.addEventListener('click', (e)=>{ e.preventDefault(); open(); });
	document.querySelectorAll('[data-close="addNurseSchedModal"]').forEach(el=>el.addEventListener('click', close));
	document.getElementById('nurseSchedForm')?.addEventListener('submit', function(ev){
		ev.preventDefault();
		close();
		alert('Nurse schedule added.');
	});
})();
</script>
<?php echo view('auth/partials/footer'); ?>
