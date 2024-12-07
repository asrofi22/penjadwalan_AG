<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_kelas', 'id_prodi', 'id_kelas'];

    public function getKelas($id = false)
    {
        if ($id === false) {
            return $this->select('kelas.*, prodi.prodi AS nama_prodi')
                        ->join('prodi', 'prodi.id = kelas.id_prodi', 'left')
                        ->findAll();
        }
        return $this->where(['id' => $id])
                    ->select('kelas.*, prodi.prodi AS nama_prodi')
                    ->join('prodi', 'prodi.id = kelas.id_prodi', 'left')
                    ->first();
    }
}
