<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'password', 'role'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'username' => [
            'rules'  => 'required|min_length[3]|max_length[50]|is_unique[users.username]',
            'errors' => [
                'required'   => 'Username wajib diisi.',
                'min_length' => 'Username minimal 3 karakter.',
                'max_length' => 'Username maksimal 50 karakter.',
                'is_unique'  => 'Username sudah digunakan.'
            ]
        ],
        'email' => [
            'rules'  => 'required|valid_email|is_unique[users.email]',
            'errors' => [
                'required'    => 'Email wajib diisi.',
                'valid_email' => 'Email tidak valid.',
                'is_unique'   => 'Email sudah digunakan.'
            ]
        ],
        'password' => [
            'rules'  => 'required|min_length[6]',
            'errors' => [
                'required'   => 'Password wajib diisi.',
                'min_length' => 'Password minimal 6 karakter.'
            ]
        ]
    ];

    public function getUserByUsernameOrEmail($identifier)
    {
        return $this->where('username', $identifier)
                    ->orWhere('email', $identifier)
                    ->first();
    }

    public function getAllUsers()
    {
        return $this->findAll();
    }

    public function getUserById($id)
    {
        return $this->find($id);
    }

    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    public function deleteUser($id)
    {
        return $this->delete($id);
    }
}
