<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prescription Orders - San Miguel HMS</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/auth.css') ?>">
    <style>
        .prescription-orders {
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
        
        .card-number.orange { color: #ea580c; }
        .card-number.green { color: #16a34a; }
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
        
        .card-subtitle.green { color: #059669; }
        
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
        
        .process-orders-btn {
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
        
        .process-orders-btn:hover {
            background: #1d4ed8;
        }
        
        .prescription-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .prescription-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            border: 1px solid #e2e8f0;
        }
        
        .prescription-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        
        .prescription-info h3 {
            color: #1e293b;
            margin: 0 0 8px 0;
            font-size: 18px;
            font-weight: 600;
        }
        
        .prescription-info p {
            color: #64748b;
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        
        .prescription-status {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 8px;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
        }
        
        .status-pending { background: #fef3c7; color: #d97706; }
        .status-ready { background: #dbeafe; color: #1e40af; }
        
        .total-amount {
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        
        .insurance-info {
            font-size: 12px;
            color: #059669;
            margin: 0;
        }
        
        .prescribed-medicines {
            margin-bottom: 20px;
        }
        
        .medicines-title {
            color: #374151;
            margin: 0 0 12px 0;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .medicine-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        
        .medicine-item:last-child {
            border-bottom: none;
        }
        
        .medicine-details {
            flex: 1;
        }
        
        .medicine-name {
            font-weight: 600;
            color: #1e293b;
            margin: 0 0 4px 0;
            font-size: 14px;
        }
        
        .medicine-dosage {
            color: #6b7280;
            margin: 0;
            font-size: 12px;
        }
        
        .medicine-quantity {
            font-weight: 600;
            color: #1e293b;
            font-size: 14px;
        }
        
        .action-buttons {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }
        
        .action-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-fulfill { background: #10b981; color: white; }
        .btn-fulfill:hover { background: #059669; }
        
        .btn-view { background: #3b82f6; color: white; }
        .btn-view:hover { background: #2563eb; }
        
        .btn-print { background: #8b5cf6; color: white; }
        .btn-print:hover { background: #7c3aed; }
        
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
            
            .prescription-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            
            .prescription-status {
                align-items: flex-start;
            }
            
            .action-buttons {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <?= $this->include('auth/partials/sidebar') ?>
    
    <div class="main-content">
        <?= $this->include('auth/partials/header') ?>
        
        <div class="prescription-orders">
            <div class="page-header">
                <h1 class="page-title">Prescription Orders</h1>
                <p class="page-subtitle">Manage and fulfill prescription orders</p>
            </div>
            
            <div class="summary-cards">
                <div class="summary-card">
                    <h2 class="card-number orange"><?= $stats['pending_orders'] ?? 0 ?></h2>
                    <p class="card-label">Pending Orders</p>
                    <p class="card-subtitle">Awaiting fulfillment</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number green"><?= $stats['ready_pickup'] ?? 0 ?></h2>
                    <p class="card-label">Ready for Pickup</p>
                    <p class="card-subtitle">Fulfilled orders</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number blue"><?= $stats['dispensed_today'] ?? 0 ?></h2>
                    <p class="card-label">Dispensed Today</p>
                    <p class="card-subtitle green">+12 from yesterday</p>
                </div>
                
                <div class="summary-card">
                    <h2 class="card-number orange"><?= $stats['partial_orders'] ?? 0 ?></h2>
                    <p class="card-label">Partial Orders</p>
                    <p class="card-subtitle">Stock issues</p>
                </div>
            </div>
            
            <div class="action-bar">
                <div class="search-section">
                    <input type="text" class="search-input" placeholder="Search prescriptions...">
                    <select class="filter-dropdown">
                        <option>All Orders</option>
                        <option>Pending</option>
                        <option>Ready for Pickup</option>
                        <option>Dispensed</option>
                        <option>Partial</option>
                    </select>
                </div>
                                 <button class="process-orders-btn" onclick="openProcessModal()">
                     Process Orders
                 </button>
            </div>
            
            <div class="prescription-list">
                <?php if (!empty($prescriptions)): ?>
                    <?php foreach ($prescriptions as $prescription): ?>
                        <?php 
                        $medications = json_decode($prescription['medications'], true) ?? [];
                        $statusClass = $prescription['status'] === 'Pending' ? 'status-pending' : 'status-ready';
                        ?>
                        <div class="prescription-card">
                            <div class="prescription-header">
                                <div class="prescription-info">
                                    <h3><?= esc($prescription['prescription_id']) ?></h3>
                                    <p>Patient: <?= esc($prescription['patient_name']) ?></p>
                                    <p>Prescribed by: <?= esc($prescription['doctor_name']) ?> | Order Date: <?= date('Y-m-d', strtotime($prescription['created_date'])) ?></p>
                                </div>
                                <div class="prescription-status">
                                    <span class="status-badge <?= $statusClass ?>"><?= esc($prescription['status']) ?></span>
                                    <div class="total-amount">₱<?= number_format($prescription['total_amount'], 2) ?></div>
                                    <p class="insurance-info"><?= esc($prescription['insurance_covered']) ?></p>
                                </div>
                            </div>
                            
                            <div class="prescribed-medicines">
                                <h4 class="medicines-title">Prescribed Medicines</h4>
                                
                                <?php if (!empty($medications)): ?>
                                    <?php foreach ($medications as $medication): ?>
                                        <div class="medicine-item">
                                            <div class="medicine-details">
                                                <div class="medicine-name"><?= esc($medication['name']) ?></div>
                                                <div class="medicine-dosage">Take <?= esc($medication['dosage']) ?> <?= esc($medication['frequency']) ?> for <?= esc($medication['duration']) ?></div>
                                            </div>
                                            <div class="medicine-quantity">Qty: 30</div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="medicine-item">
                                        <div class="medicine-details">
                                            <div class="medicine-name">No medications specified</div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="action-buttons">
                                <?php if ($prescription['status'] === 'Pending'): ?>
                                    <button class="action-btn btn-fulfill" onclick="fulfillOrder('<?= $prescription['prescription_id'] ?>')">Fulfill Order</button>
                                <?php endif; ?>
                                <button class="action-btn btn-view" onclick="viewOrderDetails('<?= $prescription['prescription_id'] ?>')">View Details</button>
                                <button class="action-btn btn-print" onclick="printLabel('<?= $prescription['prescription_id'] ?>')">Print Label</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="prescription-card">
                        <div style="text-align: center; padding: 40px;">
                            <h3 style="color: #64748b; margin-bottom: 10px;">No Prescriptions Found</h3>
                            <p style="color: #94a3b8;">No prescription orders have been created yet.</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
                 </div>
     </div>
     
     <!-- Process Prescription Order Modal -->
     <div id="processModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000;">
         <div style="background:#fff; border-radius:16px; width:90%; max-width:800px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
             <div style="padding:24px 32px; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
                 <h2 style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">Process Prescription Order</h2>
                 <button id="closeProcessModal" style="background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">×</button>
             </div>
             
             <form id="processForm" style="padding:32px;">
                 <!-- Select Prescription -->
                 <div style="margin-bottom:24px;">
                     <label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Select Prescription</label>
                     <select id="selectedPrescription" name="prescription_id" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
                         <option value="">Select a prescription to process...</option>
                         <?php if (!empty($prescriptions)): ?>
                             <?php foreach ($prescriptions as $prescription): ?>
                                 <?php if ($prescription['status'] === 'Pending'): ?>
                                     <option value="<?= esc($prescription['prescription_id']) ?>">
                                         <?= esc($prescription['prescription_id']) ?> - <?= esc($prescription['patient_name']) ?>
                                     </option>
                                 <?php endif; ?>
                             <?php endforeach; ?>
                         <?php endif; ?>
                     </select>
                 </div>
                 
                 <!-- Medicine Availability Check -->
                 <div style="margin-bottom:24px;">
                     <h3 style="font-size:16px; font-weight:600; color:#374151; margin-bottom:16px;">Medicine Availability Check</h3>
                     <div id="medicineAvailability">
                         <div style="padding:16px; background:#f8fafc; border-radius:8px; text-align:center; color:#64748b;">
                             Select a prescription to check medicine availability
                         </div>
                     </div>
                 </div>
                 
                 <!-- Processing Notes -->
                 <div style="margin-bottom:24px;">
                     <label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Processing Notes</label>
                     <textarea id="processingNotes" name="notes" rows="3" style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px; resize:vertical;" placeholder="Any special notes or substitutions..."></textarea>
                 </div>
                 
                 <!-- Status Update -->
                 <div style="margin-bottom:24px;">
                     <label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Status Update</label>
                     <select id="statusUpdate" name="status" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
                         <option value="">Select status...</option>
                         <option value="Ready for Pickup">Ready for Pickup</option>
                         <option value="Partial">Partially Available</option>
                         <option value="Need to Order">Need to Order</option>
                     </select>
                 </div>
                 
                 <!-- Processed By -->
                 <div style="margin-bottom:24px;">
                     <label style="display:block; font-weight:600; color:#374151; margin-bottom:8px;">Processed By</label>
                                           <select id="processedBy" name="processed_by" required style="width:100%; padding:12px; border:1px solid #d1d5db; border-radius:8px; font-size:14px;">
                          <option value="">Select pharmacist...</option>
                          <?php if (!empty($pharmacists)): ?>
                              <?php foreach ($pharmacists as $pharmacist): ?>
                                  <?php if ($pharmacist['name'] !== 'No Pharmacists Available'): ?>
                                      <option value="<?= esc($pharmacist['name']) ?>"><?= esc($pharmacist['name']) ?></option>
                                  <?php endif; ?>
                              <?php endforeach; ?>
                          <?php endif; ?>
                          <?php if (empty($pharmacists) || (count($pharmacists) === 1 && $pharmacists[0]['name'] === 'No Pharmacists Available')): ?>
                              <option value="Current User">Current User</option>
                          <?php endif; ?>
                      </select>
                 </div>
                 
                 <div style="display:flex; gap:12px; justify-content:flex-end; margin-top:32px; padding-top:24px; border-top:1px solid #e5e7eb;">
                     <button type="button" id="cancelProcessBtn" style="padding:12px 24px; background:#f3f4f6; color:#374151; border:1px solid #d1d5db; border-radius:8px; font-weight:600; cursor:pointer;">Cancel</button>
                     <button type="submit" style="padding:12px 24px; background:#2563eb; color:#fff; border:none; border-radius:8px; font-weight:600; cursor:pointer;">Process Order</button>
                 </div>
             </form>
         </div>
     </div>
     
          <script>
         // Process Modal Elements
         const processModal = document.getElementById('processModal');
         const closeProcessModal = document.getElementById('closeProcessModal');
         const cancelProcessBtn = document.getElementById('cancelProcessBtn');
         const processForm = document.getElementById('processForm');
         const selectedPrescription = document.getElementById('selectedPrescription');
         const medicineAvailability = document.getElementById('medicineAvailability');
         
         // Open Process Modal
         function openProcessModal() {
             processModal.style.display = 'flex';
             processModal.style.alignItems = 'center';
             processModal.style.justifyContent = 'center';
         }
         
         // Close Process Modal
         function closeProcessModalFunc() {
             processModal.style.display = 'none';
             processForm.reset();
             medicineAvailability.innerHTML = `
                 <div style="padding:16px; background:#f8fafc; border-radius:8px; text-align:center; color:#64748b;">
                     Select a prescription to check medicine availability
                 </div>
             `;
         }
         
         // Close modal event listeners
         closeProcessModal.addEventListener('click', closeProcessModalFunc);
         cancelProcessBtn.addEventListener('click', closeProcessModalFunc);
         
         // Close modal when clicking outside
         processModal.addEventListener('click', (e) => {
             if (e.target === processModal) {
                 closeProcessModalFunc();
             }
         });
         
         // Handle prescription selection for medicine availability
         selectedPrescription.addEventListener('change', function() {
             const prescriptionId = this.value;
             if (prescriptionId) {
                 // Get prescription details and show medicine availability
                 fetch(`<?= site_url('pharmacy/prescription-details') ?>/${prescriptionId}`)
                     .then(response => response.json())
                     .then(data => {
                         if (data.success) {
                             const prescription = data.data;
                             const medications = JSON.parse(prescription.medications || '[]');
                             
                             let availabilityHTML = '';
                             medications.forEach((med, index) => {
                                 // Mock availability check - in real system, this would check inventory
                                 const isAvailable = Math.random() > 0.3; // 70% chance of being available
                                 const quantity = isAvailable ? Math.floor(Math.random() * 50) + 10 : 0;
                                 
                                 availabilityHTML += `
                                     <div style="display:flex; justify-content:space-between; align-items:center; padding:12px; border-bottom:1px solid #f1f5f9; ${index === medications.length - 1 ? 'border-bottom:none;' : ''}">
                                         <div style="display:flex; align-items:center; gap:12px;">
                                             <input type="checkbox" ${isAvailable ? 'checked' : ''} style="width:16px; height:16px;">
                                             <div>
                                                 <div style="font-weight:600; color:#1e293b;">${med.name} (Qty: ${quantity})</div>
                                                 <div style="font-size:12px; color:#6b7280;">${med.dosage} ${med.frequency}</div>
                                             </div>
                                         </div>
                                         <div style="display:flex; align-items:center; gap:8px;">
                                             <span style="color:${isAvailable ? '#16a34a' : '#ef4444'}; font-size:20px;">${isAvailable ? '✓' : '✗'}</span>
                                             <span style="font-size:12px; color:${isAvailable ? '#16a34a' : '#ef4444'}; font-weight:600;">${isAvailable ? 'Available' : 'Out of Stock'}</span>
                                         </div>
                                     </div>
                                 `;
                             });
                             
                             medicineAvailability.innerHTML = availabilityHTML;
                         }
                     })
                     .catch(error => {
                         console.error('Error:', error);
                         medicineAvailability.innerHTML = `
                             <div style="padding:16px; background:#fef2f2; border-radius:8px; text-align:center; color:#ef4444;">
                                 Error loading prescription details
                             </div>
                         `;
                     });
             } else {
                 medicineAvailability.innerHTML = `
                     <div style="padding:16px; background:#f8fafc; border-radius:8px; text-align:center; color:#64748b;">
                         Select a prescription to check medicine availability
                     </div>
                 `;
             }
         });
         
         // Handle process form submission
         processForm.addEventListener('submit', (e) => {
             e.preventDefault();
             
             const formData = new FormData(processForm);
             
             fetch('<?= site_url('pharmacy/process-order') ?>', {
                 method: 'POST',
                 body: formData
             })
             .then(response => response.json())
             .then(data => {
                 if (data.success) {
                     alert('Order processed successfully!');
                     closeProcessModalFunc();
                     location.reload(); // Refresh to show updated status
                 } else {
                     alert('Error: ' + (data.message || 'Failed to process order'));
                 }
             })
             .catch(error => {
                 console.error('Error:', error);
                 alert('Error processing order. Please try again.');
             });
         });
         
         // Fulfill Order Function
         function fulfillOrder(orderId) {
             if (confirm(`Are you sure you want to fulfill order ${orderId}?`)) {
                 const formData = new FormData();
                 formData.append('prescription_id', orderId);
                 formData.append('status', 'Ready for Pickup');
                 formData.append('processed_by', '<?= session('user_name') ?? 'Pharmacist' ?>');
                 
                 fetch('<?= site_url('pharmacy/process-order') ?>', {
                     method: 'POST',
                     body: formData
                 })
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         alert('Order fulfilled successfully!');
                         location.reload();
                     } else {
                         alert('Error: ' + (data.message || 'Failed to fulfill order'));
                     }
                 })
                 .catch(error => {
                     console.error('Error:', error);
                     alert('Error fulfilling order. Please try again.');
                 });
             }
         }
         
         // View Order Details Function
         function viewOrderDetails(orderId) {
             fetch(`<?= site_url('pharmacy/prescription-details') ?>/${orderId}`)
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         const prescription = data.data;
                         const medications = JSON.parse(prescription.medications || '[]');
                         
                         let detailsHTML = `
                             <div style="padding:20px; background:#fff; border-radius:12px; max-width:600px; margin:20px auto;">
                                 <h3 style="margin:0 0 16px 0; color:#1e293b;">${prescription.prescription_id}</h3>
                                 <div style="margin-bottom:16px;">
                                     <p><strong>Patient:</strong> ${prescription.patient_name}</p>
                                     <p><strong>Doctor:</strong> ${prescription.doctor_name}</p>
                                     <p><strong>Diagnosis:</strong> ${prescription.diagnosis}</p>
                                     <p><strong>Status:</strong> <span style="color:${prescription.status === 'Pending' ? '#f59e0b' : '#16a34a'}">${prescription.status}</span></p>
                                     <p><strong>Created:</strong> ${new Date(prescription.created_date).toLocaleDateString()}</p>
                                     <p><strong>Total Amount:</strong> ₱${parseFloat(prescription.total_amount).toFixed(2)}</p>
                                 </div>
                                 <div style="margin-bottom:16px;">
                                     <h4 style="margin:0 0 8px 0;">Medications:</h4>
                                     <ul style="margin:0; padding-left:20px;">
                         `;
                         
                         medications.forEach(med => {
                             detailsHTML += `<li>${med.name} - ${med.dosage} ${med.frequency} for ${med.duration}</li>`;
                         });
                         
                         detailsHTML += `
                                     </ul>
                                 </div>
                                 ${prescription.notes ? `<div><h4 style="margin:0 0 8px 0;">Notes:</h4><p style="margin:0;">${prescription.notes}</p></div>` : ''}
                             </div>
                         `;
                         
                         // Create modal for details
                         const detailsModal = document.createElement('div');
                         detailsModal.style.cssText = 'position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:1000; display:flex; align-items:center; justify-content:center;';
                         detailsModal.innerHTML = `
                             <div style="background:#fff; border-radius:16px; width:90%; max-width:700px; max-height:90vh; overflow-y:auto; box-shadow:0 20px 60px rgba(0,0,0,0.3);">
                                 <div style="padding:24px 32px; border-bottom:1px solid #e5e7eb; display:flex; justify-content:space-between; align-items:center;">
                                     <h2 style="font-size:24px; font-weight:700; color:#0f172a; margin:0;">Prescription Details</h2>
                                     <button onclick="this.closest('.details-modal').remove()" style="background:none; border:none; font-size:24px; cursor:pointer; color:#64748b;">×</button>
                                 </div>
                                 <div style="padding:32px;">
                                     ${detailsHTML}
                                 </div>
                             </div>
                         `;
                         detailsModal.className = 'details-modal';
                         document.body.appendChild(detailsModal);
                         
                         // Close modal when clicking outside
                         detailsModal.addEventListener('click', (e) => {
                             if (e.target === detailsModal) {
                                 detailsModal.remove();
                             }
                         });
                     } else {
                         alert('Error: ' + (data.message || 'Failed to load prescription details'));
                     }
                 })
                 .catch(error => {
                     console.error('Error:', error);
                     alert('Error loading prescription details. Please try again.');
                 });
         }
         
         // Print Label Function
         function printLabel(orderId) {
             fetch(`<?= site_url('pharmacy/prescription-details') ?>/${orderId}`)
                 .then(response => response.json())
                 .then(data => {
                     if (data.success) {
                         const prescription = data.data;
                         const medications = JSON.parse(prescription.medications || '[]');
                         
                         // Create print window
                         const printWindow = window.open('', '_blank');
                         printWindow.document.write(`
                             <!DOCTYPE html>
                             <html>
                             <head>
                                 <title>Prescription Label - ${prescription.prescription_id}</title>
                                 <style>
                                     body { font-family: Arial, sans-serif; margin: 0; padding: 20px; }
                                     .label { border: 2px solid #000; padding: 20px; max-width: 400px; margin: 0 auto; }
                                     .header { text-align: center; border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 15px; }
                                     .patient-info { margin-bottom: 15px; }
                                     .medications { margin-bottom: 15px; }
                                     .footer { border-top: 1px solid #000; padding-top: 10px; text-align: center; font-size: 12px; }
                                     .med-item { margin-bottom: 8px; }
                                     @media print { body { margin: 0; } }
                                 </style>
                             </head>
                             <body>
                                 <div class="label">
                                     <div class="header">
                                         <h2>San Miguel HMS</h2>
                                         <h3>Prescription Label</h3>
                                         <p><strong>${prescription.prescription_id}</strong></p>
                                     </div>
                                     
                                     <div class="patient-info">
                                         <p><strong>Patient:</strong> ${prescription.patient_name}</p>
                                         <p><strong>Patient ID:</strong> ${prescription.patient_id}</p>
                                         <p><strong>Prescribed by:</strong> ${prescription.doctor_name}</p>
                                         <p><strong>Date:</strong> ${new Date(prescription.created_date).toLocaleDateString()}</p>
                                     </div>
                                     
                                     <div class="medications">
                                         <h4>Medications:</h4>
                                         ${medications.map(med => `
                                             <div class="med-item">
                                                 <strong>${med.name}</strong><br>
                                                 ${med.dosage} ${med.frequency}<br>
                                                 Duration: ${med.duration}
                                             </div>
                                         `).join('')}
                                     </div>
                                     
                                     ${prescription.notes ? `
                                         <div style="margin-bottom: 15px;">
                                             <h4>Notes:</h4>
                                             <p>${prescription.notes}</p>
                                         </div>
                                     ` : ''}
                                     
                                     <div class="footer">
                                         <p>Total Amount: ₱${parseFloat(prescription.total_amount).toFixed(2)}</p>
                                         <p>Insurance: ${prescription.insurance_covered}</p>
                                         <p>Printed on: ${new Date().toLocaleString()}</p>
                                     </div>
                                 </div>
                             </body>
                             </html>
                         `);
                         printWindow.document.close();
                         printWindow.print();
                     } else {
                         alert('Error: ' + (data.message || 'Failed to load prescription details'));
                     }
                 })
                 .catch(error => {
                     console.error('Error:', error);
                     alert('Error printing label. Please try again.');
                 });
         }
        
        // Search functionality
        document.querySelector('.search-input').addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const cards = document.querySelectorAll('.prescription-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
        
        // Filter functionality
        document.querySelector('.filter-dropdown').addEventListener('change', function(e) {
            const filterValue = e.target.value;
            const cards = document.querySelectorAll('.prescription-card');
            
            cards.forEach(card => {
                if (filterValue === 'All Orders') {
                    card.style.display = '';
                } else {
                    const statusBadge = card.querySelector('.status-badge');
                    const status = statusBadge.textContent.toLowerCase();
                    const shouldShow = status.includes(filterValue.toLowerCase()) || 
                                    (filterValue === 'Dispensed' && status === 'ready for pickup') ||
                                    (filterValue === 'Partial' && status === 'pending');
                    card.style.display = shouldShow ? '' : 'none';
                }
            });
        });
    </script>
</body>
</html>
