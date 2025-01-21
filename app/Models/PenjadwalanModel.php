<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjadwalanModel extends Model
{
    protected $table      = 'jadwalkuliah'; 
    protected $primaryKey = 'id'; 

    protected $allowedFields = [
        'id_pengampu', 'id_hari', 'id_jam', 'id_ruang', 'nama', 'id_mk', 'id_dosen', 'id_tahun', 
        'id_kelas', 'id_prodi', 'id_semester', 'nama_ruang', 'nama_mk', 'nama_dosen', 'tahun_akademik', 
        'nama_kelas', 'nama_prodi', 'nama_semester',
    ]; 

    public function get()
    {
        $sql = "SELECT  e.nama as hari,
                        a.id_pengampu,
                        a.id_hari,
                        a.id_jam,
                        a.id_ruang,
                        b.id,
                        b.tahun_akademik,
                        b.id_prodi,
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
                        h.id as id_kelas,
                        h.nama_kelas as nama_kelas,
                        i.id_prodi,
                        i.id,
                        i.nama_prodi as nama_prodi,
                        j.id as id_semester_tipe,
                        j.tipe_semester as tipe_semester,
                        k.id as id_tahun,
                        k.tahun as nama_tahun,
                        l.id_semester,
                        l.id as id_semester,
                        l.nama_semester as nama_semester,
                        l.semester_tipe as semester_tipe
                        
                FROM jadwalkuliah a
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
                ORDER BY e.id ASC, Jam_Kuliah ASC";

        return $this->db->query($sql)->getResultArray();
    }
    public function getAllJadwal()
    {
        $sql = "SELECT  e.nama as hari,
                        a.id_pengampu,
                        a.id_hari,
                        a.id_jam,
                        a.id_ruang,
                        b.id,
                        b.tahun_akademik,
                        b.id_prodi,
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
                        h.id as id_kelas,
                        h.nama_kelas as nama_kelas,
                        i.id_prodi,
                        i.id,
                        i.nama_prodi as nama_prodi,
                        j.id as id_semester_tipe,
                        j.tipe_semester as tipe_semester,
                        k.id as id_tahun,
                        k.tahun as nama_tahun,
                        l.id_semester,
                        l.id as id_semester,
                        l.nama_semester as nama_semester,
                        l.semester_tipe as semester_tipe
                        
                FROM jadwalkuliah a
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
                ORDER BY e.id ASC, Jam_Kuliah ASC";

        return $this->db->query($sql)->getResultArray();
    }

    public function getPerdosen($id_dosen = null)
    {
        $sql = "SELECT  e.nama as hari,
                        CONCAT_WS('-', CONCAT('(', g.id), CONCAT((SELECT id
                                                                  FROM jam
                                                                  WHERE id = (SELECT jm.id
                                                                                FROM jam jm
                                                                                WHERE MID(jm.range_jam,1,5) = MID(g.range_jam,1,5)) + (c.jumlah_jam - 1)),')')) as sesi,
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

        return $this->db->query($sql, [$id_dosen])->getResultArray();
    }

    public function semuaJadwal($semester_tipe, $tahun_akademik)
    {
        $sql = "SELECT a.id_pengampu
                FROM riwayat_penjadwalan a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN semester c ON b.semester = c.id
                WHERE c.semester_tipe = ? AND b.tahun_akademik = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik])->getResultArray();
    }

    public function hapusJadwal($semester_tipe, $tahun_akademik, $prodi)
    {
        $sql = "DELETE riwayat_penjadwalan FROM riwayat_penjadwalan
                LEFT JOIN pengampu ON riwayat_penjadwalan.id_pengampu = pengampu.id
                LEFT JOIN semester ON pengampu.semester = semester.id
                WHERE semester.semester_tipe = ? AND pengampu.tahun_akademik = ? AND pengampu.id_prodi = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik, $prodi]);
    }

    public function detailPengampu($id)
    {
        $sql = "SELECT a.id as id,
                       a.id_ruang,
                       a.kelas,
                       a.semester,
                       b.id as id_mk,
                       b.nama as nama_mk,
                       b.jenis as jenis_mk,
                       c.id as id_dosen,
                       c.nama as nama_dosen,
                       d.id as id_tahun,
                       d.tahun as tahun_akademik,
                       e.id as id_kelas,
                       e.nama_kelas as nama_kelas,
                       f.id as id_prodi,
                       f.nama_prodi as nama_prodi,
                       g.id as id_semester,
                       g.nama_semester as nama_semester,
                       i.nama as nama_ruang
                FROM pengampu a
                LEFT JOIN matakuliah b ON a.id_mk = b.id
                LEFT JOIN dosen c ON a.id_dosen = c.id
                LEFT JOIN tahun_akademik d ON a.tahun_akademik = d.id
                LEFT JOIN kelas e ON a.kelas = e.id
                LEFT JOIN prodi f ON a.id_prodi = f.id
                LEFT JOIN semester g ON a.semester = g.id
                LEFT JOIN ruang i ON a.id_ruang = i.id
                WHERE a.id = ?";

        return $this->db->query($sql, [$id])->getResultArray();
    }

    public function cekJadwal($semester_tipe, $tahun_akademik, $prodi)
    {
        $sql = "SELECT a.id,
                    b.id,
                    c.id
                FROM riwayat_penjadwalan a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN semester c ON b.semester = c.id
                WHERE c.semester_tipe = ? AND b.tahun_akademik = ? AND b.id_prodi = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik, $prodi])->getResultArray();
    }

    public function detail_pengampu($id)
    {
        $sql = "SELECT a.id as id,
                       a.id_ruang,
                       a.kelas,
                       a.semester,
                       b.id as id_mk,
                       b.nama as nama_mk,
                       b.jenis as jenis_mk,
                       c.id as id_dosen,
                       c.nama as nama_dosen,
                       d.id as id_tahun,
                       d.tahun as tahun_akademik,
                       e.id as id_kelas,
                       e.nama_kelas as nama_kelas,
                       f.id as id_prodi,
                       f.nama_prodi as nama_prodi,
                       g.id as id_semester,
                       g.nama_semester as nama_semester,
                       i.nama as nama_ruang
                FROM pengampu a
                LEFT JOIN matakuliah b ON a.id_mk = b.id
                LEFT JOIN dosen c ON a.id_dosen = c.id
                LEFT JOIN tahun_akademik d ON a.tahun_akademik = d.id
                LEFT JOIN kelas e ON a.kelas = e.id
                LEFT JOIN prodi f ON a.id_prodi = f.id
                LEFT JOIN semester g ON a.semester = g.id
                LEFT JOIN ruang i ON a.id_ruang = i.id
                WHERE a.id = ?";

        return $this->db->query($sql, [$id])->getResultArray();
    }

    public function cekjadwalkuliah()
    {
        $sql = "SELECT * FROM jadwalkuliah";
        return $this->db->query($sql)->getResultArray();
    }

    public function cekSemuaJadwal($semester_tipe, $tahun_akademik)
    {
        $sql = "SELECT a.id as id_riwayat,
                       b.id,
                       c.id
                FROM riwayat_penjadwalan a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN semester c ON b.semester = c.id
                WHERE c.semester_tipe = ? AND b.tahun_akademik = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik])->getResultArray();
    }

    public function semua_jadwal($semester_tipe,$tahun_akademik){
		$sql  = "SELECT a.id_pengampu  ".
				"FROM riwayat_penjadwalan a ".
				"LEFT JOIN pengampu b ".
				"ON a.id_pengampu = b.id ".
				"LEFT JOIN semester c ".
				"ON b.semester = c.id ".
				"WHERE c.semester_tipe = '$semester_tipe' AND b.tahun_akademik = '$tahun_akademik' ";
		
		$rs = $this->db->query($sql);
		return $rs->getResult();
	
	}

    public function hapusRiwayatJadwal($id)
    {
        return $this->db->table('riwayat_penjadwalan')->where('id', $id)->delete();
    }

    public function cekBanyakProdi($semester_tipe, $tahun_akademik)
    {
        $sql = "SELECT COUNT(DISTINCT b.id_prodi) as banyak,
                       a.id,
                       c.id
                FROM jadwalkuliah a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN semester c ON b.semester = c.id
                WHERE c.semester_tipe = ? AND b.tahun_akademik = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik])->getResultArray();
    }

    public function cekBanyakPengampu($semester_tipe, $tahun_akademik, $prodi)
    {
        $sql = "SELECT COUNT(a.id) as banyak
                FROM pengampu a
                LEFT JOIN semester b ON a.semester = b.id
                WHERE b.semester_tipe = ? AND a.tahun_akademik = ? AND a.id_prodi = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik, $prodi])->getResultArray();
    }

    public function simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang)
    {
        $data = [
            'id_pengampu' => $id_pengampu,
            'id_jam' => $id_jam,
            'id_hari' => $id_hari,
            'id_ruang' => $id_ruang
        ];

        // Insert data ke tabel riwayat_penjadwalan
        $builder = $this->db->table('riwayat_penjadwalan');
        return $builder->insert($data);
    }

    public function updateJadwal($id_pengampu, $id_jam, $id_hari, $id_ruang)
    {
        $data = [
            'id_pengampu' => $id_pengampu,
            'id_hari' => $id_hari,
            'id_jam' => $id_jam,
            'id_ruang' => $id_ruang
        ];

        return $this->db->table('riwayat_penjadwalan')->where('id_pengampu', $id_pengampu)->update($data);
    }

    public function cek_banyak_prodi($semester_tipe, $tahun_akademik)
    {
        $sql = "SELECT COUNT(DISTINCT b.id_prodi) as banyak
                FROM jadwalkuliah a
                LEFT JOIN pengampu b ON a.id_pengampu = b.id
                LEFT JOIN semester c ON b.semester = c.id
                WHERE c.semester_tipe = ? AND b.tahun_akademik = ?";

        return $this->db->query($sql, [$semester_tipe, $tahun_akademik])->getResultArray();
    }
}
