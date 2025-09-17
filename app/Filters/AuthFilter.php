<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will stop and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if user is logged in using session
        if (!session()->has('isLoggedIn') || !session()->get('isLoggedIn')) {
            // Clear any existing session data
            session()->destroy();
            // Redirect to login page if not authenticated
            return redirect()->to('/login')->with('error', 'Please log in to access this page.');
        }

        // Check for valid session token
        $sessionToken = session()->get('session_token');
        $userId = session()->get('user_id');
        
        if (!$sessionToken || !$userId) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Invalid session. Please log in again.');
        }
        
        // Validate that session token belongs to current user
        if (!str_ends_with($sessionToken, '_' . $userId)) {
            session()->destroy();
            return redirect()->to('/login')->with('error', 'Session mismatch. Please log in again.');
        }

        // No automatic logout - sessions are preserved for each user
        // Users can refresh, navigate freely, sessions stay isolated
        // Only manual logout or browser close will end session
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}