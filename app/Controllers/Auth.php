<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    /**
     * Show login page
     */
    public function index()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/katalog');
        }

        $data['title'] = 'Masuk - Griya Pot Bunga';
        return view('auth/login_view', $data);
    }

    /**
     * Process login
     */
    public function process()
    {
        // The current storefront login form uses one `identity` field.
        // This application authenticates users by email, so retain support
        // for the old `email` field as a fallback.
        $email = $this->request->getPost('identity') ?? $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return redirect()->to('/login')->with('errors', [
                'identity' => 'Username atau email wajib diisi',
                'password' => 'Password wajib diisi'
            ])->withInput();
        }

        $user = $this->userModel->findByIdentity($email);
        $passwordHash = $user['password_hash'] ?? $user['password'] ?? '';

        if (!$user || !password_verify($password, $passwordHash)) {
            return redirect()->to('/login')->with('errors', [
                'login' => 'Email atau password salah'
            ]);
        }

        // Regenerate session for security
        session()->regenerate();

        // Store user data in session
        session()->set('logged_in', true);
        session()->set('user_id', $user['id']);
        session()->set('id', $user['id']);
        $displayName = $user['nama'] ?? $user['username'] ?? $user['email'];
        session()->set('nama', $displayName);
        session()->set('username', $displayName);
        session()->set('email', $user['email']);
        session()->set('role', $user['role']);
        session()->set('last_activity', time());

        // Check for redirect after login (from guest actions)
        $redirectUrl = session()->get('login_redirect') ?? '/katalog';
        session()->remove('login_redirect');

        return redirect()->to($redirectUrl)->with('success', [
            'login' => 'Berhasil login sebagai ' . $user['role']
        ]);
    }

    /**
     * Show registration page
     */
    public function register()
    {
        if (session()->get('logged_in')) {
            return redirect()->to('/katalog');
        }

        $data['title'] = 'Daftar Akun Baru - Griya Pot Bunga';
        return view('auth/register_view', $data);
    }

    /**
     * Process registration
     */
    public function registerProcess()
    {
        $validation = $this->validate([
            'username' => [
                'rules' => 'required|min_length[3]|max_length[255]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama minimal 3 karakter.',
                    'max_length' => 'Nama maksimal 255 karakter.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi.',
                    'valid_email' => 'Format email tidak valid.',
                    'is_unique' => 'Email sudah terdaftar.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]|confirm_password[password]',
                'errors' => [
                    'required' => 'Password wajib diisi.',
                    'min_length' => 'Password minimal 8 karakter.',
                    'confirm_password' => 'Password tidak cocok.'
                ]
            ],
            'telepon' => [
                'rules' => 'permit_empty|min_length[10]|max_length[20]',
                'errors' => [
                    'min_length' => 'Nomor telepon minimal 10 digit.',
                    'max_length' => 'Nomor telepon maksimal 20 digit.'
                ]
            ]
        ]);

        if (!$validation) {
            return redirect()->to('/register')->with('errors', $this->validator->getErrors());
        }

        $userId = $this->userModel->createStorefrontUser(
            $this->request->getPost('username') ?? $this->request->getPost('nama'),
            $this->request->getPost('email'),
            $this->request->getPost('password')
        );

        if ($userId) {
            return redirect()->to('/login')->with('success', [
                'register' => 'Akun berhasil dibuat! Silakan login.'
            ]);
        }

        return redirect()->to('/register')->with('errors', [
            'register' => 'Gagal mendaftar. Silakan coba lagi.'
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', [
            'logout' => 'Berhasil logout.'
        ]);
    }

    /**
     * Show login modal for guest users
     */
    public function showLoginModal()
    {
        return view('partials/login_modal');
    }
}
