<?php

namespace App\Models;

use CodeIgniter\Model;

class BillModel extends Model
{
    protected $table = 'bills';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'bill_id', 'patient_id', 'patient_name', 'bill_date', 'due_date', 'services',
        'subtotal', 'tax', 'discount', 'total_amount', 'status', 'payment_method',
        'payment_date', 'notes', 'insurance_provider', 'insurance_details'
    ];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    
    // Generate unique bill ID
    public function generateBillId()
    {
        $prefix = 'B';
        $year = date('Y');
        $month = date('m');
        
        // Get the last bill number for this month
        $lastBill = $this->where('bill_id LIKE', $prefix . $year . $month . '%')
                         ->orderBy('bill_id', 'DESC')
                         ->first();
        
        if ($lastBill) {
            $lastNumber = intval(substr($lastBill['bill_id'], -3));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . $year . $month . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }
    
    // Get bills with patient information
    public function getBillsWithPatients($limit = null, $status = null)
    {
        $builder = $this->select('bills.*, patients.first_name, patients.last_name, patients.phone, patients.email')
                        ->join('patients', 'patients.id = bills.patient_id', 'left');
        
        if ($status && $status !== 'All Status') {
            $builder->where('bills.status', $status);
        }
        
        $builder->orderBy('bills.created_at', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }
    
    // Get bill statistics
    public function getBillStatistics()
    {
        $stats = [
            'total_revenue' => 0,
            'pending_bills' => 0,
            'pending_amount' => 0,
            'overdue_bills' => 0,
            'todays_collection' => 0
        ];
        
        // Total revenue (sum of all paid bills)
        $totalRevenue = $this->selectSum('total_amount')
                            ->where('status', 'Paid')
                            ->first();
        $stats['total_revenue'] = $totalRevenue['total_amount'] ?? 0;
        
        // Pending bills count and amount
        $pendingBills = $this->where('status', 'Pending')->findAll();
        $stats['pending_bills'] = count($pendingBills);
        $stats['pending_amount'] = array_sum(array_column($pendingBills, 'total_amount'));
        
        // Overdue bills
        $overdueBills = $this->where('status', 'Pending')
                             ->where('due_date <', date('Y-m-d'))
                             ->countAllResults();
        $stats['overdue_bills'] = $overdueBills;
        
        // Today's collection
        $todaysCollection = $this->selectSum('total_amount')
                                ->where('status', 'Paid')
                                ->where('DATE(payment_date)', date('Y-m-d'))
                                ->first();
        $stats['todays_collection'] = $todaysCollection['total_amount'] ?? 0;
        
        return $stats;
    }
    
    // Update bill status
    public function updateBillStatus($billId, $status, $paymentMethod = null, $paymentDate = null)
    {
        $data = ['status' => $status];
        
        if ($paymentMethod) {
            $data['payment_method'] = $paymentMethod;
        }
        
        if ($paymentDate) {
            $data['payment_date'] = $paymentDate;
        }
        
        return $this->where('bill_id', $billId)->set($data)->update();
    }
}
