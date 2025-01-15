<?php

namespace App\Models;

use CodeIgniter\Model;

class GuruModel extends Model
{
    // Konfigurasi untuk tabel guru
    protected $table = 'guru';
    protected $primaryKey = 'kode';
    protected $allowedFields = ['nip', 'nama', 'alamat', 'telp', 'password', 'status_guru', 'kode_guru'];

    // Tambahkan metode untuk mendapatkan data status guru
    public function getStatusDosen()
    {
        // Mengakses tabel `status_dosen` secara manual menggunakan query builder
        $db = \Config\Database::connect();
        return $db->table('status_dosen')->get()->getResultArray();
    }
}
