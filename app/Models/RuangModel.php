<?php

namespace App\Models;

use CodeIgniter\Model;

class RuangModel extends Model
{
    protected $table = 'ruang';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama', 'kapasitas', 'jenis', 'id_prodi', 'lantai', 'id_ruang'];

    public function getRuang($id = false)
    {
        if ($id === false) {
            return $this->select('ruang.*, jurusan.nama_jurusan AS nama_jurusan')
                        ->join('jurusan', 'jurusan.id = ruang.id_prodi', 'left')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->select('ruang.*, jurusan.nama_jurusan AS nama_jurusan')
                    ->join('jurusan', 'jurusan.id = ruang.id_prodi', 'left')
                    ->first();
    }
}
