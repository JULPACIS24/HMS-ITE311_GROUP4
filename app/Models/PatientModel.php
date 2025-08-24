<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
	protected $table = 'patients';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'first_name','last_name','dob','age','gender','phone','email','address','blood_type',
		'emergency_name','emergency_phone','medical_history','allergies','philhealth_number',
		'philhealth_category','insurance_provider','insurance_policy_number','created_at','updated_at'
	];
	protected $useTimestamps = true;
}


