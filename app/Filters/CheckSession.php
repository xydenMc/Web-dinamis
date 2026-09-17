<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CheckSession implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $allowedRoles = $arguments ? (is_array($arguments) ? $arguments : [$arguments]) : [];
        $loginRoute = in_array('admin', $allowedRoles, true) ? '/admin/login' : '/login';

        // Cek apakah user sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to($loginRoute)->with('error', 'Anda harus login terlebih dahulu.');
        }

        // Jika ada role argument, cek role user
        if ($allowedRoles !== []) {
            $userRole = session()->get('role');
            if (!in_array($userRole, $allowedRoles)) {
                return redirect()->to('/katalog')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed after
    }
}
