<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill - <?= $bill['bill_id'] ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #fff;
        }

        .bill-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 40px;
            border: 2px solid #333;
        }

        .bill-header {
            text-align: center;
            border-bottom: 3px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .hospital-name {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .bill-title {
            font-size: 20px;
            margin-bottom: 5px;
        }

        .bill-id {
            font-size: 18px;
            font-weight: bold;
        }

        .bill-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .info-section h3 {
            font-size: 16px;
            border-bottom: 1px solid #333;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .info-item {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }

        .services-section {
            margin-bottom: 30px;
        }

        .services-section h3 {
            font-size: 16px;
            border-bottom: 1px solid #333;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .services-content {
            background: #f9f9f9;
            padding: 20px;
            border-left: 4px solid #333;
        }

        .bill-summary {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #333;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 18px;
            border-top: 2px solid #333;
            padding-top: 15px;
            margin-top: 10px;
        }

        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border: 1px solid #333;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }

        @media print {
            body { margin: 0; }
            .bill-container { border: none; margin: 0; }
        }
    </style>
</head>
<body>
    <div class="bill-container">
        <div class="bill-header">
            <div class="hospital-name">San Miguel Hospital</div>
            <div class="bill-title">Medical Bill</div>
            <div class="bill-id"><?= esc($bill['bill_id']) ?></div>
        </div>

        <div class="bill-info">
            <div class="info-section">
                <h3>Patient Information</h3>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span><?= esc($bill['patient_name'] ?: ($bill['first_name'] . ' ' . $bill['last_name'])) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span><?= esc($bill['phone'] ?? 'N/A') ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span><?= esc($bill['email'] ?? 'N/A') ?></span>
                </div>
                <?php if (!empty($bill['address'])): ?>
                <div class="info-item">
                    <span class="info-label">Address:</span>
                    <span><?= esc($bill['address']) ?></span>
                </div>
                <?php endif; ?>
            </div>

            <div class="info-section">
                <h3>Bill Information</h3>
                <div class="info-item">
                    <span class="info-label">Bill Date:</span>
                    <span><?= date('F j, Y', strtotime($bill['bill_date'])) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Due Date:</span>
                    <span><?= date('F j, Y', strtotime($bill['due_date'])) ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="status-badge"><?= esc($bill['status']) ?></span>
                </div>
                <?php if (!empty($bill['payment_method'])): ?>
                <div class="info-item">
                    <span class="info-label">Payment:</span>
                    <span><?= esc($bill['payment_method']) ?></span>
                </div>
                <?php endif; ?>
                <?php if (!empty($bill['insurance_provider'])): ?>
                <div class="info-item">
                    <span class="info-label">Insurance:</span>
                    <span><?= esc($bill['insurance_provider']) ?></span>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="services-section">
            <h3>Services Provided</h3>
            <div class="services-content">
                <p><?= esc($bill['services'] ?: 'Medical Services') ?></p>
            </div>
        </div>

        <div class="bill-summary">
            <h3>Bill Summary</h3>
            <div class="summary-row">
                <span>Subtotal:</span>
                <span>₱<?= number_format($bill['subtotal'], 2) ?></span>
            </div>
            <div class="summary-row">
                <span>Tax:</span>
                <span>₱<?= number_format($bill['tax'], 2) ?></span>
            </div>
            <?php if ($bill['discount'] > 0): ?>
            <div class="summary-row">
                <span>Discount:</span>
                <span>-₱<?= number_format($bill['discount'], 2) ?></span>
            </div>
            <?php endif; ?>
            <div class="summary-row">
                <span>Total Amount:</span>
                <span>₱<?= number_format($bill['total_amount'], 2) ?></span>
            </div>
        </div>

        <?php if (!empty($bill['notes'])): ?>
        <div class="services-section">
            <h3>Notes</h3>
            <div class="services-content">
                <p><?= esc($bill['notes']) ?></p>
            </div>
        </div>
        <?php endif; ?>

        <div class="footer">
            <p>Thank you for choosing San Miguel Hospital</p>
            <p>For inquiries, please contact us at (123) 456-7890</p>
            <p>Generated on: <?= date('F j, Y \a\t g:i A') ?></p>
        </div>
    </div>

    <script>
        // Auto-print when page loads
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
