<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scheduling Management - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/appointments.css') ?>">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
            background-color: #f5f7fa;
            overflow-x: hidden;
        }

        .container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: #fff;
            color: #0f172a;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            border-right: 1px solid #e5e7eb;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-icon {
            width: 32px;
            height: 32px;
            background: #2563eb;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            color: #fff;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
        }

        .sidebar-subtitle {
            font-size: 12px;
            color: #64748b;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: block;
            padding: 12px 20px;
            color: #334155;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
            border-left-color: #2563eb;
        }

        .menu-item.active {
            background-color: #eef2ff;
            color: #1d4ed8;
            border-left-color: #2563eb;
        }

        .menu-icon {
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 0;
        }

        /* Header */
        .header {
            background: white;
            padding: 20px 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main-content {
                margin-left: 0;
            }

            .content-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php echo view('auth/partials/sidebar'); ?>

        <!-- Main Content -->
        <main class="main-content">
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
                        <div class="stat-value">156</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Available Doctors</span>
                            <div class="stat-icon doctors">👨‍⚕️</div>
                        </div>
                        <div class="stat-value">28</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Pending Approval</span>
                            <div class="stat-icon pending">⏰</div>
                        </div>
                        <div class="stat-value">12</div>
                    </div>
                    
                    <div class="stat-card">
                        <div class="stat-header">
                            <span class="stat-title">Emergency Cases</span>
                            <div class="stat-icon emergency">🚨</div>
                        </div>
                        <div class="stat-value">3</div>
                    </div>
                </div>

                <!-- Main Content Grid -->
                <div class="content-grid">
                    <!-- Today's Schedule Panel -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title">Today's Schedule</h2>
                            <div class="panel-controls">
                                <input type="date" class="date-selector" id="scheduleDate" value="<?= date('Y-m-d') ?>">
                                <div class="view-toggle">
                                    <button class="view-btn active" data-view="day">Day</button>
                                    <button class="view-btn" data-view="week">Week</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="appointment-list" id="appointmentList">
                            <!-- Sample appointments - will be populated dynamically -->
                        </div>
                    </div>

                    <!-- Doctor Availability Panel -->
                    <div class="panel">
                        <div class="panel-header">
                            <h2 class="panel-title">Doctor Availability</h2>
                        </div>
                        
                        <div class="doctor-list" id="doctorList">
                            <!-- Sample doctors - will be populated dynamically -->
                        </div>
                        
                        <div class="view-all-link">
                            <a href="<?= site_url('scheduling/doctor') ?>">View All Doctors</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sample appointment data (in real app, this would come from the backend)
        const appointments = [
            {
                time: '08:00',
                patient: 'Maria Santos',
                doctor: 'Dr. Juan Martinez',
                location: 'Room 101',
                type: 'Consultation',
                status: 'Scheduled'
            },
            {
                time: '08:30',
                patient: 'Pedro Garcia',
                doctor: 'Dr. Ana Rodriguez',
                location: 'Room 102',
                type: 'Follow-up',
                status: 'Completed'
            },
            {
                time: '09:00',
                patient: 'Carlos Mendoza',
                doctor: 'Dr. Luis Fernandez',
                location: 'Room 103',
                type: 'Surgery',
                status: 'In Progress'
            },
            {
                time: '09:30',
                patient: 'Isabella Cruz',
                doctor: 'Dr. Sofia Torres',
                location: 'Room 104',
                type: 'Emergency',
                status: 'Urgent'
            },
            {
                time: '10:00',
                patient: 'Roberto Silva',
                doctor: 'Dr. Miguel Santos',
                location: 'Room 105',
                type: 'Consultation',
                status: 'Scheduled'
            }
        ];

        // Sample doctor data
        const doctors = [
            {
                name: 'Dr. Juan Martinez',
                specialty: 'Cardiology',
                status: 'Available',
                appointments: 8
            },
            {
                name: 'Dr. Ana Rodriguez',
                specialty: 'Pediatrics',
                status: 'Busy',
                appointments: 12
            },
            {
                name: 'Dr. Luis Fernandez',
                specialty: 'General Surgery',
                status: 'In Surgery',
                appointments: 3
            },
            {
                name: 'Dr. Sofia Torres',
                specialty: 'Emergency Medicine',
                status: 'Available',
                appointments: 5
            },
            {
                name: 'Dr. Miguel Santos',
                specialty: 'Internal Medicine',
                status: 'Available',
                appointments: 10
            }
        ];

        // Render appointments
        function renderAppointments() {
            const container = document.getElementById('appointmentList');
            container.innerHTML = appointments.map(appointment => `
                <div class="appointment-item">
                    <div class="appointment-time">${appointment.time}</div>
                    <div class="appointment-details">
                        <div class="patient-name">${appointment.patient}</div>
                        <div class="doctor-location">${appointment.doctor} • ${appointment.location}</div>
                        <div class="appointment-type">${appointment.type}</div>
                    </div>
                    <span class="status-badge status-${appointment.status.toLowerCase().replace(' ', '-')}">${appointment.status}</span>
                    <div class="appointment-actions">
                        <button class="btn-action btn-edit" onclick="editAppointment('${appointment.time}')">✏️</button>
                        <button class="btn-action btn-delete" onclick="deleteAppointment('${appointment.time}')">🗑️</button>
                    </div>
                </div>
            `).join('');
        }

        // Render doctors
        function renderDoctors() {
            const container = document.getElementById('doctorList');
            container.innerHTML = doctors.map(doctor => `
                <div class="doctor-item">
                    <div class="doctor-avatar">👨‍⚕️</div>
                    <div class="doctor-info">
                        <div class="doctor-name">${doctor.name}</div>
                        <div class="doctor-specialty">${doctor.specialty}</div>
                        <div class="appointment-count">${doctor.appointments} appointments</div>
                    </div>
                    <span class="availability-badge availability-${doctor.status.toLowerCase().replace(' ', '-')}">${doctor.status}</span>
                </div>
            `).join('');
        }

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

        // Date selector functionality
        document.getElementById('scheduleDate').addEventListener('change', function(e) {
            const selectedDate = e.target.value;
            // In real app, fetch appointments for selected date
            console.log('Selected date:', selectedDate);
        });

        // Edit appointment function
        function editAppointment(time) {
            // In real app, open edit modal or redirect to edit page
            alert(`Edit appointment at ${time}`);
        }

        // Delete appointment function
        function deleteAppointment(time) {
            if (confirm(`Delete appointment at ${time}?`)) {
                // In real app, delete appointment
                alert(`Appointment at ${time} deleted`);
            }
        }

        // Initialize
        renderAppointments();
        renderDoctors();

        // Highlight active menu item
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu-item');
            menuItems.forEach(item => {
                const href = item.getAttribute('href') || '';
                if (href && currentPath.includes(href)) {
                    item.classList.add('active');
                }
            });
        });
    </script>
</body>
</html>
