<?php echo view('auth/partials/header', ['title' => 'System Monitoring']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>System Monitoring</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <div class="card form"><h3>Monitoring Dashboard</h3><p class="sub">Placeholder page. Hook metrics and charts here.</p></div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<?php echo view('auth/partials/footer'); ?>


