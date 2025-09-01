<?php

namespace App\Models;

use CodeIgniter\Model;

class LabResultModel extends Model
{
    protected $table = 'lab_results';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'lab_request_id',
        'patient_id',
        'doctor_id',
        'test_type',
        'result_data',
        'result_date',
        'status',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'lab_request_id' => 'required|integer',
        'patient_id' => 'required|integer',
        'doctor_id' => 'required|integer',
        'test_type' => 'required|string|max_length[255]',
        'result_data' => 'required',
        'status' => 'required|in_list[pending,ready,completed]'
    ];

    protected $validationMessages = [
        'lab_request_id' => [
            'required' => 'Lab request ID is required',
            'integer' => 'Lab request ID must be a number'
        ],
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
        'result_data' => [
            'required' => 'Result data is required'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be pending, ready, or completed'
        ]
    ];

    // Get all lab results with patient and doctor information
    public function getLabResultsWithDetails()
    {
        return $this->select('
            lab_results.*,
            patients.name as patient_name,
            patients.gender as patient_gender,
            users.name as doctor_name
        ')
        ->join('patients', 'patients.id = lab_results.patient_id')
        ->join('users', 'users.id = lab_results.doctor_id')
        ->orderBy('lab_results.created_at', 'DESC')
        ->findAll();
    }

    // Get lab results by status
    public function getLabResultsByStatus($status)
    {
        return $this->select('
            lab_results.*,
            patients.name as patient_name,
            patients.gender as patient_gender,
            users.name as doctor_name
        ')
        ->join('patients', 'patients.id = lab_results.patient_id')
        ->join('users', 'users.id = lab_results.doctor_id')
        ->where('lab_results.status', $status)
        ->orderBy('lab_results.created_at', 'DESC')
        ->findAll();
    }

    // Get ready lab results count
    public function getReadyLabResultsCount()
    {
        return $this->where('status', 'ready')->countAllResults();
    }

    // Get completed lab results count
    public function getCompletedLabResultsCount()
    {
        return $this->where('status', 'completed')->countAllResults();
    }

    // Get today's lab results count
    public function getTodayLabResultsCount()
    {
        return $this->where('DATE(created_at)', date('Y-m-d'))->countAllResults();
    }
}
