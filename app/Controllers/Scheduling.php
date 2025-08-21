<?php

namespace App\Controllers;

class Scheduling extends BaseController
{
    public function doctor()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/scheduling_doctor');
    }

    public function nurse()
    {
        if (! session('isLoggedIn')) return redirect()->to('/login');
        return view('auth/scheduling_nurse');
    }
}
