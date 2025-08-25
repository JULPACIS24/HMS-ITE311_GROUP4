<?php

namespace App\Models;

use CodeIgniter\Model;

class StockAlertsModel extends Model
{
    protected $table = 'stock_alerts';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'alert_id', 'medication_name', 'alert_type', 'priority', 'status',
        'current_stock', 'minimum_required', 'expiry_date', 'days_remaining',
        'batch_number', 'location', 'supplier', 'description', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateAlertId()
    {
        return 'ALT-' . date('Y') . '-' . str_pad($this->countAllResults() + 1, 3, '0', STR_PAD_LEFT);
    }
}
