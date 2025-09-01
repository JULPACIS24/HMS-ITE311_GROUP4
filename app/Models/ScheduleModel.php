<?php

namespace App\Models;

use CodeIgniter\Model;

class ScheduleModel extends Model
{
    protected $table = 'schedules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'doctor_id', 'patient_id', 'title', 'type', 'date', 
        'start_time', 'end_time', 'room', 'description', 'status'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation - Temporarily disabled for testing
    protected $validationRules = [];
    
    protected $validationMessages = [];
    
    protected $skipValidation = true;
    protected $cleanValidationRules = true;

    /**
     * Get schedules for a specific week
     */
    public function getSchedulesByWeek($doctorId, $startDate, $endDate)
    {
        return $this->select('schedules.*, COALESCE(patients.first_name, "") as first_name, COALESCE(patients.last_name, "") as last_name, COALESCE(patients.phone, "") as phone')
                    ->join('patients', 'patients.id = schedules.patient_id', 'left')
                    ->where('schedules.doctor_id', $doctorId)
                    ->where('schedules.date >=', $startDate)
                    ->where('schedules.date <=', $endDate)
                    ->where('schedules.status !=', 'cancelled')
                    ->orderBy('schedules.date', 'ASC')
                    ->orderBy('schedules.start_time', 'ASC')
                    ->findAll();
    }

    /**
     * Get weekly statistics
     */
    public function getWeeklyStats($doctorId, $startDate, $endDate)
    {
        $db = \Config\Database::connect();
        
        // Weekly Hours
        $weeklyHours = $db->query("
            SELECT SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as total_minutes
            FROM schedules 
            WHERE doctor_id = ? AND date BETWEEN ? AND ? AND status != 'cancelled'
        ", [$doctorId, $startDate, $endDate])->getRow();
        
        $weeklyHours = $weeklyHours ? round($weeklyHours->total_minutes / 60, 1) : 0;

        // Surgeries Scheduled
        $surgeries = $this->where('doctor_id', $doctorId)
                         ->where('date >=', $startDate)
                         ->where('date <=', $endDate)
                         ->where('type', 'surgery')
                         ->where('status !=', 'cancelled')
                         ->countAllResults();

        // Available Slots (assuming 8-hour workday, 30-min slots)
        $totalSlots = 0;
        $bookedSlots = 0;
        
        $currentDate = $startDate;
        while ($currentDate <= $endDate) {
            $dayOfWeek = date('N', strtotime($currentDate)); // 1=Monday, 7=Sunday
            if ($dayOfWeek >= 1 && $dayOfWeek <= 5) { // Weekdays only
                $totalSlots += 16; // 8 hours * 2 slots per hour
                
                $dayBooked = $db->query("
                    SELECT SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as booked_minutes
                    FROM schedules 
                    WHERE doctor_id = ? AND date = ? AND status != 'cancelled'
                ", [$doctorId, $currentDate])->getRow();
                
                $bookedSlots += $dayBooked ? ceil($dayBooked->booked_minutes / 30) : 0;
            }
            $currentDate = date('Y-m-d', strtotime($currentDate . ' +1 day'));
        }
        
        $availableSlots = max(0, $totalSlots - $bookedSlots);

        // On-Call Hours
        $onCallHours = $db->query("
            SELECT SUM(TIMESTAMPDIFF(MINUTE, start_time, end_time)) as total_minutes
            FROM schedules 
            WHERE doctor_id = ? AND date BETWEEN ? AND ? AND type = 'on_call' AND status != 'cancelled'
        ", [$doctorId, $startDate, $endDate])->getRow();
        
        $onCallHours = $onCallHours ? round($onCallHours->total_minutes / 60, 1) : 0;

        return [
            'weekly_hours' => $weeklyHours,
            'surgeries_scheduled' => $surgeries,
            'available_slots' => $availableSlots,
            'on_call_hours' => $onCallHours
        ];
    }

    /**
     * Add new schedule item
     */
    public function addSchedule($data)
    {
        return $this->insert($data);
    }

    /**
     * Block time slot
     */
    public function blockTime($doctorId, $date, $startTime, $endTime, $description = 'Blocked Time')
    {
        $data = [
            'doctor_id' => $doctorId,
            'title' => 'Blocked Time',
            'type' => 'blocked',
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'description' => $description,
            'status' => 'scheduled'
        ];
        
        return $this->insert($data);
    }

    /**
     * Get schedule by ID with patient details
     */
    public function getScheduleWithPatient($id)
    {
        return $this->select('schedules.*, patients.first_name, patients.last_name, patients.phone, patients.email')
                    ->join('patients', 'patients.id = schedules.patient_id', 'left')
                    ->where('schedules.id', $id)
                    ->first();
    }

    /**
     * Update schedule
     */
    public function updateSchedule($id, $data)
    {
        return $this->update($id, $data);
    }

    /**
     * Delete schedule
     */
    public function deleteSchedule($id)
    {
        return $this->delete($id);
    }

    /**
     * Check for time conflicts
     */
    public function checkTimeConflict($doctorId, $date, $startTime, $endTime, $excludeId = null)
    {
        $builder = $this->where('doctor_id', $doctorId)
                        ->where('date', $date)
                        ->where('status !=', 'cancelled')
                        ->where("(
                            (start_time <= ? AND end_time > ?) OR
                            (start_time < ? AND end_time >= ?) OR
                            (start_time >= ? AND end_time <= ?)
                        )", [$startTime, $startTime, $endTime, $endTime, $startTime, $endTime]);
        
        if ($excludeId) {
            $builder->where('id !=', $excludeId);
        }
        
        return $builder->countAllResults() > 0;
    }

    /**
     * Delete all schedules for a specific doctor
     */
    public function deleteAllSchedulesForDoctor($doctorId)
    {
        try {
            $deletedCount = $this->where('doctor_id', $doctorId)->countAllResults();
            $this->where('doctor_id', $doctorId)->delete();
            return $deletedCount;
        } catch (\Exception $e) {
            log_message('error', 'Error deleting all schedules for doctor: ' . $e->getMessage());
            return 0;
        }
    }
}
