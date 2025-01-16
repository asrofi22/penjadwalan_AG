<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdiModel extends Model
{
    protected $table = 'prodi';  // Tabel yang digunakan
    protected $primaryKey = 'id'; // Kunci utama tabel ini

    protected $allowedFields = ['id_prodi', 'nama_prodi', 'id_jurusan']; // Kolom yang diizinkan untuk diisi

    public function per_prodi($id_prodi)
    {
        // Pastikan query mengembalikan array atau objek
        return $this->db->table('prodi')
                        ->where('id', $id_prodi)
                        ->get()
                        ->getResult(); // Mengembalikan array of objects
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
