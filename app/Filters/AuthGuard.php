<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthGuard implements FilterInterface
{
	public function before(RequestInterface $request, $arguments = null)
	{
		$isLoggedIn = session('isLoggedIn');
		$userRole = session('role');
		
		// Debug: Log session data
		log_message('info', 'AuthGuard - isLoggedIn: ' . ($isLoggedIn ? 'true' : 'false') . ', role: ' . $userRole);
		
		if (! $isLoggedIn) {
			return redirect()->to('/login')->with('errors', ['Please log in first.']);
		}
	}

	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		// no-op
	}
}


