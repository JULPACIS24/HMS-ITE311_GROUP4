<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • Appointments</title>
	<style>
		*{margin:0;padding:0;box-sizing:border-box}
		body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,sans-serif;background:#f5f7fa}
		.container{display:flex;min-height:100vh}
		/* Sidebar styles (match doctor pages) */
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
		.main-content{flex:1;margin-left:250px}
		.header{background:#fff;padding:18px 24px;box-shadow:0 2px 4px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center}
		.header-left{display:flex;flex-direction:column}
		.header h1{font-size:22px;font-weight:700;color:#2c3e50;margin:0}
		.subtext{color:#64748b;font-size:12px;margin-top:2px}
		.actions{display:flex;align-items:center;gap:14px}
		.icon-btn{position:relative;width:34px;height:34px;border-radius:10px;background:#f8fafc;border:1px solid #e5e7eb;display:grid;place-items:center}
		.badge{position:absolute;top:-4px;right:-4px;background:#ef4444;color:#fff;border-radius:999px;font-size:10px;padding:2px 6px;font-weight:700}
		.avatar{width:34px;height:34px;border-radius:50%;background:#2563eb;color:#fff;display:grid;place-items:center;font-weight:800}
		.user-chip{display:flex;align-items:center;gap:10px}
		.user-meta{line-height:1.1}
		.user-name{font-weight:700;font-size:13px;color:#0f172a}
		.user-role{font-size:11px;color:#64748b}
		.notif-wrap,.user-wrap{position:relative}
		.notif-pop,.user-pop{position:absolute;right:0;top:44px;background:#fff;border:1px solid #e5e7eb;border-radius:12px;box-shadow:0 12px 30px rgba(0,0,0,.12);display:none;overflow:hidden;z-index:30}
		.notif-pop{width:320px}
		.user-pop{width:260px}
		.menu-header{padding:12px 14px;font-weight:700;border-bottom:1px solid #f1f5f9}
		.menu-link{display:flex;align-items:center;gap:10px;padding:10px 14px;text-decoration:none;color:#0f172a;font-size:14px}
		.menu-link:hover{background:#f8fafc}
		.page{padding:24px}
		.kpi-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:18px}
		.kpi{background:#fff;border-radius:12px;padding:18px;box-shadow:0 2px 10px rgba(0,0,0,.08);position:relative}
		.k-title{color:#64748b;font-size:14px}
		.k-value{font-size:28px;font-weight:800;color:#0f172a}
		.k-sub{font-size:12px;color:#6b7280;margin-top:6px}
		.k-icon{position:absolute;right:14px;top:14px;width:34px;height:34px;border-radius:10px;display:grid;place-items:center;color:#fff}
		.i-blue{background:#2563eb}.i-green{background:#10b981}.i-red{background:#ef4444}.i-purple{background:#8b5cf6}
		.tabs{display:flex;gap:8px;margin-bottom:12px}
		.tab{background:#f1f5f9;border:1px solid #e5e7eb;padding:8px 12px;border-radius:10px;font-weight:600;color:#334155;cursor:pointer}
		.tab.active{background:#2563eb;border-color:#2563eb;color:#fff}
		.card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden}
		.card-header{padding:14px 16px;border-bottom:1px solid #ecf0f1;font-weight:700}
		.list{display:grid;gap:12px;padding:12px 16px}
		.appt{display:flex;justify-content:space-between;gap:12px;padding:12px;border:1px solid #eef2f7;border-radius:12px;align-items:center}
		.left{display:flex;align-items:center;gap:12px}
		.pill{background:#e6f0ff;color:#2563eb;font-size:12px;border-radius:999px;padding:4px 10px;font-weight:700}
		.pill.warn{background:#fff7e6;color:#a16207}
		.pill.done{background:#e8f5e9;color:#16a34a}
		.pill.cancel{background:#fee2e2;color:#b91c1c}
		.time{font-weight:700;color:#0f172a}
		.meta{font-size:12px;color:#64748b}
		.initial{width:34px;height:34px;border-radius:10px;background:#6366f1;color:#fff;display:grid;place-items:center;font-weight:800}
		.actions-row{display:flex;gap:12px;justify-content:flex-end;margin-top:6px}
		.action-btn{cursor:pointer;text-decoration:none;font-size:18px}
		.action-btn.edit{color:#2563eb}
		/* Modal */
		.modal-overlay{position:fixed;inset:0;background:rgba(0,0,0,.35);display:none;align-items:center;justify-content:center;z-index:50}
		.modal-card{width:720px;max-width:90vw;background:#fff;border-radius:12px;box-shadow:0 20px 40px rgba(0,0,0,.2);overflow:hidden}
		.modal-header{display:flex;justify-content:space-between;align-items:center;padding:14px 18px;border-bottom:1px solid #ecf0f1;font-weight:700}
		.modal-body{padding:18px}
		.grid-2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
		.info{background:#f8fafc;border:1px solid #e5e7eb;border-radius:10px;padding:12px}
		.info .label{font-size:12px;color:#64748b}
		.info .value{font-weight:700;color:#0f172a}
		.note-box{border:1px solid #e5e7eb;border-radius:10px;padding:12px;background:#fff}
		.modal-footer{display:flex;gap:10px;justify-content:flex-end;padding:12px 18px;border-top:1px solid #ecf0f1}
		.btn{border:none;border-radius:10px;padding:10px 14px;font-weight:700;cursor:pointer}
		.btn.secondary{background:#f1f5f9}
		.btn.danger{background:#ef4444;color:#fff}
		.btn.success{background:#22c55e;color:#fff}
		@media(max-width:1200px){ .kpi-grid{grid-template-columns:repeat(2,1fr)} }
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>
		<main class="main-content">
			<header class="header">
				<div class="header-left">
					<h1>Appointments</h1>
					<span class="subtext">Manage your daily schedule and patient appointments</span>
				</div>
				<div class="actions">
					<div class="notif-wrap">
						<button class="icon-btn" id="notifBtn"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12 22a2 2 0 0 0 2-2H10a2 2 0 0 0 2 2Zm6-6V11a6 6 0 1 0-12 0v5l-2 2v1h16v-1l-2-2Z" stroke="#475569" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="badge">3</span></button>
						<div class="notif-pop" id="notifPop">
							<div class="menu-header">Notifications</div>
							<div style="max-height:320px;overflow:auto">
								<div style="display:flex;gap:10px;padding:12px 14px;border-left:4px solid #fecaca;align-items:flex-start;background:#fff7f7"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff0f0">🧪</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">Lab results ready for Patient #1234</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">5 min ago</div></div></div>
								<div style="display:flex;gap:10px;padding:12px 14px;border-left:4px solid #fde68a;align-items:flex-start"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff7e6">📅</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">New appointment scheduled for 2:00 PM</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">10 min ago</div></div></div>
								<div style="display:flex;gap:10px;padding:12px 14px;border-left:4px solid #fecaca;align-items:flex-start;background:#fff7f7"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#fff0f0">💊</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">Prescription approval needed</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">15 min ago</div></div></div>
								<div style="display:flex;gap:10px;padding:12px 14px;border-left:4px solid #bae6fd;align-items:flex-start"><div style="width:28px;height:28px;border-radius:8px;display:grid;place-items:center;background:#ebf8ff">🔔</div><div><div style="font-size:13px;color:#0f172a;font-weight:600">System maintenance scheduled for tonight</div><div style="font-size:12px;color:#94a3b8;margin-top:2px">1 hour ago</div></div></div>
							</div>
							<div style="text-align:center;border-top:1px solid #f1f5f9"><a href="#" style="color:#2563eb;text-decoration:none;font-size:13px">View All Notifications</a></div>
						</div>
					</div>
					<div class="user-wrap">
						<div class="user-chip" id="userBtn" style="cursor:pointer"><div class="avatar">DR</div><div class="user-meta"><div class="user-name">Dr. Maria Santos</div><div class="user-role">Cardiology</div></div></div>
						<div class="user-pop" id="userPop">
							<div style="display:flex;gap:10px;padding:12px 14px;border-bottom:1px solid #f1f5f9"><div style="width:38px;height:38px;border-radius:10px;display:grid;place-items:center;background:#6366f1;color:#fff;font-weight:800">DR</div><div><div style="font-weight:700">Dr. Maria Santos</div><div style="color:#64748b;font-size:12px">Cardiology Department</div><div style="color:#94a3b8;font-size:12px">ID: DOC-2024-001</div></div></div>
							<div><a href="#" class="menu-link">👤 My Profile</a><a href="#" class="menu-link">⚙️ Settings</a><a href="#" class="menu-link">🕒 Work Schedule</a></div>
							<div style="border-top:1px solid #f1f5f9"></div>
							<div><a href="<?= site_url('logout') ?>" class="menu-link" style="color:#ef4444">🚪 Sign Out</a></div>
						</div>
					</div>
				</div>
			</header>

			<div class="page">
				<div class="kpi-grid">
					<div class="kpi"><div class="k-title">Today's Appointments</div><div class="k-value">12</div><div class="k-sub">8 remaining</div><div class="k-icon i-blue">📅</div></div>
					<div class="kpi"><div class="k-title">Completed</div><div class="k-value">4</div><div class="k-sub" style="color:#16a34a">On schedule</div><div class="k-icon i-green">✅</div></div>
					<div class="kpi"><div class="k-title">Urgent Cases</div><div class="k-value">2</div><div class="k-sub" style="color:#ef4444">Need attention</div><div class="k-icon i-red">⏰</div></div>
					<div class="kpi"><div class="k-title">Available Slots</div><div class="k-value">6</div><div class="k-sub">This afternoon</div><div class="k-icon i-purple">⏲️</div></div>
				</div>

				<div class="card">
					<div class="card-header" style="display:flex;justify-content:space-between;align-items:center">
						<span>Appointment Schedule</span>
						<div class="tabs"><div class="tab active" id="tabToday">Today</div><div class="tab" id="tabWeek">This Week</div><button style="margin-left:8px;background:#2563eb;color:#fff;border:none;border-radius:10px;padding:8px 12px;font-weight:700;">+ Schedule Appointment</button></div>
					</div>
					<div class="list" id="listToday">
						<div class="appt"><div class="left"><div class="initial">RS</div><div><div style="font-weight:700">Robert Santos</div><div class="meta">P-2024-001 • Routine Checkup</div><div class="meta">Regular blood pressure monitoring</div></div></div><div style="text-align:right"><div class="pill">Scheduled</div><div class="time">9:00 AM</div><div class="meta">30 min • Room 201</div><div class="actions-row"><a href="#" class="action-btn edit" data-patient="Robert Santos" data-pid="P-2024-001" data-status="Scheduled" data-time="9:00 AM" data-duration="30 min" data-room="Room 201" data-type="Routine Checkup" data-aid="APT-2024-001" data-notes="Regular blood pressure monitoring">✎</a></div></div></div>
						<div class="appt"><div class="left"><div class="initial" style="background:#8b5cf6">LF</div><div><div style="font-weight:700">Lisa Fernandez</div><div class="meta">P-2024-002 • Follow-up</div><div class="meta">Post-surgery recovery assessment</div></div></div><div style="text-align:right"><div class="pill warn">In Progress</div><div class="time">10:30 AM</div><div class="meta">45 min • Room 203</div><div class="actions-row"><a href="#" class="action-btn edit" data-patient="Lisa Fernandez" data-pid="P-2024-002" data-status="In Progress" data-time="10:30 AM" data-duration="45 min" data-room="Room 203" data-type="Follow-up" data-aid="APT-2024-002" data-notes="Post-surgery recovery assessment">✎</a></div></div></div>
						<div class="appt"><div class="left"><div class="initial" style="background:#f59e0b">MT</div><div><div style="font-weight:700">Michael Torres</div><div class="meta">P-2024-003 • Consultation</div><div class="meta">Chest pain evaluation</div></div></div><div style="text-align:right"><div class="pill done">Completed</div><div class="time">11:15 AM</div><div class="meta">30 min • Room 201</div><div class="actions-row"><a href="#" class="action-btn edit" data-patient="Michael Torres" data-pid="P-2024-003" data-status="Completed" data-time="11:15 AM" data-duration="30 min" data-room="Room 201" data-type="Consultation" data-aid="APT-2024-003" data-notes="Chest pain evaluation">✎</a></div></div></div>
					</div>
					<div class="list" id="listWeek" style="display:none">
						<div class="appt"><div class="left"><div class="initial">AC</div><div><div style="font-weight:700">Ana Cruz</div><div class="meta">Follow-up • Diet plan</div></div></div><div style="text-align:right"><div class="pill">Scheduled</div><div class="time">Tue 3:00 PM</div><div class="meta">Room 104</div><div class="actions-row"><a href="#" class="action-btn edit" data-patient="Ana Cruz" data-pid="P-2024-010" data-status="Scheduled" data-time="Tue 3:00 PM" data-duration="30 min" data-room="Room 104" data-type="Follow-up" data-aid="APT-2024-010" data-notes="Diet plan">✎</a></div></div></div>
						<div class="appt"><div class="left"><div class="initial" style="background:#8b5cf6">JM</div><div><div style="font-weight:700">Juan Marcos</div><div class="meta">Consultation • Migraine</div></div></div><div style="text-align:right"><div class="pill warn">In Progress</div><div class="time">Thu 1:30 PM</div><div class="meta">Room 305</div><div class="actions-row"><a href="#" class="action-btn edit" data-patient="Juan Marcos" data-pid="P-2024-011" data-status="In Progress" data-time="Thu 1:30 PM" data-duration="30 min" data-room="Room 305" data-type="Consultation" data-aid="APT-2024-011" data-notes="Migraine">✎</a></div></div></div>
					</div>
				</div>
			</div>
		</main>
	</div>
	<div class="modal-overlay" id="apptModal">
		<div class="modal-card">
			<div class="modal-header">
				<span>Appointment Details</span>
				<button id="closeModal" class="btn secondary">✖</button>
			</div>
			<div class="modal-body">
				<div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
					<div id="mInitial" class="initial">RS</div>
					<div>
						<div id="mPatient" style="font-weight:700;font-size:16px">Robert Santos</div>
						<div id="mPid" class="meta">P-2024-001</div>
						<div id="mStatus" class="pill" style="margin-top:6px;display:inline-block">Scheduled</div>
					</div>
				</div>
				<div class="grid-2" style="margin-bottom:12px">
					<div class="info"><div class="label">Time & Duration</div><div id="mTime" class="value">9:00 AM</div><div id="mDuration" class="meta">30 min</div></div>
					<div class="info"><div class="label">Location</div><div id="mRoom" class="value">Room 201</div></div>
				</div>
				<div class="grid-2" style="margin-bottom:12px">
					<div class="info"><div class="label">Type</div><div id="mType" class="value">Routine Checkup</div></div>
					<div class="info"><div class="label">ID</div><div id="mAid" class="value">APT-2024-001</div></div>
				</div>
				<div class="note-box"><div class="label" style="margin-bottom:6px">Notes</div><div id="mNotes" style="color:#0f172a">Regular blood pressure monitoring</div></div>
			</div>
			<div class="modal-footer">
				<button id="reschedBtn" class="btn secondary">Reschedule</button>
				<button id="cancelBtn" class="btn danger">Cancel</button>
				<button id="completeBtn" class="btn success">Mark Complete</button>
			</div>
		</div>
	</div>
	<script>
	(function(){
		const nbtn=document.getElementById('notifBtn');const npop=document.getElementById('notifPop');const ubtn=document.getElementById('userBtn');const upop=document.getElementById('userPop');function closeAll(){if(npop)npop.style.display='none';if(upop)upop.style.display='none';}
		if(nbtn&&npop){nbtn.addEventListener('click',e=>{e.stopPropagation();npop.style.display=(npop.style.display==='none'||npop.style.display==='')?'block':'none';});}
		if(ubtn&&upop){ubtn.addEventListener('click',e=>{e.stopPropagation();upop.style.display=(upop.style.display==='none'||upop.style.display==='')?'block':'none';});}
		document.addEventListener('click',()=>closeAll());
		const tToday=document.getElementById('tabToday');const tWeek=document.getElementById('tabWeek');const lToday=document.getElementById('listToday');const lWeek=document.getElementById('listWeek');
		if(tToday&&tWeek){tToday.addEventListener('click',()=>{tToday.classList.add('active');tWeek.classList.remove('active');lToday.style.display='grid';lWeek.style.display='none';});tWeek.addEventListener('click',()=>{tWeek.classList.add('active');tToday.classList.remove('active');lToday.style.display='none';lWeek.style.display='grid';});}
		// Action buttons (demo handlers)
		document.querySelectorAll('.action-btn.edit').forEach(a=>a.addEventListener('click',e=>{e.preventDefault();alert('Edit appointment: '+a.dataset.id);}));
		function $(sel){return document.querySelector(sel);} 
		const apptModal=$('#apptModal');
		const closeBtn=$('#closeModal');
		function openModal(){apptModal.style.display='flex';}
		function closeModal(){apptModal.style.display='none';}
		if(closeBtn) closeBtn.addEventListener('click',closeModal);
		document.querySelectorAll('.action-btn.edit').forEach(btn=>{
			btn.addEventListener('click',e=>{
				e.preventDefault(); e.stopPropagation();
				$('#mInitial').textContent=(btn.dataset.patient||'').split(' ').map(s=>s[0]).slice(0,2).join('').toUpperCase();
				$('#mPatient').textContent=btn.dataset.patient||'';
				$('#mPid').textContent=btn.dataset.pid||'';
				$('#mStatus').textContent=btn.dataset.status||'';
				$('#mTime').textContent=btn.dataset.time||'';
				$('#mDuration').textContent=btn.dataset.duration||'';
				$('#mRoom').textContent=btn.dataset.room||'';
				$('#mType').textContent=btn.dataset.type||'';
				$('#mAid').textContent=btn.dataset.aid||'';
				$('#mNotes').textContent=btn.dataset.notes||'';
				openModal();
			});
		});
		apptModal.addEventListener('click',e=>{ if(e.target===apptModal) closeModal(); });
		$('#reschedBtn').addEventListener('click',()=>alert('Reschedule action')); 
		$('#cancelBtn').addEventListener('click',()=>alert('Cancel action')); 
		$('#completeBtn').addEventListener('click',()=>alert('Marked complete')); 
	})();
	</script>
</body>
</html>

