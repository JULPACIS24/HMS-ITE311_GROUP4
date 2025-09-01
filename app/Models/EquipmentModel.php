<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipmentModel extends Model
{
    protected $table = 'equipment';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = [
        'name',
        'type',
        'status',
        'utilization',
        'last_maintenance',
        'next_maintenance',
        'location',
        'notes',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|string|max_length[255]',
        'type' => 'required|string|max_length[100]',
        'status' => 'required|in_list[operational,maintenance,out_of_order]',
        'utilization' => 'required|integer|greater_than_equal_to[0]|less_than_equal_to[100]',
        'last_maintenance' => 'required|valid_date',
        'next_maintenance' => 'required|valid_date'
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Equipment name is required',
            'max_length' => 'Equipment name cannot exceed 255 characters'
        ],
        'type' => [
            'required' => 'Equipment type is required',
            'max_length' => 'Equipment type cannot exceed 100 characters'
        ],
        'status' => [
            'required' => 'Equipment status is required',
            'in_list' => 'Status must be operational, maintenance, or out_of_order'
        ],
        'utilization' => [
            'required' => 'Utilization percentage is required',
            'integer' => 'Utilization must be a number',
            'greater_than_equal_to' => 'Utilization must be 0 or greater',
            'less_than_equal_to' => 'Utilization cannot exceed 100%'
        ],
        'last_maintenance' => [
            'required' => 'Last maintenance date is required',
            'valid_date' => 'Last maintenance date must be a valid date'
        ],
        'next_maintenance' => [
            'required' => 'Next maintenance date is required',
            'valid_date' => 'Next maintenance date must be a valid date'
        ]
    ];

    // Get all equipment
    public function getAllEquipment()
    {
        return $this->orderBy('name', 'ASC')->findAll();
    }

    // Get equipment by status
    public function getEquipmentByStatus($status)
    {
        return $this->where('status', $status)->orderBy('name', 'ASC')->findAll();
    }

    // Get operational equipment
    public function getOperationalEquipment()
    {
        return $this->where('status', 'operational')->orderBy('name', 'ASC')->findAll();
    }

    // Get equipment needing maintenance
    public function getEquipmentNeedingMaintenance()
    {
        return $this->where('next_maintenance <=', date('Y-m-d'))
                   ->orderBy('next_maintenance', 'ASC')
                   ->findAll();
    }

    // Get equipment count by status
    public function getEquipmentCountByStatus($status)
    {
        return $this->where('status', $status)->countAllResults();
    }

    // Get total equipment count
    public function getTotalEquipmentCount()
    {
        return $this->countAllResults();
    }

    // Get average utilization
    public function getAverageUtilization()
    {
        $result = $this->selectAvg('utilization')->first();
        return $result ? round($result['utilization'], 1) : 0;
    }
}
