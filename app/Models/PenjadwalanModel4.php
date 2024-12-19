<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjadwalanModel4 extends Model
{
    protected $table = 'penjadwalan3';
    protected $primaryKey = 'id';
    protected $allowedFields = ['jumlah_populasi', 'jumlah_generasi', 'crossover', 'mutasi', 'jadwal'];

    public function getJadwalLengkap()
    {
        $this->join('matakuliah', 'penjadwalan3.kode_mk = matakuliah.kode_mk');
        $this->join('dosen', 'penjadwalan3.kode_dosen = dosen.kode_dosen');
        $this->join('ruang', 'penjadwalan3.kode_ruang = ruang.kode_ruang');
        $this->join('hari', 'penjadwalan3.kode_hari = hari.kode_hari');
        $this->select('matakuliah.nama_mk, dosen.nama_dosen, ruang.nama_ruang, hari.nama_hari, penjadwalan3.range_jam');
        return $this->findAll();
    }
}