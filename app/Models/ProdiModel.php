<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table = 'prodi';  // Tabel yang digunakan
    protected $primaryKey = 'id'; // Kunci utama tabel ini

    protected $allowedFields = ['id_prodi', 'nama_prodi']; // Kolom yang diizinkan untuk diisi

    public function per_prodi($id)
    {
        return $this->where('id', $id)->first(); // Mengambil satu prodi berdasarkan ID
    }

    public function semua_prodi()
    {
        return $this->findAll(); // Mengambil semua prodi
    }

    public function semua_prodi2()
    {
        return $this->where('nama_prodi !=', 'MIPA')->findAll(); // Mengambil semua prodi yang bukan MIPA
    }
}