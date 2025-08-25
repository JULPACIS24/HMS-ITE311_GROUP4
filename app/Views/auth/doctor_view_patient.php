<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • View Patient</title>
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
		.patient-card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden;margin-bottom:24px}
		.patient-header{padding:24px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);color:#fff}
		.patient-name{font-size:24px;font-weight:700;margin-bottom:8px}
		.patient-id{font-size:14px;opacity:0.9}
		.patient-body{padding:24px}
		.info-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px}
		.info-section h3{font-size:16px;font-weight:600;color:#374151;margin-bottom:16px;border-bottom:2px solid #e5e7eb;padding-bottom:8px}
		.info-row{display:flex;justify-content:space-between;padding:12px 0;border-bottom:1px solid #f3f4f6}
		.info-row:last-child{border-bottom:none}
		.info-label{font-weight:500;color:#6b7280}
		.info-value{font-weight:600;color:#111827}
		.medical-notes{background:#f9fafb;padding:16px;border-radius:8px;margin-top:16px}
		.medical-notes h4{font-size:14px;font-weight:600;color:#374151;margin-bottom:8px}
		.medical-notes p{font-size:14px;color:#6b7280;line-height:1.5}
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<div class="main">
			<div class="header">
				<div class="header-left">
					<h1>Patient Details</h1>
					<div class="sub">View complete patient information and medical history</div>
				</div>
				<div class="actions">
					<a href="<?= site_url('doctor/patients/edit/' . $patient['id']) ?>" class="btn btn-success">✎ Edit Patient</a>
					<a href="<?= site_url('doctor/patients') ?>" class="btn btn-secondary">← Back to Patients</a>
				</div>
			</div>

			<div class="content">
				<div class="patient-card">
					<div class="patient-header">
						<div class="patient-name"><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></div>
						<div class="patient-id">Patient ID: P-<?= str_pad($patient['id'], 3, '0', STR_PAD_LEFT) ?></div>
					</div>
					
					<div class="patient-body">
						<div class="info-grid">
							<div class="info-section">
								<h3>Personal Information</h3>
								<div class="info-row">
									<span class="info-label">Full Name:</span>
									<span class="info-value"><?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">Date of Birth:</span>
									<span class="info-value"><?= esc($patient['dob']) ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">Age:</span>
									<span class="info-value"><?= $patient['age'] ?? 'N/A' ?> years old</span>
								</div>
								<div class="info-row">
									<span class="info-label">Gender:</span>
									<span class="info-value"><?= esc($patient['gender']) ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">Blood Type:</span>
									<span class="info-value"><?= esc($patient['blood_type'] ?? 'N/A') ?></span>
								</div>
							</div>

							<div class="info-section">
								<h3>Contact Information</h3>
								<div class="info-row">
									<span class="info-label">Phone Number:</span>
									<span class="info-value"><?= esc($patient['phone']) ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">Email Address:</span>
									<span class="info-value"><?= esc($patient['email'] ?? 'N/A') ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">Address:</span>
									<span class="info-value"><?= esc($patient['address'] ?? 'N/A') ?></span>
								</div>
							</div>

							<div class="info-section">
								<h3>Emergency Contact</h3>
								<div class="info-row">
									<span class="info-label">Emergency Contact:</span>
									<span class="info-value"><?= esc($patient['emergency_name'] ?? 'N/A') ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">Emergency Phone:</span>
									<span class="info-value"><?= esc($patient['emergency_phone'] ?? 'N/A') ?></span>
								</div>
							</div>

							<div class="info-section">
								<h3>Insurance Information</h3>
								<div class="info-row">
									<span class="info-label">PhilHealth Number:</span>
									<span class="info-value"><?= esc($patient['philhealth_number'] ?? 'N/A') ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">PhilHealth Category:</span>
									<span class="info-value"><?= esc($patient['philhealth_category'] ?? 'N/A') ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">Insurance Provider:</span>
									<span class="info-value"><?= esc($patient['insurance_provider'] ?? 'N/A') ?></span>
								</div>
								<div class="info-row">
									<span class="info-label">Policy Number:</span>
									<span class="info-value"><?= esc($patient['insurance_policy_number'] ?? 'N/A') ?></span>
								</div>
							</div>
						</div>

						<?php if (!empty($patient['medical_history']) || !empty($patient['allergies'])): ?>
							<div class="medical-notes">
								<?php if (!empty($patient['medical_history'])): ?>
									<h4>Medical History</h4>
									<p><?= esc($patient['medical_history']) ?></p>
								<?php endif; ?>
								
								<?php if (!empty($patient['allergies'])): ?>
									<h4>Allergies</h4>
									<p><?= esc($patient['allergies']) ?></p>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
