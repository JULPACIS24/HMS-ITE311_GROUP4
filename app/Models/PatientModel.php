<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientModel extends Model
{
	protected $table = 'patients';
	protected $primaryKey = 'id';
	protected $allowedFields = [
		'first_name', 'middle_name', 'last_name', 'dob', 'age', 'gender', 'civil_status', 
		'nationality', 'religion', 'phone', 'email', 'address', 'city', 'province', 'zip_code',
		'blood_type', 'emergency_name', 'emergency_relationship', 'emergency_phone', 
		'medical_history', 'allergies', 'current_medications', 'philhealth_number',
		'philhealth_category', 'insurance_provider', 'insurance_policy_number', 
		'policy_holder_name', 'created_at', 'updated_at'
	];
	protected $useTimestamps = true;
}


