<?php echo view('auth/partials/header', ['title' => 'Unified Scheduling - Admin']); ?>

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

.appointment-list {
    max-height: 500px;
    overflow-y: auto;
}

.appointment-item {
    padding: 16px 20px;
    border-bottom: 1px solid #ecf0f1;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: background-color 0.3s ease;
}

.appointment-item:hover {
    background-color: #f8fafc;
}

.appointment-item:last-child {
    border-bottom: none;
}

.appointment-time {
    width: 60px;
    font-weight: 600;
    color: #2563eb;
    font-size: 14px;
}

.appointment-details {
    flex: 1;
}

.patient-name {
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 4px;
}

.doctor-info {
    font-size: 14px;
    color: #64748b;
}

.appointment-status {
    margin-right: 16px;
}

.status-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.confirmed { background: #ecfdf5; color: #16a34a; }
.status-badge.pending { background: #fef3c7; color: #d97706; }
.status-badge.completed { background: #dbeafe; color: #2563eb; }
.status-badge.cancelled { background: #fef2f2; color: #dc2626; }

.appointment-actions {
    display: flex;
    gap: 8px;
}

.action-btn {
    padding: 6px;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    cursor: pointer;
}

.action-btn:hover {
    background-color: #f1f5f9;
}

.doctor-list {
    max-height: 500px;
    overflow-y: auto;
}

.doctor-item {
    padding: 16px 20px;
    border-bottom: 1px solid #ecf0f1;
    display: flex;
    align-items: center;
    gap: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.doctor-item:hover {
    background-color: #f8fafc;
}

.doctor-item.selected {
    background-color: #eef2ff;
    border-left: 4px solid #2563eb;
}

.doctor-item:last-child {
    border-bottom: none;
}

.doctor-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #eef2ff;
    display: grid;
    place-items: center;
    color: #2563eb;
    font-weight: 800;
    font-size: 16px;
}

.doctor-info {
    flex: 1;
}

.doctor-name {
    font-weight: 600;
    color: #0f172a;
    margin-bottom: 4px;
}

.doctor-specialty {
    font-size: 14px;
    color: #64748b;
    margin-bottom: 4px;
}

.appointment-count {
    font-size: 12px;
    color: #64748b;
}

.availability-badge {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 600;
    margin-left: auto;
}

.availability-available { background: #ecfdf5; color: #16a34a; }
.availability-busy { background: #fef3c7; color: #d97706; }

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
.stat-icon.doctors { background: #22c55e; }
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

.no-appointments, .no-doctors {
    text-align: center;
    padding: 40px 20px;
    color: #94a3b8;
}

.no-appointments-icon, .no-doctors-icon {
    font-size: 48px;
    margin-bottom: 16px;
}

.no-appointments-text, .no-doctors-text {
    font-weight: 600;
    color: #64748b;
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
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <!-- Header -->
        <header class="header">
            <div>
                <h1>Unified Scheduling - Admin</h1>
                <div style="color: #64748b; font-size: 14px; margin-top: 4px;">Manage all doctor schedules and appointments</div>
            </div>
            <div class="header-actions">
                <button class="btn btn-secondary" onclick="refreshData()">🔄 Refresh</button>
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
                        <div class="stat-icon completed">✅</div>
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
                <!-- Today's Schedule Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Today's Schedule</h2>
                        <div class="panel-controls">
                            <input type="date" class="date-selector" id="scheduleDate" value="<?= $selected_date ?? date('Y-m-d') ?>">
                            <div class="view-toggle">
                                <button class="view-btn active" data-view="day">Day</button>
                                <button class="view-btn" data-view="week">Week</button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="appointment-list" id="todays-appointments">
                        <?php if (!empty($today_appointments)): ?>
                            <?php foreach ($today_appointments as $appointment): ?>
                                <?php 
                                    $appointmentTime = new DateTime($appointment['date_time']);
                                    $statusClass = strtolower($appointment['status']);
                                ?>
                                <div class="appointment-item" data-appointment-id="<?= $appointment['id'] ?>">
                                    <div class="appointment-time"><?= $appointmentTime->format('H:i') ?></div>
                                    <div class="appointment-details">
                                        <div class="patient-name"><?= esc($appointment['patient_name']) ?></div>
                                        <div class="doctor-info"><?= esc($appointment['doctor_name']) ?> • <?= esc($appointment['room'] ?? 'No Room') ?>, <?= esc($appointment['type']) ?></div>
                                    </div>
                                    <div class="appointment-status">
                                        <span class="status-badge <?= $statusClass ?>"><?= esc($appointment['status']) ?></span>
                                    </div>
                                    <div class="appointment-actions">
                                        <button class="action-btn edit" onclick="editAppointment(<?= $appointment['id'] ?>)" title="Edit">✏️</button>
                                        <button class="action-btn delete" onclick="deleteAppointment(<?= $appointment['id'] ?>)" title="Delete">🗑️</button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-appointments">
                                <div class="no-appointments-icon">📅</div>
                                <div class="no-appointments-text">No appointments scheduled for today</div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Doctor List Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <h2 class="panel-title">Doctors</h2>
                    </div>
                    
                    <div class="doctor-list" id="doctorList">
                        <?php if (!empty($doctors)): ?>
                            <?php foreach ($doctors as $doctor): ?>
                                <div class="doctor-item" data-doctor-id="<?= $doctor['id'] ?>" onclick="selectDoctor(<?= $doctor['id'] ?>)">
                                    <div class="doctor-avatar">
                                        <?= esc(strtoupper(substr($doctor['name'] ?? 'D', 0, 1))) ?>
                                    </div>
                                    <div class="doctor-info">
                                        <div class="doctor-name"><?= esc($doctor['name'] ?? 'Unknown Doctor') ?></div>
                                        <div class="doctor-specialty"><?= esc($doctor['specialty'] ?? 'General Medicine') ?></div>
                                        <div class="appointment-count">0 appointments today</div>
                                    </div>
                                    <span class="availability-badge availability-available">Available</span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-doctors">
                                <div class="no-doctors-icon">👥</div>
                                <div class="no-doctors-text">No doctors found</div>
                            </div>
                        <?php endif; ?>
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
                        <label for="doctor_id">Doctor *</label>
                        <select id="doctor_id" name="doctor_id" required>
                            <option value="">Select Doctor</option>
                            <?php foreach ($doctors as $doctor): ?>
                                <option value="<?= $doctor['id'] ?>"><?= esc($doctor['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="appointment_date">Date *</label>
                        <input type="date" id="appointment_date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="start_time">Start Time *</label>
                        <input type="time" id="start_time" name="start_time" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="duration">Duration (minutes) *</label>
                        <select id="duration" name="duration" required>
                            <option value="30">30 minutes</option>
                            <option value="60" selected>1 hour</option>
                            <option value="90">1.5 hours</option>
                            <option value="120">2 hours</option>
                        </select>
                    </div>
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
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="room">Room *</label>
                        <select id="room" name="room" required>
                            <option value="">Select Room</option>
                            <?php foreach ($rooms as $room): ?>
                                <option value="<?= esc($room['room_name']) ?>"><?= esc($room['room_name']) ?> (<?= esc($room['room_type']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="status">Status *</label>
                        <select id="status" name="status" required>
                            <option value="Confirmed">Confirmed</option>
                            <option value="Pending">Pending</option>
                            <option value="Completed">Completed</option>
                            <option value="Cancelled">Cancelled</option>
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
let selectedDoctorId = null;
let currentAppointmentId = null;

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
        loadAppointmentsForDate(this.value);
    });
    
    // View toggle functionality
    document.querySelectorAll('.view-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.dataset.view;
            if (view === 'week') {
                // Switch to weekly view - could redirect to weekly view
                console.log('Switching to weekly view');
            }
        });
    });
});

// Doctor selection
function selectDoctor(doctorId) {
    selectedDoctorId = doctorId;
    
    // Update UI
    document.querySelectorAll('.doctor-item').forEach(item => {
        item.classList.remove('selected');
    });
    document.querySelector(`[data-doctor-id="${doctorId}"]`).classList.add('selected');
    
    // Load appointments for this doctor
    loadAppointmentsForDoctor(doctorId);
}

// Load appointments for specific date
async function loadAppointmentsForDate(date) {
    try {
        const response = await fetch(`<?= site_url('unified-scheduling/getAppointments') ?>?date=${date}`);
        const data = await response.json();
        
        if (data.success) {
            updateAppointmentList(data.appointments);
        }
    } catch (error) {
        console.error('Error loading appointments:', error);
    }
}

// Load appointments for specific doctor
async function loadAppointmentsForDoctor(doctorId) {
    try {
        const response = await fetch(`<?= site_url('unified-scheduling/getAppointments') ?>?doctor_id=${doctorId}`);
        const data = await response.json();
        
        if (data.success) {
            updateAppointmentList(data.appointments);
        }
    } catch (error) {
        console.error('Error loading appointments:', error);
    }
}

// Update appointment list in UI
function updateAppointmentList(appointments) {
    const appointmentList = document.getElementById('appointmentList');
    
    if (appointments.length === 0) {
        appointmentList.innerHTML = `
            <div class="no-appointments">
                <div class="no-appointments-icon">📅</div>
                <div class="no-appointments-text">No appointments found</div>
            </div>
        `;
        return;
    }
    
    appointmentList.innerHTML = appointments.map(appointment => {
        const appointmentTime = new Date(appointment.date_time);
        const statusClass = appointment.status.toLowerCase();
        
        return `
            <div class="appointment-item" data-appointment-id="${appointment.id}">
                <div class="appointment-time">${appointmentTime.toTimeString().slice(0, 5)}</div>
                <div class="appointment-details">
                    <div class="patient-name">${appointment.patient_name}</div>
                    <div class="doctor-info">${appointment.doctor_name} • ${appointment.room || 'No Room'}, ${appointment.type}</div>
                </div>
                <div class="appointment-status">
                    <span class="status-badge ${statusClass}">${appointment.status}</span>
                </div>
                <div class="appointment-actions">
                    <button class="action-btn edit" onclick="editAppointment(${appointment.id})" title="Edit">✏️</button>
                    <button class="action-btn delete" onclick="deleteAppointment(${appointment.id})" title="Delete">🗑️</button>
                </div>
            </div>
        `;
    }).join('');
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
    
    // Find appointment data
    const appointmentItem = document.querySelector(`[data-appointment-id="${appointmentId}"]`);
    if (!appointmentItem) return;
    
    // For now, just open the modal - in a real app, you'd fetch the appointment data
    document.getElementById('appointmentModal').style.display = 'block';
}

// Delete appointment
async function deleteAppointment(appointmentId) {
    if (!confirm('Are you sure you want to delete this appointment?')) {
        return;
    }
    
    try {
        const response = await fetch(`<?= site_url('unified-scheduling/deleteAppointment') ?>/${appointmentId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            showSuccess('Appointment deleted successfully');
            refreshData();
        } else {
            showError(data.message || 'Failed to delete appointment');
        }
    } catch (error) {
        console.error('Error deleting appointment:', error);
        showError('Error deleting appointment');
    }
}

// Save appointment
async function saveAppointment() {
    const form = document.getElementById('appointmentForm');
    const formData = new FormData(form);
    
    // Validate required fields
    const requiredFields = ['patient_id', 'doctor_id', 'date', 'start_time', 'duration', 'type', 'room', 'status'];
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
            
            // Notify doctor's calendar to refresh if appointment was created for a doctor
            if (data.appointment && data.appointment.doctor_id) {
                console.log('Appointment created for doctor ID:', data.appointment.doctor_id);
                // You could add a WebSocket or polling mechanism here to notify the doctor's view
            }
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
    const selectedDate = document.getElementById('scheduleDate').value;
    loadAppointmentsForDate(selectedDate);
    
    if (selectedDoctorId) {
        loadAppointmentsForDoctor(selectedDoctorId);
    }
}

// Show success message
function showSuccess(message) {
    const alert = document.getElementById('success-alert');
    alert.textContent = message;
    alert.style.display = 'block';
    setTimeout(() => alert.style.display = 'none', 3000);
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
    // Refresh every 30 seconds
    refreshInterval = setInterval(() => {
        refreshData();
    }, 30000);
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
        const statsResponse = await fetch('<?= site_url('unified-scheduling/getStatistics') ?>');
        const statsData = await statsResponse.json();
        
        if (statsData.success) {
            updateStatistics(statsData.statistics);
        }
        
        // Refresh appointments
        const appointmentsResponse = await fetch(`<?= site_url('unified-scheduling/getAppointments') ?>?date=${document.getElementById('scheduleDate').value}`);
        const appointmentsData = await appointmentsResponse.json();
        
        if (appointmentsData.success) {
            displayAppointmentsOnCalendar(appointmentsData.appointments);
        }
        
        // Refresh today's appointments list
        loadTodaysAppointments();
        
    } catch (error) {
        console.error('Error refreshing data:', error);
    }
}

// Update statistics display
function updateStatistics(stats) {
    document.querySelector('.stat-card:nth-child(1) .stat-value').textContent = stats.total || 0;
    document.querySelector('.stat-card:nth-child(2) .stat-value').textContent = stats.confirmed || 0;
    document.querySelector('.stat-card:nth-child(3) .stat-value').textContent = stats.pending || 0;
    document.querySelector('.stat-card:nth-child(4) .stat-value').textContent = stats.completed || 0;
}

// Load today's appointments for the list
async function loadTodaysAppointments() {
    try {
        const today = '<?= date('Y-m-d') ?>';
        console.log('Loading appointments for date:', today);
        const response = await fetch(`<?= site_url('unified-scheduling/getAppointments') ?>?date=${today}`);
        const data = await response.json();
        
        console.log('Appointments response:', data);
        
        if (data.success) {
            displayTodaysAppointments(data.appointments);
        } else {
            console.error('Failed to load appointments:', data.message);
        }
    } catch (error) {
        console.error('Error loading today\'s appointments:', error);
    }
}

// Display today's appointments in the list
function displayTodaysAppointments(appointments) {
    const container = document.getElementById('todays-appointments');
    if (!container) {
        console.error('Container todays-appointments not found');
        return;
    }
    
    console.log('Displaying appointments:', appointments);
    container.innerHTML = '';
    
    if (appointments.length === 0) {
        container.innerHTML = '<div class="text-center text-gray-500 py-8">No appointments scheduled for today</div>';
        return;
    }
    
    appointments.forEach(appointment => {
        const appointmentElement = createAppointmentListItem(appointment);
        container.appendChild(appointmentElement);
    });
}

// Create appointment list item
function createAppointmentListItem(appointment) {
    const div = document.createElement('div');
    div.className = 'appointment-item';
    
    const time = new Date(appointment.date_time).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: true
    });
    
    const statusClass = appointment.status.toLowerCase().replace(' ', '-');
    
    div.innerHTML = `
        <div class="appointment-time">${time}</div>
        <div class="appointment-details">
            <div class="appointment-patient">${appointment.patient_name}</div>
            <div class="appointment-doctor">Dr. ${appointment.doctor_name}</div>
            <div class="appointment-room">${appointment.room}</div>
        </div>
        <div class="appointment-status status-${statusClass}">${appointment.status}</div>
        <div class="appointment-actions">
            <button onclick="editAppointment(${appointment.id})" class="btn-edit">✏️</button>
            <button onclick="deleteAppointment(${appointment.id})" class="btn-delete">🗑️</button>
        </div>
    `;
    
    return div;
}

// Initialize real-time updates when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Load initial data
    loadTodaysAppointments();
    
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
