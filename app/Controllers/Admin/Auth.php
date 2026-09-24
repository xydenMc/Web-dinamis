<?php

namespace App\Controllers\Admin;

use App\Models\UserModel;
use CodeIgniter\Controller;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form']);
    }

    /**
     * Show admin login page
     */
    public function showLogin()
    {
        if (session()->get('logged_in') && session()->get('role') === 'admin') {
            return redirect()->to('/dashboard');
        }

        $data['title'] = 'Login Admin - Panel';
        return view('admin/auth/login', $data);
    }

    /**
     * Process admin login
     */
    public function login()
    {
        if ($this->request->getMethod() !== 'post') {
            return redirect()->to('/admin/login');
        }

        // CSRF validation handled by framework

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (!$email || !$password) {
            return redirect()->to('/admin/login')->with('errors', [
                'email' => 'Email wajib diisi',
                'password' => 'Password wajib diisi'
            ]);
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return redirect()->to('/admin/login')->with('errors', [
                'login' => 'Email atau password salah'
            ]);
        }

        if ($user['role'] !== 'admin') {
            return redirect()->to('/admin/login')->with('errors', [
                'role' => 'Akun Anda bukan admin'
            ]);
        }

        // Regenerate session for security
        session()->regenerate();

        // Store admin data in session
        session()->set('logged_in', true);
        session()->set('user_id', $user['id']);
        session()->set('nama', $user['nama']);
        session()->set('email', $user['email']);
        session()->set('role', $user['role']);
        session()->set('last_activity', time());

        return $this->redirectWithFlash('/dashboard', 'success', 'Berhasil login sebagai admin');
    }

    /**
     * Logout from admin panel
     */
    public function logout()
    {
        session()->destroy();
        return $this->redirectWithFlash('/katalog', 'success', 'Berhasil logout');
    }
}
