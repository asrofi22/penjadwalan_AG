<?php

namespace App\Models;

use CodeIgniter\Model;

class WaktutidakbersediaModel extends Model
{
    protected $table      = 'waktu_tidak_bersedia'; // Nama tabel utama
    protected $primaryKey = 'id'; // Kolom primary key

    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_dosen', 'id_hari', 'id_jam'];

    // Fungsi untuk mengambil semua data waktu tidak bersedia dengan detail
    public function getWaktutidakbersediaWithDetails()
    {
        return $this->select('waktu_tidak_bersedia.*, dosen.nama AS dosen, hari.hari, jam2.range_jam')
            ->join('dosen', 'waktu_tidak_bersedia.id_dosen = dosen.id', 'LEFT') // Gunakan 'LEFT' sebagai string
            ->join('hari', 'waktu_tidak_bersedia.id_hari = hari.id', 'LEFT')   // Gunakan 'LEFT' sebagai string
            ->join('jam2', 'waktu_tidak_bersedia.id_jam = jam2.id', 'LEFT')     // Gunakan 'LEFT' sebagai string
            ->findAll();
    }


    // Fungsi untuk mengambil data waktu tidak bersedia berdasarkan id
    public function getWaktutidakbersedia($id)
    {
        return $this->select('waktu_tidak_bersedia.*, dosen.nama AS nama_dosen, hari.hari, GROUP_CONCAT(jam.range_jam) AS range_jam')
            ->join('dosen', 'waktu_tidak_bersedia.id_dosen = dosen.id', 'left')
            ->join('hari', 'waktu_tidak_bersedia.id_hari = hari.id', 'left')
            ->join('jam', 'FIND_IN_SET(jam.id, waktu_tidak_bersedia.id_jam)', false)
            ->where('waktu_tidak_bersedia.id', $id)
            ->groupBy('waktu_tidak_bersedia.id')
            ->first();
    }

    // Fungsi untuk menghapus data waktu tidak bersedia
    public function deleteWaktutidakbersedia($id)
    {
        return $this->delete($id);
    }
}
