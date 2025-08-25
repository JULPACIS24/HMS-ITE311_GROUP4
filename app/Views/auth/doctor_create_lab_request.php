<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • New Lab Request</title>
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
		.icon-btn{position:relative;width:34px;height:34px;border-radius:10px;background:#f8fafc;border:1px solid #e5e7eb;display:grid;place-items:center}
		.badge{position:absolute;top:-4px;right:-4px;background:#ef4444;color:#fff;border-radius:999px;font-size:10px;padding:2px 6px;font-weight:700}
		.avatar{width:34px;height:34px;border-radius:50%;background:#2563eb;color:#fff;display:grid;place-items:center;font-weight:800}
		.user-meta{line-height:1.1}
		.user-name{font-weight:700;font-size:13px;color:#0f172a}
		.user-role{font-size:11px;color:#64748b}
		.user-chip{display:flex;align-items:center;gap:10px}

		.page{padding:24px}
		.modal{background:#fff;border-radius:12px;box-shadow:0 20px 25px -5px rgba(0,0,0,.1),0 10px 10px -5px rgba(0,0,0,.04);max-width:800px;margin:0 auto;overflow:hidden}
		.modal-header{padding:20px;border-bottom:1px solid #ecf0f1;display:flex;justify-content:space-between;align-items:center}
		.modal-title{font-size:18px;font-weight:700;color:#0f172a}
		.close-btn{width:32px;height:32px;border:none;background:none;cursor:pointer;font-size:18px;color:#64748b}
		.modal-body{padding:20px;max-height:70vh;overflow-y:auto}
		.form-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:24px}
		.form-group{margin-bottom:20px}
		.form-label{display:block;margin-bottom:8px;font-weight:600;color:#374151;font-size:14px}
		.form-input{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px}
		.form-input:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
		.form-select{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;background:#fff}
		.form-textarea{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;min-height:100px;resize:vertical}
		
		.tests-section{margin-bottom:24px}
		.tests-title{font-size:16px;font-weight:600;color:#0f172a;margin-bottom:16px}
		.tests-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:16px}
		.test-category{background:#f8fafc;border-radius:8px;padding:16px;border:1px solid #e5e7eb}
		.category-title{font-size:14px;font-weight:600;color:#374151;margin-bottom:12px;text-transform:uppercase;letter-spacing:0.5px}
		.test-checkbox{display:flex;align-items:center;gap:8px;margin-bottom:8px}
		.test-checkbox input[type="checkbox"]{width:16px;height:16px;accent-color:#2563eb}
		.test-checkbox label{font-size:13px;color:#374151;cursor:pointer}
		
		.modal-footer{padding:20px;border-top:1px solid #ecf0f1;display:flex;justify-content:flex-end;gap:12px}
		.btn{display:inline-block;padding:12px 24px;border:none;border-radius:8px;font-weight:600;text-decoration:none;cursor:pointer;font-size:14px}
		.btn-primary{background:#2563eb;color:#fff}
		.btn-secondary{background:#6b7280;color:#fff}
		.btn:hover{opacity:0.9}
		
		.alert{padding:12px 16px;border-radius:8px;margin-bottom:20px}
		.alert-success{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
		.alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
	</style>
</head>
<body>
	<div class="container">
		<?php echo view('auth/partials/doctor_sidebar'); ?>

		<div class="main">
			<div class="header">
				<div class="header-left">
					<h1>New Lab Request</h1>
					<div class="sub">Create a new laboratory test request</div>
				</div>
				<div class="actions">
					<div class="user-wrap" style="position:relative">
						<div class="user-chip" id="userBtn" style="cursor:pointer">
							<div class="avatar">DR</div>
							<div class="user-meta">
								<div class="user-name"><?= session('role') === 'doctor' ? 'Dr. ' . (session('user_name') ?? 'Doctor') : 'Doctor' ?></div>
								<div class="user-role"><?= session('specialty') ?? session('department') ?? 'Medical' ?></div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="page">
				<?php if (session('error')): ?>
					<div class="alert alert-error"><?= session('error') ?></div>
				<?php endif; ?>
				
				<?php if (session('message')): ?>
					<div class="alert alert-success"><?= session('message') ?></div>
				<?php endif; ?>

				<div class="modal">
					<div class="modal-header">
						<div class="modal-title">New Laboratory Request</div>
						<a href="<?= site_url('doctor/lab-requests') ?>" class="close-btn">×</a>
					</div>
					
					<form method="post" action="<?= site_url('doctor/lab-requests/store') ?>">
						<div class="modal-body">
							<!-- Patient Information -->
							<div class="form-grid">
								<div class="form-group">
									<label class="form-label">Patient</label>
									<select name="patient_id" class="form-select" required>
										<option value="">Select Patient</option>
										<?php foreach ($patients as $patient): ?>
											<option value="<?= $patient['id'] ?>">
												<?= esc($patient['first_name'] . ' ' . $patient['last_name']) ?> (ID: <?= $patient['id'] ?>)
											</option>
										<?php endforeach; ?>
									</select>
								</div>
								
								<div class="form-group">
									<label class="form-label">Priority</label>
									<select name="priority" class="form-select" required>
										<option value="Routine">Routine</option>
										<option value="Urgent">Urgent</option>
										<option value="STAT">STAT</option>
									</select>
								</div>
								
								<div class="form-group">
									<label class="form-label">Expected Date</label>
									<input type="date" name="expected_date" class="form-input" required>
								</div>
							</div>

							<!-- Laboratory Tests -->
							<div class="tests-section">
								<div class="tests-title">Select Laboratory Tests</div>
								<div class="tests-grid">
									
									<!-- Hematology -->
									<div class="test-category">
										<div class="category-title">Hematology</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Complete Blood Count" id="cbc">
											<label for="cbc">Complete Blood Count</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Platelet Count" id="platelet">
											<label for="platelet">Platelet Count</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Coagulation Studies" id="coagulation">
											<label for="coagulation">Coagulation Studies</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Hemoglobin" id="hemoglobin">
											<label for="hemoglobin">Hemoglobin</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="ESR" id="esr">
											<label for="esr">ESR</label>
										</div>
									</div>

									<!-- Chemistry -->
									<div class="test-category">
										<div class="category-title">Chemistry</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Basic Metabolic Panel" id="bmp">
											<label for="bmp">Basic Metabolic Panel</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Lipid Profile" id="lipid">
											<label for="lipid">Lipid Profile</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Kidney Function Tests" id="kidney">
											<label for="kidney">Kidney Function Tests</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Comprehensive Metabolic Panel" id="cmp">
											<label for="cmp">Comprehensive Metabolic Panel</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Liver Function Tests" id="liver">
											<label for="liver">Liver Function Tests</label>
										</div>
									</div>

									<!-- Endocrinology -->
									<div class="test-category">
										<div class="category-title">Endocrinology</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="HbA1c" id="hba1c">
											<label for="hba1c">HbA1c</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Thyroid Function Tests" id="thyroid">
											<label for="thyroid">Thyroid Function Tests</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Insulin Level" id="insulin">
											<label for="insulin">Insulin Level</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Fasting Glucose" id="glucose">
											<label for="glucose">Fasting Glucose</label>
										</div>
									</div>

									<!-- Cardiology -->
									<div class="test-category">
										<div class="category-title">Cardiology</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Cardiac Enzymes" id="cardiac_enzymes">
											<label for="cardiac_enzymes">Cardiac Enzymes</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="BNP" id="bnp">
											<label for="bnp">BNP</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Troponin" id="troponin">
											<label for="troponin">Troponin</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="D-Dimer" id="ddimer">
											<label for="ddimer">D-Dimer</label>
										</div>
									</div>

									<!-- Imaging -->
									<div class="test-category">
										<div class="category-title">Imaging</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Chest X-Ray" id="chest_xray">
											<label for="chest_xray">Chest X-Ray</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="MRI" id="mri">
											<label for="mri">MRI</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="ECG" id="ecg">
											<label for="ecg">ECG</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="CT Scan" id="ct_scan">
											<label for="ct_scan">CT Scan</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Ultrasound" id="ultrasound">
											<label for="ultrasound">Ultrasound</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Echocardiogram" id="echo">
											<label for="echo">Echocardiogram</label>
										</div>
									</div>

									<!-- Microbiology -->
									<div class="test-category">
										<div class="category-title">Microbiology</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Blood Culture" id="blood_culture">
											<label for="blood_culture">Blood Culture</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Sputum Culture" id="sputum_culture">
											<label for="sputum_culture">Sputum Culture</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Urine Culture" id="urine_culture">
											<label for="urine_culture">Urine Culture</label>
										</div>
										<div class="test-checkbox">
											<input type="checkbox" name="tests[]" value="Wound Culture" id="wound_culture">
											<label for="wound_culture">Wound Culture</label>
										</div>
									</div>
								</div>
							</div>

							<!-- Clinical Notes -->
							<div class="form-group">
								<label class="form-label">Clinical Notes / Indication</label>
								<textarea name="clinical_notes" class="form-textarea" placeholder="Clinical indication for the requested tests..."></textarea>
							</div>
						</div>
						
						<div class="modal-footer">
							<a href="<?= site_url('doctor/lab-requests') ?>" class="btn btn-secondary">Cancel</a>
							<button type="submit" class="btn btn-primary">Submit Request</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
