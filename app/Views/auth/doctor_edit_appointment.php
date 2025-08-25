<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Doctor • Edit Appointment</title>
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
		.card{background:#fff;border-radius:12px;box-shadow:0 2px 10px rgba(0,0,0,.08);overflow:hidden;max-width:600px;margin:0 auto}
		.card-header{padding:16px 20px;border-bottom:1px solid #ecf0f1;font-weight:700}
		.card-body{padding:20px}
		.form-group{margin-bottom:20px}
		.form-label{display:block;margin-bottom:8px;font-weight:600;color:#374151}
		.form-input{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px}
		.form-input:focus{outline:none;border-color:#2563eb;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
		.form-select{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;background:#fff}
		.form-textarea{width:100%;padding:12px;border:1px solid #d1d5db;border-radius:8px;font-size:14px;min-height:100px;resize:vertical}
		.btn{display:inline-block;padding:12px 24px;border:none;border-radius:8px;font-weight:600;text-decoration:none;cursor:pointer;font-size:14px}
		.btn-primary{background:#2563eb;color:#fff}
		.btn-secondary{background:#6b7280;color:#fff;margin-right:12px}
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
					<h1>Edit Appointment</h1>
					<div class="sub">Update appointment details and status</div>
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
				<div class="card">
					<div class="card-header">Edit Appointment Details</div>
					<div class="card-body">
						<?php if (session('error')): ?>
							<div class="alert alert-error"><?= session('error') ?></div>
						<?php endif; ?>
						
						<?php if (session('message')): ?>
							<div class="alert alert-success"><?= session('message') ?></div>
						<?php endif; ?>

						<form method="post" action="<?= site_url('doctor/appointments/update/' . $appointment['id']) ?>">
							<div class="form-group">
								<label class="form-label">Patient Name</label>
								<input type="text" class="form-input" value="<?= esc($appointment['patient_name']) ?>" readonly>
							</div>

							<div class="form-group">
								<label class="form-label">Appointment Date & Time</label>
								<input type="text" class="form-input" value="<?= date('F j, Y g:i A', strtotime($appointment['date_time'])) ?>" readonly>
							</div>

							<div class="form-group">
								<label class="form-label">Appointment Type</label>
								<input type="text" class="form-input" value="<?= esc($appointment['type']) ?>" readonly>
							</div>

							<div class="form-group">
								<label class="form-label">Status</label>
								<select name="status" class="form-select" required>
									<option value="Pending" <?= $appointment['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
									<option value="Confirmed" <?= $appointment['status'] === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
									<option value="In Progress" <?= $appointment['status'] === 'In Progress' ? 'selected' : '' ?>>In Progress</option>
									<option value="Completed" <?= $appointment['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
									<option value="Cancelled" <?= $appointment['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
								</select>
							</div>

							<div class="form-group">
								<label class="form-label">Room</label>
								<input type="text" name="room" class="form-input" value="<?= esc($appointment['room'] ?? '') ?>" placeholder="Enter room number">
							</div>

							<div class="form-group">
								<label class="form-label">Notes</label>
								<textarea name="notes" class="form-textarea" placeholder="Enter appointment notes"><?= esc($appointment['notes'] ?? '') ?></textarea>
							</div>

							<div style="text-align:right">
								<a href="<?= site_url('doctor/appointments') ?>" class="btn btn-secondary">Cancel</a>
								<button type="submit" class="btn btn-primary">Update Appointment</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
