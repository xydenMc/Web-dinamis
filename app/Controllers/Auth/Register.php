<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Register extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        return view('auth/register');
    }

    public function process()
    {
        if (!$this->validate([
            'username' => [
                'rules'  => 'required|min_length[3]|max_length[100]|is_unique[users.username]',
                'errors' => [
                    'required' => 'Username wajib diisi.',
                    'min_length' => 'Username minimal 3 karakter.',
                    'max_length' => 'Username maksimal 100 karakter.',
                    'is_unique' => 'Username sudah terdaftar.'
                ]
            ],
            'email' => [
                'rules'  => 'required|valid_email|max_length[255]|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Email tidak valid.',
                    'max_length' => 'Email maksimal 255 karakter.',
                    'is_unique' => 'Email sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules'  => 'required|min_length[6]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 6 karakter.'
                ]
            ],
            'confirm_password' => [
                'rules'  => 'required|matches[password]',
                'errors' => [
                    'required' => 'Konfirmasi password wajib diisi.',
                    'matches' => 'Konfirmasi password tidak cocok.'
                ]
            ]
        ])) {
            return redirect()->to('/register')->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'username' => $this->request->getPost('username'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'     => 'customer'
        ];

        $this->userModel->save($userData);

        return redirect()->to('/login')->with('success', 'Pendaftaran berhasil. Silakan login.');
    }
}
