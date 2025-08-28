<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor • My Schedule</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; background: #f8fafc; color: #334155; }
        .container { display: flex; min-height: 100vh; }
        .sidebar { width: 250px; background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%); color: #fff; position: fixed; height: 100vh; overflow-y: auto; }
        .main { flex: 1; margin-left: 250px; }
        .header { background: #fff; padding: 24px 32px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-bottom: 1px solid #e2e8f0; }
        .header-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .header-left h1 { font-size: 28px; font-weight: 700; color: #1e293b; margin: 0; }
        .header-left .subtitle { font-size: 16px; color: #64748b; margin-top: 4px; }
        .header-actions { display: flex; align-items: center; gap: 16px; }
        .search-container { position: relative; min-width: 300px; }
        .search-input { width: 100%; padding: 12px 16px 12px 44px; border: 1px solid #d1d5db; border-radius: 12px; font-size: 14px; background: #f8fafc; transition: all 0.2s; }
        .search-input:focus { outline: none; border-color: #3b82f6; background: #fff; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .search-icon { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #9ca3af; }
        .notification-icons { display: flex; align-items: center; gap: 12px; }
        .icon-btn { position: relative; width: 40px; height: 40px; border-radius: 10px; background: #f1f5f9; border: 1px solid #e2e8f0; display: grid; place-items: center; cursor: pointer; transition: all 0.2s; }
        .icon-btn:hover { background: #e2e8f0; border-color: #cbd5e1; }
        .badge { position: absolute; top: -6px; right: -6px; background: #ef4444; color: #fff; border-radius: 999px; font-size: 11px; padding: 2px 6px; font-weight: 700; min-width: 18px; text-align: center; }
        .doctor-profile { display: flex; align-items: center; gap: 12px; padding: 8px 16px; background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0; cursor: pointer; transition: all 0.2s; }
        .doctor-profile:hover { background: #f1f5f9; border-color: #cbd5e1; }
        .doctor-avatar { width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #8b5cf6, #a855f7); color: #fff; display: grid; place-items: center; font-weight: 700; font-size: 16px; }
        .doctor-info { line-height: 1.2; }
        .doctor-name { font-weight: 600; color: #1e293b; font-size: 14px; }
        .doctor-specialty { font-size: 12px; color: #64748b; }
        .dropdown-arrow { color: #64748b; font-size: 12px; }
        .schedule-controls { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .navigation-buttons { display: flex; align-items: center; gap: 8px; }
        .nav-btn { padding: 8px 16px; border: 1px solid #d1d5db; background: #fff; color: #374151; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; transition: all 0.2s; }
        .nav-btn:hover { background: #f9fafb; border-color: #9ca3af; }
        .nav-btn.active { background: #3b82f6; color: #fff; border-color: #3b82f6; }
        .action-buttons { display: flex; align-items: center; gap: 12px; }
        .btn { padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; gap: 8px; }
        .btn-block { background: #ef4444; color: #fff; }
        .btn-block:hover { background: #dc2626; }
        .btn-add { background: #3b82f6; color: #fff; }
        .btn-add:hover { background: #2563eb; }
        .schedule-grid { background: #fff; border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .grid-header { display: grid; grid-template-columns: 120px repeat(7, 1fr); background: #f8fafc; border-bottom: 1px solid #e2e8f0; }
        .grid-header-cell { padding: 16px 12px; text-align: center; font-weight: 600; color: #374151; font-size: 14px; border-right: 1px solid #e2e8f0; }
        .grid-header-cell:first-child { text-align: left; padding-left: 24px; }
        .grid-header-cell:last-child { border-right: none; }
        .grid-body { display: grid; grid-template-columns: 120px repeat(7, 1fr); }
        .time-slot { padding: 12px 24px; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #f1f5f9; font-size: 13px; color: #64748b; font-weight: 500; display: flex; align-items: center; }
        .schedule-cell { border-right: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; padding: 4px; position: relative; min-height: 60px; }
        .schedule-cell:last-child { border-right: none; }
        .schedule-card { background: #fff; border-radius: 8px; padding: 8px 10px; margin: 2px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); border-left: 4px solid; font-size: 12px; line-height: 1.3; cursor: pointer; transition: all 0.2s; position: relative; overflow: hidden; min-height: 60px; display: flex; flex-direction: column; justify-content: space-between; }
        .schedule-card:hover { transform: translateY(-1px); box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15); }
        .card-blue { background: #eff6ff; border-left-color: #3b82f6; color: #1e40af; }
        .card-purple { background: #f3e8ff; border-left-color: #8b5cf6; color: #6b21a8; }
        .card-red { background: #fef2f2; border-left-color: #ef4444; color: #b91c1c; }
        .card-green { background: #f0fdf4; border-left-color: #10b981; color: #047857; }
        .card-orange { background: #fff7ed; border-left-color: #f59e0b; color: #b45309; }
        .card-gray { background: #f8fafc; border-left-color: #64748b; color: #475569; }
        .card-title { font-weight: 600; margin-bottom: 2px; text-transform: capitalize; }
        .card-details { font-size: 11px; opacity: 0.9; }
        .card-duration { font-size: 10px; opacity: 0.8; margin-top: 2px; }
        .card-location { font-size: 10px; opacity: 0.8; margin-top: 1px; }
        .card-icon { position: absolute; top: 6px; right: 8px; font-size: 14px; opacity: 0.7; }
        .legend { display: flex; align-items: center; gap: 24px; margin-top: 24px; padding: 20px; background: #fff; border-radius: 12px; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); }
        .legend-item { display: flex; align-items: center; gap: 8px; font-size: 13px; color: #64748b; }
        .legend-color { width: 16px; height: 16px; border-radius: 4px; border-left: 3px solid; }
        .legend-color.blue { background: #eff6ff; border-left-color: #3b82f6; }
        .legend-color.purple { background: #f3e8ff; border-left-color: #8b5cf6; }
        .legend-color.red { background: #fef2f2; border-left-color: #ef4444; }
        .legend-color.green { background: #f0fdf4; border-left-color: #10b981; }
        .legend-color.orange { background: #fff7ed; border-left-color: #f59e0b; }
        .legend-color.gray { background: #f8fafc; border-left-color: #64748b; }
        
        /* Modal Styles */
        .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); overflow-y: auto; }
        .modal-content { background-color: #fff; margin: 5% auto; padding: 0; border-radius: 16px; width: 90%; max-width: 600px; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); }
        .modal-header { padding: 24px 24px 20px; border-bottom: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center; }
        .modal-header h3 { font-size: 20px; font-weight: 600; color: #1f2937; margin: 0; }
        .close { color: #64748b; font-size: 28px; font-weight: bold; cursor: pointer; line-height: 1; transition: color 0.2s; }
        .close:hover { color: #1f2937; }
        .modal-body { padding: 24px; }
        .modal-footer { padding: 20px 24px; border-top: 1px solid #e2e8f0; display: flex; justify-content: flex-end; gap: 12px; background: #f8fafc; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 500; color: #374151; font-size: 14px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 12px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; transition: all 0.2s; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .btn-primary { background: #3b82f6; color: #fff; }
        .btn-primary:hover { background: #2563eb; }
        .btn-secondary { background: #6b7280; color: #fff; }
        .btn-secondary:hover { background: #4b5563; }
        .alert { padding: 16px 20px; border-radius: 10px; margin-bottom: 20px; display: none; font-weight: 500; }
        .alert-success { background: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; }
        .alert-error { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    </style>
</head>
<body>
    <div class="container">
        <?php echo view('auth/partials/doctor_sidebar'); ?>

        <div class="main">
            <div class="header">
                <div class="header-top">
                    <div class="header-left">
                        <h1>My Schedule</h1>
                        <div class="subtitle">Manage your working hours and availability</div>
                    </div>
                    <div class="header-actions">
                        <div class="search-container">
                            <svg class="search-icon" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <input type="text" class="search-input" placeholder="Search patients, appointments...">
                        </div>
                        <div class="notification-icons">
                            <button class="icon-btn" title="Notifications">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="badge">3</span>
                            </button>
                            <button class="icon-btn" title="Calendar">
                                <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span class="badge">3</span>
                            </button>
                        </div>
                        <div class="doctor-profile">
                            <div class="doctor-avatar">DR</div>
                            <div class="doctor-info">
                                <div class="doctor-name"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Maria Santos') : 'Dr. Maria Santos' ?></div>
                                <div class="doctor-specialty"><?= session('specialty') ?? 'Cardiology' ?></div>
                            </div>
                            <span class="dropdown-arrow">▼</span>
                        </div>
                    </div>
                </div>
                
                <div class="schedule-controls">
                    <div class="navigation-buttons">
                        <button class="nav-btn">Previous</button>
                        <button class="nav-btn active">This Week</button>
                        <button class="nav-btn">Next</button>
                    </div>
                    <div class="action-buttons">
                        <button class="btn btn-block">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Block Time
                        </button>
                        <button class="btn btn-add">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            + Add to Schedule
                        </button>
                    </div>
                </div>
            </div>

            <div class="page" style="padding: 24px;">
                <div class="schedule-grid">
                    <div class="grid-header">
                        <div class="grid-header-cell">Time</div>
                        <div class="grid-header-cell">Monday</div>
                        <div class="grid-header-cell">Tuesday</div>
                        <div class="grid-header-cell">Wednesday</div>
                        <div class="grid-header-cell">Thursday</div>
                        <div class="grid-header-cell">Friday</div>
                        <div class="grid-header-cell">Saturday</div>
                        <div class="grid-header-cell">Sunday</div>
                    </div>
                    
                    <div class="grid-body" id="schedule-grid-body">
                        <!-- Time slots will be generated by JavaScript -->
                    </div>
                </div>
                
                <div class="legend">
                    <div class="legend-item">
                        <div class="legend-color blue"></div>
                        <span>Appointments</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color purple"></div>
                        <span>Rounds</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color red"></div>
                        <span>Surgery</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color green"></div>
                        <span>Consultation</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color orange"></div>
                        <span>Meeting</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color gray"></div>
                        <span>Research</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add to Schedule Modal -->
    <div id="add-schedule-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add to Schedule</h3>
                <span class="close" onclick="closeModal('add-schedule-modal')">&times;</span>
            </div>
            <div class="modal-body">
                <div class="alert alert-success" id="success-alert"></div>
                <div class="alert alert-error" id="error-alert"></div>
                
                <form id="add-schedule-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="activity-type">Activity Type</label>
                            <select id="activity-type" name="type" required onchange="handleActivityTypeChange()">
                                <option value="">Select type</option>
                                <option value="appointment">Patient Appointment</option>
                                <option value="surgery">Surgery</option>
                                <option value="consultation">Consultation</option>
                                <option value="ward_rounds">Hospital Rounds</option>
                                <option value="meeting">Meeting</option>
                                <option value="research">Research Time</option>
                                <option value="rest_day">Rest Day</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="schedule-day">Day</label>
                            <select id="schedule-day" name="day" required>
                                <option value="">Select day</option>
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
                            <label for="start-time">Start Time</label>
                            <select id="start-time" name="start_time" required>
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
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration</label>
                            <select id="duration" name="duration" required>
                                <option value="">Select duration</option>
                                <option value="0.5">30 minutes</option>
                                <option value="1">1 hour</option>
                                <option value="1.5">1.5 hours</option>
                                <option value="2">2 hours</option>
                                <option value="3">3 hours</option>
                                <option value="4">4 hours</option>
                                <option value="8">8 hours</option>
                                <option value="24">1 day (24 hours)</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="patient-activity">Patient/Activity</label>
                        <select id="patient-activity" name="title" required>
                            <option value="">Select patient or enter activity</option>
                            <option value="custom">-- Enter Custom Activity --</option>
                        </select>
                        <input type="text" id="custom-activity" name="custom_title" placeholder="Enter custom activity name" style="display:none; margin-top:8px;">
                    </div>
                    <div class="form-group">
                        <label for="room-location">Room/Location</label>
                        <select id="room-location" name="room" required>
                            <option value="">Select room</option>
                            <option value="Room 201">Room 201</option>
                            <option value="Room 202">Room 202</option>
                            <option value="Room 203">Room 203</option>
                            <option value="OR-1">OR-1</option>
                            <option value="OR-2">OR-2</option>
                            <option value="Doctor Room">Doctor Room</option>
                            <option value="Conference Room">Conference Room</option>
                            <option value="Various">Various</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea id="notes" name="description" rows="3" placeholder="Additional notes or details"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="closeModal('add-schedule-modal')">Cancel</button>
                <button class="btn btn-primary" onclick="addSchedule()">Add to Schedule</button>
            </div>
        </div>
    </div>

    <script>
        // Generate time slots dynamically
        function generateTimeSlots() {
            const gridBody = document.getElementById('schedule-grid-body');
            const timeSlots = [
                '8:00 AM', '8:30 AM', '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM',
                '12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM',
                '4:00 PM', '4:30 PM', '5:00 PM'
            ];
            
            timeSlots.forEach(time => {
                const row = document.createElement('div');
                row.className = 'schedule-row';
                row.style.display = 'grid';
                row.style.gridTemplateColumns = '120px repeat(7, 1fr)';
                
                // Time slot
                const timeSlot = document.createElement('div');
                timeSlot.className = 'time-slot';
                timeSlot.textContent = time;
                timeSlot.dataset.time = time;
                row.appendChild(timeSlot);
                
                // Schedule cells for each day
                for (let i = 0; i < 7; i++) {
                    const cell = document.createElement('div');
                    cell.className = 'schedule-cell';
                    cell.dataset.day = i;
                    cell.dataset.time = time;
                    row.appendChild(cell);
                }
                
                gridBody.appendChild(row);
            });
        }

        // Navigation button functionality
        document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.nav-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Add to Schedule button functionality
        const addButton = document.querySelector('.btn-add');
        if (addButton) {
            addButton.addEventListener('click', function() {
                openAddModal();
            });
        }

        // Initialize schedule
        document.addEventListener('DOMContentLoaded', function() {
            generateTimeSlots();
            loadPatients();
            loadRooms();
            loadExistingSchedules();
        });

        function openAddModal() {
            const modal = document.getElementById('add-schedule-modal');
            modal.style.display = 'block';
        }

        async function loadPatients() {
            try {
                const response = await fetch('<?= base_url('doctor/patients') ?>', {
                    method: 'GET',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (response.ok) {
                    const html = await response.text();
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const patientRows = doc.querySelectorAll('table tbody tr');
                    const patients = [];
                    
                    patientRows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        if (cells.length >= 3) {
                            const patientName = cells[1]?.textContent?.trim();
                            if (patientName && patientName !== 'N/A') {
                                patients.push(patientName);
                            }
                        }
                    });
                    
                    if (patients.length > 0) {
                        const patientSelect = document.getElementById('patient-activity');
                        patientSelect.innerHTML = '<option value="">Select patient or enter activity</option><option value="custom">-- Enter Custom Activity --</option>';
                        
                        patients.forEach(patient => {
                            const option = document.createElement('option');
                            option.value = patient;
                            option.textContent = patient;
                            patientSelect.appendChild(option);
                        });
                    }
                }
            } catch (error) {
                console.error('Error loading patients:', error);
            }
        }

        async function loadRooms() {
            // Rooms are already in the HTML
        }

        function handleActivityTypeChange() {
            const activityType = document.getElementById('activity-type').value;
            const roomSelect = document.getElementById('room-location');
            const patientSelect = document.getElementById('patient-activity');
            const startTimeSelect = document.getElementById('start-time');
            const durationSelect = document.getElementById('duration');
            
            if (activityType === 'consultation') {
                roomSelect.value = 'Doctor Room';
            } else if (activityType === 'rest_day') {
                patientSelect.disabled = true;
                patientSelect.value = '';
                roomSelect.disabled = true;
                roomSelect.value = '';
                startTimeSelect.disabled = true;
                startTimeSelect.value = '';
                durationSelect.value = '24';
                durationSelect.disabled = true;
            } else {
                patientSelect.disabled = false;
                roomSelect.disabled = false;
                startTimeSelect.disabled = false;
                durationSelect.disabled = false;
            }
        }

        // Handle patient/activity selection
        document.addEventListener('change', function(e) {
            if (e.target.id === 'patient-activity') {
                const customInput = document.getElementById('custom-activity');
                if (e.target.value === 'custom') {
                    customInput.style.display = 'block';
                    customInput.required = true;
                } else {
                    customInput.style.display = 'none';
                    customInput.required = false;
                }
            }
        });

        async function addSchedule() {
            const form = document.getElementById('add-schedule-form');
            const formData = new FormData(form);
            
            const activityType = formData.get('type');
            
            if (activityType !== 'rest_day') {
                const patientActivity = formData.get('title');
                if (patientActivity === 'custom') {
                    const customActivity = document.getElementById('custom-activity').value.trim();
                    if (!customActivity) {
                        showError('Please enter a custom activity name');
                        return;
                    }
                    formData.set('title', customActivity);
                }
            }
            
            if (activityType === 'rest_day') {
                formData.set('title', 'Rest Day');
                formData.set('start_time', '00:00');
                formData.set('end_time', '23:59');
                formData.set('room', 'N/A');
            } else {
                const startTime = formData.get('start_time');
                const duration = parseFloat(formData.get('duration'));
                const startTimeObj = new Date(`2000-01-01T${startTime}`);
                const endTimeObj = new Date(startTimeObj.getTime() + (duration * 60 * 60 * 1000));
                const endTime = endTimeObj.toTimeString().slice(0, 5);
                formData.append('end_time', endTime);
            }
            
            const day = formData.get('day');
            const date = getDateForDay(day);
            formData.append('date', date);
            
            try {
                const response = await fetch('<?= base_url('schedule/addSchedule') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.success) {
                    addScheduleToCalendar(formData);
                    showSuccess('Schedule added successfully!');
                    closeModal('add-schedule-modal');
                    form.reset();
                } else {
                    showError(data.error || 'Failed to add schedule');
                }
            } catch (error) {
                console.error('Error adding schedule:', error);
                showError('Failed to add schedule. Please try again.');
            }
        }

        function getDateForDay(day) {
            const days = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
            const today = new Date();
            const currentDay = today.getDay();
            const targetDay = days.indexOf(day);
            const diff = targetDay - currentDay;
            
            const targetDate = new Date(today);
            targetDate.setDate(today.getDate() + diff);
            
            return targetDate.toISOString().split('T')[0];
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function showSuccess(message) {
            const alert = document.getElementById('success-alert');
            alert.textContent = message;
            alert.style.display = 'block';
            setTimeout(() => alert.style.display = 'none', 3000);
        }

        function showError(message) {
            const alert = document.getElementById('error-alert');
            alert.textContent = message;
            alert.style.display = 'block';
            setTimeout(() => alert.style.display = 'none', 5000);
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        }

        // Function to add new schedule to calendar immediately
        function addScheduleToCalendar(formData) {
            const day = formData.get('day');
            const startTime = formData.get('start_time');
            const title = formData.get('title');
            const type = formData.get('type');
            const duration = formData.get('duration');
            const room = formData.get('room');
            
            // Convert 24-hour time to 12-hour display format
            const timeDisplay = convertTo12Hour(startTime);
            
            // Find the exact time slot
            const timeSlot = document.querySelector(`[data-time="${timeDisplay}"]`);
            const dayIndex = getDayIndex(day);
            
            if (timeSlot && dayIndex !== -1) {
                const cell = timeSlot.parentElement.querySelector(`[data-day="${dayIndex}"]`);
                if (cell) {
                    const scheduleCard = createScheduleCard(title, type, duration, room);
                    cell.innerHTML = '';
                    cell.appendChild(scheduleCard);
                }
            }
        }

        // Helper function to convert 24-hour to 12-hour format
        function convertTo12Hour(time24) {
            const [hours, minutes] = time24.split(':');
            const hour = parseInt(hours);
            const ampm = hour >= 12 ? 'PM' : 'AM';
            const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
            return `${displayHour}:${minutes} ${ampm}`;
        }

        // Helper function to get day index
        function getDayIndex(day) {
            const dayMap = {
                'monday': 0,
                'tuesday': 1,
                'wednesday': 2,
                'thursday': 3,
                'friday': 4,
                'saturday': 5,
                'sunday': 6
            };
            return dayMap[day.toLowerCase()] || 0;
        }

        // Helper function to create schedule card
        function createScheduleCard(title, type, duration, room) {
            const card = document.createElement('div');
            card.className = 'schedule-card';
            
            const typeColors = {
                'appointment': 'card-blue',
                'surgery': 'card-red',
                'consultation': 'card-green',
                'ward_rounds': 'card-purple',
                'meeting': 'card-orange',
                'research': 'card-gray',
                'rest_day': 'card-gray'
            };
            
            card.classList.add(typeColors[type] || 'card-blue');
            
            let durationText = '';
            if (duration === '0.5') durationText = '30 min';
            else if (duration === '1') durationText = '1 hour';
            else if (duration === '1.5') durationText = '1.5 hours';
            else if (duration === '2') durationText = '2 hours';
            else if (duration === '3') durationText = '3 hours';
            else if (duration === '4') durationText = '4 hours';
            else if (duration === '8') durationText = '8 hours';
            else if (duration === '24') durationText = 'Full day';
            else durationText = `${duration} hours`;
            
            let displayTitle = title;
            if (type === 'rest_day') {
                displayTitle = 'Rest Day';
            } else if (title.length > 20) {
                displayTitle = title.substring(0, 20) + '...';
            }
            
            card.innerHTML = `
                <div class="card-title">${type.charAt(0).toUpperCase() + type.slice(1).replace('_', ' ')}</div>
                <div class="card-details">${displayTitle}</div>
                <div class="card-duration">${durationText}</div>
                <div class="card-location">${room}</div>
                <div class="card-icon">${getIconForType(type)}</div>
            `;
            
            if (title.length > 20) {
                card.title = title;
            }
            
            return card;
        }

        // Helper function to get icon for schedule type
        function getIconForType(type) {
            const icons = {
                'appointment': '📅',
                'surgery': '🔪',
                'consultation': '🏥',
                'ward_rounds': '🚶',
                'meeting': '👥',
                'research': '🧪',
                'rest_day': '😴'
            };
            return icons[type] || '📅';
        }

        // Function to load existing schedules from database
        async function loadExistingSchedules() {
            try {
                const response = await fetch('<?= base_url('schedule/getWeeklySchedules') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await response.json();
                
                if (data.success && data.schedules) {
                    data.schedules.forEach(schedule => {
                        addScheduleToCalendarFromData(schedule);
                    });
                }
            } catch (error) {
                console.error('Error loading existing schedules:', error);
            }
        }

        // Function to add schedule from database data
        function addScheduleToCalendarFromData(schedule) {
            const timeDisplay = convertTo12Hour(schedule.start_time);
            const timeSlot = document.querySelector(`[data-time="${timeDisplay}"]`);
            const dayColumn = getDayColumnFromDate(schedule.date);
            
            if (timeSlot && dayColumn !== -1) {
                const cell = timeSlot.parentElement.querySelector(`[data-day="${dayColumn}"]`);
                if (cell) {
                    const scheduleCard = createScheduleCard(
                        schedule.title, 
                        schedule.type, 
                        getDurationFromTimes(schedule.start_time, schedule.end_time), 
                        schedule.room || 'N/A'
                    );
                    cell.innerHTML = '';
                    cell.appendChild(scheduleCard);
                }
            }
        }

        // Helper function to get day column from date
        function getDayColumnFromDate(dateString) {
            const date = new Date(dateString);
            const dayOfWeek = date.getDay();
            return dayOfWeek;
        }

        // Helper function to calculate duration from start and end times
        function getDurationFromTimes(startTime, endTime) {
            const start = new Date(`2000-01-01T${startTime}`);
            const end = new Date(`2000-01-01T${endTime}`);
            const diffMs = end - start;
            const diffHours = diffMs / (1000 * 60 * 60);
            
            if (diffHours === 0.5) return '0.5';
            if (diffHours === 1) return '1';
            if (diffHours === 1.5) return '1.5';
            if (diffHours === 2) return '2';
            if (diffHours === 3) return '3';
            if (diffHours === 4) return '4';
            if (diffHours === 8) return '8';
            if (diffHours >= 24) return '24';
            
            return diffHours.toString();
        }
    </script>
</body>
</html>
