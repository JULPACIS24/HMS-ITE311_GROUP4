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
    protected $protectFields = true;
    protected $allowedFields = [
        'lab_id',
        'patient_name',
        'patient_id',
        'doctor_name',
        'tests',
        'priority',
        'status',
        'expected_date',
        'clinical_notes',
        'created_at',
        'updated_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'lab_id' => 'required|max_length[50]',
        'patient_name' => 'required|max_length[255]',
        'patient_id' => 'required|max_length[50]',
        'doctor_name' => 'required|max_length[255]',
        'tests' => 'required',
        'priority' => 'required|in_list[Routine,Urgent,STAT]',
        'status' => 'required|in_list[Pending,In Progress,Completed,Cancelled]',
        'expected_date' => 'required|valid_date',
        'clinical_notes' => 'permit_empty|max_length[1000]'
    ];

    protected $validationMessages = [
        'lab_id' => [
            'required' => 'Lab ID is required.',
            'max_length' => 'Lab ID cannot exceed 50 characters.'
        ],
        'patient_name' => [
            'required' => 'Patient name is required.',
            'max_length' => 'Patient name cannot exceed 255 characters.'
        ],
        'patient_id' => [
            'required' => 'Patient ID is required.',
            'max_length' => 'Patient ID cannot exceed 50 characters.'
        ],
        'doctor_name' => [
            'required' => 'Doctor name is required.',
            'max_length' => 'Doctor name cannot exceed 255 characters.'
        ],
        'tests' => [
            'required' => 'At least one test must be selected.'
        ],
        'priority' => [
            'required' => 'Priority is required.',
            'in_list' => 'Priority must be Routine, Urgent, or STAT.'
        ],
        'status' => [
            'required' => 'Status is required.',
            'in_list' => 'Status must be Pending, In Progress, Completed, or Cancelled.'
        ],
        'expected_date' => [
            'required' => 'Expected date is required.',
            'valid_date' => 'Expected date must be a valid date.'
        ],
        'clinical_notes' => [
            'max_length' => 'Clinical notes cannot exceed 1000 characters.'
        ]
    ];

    protected $skipValidation = true; // Temporarily disable validation for testing
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];
}
