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
    
    // Get insurance claims with detailed information
    public function getInsuranceClaims()
    {
        $builder = $this->select('bills.*, patients.first_name, patients.last_name, patients.phone, patients.email')
                        ->join('patients', 'patients.id = bills.patient_id', 'left')
                        ->where('bills.insurance_provider IS NOT NULL')
                        ->where('bills.insurance_provider !=', '')
                        ->orderBy('bills.created_at', 'DESC');
        
        $claims = $builder->findAll();
        
        // Transform the data to match the dashboard requirements
        $transformedClaims = [];
        foreach ($claims as $claim) {
            $transformedClaims[] = [
                'claim_id' => $claim['bill_id'],
                'patient_name' => $claim['patient_name'] ?: ($claim['first_name'] . ' ' . $claim['last_name']),
                'services' => $claim['services'] ?: 'Medical Services',
                'insurance_provider' => $claim['insurance_provider'],
                'insurance_id' => $this->getInsuranceId($claim['insurance_details']),
                'claimed_amount' => $claim['total_amount'],
                'approved_amount' => $this->getApprovedAmount($claim),
                'status' => $this->getClaimStatus($claim),
                'submitted_date' => $claim['created_at'],
                'processed_date' => $claim['payment_date'] ?? null,
                'patient_contact' => $claim['phone'] ?? 'N/A',
                'patient_email' => $claim['email'] ?? 'N/A'
            ];
        }
        
        return $transformedClaims;
    }
    
    // Get insurance statistics for dashboard
    public function getInsuranceStatistics()
    {
        $claims = $this->getInsuranceClaims();
        
        if (empty($claims)) {
            return [
                'total_approved' => 0,
                'pending_claims' => 0,
                'rejected_claims' => 0,
                'approval_rate' => 0,
                'total_claims' => 0,
                'total_claimed' => 0
            ];
        }
        
        $totalApproved = 0;
        $pendingClaims = 0;
        $rejectedClaims = 0;
        $totalClaimed = 0;
        
        foreach ($claims as $claim) {
            $totalClaimed += $claim['claimed_amount'];
            
            if ($claim['status'] === 'Approved') {
                $totalApproved += $claim['approved_amount'];
            } elseif ($claim['status'] === 'Pending') {
                $pendingClaims++;
            } elseif ($claim['status'] === 'Rejected') {
                $rejectedClaims++;
            }
        }
        
        $approvalRate = count($claims) > 0 ? round(($totalApproved / $totalClaimed) * 100) : 0;
        
        return [
            'total_approved' => $totalApproved,
            'pending_claims' => $pendingClaims,
            'rejected_claims' => $rejectedClaims,
            'approval_rate' => $approvalRate,
            'total_claims' => count($claims),
            'total_claimed' => $totalClaimed
        ];
    }
    
    // Helper method to extract insurance ID from details
    private function getInsuranceId($insuranceDetails)
    {
        if (empty($insuranceDetails)) return 'N/A';
        
        $details = json_decode($insuranceDetails, true);
        if (!$details) return 'N/A';
        
        if (isset($details['philhealth_number'])) {
            return 'PH-' . $details['philhealth_number'];
        } elseif (isset($details['policy_number'])) {
            return 'MC-' . $details['policy_number'];
        } elseif (isset($details['intellicare_number'])) {
            return 'IC-' . $details['intellicare_number'];
        }
        
        return 'N/A';
    }
    
    // Helper method to get approved amount based on status
    private function getApprovedAmount($claim)
    {
        if ($claim['status'] === 'Paid') {
            return $claim['total_amount'];
        } elseif ($claim['status'] === 'Partial') {
            return $claim['total_amount'] * 0.8; // 80% coverage example
        }
        return 0;
    }
    
    // Helper method to get claim status for display
    private function getClaimStatus($claim)
    {
        if ($claim['status'] === 'Paid') {
            return 'Approved';
        } elseif ($claim['status'] === 'Partial') {
            return 'Partial';
        } elseif ($claim['status'] === 'Pending') {
            return 'Pending';
        } else {
            return 'Rejected';
        }
    }
}
