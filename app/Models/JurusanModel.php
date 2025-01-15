<?php

namespace App\Models;

use CodeIgniter\Model;

class JurusanModel extends Model
{
    protected $table = 'jurusan'; // Nama tabel
    protected $primaryKey = 'id'; // Primary key tabel
    protected $allowedFields = ['nama_jurusan']; // Field yang diizinkan untuk diisi

    /**
     * Cek apakah nama jurusan sudah ada di database.
     *
     * @return array|false
     */
    public function cek_jurusan()
    {
        $nama = $this->request->getPost('nama'); // Ambil data dari input POST

        $query = $this->db->query("SELECT nama_jurusan FROM jurusan WHERE nama_jurusan = '$nama'");
        if ($query->getNumRows() > 0) {
            return $query->getResultArray();
        } else {
            return false;
        }
    }

    /**
     * Ambil detail jurusan berdasarkan ID.
     *
     * @param int $id
     * @return array
     */
    public function detail_jurusan($id)
    {
        $query = $this->db->query("SELECT * FROM jurusan WHERE id = '$id'");
        return $query->getResultArray();
    }

    /**
     * Ambil data jurusan berdasarkan ID.
     *
     * @param int $id
     * @return array
     */
    public function per_jurusan($id)
    {
        $query = $this->db->query("SELECT * FROM jurusan WHERE id = '$id'");
        return $query->getResultArray();
    }

    /**
     * Edit data jurusan berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function edit_jurusan($id)
    {
        $nama = $this->request->getPost('nama'); // Ambil data dari input POST

        $data = [
            'nama_jurusan' => $nama,
        ];

        $this->db->table('jurusan')->where('id', $id)->update($data);
        return $this->db->affectedRows() > 0;
    }

    /**
     * Hapus data jurusan berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function hapus_jurusan($id)
    {
        $this->db->table('jurusan')->where('id', $id)->delete();
        return $this->db->affectedRows() > 0;
    }

    /**
     * Ambil semua data jurusan.
     *
     * @return array
     */
    public function semua_jurusan()
    {
        $query = $this->db->query("SELECT * FROM jurusan ORDER BY id ASC");
        return $query->getResultArray();
    }

    /**
     * Simpan data jurusan baru.
     *
     * @param string $nama
     * @return bool
     */
    public function simpan_jurusan($nama)
    {
        $data = [
            'nama_jurusan' => $nama,
        ];

        $this->db->table('jurusan')->insert($data);
        return $this->db->affectedRows() > 0;
    }
}