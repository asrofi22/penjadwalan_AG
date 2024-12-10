<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjadwalanModel extends Model
{
    protected $table = 'jadwalkuliah';
    protected $primaryKey = 'id_pengampu';
    protected $allowedFields = ['id_pengampu', 'id_hari', 'id_jam', 'id_ruang'];

    public function get()
    {
        $sql = "SELECT e.nama as hari,
                       a.id_pengampu,
                       a.id_hari,
                       a.id_jam,
                       a.id_ruang,
                       b.id,
                       b.kuota,
                       f.kapasitas,
                       b.tahun_akademik,
                       b.id_prodi,
                       c.id_mk,
                       c.jumlah_jam as jumlah_jam,
                       e.id_hari,
                       c.nama as nama_mk,
                       c.semester as semester,
                       d.id_dosen,
                       d.nama as dosen,
                       f.id_ruang,
                       f.nama as ruang,
                       g.id_jam,
                       g.range_jam as jam_kuliah,
                       g.sesi as sesi,
                       h.id_kelas,
                       h.id as `id_kelas`,
                       h.nama_kelas as `nama_kelas`,
                       i.id_prodi,
                       i.id,
                       i.prodi as `nama_prodi`,
                       j.id as `id_tipe_semester`,
                       j.tipe_semester as `tipe_semester`,
                       k.id as `id_tahun`,
                       k.tahun as `nama_tahun`,
                       l.id_semester,
                       l.id as `id_semester`,
                       l.nama_semester as `nama_semester`,
                       l.tipe_semester as `tipe_semester`,
                       m.prodi as `nama_prodi`,
                       m.id as `id_prodi`
                FROM jadwalkuliah a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN matakuliah c ON b.id_mk = c.id
                LEFT JOIN dosen d ON b.id_dosen = d.id
                LEFT JOIN hari e ON a.id_hari = e.id
                LEFT JOIN ruang f ON a.id_ruang = f.id
                LEFT JOIN jam2 g ON a.id_jam = g.id
                LEFT JOIN kelas h ON b.kelas = h.id
                LEFT JOIN prodi i ON b.id_prodi = i.id
                LEFT JOIN tipe_semester j ON c.semester = j.id
                LEFT JOIN tahun_akademik k ON b.tahun_akademik = k.id
                LEFT JOIN semester l ON b.semester = l.id
                LEFT JOIN prodi m ON i.id_prodi = m.id
                ORDER BY e.id ASC, jam_kuliah ASC";
        
        return $this->db->query($sql)->getResult();
    }

    public function getPerDosen($id_dosen = null)
    {
        $sql = "SELECT e.nama as hari,
                       CONCAT_WS('-', CONCAT('(', g.id), 
                       CONCAT((SELECT id FROM jam WHERE id = (SELECT jm.id FROM jam jm WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1)), ')')) as sesi,
                       CONCAT_WS('-', MID(g.range_jam,1,5), (SELECT MID(range_jam,7,5) FROM jam WHERE id = (SELECT jm.id FROM jam jm WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1))) as jam_kuliah,
                       c.nama as nama_mk,
                       c.jumlah_jam as jumlah_jam,
                       c.semester as semester,
                       b.kelas as kelas,
                       d.nama as dosen,
                       f.nama as ruang
                FROM jadwalkuliah a
                JOIN pengampu b ON a.id_pengampu = b.id
                JOIN matakuliah c ON b.id_mk = c.id
                JOIN dosen d ON b.id_dosen = d.id
                JOIN hari e ON a.id_hari = e.id
                JOIN ruang f ON a.id_ruang = f.id
                JOIN jam g ON a.id_jam = g.id
                WHERE b.id_dosen = ?
                ORDER BY e.id ASC, jam_kuliah ASC";
        
        return $this->db->query($sql, [$id_dosen])->getResult();
    }

    public function semua_jadwal($tipe_semester, $tahun_akademik)
    {
        return $this->db->table('riwayat_penjadwalan')
                        ->select('a.id_pengampu')
                        ->join('pengampu b', 'a.id_pengampu = b.id')
                        ->join('semester c', 'b.semester = c.id')
                        ->where('c.tipe_semester', $tipe_semester)
                        ->where('b.tahun_akademik', $tahun_akademik)
                        ->get()
                        ->getResult();
    }

    public function hapus_jadwal($tipe_semester, $tahun_akademik, $prodi)
    {
        $this->db->table('riwayat_penjadwalan')
                 ->join('pengampu', 'riwayat_penjadwalan.id_pengampu = pengampu.id')
                 ->join('semester', 'pengampu.semester = semester.id')
                 ->where('semester.tipe_semester', $tipe_semester)
                 ->where('pengampu.tahun_akademik', $tahun_akademik)
                 ->where('pengampu.id_prodi', $prodi)
                 ->delete();
    }

    public function simpan_jadwal($data)
    {
        return $this->db->table('riwayat_penjadwalan')->insert($data);
    }

    public function update_jadwal($id_pengampu, $data)
    {
        return $this->db->table('riwayat_penjadwalan')
                        ->where('id_pengampu', $id_pengampu)
                        ->update($data);
    }
}
?>