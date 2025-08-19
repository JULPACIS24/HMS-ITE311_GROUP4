<?php

namespace App\Models;

use CodeIgniter\Model;

class SecurityLogModel extends Model
{
	protected $table         = 'security_logs';
	protected $primaryKey    = 'id';
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = '';
	protected $allowedFields = ['user_id', 'role', 'event', 'details', 'ip_address', 'user_agent'];
}

?>

