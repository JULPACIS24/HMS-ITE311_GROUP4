<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Healthcare Admin</title>
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
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #34495e;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-icon {
            width: 32px;
            height: 32px;
            background: #3498db;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: block;
            padding: 12px 20px;
            color: #bdc3c7;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .menu-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
            border-left-color: #3498db;
        }

        .menu-item.active {
            background-color: rgba(52, 152, 219, 0.2);
            color: white;
            border-left-color: #3498db;
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
            color: #2c3e50;
            font-weight: 600;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 14px;
        }

        /* Dashboard Content */
        .dashboard-content {
            padding: 30px;
        }

        /* Stats Cards */
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
        }

        .stat-card.patients::before { background: #3498db; }
        .stat-card.revenue::before { background: #27ae60; }
        .stat-card.appointments::before { background: #9b59b6; }
        .stat-card.stock::before { background: #e74c3c; }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .stat-title {
            color: #7f8c8d;
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

        .stat-icon.patients { background: #3498db; }
        .stat-icon.revenue { background: #27ae60; }
        .stat-icon.appointments { background: #9b59b6; }
        .stat-icon.stock { background: #e74c3c; }

        .stat-value {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
        }

        /* Content Grid */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 30px;
            margin-bottom: 30px;
            align-items: stretch; /* Make both columns the same height */
        }

        .card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid #ecf0f1;
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
        }

        .card-content {
            padding: 20px 24px;
            flex: 1; /* Fill remaining height so both cards align */
            display: flex;
            flex-direction: column;
        }

        /* Pending Tasks */
        .task-item {
            padding: 16px 0;
            border-bottom: 1px solid #ecf0f1;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .task-item:last-child {
            border-bottom: none;
        }

        .task-info h4 {
            color: #2c3e50;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .task-meta {
            font-size: 12px;
            color: #7f8c8d;
            margin-bottom: 4px;
        }

        .task-status {
            font-size: 12px;
            color: #7f8c8d;
        }

        .task-actions {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }

        .priority-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .priority-high { background: #fee; color: #e74c3c; }
        .priority-medium { background: #fff9e6; color: #f39c12; }
        .priority-low { background: #e8f5e8; color: #27ae60; }

        .review-btn {
            background: none;
            border: none;
            color: #3498db;
            font-size: 12px;
            cursor: pointer;
            text-decoration: underline;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .action-btn {
            padding: 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            font-weight: 600;
            text-align: center;
            transition: transform 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .action-btn.add-patient { background: #3498db; }
        .action-btn.schedule { background: #27ae60; }
        .action-btn.reports { background: #9b59b6; }
        .action-btn.settings { background: #e67e22; }

        .action-icon {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        /* Bottom Grid */
        .bottom-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
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
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="admin-icon">A</div>
                <span class="sidebar-title">Administrator</span>
            </div>
            
            <div class="sidebar-menu">
                <a href="<?= site_url('dashboard') ?>" class="menu-item active"><span class="menu-icon">📊</span>Dashboard</a>
                <a href="<?= site_url('patients') ?>" class="menu-item"><span class="menu-icon">👥</span>Patients</a>
                <a href="<?= site_url('appointments') ?>" class="menu-item"><span class="menu-icon">📅</span>Appointments</a>
                <a href="<?= site_url('billing') ?>" class="menu-item"><span class="menu-icon">💳</span>Billing & Payments</a>
                <a href="<?= site_url('laboratory') ?>" class="menu-item"><span class="menu-icon">🧪</span>Laboratory</a>
                <a href="<?= site_url('pharmacy') ?>" class="menu-item"><span class="menu-icon">💊</span>Pharmacy & Inventory</a>
                <a href="<?= site_url('reports') ?>" class="menu-item"><span class="menu-icon">📈</span>Reports</a>
                <a href="<?= site_url('users') ?>" class="menu-item"><span class="menu-icon">👤</span>User Management</a>
                <a href="<?= site_url('settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
                <a href="<?= site_url('logout') ?>" class="menu-item"><span class="menu-icon">🚪</span>Logout</a>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Dashboard</h1>
                <div class="user-info">
                    <div class="user-avatar">A</div>
                    <span>Admin</span>
                </div>
            </header>

            <!-- Dashboard Content -->
            <div class="dashboard-content">
                <!-- Stats Cards -->
                <div class="stats-grid">
                    <div class="stat-card patients">
                        <div class="stat-header">
                            <span class="stat-title">Patients Today</span>
                            <div class="stat-icon patients">👥</div>
                        </div>
                        <div class="stat-value">24</div>
                    </div>
                    
                    <div class="stat-card revenue">
                        <div class="stat-header">
                            <span class="stat-title">Revenue Today</span>
                            <div class="stat-icon revenue">💰</div>
                        </div>
                        <div class="stat-value">$4,320</div>
                    </div>
                    
                    <div class="stat-card appointments">
                        <div class="stat-header">
                            <span class="stat-title">Appointments Scheduled</span>
                            <div class="stat-icon appointments">📅</div>
                        </div>
                        <div class="stat-value">18</div>
                    </div>
                    
                    <div class="stat-card stock">
                        <div class="stat-header">
                            <span class="stat-title">Low Stock Items</span>
                            <div class="stat-icon stock">⚠️</div>
                        </div>
                        <div class="stat-value">5</div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="content-grid">
                    <!-- Pending Approvals/Tasks -->
                    <div class="card">
                        <div class="card-header">Pending Approvals/Tasks</div>
                        <div class="card-content">
                            <div class="task-item">
                                <div class="task-info">
                                    <h4>Appointment request</h4>
                                    <div class="task-meta">Assigned to: Alice Smith</div>
                                    <div class="task-status">Pending</div>
                                </div>
                                <div class="task-actions">
                                    <span class="priority-badge priority-high">High</span>
                                    <button class="review-btn">Review</button>
                                </div>
                            </div>
                            
                            <div class="task-item">
                                <div class="task-info">
                                    <h4>Order supplies</h4>
                                    <div class="task-meta">Assigned to: David Johnson</div>
                                    <div class="task-status">Pending</div>
                                </div>
                                <div class="task-actions">
                                    <span class="priority-badge priority-medium">Medium</span>
                                    <button class="review-btn">Review</button>
                                </div>
                            </div>
                            
                            <div class="task-item">
                                <div class="task-info">
                                    <h4>Review payroll</h4>
                                    <div class="task-meta">Assigned to: Elizabeth Brown</div>
                                    <div class="task-status">Pending</div>
                                </div>
                                <div class="task-actions">
                                    <span class="priority-badge priority-medium">Medium</span>
                                    <button class="review-btn">Review</button>
                                </div>
                            </div>
                            
                            <div class="task-item">
                                <div class="task-info">
                                    <h4>System update</h4>
                                    <div class="task-meta">Assigned to: Robert Wilson</div>
                                    <div class="task-status">Pending</div>
                                </div>
                                <div class="task-actions">
                                    <span class="priority-badge priority-low">Low</span>
                                    <button class="review-btn">Review</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card">
                        <div class="card-header">Quick Actions</div>
                        <div class="card-content">
                            <div class="quick-actions">
                                <a href="<?= site_url('patients') ?>" class="action-btn add-patient">
                                    <span class="action-icon">👥</span>
                                    Patients
                                </a>
                                <a href="<?= site_url('appointments') ?>" class="action-btn schedule">
                                    <span class="action-icon">📅</span>
                                    Appointments
                                </a>
                                <a href="<?= site_url('reports') ?>" class="action-btn reports">
                                    <span class="action-icon">📊</span>
                                    Reports
                                </a>
                                <a href="<?= site_url('settings') ?>" class="action-btn settings">
                                    <span class="action-icon">⚙️</span>
                                    Settings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bottom Grid -->
                <div class="bottom-grid">
                    <div class="card">
                        <div class="card-header">Recent Activities</div>
                        <div class="card-content">
                            <p style="color: #7f8c8d; text-align: center; padding: 40px 0;">
                                Recent activities will appear here...
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">System Status</div>
                        <div class="card-content">
                            <p style="color: #7f8c8d; text-align: center; padding: 40px 0;">
                                System status information will appear here...
                            </p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">Today's Summary</div>
                        <div class="card-content">
                            <p style="color: #7f8c8d; text-align: center; padding: 40px 0;">
                                Daily summary will appear here...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Add some basic interactivity
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active menu item based on current URL
            const currentPath = window.location.pathname;
            const menuItems = document.querySelectorAll('.menu-item');
            
            menuItems.forEach(item => {
                if (item.getAttribute('href') && currentPath.includes(item.getAttribute('href').split('/').pop())) {
                    menuItems.forEach(mi => mi.classList.remove('active'));
                    item.classList.add('active');
                }
            });

            // Add click handlers for review buttons
            const reviewButtons = document.querySelectorAll('.review-btn');
            reviewButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    alert('Review functionality would be implemented here');
                });
            });
        });
    </script>
</body>
</html>
            });
        });
    </script>
</body>
</html>