<?php echo view('auth/partials/header', ['title' => 'Edit Branch']); ?>
<div class="container">
    <?php echo view('auth/partials/sidebar'); ?>
    <main class="main-content">
        <header class="header">
            <div>
                <h1>Edit Branch</h1>
                <p style="color: #666; margin: 0;">Update branch information and settings.</p>
            </div>
            <div>
                <a href="<?php echo site_url('branch-management'); ?>" class="btn secondary">← Back to Branches</a>
            </div>
        </header>
        
        <div class="page-content">
            <?php if (!empty($message)): ?>
                <div class="alert success"><?php echo esc($message); ?></div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="alert danger">
                    <?php if (is_array($errors)): ?>
                        <?php foreach ($errors as $err): ?>
                            <div><?php echo esc($err); ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div><?php echo esc($errors); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="form-container">
                <form method="post" action="<?php echo site_url('branch-management/edit/' . $branch['id']); ?>" class="form-grid">
                    <div class="form-section">
                        <h3>Basic Information</h3>
                        
                        <div class="form-group">
                            <label>Branch Name *</label>
                            <input type="text" name="name" required value="<?php echo esc($branch['name']); ?>" placeholder="San Miguel Hospital - Branch Name">
                        </div>
                        
                        <div class="form-group">
                            <label>Location *</label>
                            <input type="text" name="location" required value="<?php echo esc($branch['location']); ?>" placeholder="City, Province">
                        </div>
                        
                        <div class="form-group">
                            <label>Branch Type *</label>
                            <select name="type" required>
                                <option value="">Select Type</option>
                                <?php foreach ($branchTypes as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo $branch['type'] == $value ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Bed Capacity *</label>
                            <input type="number" name="bed_capacity" required min="0" value="<?php echo esc($branch['bed_capacity']); ?>" placeholder="0">
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Management & Contact</h3>
                        
                        <div class="form-group">
                            <label>Branch Manager</label>
                            <input type="text" name="manager_name" value="<?php echo esc($branch['manager_name']); ?>" placeholder="Dr. Name">
                        </div>
                        
                        <div class="form-group">
                            <label>Contact Number</label>
                            <input type="text" name="contact_number" value="<?php echo esc($branch['contact_number']); ?>" placeholder="Phone number">
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" value="<?php echo esc($branch['email']); ?>" placeholder="branch@hospital.com">
                        </div>
                        
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" placeholder="Complete address" rows="3"><?php echo esc($branch['address']); ?></textarea>
                        </div>
                    </div>

                    <div class="form-section">
                        <h3>Operations</h3>
                        
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status">
                                <?php foreach ($statuses as $value => $label): ?>
                                    <option value="<?php echo $value; ?>" <?php echo $branch['status'] == $value ? 'selected' : ''; ?>>
                                        <?php echo $label; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label>Opening Hours</label>
                            <input type="text" name="opening_hours" value="<?php echo esc($branch['opening_hours']); ?>" placeholder="24/7">
                        </div>
                        
                        <div class="form-group">
                            <label>Departments</label>
                            <div class="checkbox-group">
                                <?php 
                                $branchDepartments = json_decode($branch['departments'] ?? '[]', true);
                                foreach ($departments as $key => $label): 
                                ?>
                                    <label class="checkbox-item">
                                        <input type="checkbox" name="departments[]" value="<?php echo $key; ?>" 
                                               <?php echo in_array($key, $branchDepartments) ? 'checked' : ''; ?>>
                                        <span><?php echo $label; ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" class="btn secondary" onclick="history.back()">Cancel</button>
                        <button type="submit" class="btn primary">Update Branch</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</div>

<style>
.form-container {
    max-width: 800px;
    margin: 0 auto;
}

.form-section {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.form-section h3 {
    margin: 0 0 20px 0;
    color: #374151;
    font-size: 1.1em;
    border-bottom: 2px solid #f3f4f6;
    padding-bottom: 10px;
}

.checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 10px;
    margin-top: 10px;
}

.checkbox-item {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
}

.checkbox-item input[type="checkbox"] {
    margin: 0;
}

.form-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}
</style>

<?php echo view('auth/partials/footer'); ?>
