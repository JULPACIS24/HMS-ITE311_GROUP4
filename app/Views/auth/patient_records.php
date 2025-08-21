<?php echo view('auth/partials/header', ['title' => 'Patient Records']); ?>
<div class="container">
	<?php echo view('auth/partials/sidebar'); ?>
	<main class="main-content">
		<header class="header">
			<div>
				<h1>Patient Records</h1>
				<div class="sub" style="color:#64748b">View and manage detailed patient medical records</div>
			</div>
			<?php echo view('auth/partials/userbadge'); ?>
		</header>
		<div class="page-content">
			<div style="display:grid; grid-template-columns:360px 1fr; gap:18px;">
				<div>
					<div class="card form" style="padding:12px 12px 0; margin-bottom:12px">
						<input type="text" class="search-input" id="prSearch" placeholder="Search patient records...">
					</div>
					<div class="patients-table-container" style="overflow:hidden">
						<div id="prList">
							<?php foreach (($patients ?? []) as $p): ?>
								<a href="<?= site_url('patients/view/'. $p['id']) ?>" class="pr-item" data-id="<?= $p['id'] ?>" style="display:flex;align-items:center;gap:12px;padding:14px 16px;text-decoration:none;color:#0f172a;border-bottom:1px solid #ecf0f1">
									<div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:grid;place-items:center;color:#2563eb;font-weight:800">👤</div>
									<div style="display:flex;flex-direction:column">
										<strong><?= esc(($p['first_name'] ?? '').' '.($p['last_name'] ?? '')) ?></strong>
										<span class="sub" style="color:#64748b;font-size:12px">P<?= esc(str_pad((string)$p['id'],3,'0',STR_PAD_LEFT)) ?> • 45y • <?= esc($p['gender'] ?? '') ?></span>
									</div>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
				<div class="patients-table-container" style="display:grid; place-items:center; min-height:480px">
					<div style="text-align:center; color:#94a3b8">
						<div style="font-size:52px; line-height:1">👥</div>
						<div style="font-weight:700; color:#0f172a; margin-top:6px">Select a Patient</div>
						<div class="sub">Choose a patient from the list to view their medical records</div>
					</div>
				</div>
			</div>
		</div>
	</main>
</div>
<script>
	const prSearch = document.getElementById('prSearch');
	prSearch?.addEventListener('input', ()=>{
		const q = prSearch.value.toLowerCase();
		document.querySelectorAll('.pr-item').forEach(el=>{
			el.style.display = el.textContent.toLowerCase().includes(q) ? '' : 'none';
		});
	});
</script>
<?php echo view('auth/partials/footer'); ?>
