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
        'patient_id',
        'doctor_id',
        'test_type',
        'priority',
        'status',
        'request_date',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'patient_id' => 'required|integer',
        'doctor_id' => 'required|integer',
        'test_type' => 'required|string|max_length[255]',
        'priority' => 'required|in_list[normal,high,urgent]',
        'status' => 'required|in_list[pending,in_progress,completed,ready]'
    ];

    protected $validationMessages = [
        'patient_id' => [
            'required' => 'Patient ID is required',
            'integer' => 'Patient ID must be a number'
        ],
        'doctor_id' => [
            'required' => 'Doctor ID is required',
            'integer' => 'Doctor ID must be a number'
        ],
        'test_type' => [
            'required' => 'Test type is required',
            'max_length' => 'Test type cannot exceed 255 characters'
        ],
        'priority' => [
            'required' => 'Priority is required',
            'in_list' => 'Priority must be normal, high, or urgent'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be pending, in_progress, completed, or ready'
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
}
