<?php echo view('auth/partials/header', ['title' => 'User Management']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header"><h1>User Management</h1><?php echo view('auth/partials/userbadge'); ?></header>
        <div class="page-content">
            <div class="stats-grid">
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Total Users</span><div class="stat-icon">👥</div></div><div class="stat-value">124</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Active Today</span><div class="stat-icon">✅</div></div><div class="stat-value">89</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">New This Month</span><div class="stat-icon">🆕</div></div><div class="stat-value">8</div></div>
                <div class="stat-card"><div class="stat-header"><span class="stat-title">Pending Approval</span><div class="stat-icon">⏳</div></div><div class="stat-value">3</div></div>
            </div>
            <div class="patients-table-container">
                <div class="table-header"><h2 class="table-title">User Management</h2><div><button class="btn primary" id="addUserBtn">Add New User</button></div></div>
                <?php if (!empty($message)): ?>
                    <div class="alert success"><?php echo esc($message); ?></div>
                <?php endif; ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert danger">
                        <?php foreach ($errors as $err): ?>
                            <div><?php echo esc($err); ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                <table class="patients-table">
                    <thead><tr><th>User</th><th>Email</th><th>Role</th><th>Department</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php if (!empty($users)): ?>
                            <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><?php echo esc($u['name']); ?></td>
                                    <td><?php echo esc($u['email']); ?></td>
                                    <td><?php echo esc(ucwords(str_replace('_',' ',$u['role']))); ?></td>
                                    <td><?php echo esc($u['department'] ?? 'IT'); ?></td>
                                    <td><span class="badge confirmed"><?php echo esc($u['status'] ?? 'Active'); ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5" style="text-align:center">No users yet.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?php echo view('auth/partials/logout_confirm'); ?>
<div class="modal" id="addUserModal" style="display:none">
    <div class="modal-content" style="max-width:520px">
        <div class="modal-header"><h3>Add IT Staff User</h3><button class="close" id="closeAddUser">×</button></div>
        <form method="post" action="<?php echo site_url('users/store'); ?>" class="form-grid">
            <div class="form-group"><label>Name</label><input type="text" name="name" required value="<?php echo old('name'); ?>"></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" required value="<?php echo old('email'); ?>"></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            <div class="form-group"><label>Confirm Password</label><input type="password" name="password_confirm" required></div>
            <div class="form-group"><label>Role</label>
                <select name="role" required>
                    <?php foreach (($roleOptions ?? []) as $opt): ?>
                        <option value="<?php echo esc($opt); ?>"><?php echo esc(ucwords($opt)); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="modal-actions"><button type="submit" class="btn primary">Create User</button><button type="button" class="btn" id="cancelAddUser">Cancel</button></div>
        </form>
    </div>
    <div class="modal-backdrop"></div>
    <style>
    .modal{position:fixed;inset:0;align-items:center;justify-content:center}
    .modal .modal-backdrop{position:absolute;inset:0;background:#0006}
    .modal .modal-content{position:relative;background:#fff;border-radius:8px;padding:16px;z-index:1}
    .modal .modal-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:12px}
    .modal .form-grid .form-group{margin-bottom:10px}
    .modal .modal-actions{display:flex;gap:8px;justify-content:flex-end;margin-top:8px}
    .modal .close{background:none;border:none;font-size:20px;cursor:pointer}
    </style>
</div>
<script>
const modal=document.getElementById('addUserModal');
document.getElementById('addUserBtn')?.addEventListener('click',()=>{modal.style.display='flex'});
document.getElementById('closeAddUser')?.addEventListener('click',()=>{modal.style.display='none'});
document.getElementById('cancelAddUser')?.addEventListener('click',()=>{modal.style.display='none'});
</script>
<?php echo view('auth/partials/footer'); ?>

