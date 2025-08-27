// Global variables
let currentConsultationId = null;
let currentAppointmentId = null;
let currentPatientId = null;

console.log('Doctor consultations JS file loaded successfully!');

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing consultation page...');
    
    // Initialize event listeners
    initializeEventListeners();
    
    // Set current date and time for consultation
    const now = new Date();
    const dateTimeString = now.toISOString().slice(0, 16);
    const dateTimeInput = document.getElementById('consultationDateTime');
    if (dateTimeInput) {
        dateTimeInput.value = dateTimeString;
    }
});

// Initialize all event listeners
function initializeEventListeners() {
    console.log('Initializing event listeners...');
    
    // Filter tabs
    const filterTabs = document.querySelectorAll('.tab-btn');
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            filterConsultations(this.dataset.filter);
        });
    });

    // New Consultation button - FIXED: Use onclick attribute instead of event listener
    console.log('Looking for New Consultation button...');
    const newConsultationBtn = document.querySelector('.btn-primary');
    console.log('Found button:', newConsultationBtn);
    
    // Consultation form submission
    const consultationForm = document.getElementById('consultationForm');
    if (consultationForm) {
        console.log('Consultation form found, adding submit listener');
        consultationForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submitted, calling saveConsultation');
            saveConsultation();
        });
    } else {
        console.error('Consultation form not found during initialization');
    }

    // Close modal when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal')) {
            closeConsultationModal();
            closeConsultationDetailsModal();
        }
    });
}

// Filter consultations
function filterConsultations(filter) {
    const consultationCards = document.querySelectorAll('.consultation-card');
    
    consultationCards.forEach(card => {
        const status = card.dataset.status;
        
        if (filter === 'all' || status === filter) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Open new consultation modal - FIXED: This function is called by onclick
function openNewConsultationModal() {
    console.log('Opening new consultation modal...');
    const modal = document.getElementById('consultationModal');
    if (modal) {
        modal.style.display = 'flex';
        console.log('Modal opened successfully');
        
        // Clear form if not from appointment
        if (!currentAppointmentId) {
            clearConsultationForm();
        }
    } else {
        console.error('Modal not found!');
    }
}

// Close consultation modal
function closeConsultationModal() {
    const modal = document.getElementById('consultationModal');
    if (modal) {
        modal.style.display = 'none';
        clearConsultationForm();
        resetGlobalVariables();
    }
}

// Clear consultation form
function clearConsultationForm() {
    const form = document.getElementById('consultationForm');
    if (form) {
        form.reset();
        
        // Set default values
        const bloodPressure = document.getElementById('bloodPressure');
        const heartRate = document.getElementById('heartRate');
        const temperature = document.getElementById('temperature');
        const weight = document.getElementById('weight');
        const dateTime = document.getElementById('consultationDateTime');
        
        if (bloodPressure) bloodPressure.value = '120/80';
        if (heartRate) heartRate.value = '72 bpm';
        if (temperature) temperature.value = '36.5°C';
        if (weight) weight.value = '70 kg';
        
        // Set current date and time
        if (dateTime) {
            const now = new Date();
            const dateTimeString = now.toISOString().slice(0, 16);
            dateTime.value = dateTimeString;
        }
    }
}

// Reset global variables
function resetGlobalVariables() {
    currentConsultationId = null;
    currentAppointmentId = null;
    currentPatientId = null;
}

// Start consultation from appointment
function startConsultation(appointmentId, patientId) {
    currentAppointmentId = appointmentId;
    currentPatientId = patientId;
    
    // Fetch appointment details
    fetch(`/doctor/appointments/${appointmentId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateConsultationForm(data.appointment);
                openNewConsultationModal();
            } else {
                alert('Error loading appointment details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading appointment details');
        });
}

// Populate consultation form with appointment data
function populateConsultationForm(appointment) {
    const patientName = document.getElementById('patientName');
    const patientId = document.getElementById('patientId');
    const dateTime = document.getElementById('consultationDateTime');
    
    if (patientName) patientName.value = appointment.patient_name || '';
    if (patientId) patientId.value = appointment.patient_id || '';
    
    // Set appointment date and time
    if (dateTime && appointment.date_time) {
        const appointmentDate = new Date(appointment.date_time);
        const dateTimeString = appointmentDate.toISOString().slice(0, 16);
        dateTime.value = dateTimeString;
    }
}

// Save consultation
function saveConsultation() {
    console.log('saveConsultation function called');
    
    const form = document.getElementById('consultationForm');
    if (!form) {
        console.error('Consultation form not found!');
        alert('Form not found. Please refresh the page and try again.');
        return;
    }
    
    const formData = new FormData(form);
    
    // Get selected patient info
    const patientSelect = document.getElementById('patientSelect');
    const patientName = document.getElementById('patientName');
    const patientId = document.getElementById('patientId');
    
    console.log('Patient select value:', patientSelect?.value);
    console.log('Patient name value:', patientName?.value);
    console.log('Patient ID value:', patientId?.value);
    
    if (!patientSelect || !patientSelect.value) {
        alert('Please select a patient first!');
        return;
    }
    
    // Add patient info to form data
    formData.append('appointment_id', patientSelect.value);
    formData.append('patient_name', patientName.value);
    
    // Extract the numeric patient ID from the formatted ID (P002 -> 2)
    const patientIdValue = patientId.value;
    if (patientIdValue && patientIdValue.startsWith('P')) {
        const numericId = patientIdValue.substring(1); // Remove 'P' prefix
        formData.append('patient_id', numericId);
    } else {
        formData.append('patient_id', patientIdValue);
    }
    
    // Log form data for debugging
    console.log('Form data being sent:');
    for (let [key, value] of formData.entries()) {
        console.log(key + ': ' + value);
    }
    
    // Show loading state
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = 'Saving...';
    submitBtn.disabled = true;
    
    // Send to server
    fetch('/doctor/consultations/save', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        
        if (data.success) {
            alert('Consultation saved successfully!');
            closeConsultationModal();
            // Reload page to show new consultation
            location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to save consultation'));
        }
    })
    .catch(error => {
        console.error('Error details:', error);
        alert('Error saving consultation. Please try again. Check console for details.');
    })
    .finally(() => {
        // Reset button
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
}

// View consultation details
function viewConsultation(consultationId) {
    fetch(`/doctor/consultations/details/${consultationId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                displayConsultationDetails(data.consultation);
                openConsultationDetailsModal();
            } else {
                alert('Error loading consultation details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading consultation details');
        });
}

// Display consultation details in modal
function displayConsultationDetails(consultation) {
    const content = document.getElementById('consultationDetailsContent');
    
    content.innerHTML = `
        <div class="consultation-details-view">
            <div class="detail-section">
                <h3>Patient Information</h3>
                <p><strong>Name:</strong> ${consultation.patient_name}</p>
                <p><strong>ID:</strong> ${consultation.patient_id}</p>
            </div>
            
            <div class="detail-section">
                <h3>Consultation Details</h3>
                <p><strong>Type:</strong> ${consultation.consultation_type}</p>
                <p><strong>Date:</strong> ${new Date(consultation.consultation_date).toLocaleDateString()}</p>
                <p><strong>Duration:</strong> ${consultation.duration} minutes</p>
                <p><strong>Status:</strong> ${consultation.status}</p>
            </div>
            
            <div class="detail-section">
                <h3>Vital Signs</h3>
                <p><strong>Blood Pressure:</strong> ${consultation.blood_pressure}</p>
                <p><strong>Heart Rate:</strong> ${consultation.heart_rate}</p>
                <p><strong>Temperature:</strong> ${consultation.temperature}</p>
                <p><strong>Weight:</strong> ${consultation.weight}</p>
            </div>
            
            <div class="detail-section">
                <h3>Medical Assessment</h3>
                <p><strong>Chief Complaint:</strong></p>
                <p>${consultation.chief_complaint || 'Not specified'}</p>
                
                <p><strong>History of Present Illness:</strong></p>
                <p>${consultation.history_of_present_illness || 'Not specified'}</p>
                
                <p><strong>Physical Examination:</strong></p>
                <p>${consultation.physical_examination || 'Not specified'}</p>
            </div>
            
            <div class="detail-section">
                <h3>Diagnosis & Treatment</h3>
                <p><strong>Diagnosis:</strong></p>
                <p>${consultation.diagnosis || 'Not specified'}</p>
                
                <p><strong>Treatment Plan:</strong></p>
                <p>${consultation.treatment_plan || 'Not specified'}</p>
                
                <p><strong>Follow-up Date:</strong> ${consultation.follow_up_date || 'Not scheduled'}</p>
                
                <p><strong>Follow-up Notes:</strong></p>
                <p>${consultation.follow_up_notes || 'Not specified'}</p>
            </div>
        </div>
    `;
}

// Open consultation details modal
function openConsultationDetailsModal() {
    const modal = document.getElementById('consultationDetailsModal');
    if (modal) {
        modal.style.display = 'flex';
    }
}

// Close consultation details modal
function closeConsultationDetailsModal() {
    const modal = document.getElementById('consultationDetailsModal');
    if (modal) {
        modal.style.display = 'none';
    }
}

// Continue consultation (edit existing)
function continueConsultation(consultationId) {
    currentConsultationId = consultationId;
    
    fetch(`/doctor/consultations/details/${consultationId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                populateConsultationFormForEdit(data.consultation);
                openNewConsultationModal();
            } else {
                alert('Error loading consultation details');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading consultation details');
        });
}

// Populate form for editing
function populateConsultationFormForEdit(consultation) {
    const patientName = document.getElementById('patientName');
    const patientId = document.getElementById('patientId');
    const consultationType = document.getElementById('consultationType');
    const dateTime = document.getElementById('consultationDateTime');
    const bloodPressure = document.getElementById('bloodPressure');
    const heartRate = document.getElementById('heartRate');
    const temperature = document.getElementById('temperature');
    const weight = document.getElementById('weight');
    const chiefComplaint = document.getElementById('chiefComplaint');
    const historyOfPresentIllness = document.getElementById('historyOfPresentIllness');
    const physicalExamination = document.getElementById('physicalExamination');
    const diagnosis = document.getElementById('diagnosis');
    const treatmentPlan = document.getElementById('treatmentPlan');
    const followUpDate = document.getElementById('followUpDate');
    const followUpNotes = document.getElementById('followUpNotes');
    
    if (patientName) patientName.value = consultation.patient_name || '';
    if (patientId) patientId.value = consultation.patient_id || '';
    if (consultationType) consultationType.value = consultation.consultation_type || 'Initial Consultation';
    if (dateTime && consultation.consultation_date) {
        const dateTimeString = new Date(consultation.consultation_date).toISOString().slice(0, 16);
        dateTime.value = dateTimeString;
    }
    if (bloodPressure) bloodPressure.value = consultation.blood_pressure || '120/80';
    if (heartRate) heartRate.value = consultation.heart_rate || '72 bpm';
    if (temperature) temperature.value = consultation.temperature || '36.5°C';
    if (weight) weight.value = consultation.weight || '70 kg';
    if (chiefComplaint) chiefComplaint.value = consultation.chief_complaint || '';
    if (historyOfPresentIllness) historyOfPresentIllness.value = consultation.history_of_present_illness || '';
    if (physicalExamination) physicalExamination.value = consultation.physical_examination || '';
    if (diagnosis) diagnosis.value = consultation.diagnosis || '';
    if (treatmentPlan) treatmentPlan.value = consultation.treatment_plan || '';
    if (followUpDate) followUpDate.value = consultation.follow_up_date || '';
    if (followUpNotes) followUpNotes.value = consultation.follow_up_notes || '';
}

// Edit consultation from details modal
function editConsultationFromDetails() {
    closeConsultationDetailsModal();
    continueConsultation(currentConsultationId);
}

// Placeholder functions for future features
function editConsultation(consultationId) {
    continueConsultation(consultationId);
}

function managePrescriptions(consultationId) {
    alert('Prescription management feature coming soon!');
}
