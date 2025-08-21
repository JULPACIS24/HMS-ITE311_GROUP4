<?php echo view('auth/partials/header', ['title' => 'Pharmacy & Inventory']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Pharmacy & Inventory</h1></header>
        <div class="page-content">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Total Items</span><div class="stat-icon">📦</div></div><div class="stat-value">247</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Critical Stock</span><div class="stat-icon">⚠️</div></div><div class="stat-value">2</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Low Stock Items</span><div class="stat-icon">🟡</div></div><div class="stat-value">5</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Well Stocked</span><div class="stat-icon">✅</div></div><div class="stat-value">189</div></div>
            </div>
            <div class="patients-table-container">
                <div class="table-header"><h2 class="table-title">Inventory Management</h2><div><button class="btn">All Categories</button><button class="btn primary" id="addItemBtn">+ Add Item</button></div></div>
                <table class="patients-table">
                    <thead><tr><th>Item Details</th><th>Stock Level</th><th>Supplier</th><th>Expiry Date</th><th>Status</th><th>Act</th></tr></thead>
                    <tbody>
                        <tr><td>Paracetamol 500mg</td><td>15 Tablets</td><td>PharmaCorp</td><td>6/15/2025</td><td><span class="badge pending">Low Stock</span></td><td class="actions"><a href="#" class="btn js-item-view">View</a></td></tr>
                        <tr><td>Amoxicillin 250mg</td><td>8 Capsules</td><td>MediSupply</td><td>3/20/2025</td><td><span class="badge">Critical</span></td><td class="actions"><a href="#" class="btn js-item-view">View</a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <?php echo view('auth/partials/logout_confirm'); ?>
</div>
<script>
document.querySelectorAll('.js-item-view').forEach(b=>b.addEventListener('click',e=>{e.preventDefault();alert('Inventory item details modal would appear here.');}));
</script>
<?php echo view('auth/partials/footer'); ?>

