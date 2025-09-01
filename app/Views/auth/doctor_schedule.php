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
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: #fff;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }
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
        .grid-body { display: flex; flex-direction: column; }
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
        
        /* Sidebar - Using standard doctor sidebar styling */
        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #34495e;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .admin-icon {
            width: 36px;
            height: 36px;
            background: #3498db;
            border-radius: 8px;
            display: grid;
            place-items: center;
            font-weight: 700;
        }
        
        .sidebar-title {
            font-size: 16px;
            font-weight: 700;
        }
        
        .sidebar-sub {
            font-size: 12px;
            color: #cbd5e1;
            margin-top: 2px;
        }
        
        .sidebar-menu {
            padding: 20px 0;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #cbd5e1;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        
        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-left-color: #3498db;
        }
        
        .menu-item.active {
            background: rgba(52, 152, 219, 0.2);
            color: #fff;
            border-left-color: #3498db;
        }
        
        .menu-icon {
            width: 20px;
            text-align: center;
        }
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


                                                                          <button class="btn btn-secondary" onclick="syncWithDatabase()" style="background: #dc2626;">
                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Delete All Schedules
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
                         <div class="legend-color green"></div>
                         <span>Consultation</span>
                     </div>
                     <div class="legend-item">
                         <div class="legend-color blue"></div>
                         <span>Follow-up</span>
                     </div>
                     <div class="legend-item">
                         <div class="legend-color purple"></div>
                         <span>Treatment / Procedure</span>
                     </div>
                     <div class="legend-item">
                         <div class="legend-color orange"></div>
                         <span>Laboratory Review</span>
                     </div>
                     <div class="legend-item">
                         <div class="legend-color red"></div>
                         <span>Surgery / Operation</span>
                     </div>
                     <div class="legend-item">
                         <div class="legend-color gray"></div>
                         <span>Rest Day</span>
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
                                 <option value="consultation">Consultation</option>
                                 <option value="follow_up">Follow-up</option>
                                 <option value="treatment">Treatment / Procedure</option>
                                 <option value="lab_review">Laboratory Request / Result Review</option>
                                 <option value="surgery">Surgery / Operation</option>
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
                                                   <div style="display: flex; gap: 8px; align-items: center;">
                              <select id="patient-activity" name="title" required style="flex: 1;">
                                  <option value="">Select patient or enter activity</option>
                                  <option value="custom">-- Enter Custom Activity --</option>
                              </select>
                                                             <button type="button" onclick="refreshPatients()" style="padding: 8px 12px; background: #6b7280; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                   🔄
                               </button>
                               <button type="button" onclick="testPatientLoading()" style="padding: 8px 12px; background: #dc2626; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                    🧪
                                </button>
                                <button type="button" onclick="clearAllCache()" style="padding: 8px 12px; background: #059669; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                    🧹
                                </button>
                                <button type="button" onclick="forceLoadPatients()" style="padding: 8px 12px; background: #7c3aed; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                    🚀
                                </button>
                                <button type="button" onclick="alert('Function accessible!')" style="padding: 8px 12px; background: #f59e0b; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 12px;">
                                    🧪
                                </button>
                          </div>
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
            console.log('🏗️ Generating time slots...');
            const gridBody = document.getElementById('schedule-grid-body');
            console.log('🔍 Grid body element:', gridBody);
            
            if (!gridBody) {
                console.error('❌ Grid body element not found!');
                return;
            }
            
            gridBody.innerHTML = '';
            console.log('🧹 Cleared grid body');
            
            const timeSlots = [
                '8:00 AM', '8:30 AM', '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM',
                '12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM',
                '4:00 PM', '4:30 PM', '5:00 PM'
            ];
            
            console.log('⏰ Creating', timeSlots.length, 'time slots');
            
            timeSlots.forEach((time, index) => {
                const row = document.createElement('div');
                row.className = 'schedule-row';
                row.style.display = 'grid';
                row.style.gridTemplateColumns = '120px repeat(7, 1fr)';
                row.style.borderBottom = '1px solid #f1f5f9';
                
                // Time slot on the left
                const timeSlot = document.createElement('div');
                timeSlot.className = 'time-slot';
                timeSlot.textContent = time;
                timeSlot.dataset.time = time;
                timeSlot.style.padding = '12px 24px';
                timeSlot.style.borderRight = '1px solid #e2e8f0';
                timeSlot.style.fontSize = '13px';
                timeSlot.style.color = '#64748b';
                timeSlot.style.fontWeight = '500';
                timeSlot.style.display = 'flex';
                timeSlot.style.alignItems = 'center';
                timeSlot.style.backgroundColor = '#f8fafc';
                row.appendChild(timeSlot);
                
                // Schedule cells for each day
                for (let i = 0; i < 7; i++) {
                    const cell = document.createElement('div');
                    cell.className = 'schedule-cell';
                    cell.dataset.day = i;
                    cell.dataset.time = time;
                    cell.style.borderRight = '1px solid #f1f5f9';
                    cell.style.padding = '8px';
                    cell.style.position = 'relative';
                    cell.style.minHeight = '60px';
                    cell.style.backgroundColor = '#fff';
                    
                    row.appendChild(cell);
                }
                
                gridBody.appendChild(row);
                
                if (index === 0) {
                    console.log('🔍 First row created with time slot:', time);
                    console.log('🔍 Time slot element:', timeSlot);
                    console.log('🔍 Time slot dataset:', timeSlot.dataset);
                    console.log('🔍 Cells in first row:', row.querySelectorAll('[data-day]').length);
                }
            });
            
            console.log('✅ Grid created with', timeSlots.length, 'rows');
            console.log('🔍 Total time slots in DOM:', document.querySelectorAll('[data-time]').length);
            console.log('🔍 Total cells in DOM:', document.querySelectorAll('[data-day]').length);
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
            console.log('🚀 DOM Content Loaded - Initializing schedule...');
            generateTimeSlots();
            
            // Force clear any cached patients and load fresh from database
            console.log('🧹 Clearing any cached patients...');
            localStorage.removeItem('cachedPatients');
            patientsLoaded = false;
            
            // Load patients from database immediately
            console.log('🔄 Loading patients from database...');
            loadPatients();
            
            loadRooms();
            
            // Add a small delay to ensure everything is loaded
            setTimeout(() => {
                console.log('⏰ Loading existing schedules after delay...');
                
                // First, restore any schedules from localStorage (this includes newly created ones)
                restoreTemporarySchedules();
                
                // Then load existing schedules from database (but don't overwrite localStorage ones)
                if (!window.schedulesLoaded) {
                    loadExistingSchedules();
                    window.schedulesLoaded = true;
                }
                
                // Start periodic sync with database to remove deleted schedules
                startPeriodicSync();
            }, 500);
        });

        function openAddModal() {
            const modal = document.getElementById('add-schedule-modal');
            modal.style.display = 'block';
        }

        // Flag to prevent multiple patient loading
        let patientsLoaded = false;
        
        // Simple patient management functions
        
        // Function to manually refresh patients
        function refreshPatients() {
            console.log('🔄 Manually refreshing patients...');
            patientsLoaded = false;
            
            // Clear the dropdown first
            const patientSelect = document.getElementById('patient-activity');
            patientSelect.innerHTML = '<option value="">Select patient or enter activity</option><option value="custom">-- Enter Custom Activity --</option>';
            
            // Force reload patients from database
            loadPatients();
        }
        
        // Function to test patient loading
        function testPatientLoading() {
            console.log('🧪 Testing patient loading...');
            console.log('📊 Current state:', {
                patientsLoaded: patientsLoaded,
                forcePatientReload: window.forcePatientReload,
                localStoragePatients: localStorage.getItem('cachedPatients')
            });
            loadPatients();
        }
        
        // Function to clear cache and reload patients
        function clearAllCache() {
            console.log('🧹 Clearing cache and reloading patients...');
            patientsLoaded = false;
            
            // Clear the dropdown
            const patientSelect = document.getElementById('patient-activity');
            patientSelect.innerHTML = '<option value="">Select patient or enter activity</option><option value="custom">-- Enter Custom Activity --</option>';
            
            // Force reload patients
            loadPatients();
            
            console.log('✅ Cache cleared and patients reloaded');
        }
        
        // Function to force load patients (bypass all checks)
        function forceLoadPatients() {
            console.log('🚀 Force loading patients...');
            alert('🚀 Force loading patients...');
            
            // Reset all flags
            patientsLoaded = false;
            window.forcePatientReload = true;
            
            // Clear the dropdown
            const patientSelect = document.getElementById('patient-activity');
            patientSelect.innerHTML = '<option value="">Loading patients...</option>';
            
            // Force reload patients
            loadPatients();
            
            console.log('✅ Force load triggered');
        }
        
        // Simple patient management functions
        
        // Simple schedule management - no complex protection needed
        
        // Simple patient loading function - no complex protection needed
        
        async function loadPatients() {
            console.log('🚀 loadPatients() function called!');
            
            try {
                console.log('🔄 Loading patients from database...');
                console.log('📍 Making request to:', '<?= base_url('schedule/getPatients') ?>');
                
                const response = await fetch('<?= base_url('schedule/getPatients') ?>', {
                    method: 'POST',
                    headers: { 
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'ajax=1'
                });
                
                console.log('📡 Response status:', response.status);
                console.log('📡 Response ok:', response.ok);
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                // First, let's see what the raw response looks like
                const responseText = await response.text();
                console.log('📄 Raw response text:', responseText);
                
                let data;
                try {
                    data = JSON.parse(responseText);
                    console.log('✅ Successfully parsed JSON response');
                } catch (parseError) {
                    console.error('❌ Failed to parse JSON response:', parseError);
                    console.error('❌ Response was not valid JSON');
                    
                    // Try to extract any useful information from the response
                    if (responseText.includes('patients') || responseText.includes('patient')) {
                        console.log('🔍 Response contains patient-related text');
                    }
                    
                    throw new Error('Server response is not valid JSON');
                }
                
                console.log('📥 Patient data received:', data);
                console.log('📊 Data structure:', {
                    success: data.success,
                    patientsCount: data.patients ? data.patients.length : 'undefined',
                    hasError: !!data.error,
                    errorMessage: data.error || 'None',
                    dataKeys: Object.keys(data)
                });
                
                if (data.success && data.patients && data.patients.length > 0) {
                    console.log(`✅ Found ${data.patients.length} patients in database`);
                    console.log('📋 Patient list:', data.patients);
                    
                    const patientSelect = document.getElementById('patient-activity');
                    
                    // Clear the dropdown and add default options
                    patientSelect.innerHTML = '<option value="">Select patient or enter activity</option><option value="custom">-- Enter Custom Activity --</option>';
                    
                    // Add each patient from the database
                    data.patients.forEach(patient => {
                        console.log('🔍 Processing patient:', patient);
                        console.log('🔍 Patient object keys:', Object.keys(patient));
                        
                        const option = document.createElement('option');
                        // Use the actual patient data structure from database
                        const patientName = (patient.first_name || '') + ' ' + (patient.last_name || '');
                        option.value = patientName.trim(); // Use the full name as value
                        option.textContent = patientName.trim(); // Display the full name
                        option.dataset.patientId = patient.id; // Store patient ID for reference
                        option.dataset.patientPhone = patient.phone || ''; // Store phone for reference
                        patientSelect.appendChild(option);
                        console.log('✅ Added patient:', patientName.trim(), 'ID:', patient.id, 'Phone:', patient.phone || 'N/A');
                    });
                    
                    console.log('✅ Real patients loaded into dropdown from database');
                    patientsLoaded = true; // Mark as loaded
                    
                    // Log the final state of the dropdown
                    setTimeout(() => {
                        const finalPatientSelect = document.getElementById('patient-activity');
                        console.log('🔍 Final dropdown state after loading:');
                        console.log('  Total options:', finalPatientSelect.options.length);
                        Array.from(finalPatientSelect.options).forEach((option, index) => {
                            console.log(`  ${index}: ${option.value} (${option.textContent})`);
                        });
                    }, 100);
                    
                } else {
                    console.log('⚠️ No patients found in database or error response');
                    if (data.error) {
                        console.error('❌ Server error:', data.error);
                    }
                    
                    // Don't add sample patients - only show real patients from database
                    console.log('⚠️ No patients found in database - keeping dropdown empty except for custom option');
                    patientsLoaded = true; // Mark as loaded
                }
            } catch (error) {
                console.error('💥 Error loading patients from database:', error);
                console.error('💥 Error details:', error.message);
                console.error('💥 Error stack:', error.stack);
                
                // Don't add sample patients on error - only show real patients from database
                console.log('⚠️ Error loading patients - keeping dropdown empty except for custom option');
                patientsLoaded = true; // Mark as loaded
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
             } else if (activityType === 'lab_review') {
                 roomSelect.value = 'Laboratory';
             } else if (activityType === 'surgery') {
                 roomSelect.value = 'OR-1';
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
                } else {
                    // Get the selected patient option to extract patient ID
                    const patientSelect = document.getElementById('patient-activity');
                    const selectedOption = patientSelect.options[patientSelect.selectedIndex];
                    if (selectedOption && selectedOption.dataset.patientId) {
                        // Add patient ID to form data for proper database linking
                        formData.append('patient_id', selectedOption.dataset.patientId);
                        console.log('🔗 Linking schedule to patient ID:', selectedOption.dataset.patientId);
                    }
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
            
            console.log('📅 Schedule data being sent to server:', {
                day: day,
                calculatedDate: date,
                type: activityType,
                title: formData.get('title'),
                startTime: formData.get('start_time'),
                endTime: formData.get('end_time'),
                room: formData.get('room'),
                patientId: formData.get('patient_id') || 'Not set'
            });
            
            try {
                const response = await fetch('<?= base_url('schedule/addSchedule') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData
                });
                
                const data = await response.json();
                console.log('📤 Server response:', data);
                
                if (data.success) {
                    addScheduleToCalendar(formData);
                    showSuccess('Schedule added successfully!');
                    closeModal('add-schedule-modal');
                    form.reset();
                    
                    // Don't reload schedules immediately - just keep the one we added
                    console.log('✅ Schedule added to calendar, not reloading from database');
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
            
            // Calculate days until next occurrence of target day
            let diff = targetDay - currentDay;
            if (diff <= 0) {
                diff += 7; // If target day is today or has passed, go to next week
            }
            
            const targetDate = new Date(today);
            targetDate.setDate(today.getDate() + diff);
            
            console.log('Date calculation:', {
                day: day,
                today: today.toDateString(),
                currentDay: currentDay,
                targetDay: targetDay,
                diff: diff,
                resultDate: targetDate.toDateString()
            });
            
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
            
            console.log('🎯 Adding schedule to calendar:', { day, startTime, title, type, duration, room });
            
            // Convert 24-hour time to 12-hour display format
            const timeDisplay = convertTo12Hour(startTime);
            console.log('🕐 Converted time display:', timeDisplay);
            
            // Find the exact time slot
            const timeSlot = document.querySelector(`[data-time="${timeDisplay}"]`);
            console.log('🔍 Found time slot:', timeSlot);
            
            const dayIndex = getDayIndex(day);
            console.log('📅 Day index:', dayIndex);
            
            if (timeSlot && dayIndex !== -1) {
                const cell = timeSlot.parentElement.querySelector(`[data-day="${dayIndex}"]`);
                console.log('🔍 Found cell:', cell);
                
                if (cell) {
                    const scheduleCard = createScheduleCard(title, type, duration, room);
                    console.log('🎨 Created schedule card:', scheduleCard);
                    
                    // Clear the cell and add the new schedule
                    cell.innerHTML = '';
                    cell.appendChild(scheduleCard);
                    console.log('✅ Schedule card added to calendar successfully');
                    
                                         // Store the schedule data in the cell for persistence
                     const scheduleId = 'new_' + Date.now();
                     cell.dataset.scheduleId = scheduleId;
                     cell.dataset.scheduleData = JSON.stringify({
                         title, type, duration, room, day, startTime,
                         source: 'new',
                         timestamp: Date.now()
                     });
                     
                     // Save to localStorage for persistence across page refreshes
                     // Use the day name (monday, tuesday, etc.) for proper restoration
                     saveScheduleToLocalStorage(scheduleId, {
                         title, type, duration, room, day: day, startTime,
                         source: 'new',
                         timestamp: Date.now()
                     });
                    
                    // Mark this cell as having a permanent schedule
                    cell.dataset.hasSchedule = 'true';
                    cell.dataset.scheduleTitle = title;
                    
                    // Add to global schedules array for permanent tracking
                    if (!window.permanentSchedules) {
                        window.permanentSchedules = [];
                    }
                    window.permanentSchedules.push({
                        id: scheduleId,
                        title: title,
                        type: type,
                        duration: duration,
                        room: room,
                        day: dayIndex,
                        startTime: startTime,
                        cell: cell,
                        element: scheduleCard
                    });
                    
                    console.log('💾 Schedule permanently stored with ID:', scheduleId);
                    console.log('📊 Total permanent schedules:', window.permanentSchedules.length);
                } else {
                    console.error('❌ Cell not found for day index:', dayIndex);
                }
            } else {
                console.error('❌ Time slot or day index not found:', { timeSlot: !!timeSlot, dayIndex });
                console.error('🔍 Available time slots:', document.querySelectorAll('[data-time]'));
                console.error('🔍 Available day cells:', document.querySelectorAll('[data-day]'));
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
                 'consultation': 'card-green',
                 'follow_up': 'card-blue',
                 'treatment': 'card-purple',
                 'lab_review': 'card-orange',
                 'surgery': 'card-red',
                 'rest_day': 'card-gray'
             };
            
            const colorClass = typeColors[type] || 'card-blue';
            card.classList.add(colorClass);
            console.log('Schedule card created:', { type, colorClass, availableTypes: Object.keys(typeColors) });
            
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
                 'consultation': '🏥',
                 'follow_up': '🔄',
                 'treatment': '💉',
                 'lab_review': '🔬',
                 'surgery': '🔪',
                 'rest_day': '😴'
             };
             return icons[type] || '📅';
         }

                         // Function to load existing schedules from database
        async function loadExistingSchedules() {
            try {
                console.log('🔄 Loading existing schedules...');
                
                // Check if we already have permanent schedules - if so, don't load from database
                if (window.permanentSchedules && window.permanentSchedules.length > 0) {
                    console.log('🛡️ Permanent schedules already exist, skipping database load to prevent overwriting');
                    console.log('📊 Current permanent schedules:', window.permanentSchedules.length);
                    return;
                }
                
                // Don't clear existing schedules - just load new ones from database
                // This prevents overwriting schedules that are already displayed
                
                const response = await fetch('<?= base_url('schedule/getWeeklySchedules') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const data = await response.json();
                console.log('📥 Response from server:', data);
                console.log('📊 Response details:', {
                    success: data.success,
                    schedulesCount: data.schedules ? data.schedules.length : 'undefined',
                    weekStart: data.week_start,
                    weekEnd: data.week_end
                });
                
                if (data.success && data.schedules && data.schedules.length > 0) {
                    console.log(`✅ Found ${data.schedules.length} schedules to display`);
                    
                    // Count how many schedules we actually add vs skip
                    let addedCount = 0;
                    let skippedCount = 0;
                    
                    data.schedules.forEach((schedule, index) => {
                        console.log(`📅 Processing schedule ${index + 1}:`, schedule);
                        
                        // Check if this schedule already exists
                        const timeDisplay = convertTo12Hour(schedule.start_time);
                        const dayColumn = getDayColumnFromDate(schedule.date);
                        const timeSlot = document.querySelector(`[data-time="${timeDisplay}"]`);
                        
                        if (timeSlot && dayColumn !== -1) {
                            const cell = timeSlot.parentElement.querySelector(`[data-day="${dayColumn}"]`);
                            if (cell) {
                                // Check if this exact schedule already exists
                                const existingCards = cell.querySelectorAll('.schedule-card');
                                let alreadyExists = false;
                                
                                existingCards.forEach(card => {
                                    const cardTitle = card.querySelector('.card-details')?.textContent;
                                    if (cardTitle === schedule.title) {
                                        alreadyExists = true;
                                    }
                                });
                                
                                if (alreadyExists) {
                                    console.log('⏭️ Schedule already exists, skipping:', schedule.title);
                                    skippedCount++;
                                    return;
                                }
                            }
                        }
                        
                        // Add the new schedule
                        addScheduleToCalendarFromData(schedule);
                        addedCount++;
                    });
                    
                    console.log(`📊 Schedule loading complete: ${addedCount} added, ${skippedCount} skipped`);
                } else {
                    console.log('❌ No schedules found or empty response');
                    if (data.schedules && data.schedules.length === 0) {
                        console.log('📭 Schedules array is empty');
                    }
                    if (!data.success) {
                        console.log('❌ Server returned success: false');
                    }
                }
            } catch (error) {
                console.error('💥 Error loading existing schedules:', error);
            }
        }

                // Function to add schedule from database data
        function addScheduleToCalendarFromData(schedule) {
            console.log('🎯 addScheduleToCalendarFromData called with:', schedule);
            
            const timeDisplay = convertTo12Hour(schedule.start_time);
            const timeSlot = document.querySelector(`[data-time="${timeDisplay}"]`);
            const dayColumn = getDayColumnFromDate(schedule.date);
            
            console.log('🔍 Schedule processing details:', {
                title: schedule.title,
                type: schedule.type,
                date: schedule.date,
                startTime: schedule.start_time,
                timeDisplay: timeDisplay,
                dayColumn: dayColumn,
                timeSlot: timeSlot ? 'Found' : 'Not found',
                timeSlotElement: timeSlot,
                schedule: schedule
            });
            
            if (!timeSlot) {
                console.error('❌ Time slot not found for:', timeDisplay);
                console.error('🔍 Available time slots:', document.querySelectorAll('[data-time]'));
                return;
            }
            
            if (dayColumn === -1) {
                console.error('❌ Invalid day column for date:', schedule.date);
                return;
            }
            
            console.log('🔍 Looking for cell with day:', dayColumn, 'in parent:', timeSlot.parentElement);
            const cell = timeSlot.parentElement.querySelector(`[data-day="${dayColumn}"]`);
            console.log('🔍 Found cell:', cell);
            
            if (cell) {
                // Check if this cell already has a permanent schedule - if so, don't overwrite
                if (cell.dataset.hasSchedule === 'true') {
                    console.log('🛡️ Cell already has permanent schedule, skipping database schedule:', schedule.title);
                    return;
                }
                
                // Check if there's already a schedule card in this cell with the same title
                const existingCard = cell.querySelector('.schedule-card');
                if (existingCard) {
                    const existingTitle = existingCard.querySelector('.card-details')?.textContent;
                    // Only skip if it's the exact same schedule (same title and type)
                    if (existingTitle === schedule.title) {
                        console.log('⚠️ Exact same schedule already exists, skipping:', existingTitle);
                        return;
                    }
                    // If different schedule, allow it (this handles overlapping schedules)
                    console.log('ℹ️ Different schedule in same cell, allowing overlap');
                }
                
                const scheduleCard = createScheduleCard(
                    schedule.title, 
                    schedule.type, 
                    getDurationFromTimes(schedule.start_time, schedule.end_time), 
                    schedule.room || 'N/A'
                );
                console.log('🎨 Created schedule card:', scheduleCard);
                
                // Add the new schedule card
                cell.appendChild(scheduleCard);
                console.log('✅ Schedule card added successfully to cell:', dayColumn, 'for', schedule.title);
                
                // Store the schedule data in the cell for persistence
                const scheduleId = 'db_' + schedule.id;
                cell.dataset.scheduleId = scheduleId;
                cell.dataset.scheduleData = JSON.stringify({
                    title: schedule.title,
                    type: schedule.type,
                    duration: getDurationFromTimes(schedule.start_time, schedule.end_time),
                    room: schedule.room || 'N/A',
                    day: dayColumn,
                    startTime: schedule.start_time,
                    source: 'database'
                });
                
                // Mark as permanent schedule
                cell.dataset.hasSchedule = 'true';
                cell.dataset.scheduleTitle = schedule.title;
                
                // Add to global permanent schedules array
                if (!window.permanentSchedules) {
                    window.permanentSchedules = [];
                }
                window.permanentSchedules.push({
                    id: scheduleId,
                    title: schedule.title,
                    type: schedule.type,
                    duration: getDurationFromTimes(schedule.start_time, schedule.end_time),
                    room: schedule.room || 'N/A',
                    day: dayColumn,
                    startTime: schedule.start_time,
                    cell: cell,
                    element: scheduleCard,
                    source: 'database'
                });
            } else {
                console.error('❌ Cell not found for day:', dayColumn, 'Time slot parent:', timeSlot.parentElement);
                console.error('🔍 Available cells in parent:', timeSlot.parentElement.querySelectorAll('[data-day]'));
            }
        }

        // Helper function to get day column from date
        function getDayColumnFromDate(dateString) {
            const date = new Date(dateString);
            const dayOfWeek = date.getDay();
            // JavaScript getDay(): 0=Sunday, 1=Monday, 2=Tuesday, etc.
            // Our grid: 0=Monday, 1=Tuesday, 2=Wednesday, etc.
            // So we need: Monday(1)->0, Tuesday(2)->1, Wednesday(3)->2, etc.
            return dayOfWeek === 0 ? 6 : dayOfWeek - 1;
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
        

        

        
        // Helper function to save schedule to localStorage
        function saveScheduleToLocalStorage(scheduleId, scheduleData) {
            try {
                const existingSchedules = JSON.parse(localStorage.getItem('tempSchedules') || '{}');
                existingSchedules[scheduleId] = scheduleData;
                localStorage.setItem('tempSchedules', JSON.stringify(existingSchedules));
                console.log('💾 Saved schedule to localStorage:', scheduleId, scheduleData);
            } catch (error) {
                console.error('❌ Error saving to localStorage:', error);
            }
        }
        
        // Helper function to restore temporary schedules from localStorage
        function restoreTemporarySchedules() {
            try {
                const tempSchedules = JSON.parse(localStorage.getItem('tempSchedules') || '{}');
                console.log('🔄 Restoring temporary schedules from localStorage:', tempSchedules);
                
                if (Object.keys(tempSchedules).length === 0) {
                    console.log('📭 No temporary schedules found in localStorage');
                    return;
                }
                
                let restoredCount = 0;
                
                Object.keys(tempSchedules).forEach(scheduleId => {
                    const scheduleData = tempSchedules[scheduleId];
                    console.log('🔄 Restoring schedule:', scheduleId, scheduleData);
                    
                    // Try to add the schedule back to the calendar
                    const day = scheduleData.day;
                    const startTime = scheduleData.startTime;
                    const title = scheduleData.title;
                    const type = scheduleData.type;
                    const duration = scheduleData.duration;
                    const room = scheduleData.room;
                    
                    // Convert 24-hour time to 12-hour display format
                    const timeDisplay = convertTo12Hour(startTime);
                    
                    // Find the exact time slot
                    const timeSlot = document.querySelector(`[data-time="${timeDisplay}"]`);
                    const dayIndex = getDayIndex(day);
                    
                    if (timeSlot && dayIndex !== -1) {
                        const cell = timeSlot.parentElement.querySelector(`[data-day="${dayIndex}"]`);
                        if (cell) {
                            // Clear the cell first to ensure clean restoration
                            cell.innerHTML = '';
                            
                            const scheduleCard = createScheduleCard(title, type, duration, room);
                            cell.appendChild(scheduleCard);
                            cell.dataset.scheduleId = scheduleId;
                            cell.dataset.scheduleData = JSON.stringify(scheduleData);
                            
                            // Mark as permanent schedule
                            cell.dataset.hasSchedule = 'true';
                            cell.dataset.scheduleTitle = title;
                            
                            // Add to global permanent schedules array
                            if (!window.permanentSchedules) {
                                window.permanentSchedules = [];
                            }
                            window.permanentSchedules.push({
                                id: scheduleId,
                                title: title,
                                type: type,
                                duration: duration,
                                room: room,
                                day: dayIndex,
                                startTime: startTime,
                                cell: cell,
                                element: scheduleCard
                            });
                            
                            restoredCount++;
                            console.log('✅ Restored schedule to calendar:', title);
                        } else {
                            console.error('❌ Cell not found for day index:', dayIndex);
                        }
                    } else {
                        console.error('❌ Time slot or day index not found:', { timeDisplay, dayIndex });
                    }
                });
                
                console.log(`✅ Successfully restored ${restoredCount} schedules from localStorage`);
                
                // If we restored schedules, mark them as loaded
                if (restoredCount > 0) {
                    window.schedulesLoaded = true;
                }
                
            } catch (error) {
                console.error('❌ Error restoring from localStorage:', error);
            }
        }
        
        // Function to clear temporary schedules (call this when schedules are successfully saved to database)
        function clearTemporarySchedules() {
            try {
                localStorage.removeItem('tempSchedules');
                console.log('🧹 Cleared temporary schedules from localStorage');
            } catch (error) {
                console.error('❌ Error clearing localStorage:', error);
            }
        }
        
        // Test function to debug patient loading
        async function testPatientLoading() {
            alert('🧪 Testing patient loading...');
            console.log('🧪 Testing patient loading...');
            
            // Clear the dropdown first
            const patientSelect = document.getElementById('patient-activity');
            patientSelect.innerHTML = '<option value="">Loading...</option>';
            
            // Try to load patients
            await loadPatients();
            
            // Show current state
            console.log('🧪 Current dropdown options:');
            Array.from(patientSelect.options).forEach((option, index) => {
                console.log(`  ${index}: ${option.value} (${option.textContent})`);
            });
        }
        
        // Function to refresh patients (called by refresh button)
        async function refreshPatients() {
            console.log('🔄 Refresh button clicked!');
            alert('🔄 Refreshing patients...');
            
            try {
                // Set force reload flag
                window.forcePatientReload = true;
                
                // Clear the dropdown first
                const patientSelect = document.getElementById('patient-activity');
                patientSelect.innerHTML = '<option value="">Loading patients...</option>';
                
                // Force reload patients
                await loadPatients();
                
                // Reset the force reload flag
                window.forcePatientReload = false;
                
                console.log('✅ Patients refreshed successfully');
                alert('✅ Patients refreshed! Check the dropdown.');
                
            } catch (error) {
                console.error('❌ Error refreshing patients:', error);
                alert('❌ Error refreshing patients: ' + error.message);
                // Reset the force reload flag on error too
                window.forcePatientReload = false;
            }
        }
        
        // Start periodic sync to remove deleted schedules from database
        function startPeriodicSync() {
            console.log('🔄 Starting periodic sync with database...');
            // Check every 30 seconds for deleted schedules
            setInterval(syncWithDatabase, 30000);
            
            // Also start protection for existing schedules
            setInterval(protectExistingSchedules, 5000);
        }
        
        // Function to protect existing schedules from being overwritten
        function protectExistingSchedules() {
            // Check global permanent schedules array first
            if (window.permanentSchedules && window.permanentSchedules.length > 0) {
                console.log('🛡️ Checking', window.permanentSchedules.length, 'permanent schedules...');
                
                window.permanentSchedules.forEach(schedule => {
                    const cell = schedule.cell;
                    if (cell && !cell.querySelector('.schedule-card')) {
                        console.log('🚨 Schedule card missing for:', schedule.title, '- Restoring immediately!');
                        
                        // Recreate and add the schedule card
                        const restoredCard = createScheduleCard(
                            schedule.title,
                            schedule.type,
                            schedule.duration,
                            schedule.room
                        );
                        
                        // Clear cell and add restored card
                        cell.innerHTML = '';
                        cell.appendChild(restoredCard);
                        
                        // Update the element reference
                        schedule.element = restoredCard;
                        
                        console.log('✅ Schedule card restored for:', schedule.title);
                    }
                });
            }
            
            // Also check cells with data attributes as backup
            const cellsWithSchedules = document.querySelectorAll('[data-has-schedule="true"]');
            cellsWithSchedules.forEach(cell => {
                // Check if the schedule card is still there
                const scheduleCard = cell.querySelector('.schedule-card');
                if (!scheduleCard && cell.dataset.scheduleData) {
                    console.log('🛡️ Restoring missing schedule card for:', cell.dataset.scheduleTitle);
                    
                    try {
                        const scheduleData = JSON.parse(cell.dataset.scheduleData);
                        const restoredCard = createScheduleCard(
                            scheduleData.title,
                            scheduleData.type,
                            scheduleData.duration,
                            scheduleData.room
                        );
                        cell.appendChild(restoredCard);
                        console.log('✅ Schedule card restored');
                    } catch (error) {
                        console.error('❌ Error restoring schedule card:', error);
                    }
                }
            });
        }
        
        // Sync calendar with database and remove deleted schedules
        async function syncWithDatabase() {
            try {
                console.log('🔄 Syncing calendar with database...');
                
                // First, delete all schedules from database
                const deleteResponse = await fetch('<?= base_url('schedule/deleteAllSchedules') ?>', {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                
                if (!deleteResponse.ok) {
                    throw new Error(`HTTP error! status: ${deleteResponse.status}`);
                }
                
                const deleteData = await deleteResponse.json();
                console.log('🗑️ Delete response:', deleteData);
                
                if (deleteData.success) {
                    // Clear all schedules from the calendar
                    const allCells = document.querySelectorAll('[data-day]');
                    allCells.forEach(cell => {
                        if (cell.querySelector('.schedule-card')) {
                            console.log('🗑️ Clearing schedule from calendar:', cell.querySelector('.card-details')?.textContent);
                            cell.innerHTML = '';
                            // Remove schedule data attributes
                            delete cell.dataset.scheduleId;
                            delete cell.dataset.scheduleData;
                            delete cell.dataset.hasSchedule;
                            delete cell.dataset.scheduleTitle;
                        }
                    });
                    
                    // Clear localStorage
                    localStorage.removeItem('tempSchedules');
                    
                    // Clear global schedules array
                    if (window.permanentSchedules) {
                        window.permanentSchedules = [];
                    }
                    
                    console.log('✅ All schedules deleted from database and calendar cleared');
                    alert(`✅ Successfully deleted ${deleteData.deleted_count || 0} schedules from database and cleared calendar!`);
                } else {
                    console.error('❌ Failed to delete schedules:', deleteData.error);
                    alert('❌ Failed to delete schedules: ' + (deleteData.error || 'Unknown error'));
                }
                
            } catch (error) {
                console.error('💥 Error syncing with database:', error);
                alert('💥 Error: ' + error.message);
            }
        }
        
        // Get all schedules currently displayed on the calendar
        function getAllDisplayedSchedules() {
            const scheduleCards = document.querySelectorAll('.schedule-card');
            const schedules = [];
            
            scheduleCards.forEach(card => {
                const cell = card.closest('[data-day]');
                const timeSlot = cell.closest('.schedule-row').querySelector('.time-slot');
                
                if (cell && timeSlot) {
                    schedules.push({
                        element: card,
                        cell: cell,
                        day: cell.dataset.day,
                        time: timeSlot.dataset.time,
                        title: card.querySelector('.card-details')?.textContent || '',
                        type: card.querySelector('.card-title')?.textContent || ''
                    });
                }
            });
            
            return schedules;
        }
        
        // Remove schedules that are no longer in the database
        function removeDeletedSchedules(displayedSchedules, databaseSchedules) {
            displayedSchedules.forEach(displayedSchedule => {
                const isStillInDatabase = databaseSchedules.some(dbSchedule => {
                    // Check if this displayed schedule matches any database schedule
                    const dbTimeDisplay = convertTo12Hour(dbSchedule.start_time);
                    const dbDayColumn = getDayColumnFromDate(dbSchedule.date);
                    
                    return dbTimeDisplay === displayedSchedule.time && 
                           dbDayColumn.toString() === displayedSchedule.day &&
                           dbSchedule.title === displayedSchedule.title &&
                           dbSchedule.type.toLowerCase().replace(' ', '_') === displayedSchedule.type.toLowerCase().replace(' ', '_');
                });
                
                if (!isStillInDatabase) {
                    console.log('🗑️ Removing deleted schedule:', displayedSchedule.title);
                    displayedSchedule.cell.innerHTML = '';
                    // Also remove from localStorage if it was there
                    if (displayedSchedule.cell.dataset.scheduleId) {
                        removeScheduleFromLocalStorage(displayedSchedule.cell.dataset.scheduleId);
                    }
                }
            });
        }
        
        // Remove schedule from localStorage
        function removeScheduleFromLocalStorage(scheduleId) {
            try {
                const existingSchedules = JSON.parse(localStorage.getItem('tempSchedules') || '{}');
                delete existingSchedules[scheduleId];
                localStorage.setItem('tempSchedules', JSON.stringify(existingSchedules));
                console.log('🗑️ Removed schedule from localStorage:', scheduleId);
            } catch (error) {
                console.error('❌ Error removing from localStorage:', error);
            }
        }
        

        
        // Save all current schedules to localStorage before page unload
        window.addEventListener('beforeunload', function() {
            console.log('💾 Page unloading - saving all current schedules to localStorage...');
            
            // Get all currently displayed schedules and save them
            const currentSchedules = getAllDisplayedSchedules();
            const schedulesToSave = {};
            
            currentSchedules.forEach(schedule => {
                const cell = schedule.cell;
                if (cell && cell.dataset.scheduleData) {
                    try {
                        const scheduleData = JSON.parse(cell.dataset.scheduleData);
                        const scheduleId = cell.dataset.scheduleId || 'temp_' + Date.now();
                        schedulesToSave[scheduleId] = scheduleData;
                    } catch (error) {
                        console.error('❌ Error parsing schedule data:', error);
                    }
                }
            });
            
            if (Object.keys(schedulesToSave).length > 0) {
                localStorage.setItem('tempSchedules', JSON.stringify(schedulesToSave));
                console.log('💾 Saved', Object.keys(schedulesToSave).length, 'schedules before page unload');
            }
        });
    </script>
</body>
</html>
