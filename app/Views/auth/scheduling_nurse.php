<?php echo view('auth/partials/header', ['title' => 'Nurse Scheduling']); ?>
<style>
.user-info {
    display: flex;
    align-items: center;
    gap: 12px;
}

.btn {
    display: inline-block;
    padding: 8px 16px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    border: 1px solid #d1d5db;
    background: white;
    color: #374151;
}

.btn:hover {
    background: #f9fafb;
    border-color: #9ca3af;
}
</style>
<div class="container">
	<?php echo view('auth/partials/sidebar'); ?>
	<main class="main-content">
		<header class="header">
			<h1>Nurse Scheduling</h1>
			<div class="user-info" style="gap:12px">
				<a class="btn" href="<?= site_url('scheduling-management') ?>">Back to Scheduling</a>
			</div>
		</header>
		<div class="page-content">
			<div class="card form" style="display:flex; gap:12px; align-items:center; justify-content:space-between; padding:16px 20px">
				<div style="display:flex; gap:12px; align-items:center">
					<input type="date" class="search-input" style="width:auto" value="<?= date('Y-m-d') ?>">
					<select class="search-input" id="departmentFilter" style="width:auto">
						<option value="">All Departments</option>
						<option value="Emergency">Emergency</option>
						<option value="ICU">ICU</option>
						<option value="Medical">Medical</option>
					</select>
				</div>
				<button class="btn primary" id="addNurseSchedBtn">Add Nurse Schedule</button>
			</div>
			<div class="patients-table-container">
				<table class="patients-table">
					<thead><tr><th>Nurse Details</th><th>Department</th><th>Shift & Time</th><th>Status</th><th>Patients Assigned</th><th>Actions</th></tr></thead>
					<tbody id="nurseSchedulesTableBody">
						<!-- Table content will be populated by JavaScript -->
					</tbody>
				</table>
			</div>
		</div>
	</main>
</div>

<!-- Add Nurse Schedule Modal -->
<div class="modal" id="addNurseSchedModal" aria-hidden="true">
	<div class="modal-backdrop" data-close="addNurseSchedModal"></div>
	<div class="modal-dialog" style="max-width:620px">
		<div class="modal-header"><h3>Add Nurse Schedule</h3><button class="modal-close" data-close="addNurseSchedModal">×</button></div>
		<form id="nurseSchedForm">
			<div class="modal-body">
				<label><span>Select Nurse</span>
					<select name="nurse_id" id="nurseSelect" required>
						<option selected disabled>Choose a nurse...</option>
						<?php if (!empty($nurses)): ?>
							<?php foreach ($nurses as $nurse): ?>
								<option value="<?= $nurse['id'] ?>"><?= esc($nurse['name']) ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</label>
				<div class="grid-2 modal-grid">
					<label><span>Department</span>
						<select name="department" id="departmentSelect" required>
							<option value="">Select Department</option>
							<option value="Emergency">Emergency</option>
							<option value="ICU">ICU</option>
							<option value="Medical">Medical</option>
						</select>
					</label>
					<label><span>Shift</span>
						<select name="shift" id="shiftSelect" required>
							<option value="">Select Shift</option>
							<option value="Morning Shift">Morning (6:00 AM - 2:00 PM)</option>
							<option value="Evening Shift">Evening (2:00 PM - 10:00 PM)</option>
							<option value="Night Shift">Night (10:00 PM - 6:00 AM)</option>
						</select>
					</label>
				</div>
			</div>
			<div class="modal-footer"><button class="btn" type="button" data-close="addNurseSchedModal">Cancel</button><button class="btn primary" type="submit">Add Schedule</button></div>
		</form>
	</div>
</div>

<!-- Edit Nurse Schedule Modal -->
<div class="modal" id="editNurseSchedModal" aria-hidden="true">
	<div class="modal-backdrop" data-close="editNurseSchedModal"></div>
	<div class="modal-dialog" style="max-width:620px">
		<div class="modal-header"><h3>Edit Nurse Schedule</h3><button class="modal-close" data-close="editNurseSchedModal">×</button></div>
		<form id="editNurseSchedForm">
			<input type="hidden" id="editScheduleId" name="schedule_id">
			<div class="modal-body">
				<div class="grid-2 modal-grid">
					<label><span>Department</span>
						<select name="department" id="editDepartmentSelect" required>
							<option value="">Select Department</option>
							<option value="Emergency">Emergency</option>
							<option value="ICU">ICU</option>
							<option value="Medical">Medical</option>
						</select>
					</label>
					<label><span>Shift</span>
						<select name="shift" id="editShiftSelect" required>
							<option value="">Select Shift</option>
							<option value="Morning Shift">Morning (6:00 AM - 2:00 PM)</option>
							<option value="Evening Shift">Evening (2:00 PM - 10:00 PM)</option>
							<option value="Night Shift">Night (10:00 PM - 6:00 AM)</option>
						</select>
					</label>
				</div>
				<label><span>Status</span>
					<select name="status" id="editStatusSelect" required>
						<option value="Active">Active</option>
						<option value="On Leave">On Leave</option>
					</select>
				</label>
			</div>
			<div class="modal-footer"><button class="btn" type="button" data-close="editNurseSchedModal">Cancel</button><button class="btn primary" type="submit">Update Schedule</button></div>
		</form>
	</div>
</div>

<script>
// Global variables
let currentSchedules = [];
let nurses = <?= json_encode($nurses ?? []) ?>;

// Modal functions
function openModal(modalId) {
    document.getElementById(modalId).classList.add('open');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('open');
}

// Initialize modals
document.addEventListener('DOMContentLoaded', function() {
    // Add Nurse Schedule Modal
    const addBtn = document.getElementById('addNurseSchedBtn');
    const addModal = document.getElementById('addNurseSchedModal');
    
    addBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        openModal('addNurseSchedModal');
    });

    // Close modals
    document.querySelectorAll('[data-close]').forEach(el => {
        el.addEventListener('click', () => {
            const modalId = el.getAttribute('data-close');
            closeModal(modalId);
        });
    });

    // Form submissions
    document.getElementById('nurseSchedForm')?.addEventListener('submit', addNurseSchedule);
    document.getElementById('editNurseSchedForm')?.addEventListener('submit', updateNurseSchedule);

    // Load existing schedules
    loadNurseSchedules();
});

// Add nurse schedule
async function addNurseSchedule(ev) {
    ev.preventDefault();
    
    const formData = new FormData(ev.target);
    const data = {
        nurse_id: formData.get('nurse_id'),
        department: formData.get('department'),
        shift: formData.get('shift')
    };

    try {
        const response = await fetch('<?= site_url('scheduling/addNurseSchedule') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        
        if (result.success) {
            // Create new schedule object
            const newSchedule = {
                id: 'schedule_' + Date.now(), // Generate unique ID
                nurse_id: data.nurse_id,
                department: data.department,
                shift: data.shift,
                shift_time: getShiftTime(data.shift),
                status: 'Active',
                patients_assigned: 0,
                experience: '5 years experience'
            };
            
            // Add to current schedules
            currentSchedules.push(newSchedule);
            
            // Debug: Show current schedules
            console.log('Added new schedule:', newSchedule);
            console.log('Total schedules now:', currentSchedules.length);
            
            // Update the table
            renderNurseSchedules();
            
            alert(result.message);
            closeModal('addNurseSchedModal');
            ev.target.reset();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to add nurse schedule');
    }
}

// Helper function to get shift time
function getShiftTime(shift) {
    switch(shift) {
        case 'Morning Shift':
            return '6:00 AM - 2:00 PM';
        case 'Evening Shift':
            return '2:00 PM - 10:00 PM';
        case 'Night Shift':
            return '10:00 PM - 6:00 AM';
        default:
            return '6:00 AM - 2:00 PM';
    }
}

// Edit nurse schedule
function editNurseSchedule(scheduleId) {
    // Find the schedule data
    const schedule = currentSchedules.find(s => s.id === scheduleId);
    if (!schedule) {
        alert('Schedule not found');
        return;
    }

    // Populate the edit form
    document.getElementById('editScheduleId').value = schedule.id;
    document.getElementById('editDepartmentSelect').value = schedule.department;
    document.getElementById('editShiftSelect').value = schedule.shift;
    document.getElementById('editStatusSelect').value = schedule.status;

    // Open the edit modal
    openModal('editNurseSchedModal');
}

// Update nurse schedule
async function updateNurseSchedule(ev) {
    ev.preventDefault();
    
    const formData = new FormData(ev.target);
    const scheduleId = formData.get('schedule_id');
    const data = {
        department: formData.get('department'),
        shift: formData.get('shift'),
        status: formData.get('status')
    };

    try {
        const response = await fetch(`<?= site_url('scheduling/updateNurseSchedule/') ?>${scheduleId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        
        if (result.success) {
            // Update the schedule in currentSchedules
            const scheduleIndex = currentSchedules.findIndex(s => s.id === scheduleId);
            if (scheduleIndex !== -1) {
                currentSchedules[scheduleIndex] = {
                    ...currentSchedules[scheduleIndex],
                    department: data.department,
                    shift: data.shift,
                    status: data.status,
                    shift_time: getShiftTime(data.shift)
                };
            }
            
            // Update the table
            renderNurseSchedules();
            
            alert(result.message);
            closeModal('editNurseSchedModal');
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to update nurse schedule');
    }
}

// Remove nurse schedule
async function removeNurseSchedule(scheduleId) {
    if (!confirm('Are you sure you want to remove this nurse schedule?')) {
        return;
    }

    try {
        const response = await fetch(`<?= site_url('scheduling/deleteNurseSchedule/') ?>${scheduleId}`, {
            method: 'POST'
        });

        const result = await response.json();
        
        if (result.success) {
            // Remove the schedule from currentSchedules
            currentSchedules = currentSchedules.filter(s => s.id !== scheduleId);
            
            // Update the table
            renderNurseSchedules();
            
            alert(result.message);
        } else {
            alert('Error: ' + result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Failed to remove nurse schedule');
    }
}

// Load nurse schedules
function loadNurseSchedules() {
    // For now, we'll use the data from PHP
    // In a real app, you'd fetch from an API endpoint
    currentSchedules = <?= json_encode($nurseSchedules ?? []) ?>;
    renderNurseSchedules();
}

// Render nurse schedules in the table
function renderNurseSchedules() {
    const tbody = document.getElementById('nurseSchedulesTableBody');
    if (!tbody) return;

    if (currentSchedules.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="6" style="text-align: center; color: #64748b;">
                    <div style="font-size: 48px; margin-bottom: 16px;">👩‍⚕️</div>
                    <div style="font-weight: 600; color: #1e293b; margin-bottom: 8px;">No Nurse Schedules Found</div>
                    <div>No nurse schedules are currently in the system. Add some schedules to get started.</div>
                </td>
            </tr>
        `;
        return;
    }

    tbody.innerHTML = currentSchedules.map(schedule => {
        const nurse = nurses.find(n => n.id == schedule.nurse_id);
        const nurseName = nurse ? nurse.name : 'Unknown Nurse';
        
        return `
            <tr>
                <td>
                    <strong>${nurseName}</strong>
                    <div class="sub">${schedule.experience}</div>
                </td>
                <td>${schedule.department}</td>
                <td>
                    ${schedule.shift}
                    <div class="sub">${schedule.shift_time}</div>
                </td>
                <td>
                    <span class="badge ${schedule.status === 'Active' ? 'completed' : 'pending'}">
                        ${schedule.status}
                    </span>
                </td>
                <td>${schedule.patients_assigned} patients</td>
                <td class="actions">
                    <button class="btn" onclick="editNurseSchedule('${schedule.id}')">Edit</button>
                    <button class="btn" onclick="removeNurseSchedule('${schedule.id}')">Remove</button>
                </td>
            </tr>
        `;
    }).join('');
}

// Auto-populate department when nurse is selected
document.getElementById('nurseSelect')?.addEventListener('change', function() {
    const nurseId = this.value;
    const departmentSelect = document.getElementById('departmentSelect');
    
    if (nurseId) {
        departmentSelect.disabled = false;
    } else {
        departmentSelect.disabled = true;
        departmentSelect.value = '';
    }
});

// Filter nurses by department
document.getElementById('departmentFilter')?.addEventListener('change', function() {
    const selectedDepartment = this.value;
    const tableRows = document.querySelectorAll('#nurseSchedulesTableBody tr');
    
    tableRows.forEach(row => {
        const departmentCell = row.querySelector('td:nth-child(2)'); // Department column
        if (departmentCell) {
            const department = departmentCell.textContent.trim();
            if (!selectedDepartment || department === selectedDepartment) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        }
    });
});
</script>
<?php echo view('auth/partials/footer'); ?>
