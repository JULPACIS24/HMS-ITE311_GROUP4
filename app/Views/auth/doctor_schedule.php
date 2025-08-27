<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Schedule - Doctor Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <style>
        * { margin:0; padding:0; box-sizing:border-box }
        body { font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif; background:#f5f7fa }
        .container { display:flex; min-height:100vh }
        .sidebar { width:250px; background:linear-gradient(180deg,#2c3e50 0%, #34495e 100%); color:#fff; position:fixed; height:100vh; overflow-y:auto }
        .sidebar-header { padding:20px; border-bottom:1px solid #34495e; display:flex; align-items:center; gap:12px }
        .admin-icon { width:36px; height:36px; background:#3498db; border-radius:8px; display:grid; place-items:center; font-weight:700 }
        .sidebar-title { font-size:16px; font-weight:700 }
        .sidebar-sub { font-size:12px; color:#cbd5e1; margin-top:2px }
        .sidebar-menu { padding:20px 0 }
        .menu-item { display:flex; align-items:center; gap:12px; padding:12px 20px; color:#cbd5e1; text-decoration:none; border-left:3px solid transparent }
        .menu-item:hover { background:rgba(255,255,255,.1); color:#fff; border-left-color:#3498db }
        .menu-item.active { background:rgba(52,152,219,.2); color:#fff; border-left-color:#3498db }
        .menu-item.disabled { pointer-events:none; opacity:.6 }
        .menu-icon { width:20px; text-align:center }
        .main-content { flex:1; margin-left:250px }
        .header { background:#fff; padding:18px 24px; box-shadow:0 2px 4px rgba(0,0,0,.08); display:flex; justify-content:space-between; align-items:center }
        .header h1 { font-size:22px; color:#2c3e50; font-weight:700; margin:0 }
        .header .subtext { color:#64748b; font-size:12px; margin-top:2px }
        .header-left { display:flex; flex-direction:column }
        .actions { display:flex; align-items:center; gap:14px }
        .icon-btn { position:relative; width:34px; height:34px; border-radius:10px; background:#f8fafc; display:grid; place-items:center; border:1px solid #e5e7eb; cursor:default }
        .badge { position:absolute; top:-4px; right:-4px; background:#ef4444; color:#fff; border-radius:999px; font-size:10px; padding:2px 6px; font-weight:700 }
        .user-chip { display:flex; align-items:center; gap:10px }
        .avatar { width:34px; height:34px; border-radius:50%; background:#2563eb; color:#fff; display:grid; place-items:center; font-weight:800 }
        .user-meta { line-height:1.1 }
        .user-name { font-weight:700; font-size:13px; color:#0f172a }
        .user-role { font-size:11px; color:#64748b }

        /* Schedule specific styles */
        .schedule-content { padding:24px 30px; background:#f5f7fa; min-height:calc(100vh - 80px) }
        .stats-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:24px }
        .stat-card { background:#fff; border-radius:12px; padding:20px; box-shadow:0 2px 10px rgba(0,0,0,.08); display:flex; align-items:center; gap:16px; transition:transform 0.2s ease; border:1px solid #e5e7eb }
        .stat-card:hover { transform:translateY(-2px); box-shadow:0 4px 20px rgba(0,0,0,.12) }
        .stat-icon { width:48px; height:48px; border-radius:12px; display:grid; place-items:center; font-size:20px; color:#fff }
        .stat-icon.blue { background:linear-gradient(135deg, #667eea 0%, #764ba2 100%) }
        .stat-icon.red { background:linear-gradient(135deg, #f093fb 0%, #f5576c 100%) }
        .stat-icon.green { background:linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) }
        .stat-icon.purple { background:linear-gradient(135deg, #a8edea 0%, #fed6e3 100%) }
        .stat-content h3 { font-size:28px; font-weight:800; color:#0f172a; margin-bottom:4px }
        .stat-content p { color:#64748b; font-size:14px; font-weight:500 }

        .controls-section { background:#fff; border-radius:12px; padding:20px; margin-bottom:24px; box-shadow:0 2px 10px rgba(0,0,0,.08); display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px }
        .week-navigation { display:flex; align-items:center; gap:12px }
        .nav-btn { padding:10px 16px; border:none; border-radius:8px; background:#f1f5f9; color:#475569; cursor:pointer; transition:all 0.2s ease; font-weight:500; font-size:14px }
        .nav-btn:hover { background:#e2e8f0; transform:translateY(-1px) }
        .nav-btn.active { background:#2563eb; color:#fff }
        .week-display { font-size:16px; font-weight:600; color:#0f172a; min-width:200px; text-align:center }
        .action-buttons { display:flex; gap:12px }
        .btn { padding:12px 24px; border:none; border-radius:8px; cursor:pointer; font-weight:600; transition:all 0.2s ease; text-decoration:none; display:inline-flex; align-items:center; gap:8px; font-size:14px; min-height:44px; justify-content:center }
        .btn:hover { transform:translateY(-1px); box-shadow:0 4px 12px rgba(0,0,0,0.15) }
        .btn-primary { background:#2563eb; color:#fff !important; border:2px solid #2563eb }
        .btn-danger { background:#dc2626; color:#fff !important; border:2px solid #dc2626 }
        .btn-secondary { background:#f3f4f6; color:#374151; border:2px solid #d1d5db }
        .btn-secondary:hover { background:#e5e7eb }

        .calendar-section { background:#fff; border-radius:12px; box-shadow:0 2px 10px rgba(0,0,0,.08); overflow:hidden; margin-bottom:30px }
        .calendar-header { padding:20px; border-bottom:1px solid #e2e8f0 }
        .calendar-header h2 { font-size:18px; font-weight:700; color:#0f172a; margin:0 }
        .calendar-grid { display:grid; grid-template-columns:80px repeat(7, 1fr); gap:1px; background:#e2e8f0; min-height:400px; max-height:800px; overflow-y:auto; margin:0 auto; width:100% }
        .calendar-header-cell { background:#f8fafc; padding:12px 8px; text-align:center; font-weight:600; font-size:13px; color:#475569; border-right:1px solid #e2e8f0; position:sticky; top:0; z-index:20 }
        .time-slot { background:#fff; padding:8px; text-align:center; font-size:12px; color:#64748b; border-right:1px solid #e2e8f0; min-height:40px; display:flex; align-items:center; justify-content:center; position:sticky; left:0; z-index:10; background:#f8fafc }
        .calendar-cell { background:#fff; min-height:40px; padding:2px; position:relative; cursor:pointer; transition:background-color 0.2s ease; border-right:1px solid #e2e8f0; border-bottom:1px solid #e2e8f0 }
        .calendar-cell:hover { background:#f8fafc }
        .calendar-cell.today { background:#eff6ff }
        .schedule-item { position:absolute; left:2px; right:2px; padding:4px 6px; border-radius:6px; font-size:11px; font-weight:500; color:#fff; cursor:pointer; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; z-index:10; transition:all 0.2s ease }
        .schedule-item:hover { transform:scale(1.02); box-shadow:0 2px 8px rgba(0,0,0,0.2) }
        .schedule-item.appointment { background:#2563eb }
        .schedule-item.ward_rounds { background:#8b5cf6 }
        .schedule-item.surgery { background:#dc2626 }
        .schedule-item.on_call { background:#ea580c }
        .schedule-item.blocked { background:#64748b }
        .schedule-item.consultation { background:#059669 }

        /* Modal Styles */
        .modal { display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5); backdrop-filter:blur(4px) }
        .modal-content { background-color:#fff; margin:5% auto; padding:0; border-radius:12px; width:90%; max-width:600px; box-shadow:0 20px 40px rgba(0,0,0,0.3); animation:modalSlideIn 0.3s ease }
        @keyframes modalSlideIn { from { opacity:0; transform:translateY(-30px) } to { opacity:1; transform:translateY(0) } }
        .modal-header { background:#2563eb; color:#fff; padding:20px; border-radius:12px 12px 0 0; display:flex; justify-content:space-between; align-items:center }
        .modal-header h2 { margin:0; font-size:18px; font-weight:600 }
        .close { color:#fff; font-size:24px; font-weight:bold; cursor:pointer; background:none; border:none; padding:0; width:24px; height:24px; display:grid; place-items:center }
        .close:hover { opacity:0.8 }
        .modal-body { padding:24px }
        .form-group { margin-bottom:20px }
        .form-group label { display:block; margin-bottom:8px; font-weight:600; color:#374151; font-size:14px }
        .form-group input, .form-group select, .form-group textarea { width:100%; padding:12px; border:2px solid #e5e7eb; border-radius:8px; font-size:14px; transition:border-color 0.2s ease; background-color: #fff }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline:none; border-color:#2563eb; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1) }
        .form-group input::placeholder, .form-group textarea::placeholder { color: #9ca3af }
        .form-row { display:grid; grid-template-columns:1fr 1fr; gap:16px }
        .modal-footer { padding:20px 24px; border-top:1px solid #e5e7eb; display:flex; justify-content:flex-end; gap:12px }

        .loading { display:none; text-align:center; padding:40px }
        .spinner { border:4px solid #f3f4f6; border-top:4px solid #2563eb; border-radius:50%; width:40px; height:40px; animation:spin 1s linear infinite; margin:0 auto }
        @keyframes spin { 0% { transform:rotate(0deg) } 100% { transform:rotate(360deg) } }
        .alert { padding:16px; border-radius:8px; margin-bottom:20px; display:none; font-size:14px }
        .alert-success { background:#dcfce7; color:#166534; border:1px solid #bbf7d0 }
        .alert-error { background:#fee2e2; color:#991b1b; border:1px solid #fecaca }

        @media (max-width: 1200px) { 
            .stats-grid { grid-template-columns:repeat(2,1fr) } 
            .controls-section { flex-direction:column; align-items:stretch } 
            .calendar-grid { grid-template-columns:60px repeat(7, 1fr); font-size:11px } 
            .schedule-item { font-size:10px; padding:2px 4px } 
        }
        @media (max-width: 768px) { 
            .stats-grid { grid-template-columns:1fr } 
            .sidebar { width:200px } 
            .main-content { margin-left:200px } 
        }

        /* Additional fixes for calendar visibility */
        .calendar-grid::-webkit-scrollbar { width: 8px; height: 8px }
        .calendar-grid::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 4px }
        .calendar-grid::-webkit-scrollbar-thumb { background: #c1c1c1; border-radius: 4px }
        .calendar-grid::-webkit-scrollbar-thumb:hover { background: #a8a8a8 }
        
        .calendar-section { position: relative; }
        .calendar-grid { border: 1px solid #e2e8f0; }
        
        /* Ensure calendar is visible and properly sized */
        .calendar-grid { 
            min-height: 500px !important; 
            max-height: 800px !important; 
            overflow: auto !important; 
            display: grid !important; 
            grid-template-columns: 80px repeat(7, 1fr) !important; 
        }
        
        /* Make sure cells are visible */
        .calendar-cell { 
            min-height: 40px !important; 
            border: 1px solid #e2e8f0 !important; 
            background: #fff !important; 
        }
        
        .time-slot { 
            min-height: 40px !important; 
            background: #f8fafc !important; 
            border: 1px solid #e2e8f0 !important; 
        }
        
        /* Ensure buttons are highly visible */
        .btn { 
            opacity: 1 !important; 
            visibility: visible !important; 
            display: inline-flex !important; 
            position: relative !important; 
            z-index: 10 !important; 
        }
        
        .action-buttons { 
            display: flex !important; 
            gap: 12px !important; 
            visibility: visible !important; 
            opacity: 1 !important; 
        }
        
        .controls-section { 
            visibility: visible !important; 
            opacity: 1 !important; 
            display: flex !important; 
        }
    </style>
</head>
<body>
    <div class="container">
        <?php echo view('auth/partials/doctor_sidebar'); ?>

        <main class="main-content">
            <header class="header">
                <div class="header-left">
                    <h1>My Schedule</h1>
                    <div class="subtext">Manage your working hours and availability</div>
                </div>
                <div class="actions">
                    <div class="icon-btn notif-wrap">
                        <span>🔔</span>
                        <span class="badge">3</span>
                    </div>
                    <div class="icon-btn">🏥</div>
                    <div class="user-chip">
                        <div class="avatar">DR</div>
                        <div class="user-meta">
                            <div class="user-name"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></div>
                            <div class="user-role"><?= session('specialty') ?? session('department') ?? 'Medical' ?></div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="schedule-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon blue">⏰</div>
                        <div class="stat-content">
                            <h3 id="weekly-hours"><?= $stats['weekly_hours'] ?? 0 ?></h3>
                            <p>Weekly Hours</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon red">🔪</div>
                        <div class="stat-content">
                            <h3 id="surgeries-scheduled"><?= $stats['surgeries_scheduled'] ?? 0 ?></h3>
                            <p>Surgeries Scheduled</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon green">📅</div>
                        <div class="stat-content">
                            <h3 id="available-slots"><?= $stats['available_slots'] ?? 0 ?></h3>
                            <p>Available Slots</p>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon purple">📞</div>
                        <div class="stat-content">
                            <h3 id="on-call-hours"><?= $stats['on_call_hours'] ?? 0 ?></h3>
                            <p>On-Call Hours</p>
                        </div>
                    </div>
                </div>

                <div class="controls-section">
                    <div class="week-navigation">
                        <button class="nav-btn" id="prev-week">← Previous</button>
                        <button class="nav-btn active" id="this-week">This Week</button>
                        <button class="nav-btn" id="next-week">Next →</button>
                        <div class="week-display" id="week-display">
                            <?= date('M j', strtotime($currentWeek['start'])) ?> - <?= date('M j, Y', strtotime($currentWeek['end'])) ?>
                        </div>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-danger" id="block-time-btn" style="background: #dc2626 !important; color: white !important; padding: 12px 24px !important; border: 2px solid #dc2626 !important; border-radius: 8px !important; font-weight: bold !important; cursor: pointer !important;">🚫 Block Time</button>
                        <button class="btn btn-primary" id="add-schedule-btn" style="background: #2563eb !important; color: white !important; padding: 12px 24px !important; border: 2px solid #2563eb !important; border-radius: 8px !important; font-weight: bold !important; cursor: pointer !important;">➕ Add to Schedule</button>
                    </div>
                </div>

                <div class="calendar-section">
                    <div class="calendar-header">
                        <h2>Weekly Schedule</h2>
                    </div>
                    <div class="loading" id="loading">
                        <div class="spinner"></div>
                        <p>Loading schedule...</p>
                    </div>
                    <div class="alert alert-success" id="success-alert"></div>
                    <div class="alert alert-error" id="error-alert"></div>
                    <div class="calendar-grid" id="calendar-grid">
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                            Loading calendar...
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Add Schedule Modal -->
    <div id="add-schedule-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Add to Schedule</h2>
                <button class="close" onclick="closeModal('add-schedule-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add-schedule-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="schedule-type">Activity Type</label>
                            <select id="schedule-type" name="type" required>
                                <option value="appointment">Patient Appointment</option>
                                <option value="ward_rounds">Ward Rounds</option>
                                <option value="surgery">Surgery</option>
                                <option value="on_call">On-Call Duty</option>
                                <option value="blocked">Blocked Time</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="schedule-day">Day</label>
                            <select id="schedule-day" name="day" required>
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                                <option value="saturday">Saturday</option>
                                <option value="sunday">Sunday</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="schedule-start-time">Start Time</label>
                            <select id="schedule-start-time" name="start_time" required>
                                <option value="08:00">8:00 AM</option>
                                <option value="08:30">8:30 AM</option>
                                <option value="09:00">9:00 AM</option>
                                <option value="09:30">9:30 AM</option>
                                <option value="10:00">10:00 AM</option>
                                <option value="10:30">10:30 AM</option>
                                <option value="11:00">11:00 AM</option>
                                <option value="11:30">11:30 AM</option>
                                <option value="12:00">12:00 PM</option>
                                <option value="12:30">12:30 PM</option>
                                <option value="13:00">1:00 PM</option>
                                <option value="13:30">1:30 PM</option>
                                <option value="14:00">2:00 PM</option>
                                <option value="14:30">2:30 PM</option>
                                <option value="15:00">3:00 PM</option>
                                <option value="15:30">3:30 PM</option>
                                <option value="16:00">4:00 PM</option>
                                <option value="16:30">4:30 PM</option>
                                <option value="17:00">5:00 PM</option>
                                <option value="17:30">5:30 PM</option>
                                <option value="18:00">6:00 PM</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="schedule-duration">Duration</label>
                            <select id="schedule-duration" name="duration" required>
                                <option value="30">30 minutes</option>
                                <option value="60">1 hour</option>
                                <option value="90">1.5 hours</option>
                                <option value="120">2 hours</option>
                                <option value="180">3 hours</option>
                                <option value="240">4 hours</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="schedule-patient">Patient/Activity</label>
                            <input type="text" id="schedule-patient" name="title" placeholder="Enter patient name or activity" required>
                        </div>
                        <div class="form-group">
                            <label for="schedule-room">Room/Location</label>
                            <input type="text" id="schedule-room" name="room" placeholder="Enter room or location">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="schedule-description">Notes</label>
                        <textarea id="schedule-description" name="description" rows="3" placeholder="Additional notes or details"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('add-schedule-modal')">Cancel</button>
                <button class="btn btn-primary" onclick="addSchedule()">Add to Schedule</button>
            </div>
        </div>
    </div>

    <!-- Block Time Modal -->
    <div id="block-time-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Block Time</h2>
                <button class="close" onclick="closeModal('block-time-modal')">&times;</button>
            </div>
            <div class="modal-body">
                <form id="block-time-form">
                    <div class="form-group">
                        <label for="block-date">Date</label>
                        <input type="date" id="block-date" name="date" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="block-start-time">Start Time</label>
                            <input type="time" id="block-start-time" name="start_time" required>
                        </div>
                        <div class="form-group">
                            <label for="block-end-time">End Time</label>
                            <input type="time" id="block-end-time" name="end_time" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="block-description">Reason (Optional)</label>
                        <textarea id="block-description" name="description" rows="3" placeholder="Why are you blocking this time?"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('block-time-modal')">Cancel</button>
                <button class="btn btn-danger" onclick="blockTime()">Block Time</button>
            </div>
        </div>
    </div>

    <!-- Schedule Details Modal -->
    <div id="schedule-details-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="details-title">Schedule Details</h2>
                <button class="close" onclick="closeModal('schedule-details-modal')">&times;</button>
            </div>
            <div class="modal-body" id="schedule-details-content"></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('schedule-details-modal')">Close</button>
                <button class="btn btn-danger" onclick="deleteSchedule()" id="delete-schedule-btn">Delete</button>
            </div>
        </div>
    </div>

    <script>
        let currentWeekStart = '<?= $currentWeek['start'] ?>';
        let currentWeekEnd = '<?= $currentWeek['end'] ?>';
        let schedules = <?= json_encode($schedules) ?>;
        let selectedScheduleId = null;

        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, generating calendar...');
            generateCalendar();
            setupEventListeners();
            console.log('Calendar generation complete');
        });

        function setupEventListeners() {
            console.log('Setting up event listeners...');
            
            const prevBtn = document.getElementById('prev-week');
            const nextBtn = document.getElementById('next-week');
            const thisWeekBtn = document.getElementById('this-week');
            const addBtn = document.getElementById('add-schedule-btn');
            const blockBtn = document.getElementById('block-time-btn');
            
            console.log('Buttons found:', { prevBtn, nextBtn, thisWeekBtn, addBtn, blockBtn });
            
            if (prevBtn) prevBtn.addEventListener('click', () => navigateWeek('prev'));
            if (nextBtn) nextBtn.addEventListener('click', () => navigateWeek('next'));
            if (thisWeekBtn) thisWeekBtn.addEventListener('click', () => navigateWeek('current'));
            if (addBtn) addBtn.addEventListener('click', () => openModal('add-schedule-modal'));
            if (blockBtn) blockBtn.addEventListener('click', () => openModal('block-time-modal'));
            
            window.addEventListener('click', function(event) {
                if (event.target.classList.contains('modal')) {
                    event.target.style.display = 'none';
                }
            });
            
            console.log('Event listeners setup complete');
        }

        function generateCalendar() {
            const grid = document.getElementById('calendar-grid');
            if (!grid) {
                console.error('Calendar grid element not found!');
                return;
            }
            console.log('Generating calendar with', schedules.length, 'schedules');
            console.log('Schedules data:', schedules);
            grid.innerHTML = '';

            const timeSlots = [];
            for (let hour = 8; hour <= 18; hour++) {
                for (let minute = 0; minute < 60; minute += 30) {
                    const time = `${hour.toString().padStart(2, '0')}:${minute.toString().padStart(2, '0')}`;
                    timeSlots.push(time);
                }
            }
            console.log('Created', timeSlots.length, 'time slots');

            const headerRow = document.createElement('div');
            headerRow.className = 'calendar-header-cell';
            headerRow.textContent = 'Time';
            grid.appendChild(headerRow);

            const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            days.forEach(day => {
                const dayHeader = document.createElement('div');
                dayHeader.className = 'calendar-header-cell';
                dayHeader.textContent = day;
                grid.appendChild(dayHeader);
            });

            timeSlots.forEach(time => {
                const timeSlot = document.createElement('div');
                timeSlot.className = 'time-slot';
                timeSlot.textContent = time;
                grid.appendChild(timeSlot);

                for (let i = 0; i < 7; i++) {
                    const cell = document.createElement('div');
                    cell.className = 'calendar-cell';
                    
                    const currentDate = new Date(currentWeekStart);
                    currentDate.setDate(currentDate.getDate() + i);
                    const today = new Date().toDateString();
                    if (currentDate.toDateString() === today) {
                        cell.classList.add('today');
                    }

                    const cellDate = currentDate.toISOString().split('T')[0];
                    console.log(`Checking cell for date: ${cellDate}, time: ${time}`);
                    
                    const cellSchedules = schedules.filter(schedule => {
                        const matchesDate = schedule.date === cellDate;
                        const matchesStartTime = schedule.start_time <= time;
                        const matchesEndTime = schedule.end_time > time;
                        
                        if (matchesDate) {
                            console.log(`Schedule ${schedule.title} matches date ${cellDate}:`, {
                                scheduleDate: schedule.date,
                                scheduleStart: schedule.start_time,
                                scheduleEnd: schedule.end_time,
                                cellTime: time,
                                matchesStartTime,
                                matchesEndTime
                            });
                        }
                        
                        return matchesDate && matchesStartTime && matchesEndTime;
                    });
                    
                    if (cellSchedules.length > 0) {
                        console.log(`Found ${cellSchedules.length} schedules for ${cellDate} at ${time}:`, cellSchedules);
                    }
                    
                    cellSchedules.forEach(schedule => {
                        const scheduleItem = document.createElement('div');
                        scheduleItem.className = `schedule-item ${schedule.type}`;
                        scheduleItem.textContent = schedule.title;
                        scheduleItem.style.top = '2px';
                        scheduleItem.style.bottom = '2px';
                        scheduleItem.onclick = (e) => {
                            e.stopPropagation();
                            showScheduleDetails(schedule.id);
                        };
                        cell.appendChild(scheduleItem);
                    });

                    grid.appendChild(cell);
                }
            });
            console.log('Calendar grid generated with', grid.children.length, 'total elements');
        }

        async function navigateWeek(direction) {
            showLoading(true);
            try {
                const response = await fetch('<?= base_url('schedule/getWeekDates') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                    body: `direction=${direction}&current_start=${currentWeekStart}`
                });
                const data = await response.json();
                if (data.success) {
                    currentWeekStart = data.start_date;
                    currentWeekEnd = data.end_date;
                    const startDate = new Date(currentWeekStart);
                    const endDate = new Date(currentWeekEnd);
                    document.getElementById('week-display').textContent = 
                        `${startDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric' })} - ${endDate.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}`;
                    await loadWeekSchedules();
                }
            } catch (error) {
                showError('Failed to navigate week');
            } finally {
                showLoading(false);
            }
        }

        async function loadWeekSchedules() {
            try {
                const response = await fetch('<?= base_url('schedule/getWeek') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                    body: `start_date=${currentWeekStart}&end_date=${currentWeekEnd}`
                });
                const data = await response.json();
                console.log('Week schedules response:', data);
                if (data.success) {
                    schedules = data.schedules;
                    console.log('Updated schedules array:', schedules);
                    updateStats(data.stats);
                    generateCalendar();
                } else {
                    console.error('Failed to load schedules:', data.error);
                }
            } catch (error) {
                showError('Failed to load schedules');
            }
        }

        function updateStats(stats) {
            document.getElementById('weekly-hours').textContent = stats.weekly_hours;
            document.getElementById('surgeries-scheduled').textContent = stats.surgeries_scheduled;
            document.getElementById('available-slots').textContent = stats.available_slots;
            document.getElementById('on-call-hours').textContent = stats.on_call_hours;
        }

        async function addSchedule() {
            const form = document.getElementById('add-schedule-form');
            
            // Validate form
            if (!validateScheduleForm()) {
                return;
            }
            
            const formData = new FormData(form);
            
            // Calculate the actual date based on selected day and current week
            const selectedDay = formData.get('day');
            const startTime = formData.get('start_time');
            const duration = parseInt(formData.get('duration'));
            
            // Get the date for the selected day in current week
            const dayIndex = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'].indexOf(selectedDay);
            const currentDate = new Date(currentWeekStart);
            currentDate.setDate(currentDate.getDate() + dayIndex);
            const selectedDate = currentDate.toISOString().split('T')[0];
            
            // Calculate end time based on duration
            const startTimeObj = new Date(`2000-01-01T${startTime}`);
            const endTimeObj = new Date(startTimeObj.getTime() + (duration * 60 * 1000));
            const endTime = endTimeObj.toTimeString().slice(0, 5);
            
            // Create new form data with calculated values
            const newFormData = new FormData();
            newFormData.append('title', formData.get('title')); // This gets the patient/activity name
            newFormData.append('type', formData.get('type'));
            newFormData.append('date', selectedDate);
            newFormData.append('start_time', startTime);
            newFormData.append('end_time', endTime);
            newFormData.append('room', formData.get('room'));
            newFormData.append('description', formData.get('description'));
            
            console.log('Sending schedule data:', {
                title: formData.get('title'),
                type: formData.get('type'),
                date: selectedDate,
                start_time: startTime,
                end_time: endTime,
                room: formData.get('room'),
                description: formData.get('description')
            });
            
            try {
                const response = await fetch('<?= base_url('schedule/addSchedule') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: newFormData
                });
                const data = await response.json();
                console.log('Add schedule response:', data);
                if (data.success) {
                    showSuccess(data.message);
                    closeModal('add-schedule-modal');
                    form.reset();
                    console.log('Schedule added successfully, reloading week...');
                    await loadWeekSchedules();
                } else {
                    console.error('Failed to add schedule:', data.error);
                    showError(data.error);
                }
            } catch (error) {
                showError('Failed to add schedule');
            }
        }
        
        function validateScheduleForm() {
            const title = document.getElementById('schedule-patient').value.trim();
            const type = document.getElementById('schedule-type').value;
            const day = document.getElementById('schedule-day').value;
            const startTime = document.getElementById('schedule-start-time').value;
            const duration = document.getElementById('schedule-duration').value;
            
            if (!title) {
                showError('Please enter a patient name or activity');
                return false;
            }
            
            if (!type) {
                showError('Please select an activity type');
                return false;
            }
            
            if (!day) {
                showError('Please select a day');
                return false;
            }
            
            if (!startTime) {
                showError('Please select a start time');
                return false;
            }
            
            if (!duration) {
                showError('Please select a duration');
                return false;
            }
            
            return true;
        }

        async function blockTime() {
            const form = document.getElementById('block-time-form');
            const formData = new FormData(form);
            try {
                const response = await fetch('<?= base_url('schedule/blockTime') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                const data = await response.json();
                if (data.success) {
                    showSuccess(data.message);
                    closeModal('block-time-modal');
                    form.reset();
                    await loadWeekSchedules();
                } else {
                    showError(data.error);
                }
            } catch (error) {
                showError('Failed to block time');
            }
        }

        async function showScheduleDetails(scheduleId) {
            selectedScheduleId = scheduleId;
            
            // Check if this is a consultation
            if (scheduleId.startsWith('consultation_')) {
                const consultationId = scheduleId.replace('consultation_', '');
                showConsultationDetails(consultationId);
                return;
            }
            
            try {
                const response = await fetch('<?= base_url('schedule/getScheduleDetails') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                    body: `schedule_id=${scheduleId}`
                });
                const data = await response.json();
                if (data.success) {
                    const schedule = data.schedule;
                    document.getElementById('details-title').textContent = schedule.title;
                    const content = document.getElementById('schedule-details-content');
                    content.innerHTML = `
                        <div class="form-group"><label><strong>Type:</strong></label><p>${schedule.type.replace('_', ' ').toUpperCase()}</p></div>
                        <div class="form-group"><label><strong>Date:</strong></label><p>${new Date(schedule.date).toLocaleDateString()}</p></div>
                        <div class="form-group"><label><strong>Time:</strong></label><p>${schedule.start_time} - ${schedule.end_time}</p></div>
                        ${schedule.room ? `<div class="form-group"><label><strong>Room:</strong></label><p>${schedule.room}</p></div>` : ''}
                        ${schedule.first_name ? `<div class="form-group"><label><strong>Patient:</strong></label><p>${schedule.first_name} ${schedule.last_name}</p></div><div class="form-group"><label><strong>Phone:</strong></label><p>${schedule.phone || 'N/A'}</p></div>` : ''}
                        ${schedule.description ? `<div class="form-group"><label><strong>Description:</strong></label><p>${schedule.description}</p></div>` : ''}
                    `;
                    openModal('schedule-details-modal');
                } else {
                    showError(data.error);
                }
            } catch (error) {
                showError('Failed to load schedule details');
            }
        }
        
        async function showConsultationDetails(consultationId) {
            try {
                const response = await fetch('<?= base_url('doctor/consultations/details/') ?>' + consultationId, {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                if (data.success) {
                    const consultation = data.consultation;
                    const dateTime = new Date(consultation.date_time);
                    const endTime = new Date(dateTime.getTime() + (consultation.duration * 60 * 1000));
                    
                    // Get room information from the schedule data
                    const scheduleItem = schedules.find(s => s.id === 'consultation_' + consultationId);
                    const room = scheduleItem ? scheduleItem.room : 'N/A';
                    
                    document.getElementById('details-title').textContent = consultation.patient_name + ' - ' + consultation.consultation_type;
                    const content = document.getElementById('schedule-details-content');
                    content.innerHTML = `
                        <div class="form-group"><label><strong>Type:</strong></label><p>CONSULTATION</p></div>
                        <div class="form-group"><label><strong>Date:</strong></label><p>${dateTime.toLocaleDateString()}</p></div>
                        <div class="form-group"><label><strong>Time:</strong></label><p>${dateTime.toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})} - ${endTime.toLocaleTimeString('en-US', {hour: '2-digit', minute:'2-digit'})}</p></div>
                        <div class="form-group"><label><strong>Room:</strong></label><p>${room}</p></div>
                        <div class="form-group"><label><strong>Patient:</strong></label><p>${consultation.patient_name}</p></div>
                        <div class="form-group"><label><strong>Consultation Type:</strong></label><p>${consultation.consultation_type}</p></div>
                        <div class="form-group"><label><strong>Chief Complaint:</strong></label><p>${consultation.chief_complaint || 'N/A'}</p></div>
                        <div class="form-group"><label><strong>Status:</strong></label><p>${consultation.status || 'Active'}</p></div>
                        ${consultation.notes ? `<div class="form-group"><label><strong>Notes:</strong></label><p>${consultation.notes}</p></div>` : ''}
                    `;
                    openModal('schedule-details-modal');
                } else {
                    showError(data.message || 'Failed to load consultation details');
                }
            } catch (error) {
                showError('Failed to load consultation details');
            }
        }

        async function deleteSchedule() {
            if (!selectedScheduleId || !confirm('Are you sure you want to delete this schedule?')) return;
            
            // Check if this is a consultation
            if (selectedScheduleId.startsWith('consultation_')) {
                showError('Consultations cannot be deleted from the schedule. Please manage them from the Consultations page.');
                return;
            }
            
            try {
                const response = await fetch('<?= base_url('schedule/deleteSchedule') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                    body: `schedule_id=${selectedScheduleId}`
                });
                const data = await response.json();
                if (data.success) {
                    showSuccess(data.message);
                    closeModal('schedule-details-modal');
                    await loadWeekSchedules();
                } else {
                    showError(data.error);
                }
            } catch (error) {
                showError('Failed to delete schedule');
            }
        }

        function openModal(modalId) { 
            document.getElementById(modalId).style.display = 'block'; 
            
            // Set smart defaults for add schedule modal
            if (modalId === 'add-schedule-modal') {
                setSmartDefaults();
            }
        }
        
        function setSmartDefaults() {
            // Set current day as default
            const today = new Date();
            const dayNames = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            const currentDay = dayNames[today.getDay()];
            
            const daySelect = document.getElementById('schedule-day');
            if (daySelect) {
                daySelect.value = currentDay;
            }
            
            // Set current time as default start time (rounded to nearest 30 minutes)
            const currentHour = today.getHours();
            const currentMinute = today.getMinutes();
            const roundedMinute = currentMinute < 30 ? 0 : 30;
            const defaultTime = `${String(currentHour).padStart(2, '0')}:${String(roundedMinute).padStart(2, '0')}`;
            
            const timeSelect = document.getElementById('schedule-start-time');
            if (timeSelect) {
                // Find closest available time
                const timeOptions = Array.from(timeSelect.options).map(opt => opt.value);
                const closestTime = timeOptions.reduce((prev, curr) => {
                    return Math.abs(new Date(`2000-01-01T${curr}`) - new Date(`2000-01-01T${defaultTime}`)) < 
                           Math.abs(new Date(`2000-01-01T${prev}`) - new Date(`2000-01-01T${defaultTime}`)) ? curr : prev;
                });
                timeSelect.value = closestTime;
            }
        }
        
        function closeModal(modalId) { document.getElementById(modalId).style.display = 'none'; }
        function showLoading(show) { document.getElementById('loading').style.display = show ? 'block' : 'none'; }
        function showSuccess(message) { const alert = document.getElementById('success-alert'); alert.textContent = message; alert.style.display = 'block'; setTimeout(() => alert.style.display = 'none', 3000); }
        function showError(message) { const alert = document.getElementById('error-alert'); alert.textContent = message; alert.style.display = 'block'; setTimeout(() => alert.style.display = 'none', 5000); }
    </script>
</body>
</html>

