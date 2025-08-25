<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • Edit Patient</title>
	<style>
		*{margin:0;padding:0;box-sizing:border-box}
		body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Oxygen,Ubuntu,sans-serif;background:#f5f7fa}
		.container{display:flex;min-height:100vh}
		.sidebar{width:250px;background:linear-gradient(180deg,#2c3e50 0%,#34495e 100%);color:#fff;position:fixed;height:100vh;overflow-y:auto}
		.sidebar-header{padding:20px;border-bottom:1px solid #34495e;display:flex;align-items:center;gap:12px}
		.admin-icon{width:36px;height:36px;border-radius:8px;background:#3498db;display:grid;place-items:center}
		.sidebar-title{font-size:16px;font-weight:700}
		.sidebar-sub{font-size:12px;color:#cbd5e1;margin-top:2px}
		.sidebar-menu{padding:20px 0}
		.menu-item{display:flex;align-items:center;gap:12px;padding:12px 20px;color:#cbd5e1;text-decoration:none;border-left:3px solid transparent}
		.menu-item:hover{background:rgba(255,255,255,.1);color:#fff;border-left-color:#3498db}
		.menu-item.active{background:rgba(52,152,219,.2);color:#fff;border-left-color:#3498db}
		.menu-icon{width:20px;text-align:center}
		.main{flex:1;margin-left:250px}
		.header{background:#fff;padding:18px 24px;box-shadow:0 2px 4px rgba(0,0,0,.08);display:flex;justify-content:space-between;align-items:center}
		.header-left{display:flex;flex-direction:column}
		.header h1{font-size:22px;font-weight:700;color:#2c3e50;margin:0}
		.header .sub{font-size:12px;color:#64748b}
		.actions{display:flex;align-items:center;gap:14px}
		.btn{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:8px;text-decoration:none;font-weight:600;font-size:14px;border:none;cursor:pointer}
		.btn-primary{background:#2563eb;color:#fff}
		.btn-secondary{background:#64748b;color:#fff}
		.btn-success{background:#10b981;color:#fff}
		.btn-danger{background:#ef4444;color:#fff}
		
		.content{padding:24px}
		.form-card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden;margin-bottom:24px}
		.form-header{padding:24px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff}
		.form-title{font-size:20px;font-weight:700;margin-bottom:8px}
		.form-subtitle{font-size:14px;opacity:0.9}
		.form-body{padding:24px}
		.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px}
		.form-group{margin-bottom:20px}
		.form-label{display:block;font-weight:600;color:#374151;margin-bottom:8px;font-size:14px}
		.form-input{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;transition:border-color 0.2s}
		.form-input:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,0.1)}
		.form-select{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;background:#fff}
		.form-textarea{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;min-height:100px;resize:vertical}
		.form-actions{display:flex;gap:12px;justify-content:flex-end;padding-top:24px;border-top:1px solid #e5e7eb}
		.error{color:#ef4444;font-size:12px;margin-top:4px}
		.success{color:#10b981;font-size:12px;margin-top:4px}
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<div class="main">
			<div class="header">
				<div class="header-left">
					<h1>Edit Patient</h1>
					<div class="sub">Update patient information and medical records</div>
				</div>
				<div class="actions">
					<a href="<?= site_url('doctor/patients/view/' . $patient['id']) ?>" class="btn btn-primary">👁️ View Patient</a>
					<a href="<?= site_url('doctor/patients') ?>" class="btn btn-secondary">← Back to Patients</a>
				</div>
			</div>

			<div class="content">
				<div class="form-card">
					<div class="form-header">
						<div class="form-title">Edit Patient Information</div>
						<div class="form-subtitle">Patient ID: P-<?= str_pad($patient['id'], 3, '0', STR_PAD_LEFT) ?></div>
					</div>
					
					<form action="<?= site_url('doctor/patients/update/' . $patient['id']) ?>" method="POST">
						<div class="form-body">
							<div class="form-grid">
								<div>
									<div class="form-group">
										<label class="form-label">First Name *</label>
										<input type="text" name="first_name" class="form-input" value="<?= esc($patient['first_name']) ?>" required>
									</div>
									
									<div class="form-group">
										<label class="form-label">Last Name *</label>
										<input type="text" name="last_name" class="form-input" value="<?= esc($patient['last_name']) ?>" required>
									</div>
									
									<div class="form-group">
										<label class="form-label">Date of Birth *</label>
										<input type="date" name="dob" class="form-input" value="<?= esc($patient['dob']) ?>" required>
									</div>
									
									<div class="form-group">
										<label class="form-label">Age</label>
										<input type="number" name="age" class="form-input" value="<?= esc($patient['age'] ?? '') ?>" min="0" max="150">
									</div>
									
									<div class="form-group">
										<label class="form-label">Gender *</label>
										<select name="gender" class="form-select" required>
											<option value="Male" <?= $patient['gender'] === 'Male' ? 'selected' : '' ?>>Male</option>
											<option value="Female" <?= $patient['gender'] === 'Female' ? 'selected' : '' ?>>Female</option>
											<option value="Other" <?= $patient['gender'] === 'Other' ? 'selected' : '' ?>>Other</option>
										</select>
									</div>
									
									<div class="form-group">
										<label class="form-label">Blood Type</label>
										<select name="blood_type" class="form-select">
											<option value="">Select Blood Type</option>
											<option value="A+" <?= $patient['blood_type'] === 'A+' ? 'selected' : '' ?>>A+</option>
											<option value="A-" <?= $patient['blood_type'] === 'A-' ? 'selected' : '' ?>>A-</option>
											<option value="B+" <?= $patient['blood_type'] === 'B+' ? 'selected' : '' ?>>B+</option>
											<option value="B-" <?= $patient['blood_type'] === 'B-' ? 'selected' : '' ?>>B-</option>
											<option value="AB+" <?= $patient['blood_type'] === 'AB+' ? 'selected' : '' ?>>AB+</option>
											<option value="AB-" <?= $patient['blood_type'] === 'AB-' ? 'selected' : '' ?>>AB-</option>
											<option value="O+" <?= $patient['blood_type'] === 'O+' ? 'selected' : '' ?>>O+</option>
											<option value="O-" <?= $patient['blood_type'] === 'O-' ? 'selected' : '' ?>>O-</option>
										</select>
									</div>
								</div>
								
								<div>
									<div class="form-group">
										<label class="form-label">Phone Number *</label>
										<input type="tel" name="phone" class="form-input" value="<?= esc($patient['phone']) ?>" required>
									</div>
									
									<div class="form-group">
										<label class="form-label">Email Address</label>
										<input type="email" name="email" class="form-input" value="<?= esc($patient['email'] ?? '') ?>">
									</div>
									
									<div class="form-group">
										<label class="form-label">Address</label>
										<textarea name="address" class="form-textarea"><?= esc($patient['address'] ?? '') ?></textarea>
									</div>
									
									<div class="form-group">
										<label class="form-label">Emergency Contact Name</label>
										<input type="text" name="emergency_name" class="form-input" value="<?= esc($patient['emergency_name'] ?? '') ?>">
									</div>
									
									<div class="form-group">
										<label class="form-label">Emergency Contact Phone</label>
										<input type="tel" name="emergency_phone" class="form-input" value="<?= esc($patient['emergency_phone'] ?? '') ?>">
									</div>
								</div>
								
								<div>
									<div class="form-group">
										<label class="form-label">PhilHealth Number</label>
										<input type="text" name="philhealth_number" class="form-input" value="<?= esc($patient['philhealth_number'] ?? '') ?>">
									</div>
									
									<div class="form-group">
										<label class="form-label">PhilHealth Category</label>
										<select name="philhealth_category" class="form-select">
											<option value="">Select Category</option>
											<option value="Individually Paying Program" <?= $patient['philhealth_category'] === 'Individually Paying Program' ? 'selected' : '' ?>>Individually Paying Program</option>
											<option value="Sponsored Program" <?= $patient['philhealth_category'] === 'Sponsored Program' ? 'selected' : '' ?>>Sponsored Program</option>
											<option value="Employed Program" <?= $patient['philhealth_category'] === 'Employed Program' ? 'selected' : '' ?>>Employed Program</option>
											<option value="OFW Program" <?= $patient['philhealth_category'] === 'OFW Program' ? 'selected' : '' ?>>OFW Program</option>
										</select>
									</div>
									
									<div class="form-group">
										<label class="form-label">Insurance Provider</label>
										<input type="text" name="insurance_provider" class="form-input" value="<?= esc($patient['insurance_provider'] ?? '') ?>">
									</div>
									
									<div class="form-group">
										<label class="form-label">Insurance Policy Number</label>
										<input type="text" name="insurance_policy_number" class="form-input" value="<?= esc($patient['insurance_policy_number'] ?? '') ?>">
									</div>
									
									<div class="form-group">
										<label class="form-label">Medical History</label>
										<textarea name="medical_history" class="form-textarea" placeholder="Enter patient's medical history..."><?= esc($patient['medical_history'] ?? '') ?></textarea>
									</div>
									
									<div class="form-group">
										<label class="form-label">Allergies</label>
										<textarea name="allergies" class="form-textarea" placeholder="Enter patient's allergies..."><?= esc($patient['allergies'] ?? '') ?></textarea>
									</div>
								</div>
							</div>
							
							<div class="form-actions">
								<a href="<?= site_url('doctor/patients') ?>" class="btn btn-secondary">Cancel</a>
								<button type="submit" class="btn btn-success">Update Patient</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
