<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Medical Certificate - Print</title>
	<style>
		* { margin:0; padding:0; box-sizing:border-box }
		body { font-family:'Times New Roman', serif; background:#fff; color:#000; line-height:1.6 }
		.certificate { max-width:800px; margin:0 auto; padding:40px; background:#fff; box-shadow:0 0 20px rgba(0,0,0,0.1) }
		.header { text-align:center; margin-bottom:30px; border-bottom:2px solid #2c5aa0; padding-bottom:20px }
		.logo { width:80px; height:80px; background:#2c5aa0; border-radius:50%; margin:0 auto 15px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:24px; font-weight:bold }
		.hospital-name { font-size:24px; font-weight:bold; color:#2c5aa0; margin-bottom:5px }
		.hospital-subtitle { font-size:14px; color:#333; margin-bottom:5px }
		.hospital-address { font-size:12px; color:#666; margin-bottom:5px }
		.hospital-contact { font-size:12px; color:#666; margin-bottom:5px }
		.hospital-email { font-size:12px; color:#666 }
		.title { text-align:center; font-size:28px; font-weight:bold; margin:30px 0; text-transform:uppercase; letter-spacing:2px }
		.date { text-align:right; font-size:14px; margin-bottom:30px }
		.content { margin-bottom:30px }
		.patient-info { margin-bottom:20px; text-align:justify }
		.diagnosis { margin-bottom:20px }
		.diagnosis-title { font-weight:bold; margin-bottom:10px }
		.pregnancy-details { margin-bottom:20px }
		.pregnancy-row { display:flex; justify-content:space-between; margin-bottom:5px }
		.medications { margin-bottom:20px }
		.medications-title { font-weight:bold; margin-bottom:10px }
		.medication-item { margin-left:20px; margin-bottom:5px }
		.notes { margin-bottom:30px }
		.notes-title { font-weight:bold; margin-bottom:10px }
		.doctor-section { text-align:right; margin-top:50px }
		.signature-line { border-top:1px solid #000; width:200px; margin:20px 0 10px auto }
		.doctor-name { font-weight:bold; margin-bottom:5px }
		.doctor-title { font-size:14px; margin-bottom:5px }
		.doctor-license { font-size:12px; color:#666 }
		.disclaimer { text-align:center; font-size:11px; color:#666; margin-top:40px; font-style:italic; border-top:1px solid #ccc; padding-top:20px }
		@media print {
			body { background:#fff }
			.certificate { box-shadow:none; padding:20px }
			.no-print { display:none }
		}
		.print-controls { text-align:center; margin:20px 0; padding:20px; background:#f5f5f5; border-radius:8px }
		.btn { padding:10px 20px; margin:0 10px; border:none; border-radius:5px; cursor:pointer; text-decoration:none; display:inline-block }
		.btn-primary { background:#2c5aa0; color:#fff }
		.btn-secondary { background:#666; color:#fff }
	</style>
</head>
<body>
	<div class="no-print print-controls">
		<button onclick="window.print()" class="btn btn-primary">🖨️ Print Certificate</button>
		<a href="<?= site_url('doctor/medical-certificates') ?>" class="btn btn-secondary">← Back to Certificates</a>
	</div>

	<div class="certificate">
		<div class="header">
			<div class="logo">🏥</div>
			<div class="hospital-name">LACSON HOSPITAL</div>
			<div class="hospital-subtitle">Dr. Gloria D. Lacson General Hospital</div>
			<div class="hospital-address">#180 Maharlika Highway, Castellano, San Leonardo, Nueva Ecija</div>
			<div class="hospital-contact">Telephone Number (044) 486-2432 / Fax Number (044)486-2918</div>
			<div class="hospital-email">Email Address: dgdigh_hospital@yahoo.com</div>
		</div>

		<div class="title">Medical Certificate</div>
		
		<div class="date"><?= date('F d, Y', strtotime($certificate['issue_date'])) ?></div>

		<div class="content">
			<div class="patient-info">
				This is to certify that <strong><?= strtoupper($certificate['patient_name']) ?></strong>, 
				<?= $certificate['patient_age'] ?> years old, <?= $certificate['patient_gender'] ?> 
				from <?= $certificate['patient_address'] ?>, was seen and examined in this hospital 
				on <?= date('F d, Y', strtotime($certificate['issue_date'])) ?> with a diagnosis of:
			</div>

			<div class="diagnosis">
				<div class="diagnosis-title">Diagnosis:</div>
				<div><?= $certificate['diagnosis'] ?></div>
			</div>

			<?php if (!empty($certificate['pregnancy_details'])): ?>
			<div class="pregnancy-details">
				<div class="pregnancy-row">
					<span><strong>LMP:</strong> <?= $certificate['lmp'] ?? 'Unrecalled' ?></span>
				</div>
				<div class="pregnancy-row">
					<span><strong>EDD:</strong> <?= $certificate['edd'] ?? 'N/A' ?></span>
				</div>
			</div>
			<?php endif; ?>

			<?php if (!empty($certificate['notes'])): ?>
			<div class="notes">
				<div class="notes-title">Note:</div>
				<div><?= $certificate['notes'] ?></div>
			</div>
			<?php endif; ?>

			<?php if (!empty($certificate['medications'])): ?>
			<div class="medications">
				<div class="medications-title">Medications:</div>
				<?php 
				$medications = explode("\n", $certificate['medications']);
				foreach ($medications as $medication):
					if (trim($medication)):
				?>
				<div class="medication-item">• <?= trim($medication) ?></div>
				<?php 
					endif;
				endforeach; 
				?>
			</div>
			<?php endif; ?>
		</div>

		<div class="doctor-section">
			<div class="signature-line"></div>
			<div class="doctor-name"><?= strtoupper($certificate['doctor_name']) ?>, MD</div>
			<div class="doctor-title">Attending Physician</div>
			<div class="doctor-license">LIC. NO.: <?= $certificate['doctor_license'] ?></div>
		</div>

		<div class="disclaimer">
			This is issued upon the request of interested party for whatever purpose it may serve; 
			however this cannot be used for Medico Legal Purpose.
		</div>
	</div>
</body>
</html>
