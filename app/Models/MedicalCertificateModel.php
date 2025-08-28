<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicalCertificateModel extends Model
{
    protected $table = 'medical_certificates';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'certificate_id', 'patient_id', 'patient_name', 'patient_age', 'patient_gender', 'patient_address',
        'doctor_id', 'doctor_name', 'doctor_license', 'issue_date', 'diagnosis', 'medications',
        'pregnancy_details', 'lmp', 'edd', 'notes', 'status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;

    public function generateCertificateId()
    {
        return 'MC-' . date('Y') . '-' . str_pad($this->countAll() + 1, 4, '0', STR_PAD_LEFT);
    }

    public function getByDoctor($doctorName)
    {
        return $this->where('doctor_name', $doctorName)->orderBy('created_at', 'DESC')->findAll();
    }

    public function getDoctorCertificateStats($doctorName)
    {
        $total = $this->where('doctor_name', $doctorName)->countAllResults();
        $active = $this->where('doctor_name', $doctorName)->where('status', 'Active')->countAllResults();
        $thisMonth = $this->where('doctor_name', $doctorName)
                          ->where('MONTH(created_at)', date('m'))
                          ->where('YEAR(created_at)', date('Y'))
                          ->countAllResults();

        return [
            'total_certificates' => $total,
            'active_certificates' => $active,
            'this_month' => $thisMonth
        ];
    }
}
