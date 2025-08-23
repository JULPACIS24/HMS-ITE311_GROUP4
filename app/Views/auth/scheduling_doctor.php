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
	let selectedDate = new Date();
	let currentDoctorKey = null;
	function openAppt(){ apptModal.classList.add('open'); }
	function closeAppt(){ apptModal.classList.remove('open'); }
	addApptBtn?.addEventListener('click', (e)=>{ e.preventDefault(); openAppt(); });
	document.querySelectorAll('[data-close="addApptModal"]').forEach(el=>el.addEventListener('click', closeAppt));
	document.getElementById('apptForm')?.addEventListener('submit', function(ev){
		ev.preventDefault();
		// Immediately reflect the new appointment in the current doctor's list
		try {
			const f = ev.target;
			const patient = f.querySelector('[name="patient_name"]').value || 'New Patient';
			const doctor  = f.querySelector('[name="doctor_name"]').value || '';
			const dateVal = f.querySelector('[name="date"]').value;
			const timeVal = f.querySelector('[name="time"]').value || '00:00';
			const typeVal = f.querySelector('[name="type"]').value || 'Consultation';
			const status  = f.querySelector('[name="status"]').value || 'Pending';
			// If no doctor selected, default to current visible doctor
			const key = currentDoctorKey || Object.keys(doctors)[0];
			if (key && doctors[key]){
				doctors[key].appointments.push({ time: timeVal, patient: patient, type: typeVal, status: status, id: null });
				renderDetail(key);
			}
			closeAppt();
		} catch (_) {
			closeAppt();
		}
	});

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
		currentDoctorKey = id;
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
							<div style=\"flex:1\"><div style=\"font-weight:700;color:#0f172a\">${ap.patient}</div><div class=\"sub\">${ap.type}</div></div>
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

		// Wire actions: edit/delete if id exists, otherwise local edit/delete
		panel.querySelectorAll('.actions').forEach(function(box){
			const id = box.getAttribute('data-appt-id');
			const idxStr = box.getAttribute('data-index');
			const idx = idxStr? parseInt(idxStr, 10) : -1;
			const edit = box.querySelector('.edit');
			const del = box.querySelector('.delete');
			if (id) {
				edit.setAttribute('href', '/appointments/edit/' + id);
				del.setAttribute('href', '/appointments/delete/' + id);
				del.addEventListener('click', function(ev){ if(!confirm('Delete this appointment?')) ev.preventDefault(); });
			} else {
				edit.addEventListener('click', function(ev){
					ev.preventDefault();
					if (idx >= 0 && doctors[currentDoctorKey] && doctors[currentDoctorKey].appointments[idx]){
						const ap = doctors[currentDoctorKey].appointments[idx];
						document.getElementById('eaPatient').value = ap.patient || '';
						document.getElementById('eaDoctor').value = (doctors[currentDoctorKey].name || '').replace(/^Dr\.\s*/, '');
						document.getElementById('eaDate').value = new Date(selectedDate).toISOString().slice(0,10);
						document.getElementById('eaTime').value = (ap.time||'').slice(0,5);
						document.getElementById('eaType').value = ap.type || 'Consultation';
						document.getElementById('eaStatus').value = ap.status || 'Pending';
						document.getElementById('eaNotes').value = '';
						const form = document.getElementById('editApptForm');
						form.onsubmit = function(e){
							e.preventDefault();
							ap.patient = document.getElementById('eaPatient').value;
							ap.type = document.getElementById('eaType').value;
							ap.status = document.getElementById('eaStatus').value;
							ap.time = document.getElementById('eaTime').value || ap.time;
							document.getElementById('editApptModal').classList.remove('open');
							renderDetail(currentDoctorKey);
						};
						document.getElementById('editApptModal').classList.add('open');
					}
				});
				del.addEventListener('click', function(ev){
					ev.preventDefault();
					if (confirm('Delete this appointment?') && idx >= 0 && doctors[currentDoctorKey]){
						doctors[currentDoctorKey].appointments.splice(idx, 1);
						renderDetail(currentDoctorKey);
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
			cal.querySelector('#calToday').onclick = function(){ selectedDate = new Date(); calBtn.textContent = '📅 ' + new Date(selectedDate).toLocaleDateString(); renderDetail(id); cal.style.display='none'; };
			cal.querySelectorAll('[data-date]').forEach(function(btn){
				btn.addEventListener('click', function(){ selectedDate = new Date(btn.getAttribute('data-date')); calBtn.textContent = '📅 ' + new Date(selectedDate).toLocaleDateString(); renderDetail(id); cal.style.display='none'; });
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
		el.addEventListener('click', ()=> renderDetail(el.dataset.id));
	});
	// Default select first
	renderDetail('maria');

	// Edit Appointment Modal (inline, uses existing appointments/update/:id)
})();
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
				<label><span>Notes</span><textarea name="notes" id="eaNotes"></textarea></label>
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
	const fNotes = document.getElementById('eaNotes');
	let currentId = null;

	function open(){ m.classList.add('open'); }
	function close(){ m.classList.remove('open'); }
	document.getElementById('closeEditAppt')?.addEventListener('click', close);
	document.getElementById('closeEditApptBackdrop')?.addEventListener('click', close);
	document.getElementById('cancelEditAppt')?.addEventListener('click', close);

	// Delegate edit/delete clicks from the detail panel
	document.getElementById('detailPanel').addEventListener('click', function(ev){
		const a = ev.target.closest('a');
		if (!a) return;
		if (a.classList.contains('edit')){
			ev.preventDefault();
			const container = a.closest('.actions');
			const id = container?.getAttribute('data-appt-id');
			if (!id){ alert('This sample item has no ID to edit.'); return; }
			fetch('<?= site_url('appointments/json') ?>/' + id).then(r=>r.json()).then(function(ap){
				currentId = ap.id;
				fPatient.value = ap.patient_name || '';
				fDoctor.value = ap.doctor_name || '';
				const dt = ap.date_time ? new Date(ap.date_time) : new Date();
				fDate.value = dt.toISOString().slice(0,10);
				fTime.value = dt.toTimeString().slice(0,5);
				fType.value = ap.type || 'Consultation';
				fStatus.value = ap.status || 'Pending';
				fNotes.value = ap.notes || '';
				form.setAttribute('action', '<?= site_url('appointments/update') ?>/' + ap.id);
				open();
			});
		}
		if (a.classList.contains('delete')){
			// leave default behavior (href + confirm)
		}
	});

	form?.addEventListener('submit', function(){
		if (!currentId){ return false; }
	});
})();
</script>
<?php echo view('auth/partials/footer'); ?>
