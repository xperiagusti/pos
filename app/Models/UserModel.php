<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "user";
    protected $primaryKey = "id_user";
    protected $allowedFields = ['username', 'email', 'password', 'nama_lengkap', 'alamat_lengkap', 'kontak', 'role', 'token', 'is_verified', 'created_at', 'updated_at'];

    public function getUserById($id_user)
    {
        return $this->where('id_user', $id_user)->first();
    }

    public function getRoleByUsername($username)
    {
        $user = $this->where('username', $username)->first();

        if ($user) {
            return $user['role'];
        } else {
            return null; // Username tidak ditemukan
        }
    }

    public function getRoleById($id_user)
    {
        $user = $this->where('id_user', $id_user)->first();

        if ($user) {
            return $user['role'];
        } else {
            return null; // ID pengguna tidak ditemukan
        }
    }
    
}
