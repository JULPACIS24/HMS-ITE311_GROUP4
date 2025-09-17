let currentConsultationId = null;
let currentAppointmentId = null;
let currentPatientId = null;

// Filter tabs functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const status = this.dataset.status;
            filterConsultations(status);
        });
    });

    // New Consultation Modal
    const newConsultationBtn = document.getElementById('newConsultationBtn');
    if (newConsultationBtn) {
        newConsultationBtn.addEventListener('click', function() {
            openNewConsultationModal();
        });
    }

    // Save consultation form
    const consultationForm = document.getElementById('consultationForm');
    if (consultationForm) {
        consultationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            saveConsultation();
        });
    }

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const consultationCards = document.querySelectorAll('.consultation-card');
            
            consultationCards.forEach(card => {
                const patientName = card.querySelector('.patient-details h4').textContent.toLowerCase();
                const patientId = card.querySelector('.patient-id').textContent.toLowerCase();
                
                if (patientName.includes(searchTerm) || patientId.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const consultationModal = document.getElementById('consultationModal');
        const consultationDetailsModal = document.getElementById('consultationDetailsModal');
        
        if (event.target === consultationModal) {
            closeConsultationModal();
        }
        if (event.target === consultationDetailsModal) {
            closeConsultationDetailsModal();
        }
    }
});

function filterConsultations(status) {
    // This would typically make an AJAX call to filter consultations
    console.log('Filtering consultations by status:', status);
}

function openNewConsultationModal() {
    document.getElementById('consultationModal').style.display = 'block';
    // Reset form
    document.getElementById('consultationForm').reset();
    // Set default values
    document.getElementById('bloodPressure').value = '120/80';
    document.getElementById('heartRate').value = '72 bpm';
    document.getElementById('temperature').value = '36.5°C';
    document.getElementById('weight').value = '70 kg';
    document.getElementById('consultationDateTime').value = new Date().toISOString().slice(0, 16);
}

function closeConsultationModal() {
    document.getElementById('consultationModal').style.display = 'none';
}

// Start consultation from appointment
function startConsultation(appointmentId, patientId) {
    currentAppointmentId = appointmentId;
    currentPatientId = patientId;
    
    // Get appointment details and populate form
    fetch(`/scheduling/getDoctorAppointments/${appointmentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const appointment = data.appointment;
                document.getElementById('patientName').value = appointment.patient_name;
                document.getElementById('patientId').value = appointment.patient_id_formatted || `P-${new Date().getFullYear()}-${String(appointment.id).padStart(3, '0')}`;
                document.getElementById('consultationDateTime').value = appointment.date_time.replace(' ', 'T');
                document.getElementById('consultationType').value = appointment.type || 'Initial Consultation';
                
                openNewConsultationModal();
            }
        })
        .catch(error => {
            console.error('Error fetching appointment details:', error);
            alert('Error loading appointment details');
        });
}

function saveConsultation() {
    if (currentAppointmentId && currentPatientId) {
        // Start consultation
        const formData = new FormData();
        formData.append('appointment_id', currentAppointmentId);
        formData.append('patient_id', currentPatientId);
        
        fetch('/doctor/consultations/start', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Consultation started successfully!');
                closeConsultationModal();
                location.reload(); // Refresh to show new consultation
            } else {
                alert(data.message || 'Error starting consultation');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error starting consultation');
        });
    } else {
        // Create new consultation without appointment
        const form = document.getElementById('consultationForm');
        const formData = new FormData(form);
        formData.append('doctor_id', document.querySelector('meta[name="user-id"]').getAttribute('content'));
        
        fetch('/doctor/consultations/save', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Consultation saved successfully!');
                closeConsultationModal();
                location.reload();
            } else {
                alert(data.message || 'Error saving consultation');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving consultation');
        });
    }
}

// View consultation details
function viewConsultation(consultationId) {
    fetch(`/doctor/consultations/details/${consultationId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayConsultationDetails(data.consultation);
                document.getElementById('consultationDetailsModal').style.display = 'block';
            } else {
                alert(data.message || 'Error loading consultation details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading consultation details');
        });
}

function displayConsultationDetails(consultation) {
    const content = document.getElementById('consultationDetailsContent');
    content.innerHTML = `
        <div class="consultation-details-view">
            <div class="detail-section">
                <h3>Patient Information</h3>
                <p><strong>Name:</strong> ${consultation.patient_name}</p>
                <p><strong>ID:</strong> ${consultation.patient_id_formatted}</p>
                <p><strong>Type:</strong> ${consultation.consultation_type}</p>
            </div>
            
            <div class="detail-section">
                <h3>Consultation Details</h3>
                <p><strong>Date:</strong> ${new Date(consultation.date_time).toLocaleDateString()}</p>
                <p><strong>Time:</strong> ${new Date(consultation.date_time).toLocaleTimeString()}</p>
                <p><strong>Duration:</strong> ${consultation.duration} minutes</p>
                <p><strong>Status:</strong> <span class="status-badge status-${consultation.status.toLowerCase().replace(' ', '-')}">${consultation.status}</span></p>
            </div>
            
            ${consultation.chief_complaint ? `
            <div class="detail-section">
                <h3>Chief Complaint</h3>
                <p>${consultation.chief_complaint}</p>
            </div>
            ` : ''}
            
            ${consultation.history_of_present_illness ? `
            <div class="detail-section">
                <h3>History of Present Illness</h3>
                <p>${consultation.history_of_present_illness}</p>
            </div>
            ` : ''}
            
            ${consultation.physical_examination ? `
            <div class="detail-section">
                <h3>Physical Examination</h3>
                <p>${consultation.physical_examination}</p>
            </div>
            ` : ''}
            
            ${consultation.diagnosis ? `
            <div class="detail-section">
                <h3>Diagnosis</h3>
                <p>${consultation.diagnosis}</p>
            </div>
            ` : ''}
            
            ${consultation.treatment_plan ? `
            <div class="detail-section">
                <h3>Treatment Plan</h3>
                <p>${consultation.treatment_plan}</p>
            </div>
            ` : ''}
        </div>
    `;
    
    currentConsultationId = consultation.id;
}

function closeConsultationDetailsModal() {
    document.getElementById('consultationDetailsModal').style.display = 'none';
}

function editConsultation(consultationId) {
    // Redirect to edit page or open edit modal
    console.log('Edit consultation:', consultationId);
}

function continueConsultation(consultationId) {
    // Continue existing consultation
    console.log('Continue consultation:', consultationId);
}

function managePrescriptions(consultationId) {
    // Redirect to prescriptions page
    window.location.href = `/doctor/prescriptions?consultation=${consultationId}`;
}

function editConsultationFromDetails() {
    if (currentConsultationId) {
        editConsultation(currentConsultationId);
    }
}
