<?php echo view('auth/partials/header', ['title' => 'Doctor Scheduling']); ?>
<div class="container">
	<?php echo view('auth/partials/sidebar'); ?>
	<main class="main-content">
		<header class="header">
			<h1>Doctor Scheduling</h1>
			<div class="user-info" style="gap:12px">
				<a class="btn" href="#" id="backSched">Back to Scheduling</a>
				<a class="btn primary" href="#" id="addApptBtn">+ Add Appointment</a>
			</div>
		</header>
		<div class="page-content" style="display:grid; grid-template-columns:360px 1fr; gap:18px;">
			<!-- Left: Doctor list -->
			<div class="patients-table-container">
				<div class="table-header"><h2 class="table-title">Doctors</h2></div>
				<div id="doctorList" style="padding:10px 0">
					<div class="doc-item" data-id="maria" style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-left:3px solid transparent; cursor:pointer; border-bottom:1px solid #ecf0f1">
						<div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:grid;place-items:center;color:#2563eb;font-weight:800">👤</div>
						<div style="flex:1"><div style="font-weight:700;color:#0f172a">Dr. Maria Rodriguez</div><div class="sub">Cardiology</div></div>
						<span class="badge completed">Available</span>
					</div>
					<div class="doc-item" data-id="juan" style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-left:3px solid transparent; cursor:pointer; border-bottom:1px solid #ecf0f1">
						<div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:grid;place-items:center;color:#2563eb;font-weight:800">👤</div>
						<div style="flex:1"><div style="font-weight:700;color:#0f172a">Dr. Juan Garcia</div><div class="sub">Pediatrics</div></div>
						<span class="badge pending">In Surgery</span>
					</div>
					<div class="doc-item" data-id="ana" style="display:flex; align-items:center; gap:12px; padding:12px 16px; border-left:3px solid transparent; cursor:pointer">
						<div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:grid;place-items:center;color:#2563eb;font-weight:800">👤</div>
						<div style="flex:1"><div style="font-weight:700;color:#0f172a">Dr. Ana Santos</div><div class="sub">Emergency Medicine</div></div>
						<span class="badge">On Break</span>
					</div>
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
				<label><span>Patient Name</span><input type="text" name="patient_name" required></label>
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
	function openAppt(){ apptModal.classList.add('open'); }
	function closeAppt(){ apptModal.classList.remove('open'); }
	addApptBtn?.addEventListener('click', (e)=>{ e.preventDefault(); openAppt(); });
	document.querySelectorAll('[data-close="addApptModal"]').forEach(el=>el.addEventListener('click', closeAppt));
	document.getElementById('apptForm')?.addEventListener('submit', function(ev){ ev.preventDefault(); closeAppt(); alert('Appointment added.'); });

	// Mock data to render the right panel similar to your screenshots
	const doctors = {
		maria: {
			name: 'Dr. Maria Rodriguez', dept: 'Cardiology • Internal Medicine', email: 'maria.rodriguez@sanmiguel.ph',
			date: '01/15/2024',
			appointments: [
				{ time:'08:00-09:00', patient:'Juan Dela Cruz', type:'Consultation', status:'Confirmed' },
				{ time:'09:00-10:00', patient:'Maria Santos', type:'Follow-up', status:'Confirmed' },
				{ time:'10:00-11:00', patient:'Pedro Garcia', type:'Checkup', status:'Pending' },
				{ time:'14:00-15:00', patient:'Ana Rodriguez', type:'Consultation', status:'Confirmed' },
				{ time:'15:00-16:00', patient:'Carlos Mendoza', type:'Emergency', status:'Urgent' },
			],
			weekly:[8,8,8,8,8,'Off','Off']
		},
		juan: {
			name: 'Dr. Juan Garcia', dept: 'Pediatrics • Pediatrics', email: 'juan.garcia@sanmiguel.ph',
			date: '01/15/2024', appointments: [], weekly:[8,8,8,8,8,'Off','Off']
		},
		ana: {
			name: 'Dr. Ana Santos', dept: 'Emergency Medicine • Emergency', email: 'ana.santos@sanmiguel.ph',
			date: '01/15/2024', appointments: [], weekly:[8,8,8,8,8,'Off','Off']
		}
	};

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
		// highlight selected in the list
		document.querySelectorAll('#doctorList .doc-item').forEach(el=>{
			el.style.borderLeftColor = (el.dataset.id===id)? '#2563eb' : 'transparent';
			el.style.background = (el.dataset.id===id)? '#eef2ff' : 'transparent';
		});

		const panel = document.getElementById('detailPanel');
		panel.innerHTML = `
			<div style=\"padding:16px 18px; border-bottom:1px solid #ecf0f1; display:flex; align-items:center; gap:12px\">
				<div style=\"width:42px;height:42px;border-radius:12px;background:#eef2ff;display:grid;place-items:center;color:#2563eb;font-weight:800\">👤</div>
				<div style=\"flex:1\"><div style=\"font-weight:800;color:#0f172a\">${d.name}</div><div class=\"sub\">${d.dept}</div><div class=\"sub\">${d.email}</div></div>
				<div style=\"display:flex; gap:8px; align-items:center\">
					<button class=\"btn\" type=\"button\">Day</button>
					<button class=\"btn primary\" type=\"button\">Week</button>
					<input type=\"text\" value=\"${d.date}\" class=\"search-input\" style=\"width:120px\" />
				</div>
			</div>
			<div style=\"padding:16px 18px\">
				<div class=\"sub\" style=\"margin-bottom:10px\">Schedule for Monday, January 15, 2024</div>
				${d.appointments.length? d.appointments.map(ap=>`
					<div style=\"border-left:4px solid ${ap.status==='Pending'?'#f59e0b': ap.status==='Urgent'?'#ef4444':'#22c55e'}; background:${ap.status==='Pending'?'#fff7ed': ap.status==='Urgent'?'#fef2f2':'#ecfdf5'}; padding:12px 14px; border-radius:10px; display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:10px\">
						<div style=\"width:120px;color:#475569\">${ap.time}</div>
						<div style=\"flex:1\"><div style=\"font-weight:700;color:#0f172a\">${ap.patient}</div><div class=\"sub\">${ap.type}</div></div>
						<div><span class=\"badge ${badgeClass(ap.status)}\">${ap.status}</span></div>
						<div class=\"actions\"><a class=\"btn\" href=\"#\">✏️</a> <a class=\"btn\" href=\"#\">🗑️</a></div>
					</div>
				`).join('') : `
					<div style=\"text-align:center; color:#94a3b8; padding:40px 0\">
						<div style=\"font-size:48px\">📅</div>
						<div style=\"font-weight:700; color:#0f172a; margin-top:6px\">No Appointments Scheduled</div>
						<div class=\"sub\">This doctor has no appointments for the selected date</div>
						<div style=\"margin-top:12px\"><a class=\"btn primary\" href=\"#\" id=\"inlineAddAppt\">+ Add Appointment</a></div>
					</div>
				`}
				<div style=\"margin-top:18px\">
					<div class=\"sub\" style=\"margin-bottom:8px\">Weekly Overview</div>
					<div style=\"display:grid; grid-template-columns:repeat(7,1fr); gap:10px\">
						${['Mon','Tue','Wed','Thu','Fri','Sat','Sun'].map((dname,i)=>`<div style=\"text-align:center; background:#f8fafc; border:1px solid #eef2f6; border-radius:10px; padding:10px 8px\"><div class=\"sub\">${dname}</div><div style=\"font-weight:700\">${doctors[id].weekly[i]}</div><div class=\"sub\">appointments</div></div>`).join('')}
					</div>
				</div>
			</div>
		`;
		// Wire inline Add Appointment button
		panel.querySelector('#inlineAddAppt')?.addEventListener('click', function(e){ e.preventDefault(); openAppt(); });
	}

	// Click handlers
	document.querySelectorAll('#doctorList .doc-item').forEach(el=>{
		el.addEventListener('click', ()=> renderDetail(el.dataset.id));
	});
	// Default select first
	renderDetail('maria');
})();
</script>
<?php echo view('auth/partials/footer'); ?>
