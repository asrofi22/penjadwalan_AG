<?php

namespace App\Models;

use CodeIgniter\Model;

class PengampuModel extends Model
{
    protected $table      = 'pengampu'; // Nama tabel utama
    protected $primaryKey = 'id'; // Kolom primary key

    protected $useAutoIncrement = true;
    protected $allowedFields = ['id_mk', 'id_dosen', 'id_kelas', 'id_tahun_akademik', 'id_prodi', 'id_semester', 'kuota', 'id_ruang'];

    // Fungsi untuk mengambil semua data pengampu dengan join ke tabel lain
    public function getPengampuWithDetails()
    {
        return $this->select('pengampu.*, matakuliah.nama AS matakuliah, dosen.nama AS dosen, kelas.nama_kelas AS kelas, tahun_akademik.tahun, prodi.prodi, semester.nama_semester, ruang.nama')
            ->join('matakuliah', 'pengampu.id_mk = matakuliah.id', 'left')
            ->join('dosen', 'pengampu.id_dosen = dosen.id', 'left')
            ->join('kelas', 'pengampu.id_kelas = kelas.id', 'left')
            ->join('tahun_akademik', 'pengampu.id_tahun_akademik = tahun_akademik.id', 'left')
            ->join('prodi', 'pengampu.id_prodi = prodi.id', 'left')
            ->join('semester', 'pengampu.id_semester = semester.id', 'left')
            ->join('ruang', 'pengampu.id_ruang = ruang.id', 'left')
            ->findAll();
    }

    // Fungsi untuk mengambil data pengampu berdasarkan id
    public function getPengampu($id)
    {
        return $this->select('pengampu.*, matakuliah.nama AS matakuliah, dosen.nama AS dosen, kelas.nama_kelas AS kelas, tahun_akademik.tahun, prodi.prodi, semester.nama_semester, ruang.nama')
            ->join('matakuliah', 'pengampu.id_mk = matakuliah.id', 'left')
            ->join('dosen', 'pengampu.id_dosen = dosen.id', 'left')
            ->join('kelas', 'pengampu.id_kelas = kelas.id', 'left')
            ->join('tahun_akademik', 'pengampu.id_tahun_akademik = tahun_akademik.id', 'left')
            ->join('prodi', 'pengampu.id_prodi = prodi.id', 'left')
            ->join('semester', 'pengampu.id_semester = semester.id', 'left')
            ->join('ruang', 'pengampu.id_ruang = ruang.id', 'left')
            ->where('pengampu.id', $id)
            ->first();
    }

    // Fungsi untuk menyimpan data pengampu
    public function savePengampu($data)
    {
        return $this->save($data);
    }

    // Fungsi untuk menghapus data pengampu
    public function deletePengampu($id)
    {
        return $this->delete($id);
    }
}
