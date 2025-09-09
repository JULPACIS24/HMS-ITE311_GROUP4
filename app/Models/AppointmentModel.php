<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
	protected $table            = 'appointments';
	protected $primaryKey       = 'id';
	protected $allowedFields    = [
		'appointment_code',
		'patient_id',
		'patient_name',
		'patient_phone',
		'doctor_id',
		'doctor_name',
		'date_time',
		'type',
		'status',
		'room',
		'notes',
		'color_label',
		'duration',
		'created_at',
		'updated_at',
	];

	protected $useTimestamps = true;

	/**
	 * Get appointments for a specific doctor and date range
	 */
	public function getAppointmentsByDoctorAndDate($doctorId, $startDate = null, $endDate = null)
	{
		$builder = $this->where('doctor_id', $doctorId);
		
		if ($startDate) {
			$builder->where('date_time >=', $startDate . ' 00:00:00');
		}
		
		if ($endDate) {
			$builder->where('date_time <=', $endDate . ' 23:59:59');
		}
		
		return $builder->orderBy('date_time', 'ASC')->findAll();
	}

	/**
	 * Get appointments for a specific date (all doctors)
	 */
	public function getAppointmentsByDate($date)
	{
		$nextDay = date('Y-m-d', strtotime($date . ' +1 day'));
		
		return $this->where('date_time >=', $date . ' 00:00:00')
					->where('date_time <', $nextDay . ' 00:00:00')
					->orderBy('date_time', 'ASC')
					->findAll();
	}

	/**
	 * Get all appointments with patient and doctor details
	 */
	public function getAppointmentsWithDetails($filters = [])
	{
		$builder = $this->select('appointments.*, patients.first_name, patients.last_name, patients.phone, users.name as doctor_name, users.specialty')
						->join('patients', 'patients.id = appointments.patient_id', 'left')
						->join('users', 'users.id = appointments.doctor_id', 'left');

		// Apply filters
		if (isset($filters['doctor_id'])) {
			$builder->where('appointments.doctor_id', $filters['doctor_id']);
		}

		if (isset($filters['date'])) {
			$nextDay = date('Y-m-d', strtotime($filters['date'] . ' +1 day'));
			$builder->where('appointments.date_time >=', $filters['date'] . ' 00:00:00')
					->where('appointments.date_time <', $nextDay . ' 00:00:00');
		}

		// Handle date range filters (for weekly calendar)
		if (isset($filters['start_date']) && isset($filters['end_date'])) {
			$builder->where('appointments.date_time >=', $filters['start_date'] . ' 00:00:00')
					->where('appointments.date_time <=', $filters['end_date'] . ' 23:59:59');
		}

		if (isset($filters['status'])) {
			$builder->where('appointments.status', $filters['status']);
		}

		return $builder->orderBy('appointments.date_time', 'ASC')->findAll();
	}

	/**
	 * Check for appointment conflicts
	 */
	public function checkConflict($doctorId, $dateTime, $duration = 60, $excludeId = null)
	{
		$startTime = new \DateTime($dateTime);
		$endTime = clone $startTime;
		$endTime->add(new \DateInterval('PT' . $duration . 'M'));

		$startTimeStr = $startTime->format('Y-m-d H:i:s');
		$endTimeStr = $endTime->format('Y-m-d H:i:s');

		// Get all appointments for the doctor on the same date
		$appointments = $this->where('doctor_id', $doctorId)
							->where('status !=', 'Cancelled')
							->where('DATE(date_time)', date('Y-m-d', strtotime($dateTime)))
							->findAll();

		if ($excludeId) {
			$appointments = array_filter($appointments, function($apt) use ($excludeId) {
				return $apt['id'] != $excludeId;
			});
		}

		// Check for conflicts
		foreach ($appointments as $appointment) {
			$aptStart = new \DateTime($appointment['date_time']);
			$aptDuration = $appointment['duration'] ?? 60;
			$aptEnd = clone $aptStart;
			$aptEnd->add(new \DateInterval('PT' . $aptDuration . 'M'));

			// Check if appointments overlap
			if (($startTime < $aptEnd) && ($endTime > $aptStart)) {
				return true; // Conflict found
			}
		}

		return false; // No conflict
	}

	/**
	 * Get appointment statistics
	 */
	public function getStatistics($filters = [])
	{
		$baseBuilder = $this;

		// Apply common filters
		if (isset($filters['doctor_id'])) {
			$baseBuilder->where('doctor_id', $filters['doctor_id']);
		}

		if (isset($filters['date'])) {
			$nextDay = date('Y-m-d', strtotime($filters['date'] . ' +1 day'));
			$baseBuilder->where('date_time >=', $filters['date'] . ' 00:00:00')
						->where('date_time <', $nextDay . ' 00:00:00');
		}

		$total = $baseBuilder->countAllResults(false);

		// Get status counts with same filters
		$confirmedBuilder = $this;
		$pendingBuilder = $this;
		$completedBuilder = $this;
		$cancelledBuilder = $this;

		// Apply same filters to each status query
		if (isset($filters['doctor_id'])) {
			$confirmedBuilder->where('doctor_id', $filters['doctor_id']);
			$pendingBuilder->where('doctor_id', $filters['doctor_id']);
			$completedBuilder->where('doctor_id', $filters['doctor_id']);
			$cancelledBuilder->where('doctor_id', $filters['doctor_id']);
		}

		if (isset($filters['date'])) {
			$nextDay = date('Y-m-d', strtotime($filters['date'] . ' +1 day'));
			$confirmedBuilder->where('date_time >=', $filters['date'] . ' 00:00:00')
							->where('date_time <', $nextDay . ' 00:00:00');
			$pendingBuilder->where('date_time >=', $filters['date'] . ' 00:00:00')
							->where('date_time <', $nextDay . ' 00:00:00');
			$completedBuilder->where('date_time >=', $filters['date'] . ' 00:00:00')
							->where('date_time <', $nextDay . ' 00:00:00');
			$cancelledBuilder->where('date_time >=', $filters['date'] . ' 00:00:00')
							->where('date_time <', $nextDay . ' 00:00:00');
		}

		$confirmed = $confirmedBuilder->where('status', 'Confirmed')->countAllResults(false);
		$pending = $pendingBuilder->where('status', 'Pending')->countAllResults(false);
		$completed = $completedBuilder->where('status', 'Completed')->countAllResults(false);
		$cancelled = $cancelledBuilder->where('status', 'Cancelled')->countAllResults(false);

		return [
			'total' => $total,
			'confirmed' => $confirmed,
			'pending' => $pending,
			'completed' => $completed,
			'cancelled' => $cancelled
		];
	}
}


