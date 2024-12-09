<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjadwalanModel2 extends Model
{
    protected $table = 'jadwalkuliah'; // Nama tabel jadwal kuliah
    protected $primaryKey = 'id'; // primary tabel
    protected $allowedFields = ['id_pengampu', 'id_hari', 'id_jam', 'id_ruang']; // Fields yang dapat diisi

    // Mengambil semua jadwal
    public function getAllJadwal() {
        return $this->db->query("
            SELECT  e.nama as hari, 
                    IF(c.jumlah_jam='4','2',IF(c.jumlah_jam='1','1',IF(c.jumlah_jam='2','2',IF(c.jumlah_jam='3','3','')))) as sks,
                    CONCAT_WS('-', CONCAT('(', g.id), CONCAT((SELECT id FROM jam WHERE id = (SELECT jm.id FROM jam jm WHERE MID(jm.range_jam, 1, 5) = MID(g.range_jam, 1, 5)) + (sks - 1)), ')')) as sesi,
                    CONCAT_WS('-', MID(g.range_jam, 1, 5), (SELECT MID(range_jam, 7, 5) FROM jam WHERE id = (SELECT jm.id FROM jam jm WHERE MID(jm.range_jam, 1, 5) = MID(g.range_jam, 1, 5)) + (sks - 1))) as jam_kuliah,
                    a.id_pengampu,
                    a.id_hari,
                    a.id_jam,
                    a.id_ruang,
                    b.kuota,
                    b.id,
                    b.tahun_akademik,
                    b.id_prodi,
                    c.jumlah_jam as jumlah_jam,
                    c.nama as nama_mk,
                    c.semester as semester,
                    d.nama as dosen,
                    f.nama as ruang,
                    f.kapasitas,
                    h.id as id_kelas,
                    h.nama_kelas as nama_kelas,
                    i.id,
                    i.nama_prodi as nama_prodi,
                    j.id as id_tipe_semester,
                    j.tipe_semester as tipe_semester,
                    k.id as id_tahun,
                    k.tahun as nama_tahun,
                    l.id as id_semester,
                    l.nama_semester as nama_semester,
                    l.tipe_semester as tipe_semester,
                    m.prodi as nama_prodi,
                    m.id as id_prodi
            FROM jadwalkuliah a
            LEFT JOIN pengampu b ON a.id_pengampu = b.id
            LEFT JOIN matakuliah c ON b.id_mk = c.id
            LEFT JOIN dosen d ON b.id_dosen = d.id
            LEFT JOIN hari e ON a.id_hari = e.id
            LEFT JOIN ruang f ON a.id_ruang = f.id
            LEFT JOIN jam g ON a.id_jam = g.id
            LEFT JOIN kelas h ON b.kelas = h.id
            LEFT JOIN prodi i ON b.id_prodi = i.id
            LEFT JOIN tipe_semester j ON c.semester = j.id
            LEFT JOIN tahun_akademik k ON b.tahun_akademik = k.id
            LEFT JOIN semester l ON b.semester = l.id
            LEFT JOIN prodi m ON i.id_prodi = m.id
            ORDER BY e.id ASC, jam_kuliah ASC
        ");
    }

    // Mengambil jadwal berdasarkan dosen
    public function getPerDosen($id_dosen = null) {
        return $this->db->query("
            SELECT  e.nama as hari,
                    CONCAT_WS('-', CONCAT('(', g.id), CONCAT((SELECT id FROM jam WHERE id = (SELECT jm.id FROM jam jm WHERE MID(jm.range_jam, 1, 5) = MID(g.range_jam, 1, 5)) + (c.jumlah_jam - 1)), ')')) as sesi,
                    CONCAT_WS('-', MID(g.range_jam, 1, 5), (SELECT MID(range_jam, 7, 5) FROM jam WHERE id = (SELECT jm.id FROM jam jm WHERE MID(jm.range_jam, 1, 5) = MID(g.range_jam, 1, 5))
                    + (c.jumlah_jam - 1))) as jam_kuliah,
                    c.nama as nama_mk,
                    c.jumlah_jam as jumlah_jam,
                    c.semester as semester,
                    b.kelas as kelas,
                    d.nama as dosen,
                    f.nama as ruang 
            FROM jadwalpelajaran a
            LEFT JOIN pengampu b ON a.id_pengampu = b.id 
            LEFT JOIN matakuliah c ON b.id_mk = c.id 
            LEFT JOIN dosen d ON b.id_dosen = d.id 
            LEFT JOIN hari e ON a.id_hari = e.id 
            LEFT JOIN ruang f ON a.id_ruang = f.id 
            LEFT JOIN jam g ON a.id_jam = g.id 
            WHERE b.id_dosen = {$id_dosen}
            ORDER BY e.id ASC, jam_kuliah ASC
        ");
    }

    // Mengambil semua jadwal berdasarkan semester tipe dan tahun akademik
    public function semuaJadwal($tipe_semester, $tahun_akademik) {
        return $this->db->query("
            SELECT a.id_pengampu 
            FROM riwayat_penjadwalan a 
            LEFT JOIN pengampu b ON a.id_pengampu = b.id 
            LEFT JOIN semester c ON b.semester = c.id 
            WHERE c.tipe_semester = '$tipe_semester' AND b.tahun_akademik = '$tahun_akademik'
        ")->getResult();
    }

    // Memeriksa jadwal tertentu berdasarkan tipe semester, tahun akademik, dan id prodi
    public function cekJadwal($tipe_semester, $tahun_akademik, $prodi) {
        return $this->db->query("
            SELECT a.id, b.id, c.id 
            FROM riwayat_penjadwalan a 
            LEFT JOIN pengampu b ON a.id_pengampu = b.id 
            LEFT JOIN semester c ON b.semester = c.id 
            WHERE c.tipe_semester = '$tipe_semester' AND b.tahun_akademik = '$tahun_akademik' AND b.id_prodi = '$prodi'
        ")->getResult();
    }

    // Memeriksa semua jadwal
    public function cekSemuaJadwal($tipe_semester, $tahun_akademik) {
        return $this->db->query("
            SELECT a.id as id_riwayat, b.id, c.id 
            FROM riwayat_penjadwalan a 
            LEFT JOIN pengampu b ON a.id_pengampu = b.id 
            LEFT JOIN semester c ON b.semester = c.id 
            WHERE c.tipe_semester = '$tipe_semester' AND b.tahun_akademik = '$tahun_akademik'
        ")->getResult();
    }

    // Menghapus riwayat jadwal berdasarkan ID
    public function hapusRiwayatJadwal($id) {
        return $this->db->table('riwayat_penjadwalan')->where('id', $id)->delete();
    }

    // Memeriksa jumlah program studi
    public function cekBanyakProdi($tipe_semester, $tahun_akademik) {
        return $this->db->query("
            SELECT COUNT(DISTINCT b.id_prodi) as banyak, a.id, c.id 
            FROM jadwalpelajaran a 
            LEFT JOIN pengampu b ON a.id_pengampu = b.id 
            LEFT JOIN semester c ON b.semester = c.id 
            WHERE c.tipe_semester = '$tipe_semester' AND b.tahun_akademik = '$tahun_akademik'
        ")->getResult();
    }

    // Memeriksa jumlah pengampu
    public function cekBanyakPengampu($tipe_semester, $tahun_akademik, $prodi) {
        return $this->db->query("
            SELECT COUNT(a.id) as banyak 
            FROM pengampu a 
            LEFT JOIN semester b ON a.semester = b.id 
            WHERE b.tipe_semester = '$tipe_semester' AND a.tahun_akademik = '$tahun_akademik' AND a.id_prodi = '$prodi'
        ")->getRow();
    }

    // Menyimpan jadwal baru
    public function simpanJadwal($id_pengampu, $id_jam, $id_hari, $id_ruang) {
        $data = [
            'id_pengampu' => $id_pengampu,
            'id_hari' => $id_hari,
            'id_jam' => $id_jam,
            'id_ruang' => $id_ruang
        ];
        return $this->db->table('riwayat_penjadwalan')->insert($data);
    }

    // Memperbarui jadwal yang ada
    public function updateJadwal($id_pengampu, $id_jam, $id_hari, $id_ruang) {
        $data = [
            'id_hari' => $id_hari,
            'id_jam' => $id_jam,
            'id_ruang' => $id_ruang
        ];
        return $this->db->table('riwayat_penjadwalan')->where('id_pengampu', $id_pengampu)->update($data);
    }
}
