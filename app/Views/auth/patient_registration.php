<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Registration - San Miguel HMS</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f7fa;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }
        
        .container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }
        
        /* Sidebar */
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
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #334155;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }
        
        .menu-item:hover {
            background: #dbeafe;
            color: #1e40af;
            border-left-color: #2563eb;
        }
        
        .menu-item.active {
            background: #eef2ff;
            color: #1d4ed8;
            border-left-color: #2563eb;
        }
        
        .menu-icon {
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            min-height: 100vh;
            background: #f5f7fa;
        }
        
        .page-content {
            padding: 30px 40px;
        }
        
        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 30px;
        }
        
        .header-left h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        
        .header-left .subtitle {
            font-size: 16px;
            color: #6b7280;
        }
        
        .back-btn {
            background: #374151;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: background-color 0.3s ease;
        }
        
        .back-btn:hover {
            background: #4b5563;
        }
        
        /* Progress Stepper */
        .stepper {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
        }
        
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            z-index: 2;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 16px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
        }
        
        .step.active .step-circle {
            background: #3b82f6;
            color: white;
        }
        
        .step.completed .step-circle {
            background: #3b82f6;
            color: white;
        }
        
        .step.inactive .step-circle {
            background: #e5e7eb;
            color: #6b7280;
        }
        
        .step-label {
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .step.active .step-label {
            color: #3b82f6;
        }
        
        .step.completed .step-label {
            color: #3b82f6;
        }
        
        .step.inactive .step-label {
            color: #6b7280;
        }
        
        .step:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 20px;
            left: 50%;
            width: 100px;
            height: 2px;
            background: #e5e7eb;
            z-index: -1;
        }
        
        .step.completed:not(:last-child)::after {
            background: #3b82f6;
        }
        
        /* Form Card */
        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            padding: 40px;
            width: 100%;
            margin: 0;
        }
        
        .section-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 30px;
        }
        
        /* Form Fields */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #374151;
            font-size: 14px;
        }
        
        .form-group label.required::after {
            content: ' *';
            color: #ef4444;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
            background: white;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        .form-group input[type="date"] {
            position: relative;
        }
        
        .form-group input[type="date"]::-webkit-calendar-picker-indicator {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        
        /* Age Display */
        .age-display {
            background: #f3f4f6;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 14px;
            color: #6b7280;
            margin-top: 8px;
            display: inline-block;
        }
        
        /* Registration Summary */
        .summary-section {
            background: #f9fafb;
            border-radius: 8px;
            padding: 20px;
            margin-top: 30px;
        }
        
        .summary-title {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .summary-item {
            display: flex;
            flex-direction: column;
        }
        
        .summary-label {
            font-weight: 600;
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 4px;
        }
        
        .summary-value {
            color: #1f2937;
            font-size: 14px;
        }
        
        /* Navigation Buttons */
        .form-navigation {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
        }
        
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .btn-secondary {
            background: white;
            color: #6b7280;
            border: 2px solid #e5e7eb;
        }
        
        .btn-secondary:hover {
            background: #f9fafb;
            border-color: #d1d5db;
        }
        
        .btn-primary {
            background: #3b82f6;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2563eb;
        }
        
        .btn-success {
            background: #10b981;
            color: white;
        }
        
        .btn-success:hover {
            background: #059669;
        }
        
        /* Hidden steps */
        .step-content {
            display: none;
        }
        
        .step-content.active {
            display: block;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .page-content {
                padding: 15px;
            }
            
            .form-card {
                padding: 25px;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .stepper {
                flex-direction: column;
                gap: 20px;
            }
            
            .step:not(:last-child)::after {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Sidebar -->
        <?php echo view('auth/partials/sidebar'); ?>

        <!-- Main Content -->
        <div class="main-content">
            <div class="page-content">
                <!-- Header -->
                <div class="header">
                    <div class="header-left">
                        <h1>Patient Registration</h1>
                        <div class="subtitle">Register new patients into the system</div>
                    </div>
                    <button class="back-btn" onclick="goBack()">
                        ← Back to Patients
                    </button>
                </div>

                <!-- Progress Stepper -->
                <div class="stepper">
                    <div class="step active" data-step="1">
                        <div class="step-circle">1</div>
                        <div class="step-label">Personal Info</div>
                    </div>
                    <div class="step inactive" data-step="2">
                        <div class="step-circle">2</div>
                        <div class="step-label">Contact & Emergency</div>
                    </div>
                    <div class="step inactive" data-step="3">
                        <div class="step-circle">3</div>
                        <div class="step-label">Medical Info</div>
                    </div>
                    <div class="step inactive" data-step="4">
                        <div class="step-circle">4</div>
                        <div class="step-label">Insurance & Review</div>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="form-card">
                    <!-- Step 1: Personal Information -->
                    <div class="step-content active" id="step1">
                        <div class="section-title">Personal Information</div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="required" for="firstName">First Name</label>
                                <input type="text" id="firstName" name="firstName" required>
                            </div>
                            <div class="form-group">
                                <label for="middleName">Middle Name</label>
                                <input type="text" id="middleName" name="middleName">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="required" for="lastName">Last Name</label>
                                <input type="text" id="lastName" name="lastName" required>
                            </div>
                            <div class="form-group">
                                <label class="required" for="dateOfBirth">Date of Birth</label>
                                <input type="date" id="dateOfBirth" name="dateOfBirth" required onchange="calculateAge()">
                                <div class="age-display" id="ageDisplay" style="display: none;"></div>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="required" for="gender">Gender</label>
                                <select id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="civilStatus">Civil Status</label>
                                <select id="civilStatus" name="civilStatus">
                                    <option value="">Select Status</option>
                                    <option value="Single">Single</option>
                                    <option value="Married">Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nationality">Nationality</label>
                                <input type="text" id="nationality" name="nationality" placeholder="e.g., Filipino">
                            </div>
                            <div class="form-group">
                                <label for="religion">Religion</label>
                                <input type="text" id="religion" name="religion">
                            </div>
                        </div>
                        
                        <div class="form-navigation">
                            <div></div>
                            <button class="btn btn-primary" onclick="nextStep()">
                                Next Step
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Contact & Emergency -->
                    <div class="step-content" id="step2">
                        <div class="section-title">Contact & Emergency</div>
                        
                        <div class="form-group">
                            <label class="required" for="phoneNumber">Phone Number</label>
                            <input type="tel" id="phoneNumber" name="phoneNumber" placeholder="+63 912-345-6789" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="emailAddress">Email Address</label>
                            <input type="email" id="emailAddress" name="emailAddress">
                        </div>
                        
                        <div class="form-group">
                            <label class="required" for="address">Address</label>
                            <textarea id="address" name="address" placeholder="Street Address" required></textarea>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="required" for="city">City</label>
                                <input type="text" id="city" name="city" required>
                            </div>
                            <div class="form-group">
                                <label for="province">Province</label>
                                <input type="text" id="province" name="province">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="zipCode">Zip Code</label>
                            <input type="text" id="zipCode" name="zipCode">
                        </div>
                        
                        <div class="section-title" style="margin-top: 40px;">Emergency Contact</div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label class="required" for="emergencyName">Full Name</label>
                                <input type="text" id="emergencyName" name="emergencyName" required>
                            </div>
                            <div class="form-group">
                                <label class="required" for="emergencyRelationship">Relationship</label>
                                <input type="text" id="emergencyRelationship" name="emergencyRelationship" placeholder="e.g., Spouse, Parent, Sibling" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="required" for="emergencyPhone">Phone Number</label>
                            <input type="tel" id="emergencyPhone" name="emergencyPhone" required>
                        </div>
                        
                        <div class="form-navigation">
                            <button class="btn btn-secondary" onclick="previousStep()">
                                Previous
                            </button>
                            <button class="btn btn-primary" onclick="nextStep()">
                                Next Step
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Medical Information -->
                    <div class="step-content" id="step3">
                        <div class="section-title">Medical Information</div>
                        
                        <div class="form-group">
                            <label for="bloodType">Blood Type</label>
                            <select id="bloodType" name="bloodType">
                                <option value="">Select Blood Type</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="allergies">Known Allergies</label>
                            <textarea id="allergies" name="allergies" placeholder="List any known allergies (medications, food, environmental, etc.)"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="currentMedications">Current Medications</label>
                            <textarea id="currentMedications" name="currentMedications" placeholder="List current medications with dosages"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label for="medicalHistory">Medical History</label>
                            <textarea id="medicalHistory" name="medicalHistory" placeholder="Previous illnesses, surgeries, chronic conditions, etc."></textarea>
                        </div>
                        
                        <div class="form-navigation">
                            <button class="btn btn-secondary" onclick="previousStep()">
                                Previous
                            </button>
                            <button class="btn btn-primary" onclick="nextStep()">
                                Next Step
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Insurance & Review -->
                    <div class="step-content" id="step4">
                        <div class="section-title">Insurance Information</div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="insuranceProvider">Insurance Provider</label>
                                <input type="text" id="insuranceProvider" name="insuranceProvider" placeholder="e.g., PhilHealth, HMO Name">
                            </div>
                            <div class="form-group">
                                <label for="insuranceNumber">Insurance/Policy Number</label>
                                <input type="text" id="insuranceNumber" name="insuranceNumber">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="policyHolder">Policy Holder Name</label>
                            <input type="text" id="policyHolder" name="policyHolder" placeholder="If different from patient">
                        </div>
                        
                        <div class="summary-section">
                            <div class="summary-title">Registration Summary</div>
                            <div class="summary-grid">
                                <div class="summary-item">
                                    <div class="summary-label">Name:</div>
                                    <div class="summary-value" id="summaryName">-</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">Emergency Contact:</div>
                                    <div class="summary-value" id="summaryEmergency">-</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">Date of Birth:</div>
                                    <div class="summary-value" id="summaryDOB">-</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">Blood Type:</div>
                                    <div class="summary-value" id="summaryBlood">-</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">Phone:</div>
                                    <div class="summary-value" id="summaryPhone">-</div>
                                </div>
                                <div class="summary-item">
                                    <div class="summary-label">Insurance:</div>
                                    <div class="summary-value" id="summaryInsurance">-</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-navigation">
                            <button class="btn btn-secondary" onclick="previousStep()">
                                Previous
                            </button>
                            <button class="btn btn-success" onclick="registerPatient()">
                                Register Patient
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        // Initialize the form
        document.addEventListener('DOMContentLoaded', function() {
            updateStepper();
            updateSummary();
        });

        // Calculate age from date of birth
        function calculateAge() {
            const dobInput = document.getElementById('dateOfBirth');
            const ageDisplay = document.getElementById('ageDisplay');
            
            if (dobInput.value) {
                const dob = new Date(dobInput.value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                
                ageDisplay.textContent = `Age: ${age} years old`;
                ageDisplay.style.display = 'block';
            } else {
                ageDisplay.style.display = 'none';
            }
        }

        // Navigate to next step
        function nextStep() {
            if (validateCurrentStep()) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);
                    updateStepper();
                    updateSummary();
                }
            }
        }

        // Navigate to previous step
        function previousStep() {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
                updateStepper();
            }
        }

        // Show specific step
        function showStep(step) {
            // Hide all steps
            for (let i = 1; i <= totalSteps; i++) {
                document.getElementById(`step${i}`).classList.remove('active');
            }
            
            // Show current step
            document.getElementById(`step${step}`).classList.add('active');
        }

        // Update stepper display
        function updateStepper() {
            const steps = document.querySelectorAll('.step');
            
            steps.forEach((step, index) => {
                const stepNumber = index + 1;
                
                if (stepNumber < currentStep) {
                    step.classList.remove('active', 'inactive');
                    step.classList.add('completed');
                } else if (stepNumber === currentStep) {
                    step.classList.remove('completed', 'inactive');
                    step.classList.add('active');
                } else {
                    step.classList.remove('active', 'completed');
                    step.classList.add('inactive');
                }
            });
        }

        // Validate current step
        function validateCurrentStep() {
            const currentStepElement = document.getElementById(`step${currentStep}`);
            const requiredFields = currentStepElement.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    field.style.borderColor = '#ef4444';
                    isValid = false;
                } else {
                    field.style.borderColor = '#e5e7eb';
                }
            });
            
            if (!isValid) {
                alert('Please fill in all required fields before proceeding.');
            }
            
            return isValid;
        }

        // Update summary section
        function updateSummary() {
            document.getElementById('summaryName').textContent = 
                `${document.getElementById('firstName').value || '-'} ${document.getElementById('lastName').value || ''}`.trim() || '-';
            
            document.getElementById('summaryDOB').textContent = 
                document.getElementById('dateOfBirth').value || '-';
            
            document.getElementById('summaryPhone').textContent = 
                document.getElementById('phoneNumber').value || '-';
            
            document.getElementById('summaryEmergency').textContent = 
                document.getElementById('emergencyName').value || '-';
            
            document.getElementById('summaryBlood').textContent = 
                document.getElementById('bloodType').value || '-';
            
            document.getElementById('summaryInsurance').textContent = 
                document.getElementById('insuranceProvider').value || '-';
        }

        // Register patient
        function registerPatient() {
            if (validateCurrentStep()) {
                // Collect all form data
                const formData = new FormData();
                
                // Personal Info
                formData.append('firstName', document.getElementById('firstName').value);
                formData.append('middleName', document.getElementById('middleName').value);
                formData.append('lastName', document.getElementById('lastName').value);
                formData.append('dateOfBirth', document.getElementById('dateOfBirth').value);
                formData.append('gender', document.getElementById('gender').value);
                formData.append('civilStatus', document.getElementById('civilStatus').value);
                formData.append('nationality', document.getElementById('nationality').value);
                formData.append('religion', document.getElementById('religion').value);
                
                // Contact & Emergency
                formData.append('phoneNumber', document.getElementById('phoneNumber').value);
                formData.append('emailAddress', document.getElementById('emailAddress').value);
                formData.append('address', document.getElementById('address').value);
                formData.append('city', document.getElementById('city').value);
                formData.append('province', document.getElementById('province').value);
                formData.append('zipCode', document.getElementById('zipCode').value);
                formData.append('emergencyName', document.getElementById('emergencyName').value);
                formData.append('emergencyRelationship', document.getElementById('emergencyRelationship').value);
                formData.append('emergencyPhone', document.getElementById('emergencyPhone').value);
                
                // Medical Info
                formData.append('bloodType', document.getElementById('bloodType').value);
                formData.append('allergies', document.getElementById('allergies').value);
                formData.append('currentMedications', document.getElementById('currentMedications').value);
                formData.append('medicalHistory', document.getElementById('medicalHistory').value);
                
                // Insurance
                formData.append('insuranceProvider', document.getElementById('insuranceProvider').value);
                formData.append('insuranceNumber', document.getElementById('insuranceNumber').value);
                formData.append('policyHolder', document.getElementById('policyHolder').value);
                
                // Calculate age
                const dob = new Date(document.getElementById('dateOfBirth').value);
                const today = new Date();
                let age = today.getFullYear() - dob.getFullYear();
                const monthDiff = today.getMonth() - dob.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                    age--;
                }
                formData.append('age', age);
                
                // Submit the form
                submitPatientRegistration(formData);
            }
        }

        // Submit patient registration
        function submitPatientRegistration(formData) {
            // Show loading state
            const submitBtn = document.querySelector('button[onclick="registerPatient()"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Registering...';
            submitBtn.disabled = true;
            
            // Send data to backend
            fetch('<?= site_url('patients/storeRegistration') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    // Redirect to patient management
                    window.location.href = data.redirect_url;
                } else {
                    alert('Error: ' + data.message);
                    // Reset button
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                // Reset button
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        }

        // Go back to patients list
        function goBack() {
            if (confirm('Are you sure you want to go back? All entered data will be lost.')) {
                window.location.href = '<?= site_url('patient-management') ?>';
            }
        }

        // Add real-time validation
        document.addEventListener('input', function(e) {
            if (e.target.hasAttribute('required')) {
                if (e.target.value.trim()) {
                    e.target.style.borderColor = '#e5e7eb';
                } else {
                    e.target.style.borderColor = '#ef4444';
                }
            }
        });
    </script>
</body>
</html>
