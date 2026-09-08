<?php
/**
 * Script untuk generate password hash untuk CodeIgniter 4
 * Jalankan: php spark password-hash "password"
 * Atau gunakan password_hash() PHP native
 */

// Hash untuk admin123
$password1 = 'admin123';
$hash1 = password_hash($password1, PASSWORD_DEFAULT);
echo "Password: $password1\n";
echo "Hash: $hash1\n\n";

// Hash untuk customer123
$password2 = 'customer123';
$hash2 = password_hash($password2, PASSWORD_DEFAULT);
echo "Password: $password2\n";
echo "Hash: $hash2\n";