<?php echo view('auth/partials/header', ['title' => 'Settings']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>Settings</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <div class="patients-table-container">
                <div class="table-header"><h2 class="table-title">General Settings</h2></div>
                <form class="card form" onsubmit="event.preventDefault();alert('Settings saved');">
                    <div class="grid-2">
                        <label><span>Hospital Name</span><input type="text" value="General Hospital"></label>
                        <label><span>Email Address</span><input type="text" value="admin@hospital.com"></label>
                    </div>
                    <div class="grid-2">
                        <label><span>Phone Number</span><input type="text" value="+1 (555) 123-4567"></label>
                        <label><span>Time Zone</span><input type="text" value="EST"></label>
                    </div>
                    <div class="form-actions"><button class="btn">Reset to Default</button><button class="btn primary" type="submit">Save Changes</button></div>
                </form>
            </div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<?php echo view('auth/partials/footer'); ?>

