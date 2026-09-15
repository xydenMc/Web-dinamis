<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Login extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        helper('form');

        $data['title'] = 'Login - Griya Pot Bunga';

        // Jika user sudah login, redirect ke katalog
        if (session()->get('logged_in')) {
            return redirect()->to('/katalog');
        }

        return view('auth/login_view', $data);
    }

    public function process()
    {
        $rules = [
            'identity' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Username atau email wajib diisi.'
                ]
            ],
            'password' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Password wajib diisi.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/login')->withInput()->with('errors', $this->validator->getErrors());
        }

        $login = $this->request->getPost('identity');
        $password = $this->request->getPost('password');

        $user = $this->userModel->getUserByUsernameOrEmail($login);

        if ($user && password_verify($password, $user['password'])) {
            $sessionData = [
                'id'         => $user['id'],
                'username'   => $user['username'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'logged_in'  => true
            ];

            session()->set($sessionData);

            // Clear any flashdata that might trigger unwanted modals
            session()->setFlashdata('open_delete_modal', null);
            session()->setFlashdata('delete_product_id', null);

            // Redirect ke halaman toko untuk semua role
            return redirect()->to('/katalog')->with('success', 'Selamat datang, ' . $user['username'] . '!');
        }

        return redirect()->to('/login')->with('error', 'Username/email atau password salah.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
