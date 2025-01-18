<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatpenjadwalanModel extends Model
{
    protected $table = 'riwayat_penjadwalan'; // Nama tabel
    protected $primaryKey = 'id'; // Kunci utama tabel
    protected $allowedFields = [
        'id_pengampu',
        'id_jam',
        'id_hari',
        'id_ruang'
    ];

    // Method untuk mengambil data riwayat penjadwalan
    public function get($semester_tipe, $tahun_akademik)
    {
        $sql = "SELECT  a.id, 
                        e.nama as hari,
                        b.kuota,
                        c.nama as nama_mk,
                        c.jumlah_jam as jumlah_jam,
                        c.semester as semester,
                        d.nama as dosen,
                        f.nama as ruang,
                        g.range_jam as jam_kuliah,
                        g.sesi,
                        f.kapasitas,
                        h.id as id_kelas,
                        h.nama_kelas as nama_kelas,
                        i.id as id_prodi,
                        i.nama_prodi as nama_prodi,
                        j.id as id_semester_tipe,
                        j.tipe_semester as semester_tipe,
                        k.id as id_tahun,
                        k.tahun as nama_tahun,
                        l.id as id_semester,
                        l.nama_semester as nama_semester,
                        m.id as id_jurusan,
                        m.nama_jurusan as nama_jurusan
                FROM riwayat_penjadwalan a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN matakuliah c ON b.id_mk = c.id
                LEFT JOIN dosen d ON b.id_dosen = d.id
                LEFT JOIN hari e ON a.id_hari = e.id
                LEFT JOIN ruang f ON a.id_ruang = f.id
                LEFT JOIN jam2 g ON a.id_jam = g.id
                LEFT JOIN kelas h ON b.kelas = h.id
                LEFT JOIN prodi i ON b.id_prodi = i.id
                LEFT JOIN semester_tipe j ON c.semester = j.id
                LEFT JOIN tahun_akademik k ON b.tahun_akademik = k.id
                LEFT JOIN semester l ON b.semester = l.id
                LEFT JOIN jurusan m ON i.id_jurusan = m.id
                WHERE l.semester_tipe = ? AND b.tahun_akademik = ?
                ORDER BY e.id ASC, Jam_Kuliah ASC";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik])->getResultArray();
    }

    // Method untuk mengambil data riwayat penjadwalan per prodi
    public function get_perprodi($semester_tipe, $tahun_akademik, $jurusan)
    {
        $sql = "SELECT  e.nama as hari,
                        b.kuota,
                        c.nama as nama_mk,
                        c.jumlah_jam as jumlah_jam,
                        c.semester as semester,
                        d.nama as dosen,
                        f.nama as ruang,
                        g.range_jam as jam_kuliah,
                        g.sesi,
                        f.kapasitas,
                        h.id as id_kelas,
                        h.nama_kelas as nama_kelas,
                        i.id as id_prodi,
                        i.nama_prodi as nama_prodi,
                        j.id as id_semester_tipe,
                        j.tipe_semester as semester_tipe,
                        k.id as id_tahun,
                        k.tahun as nama_tahun,
                        l.id as id_semester,
                        l.nama_semester as nama_semester,
                        m.id as id_jurusan,
                        m.nama_jurusan as nama_jurusan
                FROM riwayat_penjadwalan a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN matakuliah c ON b.id_mk = c.id
                LEFT JOIN dosen d ON b.id_dosen = d.id
                LEFT JOIN hari e ON a.id_hari = e.id
                LEFT JOIN ruang f ON a.id_ruang = f.id
                LEFT JOIN jam2 g ON a.id_jam = g.id
                LEFT JOIN kelas h ON b.kelas = h.id
                LEFT JOIN prodi i ON b.id_prodi = i.id
                LEFT JOIN semester_tipe j ON c.semester = j.id
                LEFT JOIN tahun_akademik k ON b.tahun_akademik = k.id
                LEFT JOIN semester l ON b.semester = l.id
                LEFT JOIN jurusan m ON i.id_jurusan = m.id
                WHERE l.semester_tipe = ? AND b.tahun_akademik = ? AND b.id_prodi = ?
                ORDER BY e.id ASC, Jam_Kuliah ASC";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik, $jurusan])->getResultArray();
    }

    // Method untuk mencetak semua jadwal jurusan
    public function print_semua_jurusan($semester_tipe, $tahun_akademik)
    {
        $sql = "SELECT  e.nama as hari,
                        CONCAT_WS('-', CONCAT('(', g.id), CONCAT((SELECT id
                                                                   FROM jam
                                                                   WHERE id = (SELECT jm.id
                                                                                 FROM jam jm
                                                                                 WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1)), ')')) as sesi,
                        CONCAT_WS('-', MID(g.range_jam,1,5),
                                  (SELECT MID(range_jam,7,5)
                                   FROM jam
                                   WHERE id = (SELECT jm.id
                                                 FROM jam jm
                                                 WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1))) as jam_kuliah,
                        c.nama as nama_mk,
                        c.jumlah_jam as jumlah_jam,
                        c.semester as semester,
                        d.nama as dosen,
                        f.nama as ruang,
                        h.id as id_kelas,
                        h.nama_kelas as nama_kelas,
                        i.id as id_prodi,
                        i.nama_prodi as nama_prodi,
                        j.id as id_semester_tipe,
                        j.tipe_semester as semester_tipe,
                        k.id as id_tahun,
                        k.tahun as nama_tahun,
                        l.nama_semester as nama_semester,
                        m.nama_jurusan as nama_jurusan
                FROM riwayat_penjadwalan a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN matakuliah c ON b.id_mk = c.id
                LEFT JOIN dosen d ON b.id_dosen = d.id
                LEFT JOIN hari e ON a.id_hari = e.id
                LEFT JOIN ruang f ON a.id_ruang = f.id
                LEFT JOIN jam g ON a.id_jam = g.id
                LEFT JOIN kelas h ON b.kelas = h.id
                LEFT JOIN prodi i ON b.id_prodi = i.id
                LEFT JOIN semester_tipe j ON c.semester = j.id
                LEFT JOIN tahun_akademik k ON b.tahun_akademik = k.id
                LEFT JOIN semester l ON b.semester = l.id
                LEFT JOIN jurusan m ON i.id_jurusan = m.id
                WHERE l.semester_tipe = ? AND b.tahun_akademik = ?
                ORDER BY e.id ASC, Jam_Kuliah ASC";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik])->getResult();
    }

    // Method untuk mengambil jadwal per dosen
    public function getPerDosen($id_dosen = null)
    {
        $sql = "SELECT  e.nama as hari,
                        CONCAT_WS('-', CONCAT('(', g.id), CONCAT((SELECT id
                                                                   FROM jam
                                                                   WHERE id = (SELECT jm.id
                                                                                 FROM jam jm
                                                                                 WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1)), ')')) as sesi,
                        CONCAT_WS('-', MID(g.range_jam,1,5),
                                  (SELECT MID(range_jam,7,5)
                                   FROM jam
                                   WHERE id = (SELECT jm.id
                                                 FROM jam jm
                                                 WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1))) as jam_kuliah,
                        c.nama as nama_mk,
                        c.jumlah_jam as jumlah_jam,
                        c.semester as semester,
                        b.kelas as kelas,
                        d.nama as dosen,
                        f.nama as ruang
                FROM jadwalkuliah as a, pengampu as b, matakuliah as c, dosen as d, hari as e, ruang as f, jam as g
                WHERE a.id_pengampu = b.id AND
                      b.id_mk = c.id AND
                      b.id_dosen = d.id AND
                      b.id_dosen = ? AND
                      a.id_hari = e.id AND
                      a.id_ruang = f.id AND
                      a.id_jam = g.id
                ORDER BY e.id ASC, Jam_Kuliah ASC";

        return $this->db->query($sql, [$id_dosen])->getResult();
    }

    // Method untuk mengambil semua jadwal
    public function semua_jadwal()
    {
        return $this->db->table('jadwalkuliah')->get()->getResult();
    }

    // Method untuk menghapus jadwal berdasarkan prodi
    public function hapus_jadwal($semester_tipe, $tahun_akademik, $prodi)
    {
        $sql = "DELETE riwayat_penjadwalan
                FROM riwayat_penjadwalan
                LEFT JOIN pengampu ON riwayat_penjadwalan.id_pengampu = pengampu.id
                LEFT JOIN semester ON pengampu.semester = semester.id
                WHERE semester.semester_tipe = ? AND pengampu.tahun_akademik = ? AND pengampu.id_prodi = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik, $prodi]);
    }

    // Method untuk menghapus semua jadwal
    public function hapus_semua_jadwal($semester_tipe, $tahun_akademik)
    {
        $sql = "DELETE riwayat_penjadwalan
                FROM riwayat_penjadwalan
                LEFT JOIN pengampu ON riwayat_penjadwalan.id_pengampu = pengampu.id
                LEFT JOIN semester ON pengampu.semester = semester.id
                WHERE semester.semester_tipe = ? AND pengampu.tahun_akademik = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik]);
    }

    // Method untuk menyimpan jadwal
    public function simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang)
    {
        $data = [
            'id_pengampu' => $id_pengampu,
            'id_hari' => $id_hari,
            'id_jam' => $id_jam,
            'id_ruang' => $id_ruang
        ];

        return $this->db->table('riwayat_penjadwalan')->insert($data);
    }

    public function get_all_jadwal()
    {
        $sql = "SELECT  e.nama as hari,
                        b.kuota,
                        c.nama as nama_mk,
                        c.jumlah_jam as jumlah_jam,
                        c.semester as semester,
                        d.nama as dosen,
                        f.nama as ruang,
                        g.range_jam as jam_kuliah,
                        g.sesi,
                        f.kapasitas,
                        h.id as id_kelas,
                        h.nama_kelas as nama_kelas,
                        i.id as id_prodi,
                        i.nama_prodi as nama_prodi,
                        j.id as id_semester_tipe,
                        j.tipe_semester as semester_tipe,
                        k.id as id_tahun,
                        k.tahun as nama_tahun,
                        l.id as id_semester,
                        l.nama_semester as nama_semester,
                        m.id as id_jurusan,
                        m.nama_jurusan as nama_jurusan
                FROM riwayat_penjadwalan a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN matakuliah c ON b.id_mk = c.id
                LEFT JOIN dosen d ON b.id_dosen = d.id
                LEFT JOIN hari e ON a.id_hari = e.id
                LEFT JOIN ruang f ON a.id_ruang = f.id
                LEFT JOIN jam2 g ON a.id_jam = g.id
                LEFT JOIN kelas h ON b.kelas = h.id
                LEFT JOIN prodi i ON b.id_prodi = i.id
                LEFT JOIN semester_tipe j ON c.semester = j.id
                LEFT JOIN tahun_akademik k ON b.tahun_akademik = k.id
                LEFT JOIN semester l ON b.semester = l.id
                LEFT JOIN jurusan m ON i.id_jurusan = m.id
                ORDER BY e.id ASC, Jam_Kuliah ASC";

        return $this->db->query($sql)->getResult();
    }

    public function getJadwal($id)
    {
        return $this->select('
                riwayat_penjadwalan.*, 
                e.nama as hari,
                b.kuota,
                c.nama as nama_mk,
                c.jumlah_jam as jumlah_jam,
                c.semester as semester,
                d.nama as dosen,
                f.nama as ruang,
                g.range_jam as jam_kuliah,
                g.sesi,
                f.kapasitas,
                h.id as id_kelas,
                h.nama_kelas as nama_kelas,
                i.id as id_prodi,
                i.nama_prodi as nama_prodi,
                j.id as id_semester_tipe,
                j.tipe_semester as semester_tipe,
                k.id as id_tahun,
                k.tahun as nama_tahun,
                l.id as id_semester,
                l.nama_semester as nama_semester,
                m.id as id_jurusan,
                m.nama_jurusan as nama_jurusan
            ')
            ->join('pengampu b', 'riwayat_penjadwalan.id_pengampu = b.id', 'left')
            ->join('matakuliah c', 'b.id_mk = c.id', 'left')
            ->join('dosen d', 'b.id_dosen = d.id', 'left')
            ->join('hari e', 'riwayat_penjadwalan.id_hari = e.id', 'left')
            ->join('ruang f', 'riwayat_penjadwalan.id_ruang = f.id', 'left')
            ->join('jam2 g', 'riwayat_penjadwalan.id_jam = g.id', 'left')
            ->join('kelas h', 'b.kelas = h.id', 'left')
            ->join('prodi i', 'b.id_prodi = i.id', 'left')
            ->join('semester_tipe j', 'c.semester = j.id', 'left')
            ->join('tahun_akademik k', 'b.tahun_akademik = k.id', 'left')
            ->join('semester l', 'b.semester = l.id', 'left')
            ->join('jurusan m', 'i.id_jurusan = m.id', 'left')
            ->where('riwayat_penjadwalan.id', $id)
            ->first();
    }

    public function update_jadwal($id, $data)
    {
        return $this->db->table('riwayat_penjadwalan')->where('id', $id)->update($data);
    }
}