<?php

namespace App\Models;

use CodeIgniter\Model;

class JadwalModel extends Model
{
    protected $table = 'jadwalkuliah'; // Tabel jadwal kuliah
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_pengampu', 'id_jam', 'id_hari', 'id_ruang'];

    // Fungsi untuk menyimpan jadwal
    public function saveJadwal($data)
    {
        return $this->insert($data);
    }

    // Fungsi untuk mendapatkan jadwal
    public function getJadwal()
    {
        return $this->findAll();
    }
}