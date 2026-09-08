<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        $data['title'] = 'Dashboard - Griya Pot Bunga';

        // Check if user is admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/katalog');
        }

        return view('dashboard_view', $data);
    }
}
