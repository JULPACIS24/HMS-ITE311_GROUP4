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
		
		
		.modal-footer{padding:20px;border-top:1px solid #ecf0f1;display:flex;justify-content:flex-end;gap:12px}
		.form-container{background:#fff;border-radius:12px;box-shadow:0 20px 25px -5px rgba(0,0,0,.1),0 10px 10px -5px rgba(0,0,0,.04);max-width:800px;margin:0 auto;overflow:hidden}
		.form-header{padding:20px;border-bottom:1px solid #ecf0f1;display:flex;justify-content:space-between;align-items:center}
		.form-header h2{font-size:18px;font-weight:700;color:#0f172a;margin:0}
		.form-body{padding:20px;max-height:70vh;overflow-y:auto}
		.form-footer{padding:20px;border-top:1px solid #ecf0f1;display:flex;justify-content:flex-end;gap:12px}
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

				<div class="form-container">
					<div class="form-header">
						<h2>New Laboratory Request</h2>
						<a href="<?= site_url('doctor/lab-requests') ?>" class="btn btn-secondary">← Back</a>
					</div>
					
					<form method="post" action="<?= site_url('doctor/lab-requests/store') ?>" class="lab-request-form">
						<?= csrf_field() ?>
						<div class="form-body">
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

							<!-- Test Type -->
							<div class="form-group">
								<label class="form-label">Test Type</label>
								<select name="test_type" class="form-select" required>
									<option value="">Select Test Type</option>
									<option value="Complete Blood Count">Complete Blood Count</option>
									<option value="Basic Metabolic Panel">Basic Metabolic Panel</option>
									<option value="Lipid Profile">Lipid Profile</option>
									<option value="Liver Function Test">Liver Function Test</option>
									<option value="Urinalysis">Urinalysis</option>
									<option value="Chest X-Ray">Chest X-Ray</option>
									<option value="CT Scan">CT Scan</option>
									<option value="MRI">MRI</option>
									<option value="ECG">ECG</option>
									<option value="Blood Glucose">Blood Glucose</option>
									<option value="Thyroid Function Test">Thyroid Function Test</option>
									<option value="Blood Culture">Blood Culture</option>
									<option value="Other">Other</option>
								</select>
							</div>

							<!-- Clinical Notes -->
							<div class="form-group">
								<label class="form-label">Clinical Notes / Indication</label>
								<textarea name="clinical_notes" class="form-textarea" placeholder="Clinical indication for the requested tests..."></textarea>
							</div>
						</div>
						
						<div class="form-footer">
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
