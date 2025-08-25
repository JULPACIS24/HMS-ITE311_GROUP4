<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Alerts - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .stock-alerts {
            padding: 20px;
            background: #f8fafc;
            min-height: 100vh;
        }
        
        .page-header {
            margin-bottom: 30px;
        }
        
        .page-title {
            color: #1e293b;
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        
        .page-subtitle {
            color: #64748b;
            margin: 5px 0 0 0;
            font-size: 16px;
        }
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .summary-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            text-align: center;
        }
        
        .card-number {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
            margin-bottom: 8px;
        }
        
        .card-number.red { color: #dc2626; }
        .card-number.orange { color: #ea580c; }
        .card-number.yellow { color: #ca8a04; }
        .card-number.blue { color: #2563eb; }
        
        .card-label {
            font-size: 16px;
            font-weight: 600;
            color: #1e293b;
            margin: 0;
            margin-bottom: 4px;
        }
        
        .card-subtitle {
            font-size: 14px;
            color: #64748b;
            margin: 0;
        }
        
        .action-bar {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }
        
        .search-section {
            display: flex;
            gap: 12px;
            align-items: center;
            flex: 1;
        }
        
        .search-input {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            min-width: 250px;
        }
        
        .filter-dropdown {
            padding: 10px 16px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            min-width: 150px;
        }
        
        .alert-settings-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            white-space: nowrap;
            transition: background 0.3s ease;
        }
        
        .alert-settings-btn:hover {
            background: #1d4ed8;
        }
        
        .alerts-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .alert-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
            border-left: 4px solid #d1d5db;
            position: relative;
        }
        
        .alert-card.critical { border-left-color: #dc2626; }
        .alert-card.high { border-left-color: #ea580c; }
        .alert-card.medium { border-left-color: #ca8a04; }
        .alert-card.low { border-left-color: #2563eb; }
        
        .alert-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 16px;
        }
        
        .alert-info h3 {
            color: #1e293b;
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .alert-tags {
            display: flex;
            gap: 8px;
            margin-top: 8px;
        }
        
        .alert-tag {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .tag-priority { background: #fef3c7; color: #d97706; }
        .tag-type { background: #f1f5f9; color: #64748b; }
        
        .alert-timestamp {
            color: #64748b;
            font-size: 12px;
            text-align: right;
        }
        
        .alert-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 20px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
        }
        
        .detail-label {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 4px;
        }
        
        .detail-value {
            font-size: 14px;
            color: #1e293b;
            font-weight: 500;
        }
        
        .alert-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-reorder { background: #10b981; color: white; }
        .btn-reorder:hover { background: #059669; }
        
        .btn-remove { background: #f59e0b; color: white; }
        .btn-remove:hover { background: #d97706; }
        
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        
        .btn-dismiss { background: #6b7280; color: white; }
        .btn-dismiss:hover { background: #4b5563; }
        
        @media (max-width: 1200px) {
            .summary-cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .summary-cards {
                grid-template-columns: 1fr;
            }
            
            .action-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-section {
                flex-direction: column;
                align-items: stretch;
            }
            
            .search-input,
            .filter-dropdown {
                min-width: auto;
            }
            
            .alert-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 12px;
            }
            
            .alert-timestamp {
                text-align: left;
            }
            
            .alert-actions {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('auth/partials/sidebar') ?>
    
    <div class="main-content">
        <?= $this->include('auth/partials/header') ?>
        
        <div class="stock-alerts">
            <div class="page-header">
                <h1 class="page-title">Stock Alerts</h1>
                <p class="page-subtitle">Monitor inventory alerts and notifications</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <h2 class="card-number red"><?= $stats['critical_alerts'] ?? 0 ?></h2>
                    <p class="card-label">Critical Alerts</p>
                    <p class="card-subtitle">Immediate attention</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number orange"><?= $stats['high_priority'] ?? 0 ?></h2>
                    <p class="card-label">High Priority</p>
                    <p class="card-subtitle">Action needed</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number yellow"><?= $stats['medium_priority'] ?? 0 ?></h2>
                    <p class="card-label">Medium Priority</p>
                    <p class="card-subtitle">Monitor closely</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number blue"><?= $stats['low_priority'] ?? 0 ?></h2>
                    <p class="card-label">Low Priority</p>
                    <p class="card-subtitle">General awareness</p>
                </div>
            </div>
            
            <div class="action-bar">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Search alerts...">
                    <select class="filter-dropdown" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="Active">Active</option>
                        <option value="Dismissed">Dismissed</option>
                        <option value="Reorder Requested">Reorder Requested</option>
                        <option value="Removed from Stock">Removed from Stock</option>
                    </select>
                    <select class="filter-dropdown" id="typeFilter">
                        <option value="">All Types</option>
                        <option value="Low Stock">Low Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                        <option value="Expiring Soon">Expiring Soon</option>
                        <option value="Expired">Expired</option>
                    </select>
                </div>
                                 <button class="alert-settings-btn" onclick="showAlertSettings()">Alert Settings</button>
            </div>
            
            <div class="alerts-list">
                <?php if (!empty($alerts)): ?>
                    <?php foreach ($alerts as $alert): ?>
                        <?php 
                        $priorityClass = strtolower($alert['priority']);
                        $isExpired = isset($alert['days_remaining']) && $alert['days_remaining'] < 0;
                        ?>
                        <div class="alert-card <?= $priorityClass ?>">
                            <div class="alert-header">
                                <div class="alert-info">
                                    <h3><?= esc($alert['medication_name']) ?></h3>
                                    <div class="alert-tags">
                                        <span class="alert-tag tag-priority"><?= esc($alert['priority']) ?></span>
                                        <span class="alert-tag tag-type"><?= esc($alert['alert_type']) ?></span>
                                        <span class="alert-tag tag-status" style="background: <?= $alert['status'] === 'Active' ? '#10b981' : ($alert['status'] === 'Reorder Requested' ? '#f59e0b' : '#6b7280'); ?>; color: white;"><?= esc($alert['status']) ?></span>
                                    </div>
                                </div>
                                <div class="alert-timestamp">
                                    <?= date('M d, Y g:i A', strtotime($alert['created_at'])) ?>
                                </div>
                            </div>
                            
                            <div class="alert-details">
                                <?php if ($alert['alert_type'] === 'Low Stock' || $alert['alert_type'] === 'Out of Stock'): ?>
                                    <div class="detail-item">
                                        <span class="detail-label">Current Stock</span>
                                        <span class="detail-value"><?= esc($alert['current_stock']) ?> units</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Minimum Required</span>
                                        <span class="detail-value"><?= esc($alert['minimum_required']) ?> units</span>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($alert['alert_type'] === 'Expiring Soon' || $alert['alert_type'] === 'Expired'): ?>
                                    <div class="detail-item">
                                        <span class="detail-label">Expiry Date</span>
                                        <span class="detail-value"><?= esc($alert['expiry_date']) ?></span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Days Remaining</span>
                                        <span class="detail-value" style="color: <?= $isExpired ? '#dc2626' : '#ca8a04' ?>">
                                            <?= esc($alert['days_remaining']) ?> days
                                        </span>
                                    </div>
                                    <?php if (!empty($alert['batch_number'])): ?>
                                        <div class="detail-item">
                                            <span class="detail-label">Batch Number</span>
                                            <span class="detail-value"><?= esc($alert['batch_number']) ?></span>
                                        </div>
                                    <?php endif; ?>
                                    <div class="detail-item">
                                        <span class="detail-label">Stock Affected</span>
                                        <span class="detail-value"><?= esc($alert['current_stock']) ?> units</span>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="detail-item">
                                    <span class="detail-label">Location</span>
                                    <span class="detail-value"><?= esc($alert['location']) ?></span>
                                </div>
                                
                                <div class="detail-item">
                                    <span class="detail-label">Supplier</span>
                                    <span class="detail-value"><?= esc($alert['supplier']) ?></span>
                                </div>
                            </div>
                            
                            <div class="alert-actions">
                                <?php if (($alert['alert_type'] === 'Low Stock' || $alert['alert_type'] === 'Out of Stock') && $alert['status'] === 'Active'): ?>
                                    <button class="action-btn btn-reorder" onclick="updateAlertStatus(<?= $alert['id'] ?>, 'reorder')">Reorder Stock</button>
                                <?php endif; ?>
                                
                                <?php if ($alert['alert_type'] === 'Expired' && $alert['status'] === 'Active'): ?>
                                    <button class="action-btn btn-remove" onclick="updateAlertStatus(<?= $alert['id'] ?>, 'remove')">Remove from Stock</button>
                                <?php endif; ?>
                                
                                <button class="action-btn btn-view" onclick="viewAlertDetails(<?= $alert['id'] ?>)">View Details</button>
                                
                                <?php if ($alert['status'] === 'Active'): ?>
                                    <button class="action-btn btn-dismiss" onclick="updateAlertStatus(<?= $alert['id'] ?>, 'dismiss')">Dismiss Alert</button>
                                <?php endif; ?>
                                
                                <?php if ($alert['status'] !== 'Active'): ?>
                                    <button class="action-btn btn-reactivate" onclick="updateAlertStatus(<?= $alert['id'] ?>, 'reactivate')" style="background: #10b981; color: white;">Reactivate Alert</button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="alert-card">
                        <div style="text-align: center; padding: 40px;">
                            <h3 style="color: #64748b; margin-bottom: 10px;">No Alerts Found</h3>
                            <p style="color: #94a3b8;">All inventory levels are within normal ranges.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <script>
                 // Update Alert Status Function
         function updateAlertStatus(alertId, action) {
             const actionText = {
                 'dismiss': 'dismiss',
                 'reorder': 'request reorder for',
                 'remove': 'remove from stock',
                 'reactivate': 'reactivate'
             };
             
             if (confirm(`Are you sure you want to ${actionText[action]} this alert?`)) {
                 // Show loading state
                 const button = event.target;
                 const originalText = button.textContent;
                 button.textContent = 'Processing...';
                 button.disabled = true;
                 
                 const formData = new FormData();
                 formData.append('alert_id', alertId);
                 formData.append('action', action);
                 
                 fetch('<?= site_url('pharmacy/update-alert-status') ?>', {
                     method: 'POST',
                     body: formData,
                     headers: {
                         'X-Requested-With': 'XMLHttpRequest'
                     }
                 })
                 .then(response => {
                     if (!response.ok) {
                         throw new Error('Network response was not ok: ' + response.status);
                     }
                     return response.json();
                 })
                 .then(data => {
                     if (data.success) {
                         // Show success message
                         showNotification('Alert updated successfully!', 'success');
                         setTimeout(() => {
                             location.reload();
                         }, 1000);
                     } else {
                         showNotification('Error: ' + (data.message || 'Failed to update alert'), 'error');
                         // Reset button
                         button.textContent = originalText;
                         button.disabled = false;
                     }
                 })
                 .catch(error => {
                     console.error('Error:', error);
                     showNotification('Error updating alert: ' + error.message, 'error');
                     // Reset button
                     button.textContent = originalText;
                     button.disabled = false;
                 });
             }
         }
         
         // View Alert Details Function
         function viewAlertDetails(alertId) {
             // Show loading state
             const button = event.target;
             const originalText = button.textContent;
             button.textContent = 'Loading...';
             button.disabled = true;
             
             fetch(`<?= site_url('pharmacy/alert-details') ?>/${alertId}`)
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         const alert = data.data;
                         showAlertDetailsModal(alert);
                     } else {
                         showNotification('Error: ' + (data.message || 'Failed to load alert details'), 'error');
                     }
                     // Reset button
                     button.textContent = originalText;
                     button.disabled = false;
                 })
                 .catch(error => {
                     console.error('Error:', error);
                     showNotification('Error loading alert details. Please try again.', 'error');
                     // Reset button
                     button.textContent = originalText;
                     button.disabled = false;
                 });
         }
         
         // Show Alert Details Modal
         function showAlertDetailsModal(alert) {
             const modal = document.createElement('div');
             modal.style.cssText = 'position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; display:flex; align-items:center; justify-content:center;';
             
             const priorityColor = {
                 'Critical': '#dc2626',
                 'High': '#ea580c',
                 'Medium': '#ca8a04',
                 'Low': '#2563eb'
             };
             
             modal.innerHTML = `
                 <div style="background:#fff; border-radius:16px; width:90%; max-width:600px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                     <div style="padding:24px 32px; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
                         <h2 style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">Alert Details</h2>
                         <button onclick="this.closest('.alert-details-modal').remove()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">×</button>
                     </div>
                     <div style="padding:32px;">
                         <div style="margin-bottom:24px;">
                             <h3 style="margin:0 0 16px 0; color:#1e293b; font-size:20px;">${alert.medication_name}</h3>
                             <div style="display:flex; gap:8px; margin-bottom:16px;">
                                 <span style="padding:4px 12px; border-radius:12px; font-size:12px; font-weight:500; background:${priorityColor[alert.priority]}; color:white;">${alert.priority}</span>
                                 <span style="padding:4px 12px; border-radius:12px; font-size:12px; font-weight:500; background:#f1f5f9; color:#64748b;">${alert.alert_type}</span>
                             </div>
                         </div>
                         
                         <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:16px; margin-bottom:24px;">
                             <div>
                                 <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Alert ID</label>
                                 <p style="margin:0; font-weight:500; color:#1e293b;">${alert.alert_id}</p>
                             </div>
                             <div>
                                 <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Status</label>
                                 <p style="margin:0; font-weight:500; color:#1e293b;">${alert.status}</p>
                             </div>
                             <div>
                                 <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Location</label>
                                 <p style="margin:0; font-weight:500; color:#1e293b;">${alert.location}</p>
                             </div>
                             <div>
                                 <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Supplier</label>
                                 <p style="margin:0; font-weight:500; color:#1e293b;">${alert.supplier}</p>
                             </div>
                             ${alert.current_stock !== null ? `
                                 <div>
                                     <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Current Stock</label>
                                     <p style="margin:0; font-weight:500; color:#1e293b;">${alert.current_stock} units</p>
                                 </div>
                             ` : ''}
                             ${alert.minimum_required !== null ? `
                                 <div>
                                     <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Minimum Required</label>
                                     <p style="margin:0; font-weight:500; color:#1e293b;">${alert.minimum_required} units</p>
                                 </div>
                             ` : ''}
                             ${alert.expiry_date !== null ? `
                                 <div>
                                     <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Expiry Date</label>
                                     <p style="margin:0; font-weight:500; color:#1e293b;">${alert.expiry_date}</p>
                                 </div>
                             ` : ''}
                             ${alert.days_remaining !== null ? `
                                 <div>
                                     <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Days Remaining</label>
                                     <p style="margin:0; font-weight:500; color:${alert.days_remaining < 0 ? '#dc2626' : '#ca8a04'};">${alert.days_remaining} days</p>
                                 </div>
                             ` : ''}
                             ${alert.batch_number !== null ? `
                                 <div>
                                     <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Batch Number</label>
                                     <p style="margin:0; font-weight:500; color:#1e293b;">${alert.batch_number}</p>
                                 </div>
                             ` : ''}
                         </div>
                         
                         ${alert.description ? `
                             <div style="margin-bottom:16px;">
                                 <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Description</label>
                                 <p style="margin:0; color:#1e293b;">${alert.description}</p>
                             </div>
                         ` : ''}
                         
                         <div style="display:flex; gap:8px; margin-top:24px;">
                             <div>
                                 <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Created</label>
                                 <p style="margin:0; font-size:12px; color:#64748b;">${new Date(alert.created_at).toLocaleString()}</p>
                             </div>
                             <div>
                                 <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Last Updated</label>
                                 <p style="margin:0; font-size:12px; color:#64748b;">${new Date(alert.updated_at).toLocaleString()}</p>
                             </div>
                         </div>
                     </div>
                 </div>
             `;
             
             modal.className = 'alert-details-modal';
             document.body.appendChild(modal);
             
             // Close modal when clicking outside
             modal.addEventListener('click', (e) => {
                 if (e.target === modal) {
                     modal.remove();
                 }
             });
         }
         
                   // Show Alert Settings Modal
          function showAlertSettings() {
              const modal = document.createElement('div');
              modal.style.cssText = 'position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; display:flex; align-items:center; justify-content:center;';
              
              modal.innerHTML = `
                  <div style="background:#fff; border-radius:16px; width:90%; max-width:500px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                      <div style="padding:24px 32px; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
                          <h2 style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">Alert Settings</h2>
                          <button onclick="this.closest('.alert-settings-modal').remove()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">×</button>
                      </div>
                      <div style="padding:32px;">
                          <div style="margin-bottom:24px;">
                              <h3 style="margin:0 0 16px 0; color:#1e293b;">Notification Preferences</h3>
                              <div style="display:flex; flex-direction:column; gap:12px;">
                                  <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                      <input type="checkbox" checked style="width:16px; height:16px;">
                                      <span>Email notifications for critical alerts</span>
                                  </label>
                                  <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                      <input type="checkbox" checked style="width:16px; height:16px;">
                                      <span>SMS notifications for high priority alerts</span>
                                  </label>
                                  <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                      <input type="checkbox" style="width:16px; height:16px;">
                                      <span>Desktop notifications</span>
                                  </label>
                              </div>
                          </div>
                          
                          <div style="margin-bottom:24px;">
                              <h3 style="margin:0 0 16px 0; color:#1e293b;">Threshold Settings</h3>
                              <div style="display:grid; grid-template-columns: 1fr 1fr; gap:16px;">
                                  <div>
                                      <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Low Stock Threshold (%)</label>
                                      <input type="number" value="20" min="0" max="100" style="width:100%; padding:8px; border:1px solid #d1d5db; border-radius:4px;">
                                  </div>
                                  <div>
                                      <label style="font-size:12px; color:#64748b; margin-bottom:4px; display:block;">Expiry Warning (days)</label>
                                      <input type="number" value="30" min="1" max="365" style="width:100%; padding:8px; border:1px solid #d1d5db; border-radius:4px;">
                                  </div>
                              </div>
                          </div>
                          
                          <div style="margin-bottom:24px;">
                              <h3 style="margin:0 0 16px 0; color:#1e293b;">Auto-Actions</h3>
                              <div style="display:flex; flex-direction:column; gap:12px;">
                                  <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                      <input type="checkbox" style="width:16px; height:16px;">
                                      <span>Auto-dismiss alerts after 7 days</span>
                                  </label>
                                  <label style="display:flex; align-items:center; gap:8px; cursor:pointer;">
                                      <input type="checkbox" style="width:16px; height:16px;">
                                      <span>Auto-generate reorder requests for critical alerts</span>
                                  </label>
                              </div>
                          </div>
                          
                          <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:32px; padding-top:24px; border-top:1px solid #e5e7eb;">
                              <button onclick="this.closest('.alert-settings-modal').remove()" style="padding:12px 24px; background:#f3f4f6; color:#374151; border:1px solid #d1d5db; border-radius:8px; font-weight:600; cursor:pointer;">Cancel</button>
                              <button onclick="saveAlertSettings()" style="padding:12px 24px; background:#2563eb; color:#fff; border:none; border-radius:8px; font-weight:600; cursor:pointer;">Save Settings</button>
                          </div>
                      </div>
                  </div>
              `;
              
              modal.className = 'alert-settings-modal';
              document.body.appendChild(modal);
              
              // Close modal when clicking outside
              modal.addEventListener('click', (e) => {
                  if (e.target === modal) {
                      modal.remove();
                  }
              });
          }
          
          // Save Alert Settings Function
          function saveAlertSettings() {
              showNotification('Alert settings saved successfully!', 'success');
              document.querySelector('.alert-settings-modal').remove();
          }
          
          // Show Notification Function
          function showNotification(message, type) {
              const notification = document.createElement('div');
              notification.style.cssText = `
                  position: fixed;
                  top: 20px;
                  right: 20px;
                  padding: 16px 24px;
                  border-radius: 8px;
                  color: white;
                  font-weight: 500;
                  z-index: 10000;
                  animation: slideIn 0.3s ease;
                  background: ${type === 'success' ? '#10b981' : '#ef4444'};
              `;
              notification.textContent = message;
              
              // Add animation CSS
              if (!document.querySelector('#notification-styles')) {
                  const style = document.createElement('style');
                  style.id = 'notification-styles';
                  style.textContent = `
                      @keyframes slideIn {
                          from { transform: translateX(100%); opacity: 0; }
                          to { transform: translateX(0); opacity: 1; }
                      }
                  `;
                  document.head.appendChild(style);
              }
              
              document.body.appendChild(notification);
              
              // Remove notification after 3 seconds
              setTimeout(() => {
                  notification.remove();
              }, 3000);
          }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.alert-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
                 // Filter functionality
         function applyFilters() {
             const statusFilter = document.getElementById('statusFilter').value;
             const typeFilter = document.getElementById('typeFilter').value;
             const searchTerm = document.querySelector('.search-input').value.toLowerCase();
             
             const cards = document.querySelectorAll('.alert-card');
             
             cards.forEach(card => {
                 const statusTag = card.querySelector('.tag-status');
                 const typeTag = card.querySelector('.tag-type');
                 const text = card.textContent.toLowerCase();
                 
                 const status = statusTag ? statusTag.textContent : '';
                 const type = typeTag ? typeTag.textContent : '';
                 
                 const matchesStatus = !statusFilter || status === statusFilter;
                 const matchesType = !typeFilter || type === typeFilter;
                 const matchesSearch = !searchTerm || text.includes(searchTerm);
                 
                 card.style.display = (matchesStatus && matchesType && matchesSearch) ? '' : 'none';
             });
         }
         
         // Add event listeners for filters
         document.getElementById('statusFilter').addEventListener('change', applyFilters);
         document.getElementById('typeFilter').addEventListener('change', applyFilters);
         document.querySelector('.search-input').addEventListener('input', applyFilters);
    </script>
</body>
</html>
