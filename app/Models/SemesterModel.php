<?php

namespace App\Models;

use CodeIgniter\Model;

class SemesterModel extends Model
{
    // Konfigurasi untuk tabel `semester`
    protected $table = 'semester';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_semester', 'semester_tipe', 'id_semester'];

    /**
     * Mendapatkan semua data semester beserta tipe_semester-nya
     * menggunakan join dengan tabel `tipe_semester`.
     */
    public function getSemesterWithTipe()
    {
        return $this->select('semester.*, semester_tipe.tipe_semester as nama_tipe')
            ->join('semester_tipe', 'semester.semester_tipe = semester_tipe.id')
            ->findAll();
    }

    /**
     * Mendapatkan semua data dari tabel `tipe_semester`
     */
    public function getAllTipeSemester()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('semester_tipe');
        return $builder->get()->getResultArray();
    }
}

