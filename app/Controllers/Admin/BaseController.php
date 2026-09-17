<?php

namespace App\Controllers\Admin;

use CodeIgniter\Controller;

class BaseController extends Controller
{
    protected $theme = 'Admin Layout';
    protected $themeViewPath = 'admin/views/';

    public function initController(\CodeIgniter\Http\RequestInterface $request, \CodeIgniter\Http\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Check if user is logged in as admin
        if (!session()->get('logged_in')) {
            return redirect()->to('/admin/login');
        }

        if (session()->get('role') !== 'admin') {
            session()->destroy();
            return redirect()->to('/admin/login')->with('errors', [
                'access' => 'Anda tidak memiliki akses ke area admin'
            ]);
        }
    }
}