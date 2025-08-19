<?php echo view('auth/partials/header', ['title' => 'Security & Access']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Security & Access</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <div class="card form"><h3>Security Center</h3><p class="sub">Configure authentication, access policies, and audits here.</p></div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<?php echo view('auth/partials/footer'); ?>


