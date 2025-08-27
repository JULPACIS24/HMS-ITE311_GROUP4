<?php

namespace App\Controllers;

use App\Models\BranchModel;
use App\Models\UserModel;

class BranchManagement extends BaseController
{
    protected $branchModel;
    protected $userModel;

    public function __construct()
    {
        $this->branchModel = new BranchModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Get filters from request
        $filters = [
            'status' => $this->request->getGet('status'),
            'type'   => $this->request->getGet('type'),
            'search' => $this->request->getGet('search'),
        ];

        // Get branches and statistics
        $branches = $this->branchModel->getAllBranches($filters);
        $statistics = $this->branchModel->getBranchStatistics();

        // Get department coverage data
        $departmentCoverage = $this->getDepartmentCoverage();

        return view('auth/branch_management', [
            'branches'            => $branches,
            'statistics'          => $statistics,
            'departmentCoverage'  => $departmentCoverage,
            'filters'             => $filters,
            'message'             => session()->getFlashdata('message'),
            'errors'              => session()->getFlashdata('errors'),
        ]);
    }

    public function create()
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'name'         => $this->request->getPost('name'),
                'location'     => $this->request->getPost('location'),
                'type'         => $this->request->getPost('type'),
                'bed_capacity' => $this->request->getPost('bed_capacity'),
                'manager_name' => $this->request->getPost('manager_name'),
                'contact_number' => $this->request->getPost('contact_number'),
                'email'        => $this->request->getPost('email'),
                'address'      => $this->request->getPost('address'),
                'status'       => $this->request->getPost('status') ?: 'Active',
                'opening_hours' => $this->request->getPost('opening_hours') ?: '24/7',
                'departments'  => $this->request->getPost('departments') ? json_encode($this->request->getPost('departments')) : null,
            ];

            // Validate data
            if (!$this->branchModel->validate($data)) {
                session()->setFlashdata('errors', $this->branchModel->errors());
                return redirect()->back()->withInput();
            }

            // Check if name is unique
            if (!$this->branchModel->isNameUnique($data['name'])) {
                session()->setFlashdata('errors', ['name' => 'Branch name already exists']);
                return redirect()->back()->withInput();
            }

            // Insert branch
            if ($this->branchModel->insert($data)) {
                session()->setFlashdata('message', 'Branch created successfully');
                return redirect()->to('/branch-management');
            } else {
                session()->setFlashdata('errors', ['general' => 'Failed to create branch']);
                return redirect()->back()->withInput();
            }
        }

        // Show create form
        return view('auth/branch_create', [
            'branchTypes' => $this->getBranchTypes(),
            'statuses'    => $this->getStatuses(),
            'departments' => $this->getDepartments(),
        ]);
    }

    public function edit($id = null)
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $branch = $this->branchModel->find($id);
        if (!$branch) {
            session()->setFlashdata('message', 'Branch not found');
            return redirect()->to('/branch-management');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'name'         => $this->request->getPost('name'),
                'location'     => $this->request->getPost('location'),
                'type'         => $this->request->getPost('type'),
                'bed_capacity' => $this->request->getPost('bed_capacity'),
                'manager_name' => $this->request->getPost('manager_name'),
                'contact_number' => $this->request->getPost('contact_number'),
                'email'        => $this->request->getPost('email'),
                'address'      => $this->request->getPost('address'),
                'status'       => $this->request->getPost('status'),
                'opening_hours' => $this->request->getPost('opening_hours'),
                'departments'  => $this->request->getPost('departments') ? json_encode($this->request->getPost('departments')) : null,
            ];

            // Validate data
            if (!$this->branchModel->validate($data)) {
                session()->setFlashdata('errors', $this->branchModel->errors());
                return redirect()->back()->withInput();
            }

            // Check if name is unique (excluding current branch)
            if (!$this->branchModel->isNameUnique($data['name'], $id)) {
                session()->setFlashdata('errors', ['name' => 'Branch name already exists']);
                return redirect()->back()->withInput();
            }

            // Update branch
            if ($this->branchModel->update($id, $data)) {
                session()->setFlashdata('message', 'Branch updated successfully');
                return redirect()->to('/branch-management');
            } else {
                session()->setFlashdata('errors', ['general' => 'Failed to update branch']);
                return redirect()->back()->withInput();
            }
        }

        // Show edit form
        return view('auth/branch_edit', [
            'branch'      => $branch,
            'branchTypes' => $this->getBranchTypes(),
            'statuses'    => $this->getStatuses(),
            'departments' => $this->getDepartments(),
        ]);
    }

    public function delete($id = null)
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $branch = $this->branchModel->find($id);
        if (!$branch) {
            session()->setFlashdata('message', 'Branch not found');
            return redirect()->to('/branch-management');
        }

        if ($this->branchModel->delete($id)) {
            session()->setFlashdata('message', 'Branch deleted successfully');
        } else {
            session()->setFlashdata('message', 'Failed to delete branch');
        }

        return redirect()->to('/branch-management');
    }

    public function view($id = null)
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $branch = $this->branchModel->find($id);
        if (!$branch) {
            session()->setFlashdata('message', 'Branch not found');
            return redirect()->to('/branch-management');
        }

        return view('auth/branch_view', [
            'branch' => $branch,
        ]);
    }

    public function updateStatistics($id = null)
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $this->branchModel->updateBranchStatistics($id);
        session()->setFlashdata('message', 'Branch statistics updated');
        return redirect()->to('/branch-management');
    }

    // AJAX endpoints
    public function getBranchesAjax()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $filters = [
            'status' => $this->request->getGet('status'),
            'type'   => $this->request->getGet('type'),
            'search' => $this->request->getGet('search'),
        ];

        $branches = $this->branchModel->getAllBranches($filters);
        return $this->response->setJSON(['branches' => $branches]);
    }

    public function getStatisticsAjax()
    {
        if (!session('isLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $statistics = $this->branchModel->getBranchStatistics();
        return $this->response->setJSON(['statistics' => $statistics]);
    }

    // Helper methods
    private function getBranchTypes()
    {
        return [
            'Main Hospital'      => 'Main Hospital',
            'Branch Hospital'    => 'Branch Hospital',
            'Emergency Center'   => 'Emergency Center',
            'Outpatient Clinic'  => 'Outpatient Clinic',
            'Specialty Center'   => 'Specialty Center',
        ];
    }

    private function getStatuses()
    {
        return [
            'Active'             => 'Active',
            'Inactive'           => 'Inactive',
            'Under Construction' => 'Under Construction',
            'Maintenance'        => 'Maintenance',
        ];
    }

    private function getDepartments()
    {
        // This would typically come from a departments table
        // For now, we'll use a static list
        return [
            'emergency' => 'Emergency Department',
            'cardiology' => 'Cardiology',
            'pediatrics' => 'Pediatrics',
            'laboratory' => 'Laboratory',
            'pharmacy' => 'Pharmacy',
            'radiology' => 'Radiology',
            'surgery' => 'Surgery',
            'orthopedics' => 'Orthopedics',
            'neurology' => 'Neurology',
            'oncology' => 'Oncology',
        ];
    }

    private function getDepartmentCoverage()
    {
        // This would typically be calculated from the database
        // For now, we'll return static data based on the UI shown
        return [
            'Emergency Department' => [
                'branches' => ['Main Campus', 'Emergency Center'],
                'hours' => '24/7'
            ],
            'Cardiology' => [
                'branches' => ['Main Campus'],
                'hours' => 'Mon-Fri 8AM-6PM'
            ],
            'Pediatrics' => [
                'branches' => ['Main Campus', 'Downtown Clinic'],
                'hours' => 'Mon-Sat 8AM-8PM'
            ],
            'Laboratory' => [
                'branches' => ['All Branches'],
                'hours' => '24/7'
            ],
        ];
    }
}
