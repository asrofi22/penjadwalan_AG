<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Myth\Auth\Password; // Untuk hash password

class GantiPassword extends BaseController
{
    public function changePassword()
    {
        // Instance UserModel
        $userModel = new \Myth\Auth\Models\UserModel();

        // ID user yang akan diubah
        $userId = 1;

        // Cari user berdasarkan ID
        $user = $userModel->find($userId);

        if (!$user) {
            print_r('User tidak ditemukan.');exit;
        }

        // Update password dengan hashing
        $newPassword = 'asrofi'; // Password baru
        $userModel->update($userId, [
            'password_hash' => Password::hash($newPassword), // Gunakan hash password
        ]);

        print_r('Password berhasil diubah. Silakan login dengan password baru.');exit;
    }
}
