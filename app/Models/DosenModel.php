<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    // Konfigurasi untuk tabel dosen
    protected $table = 'dosen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nip', 'nama', 'alamat', 'telp', 'password', 'status_dosen', 'id_dosen'];

    // Tambahkan metode untuk mendapatkan data status dosen
    public function getStatusDosen()
    {
        // Mengakses tabel `status_dosen` secara manual menggunakan query builder
        $db = \Config\Database::connect();
        return $db->table('status_dosen')->get()->getResultArray();
    }
}
