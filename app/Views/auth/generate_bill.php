<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Bill - San Miguel HMS</title>
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
            transition: background-color 0.3s ease;
        }

        .back-btn:hover {
            background: #4b5563;
        }

        /* Page Content */
        .page-content {
            padding: 30px;
        }

        /* Form Container */
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            max-width: 800px;
            margin: 0 auto;
        }

        .form-header {
            padding: 20px;
            border-bottom: 1px solid #ecf0f1;
            background: #f8fafc;
        }

        .form-title {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
        }

        .form-body {
            padding: 30px;
        }

        .form-section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 16px;
            padding-bottom: 8px;
            border-bottom: 2px solid #e5e7eb;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
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
            font-size: 14px;
        }

        .form-input {
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s ease;
        }

        .form-input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-select {
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            background: white;
            cursor: pointer;
        }

        .form-textarea {
            padding: 12px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            resize: vertical;
            min-height: 100px;
        }

        /* Services Section */
        .services-section {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 20px;
            background: #f9fafb;
        }

        .service-item {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr auto;
            gap: 16px;
            align-items: center;
            padding: 16px;
            background: white;
            border-radius: 8px;
            margin-bottom: 16px;
            border: 1px solid #e5e7eb;
        }

        .service-item:last-child {
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
        }

        .add-service-btn:hover {
            background: #059669;
        }

        .remove-service-btn {
            background: #ef4444;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
        }

        .remove-service-btn:hover {
            background: #dc2626;
        }

        /* Total Section */
        .total-section {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            font-size: 14px;
        }

        .total-row.grand-total {
            font-size: 18px;
            font-weight: 700;
            color: #0f172a;
            border-top: 2px solid #e5e7eb;
            padding-top: 16px;
            margin-top: 16px;
        }

        /* Form Actions */
        .form-actions {
            display: flex;
            gap: 16px;
            justify-content: flex-end;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
        }

        .btn-secondary {
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
        }

        .btn-secondary:hover {
            background: #4b5563;
        }

        .btn-primary {
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
        }

        .btn-primary:hover {
            background: #1d4ed8;
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

            .form-row {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .service-item {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .form-actions {
                flex-direction: column;
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
                    <h1>Generate Bill</h1>
                    <div class="header-subtitle">Create new bills and invoices for patients</div>
                </div>
                <a href="<?= site_url('billing') ?>" class="back-btn">
                    <span>←</span> Back to Billing
                </a>
            </header>

            <!-- Page Content -->
            <div class="page-content">
                <div class="form-container">
                    <div class="form-header">
                        <h2 class="form-title">New Bill Form</h2>
                    </div>

                    <form class="form-body" id="billForm">
                        <!-- Patient Information -->
                        <div class="form-section">
                            <h3 class="section-title">Patient Information</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Patient Name</label>
                                    <select class="form-select" id="patientSelect" required>
                                        <option value="">Select Patient</option>
                                        <option value="P001">Juan Dela Cruz</option>
                                        <option value="P002">Maria Santos</option>
                                        <option value="P003">Pedro Garcia</option>
                                        <option value="P004">Ana Rodriguez</option>
                                        <option value="P005">Carlos Mendoza</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Patient ID</label>
                                    <input type="text" class="form-input" id="patientId" readonly>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Contact Number</label>
                                    <input type="text" class="form-input" id="contactNumber" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-input" id="email" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Bill Details -->
                        <div class="form-section">
                            <h3 class="section-title">Bill Details</h3>
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">Bill Date</label>
                                    <input type="date" class="form-input" id="billDate" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Due Date</label>
                                    <input type="date" class="form-input" id="dueDate" required>
                                </div>
                            </div>
                            <div class="form-group full-width">
                                <label class="form-label">Notes</label>
                                <textarea class="form-textarea" id="notes" placeholder="Additional notes or special instructions..."></textarea>
                            </div>
                        </div>

                        <!-- Services -->
                        <div class="form-section">
                            <h3 class="section-title">Services & Charges</h3>
                            <div class="services-section">
                                <div id="servicesList">
                                    <!-- Service items will be added here -->
                                </div>
                                <button type="button" class="add-service-btn" id="addServiceBtn">
                                    <span>➕</span> Add Service
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
                            <button type="button" class="btn-secondary" id="saveDraftBtn">
                                <span>💾</span> Save Draft
                            </button>
                            <button type="submit" class="btn-primary">
                                <span>📄</span> Generate Bill
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // Sample services data
        const availableServices = [
            { id: 1, name: 'Consultation', price: 1500, category: 'General' },
            { id: 2, name: 'Laboratory Tests', price: 2500, category: 'Diagnostic' },
            { id: 3, name: 'X-Ray', price: 1200, category: 'Diagnostic' },
            { id: 4, name: 'Surgery', price: 25000, category: 'Procedure' },
            { id: 5, name: 'Room Charges (per day)', price: 3000, category: 'Accommodation' },
            { id: 6, name: 'Medicines', price: 800, category: 'Pharmacy' },
            { id: 7, name: 'Emergency Care', price: 5000, category: 'Emergency' },
            { id: 8, name: 'Physical Therapy', price: 2000, category: 'Therapy' }
        ];

        // Sample patients data
        const patients = {
            'P001': { name: 'Juan Dela Cruz', contact: '+63 912 345 6789', email: 'juan@email.com' },
            'P002': { name: 'Maria Santos', contact: '+63 923 456 7890', email: 'maria@email.com' },
            'P003': { name: 'Pedro Garcia', contact: '+63 934 567 8901', email: 'pedro@email.com' },
            'P004': { name: 'Ana Rodriguez', contact: '+63 945 678 9012', email: 'ana@email.com' },
            'P005': { name: 'Carlos Mendoza', contact: '+63 956 789 0123', email: 'carlos@email.com' }
        };

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
        });

        // Update patient information when selected
        function updatePatientInfo() {
            const patientId = document.getElementById('patientSelect').value;
            if (patientId && patients[patientId]) {
                const patient = patients[patientId];
                document.getElementById('patientId').value = patientId;
                document.getElementById('contactNumber').value = patient.contact;
                document.getElementById('email').value = patient.email;
            } else {
                document.getElementById('patientId').value = '';
                document.getElementById('contactNumber').value = '';
                document.getElementById('email').value = '';
            }
        }

        // Add new service row
        function addService() {
            serviceCounter++;
            const serviceId = `service_${serviceCounter}`;
            
            const serviceRow = document.createElement('div');
            serviceRow.className = 'service-item';
            serviceRow.id = serviceId;
            
            serviceRow.innerHTML = `
                <div class="form-group">
                    <select class="form-select service-select" onchange="updateServicePrice('${serviceId}')" required>
                        <option value="">Select Service</option>
                        ${availableServices.map(service => 
                            `<option value="${service.id}" data-price="${service.price}">${service.name} - ₱${service.price.toLocaleString()}</option>`
                        ).join('')}
                    </select>
                </div>
                <div class="form-group">
                    <input type="number" class="form-input" placeholder="Qty" min="1" value="1" onchange="updateServiceTotal('${serviceId}')" required>
                </div>
                <div class="form-group">
                    <input type="number" class="form-input service-price" placeholder="Price" readonly>
                </div>
                <div class="form-group">
                    <input type="number" class="form-input service-total" placeholder="Total" readonly>
                </div>
                <button type="button" class="remove-service-btn" onclick="removeService('${serviceId}')">Remove</button>
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
                const total = parseFloat(priceInput.value) * parseFloat(qtyInput.value);
                totalInput.value = total;
            }
            calculateTotals();
        }

        // Remove service row
        function removeService(serviceId) {
            const serviceRow = document.getElementById(serviceId);
            serviceRow.remove();
            services = services.filter(id => id !== serviceId);
            calculateTotals();
        }

        // Calculate totals
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
            const discount = 0; // Can be made editable later
            
            document.getElementById('subtotal').textContent = `₱${subtotal.toLocaleString()}`;
            document.getElementById('tax').textContent = `₱${tax.toLocaleString()}`;
            document.getElementById('discount').textContent = `₱${discount.toLocaleString()}`;
            document.getElementById('grandTotal').textContent = `₱${(subtotal + tax - discount).toLocaleString()}`;
        }

        // Save draft
        function saveDraft() {
            alert('Draft saved successfully!');
        }

        // Generate bill
        function generateBill(e) {
            e.preventDefault();
            
            // Validate form
            const patientId = document.getElementById('patientSelect').value;
            const billDate = document.getElementById('billDate').value;
            const dueDate = document.getElementById('dueDate').value;
            
            if (!patientId) {
                alert('Please select a patient');
                return;
            }
            
            if (!billDate || !dueDate) {
                alert('Please fill in all required dates');
                return;
            }
            
            // Check if services are added
            let hasServices = false;
            services.forEach(serviceId => {
                const serviceRow = document.getElementById(serviceId);
                if (serviceRow && serviceRow.querySelector('.service-select').value) {
                    hasServices = true;
                }
            });
            
            if (!hasServices) {
                alert('Please add at least one service');
                return;
            }
            
            // Generate bill (in real app, this would save to database)
            alert('Bill generated successfully!');
            
            // Reset form
            document.getElementById('billForm').reset();
            document.getElementById('servicesList').innerHTML = '';
            services = [];
            serviceCounter = 0;
            addService();
            calculateTotals();
        }
    </script>
</body>
</html>
