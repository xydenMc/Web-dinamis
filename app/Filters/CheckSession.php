<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class CheckSession implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
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
