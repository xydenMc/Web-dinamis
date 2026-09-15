<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard - Griya Pot Bunga';

        // TEMPORARY AUDIT MODE: Allow access for audit purposes
        if (env('AUDIT_MODE') === 'true') {
            // Set admin role if not already set
            if (!session()->get('role')) {
                session()->set('role', 'admin');
            }
            return view('dashboard_view', $data);
        }

        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/katalog');
        }

        return view('dashboard_view', $data);
    }
}
