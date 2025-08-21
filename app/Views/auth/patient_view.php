<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/appointments.css') ?>">
</head>
<body>
    <div class="container">
        <?php echo view('auth/partials/sidebar'); ?>
        <main class="main-content">
            <header class="header"><h1>Patient Details</h1><div class="user-info"><div class="user-avatar">A</div><span>Admin</span></div></header>
            <div class="page-content">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-content">
                        <?php if (empty($patient)): ?>
                            <p>No patient data found.</p>
                        <?php else: ?>
                            <p><strong>Name:</strong> <?= esc(($patient['first_name'] ?? '') . ' ' . ($patient['last_name'] ?? '')) ?></p>
                            <p><strong>Phone:</strong> <?= esc($patient['phone'] ?? '') ?></p>
                            <p><strong>Email:</strong> <?= esc($patient['email'] ?? '') ?></p>
                            <p><strong>Gender:</strong> <?= esc($patient['gender'] ?? '') ?></p>
                            <p><strong>DOB:</strong> <?= esc($patient['dob'] ?? '') ?></p>
                            <p><strong>Address:</strong> <?= esc($patient['address'] ?? '') ?></p>
                        <?php endif; ?>
                        <div class="form-actions" style="justify-content:flex-start;margin-top:16px">
                            <a class="btn" href="<?= site_url('patients') ?>">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>


