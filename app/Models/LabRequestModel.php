<?php

namespace App\Models;

use CodeIgniter\Model;

class LabRequestModel extends Model
{
    protected $table = 'lab_requests';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'lab_id',
        'patient_name',
        'patient_id',
        'doctor_name',
        'tests',
        'priority',
        'status',
        'expected_date',
        'clinical_notes'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'patient_name' => 'required|string|max_length[255]',
        'patient_id' => 'required|string|max_length[50]',
        'doctor_name' => 'required|string|max_length[255]',
        'tests' => 'required|string|max_length[255]',
        'priority' => 'required|in_list[Routine,Urgent,STAT]',
        'status' => 'required|in_list[New Request,In Progress,Completed]',
        'expected_date' => 'required|valid_date',
        'clinical_notes' => 'permit_empty|string'
    ];

    protected $validationMessages = [
        'patient_name' => [
            'required' => 'Patient name is required',
            'max_length' => 'Patient name cannot exceed 255 characters'
        ],
        'patient_id' => [
            'required' => 'Patient ID is required',
            'max_length' => 'Patient ID cannot exceed 50 characters'
        ],
        'doctor_name' => [
            'required' => 'Doctor name is required',
            'max_length' => 'Doctor name cannot exceed 255 characters'
        ],
        'tests' => [
            'required' => 'Test type is required',
            'max_length' => 'Test type cannot exceed 255 characters'
        ],
        'priority' => [
            'required' => 'Priority is required',
            'in_list' => 'Priority must be Routine, Urgent, or STAT'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be New Request, In Progress, or Completed'
        ],
        'expected_date' => [
            'required' => 'Expected date is required',
            'valid_date' => 'Expected date must be a valid date'
        ]
    ];

    // Get all lab requests with patient and doctor information
    public function getLabRequestsWithDetails()
    {
        return $this->select('
            lab_requests.*,
            patients.name as patient_name,
            patients.gender as patient_gender,
            users.name as doctor_name
        ')
        ->join('patients', 'patients.id = lab_requests.patient_id')
        ->join('users', 'users.id = lab_requests.doctor_id')
        ->orderBy('lab_requests.created_at', 'DESC')
        ->findAll();
    }

    // Get lab requests by status
    public function getLabRequestsByStatus($status)
    {
        return $this->select('
            lab_requests.*,
            patients.name as patient_name,
            patients.gender as patient_gender,
            users.name as doctor_name
        ')
        ->join('patients', 'patients.id = lab_requests.patient_id')
        ->join('users', 'users.id = lab_requests.doctor_id')
        ->where('lab_requests.status', $status)
        ->orderBy('lab_requests.created_at', 'DESC')
        ->findAll();
    }

    // Get urgent lab requests
    public function getUrgentLabRequests()
    {
        return $this->select('
            lab_requests.*,
            patients.name as patient_name,
            patients.gender as patient_gender,
            users.name as doctor_name
        ')
        ->join('patients', 'patients.id = lab_requests.patient_id')
        ->join('users', 'users.id = lab_requests.doctor_id')
        ->where('lab_requests.priority', 'urgent')
        ->orderBy('lab_requests.created_at', 'ASC')
        ->findAll();
    }

    // Get today's lab requests count
    public function getTodayLabRequestsCount()
    {
        return $this->where('DATE(created_at)', date('Y-m-d'))->countAllResults();
    }

    // Get pending lab requests count
    public function getPendingLabRequestsCount()
    {
        return $this->where('status', 'pending')->countAllResults();
    }

    // Get completed lab requests count
    public function getCompletedLabRequestsCount()
    {
        return $this->where('status', 'completed')->countAllResults();
    }

    // Get urgent lab requests count
    public function getUrgentLabRequestsCount()
    {
        return $this->where('priority', 'urgent')->countAllResults();
    }

    /**
     * Get all lab requests with optional filtering
     */
    public function getAllRequests($status = null, $priority = null)
    {
        $builder = $this->builder();
        
        if ($status) {
            $builder->where('status', $status);
        }
        
        if ($priority) {
            $builder->where('priority', $priority);
        }
        
        return $builder->orderBy('created_at', 'DESC')->get()->getResultArray();
    }

    /**
     * Get request statistics
     */
    public function getRequestStats()
    {
        $total = $this->countAllResults();
        $new = $this->where('status', 'New Request')->countAllResults();
        $inProgress = $this->where('status', 'In Progress')->countAllResults();
        $urgent = $this->whereIn('priority', ['Urgent', 'STAT'])->countAllResults();
        
        return [
            'total' => $total,
            'new' => $new,
            'in_progress' => $inProgress,
            'urgent' => $urgent
        ];
    }

    /**
     * Delete lab request by ID
     */
    public function deleteRequest($id)
    {
        return $this->delete($id);
    }

    /**
     * Delete lab request by patient name
     */
    public function deleteByPatientName($patientName)
    {
        return $this->where('patient_name', $patientName)->delete();
    }
}
