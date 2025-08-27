<?php

namespace App\Models;

use CodeIgniter\Model;

class BranchModel extends Model
{
    protected $table            = 'branches';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name', 'location', 'type', 'bed_capacity', 'manager_id', 'manager_name',
        'contact_number', 'email', 'address', 'status', 'opening_hours',
        'departments', 'monthly_revenue', 'total_staff', 'total_patients', 'occupancy_rate'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // Validation
    protected $validationRules = [
        'name'         => 'required|min_length[3]|max_length[255]',
        'location'     => 'required|min_length[3]|max_length[255]',
        'type'         => 'required|in_list[Main Hospital,Branch Hospital,Emergency Center,Outpatient Clinic,Specialty Center]',
        'bed_capacity' => 'required|integer|greater_than_equal_to[0]',
        'status'       => 'required|in_list[Active,Inactive,Under Construction,Maintenance]',
    ];

    protected $validationMessages = [
        'name' => [
            'required'   => 'Branch name is required',
            'min_length' => 'Branch name must be at least 3 characters long',
            'max_length' => 'Branch name cannot exceed 255 characters',
        ],
        'location' => [
            'required'   => 'Location is required',
            'min_length' => 'Location must be at least 3 characters long',
            'max_length' => 'Location cannot exceed 255 characters',
        ],
        'type' => [
            'required'  => 'Branch type is required',
            'in_list'   => 'Please select a valid branch type',
        ],
        'bed_capacity' => [
            'required'              => 'Bed capacity is required',
            'integer'               => 'Bed capacity must be a whole number',
            'greater_than_equal_to' => 'Bed capacity cannot be negative',
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list'  => 'Please select a valid status',
        ],
    ];

    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    /**
     * Get all branches with optional filtering
     */
    public function getAllBranches($filters = [])
    {
        // Apply filters
        if (!empty($filters['status'])) {
            $this->where('status', $filters['status']);
        }

        if (!empty($filters['type'])) {
            $this->where('type', $filters['type']);
        }

        if (!empty($filters['search'])) {
            $this->groupStart()
                ->like('name', $filters['search'])
                ->orLike('location', $filters['search'])
                ->orLike('manager_name', $filters['search'])
                ->groupEnd();
        }

        return $this->orderBy('name', 'ASC')->findAll();
    }

    /**
     * Get branch statistics
     */
    public function getBranchStatistics()
    {
        $stats = [
            'total_branches' => $this->countAll(),
            'operational'    => $this->where('status', 'Active')->countAllResults(),
            'under_construction' => $this->where('status', 'Under Construction')->countAllResults(),
            'total_beds'    => $this->selectSum('bed_capacity')->get()->getRow()->bed_capacity ?? 0,
            'total_staff'   => $this->selectSum('total_staff')->get()->getRow()->total_staff ?? 0,
            'total_revenue' => $this->selectSum('monthly_revenue')->get()->getRow()->monthly_revenue ?? 0,
            'total_patients' => $this->selectSum('total_patients')->get()->getRow()->total_patients ?? 0,
        ];

        // Calculate occupancy rate
        $totalBeds = $stats['total_beds'];
        $totalPatients = $stats['total_patients'];
        $stats['occupancy_rate'] = $totalBeds > 0 ? round(($totalPatients / $totalBeds) * 100, 2) : 0;

        return $stats;
    }

    /**
     * Get branches by department
     */
    public function getBranchesByDepartment($departmentId)
    {
        return $this->where("JSON_CONTAINS(departments, '$departmentId')", null, false)
                   ->where('status', 'Active')
                   ->findAll();
    }

    /**
     * Update branch statistics
     */
    public function updateBranchStatistics($branchId)
    {
        // This would typically involve calculating from related tables
        // For now, we'll just update the occupancy rate
        $branch = $this->find($branchId);
        if ($branch) {
            $occupancyRate = $branch['bed_capacity'] > 0 
                ? round(($branch['total_patients'] / $branch['bed_capacity']) * 100, 2) 
                : 0;
            
            $this->update($branchId, ['occupancy_rate' => $occupancyRate]);
        }
    }

    /**
     * Get active branches for dropdown
     */
    public function getActiveBranchesForDropdown()
    {
        return $this->select('id, name, location')
                   ->where('status', 'Active')
                   ->orderBy('name', 'ASC')
                   ->findAll();
    }

    /**
     * Check if branch name exists (for validation)
     */
    public function isNameUnique($name, $excludeId = null)
    {
        $this->where('name', $name);
        
        if ($excludeId) {
            $this->where('id !=', $excludeId);
        }
        
        return $this->countAllResults() === 0;
    }
}
