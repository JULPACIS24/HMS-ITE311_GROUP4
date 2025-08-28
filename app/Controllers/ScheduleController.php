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
        
        // Get form data
        $title = $this->request->getPost('title');
        $type = $this->request->getPost('type');
        $date = $this->request->getPost('date');
        $startTime = $this->request->getPost('start_time');
        $endTime = $this->request->getPost('end_time');
        $room = $this->request->getPost('room');
        $description = $this->request->getPost('description');
        
        // Basic validation
        if (empty($title) || empty($type) || empty($date) || empty($startTime) || empty($endTime)) {
            return $this->response->setJSON([
                'error' => 'Please fill in all required fields'
            ]);
        }
        
        $data = [
            'doctor_id' => $doctorId,
            'title' => $title,
            'type' => $type,
            'date' => $date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'room' => $room ?: '',
            'description' => $description ?: '',
            'status' => 'scheduled'
        ];

        try {
            // Insert schedule directly without complex validation
            $scheduleId = $this->scheduleModel->insert($data);
            
            if ($scheduleId) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Schedule added successfully',
                    'schedule_id' => $scheduleId
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => 'Failed to add schedule to database'
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Schedule add error: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Database error occurred. Please try again.'
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
     * Test method to check database connection and schedule functionality
     */
    public function test()
    {
        try {
            // Test database connection
            $db = \Config\Database::connect();
            $result = $db->query('SELECT COUNT(*) as count FROM schedules')->getRow();
            
            // Test getting schedules
            $schedules = $this->scheduleModel->findAll();
            
            // Test getting patients
            $patients = $this->patientModel->findAll();
            
            echo "Database connection: OK<br>";
            echo "Schedules table count: " . ($result ? $result->count : 'Error') . "<br>";
            echo "Schedules found: " . count($schedules) . "<br>";
            echo "Patients found: " . count($patients) . "<br>";
            
            // Show sample schedule data
            if (!empty($schedules)) {
                echo "<h3>Sample Schedule:</h3>";
                echo "<pre>" . print_r($schedules[0], true) . "</pre>";
            }
            
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    /**
     * Get patients for dropdown (AJAX)
     */
    public function getPatients()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        try {
            $patientModel = new \App\Models\PatientModel();
            $patients = $patientModel->select('id, first_name, last_name, phone')
                                   ->where('status', 'active')
                                   ->orderBy('first_name', 'ASC')
                                   ->findAll();

            $patientList = [];
            foreach ($patients as $patient) {
                $patientList[] = [
                    'id' => $patient['id'],
                    'name' => $patient['first_name'] . ' ' . $patient['last_name'],
                    'phone' => $patient['phone']
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'patients' => $patientList
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get patients error: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Failed to load patients'
            ]);
        }
    }

    /**
     * Get rooms for dropdown (AJAX)
     */
    public function getRooms()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        try {
            $roomModel = new \App\Models\RoomModel();
            $rooms = $roomModel->select('id, room_number, room_type, floor')
                              ->where('status', 'available')
                              ->orderBy('room_number', 'ASC')
                              ->findAll();

            $roomList = [];
            foreach ($rooms as $room) {
                $roomList[] = [
                    'id' => $room['id'],
                    'name' => $room['room_number'] . ' (' . $room['room_type'] . ')',
                    'type' => $room['room_type']
                ];
            }

            // Add default rooms if no rooms in database
            if (empty($roomList)) {
                $roomList = [
                    ['id' => 'room_201', 'name' => 'Room 201', 'type' => 'Consultation'],
                    ['id' => 'room_202', 'name' => 'Room 202', 'type' => 'Consultation'],
                    ['id' => 'room_203', 'name' => 'Room 203', 'type' => 'Consultation'],
                    ['id' => 'or_1', 'name' => 'OR-1', 'type' => 'Operating Room'],
                    ['id' => 'or_2', 'name' => 'OR-2', 'type' => 'Operating Room'],
                    ['id' => 'doctor_room', 'name' => 'Doctor Room', 'type' => 'Office'],
                    ['id' => 'conference', 'name' => 'Conference Room', 'type' => 'Meeting'],
                    ['id' => 'various', 'name' => 'Various', 'type' => 'Other']
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'rooms' => $roomList
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Get rooms error: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Failed to load rooms'
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

    /**
     * Get weekly schedules for current week (AJAX)
     */
    public function getWeeklySchedules()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['error' => 'Invalid request']);
        }

        try {
            $doctorId = session()->get('user_id') ?? 1; // Default to 1 for testing
            
            // Get current week dates
            $currentWeek = $this->getCurrentWeek();
            
            // Get schedules for current week
            $schedules = $this->scheduleModel->getSchedulesByWeek(
                $doctorId, 
                $currentWeek['start'], 
                $currentWeek['end']
            );
            
            // Format schedules for frontend
            $formattedSchedules = [];
            foreach ($schedules as $schedule) {
                $formattedSchedules[] = [
                    'id' => $schedule['id'],
                    'title' => $schedule['title'],
                    'type' => $schedule['type'],
                    'date' => $schedule['date'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'],
                    'room' => $schedule['room'],
                    'description' => $schedule['description'],
                    'status' => $schedule['status']
                ];
            }
            
            return $this->response->setJSON([
                'success' => true,
                'schedules' => $formattedSchedules,
                'week_start' => $currentWeek['start'],
                'week_end' => $currentWeek['end']
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Get weekly schedules error: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => 'Failed to load schedules'
            ]);
        }
    }
}
