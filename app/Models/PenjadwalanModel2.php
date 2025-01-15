<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjadwalanModel2 extends Model
{
    protected $table = 'jadwalkuliah'; // Nama tabel jadwal kuliah
    protected $primaryKey = 'kode'; // primary tabel
    protected $allowedFields = ['kode_pengampu', 'kode_hari', 'kode_jam', 'kode_ruang']; // Fields yang dapat diisi

    // Mengambil semua jadwal
    public function get() {
        return $this->db->query("
            SELECT  e.nama as hari, 
                    IF(c.jumlah_jam='4','2',IF(c.jumlah_jam='1','1',IF(c.jumlah_jam='2','2',IF(c.jumlah_jam='3','3','')))) as sks,
                    CONCAT_WS('-', CONCAT('(', g.kode), CONCAT((SELECT kode FROM jam WHERE kode = (SELECT jm.kode FROM jam jm WHERE Mkode(jm.range_jam, 1, 5) = Mkode(g.range_jam, 1, 5)) + (sks - 1)), ')')) as sesi,
                    CONCAT_WS('-', Mkode(g.range_jam, 1, 5), (SELECT Mkode(range_jam, 7, 5) FROM jam WHERE kode = (SELECT jm.kode FROM jam jm WHERE Mkode(jm.range_jam, 1, 5) = Mkode(g.range_jam, 1, 5)) + (sks - 1))) as jam_kuliah,
                    a.kode_pengampu,
                    a.kode_hari,
                    a.kode_jam,
                    a.kode_ruang,
                    b.kuota,
                    b.kode,
                    b.tahun_akademik,
                    b.kode_prodi,
                    c.jumlah_jam as jumlah_jam,
                    c.nama as nama_mk,
                    c.semester as semester,
                    d.nama as guru,
                    f.nama as ruang,
                    f.kapasitas,
                    h.kode as kode_kelas,
                    h.nama_kelas as nama_kelas,
                    i.kode,
                    i.nama_prodi as nama_prodi,
                    j.kode as kode_tipe_semester,
                    j.tipe_semester as tipe_semester,
                    k.kode as kode_tahun,
                    k.tahun as nama_tahun,
                    l.kode as kode_semester,
                    l.nama_semester as nama_semester,
                    l.tipe_semester as tipe_semester,
                    m.prodi as nama_prodi,
                    m.kode as kode_prodi
            FROM jadwalkuliah a
            LEFT JOIN pengampu b ON a.kode_pengampu = b.kode
            LEFT JOIN matakuliah c ON b.kode_mk = c.kode
            LEFT JOIN guru d ON b.kode_guru = d.kode
            LEFT JOIN hari e ON a.kode_hari = e.kode
            LEFT JOIN ruang f ON a.kode_ruang = f.kode
            LEFT JOIN jam g ON a.kode_jam = g.kode
            LEFT JOIN kelas h ON b.kelas = h.kode
            LEFT JOIN prodi i ON b.kode_prodi = i.kode
            LEFT JOIN tipe_semester j ON c.semester = j.kode
            LEFT JOIN tahun_akademik k ON b.tahun_akademik = k.kode
            LEFT JOIN semester l ON b.semester = l.kode
            LEFT JOIN prodi m ON i.kode_prodi = m.kode
            ORDER BY e.kode ASC, jam_kuliah ASC
        ");
    }

    // Mengambil jadwal berdasarkan guru
    public function getPerguru($kode_guru = null) {
        return $this->db->query("
            SELECT  e.nama as hari,
                    CONCAT_WS('-', CONCAT('(', g.kode), CONCAT((SELECT kode FROM jam WHERE kode = (SELECT jm.kode FROM jam jm WHERE Mkode(jm.range_jam, 1, 5) = Mkode(g.range_jam, 1, 5)) + (c.jumlah_jam - 1)), ')')) as sesi,
                    CONCAT_WS('-', Mkode(g.range_jam, 1, 5), (SELECT Mkode(range_jam, 7, 5) FROM jam WHERE kode = (SELECT jm.kode FROM jam jm WHERE Mkode(jm.range_jam, 1, 5) = Mkode(g.range_jam, 1, 5))
                    + (c.jumlah_jam - 1))) as jam_kuliah,
                    c.nama as nama_mk,
                    c.jumlah_jam as jumlah_jam,
                    c.semester as semester,
                    b.kelas as kelas,
                    d.nama as guru,
                    f.nama as ruang 
            FROM jadwalpelajaran a
            LEFT JOIN pengampu b ON a.kode_pengampu = b.kode 
            LEFT JOIN matakuliah c ON b.kode_mk = c.kode 
            LEFT JOIN guru d ON b.kode_guru = d.kode 
            LEFT JOIN hari e ON a.kode_hari = e.kode 
            LEFT JOIN ruang f ON a.kode_ruang = f.kode 
            LEFT JOIN jam g ON a.kode_jam = g.kode 
            WHERE b.kode_guru = {$kode_guru}
            ORDER BY e.kode ASC, jam_kuliah ASC
        ");
    }

    // Mengambil semua jadwal berdasarkan semester tipe dan tahun akademik
    public function semuaJadwal($tipe_semester, $tahun_akademik) {
        return $this->db->query("
            SELECT a.kode_pengampu 
            FROM riwayat_penjadwalan a 
            LEFT JOIN pengampu b ON a.kode_pengampu = b.kode 
            LEFT JOIN semester c ON b.semester = c.kode 
            WHERE c.tipe_semester = '$tipe_semester' AND b.tahun_akademik = '$tahun_akademik'
        ")->getResult();
    }

    // Memeriksa jadwal tertentu berdasarkan tipe semester, tahun akademik, dan kode prodi
    public function cekJadwal($tipe_semester, $tahun_akademik, $prodi) {
        return $this->db->query("
            SELECT a.kode, b.kode, c.kode 
            FROM riwayat_penjadwalan a 
            LEFT JOIN pengampu b ON a.kode_pengampu = b.kode 
            LEFT JOIN semester c ON b.semester = c.kode 
            WHERE c.tipe_semester = '$tipe_semester' AND b.tahun_akademik = '$tahun_akademik' AND b.kode_prodi = '$prodi'
        ")->getResult();
    }

    // Memeriksa semua jadwal
    public function cekSemuaJadwal($tipe_semester, $tahun_akademik) {
        return $this->db->query("
            SELECT a.kode as kode_riwayat, b.kode, c.kode 
            FROM riwayat_penjadwalan a 
            LEFT JOIN pengampu b ON a.kode_pengampu = b.kode 
            LEFT JOIN semester c ON b.semester = c.kode 
            WHERE c.tipe_semester = '$tipe_semester' AND b.tahun_akademik = '$tahun_akademik'
        ")->getResult();
    }

    // Menghapus riwayat jadwal berdasarkan kode
    public function hapusRiwayatJadwal($kode) {
        return $this->db->table('riwayat_penjadwalan')->where('kode', $kode)->delete();
    }

    // Memeriksa jumlah program studi
    public function cekBanyakProdi($tipe_semester, $tahun_akademik) {
        return $this->db->query("
            SELECT COUNT(DISTINCT b.kode_prodi) as banyak, a.kode, c.kode 
            FROM jadwalpelajaran a 
            LEFT JOIN pengampu b ON a.kode_pengampu = b.kode 
            LEFT JOIN semester c ON b.semester = c.kode 
            WHERE c.tipe_semester = '$tipe_semester' AND b.tahun_akademik = '$tahun_akademik'
        ")->getResult();
    }

    // Memeriksa jumlah pengampu
    public function cekBanyakPengampu($tipe_semester, $tahun_akademik, $prodi) {
        return $this->db->query("
            SELECT COUNT(a.kode) as banyak 
            FROM pengampu a 
            LEFT JOIN semester b ON a.semester = b.kode 
            WHERE b.tipe_semester = '$tipe_semester' AND a.tahun_akademik = '$tahun_akademik' AND a.kode_prodi = '$prodi'
        ")->getRow();
    }

    // Menyimpan jadwal baru
    public function simpanJadwal($kode_pengampu, $kode_jam, $kode_hari, $kode_ruang) {
        $data = [
            'kode_pengampu' => $kode_pengampu,
            'kode_hari' => $kode_hari,
            'kode_jam' => $kode_jam,
            'kode_ruang' => $kode_ruang
        ];
        return $this->db->table('riwayat_penjadwalan')->insert($data);
    }

    // Memperbarui jadwal yang ada
    public function updateJadwal($kode_pengampu, $kode_jam, $kode_hari, $kode_ruang) {
        $data = [
            'kode_hari' => $kode_hari,
            'kode_jam' => $kode_jam,
            'kode_ruang' => $kode_ruang
        ];
        return $this->db->table('riwayat_penjadwalan')->where('kode_pengampu', $kode_pengampu)->update($data);
    }
}
