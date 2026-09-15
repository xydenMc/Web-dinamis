<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CheckSession implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // TEMPORARY AUDIT MODE: Bypass authentication if enabled
        // Set environment variable AUDIT_MODE=true to enable
        if (env('AUDIT_MODE') === 'true') {
            // In audit mode, set temporary session data if not already logged in
            if (!session()->get('logged_in')) {
                // Set temporary audit session - gunakan akun admin yang sudah ada
                session()->set([
                    'id'         => 1,  // ID user admin (pastikan ada di database)
                    'username'   => 'audit_admin',
                    'email'      => 'audit@demo.com',
                    'role'       => 'admin',
                    'logged_in'  => true,
                ]);
            }
            // Lanjutkan ke filter role check jika diperlukan
            if ($arguments && is_array($arguments)) {
                $userRole = session()->get('role');
                if (!in_array($userRole, $arguments)) {
                    // Log untuk debugging audit mode
                    return redirect()->to('/katalog')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
                }
            }
            return null; // Allow request to proceed
        }

        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Jika ada role argument, cek role user
        if ($arguments && is_array($arguments)) {
            $userRole = session()->get('role');
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/katalog')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after
    }
}

