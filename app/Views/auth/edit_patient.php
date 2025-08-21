<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/appointments.css') ?>">
</head>
<body>
    <div class="container">
        <?php echo view('auth/partials/sidebar'); ?>
        <main class="main-content">
            <header class="header">
                <h1>Edit Patient</h1>
                <div class="user-info"><div class="user-avatar">A</div><span>Admin</span></div>
            </header>
            <div class="page-content">
                <?php if (! empty(session('errors'))): ?>
                    <div style="background:#fee;color:#b00020;padding:12px;border-radius:8px;margin-bottom:12px;">
                        <?= implode('<br>', (array) session('errors')) ?>
                    </div>
                <?php endif; ?>
                <form class="card form" method="post" action="<?= site_url('patients/update/' . $patient['id']) ?>">
                    <div class="grid-2">
                        <label>
                            <span>Phone *</span>
                            <input type="text" name="phone" value="<?= esc($patient['phone'] ?? '') ?>" required>
                        </label>
                        <label>
                            <span>Email</span>
                            <input type="text" name="email" value="<?= esc($patient['email'] ?? '') ?>">
                        </label>
                    </div>
                    <p style="color:#7f8c8d;margin-top:6px">Only phone and email are editable here.</p>
                    <div class="form-actions">
                        <a href="<?= site_url('patients') ?>" class="btn">Cancel</a>
                        <button class="btn primary" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>


