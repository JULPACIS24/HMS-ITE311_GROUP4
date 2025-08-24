<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class StaffManagement extends BaseController
{
    public function index()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userModel = new \App\Models\UserModel();
        $isItStaff = (session('role') === 'it_staff');

        if ($isItStaff) {
            // IT staff see only operational roles (not IT nor Admin)
            $users = $userModel
                ->whereNotIn('role', ['it_staff', 'admin'])
                ->orderBy('id', 'DESC')
                ->findAll();
        } else {
            // Admin sees all users (including IT staff)
            $users = $userModel
                ->whereNotIn('role', ['admin'])
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        // Calculate real statistics
        $totalUsers = count($users);
        $activeToday = $userModel->where('status', 'Active')->countAllResults();
        
        // Count new users this month
        $currentMonth = date('Y-m');
        $newThisMonth = $userModel->where("DATE_FORMAT(created_at, '%Y-%m')", $currentMonth)->countAllResults();
        
        // Count pending approvals (users with 'Inactive' status)
        $pendingApproval = $userModel->where('status', 'Inactive')->countAllResults();

        return view('auth/staff_management', [
            'users'           => $users,
            'message'         => session()->getFlashdata('message'),
            'errors'          => session()->getFlashdata('errors'),
            'isItStaff'       => $isItStaff,
            'totalUsers'      => $totalUsers,
            'activeToday'     => $activeToday,
            'newThisMonth'    => $newThisMonth,
            'pendingApproval' => $pendingApproval,
        ]);
    }

    public function employeeRecords()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userModel = new \App\Models\UserModel();
        $isItStaff = (session('role') === 'it_staff');

        if ($isItStaff) {
            // IT staff see only operational roles
            $employees = $userModel
                ->whereNotIn('role', ['it_staff', 'admin'])
                ->orderBy('id', 'DESC')
                ->findAll();
        } else {
            // Admin sees all users except admin
            $employees = $userModel
                ->whereNotIn('role', ['admin'])
                ->orderBy('id', 'DESC')
                ->findAll();
        }

        // Calculate employee statistics
        $totalEmployees = count($employees);
        $activeEmployees = $userModel->where('status', 'Active')->countAllResults();
        $inactiveEmployees = $userModel->where('status', 'Inactive')->countAllResults();
        
        // Count by department
        $departmentStats = [];
        $departments = ['Medical', 'Nursing', 'Pharmacy', 'Laboratory', 'Finance', 'Front Desk', 'IT'];
        foreach ($departments as $dept) {
            $count = $userModel->where('department', $dept)->countAllResults();
            if ($count > 0) {
                $departmentStats[$dept] = $count;
            }
        }

        return view('auth/employee_records', [
            'employees' => $employees,
            'isItStaff' => $isItStaff,
            'totalEmployees' => $totalEmployees,
            'activeEmployees' => $activeEmployees,
            'inactiveEmployees' => $inactiveEmployees,
            'departmentStats' => $departmentStats,
        ]);
    }

    public function roleManagement()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userModel = new \App\Models\UserModel();
        $isItStaff = (session('role') === 'it_staff');

        // Get role statistics with real user counts
        $roleStats = [];
        $roles = ['doctor', 'nurse', 'pharmacist', 'laboratory', 'accountant', 'receptionist', 'it_staff'];
        
        foreach ($roles as $role) {
            $count = $userModel->where('role', $role)->countAllResults();
            $roleStats[$role] = $count;
        }
        
        // Get total system statistics
        $totalUsers = $userModel->whereNotIn('role', ['admin'])->countAllResults();
        $totalRoles = count($roles);
        $activeUsers = $userModel->where('status', 'Active')->countAllResults();

        return view('auth/role_management', [
            'roleStats' => $roleStats,
            'isItStaff' => $isItStaff,
            'totalUsers' => $totalUsers,
            'totalRoles' => $totalRoles,
            'activeUsers' => $activeUsers,
        ]);
    }

    public function store()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $isItStaff = (session('role') === 'it_staff');
        $allowedRoles = $isItStaff
            ? ['doctor','nurse','accountant','receptionist','laboratory','pharmacist']
            : ['it_staff','doctor','nurse','accountant','receptionist','laboratory','pharmacist'];

        $rules = [
            'name'             => 'required|min_length[3]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'password'         => 'required|min_length[6]',
            'password_confirm' => 'required|matches[password]',
            'role'             => 'required|in_list[' . implode(',', $allowedRoles) . ']',
        ];

        // Add specialty validation for doctors
        if ($this->request->getPost('role') === 'doctor') {
            $rules['specialty'] = 'required|in_list[Cardiologist,Pediatrician,Surgeon,General Physician]';
        }
        
        // Add department validation for nurses
        if ($this->request->getPost('role') === 'nurse') {
            $rules['department'] = 'required|in_list[Emergency,ICU,Medical]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userModel = new \App\Models\UserModel();
        $role = strtolower($this->request->getPost('role'));
        if (! in_array($role, $allowedRoles, true)) {
            $role = 'it_staff';
        }

        $userData = [
            'name'          => $this->request->getPost('name'),
            'email'         => $this->request->getPost('email'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'          => $role,
            'department'    => $this->mapDepartment($role),
            'status'        => 'Active',
        ];

        // Add specialty for doctors
        if ($role === 'doctor') {
            $userData['specialty'] = $this->request->getPost('specialty');
        }
        
        // Add department for nurses
        if ($role === 'nurse') {
            $userData['department'] = $this->request->getPost('department');
        }

        $userModel->insert($userData);

        return redirect()->to('/staff-management')->with('message', 'User account created successfully.');
    }

    public function updateEmployee()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $id = $this->request->getPost('id');
        $userModel = new \App\Models\UserModel();
        
        $rules = [
            'name'   => 'required|min_length[3]',
            'email'  => 'required|valid_email',
            'role'   => 'required',
            'status' => 'required|in_list[Active,Inactive]',
        ];

        if (! $this->validate($rules)) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $role = strtolower($this->request->getPost('role'));
        $updateData = [
            'name'       => $this->request->getPost('name'),
            'email'      => $this->request->getPost('email'),
            'role'       => $role,
            'department' => $this->mapDepartment($role),
            'status'     => $this->request->getPost('status'),
        ];

        // Add specialty for doctors
        if ($role === 'doctor') {
            $updateData['specialty'] = $this->request->getPost('specialty');
        } else {
            // Clear specialty for non-doctors
            $updateData['specialty'] = null;
        }
        
        // Add department for nurses
        if ($role === 'nurse') {
            $updateData['department'] = $this->request->getPost('department');
        }

        if ($userModel->update($id, $updateData)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Employee updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to update employee.'
            ]);
        }
    }

    public function getEmployee($id)
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userModel = new \App\Models\UserModel();
        $employee = $userModel->find($id);
        
        if ($employee) {
            return $this->response->setJSON([
                'success' => true,
                'employee' => $employee
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Employee not found.'
            ]);
        }
    }

    private function mapDepartment(?string $role): string
    {
        $role = strtolower($role ?? '');
        switch ($role) {
            case 'doctor': return 'Medical';
            case 'nurse': return 'Nursing'; // Default, but can be overridden by user selection
            case 'accountant': return 'Finance';
            case 'receptionist': return 'Front Desk';
            case 'laboratory': return 'Laboratory';
            case 'pharmacist': return 'Pharmacy';
            case 'it_staff':
            default: return 'IT';
        }
    }

    public function getStatistics()
    {
        if (! session('isLoggedIn')) {
            return redirect()->to('/login');
        }
        
        $userModel = new \App\Models\UserModel();
        $isItStaff = (session('role') === 'it_staff');

        if ($isItStaff) {
            $users = $userModel->whereNotIn('role', ['it_staff', 'admin'])->findAll();
        } else {
            $users = $userModel->whereNotIn('role', ['admin'])->findAll();
        }

        // Calculate real-time statistics
        $totalUsers = count($users);
        $activeToday = $userModel->where('status', 'Active')->countAllResults();
        
        $currentMonth = date('Y-m');
        $newThisMonth = $userModel->where("DATE_FORMAT(created_at, '%Y-%m')", $currentMonth)->countAllResults();
        
        $pendingApproval = $userModel->where('status', 'Inactive')->countAllResults();

        return $this->response->setJSON([
            'success' => true,
            'statistics' => [
                'totalUsers' => $totalUsers,
                'activeToday' => $activeToday,
                'newThisMonth' => $newThisMonth,
                'pendingApproval' => $pendingApproval
            ]
        ]);
    }
}
