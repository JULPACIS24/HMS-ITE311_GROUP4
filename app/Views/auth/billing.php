<?php echo view('auth/partials/header', ['title' => 'Billing & Payments']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header">
            <h1>Billing & Payments</h1>
        </header>
        <div class="page-content">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Total Revenue</span><div class="stat-icon">💵</div></div><div class="stat-value">$125,430</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Pending Invoices</span><div class="stat-icon">🧾</div></div><div class="stat-value">8,250</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Overdue Payments</span><div class="stat-icon">⏰</div></div><div class="stat-value">3,120</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">This Month</span><div class="stat-icon">📅</div></div><div class="stat-value">$42,680</div></div>
            </div>
            <div class="patients-table-container">
                <div class="table-header">
                    <h2 class="table-title">Recent Invoices</h2>
                    <div>
                        <button class="btn" id="filterBtn">Filter</button>
                        <button class="btn primary" id="exportBtn">Export</button>
                    </div>
                </div>
                <table class="patients-table">
                    <thead><tr><th>Invoice ID</th><th>Patient</th><th>Amount</th><th>Status</th><th>Date</th><th>Payment</th><th>Actions</th></tr></thead>
                    <tbody>
                        <tr><td>INV-2024-001</td><td>Sarah Johnson</td><td>$450.00</td><td><span class="badge completed">Paid</span></td><td>1/15/2024</td><td>Credit Card</td><td class="actions"><a class="btn js-view-invoice" href="#">View</a><a class="btn" href="#">↧</a></td></tr>
                        <tr><td>INV-2024-002</td><td>Michael Brown</td><td>$325.50</td><td><span class="badge pending">Pending</span></td><td>1/14/2024</td><td>Insurance</td><td class="actions"><a class="btn js-view-invoice" href="#">View</a><a class="btn" href="#">↧</a></td></tr>
                        <tr><td>INV-2024-003</td><td>Emily Davis</td><td>$180.00</td><td><span class="badge">Overdue</span></td><td>1/10/2024</td><td>Cash</td><td class="actions"><a class="btn js-view-invoice" href="#">View</a><a class="btn" href="#">↧</a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<script>
document.querySelectorAll('.js-view-invoice').forEach(b=>b.addEventListener('click',e=>{e.preventDefault();alert('Invoice details modal would appear here.');}));
</script>
<?php echo view('auth/partials/footer'); ?>

