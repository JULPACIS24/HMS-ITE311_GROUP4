<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
	protected $table            = 'appointments';
	protected $primaryKey       = 'id';
	protected $allowedFields    = [
		'appointment_code',
		'patient_name',
		'patient_phone',
		'doctor_name',
		'date_time',
		'type',
		'status',
		'notes',
		'created_at',
		'updated_at',
	];

	protected $useTimestamps = true;
}


