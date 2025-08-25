<?php

namespace App\Models;

use CodeIgniter\Model;

class PrescriptionModel extends Model
{
    protected $table = 'prescriptions';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'prescription_id',
        'patient_name',
        'patient_id',
        'doctor_name',
        'doctor_id',
        'diagnosis',
        'medications',
        'notes',
        'status',
        'total_amount',
        'insurance_covered',
        'created_date',
        'updated_at'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_date';
    protected $updatedField = 'updated_at';

    // Generate prescription ID
    public function generatePrescriptionId()
    {
        return 'RX-' . date('Y') . '-' . str_pad($this->countAll() + 1, 3, '0', STR_PAD_LEFT);
    }

    // Get prescriptions by doctor
    public function getByDoctor($doctorName)
    {
        return $this->where('doctor_name', $doctorName)
                    ->orderBy('created_date', 'DESC')
                    ->findAll();
    }

    // Get prescriptions by status
    public function getByStatus($status)
    {
        return $this->where('status', $status)
                    ->orderBy('created_date', 'DESC')
                    ->findAll();
    }

    // Get pending prescriptions for pharmacy
    public function getPendingPrescriptions()
    {
        return $this->where('status', 'Pending')
                    ->orderBy('created_date', 'ASC')
                    ->findAll();
    }

    // Update prescription status
    public function updateStatus($id, $status)
    {
        return $this->update($id, ['status' => $status]);
    }
}
