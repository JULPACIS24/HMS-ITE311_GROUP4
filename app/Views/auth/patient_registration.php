<?php echo view('auth/partials/header', ['title' => 'Patient Registration']); ?>
<div class="container">
	<?php echo view('auth/partials/sidebar'); ?>
	<main class="main-content">
		<header class="header">
			<div>
				<h1>Patient Registration</h1>
				<div class="sub" style="color:#64748b">Register new patients into the system</div>
			</div>
			<?php echo view('auth/partials/userbadge'); ?>
		</header>
		<div class="page-content">
			<!-- Stepper -->
			<div class="card form" style="padding:16px 20px; margin-bottom:16px; display:flex; align-items:center; gap:24px">
				<button class="btn step" data-step="1" style="border-radius:999px;width:32px;height:32px">1</button>
				<span>Personal Info</span>
				<div style="flex:0 0 28px; height:2px; background:#e5e7eb"></div>
				<button class="btn step" data-step="2" style="border-radius:999px;width:32px;height:32px">2</button>
				<span>Contact & Emergency</span>
				<div style="flex:0 0 28px; height:2px; background:#e5e7eb"></div>
				<button class="btn step" data-step="3" style="border-radius:999px;width:32px;height:32px">3</button>
				<span>Medical Info</span>
				<div style="flex:0 0 28px; height:2px; background:#e5e7eb"></div>
				<button class="btn step" data-step="4" style="border-radius:999px;width:32px;height:32px">4</button>
				<span>Insurance & Review</span>
			</div>

			<form method="post" action="<?= site_url('patients/store') ?>" id="regForm">
				<!-- Step 1 -->
				<div class="card form step-panel" data-step="1">
					<h3 style="margin-bottom:12px">Personal Information</h3>
					<div class="grid-2">
						<label><span>First Name *</span><input type="text" name="first_name" required></label>
						<label><span>Middle Name</span><input type="text" name="middle_name"></label>
						<label><span>Last Name *</span><input type="text" name="last_name" required></label>
						<label><span>Date of Birth *</span><input type="date" name="dob" id="dob" required onchange="calculateAge()"></label>
						<label><span>Age</span><input type="text" name="age" id="age" placeholder="Enter age"></label>
						<label><span>Gender *</span><select name="gender" required><option>Male</option><option>Female</option><option>Other</option></select></label>
						<label><span>Civil Status</span><select name="civil"><option>Single</option><option>Married</option><option>Widowed</option></select></label>
						<label><span>Nationality</span><input type="text" name="nationality" placeholder="e.g., Filipino"></label>
						<label><span>Religion</span><input type="text" name="religion"></label>
					</div>
				</div>

				<!-- Step 2 -->
				<div class="card form step-panel" data-step="2" style="display:none">
					<h3 style="margin-bottom:12px">Contact & Emergency</h3>
					<div class="grid-2">
						<label><span>Phone *</span><input type="text" name="phone" required></label>
						<label><span>Email</span><input type="text" name="email"></label>
						<label class="grid-span-2"><span>Address</span><input type="text" name="address"></label>
						<label><span>Emergency Contact Name</span><input type="text" name="emergency_name"></label>
						<label><span>Emergency Contact Phone</span><input type="text" name="emergency_phone"></label>
					</div>
				</div>

				<!-- Step 3 -->
				<div class="card form step-panel" data-step="3" style="display:none">
					<h3 style="margin-bottom:12px">Medical Information</h3>
					<div class="grid-2">
						<label><span>Blood Type</span><select name="blood_type"><option value="">Select</option><option>A+</option><option>A-</option><option>B+</option><option>B-</option><option>AB+</option><option>AB-</option><option>O+</option><option>O-</option></select></label>
						<label><span>Known Allergies</span><input type="text" name="allergies"></label>
						<label class="grid-span-2"><span>Medical History</span><textarea name="medical_history"></textarea></label>
					</div>
				</div>

				<!-- Step 4 -->
				<div class="card form step-panel" data-step="4" style="display:none">
					<h3 style="margin-bottom:12px">Insurance & Review</h3>
					<p class="sub" style="margin-bottom:12px">Optional insurance details and final review before saving.</p>
					<div class="grid-2">
						<label><span>Insurance Provider</span><input type="text" name="ins_provider"></label>
						<label><span>Policy Number</span><input type="text" name="ins_policy"></label>
					</div>
				</div>

				<div class="form-actions">
					<button class="btn" type="button" id="prevStep">Back</button>
					<button class="btn primary" type="button" id="nextStep">Next Step</button>
				</div>
			</form>
		</div>
	</main>
</div>

<style>
/* Remove ALL hover effects and transitions */
.btn, .step, input, select, textarea, .card, .form-actions button {
    transition: none !important;
}

.btn:hover, .step:hover, input:hover, select:hover, textarea:hover, .card:hover, .form-actions button:hover {
    transform: none !important;
    box-shadow: none !important;
    background-color: inherit !important;
    border-color: inherit !important;
}

/* Make age field look exactly like others */
#age {
    background-color: white !important;
    border: 1px solid #d1d5db !important;
    color: #374151 !important;
}

#age:focus {
    border-color: #3b82f6 !important;
    outline: none !important;
}
</style>

<script>
	let currentStep = 1; const maxStep = 4;
	const steps = document.querySelectorAll('.step');
	const panels = document.querySelectorAll('.step-panel');
	
	// Function to calculate age from date of birth
	function calculateAge() {
		const dobInput = document.getElementById('dob');
		const ageInput = document.getElementById('age');
		
		if (dobInput.value) {
			const birthDate = new Date(dobInput.value);
			const today = new Date();
			let age = today.getFullYear() - birthDate.getFullYear();
			const monthDiff = today.getMonth() - birthDate.getMonth();
			
			if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
				age--;
			}
			
			ageInput.value = age;
			console.log('Age calculated:', age); // Debug log
		} else {
			ageInput.value = '';
		}
	}
	
	function render(){
		steps.forEach(s=>{ s.style.background = (+s.dataset.step === currentStep) ? '#2563eb' : '#ecf0f1'; s.style.color = (+s.dataset.step === currentStep) ? '#fff' : '#2c3e50'; });
		panels.forEach(p=>{ p.style.display = (+s.dataset.step === currentStep) ? '' : 'none'; });
		document.getElementById('prevStep').disabled = currentStep === 1;
		document.getElementById('nextStep').textContent = currentStep === maxStep ? 'Submit' : 'Next Step';
	}
	document.getElementById('prevStep').addEventListener('click', ()=>{ if(currentStep>1){ currentStep--; render(); }});
	document.getElementById('nextStep').addEventListener('click', ()=>{
		if(currentStep < maxStep){ currentStep++; render(); }
		else{ 
			// Validate age is calculated before submit
			const ageInput = document.getElementById('age');
			if (!ageInput.value) {
				alert('Please select a date of birth to calculate age');
				return;
			}
			document.getElementById('regForm').submit(); 
		}
	});
	render();
</script>
<?php echo view('auth/partials/footer'); ?>
