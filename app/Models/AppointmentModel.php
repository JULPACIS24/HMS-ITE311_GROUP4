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
		'created_at',
		'updated_at',
	];

	protected $useTimestamps = true;
}


