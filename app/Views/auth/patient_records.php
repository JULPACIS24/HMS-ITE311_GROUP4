<?php echo view('auth/partials/header', ['title' => 'Patient Records']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header">
            <div>
                <h1>Patient Records</h1>
                <div class="sub" style="color:#64748b">View and manage detailed patient medical records</div>
            </div>
            <a href="<?= site_url('patient-management') ?>" class="back-btn">
                <span>←</span> Back to Patients
            </a>
        </header>
        
        <div class="page-content">
            <div class="split-panel">
                <!-- Left Panel - Patient List -->
                <div class="left-panel">
                    <div class="search-card">
                        <div class="search-input-wrapper">
                            <span class="search-icon">🔍</span>
                            <input type="text" class="search-input" id="patientSearch" placeholder="Search patient records...">
                        </div>
                    </div>
                    
                    <div class="patient-list">
                        <?php foreach (($patients ?? []) as $p): ?>
                            <div class="patient-item" data-patient-id="<?= $p['id'] ?>" onclick="selectPatient(<?= $p['id'] ?>, <?= htmlspecialchars(json_encode($p), ENT_QUOTES, 'UTF-8') ?>)">
                                <div class="patient-avatar">👤</div>
                                <div class="patient-info">
                                    <div class="patient-name"><?= esc(($p['first_name'] ?? '').' '.($p['last_name'] ?? '')) ?></div>
                                    <div class="patient-meta">
                                        P<?= esc(str_pad((string)$p['id'],3,'0',STR_PAD_LEFT)) ?> • 
                                        <?php 
                                            if (!empty($p['dob'])) {
                                                $dob = new DateTime($p['dob']);
                                                $now = new DateTime();
                                                echo $dob->diff($now)->y . 'y';
                                            } else {
                                                echo 'N/A';
                                            }
                                        ?> • 
                                        <?= esc($p['gender'] ?? 'N/A') ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Right Panel - Patient Details -->
                <div class="right-panel">
                    <div class="patient-details" id="patientDetails">
                        <div class="select-patient-message">
                            <div class="message-icon">👥</div>
                            <div class="message-title">Select a Patient</div>
                            <div class="message-subtitle">Choose a patient from the list to view their medical records</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<style>
/* Header */
.header {
    background: white;
    padding: 24px 32px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
    border-radius: 12px;
}

.header h1 {
    font-size: 28px;
    color: #1e293b;
    font-weight: 700;
    margin: 0;
}

.header .sub {
    color: #64748b;
    font-size: 15px;
    margin-top: 6px;
    font-weight: 400;
}

.back-btn {
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #e2e8f0;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

/* Page Content */
.page-content {
    padding: 0 32px 32px;
}

/* Split Panel Layout */
.split-panel {
    display: grid;
    grid-template-columns: 380px 1fr;
    gap: 28px;
    height: calc(100vh - 220px);
}

/* Left Panel - Patient List */
.left-panel {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: 1px solid #f1f5f9;
}

.search-card {
    padding: 20px;
    border-bottom: 1px solid #f1f5f9;
    background: #fafafa;
}

.search-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 14px;
    color: #94a3b8;
    font-size: 16px;
    z-index: 2;
}

.search-input {
    width: 100%;
    padding: 14px 14px 14px 42px;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    font-size: 14px;
    outline: none;
    background: white;
    color: #374151;
}

.search-input:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.search-input::placeholder {
    color: #9ca3af;
}

.patient-list {
    overflow-y: auto;
    max-height: calc(100vh - 340px);
}

.patient-item {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 18px 20px;
    cursor: pointer;
    border-left: 4px solid transparent;
    border-bottom: 1px solid #f8fafc;
}

.patient-item.selected {
    background-color: #eff6ff;
    border-left-color: #3b82f6;
}

.patient-avatar {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #e0e7ff;
    display: grid;
    place-items: center;
    color: #6366f1;
    font-weight: 600;
    font-size: 18px;
    flex-shrink: 0;
}

.patient-info {
    flex: 1;
    min-width: 0;
}

.patient-name {
    font-weight: 600;
    color: #1e293b;
    font-size: 15px;
    margin-bottom: 3px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.patient-meta {
    color: #64748b;
    font-size: 13px;
    font-weight: 400;
}

/* Right Panel - Patient Details */
.right-panel {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    border: 1px solid #f1f5f9;
}

.patient-details {
    padding: 28px;
    height: 100%;
    overflow-y: auto;
}

.select-patient-message {
    display: grid;
    place-items: center;
    min-height: 400px;
    text-align: center;
    color: #94a3b8;
}

.message-icon {
    font-size: 72px;
    line-height: 1;
    margin-bottom: 20px;
    opacity: 0.6;
}

.message-title {
    font-weight: 600;
    color: #1e293b;
    font-size: 22px;
    margin-bottom: 10px;
}

.message-subtitle {
    color: #64748b;
    font-size: 15px;
    max-width: 300px;
    line-height: 1.5;
}

/* Patient Details Content */
.patient-header {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 32px;
    padding-bottom: 24px;
    border-bottom: 2px solid #f1f5f9;
}

.patient-header-avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #e0e7ff;
    display: grid;
    place-items: center;
    color: #6366f1;
    font-weight: 600;
    font-size: 28px;
    flex-shrink: 0;
}

.patient-header-info {
    flex: 1;
    min-width: 0;
}

.patient-header-name {
    font-size: 28px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 6px;
    line-height: 1.2;
}

.patient-header-meta {
    color: #64748b;
    font-size: 16px;
    font-weight: 400;
}

.patient-header-actions {
    display: flex;
    gap: 12px;
    flex-shrink: 0;
}

.btn-edit-record {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

.btn-print {
    background: #10b981;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
}

/* Information Sections */
.info-section {
    margin-bottom: 32px;
}

.info-section-title {
    font-size: 18px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 2px solid #f1f5f9;
    position: relative;
}

.info-section-title::after {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 0;
    width: 40px;
    height: 2px;
    background: #3b82f6;
    border-radius: 1px;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}

.info-item {
    display: flex;
    flex-direction: column;
    background: #f8fafc;
    padding: 18px;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}

.info-label {
    color: #64748b;
    font-size: 11px;
    margin-bottom: 6px;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.info-value {
    color: #1e293b;
    font-size: 15px;
    font-weight: 500;
    line-height: 1.4;
}

/* Badges */
.badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    margin: 2px;
    border: 1px solid transparent;
}

.badge-red {
    background: #fef2f2;
    color: #dc2626;
    border-color: #fecaca;
}

.badge-yellow {
    background: #fffbeb;
    color: #d97706;
    border-color: #fed7aa;
}

.badge-orange {
    background: #fff7ed;
    color: #ea580c;
    border-color: #fed7aa;
}

/* Responsive Design */
@media (max-width: 1200px) {
    .split-panel {
        grid-template-columns: 320px 1fr;
        gap: 20px;
    }
}

@media (max-width: 1024px) {
    .split-panel {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .left-panel {
        order: 2;
    }
    
    .right-panel {
        order: 1;
    }
    
    .page-content {
        padding: 0 20px 20px;
    }
}

@media (max-width: 768px) {
    .header {
        padding: 20px;
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
    }
    
    .patient-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
    }
    
    .patient-header-actions {
        width: 100%;
        justify-content: stretch;
    }
    
    .btn-edit-record,
    .btn-print {
        flex: 1;
        justify-content: center;
    }
}
</style>

<script>
// Search functionality
document.getElementById('patientSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const patientItems = document.querySelectorAll('.patient-item');
    
    patientItems.forEach(item => {
        const patientName = item.querySelector('.patient-name').textContent.toLowerCase();
        const patientMeta = item.querySelector('.patient-meta').textContent.toLowerCase();
        
        const shouldShow = patientName.includes(searchTerm) || patientMeta.includes(searchTerm);
        item.style.display = shouldShow ? 'flex' : 'none';
    });
});

// Patient selection
function selectPatient(patientId, patientData) {
    // Remove selected class from all items
    document.querySelectorAll('.patient-item').forEach(item => {
        item.classList.remove('selected');
    });
    
    // Add selected class to clicked item
    event.currentTarget.classList.add('selected');
    
    // Display patient details
    displayPatientDetails(patientData);
}

// Display patient details
function displayPatientDetails(patient) {
    const detailsContainer = document.getElementById('patientDetails');
    
    // Calculate age
    let age = 'N/A';
    if (patient.dob) {
        const dob = new Date(patient.dob);
        const now = new Date();
        age = now.getFullYear() - dob.getFullYear();
    }
    
    detailsContainer.innerHTML = `
        <div class="patient-header">
            <div class="patient-header-avatar">👤</div>
            <div class="patient-header-info">
                <div class="patient-header-name">${patient.first_name} ${patient.last_name}</div>
                <div class="patient-header-meta">P${String(patient.id).padStart(3, '0')} • ${age} years old • ${patient.gender}</div>
            </div>
            <div class="patient-header-actions">
                <button class="btn-edit-record" onclick="editPatient(${patient.id})">
                    <span>✏️</span> Edit Record
                </button>
                <button class="btn-print" onclick="printPatient(${patient.id})">
                    <span>🖨️</span> Print
                </button>
            </div>
        </div>
        
        <div class="info-section">
            <div class="info-section-title">Basic Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Blood Type</div>
                    <div class="info-value">${patient.blood_type || 'N/A'}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Phone</div>
                    <div class="info-value">${patient.phone || 'N/A'}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Address</div>
                    <div class="info-value">${patient.address || 'N/A'}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Emergency Contact</div>
                    <div class="info-value">${patient.emergency_name || 'N/A'} - ${patient.emergency_phone || 'N/A'}</div>
                </div>
            </div>
        </div>
        
        <div class="info-section">
            <div class="info-section-title">Medical Information</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Allergies</div>
                    <div class="info-value">
                        ${patient.allergies ? patient.allergies.split(',').map(allergy => 
                            `<span class="badge badge-red">${allergy.trim()}</span>`
                        ).join('') : 'None'}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Medical Conditions</div>
                    <div class="info-value">
                        ${patient.medical_history ? patient.medical_history.split(',').map(condition => 
                            `<span class="badge badge-yellow">${condition.trim()}</span>`
                        ).join('') : 'None'}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Current Medications</div>
                    <div class="info-value">${patient.medications || 'None'}</div>
                </div>
            </div>
        </div>
        
        <div class="info-section">
            <div class="info-section-title">Recent Visits</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Last Visit</div>
                    <div class="info-value">${patient.last_visit || 'No visits'}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Attending Physician</div>
                    <div class="info-value">${patient.attending_physician || 'N/A'}</div>
                </div>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <a href="<?= site_url('patients/history') ?>" style="color: #3b82f6; text-decoration: none; font-weight: 500; font-size: 14px;">View Full History</a>
            </div>
        </div>
    `;
}

// Edit patient function
function editPatient(patientId) {
    window.location.href = `<?= site_url('patients/edit/') ?>${patientId}`;
}

// Print patient function
function printPatient(patientId) {
    window.open(`<?= site_url('patients/view/') ?>${patientId}?print=1`, '_blank');
}

// Auto-select first patient if available
document.addEventListener('DOMContentLoaded', function() {
    const firstPatient = document.querySelector('.patient-item');
    if (firstPatient) {
        const patientId = firstPatient.getAttribute('data-patient-id');
        const patientData = JSON.parse(firstPatient.getAttribute('onclick').match(/selectPatient\((\d+), (.+)\)/)[2]);
        selectPatient(patientId, patientData);
    }
});
</script>

<?php echo view('auth/partials/footer'); ?>
