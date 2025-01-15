<?php

namespace App\Models;

use CodeIgniter\Model;

class PenjadwalanModel extends Model
{
    protected $table = 'jadwalkuliah';
    protected $primaryKey = 'id_pengampu';
    protected $allowedFields = ['id_pengampu', 'id_hari', 'id_jam', 'id_ruang'];

    function cek_jadwal($semester_tipe,$tahun_akademik,$prodi){
		
		$sql  = "SELECT a.id  ,".
				"       b.id ,".
				"       c.id ".
				"FROM riwayat_penjadwalan a ".
				"LEFT JOIN pengampu b ".
				"ON a.id_pengampu = b.id ".
				"LEFT JOIN semester c ".
				"ON b.semester = c.id ".
				"WHERE c.semester_tipe = '$semester_tipe' AND b.tahun_akademik = '$tahun_akademik' AND b.id_prodi = '$prodi'";
		
		$rs = $this->db->query($sql);
		return $rs->getResult();
		
	}

    function cek_banyak_prodi($semester_tipe,$tahun_akademik){
		
		$sql  = "SELECT COUNT( DISTINCT d.id_prodi ) as banyak ,".
				"       a.id ,".
				"       c.id ,".
				"       d.id ".
				"FROM jadwalkuliah a ".
				"LEFT JOIN pengampu b ".
				"ON a.id_pengampu = b.id ".
				"LEFT JOIN semester c ".
				"ON b.semester = c.id ".
				"LEFT JOIN prodi d ".
				"ON b.id_prodi =d.id ".
				"WHERE c.semester_tipe = '$semester_tipe' AND b.tahun_akademik = '$tahun_akademik'";
		
		$rs = $this->db->query($sql);
		return $rs->getResult();
		
	}

    function cek_banyak_pengampu($semester_tipe,$tahun_akademik, $prodi){
		
		$sql  = "SELECT COUNT( a.id ) as banyak  ".
				"FROM pengampu a ".
				"LEFT JOIN semester b ".
				"ON a.semester = b.id ".
				"WHERE b.semester_tipe = '$semester_tipe' AND a.tahun_akademik = '$tahun_akademik' and a.id_prodi='$prodi'";
		
		$rs = $this->db->query($sql);
		return $rs;
		
	}

    public function simpan_jadwal($id_pengampu,$id_jam,$id_hari,$id_ruang){
	        
		$data = [
            'id_pengampu' => $id_pengampu,
            'id_hari' => $id_hari,
            'id_jam' => $id_jam,
            'id_ruang' => $id_ruang
        ];
    
        // Menggunakan query builder untuk melakukan insert
        $builder = $this->db->table('riwayat_penjadwalan');
        $result = $builder->insert($data);
		return $result;
	}
    public function detail_pengampu($id_pengampu)
    {
        return $this->db->table('pengampu')
            ->select('nama as nama_mk, nama_kelas')
            ->join('matakuliah', 'pengampu.id_mk = matakuliah.id')
            ->join('kelas', 'pengampu.id_kelas = kelas.id')
            ->where('pengampu.id', $id_pengampu)
            ->get()->getRow();
    }

    public function getAllJadwal()
    {
        $builder = $this->db->table('jadwalkuliah a')
            ->select('
                e.nama as hari,
                a.id_pengampu,
                a.id_hari,
                a.id_jam,
                a.id_ruang,
                b.id,
                b.kuota,
                f.kapasitas,
                b.tahun_akademik,
                b.id_prodi,
                c.id_mapel,
                c.jumlah_jam as jumlah_jam,
                e.id_hari,
                c.nama as nama_mk,
                c.semester as semester,
                d.id_dosen,
                d.nama as dosen,
                f.id as id_ruang,
                f.nama as ruang,
                g.id as id_jam,
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
                l.semester_tipe as semester_tipe,
                m.nama_jurusan as nama_jurusan,
                m.id as id_jurusan
            ')
            ->join('pengampu b', 'a.id_pengampu = b.id', 'left')
            ->join('matakuliah c', 'b.id_mk = c.id', 'left')
            ->join('dosen d', 'b.id_dosen = d.id', 'left')
            ->join('hari e', 'a.id_hari = e.id', 'left')
            ->join('ruang f', 'a.id_ruang = f.id', 'left')
            ->join('jam2 g', 'a.id_jam = g.id', 'left')
            ->join('kelas h', 'b.id_kelas = h.id', 'left')
            ->join('prodi i', 'b.id_prodi = i.id', 'left')
            ->join('semester_tipe j', 'c.semester = j.id', 'left')
            ->join('tahun_akademik k', 'b.tahun_akademik = k.id', 'left')
            ->join('semester l', 'b.semester = l.id', 'left')
            ->join('jurusan m', 'i.id_jurusan = m.id', 'left')
            ->orderBy('e.id', 'asc')
            ->orderBy('g.range_jam', 'asc');

        $query = $builder->get();
        return $query->getResult();
    }

    public function getPerDosen($id_dosen = null)
    {
        $rs = $this->db->table('jadwalkuliah a');

        $rs->select([
            'e.nama as hari',
            'CONCAT_WS("-", CONCAT("(", g.id), CONCAT((SELECT id FROM jam2 WHERE id = (SELECT jm.id FROM jam2 jm WHERE MID(jm.range_jam, 1, 5) = MID(g.range_jam, 1, 5)) + (c.jumlah_jam - 1)), ")")) as sesi',
            'CONCAT_WS("-", MID(g.range_jam, 1, 5), (SELECT MID(range_jam, 7, 5) FROM jam2 WHERE id = (SELECT jm.id FROM jam2 jm WHERE MID(jm.range_jam, 1, 5) = MID(g.range_jam, 1, 5)) + (c.jumlah_jam - 1))) as jam_kuliah',
            'c.nama as nama_mk',
            'c.jumlah_jam as jumlah_jam',
            'c.semester as semester',
            'b.id_kelas as kelas',
            'd.nama as dosen',
            'f.nama as ruang'
        ])
        ->join('pengampu b', 'a.id_pengampu = b.id', 'left')
        ->join('matakuliah c', 'b.id_mk = c.id', 'left')
        ->join('dosen d', 'b.id_dosen = d.id', 'left')
        ->join('hari e', 'a.id_hari = e.id', 'left')
        ->join('ruang f', 'a.id_ruang = f.id', 'left')
        ->join('jam g', 'a.id_jam = g.id', 'left')
        ->where('b.id_dosen', $id_dosen)
        ->orderBy('e.id', 'ASC')
        ->orderBy('g.range_jam', 'ASC');

        return $rs; // Mengembalikan hasil sebagai array objek
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

    public function hapus_jadwal($tipe_semester, $tahun_akademik, $prodi)
    {
        return $this->db->table('riwayat_penjadwalan')
            ->join('pengampu', 'riwayat_penjadwalan.id_pengampu = pengampu.id')
            ->join('semester', 'pengampu.semester = semester.id')
            ->where('semester.tipe_semester', $tipe_semester)
            ->where('pengampu.tahun_akademik', $tahun_akademik)
            ->where('pengampu.id_prodi', $prodi)
            ->delete();
    }

    // public function simpan_jadwal($data)
    // {
    //     return $this->db->table('riwayat_penjadwalan')->insert($data);
    // }

    public function update_jadwal($id_pengampu, $data)
    {
        return $this->db->table('riwayat_penjadwalan')
            ->where('id_pengampu', $id_pengampu)
            ->update($data);
    }

    public function deleteDuplicates()
    {
        return $this->db->table($this->table)
            ->whereIn('id', function($subquery) {
                $subquery->select('id')
                    ->from($this->table)
                    ->groupBy('id_pengampu')
                    ->having('COUNT(*) > 1');
            })
            ->delete();
    }

    

}
