<?php echo view('auth/partials/header', ['title' => 'Unified Scheduling - Doctor']); ?>

<style>
.unified-scheduling {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
}

.header {
    background: white;
    padding: 20px 30px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.header h1 {
    font-size: 24px;
    color: #0f172a;
    font-weight: 600;
}

.header-actions {
    display: flex;
    gap: 12px;
}

.btn {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #2563eb;
    color: white;
}

.btn-primary:hover {
    background: #1d4ed8;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.page-content {
    padding: 30px;
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    margin-bottom: 30px;
}

.panel {
    background: white;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    overflow: hidden;
}

.panel-header {
    padding: 20px;
    border-bottom: 1px solid #ecf0f1;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.panel-title {
    font-size: 18px;
    font-weight: 600;
    color: #0f172a;
}

.panel-controls {
    display: flex;
    align-items: center;
    gap: 12px;
}

.date-selector {
    padding: 8px 12px;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 14px;
    outline: none;
}

.view-toggle {
    display: flex;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    overflow: hidden;
}

.view-btn {
    padding: 8px 16px;
    border: none;
    background: white;
    color: #64748b;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.view-btn.active {
    background: #2563eb;
    color: white;
}

.view-btn:not(.active):hover {
    background: #f8fafc;
}

.schedule-grid {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.grid-header {
    display: grid;
    grid-template-columns: 120px repeat(7, 1fr);
    background: #f8fafc;
    border-bottom: 1px solid #e2e8f0;
}

.grid-header-cell {
    padding: 16px 12px;
    text-align: center;
    font-weight: 600;
    color: #374151;
    font-size: 14px;
    border-right: 1px solid #e2e8f0;
}

.grid-header-cell:first-child {
    text-align: left;
    padding-left: 24px;
}

.grid-header-cell:last-child {
    border-right: none;
}

.grid-body {
    display: flex;
    flex-direction: column;
}

.time-slot {
    padding: 12px 24px;
    border-right: 1px solid #e2e8f0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
    color: #64748b;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.schedule-cell {
    border-right: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    padding: 4px;
    position: relative;
    min-height: 60px;
}

.schedule-cell:last-child {
    border-right: none;
}

.schedule-card {
    background: #fff;
    border-radius: 8px;
    padding: 8px 10px;
    margin: 2px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    border-left: 4px solid;
    font-size: 12px;
    line-height: 1.3;
    cursor: pointer;
    transition: all 0.2s;
    position: relative;
    overflow: hidden;
    min-height: 60px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.schedule-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.card-blue { background: #eff6ff; border-left-color: #3b82f6; color: #1e40af; }
.card-purple { background: #f3e8ff; border-left-color: #8b5cf6; color: #6b21a8; }
.card-red { background: #fef2f2; border-left-color: #ef4444; color: #b91c1c; }
.card-green { background: #f0fdf4; border-left-color: #10b981; color: #047857; }
.card-orange { background: #fff7ed; border-left-color: #f59e0b; color: #b45309; }
.card-gray { background: #f8fafc; border-left-color: #64748b; color: #475569; }

.card-title {
    font-weight: 600;
    margin-bottom: 2px;
    text-transform: capitalize;
}

.card-details {
    font-size: 11px;
    opacity: 0.9;
}

.card-duration {
    font-size: 10px;
    opacity: 0.8;
    margin-top: 2px;
}

.card-location {
    font-size: 10px;
    opacity: 0.8;
    margin-top: 1px;
}

.card-icon {
    position: absolute;
    top: 6px;
    right: 8px;
    font-size: 14px;
    opacity: 0.7;
}

.legend {
    display: flex;
    align-items: center;
    gap: 24px;
    margin-top: 24px;
    padding: 20px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #64748b;
}

.legend-color {
    width: 16px;
    height: 16px;
    border-radius: 4px;
    border-left: 3px solid;
}

.legend-color.blue { background: #eff6ff; border-left-color: #3b82f6; }
.legend-color.purple { background: #f3e8ff; border-left-color: #8b5cf6; }
.legend-color.red { background: #fef2f2; border-left-color: #ef4444; }
.legend-color.green { background: #f0fdf4; border-left-color: #10b981; }
.legend-color.orange { background: #fff7ed; border-left-color: #f59e0b; }
.legend-color.gray { background: #f8fafc; border-left-color: #64748b; }

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 24px;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    position: relative;
    overflow: hidden;
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: #2563eb;
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.stat-title {
    color: #64748b;
    font-size: 14px;
    font-weight: 500;
}

.stat-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
}

.stat-icon.appointments { background: #2563eb; }
.stat-icon.confirmed { background: #22c55e; }
.stat-icon.pending { background: #f59e0b; }
.stat-icon.completed { background: #10b981; }

.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #0f172a;
}

/* Modal Styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    overflow-y: auto;
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 0;
    border-radius: 16px;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.modal-header {
    padding: 24px 24px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    font-size: 20px;
    font-weight: 600;
    color: #1f2937;
    margin: 0;
}

.close {
    color: #64748b;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
    line-height: 1;
    transition: color 0.2s;
}

.close:hover {
    color: #1f2937;
}

.modal-body {
    padding: 24px;
}

.modal-footer {
    padding: 20px 24px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    background: #f8fafc;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #374151;
    font-size: 14px;
}

.form-group input, .form-group select, .form-group textarea {
    width: 100%;
    padding: 12px;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    transition: all 0.2s;
}

.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

.color-picker {
    display: flex;
    gap: 8px;
    margin-top: 8px;
}

.color-option {
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.2s;
}

.color-option.selected {
    border-color: #374151;
    transform: scale(1.1);
}

.alert {
    padding: 16px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: none;
    font-weight: 500;
}

.alert-success {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}

.alert-error {
    background: #fef2f2;
    color: #991b1b;
    border: 1px solid #fecaca;
}

/* Responsive Design */
@media (max-width: 768px) {
    .content-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .stats-grid {
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    }

    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="container">
    <?php echo view('auth/partials/doctor_sidebar'); ?>
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div>
                <h1>My Schedule</h1>
                <div style="color: #64748b; font-size: 14px; margin-top: 4px;">Manage your appointments and availability</div>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary" onclick="loadTodaysAppointments()">📅 Today</button>
                <button class="btn btn-secondary" onclick="forceRefresh()">🔄 Refresh</button>
                <button class="btn btn-secondary" onclick="checkForUpdates()">🔍 Check Updates</button>
                <button class="btn btn-primary" onclick="openAddAppointmentModal()">➕ Add Appointment</button>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <!-- Summary Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Today's Appointments</span>
                        <div class="stat-icon appointments">📅</div>
                    </div>
                    <div class="stat-value"><?= $stats['total'] ?? 0 ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Confirmed</span>
                        <div class="stat-icon confirmed">✅</div>
                    </div>
                    <div class="stat-value"><?= $stats['confirmed'] ?? 0 ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Pending</span>
                        <div class="stat-icon pending">⏰</div>
                    </div>
                    <div class="stat-value"><?= $stats['pending'] ?? 0 ?></div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <span class="stat-title">Completed</span>
                        <div class="stat-icon completed">✅</div>
                    </div>
                    <div class="stat-value"><?= $stats['completed'] ?? 0 ?></div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="content-grid">
                <!-- Weekly Schedule Panel -->
                <div class="panel" style="grid-column: 1 / -1;">
                    <div class="panel-header">
                        <h2 class="panel-title">Weekly Schedule</h2>
                        <div class="panel-controls">
                            <input type="date" class="date-selector" id="scheduleDate" value="<?= $selected_date ?? date('Y-m-d') ?>">
                            <div class="view-toggle">
                                <button class="view-btn active" data-view="week">Week</button>
                                <button class="view-btn" data-view="day">Day</button>
                            </div>
                        </div>
                    </div>
                    
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
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Add/Edit Appointment Modal -->
<div id="appointmentModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">Add Appointment</h3>
            <span class="close" onclick="closeModal()">&times;</span>
        </div>
        <div class="modal-body">
            <div class="alert alert-success" id="success-alert"></div>
            <div class="alert alert-error" id="error-alert"></div>
            
            <form id="appointmentForm">
                <input type="hidden" id="appointmentId" name="appointment_id">
                <input type="hidden" id="doctor_id" name="doctor_id" value="<?= session('user_id') ?>">
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="patient_id">Patient *</label>
                        <select id="patient_id" name="patient_id" required>
                            <option value="">Select Patient</option>
                            <?php foreach ($patients as $patient): ?>
                                <option value="<?= $patient['id'] ?>"><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="appointment_date">Date *</label>
                        <input type="date" id="appointment_date" name="date" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="start_time">Start Time *</label>
                        <input type="time" id="start_time" name="start_time" required>
                    </div>
                    <div class="form-group">
                        <label for="duration">Duration (minutes) *</label>
                        <select id="duration" name="duration" required>
                            <option value="30">30 minutes</option>
                            <option value="60" selected>1 hour</option>
                            <option value="90">1.5 hours</option>
                            <option value="120">2 hours</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="type">Activity Type *</label>
                        <select id="type" name="type" required>
                            <option value="">Select Type</option>
                            <option value="consultation">Consultation</option>
                            <option value="follow_up">Follow-up</option>
                            <option value="treatment">Treatment / Procedure</option>
                            <option value="lab_review">Laboratory Request / Result Review</option>
                            <option value="surgery">Surgery / Operation</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="room">Room *</label>
                        <select id="room" name="room" required>
                            <option value="">Select Room</option>
                            <?php foreach ($rooms as $room): ?>
                                <option value="<?= esc($room['room_name']) ?>"><?= esc($room['room_name']) ?> (<?= esc($room['room_type']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="color_label">Color Label</label>
                    <div class="color-picker">
                        <div class="color-option selected" data-color="#3b82f6" style="background: #3b82f6;"></div>
                        <div class="color-option" data-color="#ef4444" style="background: #ef4444;"></div>
                        <div class="color-option" data-color="#22c55e" style="background: #22c55e;"></div>
                        <div class="color-option" data-color="#8b5cf6" style="background: #8b5cf6;"></div>
                        <div class="color-option" data-color="#f59e0b" style="background: #f59e0b;"></div>
                        <div class="color-option" data-color="#6b7280" style="background: #6b7280;"></div>
                    </div>
                    <input type="hidden" id="color_label" name="color_label" value="#3b82f6">
                </div>
                
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea id="notes" name="notes" rows="3" placeholder="Additional notes or details"></textarea>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button class="btn btn-secondary" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary" onclick="saveAppointment()">Save Appointment</button>
        </div>
    </div>
</div>

<script>
let currentAppointmentId = null;
let currentWeekStart = '<?= $week_start ?? date('Y-m-d', strtotime('monday this week')) ?>';
let currentWeekEnd = '<?= $week_end ?? date('Y-m-d', strtotime('sunday this week')) ?>';

// Calculate current week dates
function getCurrentWeekDates() {
    // Use server's week dates to ensure consistency with Philippine timezone
    return {
        start: '<?= date('Y-m-d', strtotime('monday this week')) ?>',
        end: '<?= date('Y-m-d', strtotime('sunday this week')) ?>'
    };
}

// Update week dates
const weekDates = getCurrentWeekDates();
currentWeekStart = weekDates.start;
currentWeekEnd = weekDates.end;

console.log('Current week:', currentWeekStart, 'to', currentWeekEnd);

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Set default date to today
    document.getElementById('appointment_date').value = '<?= date('Y-m-d') ?>';
    
    // Set default time to next hour
    const nextHour = new Date();
    nextHour.setHours(nextHour.getHours() + 1, 0, 0, 0);
    document.getElementById('start_time').value = nextHour.toTimeString().slice(0, 5);
    
    // Color picker functionality
    document.querySelectorAll('.color-option').forEach(option => {
        option.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            document.getElementById('color_label').value = this.dataset.color;
        });
    });
    
    // Date selector functionality
    document.getElementById('scheduleDate').addEventListener('change', function() {
        console.log('Date changed to:', this.value);
        // Update week dates based on selected date
        const selectedDate = new Date(this.value + 'T00:00:00'); // Force local timezone
        const dayOfWeek = selectedDate.getDay();
        const mondayOffset = dayOfWeek === 0 ? -6 : 1 - dayOfWeek;
        
        const monday = new Date(selectedDate);
        monday.setDate(selectedDate.getDate() + mondayOffset);
        
        const sunday = new Date(monday);
        sunday.setDate(monday.getDate() + 6);
        
        currentWeekStart = monday.toISOString().split('T')[0];
        currentWeekEnd = sunday.toISOString().split('T')[0];
        
        console.log('Updated week dates:', currentWeekStart, 'to', currentWeekEnd);
        loadAppointmentsForWeek();
    });
    
    // View toggle functionality
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.dataset.view;
            if (view === 'day') {
                // Switch to day view
                console.log('Switching to day view');
            }
        });
    });
    
    // Generate time slots and load appointments
    generateTimeSlots();
    loadAppointmentsForWeek();
    
    // Also load today's appointments to make sure we see any new ones
    loadTodaysAppointments();
    
    // Request notification permission
    if ('Notification' in window && Notification.permission === 'default') {
        Notification.requestPermission();
    }
});

// Generate time slots for the weekly calendar
function generateTimeSlots() {
    const gridBody = document.getElementById('schedule-grid-body');
    gridBody.innerHTML = '';
    
    const timeSlots = [
        '8:00 AM', '8:30 AM', '9:00 AM', '9:30 AM', '10:00 AM', '10:30 AM', '11:00 AM', '11:30 AM',
        '12:00 PM', '12:30 PM', '1:00 PM', '1:30 PM', '2:00 PM', '2:30 PM', '3:00 PM', '3:30 PM',
        '4:00 PM', '4:30 PM', '5:00 PM'
    ];
    
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

// Load appointments for the current week
async function loadAppointmentsForWeek() {
    try {
        const url = `<?= site_url('unified-scheduling/getAppointments') ?>?doctor_id=<?= session('user_id') ?>&start_date=${currentWeekStart}&end_date=${currentWeekEnd}`;
        console.log('Loading appointments for doctor with URL:', url);
        
        const response = await fetch(url);
        const data = await response.json();
        
        console.log('Doctor appointments response:', data);
        
        if (data.success) {
            displayAppointmentsOnCalendar(data.appointments);
        } else {
            console.error('Failed to load doctor appointments:', data.message);
        }
    } catch (error) {
        console.error('Error loading appointments:', error);
    }
}

// Display appointments on the calendar
function displayAppointmentsOnCalendar(appointments) {
    console.log('Displaying appointments on calendar:', appointments);
    
    // Clear existing appointments
    document.querySelectorAll('.schedule-card').forEach(card => card.remove());
    
    if (appointments.length === 0) {
        console.log('No appointments to display');
        return;
    }
    
    appointments.forEach(appointment => {
        console.log('Processing appointment:', appointment);
        
        const appointmentTime = new Date(appointment.date_time);
        const timeDisplay = convertTo12Hour(appointmentTime.toTimeString().slice(0, 5));
        const dayColumn = getDayColumnFromDate(appointmentTime.toISOString().slice(0, 10));
        
        console.log('Appointment time:', appointmentTime, 'Time display:', timeDisplay, 'Day column:', dayColumn);
        
        const timeSlot = document.querySelector(`[data-time="${timeDisplay}"]`);
        if (timeSlot && dayColumn !== -1) {
            const cell = timeSlot.parentElement.querySelector(`[data-day="${dayColumn}"]`);
            if (cell) {
                const scheduleCard = createScheduleCard(appointment);
                cell.appendChild(scheduleCard);
                console.log('Added appointment card to calendar');
            } else {
                console.log('Cell not found for day column:', dayColumn);
            }
        } else {
            console.log('Time slot not found for:', timeDisplay, 'or invalid day column:', dayColumn);
        }
    });
}

// Create schedule card element
function createScheduleCard(appointment) {
    const card = document.createElement('div');
    card.className = 'schedule-card';
    
    // Set color based on appointment type
    const typeColors = {
        'consultation': 'card-green',
        'follow_up': 'card-blue',
        'treatment': 'card-purple',
        'lab_review': 'card-orange',
        'surgery': 'card-red'
    };
    
    const colorClass = typeColors[appointment.type] || 'card-blue';
    card.classList.add(colorClass);
    
    // Calculate duration text
    const duration = appointment.duration || 60;
    let durationText = '';
    if (duration === 30) durationText = '30 min';
    else if (duration === 60) durationText = '1 hour';
    else if (duration === 90) durationText = '1.5 hours';
    else if (duration === 120) durationText = '2 hours';
    else durationText = `${duration} min`;
    
    card.innerHTML = `
        <div class="card-title">${appointment.type.charAt(0).toUpperCase() + appointment.type.slice(1).replace('_', ' ')}</div>
        <div class="card-details">${appointment.patient_name}</div>
        <div class="card-duration">${durationText}</div>
        <div class="card-location">${appointment.room || 'No Room'}</div>
        <div class="card-icon">${getIconForType(appointment.type)}</div>
    `;
    
    // Add click handler for editing
    card.addEventListener('click', function() {
        editAppointment(appointment.id);
    });
    
    return card;
}

// Get icon for appointment type
function getIconForType(type) {
    const icons = {
        'consultation': '🏥',
        'follow_up': '🔄',
        'treatment': '💉',
        'lab_review': '🔬',
        'surgery': '🔪'
    };
    return icons[type] || '📅';
}

// Convert 24-hour time to 12-hour format
function convertTo12Hour(time24) {
    const [hours, minutes] = time24.split(':');
    const hour = parseInt(hours);
    const ampm = hour >= 12 ? 'PM' : 'AM';
    const displayHour = hour === 0 ? 12 : hour > 12 ? hour - 12 : hour;
    return `${displayHour}:${minutes} ${ampm}`;
}

// Get day column from date
function getDayColumnFromDate(dateString) {
    const date = new Date(dateString);
    const dayOfWeek = date.getDay();
    // JavaScript getDay(): 0=Sunday, 1=Monday, 2=Tuesday, etc.
    // Our grid: 0=Monday, 1=Tuesday, 2=Wednesday, etc.
    // So we need: Monday(1)->0, Tuesday(2)->1, Wednesday(3)->2, etc.
    return dayOfWeek === 0 ? 6 : dayOfWeek - 1;
}

// Open add appointment modal
function openAddAppointmentModal() {
    currentAppointmentId = null;
    document.getElementById('modalTitle').textContent = 'Add Appointment';
    document.getElementById('appointmentForm').reset();
    document.getElementById('appointment_date').value = '<?= date('Y-m-d') ?>';
    
    // Set default time to next hour
    const nextHour = new Date();
    nextHour.setHours(nextHour.getHours() + 1, 0, 0, 0);
    document.getElementById('start_time').value = nextHour.toTimeString().slice(0, 5);
    
    // Reset color picker
    document.querySelectorAll('.color-option').forEach(opt => opt.classList.remove('selected'));
    document.querySelector('.color-option[data-color="#3b82f6"]').classList.add('selected');
    document.getElementById('color_label').value = '#3b82f6';
    
    document.getElementById('appointmentModal').style.display = 'block';
}

// Edit appointment
function editAppointment(appointmentId) {
    currentAppointmentId = appointmentId;
    document.getElementById('modalTitle').textContent = 'Edit Appointment';
    
    // For now, just open the modal - in a real app, you'd fetch the appointment data
    document.getElementById('appointmentModal').style.display = 'block';
}

// Save appointment
async function saveAppointment() {
    const form = document.getElementById('appointmentForm');
    const formData = new FormData(form);
    
    // Validate required fields
    const requiredFields = ['patient_id', 'date', 'start_time', 'duration', 'type', 'room'];
    for (const field of requiredFields) {
        if (!formData.get(field)) {
            showError(`Please fill in the ${field.replace('_', ' ')} field`);
            return;
        }
    }
    
    try {
        const url = currentAppointmentId 
            ? `<?= site_url('unified-scheduling/updateAppointment') ?>/${currentAppointmentId}`
            : `<?= site_url('unified-scheduling/createAppointment') ?>`;
        
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        });
        
        const data = await response.json();
        
        if (data.success) {
            showSuccess(currentAppointmentId ? 'Appointment updated successfully' : 'Appointment created successfully');
            closeModal();
            refreshData();
            
            // Force refresh the calendar to show the new appointment
            console.log('Appointment saved, refreshing calendar...');
            loadAppointmentsForWeek();
            loadTodaysAppointments();
        } else {
            showError(data.message || 'Failed to save appointment');
        }
    } catch (error) {
        console.error('Error saving appointment:', error);
        showError('Error saving appointment');
    }
}

// Close modal
function closeModal() {
    document.getElementById('appointmentModal').style.display = 'none';
    hideAlerts();
}

// Refresh data
function refreshData() {
    loadAppointmentsForWeek();
}

// Show success message
function showSuccess(message) {
    const alert = document.getElementById('success-alert');
    alert.textContent = message;
    alert.style.display = 'block';
    setTimeout(() => alert.style.display = 'none', 3000);
    
    // Also show a browser notification if supported
    if ('Notification' in window && Notification.permission === 'granted') {
        new Notification('Appointment Update', {
            body: message,
            icon: '/favicon.ico'
        });
    }
}

// Show error message
function showError(message) {
    const alert = document.getElementById('error-alert');
    alert.textContent = message;
    alert.style.display = 'block';
    setTimeout(() => alert.style.display = 'none', 5000);
}

// Hide alerts
function hideAlerts() {
    document.getElementById('success-alert').style.display = 'none';
    document.getElementById('error-alert').style.display = 'none';
}

// Close modal when clicking outside
window.onclick = function(event) {
    const modal = document.getElementById('appointmentModal');
    if (event.target === modal) {
        closeModal();
    }
}

// Real-time updates functionality
let refreshInterval;

// Start real-time updates
function startRealTimeUpdates() {
    // Refresh every 10 seconds for better synchronization
    refreshInterval = setInterval(() => {
        refreshData();
    }, 10000);
}

// Stop real-time updates
function stopRealTimeUpdates() {
    if (refreshInterval) {
        clearInterval(refreshInterval);
    }
}

// Enhanced refresh function with real-time updates
async function refreshData() {
    try {
        // Refresh statistics
        const statsResponse = await fetch(`<?= site_url('unified-scheduling/getStatistics') ?>?doctor_id=<?= session('user_id') ?>&date=${document.getElementById('scheduleDate').value}`);
        const statsData = await statsResponse.json();
        
        if (statsData.success) {
            updateStatistics(statsData.statistics);
        }
        
        // Refresh appointments for current week
        loadAppointmentsForWeek();
        
    } catch (error) {
        console.error('Error refreshing data:', error);
    }
}

// Force refresh function for external updates
function forceRefresh() {
    console.log('Force refreshing doctor calendar...');
    refreshData();
}

// Check for updates from admin or other sources
async function checkForUpdates() {
    console.log('Checking for updates...');
    try {
        // Check today's appointments
        await loadTodaysAppointments();
        
        // Check weekly appointments
        await loadAppointmentsForWeek();
        
        // Refresh statistics
        const statsResponse = await fetch(`<?= site_url('unified-scheduling/getStatistics') ?>?doctor_id=<?= session('user_id') ?>&date=<?= date('Y-m-d') ?>`);
        const statsData = await statsResponse.json();
        
        if (statsData.success) {
            updateStatistics(statsData.statistics);
        }
        
        console.log('Update check completed');
    } catch (error) {
        console.error('Error checking for updates:', error);
    }
}

// Load appointments for today specifically
async function loadTodaysAppointments() {
    try {
        const today = '<?= date('Y-m-d') ?>';
        console.log('Loading today\'s appointments for doctor:', today);
        
        // Show loading indicator
        const refreshBtn = document.querySelector('button[onclick="loadTodaysAppointments()"]');
        if (refreshBtn) {
            refreshBtn.textContent = '⏳ Loading...';
            refreshBtn.disabled = true;
        }
        
        const response = await fetch(`<?= site_url('unified-scheduling/getAppointments') ?>?doctor_id=<?= session('user_id') ?>&date=${today}`);
        const data = await response.json();
        
        console.log('Today\'s appointments response:', data);
        
        if (data.success && data.appointments.length > 0) {
            console.log('Found appointments for today:', data.appointments);
            // Update the calendar to show today's appointments
            displayAppointmentsOnCalendar(data.appointments);
        } else {
            console.log('No appointments found for today');
        }
        
        // Reset button
        if (refreshBtn) {
            refreshBtn.textContent = '📅 Today';
            refreshBtn.disabled = false;
        }
    } catch (error) {
        console.error('Error loading today\'s appointments:', error);
        
        // Reset button on error
        const refreshBtn = document.querySelector('button[onclick="loadTodaysAppointments()"]');
        if (refreshBtn) {
            refreshBtn.textContent = '📅 Today';
            refreshBtn.disabled = false;
        }
    }
}

// Update statistics display
function updateStatistics(stats) {
    document.querySelector('.stat-card:nth-child(1) .stat-value').textContent = stats.total || 0;
    document.querySelector('.stat-card:nth-child(2) .stat-value').textContent = stats.confirmed || 0;
    document.querySelector('.stat-card:nth-child(3) .stat-value').textContent = stats.pending || 0;
    document.querySelector('.stat-card:nth-child(4) .stat-value').textContent = stats.completed || 0;
}

// Initialize real-time updates when page loads
document.addEventListener('DOMContentLoaded', function() {
    startRealTimeUpdates();
    
    // Stop updates when page is hidden
    document.addEventListener('visibilitychange', function() {
        if (document.hidden) {
            stopRealTimeUpdates();
        } else {
            startRealTimeUpdates();
        }
    });
});

// Clean up when page unloads
window.addEventListener('beforeunload', function() {
    stopRealTimeUpdates();
});
</script>

<?php echo view('auth/partials/footer'); ?>
