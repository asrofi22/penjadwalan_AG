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
            return $this->select('ruang.*, prodi.prodi AS nama_prodi')
                        ->join('prodi', 'prodi.id = ruang.id_prodi', 'left')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->select('ruang.*, prodi.prodi AS nama_prodi')
                    ->join('prodi', 'prodi.id = ruang.id_prodi', 'left')
                    ->first();
    }
}
