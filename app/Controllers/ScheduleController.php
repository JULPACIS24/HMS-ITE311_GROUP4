<?php

namespace App\Controllers;

use App\Models\ScheduleModel;
use App\Models\PatientModel;
use App\Models\UserModel;

class ScheduleController extends BaseController
{
    protected $scheduleModel;
    protected $patientModel;
    protected $userModel;

    public function __construct()
    {
        $this->scheduleModel = new ScheduleModel();
        $this->patientModel = new PatientModel();
        $this->userModel = new UserModel();
    }

    /**
     * Display the main schedule page
     */
    public function index()
    {
        // Get current week dates
        $currentWeek = $this->getCurrentWeek();
        
        // Get doctor ID from session (assuming doctor is logged in)
        $doctorId = session()->get('user_id') ?? 1; // Default to 1 for testing
        
        // Get weekly statistics
        $stats = $this->scheduleModel->getWeeklyStats(
            $doctorId, 
            $currentWeek['start'], 
            $currentWeek['end']
        );
        
        // Get schedules for current week
        $schedules = $this->scheduleModel->getSchedulesByWeek(
            $doctorId, 
            $currentWeek['start'], 
            $currentWeek['end']
        );
        
        // Get consultations for current week
        $consultationModel = new \App\Models\ConsultationModel();
        $consultations = $consultationModel->where('doctor_id', $doctorId)
            ->where('date_time >=', $currentWeek['start'] . ' 00:00:00')
            ->where('date_time <=', $currentWeek['end'] . ' 23:59:59')
            ->orderBy('date_time', 'ASC')
            ->findAll();
        
        // Convert consultations to schedule format for display
        $consultationSchedules = [];
        $appointmentModel = new \App\Models\AppointmentModel();
        
        foreach ($consultations as $consultation) {
            $dateTime = new \DateTime($consultation['date_time']);
            $endTime = clone $dateTime;
            $endTime->add(new \DateInterval('PT' . ($consultation['duration'] ?? 30) . 'M'));
            
            // Get room information from appointment if available
            $room = 'N/A';
            if ($consultation['appointment_id']) {
                $appointment = $appointmentModel->find($consultation['appointment_id']);
                if ($appointment && isset($appointment['room'])) {
                    $room = $appointment['room'];
                }
            }
            
            $consultationSchedules[] = [
                'id' => 'consultation_' . $consultation['id'],
                'title' => $consultation['patient_name'] . ' - ' . $consultation['consultation_type'],
                'type' => 'consultation',
                'date' => $dateTime->format('Y-m-d'),
                'start_time' => $dateTime->format('H:i'),
                'end_time' => $endTime->format('H:i'),
                'room' => $room,
                'description' => $consultation['chief_complaint'] ?? '',
                'consultation_id' => $consultation['id'],
                'patient_name' => $consultation['patient_name'],
                'consultation_type' => $consultation['consultation_type'],
                'status' => $consultation['status'] ?? 'Active'
            ];
        }
        
        // Merge schedules and consultations
        $allSchedules = array_merge($schedules, $consultationSchedules);
        
        // Get all patients for dropdown
        $patients = $this->patientModel->findAll();
        
        $data = [
            'title' => 'My Schedule',
            'currentWeek' => $currentWeek,
            'stats' => $stats,
            'schedules' => $allSchedules,
            'patients' => $patients,
            'doctorId' => $doctorId
        ];
        
        return view('auth/doctor_schedule', $data);
    }

    /**
     * Get schedules for a specific week (AJAX)
     */
    public function getWeek()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        $doctorId = session()->get('user_id') ?? 1;

        if (!$startDate || !$endDate) {
            return $this->response->setJSON(['error' => 'Start and end dates are required']);
        }

        // Get schedules
        $schedules = $this->scheduleModel->getSchedulesByWeek($doctorId, $startDate, $endDate);
        
        // Get consultations for current week
        $consultationModel = new \App\Models\ConsultationModel();
        $consultations = $consultationModel->where('doctor_id', $doctorId)
            ->where('date_time >=', $startDate . ' 00:00:00')
            ->where('date_time <=', $endDate . ' 23:59:59')
            ->orderBy('date_time', 'ASC')
            ->findAll();
        
        // Convert consultations to schedule format for display
        $consultationSchedules = [];
        $appointmentModel = new \App\Models\AppointmentModel();
        
        foreach ($consultations as $consultation) {
            $dateTime = new \DateTime($consultation['date_time']);
            $endTime = clone $dateTime;
            $endTime->add(new \DateInterval('PT' . ($consultation['duration'] ?? 30) . 'M'));
            
            // Get room information from appointment if available
            $room = 'N/A';
            if ($consultation['appointment_id']) {
                $appointment = $appointmentModel->find($consultation['appointment_id']);
                if ($appointment && isset($appointment['room'])) {
                    $room = $appointment['room'];
                }
            }
            
            $consultationSchedules[] = [
                'id' => 'consultation_' . $consultation['id'],
                'title' => $consultation['patient_name'] . ' - ' . $consultation['consultation_type'],
                'type' => 'consultation',
                'date' => $dateTime->format('Y-m-d'),
                'start_time' => $dateTime->format('H:i'),
                'end_time' => $endTime->format('H:i'),
                'room' => $room,
                'description' => $consultation['chief_complaint'] ?? '',
                'consultation_id' => $consultation['id'],
                'patient_name' => $consultation['patient_name'],
                'consultation_type' => $consultation['consultation_type'],
                'status' => $consultation['status'] ?? 'Active'
            ];
        }
        
        // Merge schedules and consultations
        $allSchedules = array_merge($schedules, $consultationSchedules);
        
        // Get statistics
        $stats = $this->scheduleModel->getWeeklyStats($doctorId, $startDate, $endDate);

        return $this->response->setJSON([
            'success' => true,
            'schedules' => $allSchedules,
            'stats' => $stats
        ]);
    }

    /**
     * Add new schedule item (AJAX)
     */
    public function addSchedule()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $doctorId = session()->get('user_id') ?? 1;
        
        $data = [
            'doctor_id' => $doctorId,
            'patient_id' => $this->request->getPost('patient_id') ?: null,
            'title' => $this->request->getPost('title'),
            'type' => $this->request->getPost('type'),
            'date' => $this->request->getPost('date'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'room' => $this->request->getPost('room'),
            'description' => $this->request->getPost('description'),
            'status' => 'scheduled'
        ];

        // Validate data
        if (!$this->scheduleModel->validate($data)) {
            return $this->response->setJSON([
                'error' => 'Validation failed',
                'errors' => $this->scheduleModel->errors()
            ]);
        }

        // Check for time conflicts
        if ($this->scheduleModel->checkTimeConflict(
            $data['doctor_id'], 
            $data['date'], 
            $data['start_time'], 
            $data['end_time']
        )) {
            return $this->response->setJSON([
                'error' => 'Time conflict detected. Please choose a different time slot.'
            ]);
        }

        // Insert schedule
        $scheduleId = $this->scheduleModel->addSchedule($data);
        
        if ($scheduleId) {
            // Get the newly created schedule with patient details
            $newSchedule = $this->scheduleModel->getScheduleWithPatient($scheduleId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Schedule added successfully',
                'schedule' => $newSchedule
            ]);
        } else {
            return $this->response->setJSON([
                'error' => 'Failed to add schedule'
            ]);
        }
    }

    /**
     * Block time slot (AJAX)
     */
    public function blockTime()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $doctorId = session()->get('user_id') ?? 1;
        $date = $this->request->getPost('date');
        $startTime = $this->request->getPost('start_time');
        $endTime = $this->request->getPost('end_time');
        $description = $this->request->getPost('description') ?: 'Blocked Time';

        if (!$date || !$startTime || !$endTime) {
            return $this->response->setJSON(['error' => 'Date, start time, and end time are required']);
        }

        // Check for time conflicts
        if ($this->scheduleModel->checkTimeConflict($doctorId, $date, $startTime, $endTime)) {
            return $this->response->setJSON([
                'error' => 'Time conflict detected. Please choose a different time slot.'
            ]);
        }

        // Block time
        $blockId = $this->scheduleModel->blockTime($doctorId, $date, $startTime, $endTime, $description);
        
        if ($blockId) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Time blocked successfully',
                'block_id' => $blockId
            ]);
        } else {
            return $this->response->setJSON([
                'error' => 'Failed to block time'
            ]);
        }
    }

    /**
     * Get schedule details (AJAX)
     */
    public function getScheduleDetails()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $scheduleId = $this->request->getPost('schedule_id');
        
        if (!$scheduleId) {
            return $this->response->setJSON(['error' => 'Schedule ID is required']);
        }

        $schedule = $this->scheduleModel->getScheduleWithPatient($scheduleId);
        
        if ($schedule) {
            return $this->response->setJSON([
                'success' => true,
                'schedule' => $schedule
            ]);
        } else {
            return $this->response->setJSON([
                'error' => 'Schedule not found'
            ]);
        }
    }

    /**
     * Update schedule (AJAX)
     */
    public function updateSchedule()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $scheduleId = $this->request->getPost('schedule_id');
        $data = [
            'patient_id' => $this->request->getPost('patient_id') ?: null,
            'title' => $this->request->getPost('title'),
            'type' => $this->request->getPost('type'),
            'date' => $this->request->getPost('date'),
            'start_time' => $this->request->getPost('start_time'),
            'end_time' => $this->request->getPost('end_time'),
            'room' => $this->request->getPost('room'),
            'description' => $this->request->getPost('description')
        ];

        // Check for time conflicts (excluding current schedule)
        if ($this->scheduleModel->checkTimeConflict(
            session()->get('user_id') ?? 1, 
            $data['date'], 
            $data['start_time'], 
            $data['end_time'], 
            $scheduleId
        )) {
            return $this->response->setJSON([
                'error' => 'Time conflict detected. Please choose a different time slot.'
            ]);
        }

        // Update schedule
        if ($this->scheduleModel->updateSchedule($scheduleId, $data)) {
            $updatedSchedule = $this->scheduleModel->getScheduleWithPatient($scheduleId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Schedule updated successfully',
                'schedule' => $updatedSchedule
            ]);
        } else {
            return $this->response->setJSON([
                'error' => 'Failed to update schedule'
            ]);
        }
    }

    /**
     * Delete schedule (AJAX)
     */
    public function deleteSchedule()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $scheduleId = $this->request->getPost('schedule_id');
        
        if (!$scheduleId) {
            return $this->response->setJSON(['error' => 'Schedule ID is required']);
        }

        if ($this->scheduleModel->deleteSchedule($scheduleId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Schedule deleted successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'error' => 'Failed to delete schedule'
            ]);
        }
    }

    /**
     * Get current week dates
     */
    private function getCurrentWeek()
    {
        $today = date('Y-m-d');
        $dayOfWeek = date('N', strtotime($today)); // 1=Monday, 7=Sunday
        
        $monday = date('Y-m-d', strtotime($today . ' -' . ($dayOfWeek - 1) . ' days'));
        $sunday = date('Y-m-d', strtotime($monday . ' +6 days'));
        
        return [
            'start' => $monday,
            'end' => $sunday,
            'current' => $today
        ];
    }

    /**
     * Get week dates for navigation
     */
    public function getWeekDates()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        $direction = $this->request->getPost('direction'); // 'prev', 'next', 'current'
        $currentStart = $this->request->getPost('current_start');
        
        if (!$currentStart) {
            $currentStart = date('Y-m-d');
        }

        $monday = date('Y-m-d', strtotime($currentStart . ' -' . (date('N', strtotime($currentStart)) - 1) . ' days'));
        
        switch ($direction) {
            case 'prev':
                $monday = date('Y-m-d', strtotime($monday . ' -7 days'));
                break;
            case 'next':
                $monday = date('Y-m-d', strtotime($monday . ' +7 days'));
                break;
            case 'current':
            default:
                $monday = date('Y-m-d', strtotime('monday this week'));
                break;
        }
        
        $sunday = date('Y-m-d', strtotime($monday . ' +6 days'));
        
        return $this->response->setJSON([
            'success' => true,
            'start_date' => $monday,
            'end_date' => $sunday
        ]);
    }
}
