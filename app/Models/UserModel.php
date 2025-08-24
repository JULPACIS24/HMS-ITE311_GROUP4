<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
	protected $table         = 'users';
	protected $primaryKey    = 'id';
	protected $returnType    = 'array';
	protected $useTimestamps = true;

	protected $allowedFields = ['name', 'email', 'password_hash', 'role', 'department', 'status', 'specialty'];

	public function findByEmail(string $email): ?array
	{
		return $this->where('email', $email)->first();
	}
}


