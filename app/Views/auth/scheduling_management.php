<?php echo view('auth/partials/header', ['title' => 'Scheduling Management']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <style>
        /* Header */
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

        .header-subtitle {
            color: #64748b;
            font-size: 14px;
            margin-top: 4px;
        }

        .new-appointment-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
        }

        .new-appointment-btn:hover {
            background: #1d4ed8;
        }

        /* Page Content */
        .page-content {
            padding: 30px;
        }

        /* Summary Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
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
        .stat-icon.emergency { background: #ef4444; }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #0f172a;
        }

        /* Main Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
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
            min-width: 120px; /* Ensure minimum width */
        }

        .view-btn {
            padding: 8px 16px;
            border: none;
            background: white;
            color: #64748b;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1; /* Make buttons equal width */
            min-width: 60px; /* Ensure minimum button width */
            position: relative; /* Ensure proper positioning */
        }

        .view-btn.active {
            background: #2563eb;
            color: white;
        }

        .view-btn:not(.active):hover {
            background: #f8fafc;
        }

        /* Ensure both buttons are visible */
        .view-btn:first-child {
            border-right: 1px solid #e5e7eb;
        }

        .view-btn:last-child {
            border-left: 1px solid #e5e7eb;
        }

        /* Appointment List */
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
        }

        .appointment-item:last-child {
            border-bottom: none;
        }

        .appointment-time {
            width: 60px;
            font-weight: 600;
            color: #0f172a;
        }

        .appointment-details {
            flex: 1;
        }

        .patient-name {
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .doctor-location {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 4px;
        }

        .appointment-type {
            font-size: 12px;
            color: #64748b;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
            margin-left: auto;
        }

        .status-scheduled { background: #f1f5f9; color: #64748b; }
        .status-completed { background: #ecfdf5; color: #16a34a; }
        .status-progress { background: #eff6ff; color: #2563eb; }
        .status-urgent { background: #fef2f2; color: #dc2626; }

        .appointment-actions {
            display: flex;
            gap: 8px;
            margin-left: 12px;
        }

        .btn-action {
            padding: 6px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: opacity 0.3s ease;
        }

        .btn-edit {
            background: #f59e0b;
            color: white;
        }

        .btn-delete {
            background: #ef4444;
            color: white;
        }

        .btn-action:hover {
            opacity: 0.8;
        }

        /* Doctor Availability */
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
        .availability-surgery { background: #fef2f2; color: #dc2626; }

        .view-all-link {
            padding: 16px 20px;
            text-align: center;
            border-top: 1px solid #ecf0f1;
        }

        .view-all-link a {
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        }

        .view-all-link a:hover {
            text-decoration: underline;
        }

        /* Appointment List Styles */
        .appointment-item {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 16px 20px;
            border-bottom: 1px solid #ecf0f1;
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

        .appointment-actions {
            display: flex;
            gap: 8px;
        }

        .action-btn {
            padding: 6px;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .action-btn:hover {
            background-color: #f1f5f9;
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

        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn.primary {
            background: #2563eb;
            color: white;
        }

        .btn.primary:hover {
            background: #1d4ed8;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>

    <!-- Header -->
    <header class="header">
        <div>
            <h1>Scheduling Management</h1>
            <div class="header-subtitle">Manage doctor schedules and appointments</div>
        </div>
        <a href="<?= site_url('appointments/schedule') ?>" class="new-appointment-btn">
            <span>➕</span> New Appointment
        </a>
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
                        <div class="stat-value"><?= $stats['today_appointments'] ?? 0 ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Available Doctors</span>
                            <div class="stat-icon doctors">👨‍⚕️</div>
                        </div>
                        <div class="stat-value"><?= $stats['available_doctors'] ?? 0 ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Pending Approval</span>
                            <div class="stat-icon pending">⏰</div>
                        </div>
                        <div class="stat-value"><?= $stats['pending_approval'] ?? 0 ?></div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Emergency Cases</span>
                            <div class="stat-icon emergency">🚨</div>
                        </div>
                        <div class="stat-value"><?= $stats['emergency_cases'] ?? 0 ?></div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="content-grid">
                    <!-- Today's Schedule Panel -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title"><?= $selected_date ? 'Schedule for ' . date('M d, Y', strtotime($selected_date)) : 'Today\'s Schedule' ?></h2>
                            <div class="panel-controls">
                                <input type="date" class="date-selector" id="scheduleDate" value="<?= $selected_date ?? date('Y-m-d') ?>">
                                <div class="view-toggle">
                                    <button class="view-btn active" data-view="day">Day</button>
                                    <button class="view-btn" data-view="week">Week</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="appointment-list" id="appointmentList">
                            <?php if (!empty($today_schedule)): ?>
                                <?php foreach ($today_schedule as $appointment): ?>
                                    <?php 
                                        $appointmentTime = new DateTime($appointment['date_time']);
                                        $statusClass = '';
                                        switch(strtolower($appointment['status'])) {
                                            case 'confirmed': $statusClass = 'confirmed'; break;
                                            case 'pending': $statusClass = 'pending'; break;
                                            case 'completed': $statusClass = 'completed'; break;
                                            default: $statusClass = 'pending';
                                        }
                                    ?>
                                    <div class="appointment-item">
                                        <div class="appointment-time"><?= $appointmentTime->format('H:i') ?></div>
                                        <div class="appointment-details">
                                            <div class="patient-name"><?= esc($appointment['patient_name']) ?></div>
                                            <div class="doctor-info"><?= esc($appointment['doctor_name']) ?> • <?= esc($appointment['room'] ?? 'No Room') ?>, <?= esc($appointment['type']) ?></div>
                                        </div>
                                        <div class="appointment-status">
                                            <span class="status-badge <?= $statusClass ?>"><?= esc($appointment['status']) ?></span>
                                        </div>
                                        <div class="appointment-actions">
                                            <a href="#" class="action-btn edit" title="Edit">✏️</a>
                                            <a href="#" class="action-btn delete" title="Delete">🗑️</a>
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

                    <!-- Doctor Availability Panel -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title">Doctor Availability</h2>
                        </div>
                        
                        <div class="doctor-list" id="doctorList">
                            <?php if (!empty($doctors)): ?>
                                <?php foreach ($doctors as $doctor): ?>
                                    <?php 
                                        $availabilityClass = 'available';
                                        $availabilityText = 'Available';
                                        if ($doctor['today_appointments'] > 5) {
                                            $availabilityClass = 'busy';
                                            $availabilityText = 'Busy';
                                        } elseif ($doctor['today_appointments'] > 0) {
                                            $availabilityClass = 'available';
                                            $availabilityText = 'Available';
                                        }
                                    ?>
                                    <div class="doctor-item">
                                        <div class="doctor-avatar">
                                            <?= esc(strtoupper(substr($doctor['name'] ?? 'D', 0, 1))) ?>
                                        </div>
                                        <div class="doctor-info">
                                            <div class="doctor-name"><?= esc($doctor['name'] ?? 'Unknown Doctor') ?></div>
                                            <div class="doctor-specialty"><?= esc($doctor['specialty'] ?? 'General Medicine') ?></div>
                                            <div class="appointment-count"><?= $doctor['appointment_count'] ?? 0 ?> appointments</div>
                                        </div>
                                        <span class="availability-badge availability-<?= $availabilityClass ?>"><?= $availabilityText ?></span>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="no-doctors">
                                    <div class="no-doctors-icon">👥</div>
                                    <div class="no-doctors-text">No doctors found</div>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="view-all-link">
                            <a href="<?= site_url('scheduling/doctor') ?>" class="btn primary">View All Doctors</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // View toggle functionality
        document.querySelectorAll('.view-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const view = this.dataset.view;
                if (view === 'week') {
                    // Switch to weekly view
                    window.location.href = '<?= site_url('scheduling/doctor') ?>';
                }
            });
        });

        // Date selector functionality - refresh page with new date
        document.getElementById('scheduleDate').addEventListener('change', function(e) {
            const selectedDate = e.target.value;
            // Redirect to the same page with the new date as a parameter
            const currentUrl = new URL(window.location);
            currentUrl.searchParams.set('date', selectedDate);
            window.location.href = currentUrl.toString();
        });

        // Edit appointment function
        function editAppointment(appointmentId) {
            // Redirect to doctor scheduling with edit mode
            window.location.href = '<?= site_url('scheduling/doctor') ?>?edit=' + appointmentId;
        }

        // Delete appointment function
        function deleteAppointment(appointmentId) {
            if (confirm('Delete this appointment?')) {
                // Send AJAX request to delete appointment
                fetch('<?= site_url('scheduling/deleteAppointment') ?>/' + appointmentId, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Reload the page to refresh the data
                        window.location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting appointment. Please try again.');
                });
            }
        }

        // Add click handlers for edit/delete buttons
        document.addEventListener('DOMContentLoaded', function() {
            // Add click handlers for edit buttons
            document.querySelectorAll('.action-btn.edit').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const appointmentItem = this.closest('.appointment-item');
                    const patientName = appointmentItem.querySelector('.patient-name').textContent;
                    const time = appointmentItem.querySelector('.appointment-time').textContent;
                    
                    // Find the appointment ID from the data or redirect to doctor scheduling
                    window.location.href = '<?= site_url('scheduling/doctor') ?>?search=' + encodeURIComponent(patientName);
                });
            });

            // Add click handlers for delete buttons
            document.querySelectorAll('.action-btn.delete').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const appointmentItem = this.closest('.appointment-item');
                    const patientName = appointmentItem.querySelector('.patient-name').textContent;
                    const time = appointmentItem.querySelector('.appointment-time').textContent;
                    
                    if (confirm(`Delete appointment for ${patientName} at ${time}?`)) {
                        // For now, just remove from DOM (in real app, send to backend)
                        appointmentItem.remove();
                        
                        // Check if no more appointments
                        const remainingAppointments = document.querySelectorAll('.appointment-item');
                        if (remainingAppointments.length === 0) {
                            const container = document.getElementById('appointmentList');
                            container.innerHTML = `
                                <div class="no-appointments">
                                    <div class="no-appointments-icon">📅</div>
                                    <div class="no-appointments-icon">📅</div>
                                    <div class="no-appointments-text">No appointments scheduled for this date</div>
                                </div>
                            `;
                        }
                    }
                });
            });
        });
    </script>
<?php echo view('auth/partials/footer'); ?>
