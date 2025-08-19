<?php echo view('auth/partials/header', ['title' => 'Backup & Recovery']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Backup & Recovery</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <div class="card form"><h3>Backups</h3><p class="sub">Manage scheduled backups and restore points here.</p></div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<?php echo view('auth/partials/footer'); ?>


