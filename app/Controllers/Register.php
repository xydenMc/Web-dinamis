<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Register extends Controller
{
    protected $userModel;
    protected $helpers = ['form'];
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data['title'] = 'Register - Griya Pot Bunga';

        // Jika user sudah login, redirect ke halaman toko
        if (session()->get('logged_in')) {
            return redirect()->to('/katalog');
        }

        return view('auth/register_view', $data);
    }

    public function process()
    {
        $rules = [
            'username' => [
                'rules'  => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
                'errors' => [
                    'required'     => 'Username wajib diisi.',
                    'min_length'   => 'Username minimal 3 karakter.',
                    'max_length'   => 'Username maksimal 50 karakter.',
                    'is_unique'    => 'Username sudah digunakan.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required'     => 'Email wajib diisi.',
                    'valid_email'  => 'Email tidak valid.',
                    'is_unique'    => 'Email sudah digunakan.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required'     => 'Password wajib diisi.',
                    'min_length'   => 'Password minimal 6 karakter.'
                ]
            ],
            'confirm_password' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required'     => 'Konfirmasi password wajib diisi.',
                    'matches'      => 'Password tidak cocok.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return redirect()->to('/register')->with('errors', $this->validator->getErrors());
        }

        $data = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'customer' // Default role untuk registrasi
        ];

        $this->userModel->save($data);

        return redirect()->to('/login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
}
