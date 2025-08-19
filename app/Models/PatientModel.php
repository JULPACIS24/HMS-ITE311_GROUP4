<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
	protected $table = 'patients';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'first_name','last_name','dob','gender','phone','email','address','blood_type',
		'emergency_name','emergency_phone','medical_history','allergies','created_at','updated_at'
	];
	protected $useTimestamps = true;
}


