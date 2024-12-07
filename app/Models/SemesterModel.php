<?php

namespace App\Models;

use CodeIgniter\Model;

class SemesterModel extends Model
{
    // Konfigurasi untuk tabel `semester`
    protected $table = 'semester';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_semester', 'tipe_semester', 'id_semester'];

    /**
     * Mendapatkan semua data semester beserta tipe_semester-nya
     * menggunakan join dengan tabel `tipe_semester`.
     */
    public function getSemesterWithTipe()
    {
        return $this->select('semester.*, tipe_semester.tipe_semester as nama_tipe')
            ->join('tipe_semester', 'semester.tipe_semester = tipe_semester.id')
            ->findAll();
    }

    /**
     * Mendapatkan semua data dari tabel `tipe_semester`
     */
    public function getAllTipeSemester()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('tipe_semester');
        return $builder->get()->getResultArray();
    }
}

