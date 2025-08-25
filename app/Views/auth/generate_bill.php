<?php echo view('auth/partials/header', ['title' => 'Generate Bill']); ?>

<style>
/* Dashboard-style Bill Generation Styles */
.container { 
    display: flex; 
    min-height: 100vh 
}

/* Sidebar (kept from dashboard) */
.sidebar { 
    width: 250px; 
    background: linear-gradient(180deg,#2c3e50 0%, #34495e 100%); 
    color: #fff; 
    position: fixed; 
    height: 100vh; 
    overflow-y: auto; 
    z-index: 1000 
}

/* Main area */
.main-content { 
    flex: 1; 
    margin-left: 250px 
}

.topbar { 
    background: #fff; 
    padding: 16px 22px; 
    box-shadow: 0 2px 4px rgba(0,0,0,.08); 
    display: flex; 
    align-items: center; 
    justify-content: space-between 
}

.top-left { 
    display: flex; 
    flex-direction: column 
}

.top-title { 
    font-size: 20px; 
    color: #0f172a; 
    font-weight: 800 
}

.top-sub { 
    color: #64748b; 
    font-size: 12px; 
    margin-top: 2px 
}

.back-btn { 
    background: #6b7280; 
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
    transition: background-color 0.3s ease 
}

.back-btn:hover { 
    background: #4b5563 
}

/* Page content */
.page { 
    padding: 24px 26px 
}

/* Bill Form Container */
.bill-form-container {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0,0,0,.08);
    overflow: hidden;
    margin-bottom: 24px;
}

.form-section {
    padding: 20px;
    border-bottom: 1px solid #ecf0f1;
}

.form-section:last-child {
    border-bottom: none;
}

.section-title {
    font-size: 16px;
    font-weight: 800;
    color: #0f172a;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-input, .form-select, .form-textarea {
    padding: 12px 16px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    outline: none;
    transition: all 0.3s ease;
    background: #fff;
}

.form-input:focus, .form-select:focus, .form-textarea:focus {
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

.form-textarea {
    resize: vertical;
    min-height: 100px;
}

/* Services Section */
.services-section {
    background: #f8fafc;
    border-radius: 8px;
    padding: 20px;
    margin-top: 16px;
}

.service-item {
    background: white;
    border-radius: 8px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.service-item:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
}

.service-grid {
    display: grid;
    grid-template-columns: 2fr 1fr 1fr 1fr auto;
    gap: 16px;
    align-items: center;
}

.service-grid .form-group {
    margin-bottom: 0;
}

.add-service-btn {
    background: #10b981;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 16px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.add-service-btn:hover {
    background: #059669;
    transform: translateY(-1px);
}

.remove-service-btn {
    background: #ef4444;
    color: white;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.remove-service-btn:hover {
    background: #dc2626;
    transform: scale(1.05);
}

/* Total Section */
.total-section {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    color: white;
    padding: 24px;
    border-radius: 12px;
    margin-top: 24px;
}

.total-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    font-size: 14px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.total-row:last-child {
    border-bottom: none;
}

.total-row.grand-total {
    font-size: 18px;
    font-weight: 800;
    border-top: 2px solid rgba(255,255,255,0.2);
    padding-top: 16px;
    margin-top: 16px;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 16px;
    justify-content: flex-end;
    padding: 20px;
    background: #f8fafc;
}

.btn {
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    transition: all 0.3s ease;
    border: none;
}

.btn-secondary {
    background: #6b7280;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
    transform: translateY(-1px);
}

.btn-primary {
    background: #3498db;
    color: white;
}

.btn-primary:hover {
    background: #2980b9;
    transform: translateY(-1px);
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
    
    .form-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .service-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }
    
    .form-actions {
        flex-direction: column;
        padding: 16px;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}

/* Notification Styles */
.notification {
    position: fixed;
    top: 20px;
    right: 20px;
    padding: 16px 24px;
    border-radius: 12px;
    color: white;
    font-weight: 600;
    z-index: 10000;
    animation: slideIn 0.3s ease;
    box-shadow: 0 4px 16px rgba(0,0,0,0.2);
}

@keyframes slideIn {
    from { transform: translateX(100%); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

@keyframes slideOut {
    from { transform: translateX(0); opacity: 1; }
    to { transform: translateX(100%); opacity: 0; }
}
</style>

<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    
    <main class="main-content">
        <!-- Top bar -->
        <header class="topbar">
            <div class="top-left">
                <div class="top-title">Generate Bill</div>
                <div class="top-sub">Create professional bills and invoices for patients</div>
            </div>
            <a href="<?= site_url('billing') ?>" class="back-btn">
                <span>←</span> Back to Billing
            </a>
        </header>

        <div class="page">
            <div class="bill-form-container">
                <form id="billForm">
                    <!-- Patient Information -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <span>👤</span>
                            Patient Information
                        </h3>
                        
                        <!-- Info Note -->
                        <div style="background: #f0f9ff; border: 1px solid #0ea5e9; border-radius: 8px; padding: 12px; margin-bottom: 20px;">
                            <div style="display: flex; align-items: center; gap: 8px; color: #0c4a6e; font-size: 13px;">
                                <span>ℹ️</span>
                                <strong>Note:</strong> Insurance fields are now functional! You can select from PhilHealth, Maxicare, or Intellicare. 
                                PhilHealth categories include Indigent, Senior Citizen, PWD, and more.
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Patient Name</label>
                                <select class="form-select" id="patientSelect" required>
                                    <option value="">Select Patient</option>
                                    <?php if (!empty($patients)): ?>
                                        <?php foreach ($patients as $patient): ?>
                                            <option value="<?= $patient['id'] ?>"><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?> - ID: <?= esc($patient['id']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Patient ID</label>
                                <input type="text" class="form-input" id="patientId" readonly>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Contact Number</label>
                                <input type="text" class="form-input" id="contactNumber" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-input" id="email" readonly>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">PhilHealth Number</label>
                                <input type="text" class="form-input" id="philhealthNumber" placeholder="Enter PhilHealth number">
                            </div>
                            <div class="form-group">
                                <label class="form-label">PhilHealth Category</label>
                                <select class="form-select" id="philhealthCategory">
                                    <option value="">Select Category</option>
                                    <option value="Indigent">Indigent</option>
                                    <option value="Sponsored">Sponsored</option>
                                    <option value="Senior Citizen">Senior Citizen</option>
                                    <option value="PWD">PWD</option>
                                    <option value="OFW">OFW</option>
                                    <option value="Employed">Employed</option>
                                    <option value="Self-Employed">Self-Employed</option>
                                    <option value="Non-Working">Non-Working</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Insurance Provider</label>
                                <select class="form-select" id="insuranceProvider" onchange="updateInsuranceFields()">
                                    <option value="">Select Insurance Provider</option>
                                    <option value="PhilHealth">PhilHealth</option>
                                    <option value="Maxicare">Maxicare</option>
                                    <option value="Intellicare">Intellicare</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Insurance Policy Number</label>
                                <input type="text" class="form-input" id="insurancePolicyNumber" placeholder="Enter policy number">
                            </div>
                        </div>
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Emergency Contact</label>
                                <input type="text" class="form-input" id="emergencyContact" readonly>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Emergency Contact Number</label>
                                <input type="text" class="form-input" id="emergencyContactNumber" readonly>
                            </div>
                        </div>
                    </div>

                                         <!-- Bill Details -->
                     <div class="form-section">
                         <h3 class="section-title">
                             <span>📋</span>
                             Bill Details
                         </h3>
                         <div class="form-grid">
                             <div class="form-group">
                                 <label class="form-label">Bill Date</label>
                                 <input type="date" class="form-input" id="billDate" required>
                             </div>
                             <div class="form-group">
                                 <label class="form-label">Due Date</label>
                                 <input type="date" class="form-input" id="dueDate" required>
                             </div>
                         </div>
                         <div class="form-grid">
                             <div class="form-group">
                                 <label class="form-label">Payment Method</label>
                                 <select class="form-select" id="paymentMethod" onchange="updatePaymentStatus()" required>
                                     <option value="">Select Payment Method</option>
                                     <option value="Cash">Cash</option>
                                     <option value="Card">Card</option>
                                     <option value="Insurance">Insurance</option>
                                     <option value="Bank Transfer">Bank Transfer</option>
                                 </select>
                             </div>
                             <div class="form-group">
                                 <label class="form-label">Payment Status</label>
                                 <input type="text" class="form-input" id="paymentStatus" readonly style="background-color: #f3f4f6;">
                             </div>
                         </div>
                         <div class="form-group full-width">
                             <label class="form-label">Additional Notes</label>
                             <textarea class="form-textarea" id="notes" placeholder="Enter any special instructions, payment terms, or additional information..."></textarea>
                         </div>
                     </div>

                    <!-- Services -->
                    <div class="form-section">
                        <h3 class="section-title">
                            <span>💊</span>
                            Services & Charges
                        </h3>
                        <div class="services-section">
                            <div id="servicesList">
                                <!-- Service items will be added here -->
                            </div>
                            <button type="button" class="add-service-btn" id="addServiceBtn">
                                <span>➕</span> Add Service Item
                            </button>
                        </div>
                    </div>

                    <!-- Total Section -->
                    <div class="total-section">
                        <div class="total-row">
                            <span>Subtotal:</span>
                            <span id="subtotal">₱0.00</span>
                        </div>
                        <div class="total-row">
                            <span>Tax (12%):</span>
                            <span id="tax">₱0.00</span>
                        </div>
                        <div class="total-row">
                            <span>Discount:</span>
                            <span id="discount">₱0.00</span>
                        </div>
                        <div class="total-row grand-total">
                            <span>Total Amount:</span>
                            <span id="grandTotal">₱0.00</span>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="saveDraftBtn">
                            <span>💾</span> Save Draft
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <span>📄</span> Generate Bill
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<script>
// Enhanced services data with better categorization
const availableServices = [
    { id: 1, name: 'General Consultation', price: 1500, category: 'Consultation', description: 'Standard doctor consultation' },
    { id: 2, name: 'Specialist Consultation', price: 2500, category: 'Consultation', description: 'Specialist doctor consultation' },
    { id: 3, name: 'Laboratory Tests', price: 2500, category: 'Diagnostic', description: 'Complete blood count and basic tests' },
    { id: 4, name: 'X-Ray Imaging', price: 1200, category: 'Diagnostic', description: 'Standard X-ray examination' },
    { id: 5, name: 'MRI Scan', price: 8000, category: 'Diagnostic', description: 'Magnetic Resonance Imaging' },
    { id: 6, name: 'Minor Surgery', price: 25000, category: 'Procedure', description: 'Outpatient surgical procedure' },
    { id: 7, name: 'Major Surgery', price: 50000, category: 'Procedure', description: 'Inpatient surgical procedure' },
    { id: 8, name: 'Room Charges (per day)', price: 3000, category: 'Accommodation', description: 'Daily room accommodation' },
    { id: 9, name: 'ICU Room (per day)', price: 8000, category: 'Accommodation', description: 'Intensive care unit' },
    { id: 10, name: 'Medicines', price: 800, category: 'Pharmacy', description: 'Prescribed medications' },
    { id: 11, name: 'Emergency Care', price: 5000, category: 'Emergency', description: 'Emergency room treatment' },
    { id: 12, name: 'Physical Therapy', price: 2000, category: 'Therapy', description: 'Physical therapy session' },
    { id: 13, name: 'Dental Cleaning', price: 1500, category: 'Dental', description: 'Professional dental cleaning' },
    { id: 14, name: 'Eye Examination', price: 1000, category: 'Ophthalmology', description: 'Comprehensive eye exam' }
];

// Enhanced patients data - will be populated from PHP
const patients = <?= json_encode($patients ?? []) ?>;
console.log('Patients data loaded:', patients);

let serviceCounter = 0;
let services = [];

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
    // Set default dates
    const today = new Date();
    const dueDate = new Date();
    dueDate.setDate(today.getDate() + 30);
    
    document.getElementById('billDate').value = today.toISOString().split('T')[0];
    document.getElementById('dueDate').value = dueDate.toISOString().split('T')[0];

    // Add event listeners
    document.getElementById('patientSelect').addEventListener('change', updatePatientInfo);
    document.getElementById('addServiceBtn').addEventListener('click', addService);
    document.getElementById('saveDraftBtn').addEventListener('click', saveDraft);
    document.getElementById('billForm').addEventListener('submit', generateBill);

    // Add first service row
    addService();
    
    // Initialize insurance fields
    updateInsuranceFields();
    
    // Initialize payment status
    updatePaymentStatus();
});

// Update payment status based on payment method
function updatePaymentStatus() {
    const paymentMethod = document.getElementById('paymentMethod').value;
    const paymentStatus = document.getElementById('paymentStatus');
    
    if (paymentMethod === 'Cash') {
        paymentStatus.value = 'Paid';
        paymentStatus.style.backgroundColor = '#dcfce7';
        paymentStatus.style.color = '#166534';
    } else if (paymentMethod === 'Card' || paymentMethod === 'Bank Transfer') {
        paymentStatus.value = 'Pending';
        paymentStatus.style.backgroundColor = '#fef3c7';
        paymentStatus.style.color = '#92400e';
    } else if (paymentMethod === 'Insurance') {
        paymentStatus.value = 'Pending';
        paymentStatus.style.backgroundColor = '#fef3c7';
        paymentStatus.style.color = '#92400e';
    } else {
        paymentStatus.value = 'Not Selected';
        paymentStatus.style.backgroundColor = '#f3f4f6';
        paymentStatus.style.color = '#6b7280';
    }
}

// Update insurance fields based on provider selection
function updateInsuranceFields() {
    const insuranceProvider = document.getElementById('insuranceProvider').value;
    const philhealthGroup = document.getElementById('philhealthNumber').closest('.form-grid');
    const philhealthCategoryGroup = document.getElementById('philhealthCategory').closest('.form-grid');
    
    if (insuranceProvider === 'PhilHealth') {
        // Show PhilHealth fields
        philhealthGroup.style.display = 'grid';
        philhealthCategoryGroup.style.display = 'grid';
        
        // Make PhilHealth fields required
        document.getElementById('philhealthNumber').required = true;
        document.getElementById('philhealthCategory').required = true;
        
        // Clear other insurance fields
        document.getElementById('insurancePolicyNumber').value = '';
        document.getElementById('insurancePolicyNumber').required = false;
    } else if (insuranceProvider === 'Maxicare' || insuranceProvider === 'Intellicare') {
        // Hide PhilHealth fields
        philhealthGroup.style.display = 'none';
        philhealthCategoryGroup.style.display = 'none';
        
        // Make PhilHealth fields not required
        document.getElementById('philhealthNumber').required = false;
        document.getElementById('philhealthCategory').required = false;
        
        // Make policy number required
        document.getElementById('insurancePolicyNumber').required = true;
        
        // Clear PhilHealth fields
        document.getElementById('philhealthNumber').value = '';
        document.getElementById('philhealthCategory').value = '';
    } else {
        // No insurance selected
        philhealthGroup.style.display = 'grid';
        philhealthCategoryGroup.style.display = 'grid';
        
        // Make all fields not required
        document.getElementById('philhealthNumber').required = false;
        document.getElementById('philhealthCategory').required = false;
        document.getElementById('insurancePolicyNumber').required = false;
    }
    
    // Recalculate totals when insurance changes
    calculateTotals();
}

// Update patient information when selected
function updatePatientInfo() {
    const patientId = document.getElementById('patientSelect').value;
    console.log('Selected patient ID:', patientId);
    console.log('Available patients:', patients);
    
    if (patientId) {
        // Find the patient by ID in the patients array
        const patient = patients.find(p => p.id == patientId);
        console.log('Found patient:', patient);
        
        if (patient) {
            document.getElementById('patientId').value = patient.id || patientId;
            document.getElementById('contactNumber').value = patient.phone || '';
            document.getElementById('email').value = patient.email || '';
            document.getElementById('philhealthNumber').value = patient.philhealth_number || '';
            document.getElementById('philhealthCategory').value = patient.philhealth_category || '';
            document.getElementById('insuranceProvider').value = patient.insurance_provider || '';
            document.getElementById('insurancePolicyNumber').value = patient.insurance_policy_number || '';
            document.getElementById('emergencyContact').value = patient.emergency_name || '';
            document.getElementById('emergencyContactNumber').value = patient.emergency_phone || '';
        } else {
            console.log('Patient not found in array');
            // Clear all fields
            clearPatientFields();
        }
    } else {
        // Clear all fields
        clearPatientFields();
    }
}

// Helper function to clear patient fields
function clearPatientFields() {
    document.getElementById('patientId').value = '';
    document.getElementById('contactNumber').value = '';
    document.getElementById('email').value = '';
    document.getElementById('philhealthNumber').value = '';
    document.getElementById('philhealthCategory').value = '';
    document.getElementById('insuranceProvider').value = '';
    document.getElementById('insurancePolicyNumber').value = '';
    document.getElementById('emergencyContact').value = '';
    document.getElementById('emergencyContactNumber').value = '';
}

// Add new service row with enhanced UI
function addService() {
    serviceCounter++;
    const serviceId = `service_${serviceCounter}`;
    
    const serviceRow = document.createElement('div');
    serviceRow.className = 'service-item';
    serviceRow.id = serviceId;
    
    serviceRow.innerHTML = `
        <div class="service-grid">
            <div class="form-group">
                <label class="form-label">Service</label>
                <select class="form-select service-select" onchange="updateServicePrice('${serviceId}')" required>
                    <option value="">Select a service...</option>
                    ${availableServices.map(service => 
                        `<option value="${service.id}" data-price="${service.price}" data-description="${service.description}">
                            ${service.name} - ₱${service.price.toLocaleString()}
                        </option>`
                    ).join('')}
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Quantity</label>
                <input type="number" class="form-input" placeholder="Qty" min="1" value="1" onchange="updateServiceTotal('${serviceId}')" required>
            </div>
            <div class="form-group">
                <label class="form-label">Unit Price</label>
                <input type="number" class="form-input service-price" placeholder="₱0.00" readonly>
            </div>
            <div class="form-group">
                <label class="form-label">Total</label>
                <input type="number" class="form-input service-total" placeholder="₱0.00" readonly>
            </div>
            <button type="button" class="remove-service-btn" onclick="removeService('${serviceId}')" title="Remove Service">
                🗑️
            </button>
        </div>
    `;
    
    document.getElementById('servicesList').appendChild(serviceRow);
    services.push(serviceId);
}

// Update service price when service is selected
function updateServicePrice(serviceId) {
    const serviceRow = document.getElementById(serviceId);
    const serviceSelect = serviceRow.querySelector('.service-select');
    const priceInput = serviceRow.querySelector('.service-price');
    const qtyInput = serviceRow.querySelector('input[type="number"]');
    
    if (serviceSelect.value) {
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price);
        priceInput.value = price;
        updateServiceTotal(serviceId);
    } else {
        priceInput.value = '';
        serviceRow.querySelector('.service-total').value = '';
    }
    calculateTotals();
}

// Update service total when quantity changes
function updateServiceTotal(serviceId) {
    const serviceRow = document.getElementById(serviceId);
    const priceInput = serviceRow.querySelector('.service-price');
    const qtyInput = serviceRow.querySelector('input[type="number"]');
    const totalInput = serviceRow.querySelector('.service-total');
    
    if (priceInput.value && qtyInput.value) {
        const price = parseFloat(priceInput.value);
        const qty = parseFloat(qtyInput.value);
        const total = price * qty;
        totalInput.value = total;
    }
    calculateTotals();
}

// Remove service row with confirmation
function removeService(serviceId) {
    if (services.length > 1) {
        if (confirm('Are you sure you want to remove this service?')) {
            const serviceRow = document.getElementById(serviceId);
            serviceRow.remove();
            services = services.filter(id => id !== serviceId);
            calculateTotals();
        }
    } else {
        alert('At least one service is required.');
    }
}

// Calculate totals with enhanced formatting
function calculateTotals() {
    let subtotal = 0;
    
    services.forEach(serviceId => {
        const serviceRow = document.getElementById(serviceId);
        if (serviceRow) {
            const totalInput = serviceRow.querySelector('.service-total');
            if (totalInput.value) {
                subtotal += parseFloat(totalInput.value);
            }
        }
    });
    
    const tax = subtotal * 0.12;
    
    // Calculate insurance discount
    let discount = 0;
    const insuranceProvider = document.getElementById('insuranceProvider').value;
    if (insuranceProvider === 'PhilHealth') {
        discount = subtotal * 0.20; // 20% discount for PhilHealth
    } else if (insuranceProvider === 'Maxicare') {
        discount = subtotal * 0.15; // 15% discount for Maxicare
    } else if (insuranceProvider === 'Intellicare') {
        discount = subtotal * 0.10; // 10% discount for Intellicare
    }
    
    document.getElementById('subtotal').textContent = `₱${subtotal.toLocaleString()}`;
    document.getElementById('tax').textContent = `₱${tax.toLocaleString()}`;
    document.getElementById('discount').textContent = `₱${discount.toLocaleString()}`;
    document.getElementById('grandTotal').textContent = `₱${(subtotal + tax - discount).toLocaleString()}`;
}

// Save draft with enhanced feedback
function saveDraft() {
    const saveBtn = document.getElementById('saveDraftBtn');
    const originalText = saveBtn.innerHTML;
    
    saveBtn.innerHTML = '<span>⏳</span> Saving...';
    saveBtn.disabled = true;
    
    // Simulate saving
    setTimeout(() => {
        saveBtn.innerHTML = '<span>✅</span> Draft Saved!';
        saveBtn.style.background = '#10b981';
        
        setTimeout(() => {
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
            saveBtn.style.background = '';
        }, 2000);
    }, 1000);
}

// Generate bill with enhanced validation and feedback
function generateBill(e) {
    e.preventDefault();
    
    // Validate form
    const patientId = document.getElementById('patientSelect').value;
    const billDate = document.getElementById('billDate').value;
    const dueDate = document.getElementById('dueDate').value;
    
    if (!patientId) {
        showNotification('Please select a patient', 'error');
        return;
    }
    
    if (!billDate || !dueDate) {
        showNotification('Please fill in all required dates', 'error');
        return;
    }
    
    // Check if services are added
    let hasServices = false;
    let servicesData = [];
    services.forEach(serviceId => {
        const serviceRow = document.getElementById(serviceId);
        if (serviceRow && serviceRow.querySelector('.service-select').value) {
            hasServices = true;
            
            // Collect service data
            const serviceSelect = serviceRow.querySelector('.service-select');
            const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
            const serviceName = selectedOption.textContent.split(' - ')[0];
            const quantity = serviceRow.querySelector('input[type="number"]').value;
            const price = parseFloat(serviceRow.querySelector('.service-price').value.replace(/,/g, ''));
            const total = parseFloat(serviceRow.querySelector('.service-total').value.replace(/,/g, ''));
            
            servicesData.push({
                name: serviceName,
                quantity: quantity,
                price: price,
                total: total
            });
        }
    });
    
    if (!hasServices) {
        showNotification('Please add at least one service', 'error');
        return;
    }
    
    // Get patient information
    const patient = patients.find(p => p.id == patientId);
    if (!patient) {
        showNotification('Patient information not found', 'error');
        return;
    }
    
    // Get insurance information
    const insuranceProvider = document.getElementById('insuranceProvider').value;
    const insuranceDetails = {};
    
    if (insuranceProvider === 'PhilHealth') {
        insuranceDetails.philhealth_number = document.getElementById('philhealthNumber').value;
        insuranceDetails.philhealth_category = document.getElementById('philhealthCategory').value;
    } else if (insuranceProvider === 'Maxicare' || insuranceProvider === 'Intellicare') {
        insuranceDetails.policy_number = document.getElementById('insurancePolicyNumber').value;
    }
    
    // Get payment method and status
    const paymentMethod = document.getElementById('paymentMethod').value;
    const paymentStatus = document.getElementById('paymentStatus').value;
    
    if (!paymentMethod) {
        showNotification('Please select a payment method', 'error');
        return;
    }
    
    // Prepare bill data
    const billData = {
        patient_id: patientId,
        patient_name: patient ? (patient.first_name + ' ' + patient.last_name) : '',
        bill_date: billDate,
        due_date: dueDate,
        services: JSON.stringify(servicesData),
        subtotal: parseFloat(document.getElementById('subtotal').textContent.replace('₱', '').replace(/,/g, '')),
        tax: parseFloat(document.getElementById('tax').textContent.replace('₱', '').replace(/,/g, '')),
        discount: parseFloat(document.getElementById('discount').textContent.replace('₱', '').replace(/,/g, '')),
        total_amount: parseFloat(document.getElementById('grandTotal').textContent.replace('₱', '').replace(/,/g, '')),
        notes: document.getElementById('notes').value,
        insurance_provider: insuranceProvider,
        insurance_details: JSON.stringify(insuranceDetails),
        payment_method: paymentMethod,
        status: paymentStatus
    };
    
    console.log('Sending bill data:', billData);
    
    // Send bill data to server
    console.log('Sending request to:', '<?= site_url('billing/create') ?>');
    
    // Get CSRF token if available
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    
    fetch('<?= site_url('billing/create') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            ...(csrfToken && { 'X-CSRF-TOKEN': csrfToken })
        },
        body: JSON.stringify(billData)
    })
    .then(response => {
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            showNotification(`Bill generated successfully! Bill ID: ${data.bill_id}`, 'success');
            
            // Reset form after delay
            setTimeout(() => {
                document.getElementById('billForm').reset();
                document.getElementById('servicesList').innerHTML = '';
                services = [];
                serviceCounter = 0;
                addService();
                calculateTotals();
                
                // Reset patient info
                document.getElementById('patientId').value = '';
                document.getElementById('contactNumber').value = '';
                document.getElementById('email').value = '';
                document.getElementById('philhealthNumber').value = '';
                document.getElementById('philhealthCategory').value = '';
                document.getElementById('insuranceProvider').value = '';
                document.getElementById('insurancePolicyNumber').value = '';
                document.getElementById('emergencyContact').value = '';
                document.getElementById('emergencyContactNumber').value = '';
                
                // Reset insurance field display
                updateInsuranceFields();
                
                // Reset payment fields
                document.getElementById('paymentMethod').value = '';
                updatePaymentStatus();
                
                // Redirect to billing dashboard after 2 seconds
                setTimeout(() => {
                    window.location.href = '<?= site_url('billing') ?>';
                }, 2000);
            }, 2000);
        } else {
            showNotification(data.message || 'Error generating bill', 'error');
        }
    })
    .catch(error => {
        console.error('Fetch Error:', error);
        showNotification('Error generating bill. Please try again.', 'error');
    });
}

// Enhanced notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());
    
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    
    // Set background based on type
    switch(type) {
        case 'success':
            notification.style.background = '#10b981';
            break;
        case 'error':
            notification.style.background = '#ef4444';
            break;
        default:
            notification.style.background = '#3498db';
    }
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Auto-remove after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}
</script>

<?php echo view('auth/partials/footer'); ?>

<?php echo view('auth/partials/footer'); ?>
