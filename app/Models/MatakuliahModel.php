<?php

namespace App\Models;

use CodeIgniter\Model;

class MatakuliahModel extends Model
{
    protected $table = 'matakuliah';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nama',
        'jumlah_jam',
        'semester',
        'aktif',
        'jenis',
        'nama_kode',
        'id_prodi',
        'id_matkul'
    ];

    public function getAllData()
    {
        return $this->select('matakuliah.*, semester.nama_semester, prodi.prodi')
            ->join('semester', 'matakuliah.semester = semester.id', 'left')
            ->join('prodi', 'matakuliah.id_prodi = prodi.id', 'left')
            ->findAll();
    }
}
