<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\Database\ResultInterface;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'nama',
        'email',
        'password_hash',
        'telepon',
        'role',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'nama' => 'required|min_length[3]|max_length[255]',
        'email' => 'required|valid_email|is_unique[users.email]',
        'password_hash' => 'required|min_length[8]',
        'role' => 'in_list[customer,admin]'
    ];

    protected $validationMessages = [
        'nama' => [
            'required' => 'Nama lengkap wajib diisi.',
            'min_length' => 'Nama minimal 3 karakter.',
            'max_length' => 'Nama maksimal 255 karakter.'
        ],
        'email' => [
            'required' => 'Email wajib diisi.',
            'valid_email' => 'Format email tidak valid.',
            'is_unique' => 'Email sudah terdaftar.'
        ],
        'password_hash' => [
            'required' => 'Password wajib diisi.',
            'min_length' => 'Password minimal 8 karakter.'
        ]
    ];

    /**
     * Find user by email
     */
    public function findByEmail(string $email): array|null
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Find an account from either version of the users table used in this
     * project. The redesigned UI accepts an email or username.
     */
    public function findByIdentity(string $identity): array|null
    {
        $fields = $this->db->getFieldNames($this->table);
        $nameField = in_array('username', $fields, true) ? 'username' : 'nama';

        return $this->groupStart()
            ->where('email', $identity)
            ->orWhere($nameField, $identity)
            ->groupEnd()
            ->first();
    }

    /**
     * Create an account using the column names present in the active database.
     */
    public function createStorefrontUser(string $username, string $email, string $password): int|bool
    {
        $fields = $this->db->getFieldNames($this->table);
        $data = [
            'email' => $email,
            'role' => 'customer',
            'created_at' => date('Y-m-d H:i:s'),
        ];

        if (in_array('username', $fields, true)) {
            $data['username'] = $username;
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $data['nama'] = $username;
            $data['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
            if (in_array('telepon', $fields, true)) {
                $data['telepon'] = '';
            }
        }

        if (in_array('updated_at', $fields, true)) {
            $data['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db->table($this->table)->insert($data);

        return $this->db->insertID() ?: false;
    }

    /**
     * Create user with hashed password
     */
    public function createUser(array $data): int|bool
    {
        $data['password_hash'] = password_hash($data['password_hash'], PASSWORD_DEFAULT);
        return $this->insert($data);
    }

    /**
     * Verify user password
     */
    public function verifyPassword(int $userId, string $password): bool
    {
        $user = $this->find($userId);
        if (!$user) {
            return false;
        }
        return password_verify($password, $user['password_hash']);
    }

    /**
     * Get all customers
     */
    public function getCustomers(): array
    {
        return $this->where('role', 'customer')->findAll();
    }

    /**
     * Get all admins
     */
    public function getAdmins(): array
    {
        return $this->where('role', 'admin')->findAll();
    }
}
