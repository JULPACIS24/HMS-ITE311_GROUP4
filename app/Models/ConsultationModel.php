<?php

namespace App\Models;

use CodeIgniter\Model;

class ConsultationModel extends Model
{
    protected $table            = 'consultations';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'appointment_id',
        'patient_id',
        'patient_name',
        'patient_id_formatted',
        'doctor_id',
        'doctor_name',
        'consultation_type',
        'date_time',
        'duration',
        'status',
        'chief_complaint',
        'history_of_present_illness',
        'physical_examination',
        'diagnosis',
        'treatment_plan',
        'prescriptions',
        'follow_up_date',
        'follow_up_notes',
        'blood_pressure',
        'heart_rate',
        'temperature',
        'weight',
        'height',
        'notes',
    ];

    protected $useTimestamps = true;

    // Get consultations for a specific doctor
    public function getDoctorConsultations($doctorId, $status = null)
    {
        $builder = $this->where('doctor_id', $doctorId);
        
        if ($status && $status !== 'All') {
            $builder->where('status', $status);
        }
        
        return $builder->orderBy('date_time', 'DESC')->findAll();
    }

    // Get consultations for a specific patient
    public function getPatientConsultations($patientId)
    {
        return $this->where('patient_id', $patientId)
                    ->orderBy('date_time', 'DESC')
                    ->findAll();
    }

    // Get consultation statistics for a doctor
    public function getDoctorConsultationStats($doctorId)
    {
        $today = date('Y-m-d');
        $thisMonth = date('Y-m');
        $thisWeek = date('Y-m-d', strtotime('monday this week'));
        $nextWeek = date('Y-m-d', strtotime('monday next week'));
        
        // Get average duration
        $avgDurationResult = $this->select('AVG(duration) as avg_duration')
                                 ->where('doctor_id', $doctorId)
                                 ->where('duration >', 0)
                                 ->first();
        
        $avgDuration = $avgDurationResult ? round($avgDurationResult['avg_duration']) : 0;
        
        // Get follow-ups scheduled for this week
        $followUps = $this->where('doctor_id', $doctorId)
                         ->where('consultation_type', 'Follow-up')
                         ->where('date_time >=', $thisWeek)
                         ->where('date_time <', $nextWeek)
                         ->countAllResults();
        
        $stats = [
            'total' => $this->where('doctor_id', $doctorId)
                            ->where('DATE_FORMAT(date_time, "%Y-%m")', $thisMonth)
                            ->countAllResults(),
            'active' => $this->where('doctor_id', $doctorId)
                             ->where('status', 'Active')
                             ->countAllResults(),
            'completed' => $this->where('doctor_id', $doctorId)
                                ->where('DATE(date_time)', $today)
                                ->countAllResults(), // Count all consultations today, regardless of status
            'emergency' => $this->where('doctor_id', $doctorId)
                                ->where('consultation_type', 'Emergency')
                                ->where('date_time >=', date('Y-m-d H:i:s', strtotime('-24 hours')))
                                ->countAllResults(),
            'avg_duration' => $avgDuration,
            'follow_ups' => $followUps,
        ];
        
        return $stats;
    }

    // Get consultations with patient and appointment details
    public function getConsultationsWithDetails($doctorId, $status = null)
    {
        $builder = $this->select('consultations.*, patients.first_name, patients.last_name, patients.phone, appointments.appointment_code, appointments.room')
                        ->join('patients', 'patients.id = consultations.patient_id', 'left')
                        ->join('appointments', 'appointments.id = consultations.appointment_id', 'left')
                        ->where('consultations.doctor_id', $doctorId);
        
        if ($status && $status !== 'All') {
            $builder->where('consultations.status', $status);
        }
        
        return $builder->orderBy('consultations.date_time', 'DESC')->findAll();
    }
}
