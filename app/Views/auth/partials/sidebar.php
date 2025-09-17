<nav class="sidebar">
	<!-- Brand -->
	<div class="sidebar-header" style="display:flex; align-items:center; gap:10px">
		<div class="admin-icon">A</div>
		<div style="display:flex; flex-direction:column; line-height:1.1">
			<span class="sidebar-title" style="font-weight:800">San Miguel HMS</span>
			<span style="font-size:12px; color:#cbd5e1">Admin Portal</span>
		</div>
		<div style="margin-left:auto; opacity:.8">≡</div>
	</div>

	<style>
		/* Light theme overrides */
		.sidebar { 
			background:#fff !important; 
			color:#0f172a !important; 
			border-right:1px solid #e5e7eb; 
			overflow-y: hidden !important; 
			overflow-x: hidden !important;
			scrollbar-width: none !important;
			-ms-overflow-style: none !important;
		}
		
		/* Hide scrollbar for webkit browsers */
		.sidebar::-webkit-scrollbar {
			display: none !important;
		}
		.sidebar-header { border-bottom:1px solid #e5e7eb !important }
		.admin-icon { background:#2563eb !important; color:#fff }
		.sidebar-title { color:#0f172a }
		.sidebar-header span[style*="color:#cbd5e1"]{ color:#64748b !important }

		/* Collapsible groups */
		.menu-group { margin-top:2px }
		.group-toggle {
            width: 100%;
            padding: 12px 20px;
            background: none;
            border: none;
            color: #334155;
            text-align: left;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: all 0.3s ease;
            text-decoration: none;
            font-size: 14px;
        }

        .group-toggle:hover {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .menu-group.open .group-toggle {
            background-color: #dbeafe;
            color: #1e40af;
        }
		.group-toggle .chev { margin-left:auto; transition:transform .2s ease }
		.menu-group.open .chev { transform:rotate(90deg) }
		.menu-group.open .group-toggle { background:#dbeafe; color:#1e40af; border-left-color:#2563eb }
		.submenu { display:none; padding:6px 0 8px 46px }
		.menu-group.open .submenu { display:block }
		.subitem { display:block; padding:8px 0; color:#334155; text-decoration:none; font-size:14px }
		.subitem:hover { color:#1e40af; font-weight:600 }
		.subitem.active { color:#1e40af; font-weight:600; background:#dbeafe; padding:4px 8px; border-radius:4px; margin:0 -8px }
		.menu-item { display:flex; align-items:center; gap:12px; padding:12px 20px; color:#334155; text-decoration:none; border-left:3px solid transparent }
		.menu-item:hover { background:#dbeafe; color:#1e40af; border-left-color:#2563eb }
		.menu-item.active { background:#eef2ff; color:#1d4ed8; border-left-color:#2563eb }
		.menu-icon { width:20px; text-align:center }
		
		/* Dashboard, Logout, Branch Management, and System Settings styling to match other sidebar items */
		.menu-item.dashboard,
		.menu-item.logout,
		.menu-item[href*="branch-management"],
		.menu-item[href*="settings"] {
			color: #334155;
		}
		
		.menu-item.dashboard:hover,
		.menu-item.logout:hover,
		.menu-item[href*="branch-management"]:hover,
		.menu-item[href*="settings"]:hover {
			background: #dbeafe;
			color: #1e40af;
		}
		
		/* Ensure Branch Management and System Settings maintain consistent color when other items are active */
		.menu-item[href*="branch-management"]:not(.active),
		.menu-item[href*="settings"]:not(.active) {
			color: #334155 !important;
		}
	</style>

	<div class="sidebar-menu" id="sidebarMenu">
		<?php $role = session('role') ?? 'admin'; ?>
		<?php if ($role === 'it_staff'): ?>
			<a href="<?= site_url('it') ?>" class="menu-item"><span class="menu-icon">🖥️</span>IT Dashboard</a>
			<a href="<?= site_url('it/monitoring') ?>" class="menu-item"><span class="menu-icon">📡</span>System Monitoring</a>
			<a href="<?= site_url('it/security') ?>" class="menu-item"><span class="menu-icon">🔐</span>Security & Access</a>
			<a href="<?= site_url('it/backup') ?>" class="menu-item"><span class="menu-icon">💾</span>Backup & Recovery</a>
			<a href="<?= site_url('users') ?>" class="menu-item"><span class="menu-icon">👤</span>User Management</a>

			<a href="<?= site_url('it/logs') ?>" class="menu-item"><span class="menu-icon">📜</span>System Logs</a>
			<a href="<?= site_url('reports') ?>" class="menu-item"><span class="menu-icon">📈</span>IT Reports</a>
			<a href="<?= site_url('settings') ?>" class="menu-item"><span class="menu-icon">⚙️</span>Settings</a>
		<?php else: ?>
			<!-- Dashboard -->
			<a href="http://localhost/HMS-ITE311_GROUP4/admin/dashboard" class="menu-item dashboard">
				<span class="menu-icon">📊</span>Dashboard
			</a>

			<!-- Patient Management -->
			<div class="menu-group" data-group="patients">
				<button class="group-toggle" type="button"><span class="menu-icon">👥</span>Patient Management <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/patient-management/records">Patient Records</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/patient-management/add">Registration</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/patient-management/history">Medical History</a>
				</div>
			</div>

			<!-- Scheduling -->
			<div class="menu-group" data-group="scheduling">
				<button class="group-toggle" type="button"><span class="menu-icon">📅</span>Scheduling <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/scheduling-management/doctor">Doctor Schedule</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/scheduling-management/nurse">Nurse Schedule</a>
				</div>
			</div>

			<!-- Billing & Payments -->
			<div class="menu-group" data-group="billing">
				<button class="group-toggle" type="button">
					<span class="menu-icon">🧾</span>Billing & Payments <span class="chev">›</span>
				</button>
				<div class="submenu">
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/billing-management/generate">Generate Bills</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/billing-management/payments">Payment Tracking</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/billing-management/insurance-claims">Insurance Claims</a>
				</div>
			</div>

			<!-- Lab Management -->
			<div class="menu-group" data-group="lab-management">
				<button class="group-toggle" type="button"><span class="menu-icon">🧪</span>Lab Management <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/lab-management/requests">Lab Requests</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/lab-management/results">Lab Results</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/lab-management/equipment">Equipment Status</a>
				</div>
			</div>

			<!-- Pharmacy Management -->
			<div class="menu-group" data-group="pharmacy">
				<button class="group-toggle" type="button"><span class="menu-icon">💊</span>Pharmacy Management <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/pharmacy-management/inventory">Inventory Management</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/pharmacy-management/prescriptions">Prescription Orders</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/pharmacy-management/stock-alerts">Stock Alerts</a>
				</div>
			</div>



			<!-- Reports & Analytics -->
			<div class="menu-group" data-group="reports">
				<button class="group-toggle" type="button"><span class="menu-icon">📊</span>Reports & Analytics <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/reports-management/performance">Performance Report</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/reports-management/financial">Financial Reports</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/reports-management/patient-analytics">Patient Analytics</a>
				</div>
			</div>

			<div class="menu-group" data-group="staff">
				<button class="group-toggle" type="button" onclick="window.location.href='http://localhost/HMS-ITE311_GROUP4/admin/staff-management'"><span class="menu-icon">👥</span>Staff Management <span class="chev">›</span></button>
				<div class="submenu">
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/staff-management/employee-records">Employee Records</a>
					<a class="subitem" href="http://localhost/HMS-ITE311_GROUP4/admin/staff-management/role-management">Role Management</a>
				</div>
			</div>

			<a href="http://localhost/HMS-ITE311_GROUP4/admin/branch-management" class="menu-item"><span class="menu-icon">🏢</span>Branch Management</a>



			<a href="http://localhost/HMS-ITE311_GROUP4/admin/system-settings" class="menu-item"><span class="menu-icon">⚙️</span>System Settings</a>
		<?php endif; ?>

		<a href="http://localhost/HMS-ITE311_GROUP4/admin/logout" class="menu-item logout"><span class="menu-icon">🚪</span>Logout</a>
	</div>

	<script>
		(function(){
			const groups = document.querySelectorAll('[data-group]');
			groups.forEach(g=>{
				const btn = g.querySelector('.group-toggle');
				
				// Check if it's a link or button
				if (btn.tagName === 'A') {
					// For link group-toggles (like Billing & Payments), don't add click handler
					// The link will handle navigation naturally
				} else {
					// For button group-toggles, add click handler
					btn.addEventListener('click', (e)=>{
						// For Patient Management group, go to dashboard
						if (btn.textContent.includes('Patient Management')) {
							window.location.href = 'http://localhost/HMS-ITE311_GROUP4/admin/patient-management';
						} else if (btn.textContent.includes('Scheduling')) {
							// For Scheduling group, go to Scheduling Management dashboard
							window.location.href = 'http://localhost/HMS-ITE311_GROUP4/admin/scheduling-management';
						} else if (btn.textContent.includes('Billing & Payments')) {
							// For Billing & Payments group, go to main billing dashboard
							window.location.href = 'http://localhost/HMS-ITE311_GROUP4/admin/billing-management';
						} else if (btn.textContent.includes('Lab Management')) {
							// For Lab Management group, go to main lab management dashboard
							// Don't auto-open submenu, just navigate
							window.location.href = 'http://localhost/HMS-ITE311_GROUP4/admin/lab-management';
						} else if (btn.textContent.includes('Pharmacy Management')) {
							// For Pharmacy Management group, go to main pharmacy dashboard
							window.location.href = 'http://localhost/HMS-ITE311_GROUP4/admin/pharmacy-management';
						} else if (btn.textContent.includes('Reports & Analytics')) {
							// For Reports & Analytics group, go to main reports dashboard
							window.location.href = 'http://localhost/HMS-ITE311_GROUP4/admin/reports-management';
						} else {
							// For other groups, toggle submenu
							g.classList.toggle('open');
						}
					});
				}
				
				// Add separate click handler for chevron to expand/collapse
				const chevron = btn.querySelector('.chev');
				if (chevron) {
					chevron.addEventListener('click', (e)=>{
						e.stopPropagation(); // Prevent triggering the main button/link click
						g.classList.toggle('open');
					});
				}
			});
			
			// Active highlight for routes (top-level and subitems) and auto-open group
			const path = window.location.pathname;
			let activeSet = false;
			
			document.querySelectorAll('.menu-item').forEach(a=>{
				const href = a.getAttribute('href') || '';
				if(href && path.indexOf(href) !== -1){ a.classList.add('active'); activeSet = true; }
			});
			
			document.querySelectorAll('.submenu .subitem').forEach(a=>{
				const href = a.getAttribute('href') || '';
				// Extract just the path part from the full URL
				const hrefPath = href.replace(window.location.origin, '').replace(/^\//, '');
				const currentPath = path.replace(/^\//, '');
				
				if(hrefPath && currentPath.includes(hrefPath)){
					a.classList.add('active'); // Add active class for styling
					const group = a.closest('[data-group]');
					
					// For all groups, auto-open when a subitem is active
					if (group) {
						group.classList.add('open');
					}
					
					activeSet = true;
				}
			});

			// Keep Staff Management submenu open when on staff-related pages
			if (path.includes('admin/staff-management/employee-records') || path.includes('admin/staff-management/role-management')) {
				const staffGroup = document.querySelector('[data-group="staff"]');
				if (staffGroup) {
					staffGroup.classList.add('open');
				}
			}
			
			// Auto-open specific groups based on current page
			// Patient Management group
			if (path.includes('admin/patient-management/records') || path.includes('admin/patient-management/add') || path.includes('admin/patient-management/history')) {
				const patientGroup = document.querySelector('[data-group="patients"]');
				patientGroup && patientGroup.classList.add('open');
			}
			
			// Scheduling group
			if (path.includes('admin/scheduling-management/doctor') || path.includes('admin/scheduling-management/nurse')) {
				const schedulingGroup = document.querySelector('[data-group="scheduling"]');
				schedulingGroup && schedulingGroup.classList.add('open');
			}
			
			// Billing & Payments group
			if (path.includes('admin/billing-management/generate') || path.includes('admin/billing-management/payments') || path.includes('admin/billing-management/insurance-claims')) {
				const billingGroup = document.querySelector('[data-group="billing"]');
				billingGroup && billingGroup.classList.add('open');
			}
			
			// Lab Management group - auto-open when on lab management pages or lab results
			if (path.includes('admin/lab-management') || path.includes('laboratory_results')) {
				const labManagementGroup = document.querySelector('[data-group="lab-management"]');
				if (labManagementGroup) {
					labManagementGroup.classList.add('open');
				}
			}
			
			// Pharmacy group - same behavior as other groups
			if (path.includes('admin/pharmacy-management/inventory') || path.includes('admin/pharmacy-management/prescriptions') || path.includes('admin/pharmacy-management/stock-alerts')) {
				const pharmacyGroup = document.querySelector('[data-group="pharmacy"]');
				pharmacyGroup && pharmacyGroup.classList.add('open');
			}
			
			// Reports & Analytics group - same behavior as other groups
			if (path.includes('admin/reports-management/performance') || path.includes('admin/reports-management/financial') || path.includes('admin/reports-management/patient-analytics')) {
				const reportsGroup = document.querySelector('[data-group="reports"]');
				reportsGroup && reportsGroup.classList.add('open');
			}
			
			// No default open; groups open only on user click or when on specific sub-pages
			

		})();
	</script>
</nav>

