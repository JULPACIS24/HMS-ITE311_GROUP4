<?php echo view('auth/partials/header', ['title' => 'Maintenance']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Maintenance</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <div class="card form"><h3>System Maintenance</h3><p class="sub">Run maintenance tasks and scheduling.</p></div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<?php echo view('auth/partials/footer'); ?>


