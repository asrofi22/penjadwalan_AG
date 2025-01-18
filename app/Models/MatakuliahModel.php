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
        'nama_id',
        'id_prodi',
        'ket_mk'
    ];

    public function getAllData()
    {
        return $this->select('matakuliah.*, semester.nama_semester, prodi.nama_prodi')
            ->join('semester', 'matakuliah.semester = semester.id', 'left')
            ->join('prodi', 'matakuliah.id_prodi = prodi.id', 'left')
            ->findAll();
    }

    public function jumlahJam($id)
    {
        // Menggunakan Query Builder
        return $this->db->table('matakuliah')
                        ->where('id', $id)
                        ->get()
                        ->getResult();
    }
}
