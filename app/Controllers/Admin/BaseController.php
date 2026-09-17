<?php

namespace App\Controllers\Admin;

class BaseController extends \App\Controllers\BaseController
{
    protected $theme = 'Admin Layout';
    protected $themeViewPath = 'admin/views/';
    protected $db;

    public function initController(\CodeIgniter\Http\RequestInterface $request, \CodeIgniter\Http\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);

        // Dashboard uses this connection for aggregate statistics. Access
        // control is handled reliably before the controller by `role:admin`.
        $this->db = db_connect();
    }
}
