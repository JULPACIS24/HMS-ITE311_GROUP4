<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicationsInventoryModel extends Model
{
    protected $table = 'medications_inventory';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'medication_id', 'medication_name', 'generic_name', 'strength', 'dosage_form',
        'current_stock', 'minimum_stock', 'maximum_stock', 'unit_price', 'category',
        'supplier', 'location', 'storage_conditions', 'requires_prescription', 'status',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function generateMedicationId()
    {
        return 'MED-' . str_pad($this->countAllResults() + 1, 3, '0', STR_PAD_LEFT);
    }

    public function getLowStockMedications()
    {
        return $this->where('current_stock <= minimum_stock')
                   ->where('status', 'Active')
                   ->findAll();
    }

    public function getMedicationsByCategory($category)
    {
        return $this->where('category', $category)
                   ->where('status', 'Active')
                   ->findAll();
    }

    public function searchMedications($searchTerm)
    {
        return $this->like('medication_name', $searchTerm)
                   ->orLike('generic_name', $searchTerm)
                   ->orLike('medication_id', $searchTerm)
                   ->where('status', 'Active')
                   ->findAll();
    }
}
