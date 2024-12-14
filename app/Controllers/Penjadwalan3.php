<?php 

namespace App\Controllers;

use Config\Database;
use App\Models\JamModel;
use App\Models\HariModel;
use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\ProdiModel;
use App\Models\RuangModel;
use App\Models\RiwayatpenjadwalanModel;
use App\Models\PengampuModel;
use App\Models\SemesterModel;
use App\Models\MatakuliahModel;
use App\Models\PenjadwalanModel;
use App\Models\TahunakademikModel;
use Myth\Auth\Models\UserModel;
use App\Models\WaktutidakbersediaModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xls;

class Penjadwalan3 extends BaseController {
    
    private $TEORI = 'TEORI';
    private $NORMAL = 'NORMAL';
    private $LABORATORIUM = 'LABORATORIUM';
    private $PRAKTIKUM = 'PRAKTIKUM';

    private $kap = true;
    private $id_pengampu;
    private $jenis_semester;
    private $semester_list;
    private $tahun_akademik;
    private $populasi;
    private $crossOver;
    private $mutasi;

    private $pengampu = [];
    private $individu = [[]];
    private $sks = [];
    private $dosen = [];
    private $status = [];
    private $status_dosen = [];
    private $prodi = [];
    private $kuota_pengampu = [];
    private $kelas = [];
    private $ruang_pilihan = [];
    private $semester = [];    

    private $jam1 = [];
    private $jam2 = [];
    private $jam3 = [];
    private $jam4 = [];
    private $sesi1 = [];
    private $sesi2 = [];
    private $sesi3 = [];
    private $sesi4 = [];
    private $hari = [];
    private $idosen = [];
    private $itersimpan = [];
    private $itersimpann = [];
    private $itersedia = [];
    private $itersediaa = [];

    private $waktu_dosen = [[]];
    private $waktu_tersedia = [[]];
    private $waktu_tersimpan = [[]];
    private $jenis_mk = [];

    private $kuota_ruangReguler = [];
    private $kuota_ruangLaboratorium = [];
    private $ruangLaboratorium = [];
    private $ruangReguler = [];
    private $logAmbilData;
    private $logInisialisasi;

    private $induk = [];

    private $id_jumat;
    private $range_jumat = [];
    private $id_dhuhur;
    private $is_waktu_dosen_tidak_bersedia_empty;

    protected $session;
    protected $form_validation;
    protected $db;
    protected $pagination;
    protected $helpers = ['url', 'download', 'security', 'date'];

    // Menyimpan objek model
    protected $models = [];

    public function __construct()
    {
        $this->session = session(); // Mendapatkan session dari CI4
        $this->form_validation = \Config\Services::validation(); // Form validation di CI4
        $this->db = \Config\Database::connect(); // Mengakses database
        $this->pagination = \Config\Services::pagination(); // Mengakses pagination

        // Memuat model
        $modelClasses = [
            JamModel::class,
            WaktutidakbersediaModel::class,
            KelasModel::class,
            ProdiModel::class,
            SemesterModel::class,
            PenjadwalanModel::class,
            PengampuModel::class,
            TahunakademikModel::class,
            DosenModel::class,
            HariModel::class,
            UserModel::class,
            MatakuliahModel::class,
            RiwayatpenjadwalanModel::class,
            RuangModel::class
        ];

        foreach ($modelClasses as $modelClass) {
            $this->models[strtolower((new \ReflectionClass($modelClass))->getShortName())] = new $modelClass();
        }

        // Mengatur variabel konstan
        define('IS_TEST', 'FALSE');
    }

    public function index() 
    {
        if (!$this->session->get('logged_in')) {
            return redirect()->to('admin');
        }

        $data = [
            'prodi_list' => $this->models['prodi']->findAll(),
            'pengampu_list' => $this->models['pengampu']->getPengampuWithDetails(),
            'matakuliah_list' => $this->models['matakuliah']->findAll(),
            'dosen_list' => $this->models['dosen']->findAll(),
            'kelas_list' => $this->models['kelas']->findAll(),
            'tahun_akademik_list' => $this->models['tahunakademik']->findAll(),
            'semester_list' => $this->models['semester']->findAll(),
            'ruang_list' => $this->models['ruang']->findAll()
        ];

        return view('penjadwalan', $data);
    }

    public function simpan_jadwal()
    {
        // Mengambil data jadwal
        $jadwal = $this->models['penjadwalan']->findAll();
        
        foreach ($jadwal as $k) {
            $tipe_semester = $k['tipe_semester'];
            $tahun_akademik = $k['tahun_akademik'];
            $prodi = $k['id_prodi'];
        }

        $banyak_prodi = $this->models['penjadwalan']->cek_banyak_prodi($tipe_semester, $tahun_akademik);
        $riwayat = $this->models['penjadwalan']->semua_jadwal($tipe_semester, $tahun_akademik);
    
        foreach ($banyak_prodi as $b) {
            if ($b['banyak'] > 1) {
                // Hapus semua jadwal
                $this->models['riwayatpenjadwalan']->hapus_semua_jadwal($tipe_semester, $tahun_akademik);

                // Simpan jadwal
                foreach ($jadwal as $j) {
                    $id_pengampu = $j['id_pengampu'];
                    $id_jam = $j['id_jam'];
                    $id_hari = $j['id_hari'];
                    $id_ruang = $j['id_ruang'];
                    $this->models['penjadwalan']->simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang);
                }
            } else {
                $cek = $this->models['penjadwalan']->cek_jadwal($tipe_semester, $tahun_akademik, $prodi);
                
                if ($cek) {
                    // Hapus jadwal yang sudah ada
                    $this->models['riwayatpenjadwalan']->hapus_jadwal($tipe_semester, $tahun_akademik, $prodi);
                        
                    // Simpan jadwal baru
                    foreach ($jadwal as $j) {
                        $id_pengampu = $j['id_pengampu'];
                        $id_jam = $j['id_jam'];
                        $id_hari = $j['id_hari'];
                        $id_ruang = $j['id_ruang'];
                        $this->models['penjadwalan']->simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang);
                    }
                } else {
                    // Simpan jadwal
                    foreach ($jadwal as $j) {
                        $id_pengampu = $j['id_pengampu'];
                        $id_jam = $j['id_jam'];
                        $id_hari = $j['id_hari'];
                        $id_ruang = $j['id_ruang'];
                        $this->models['penjadwalan']->simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang);
                    }
                }
            }
        }

        // Menyiapkan data untuk tampilan 
        $data['rs_tahun'] = $this->models['tahunakademik']->findAll();
        $data['waktu'] = "Berhasil menyimpan jadwal";
        $data['rs_jadwal'] = $this->models['penjadwalan']->findAll();

        // Mengatur tampilan (view)
        return view('penjadwalan', $data);
    }

    public function hapus_jadwal()
    {
        // Menghapus data jadwal
        $this->db->query("TRUNCATE TABLE jadwalkuliah");

        // Menyiapkan data untuk tampilan
        $data['rs_tahun'] = $this->models['tahunakademik']->findAll();
        $data['hapus'] = "Berhasil menghapus jadwal";
        $data['rs_jadwal'] = $this->models['penjadwalan']->findAll();

        // Mengatur tampilan (view)
        return view('penjadwalan', $data);
    } 

    public function excel_report()
    {
        // Mengambil data dari model
        $query = $this->models['penjadwalan']->findAll();

        if (!$query) {
            return false;
        }

        // Memuat PHP Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("Export");

        // Menentukan nama field untuk header excel
        $fields = ["hari", "ruang", "jam_kuliah", "nama_mk", "dosen", "nama_kelas", "nama_semester", "nama_prodi", "kuota"];
        
        // Mengisi header excel
        $col = 1;
        foreach ($fields as $field) {
            $sheet->setCellValueExplicit($col++, 1, $field, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
        }

        // Mengisi data ke dalam sheet
        $row = 2;
        foreach ($query as $data) {
            $col = 1;
            foreach ($fields as $field) {
                $sheet->setCellValue($col++, $row, $data[$field]);
            }
            $row++;
        }

        // Mengatur writer untuk menulis ke file Excel
        $writer = new Xls($spreadsheet);
        
        // Mengirimkan file Excel ke browser untuk diunduh
        return $this->response->setHeader('Content-Type', 'application/vnd.ms-excel')
                              ->setHeader('Content-Disposition', 'attachment;filename="Jadwal_' . date('dMy') . '.xls"')
                              ->setHeader('Cache-Control', 'max-age=0')
                              ->setBody($writer->save('php://output'));
    }
    public function AmbilData($semester_list, $tahun_akademik, $jumlah_populasi, $prodi, $query, $e, $mod)
    {
        $this->semester_list = $semester_list;
        $this->tahun_akademik = $tahun_akademik;
        $this->populasi = $jumlah_populasi;

        // Penggunaan query builder untuk tabel pengampu
        $builder = $this->db->table('pengampu a');
        $builder->select('a.id, b.jumlah_jam, a.id_dosen, a.id_prodi, a.kelas, a.id_ruang,
                          a.kuota, a.semester as id_sem, b.jenis, c.id as id_kelas, c.nama_kelas,
                          d.id as id_prod, d.prodi as nama_prodi, d.id_prodi, e.id as id_semester,
                          e.nama_semester, f.status_dosen, g.status')
                ->join('matakuliah b', 'a.id_mk = b.id', 'left')
                ->join('kelas c', 'a.kelas = c.id', 'left')
                ->join('prodi d', 'a.id_prodi = d.id', 'left')
                ->join('semester e', 'a.semester = e.id', 'left')
                ->join('dosen f', 'a.id_dosen = f.id', 'left')
                ->join('status_dosen g', 'f.status_dosen = g.id', 'left')
                ->where('b.semester', $this->semester_list)
                ->where('a.tahun_akademik', $this->tahun_akademik);

        // Jika filter prodi diberikan
        if ($prodi) {
            $builder->where('a.id_prodi', $prodi);
        }

        // Menambah Order By
        if ($query) {
            $builder->orderBy('a.id', $query);
        }

        // Eksekusi query
        $rs_data = $builder->get();

        // Parsing data
        $i = 0;
        foreach ($rs_data->getResult() as $data) {
            $this->pengampu[$i] = intval($data->id);
            $this->sks[$i] = intval($data->jumlah_jam);
            $this->dosen[$i] = intval($data->id_dosen);
            $this->status_dosen[$i] = intval($data->status_dosen);
            $this->status[$i] = $data->status;
            $this->prodi[$i] = intval($data->id_prodi);
            $this->semester[$i] = intval($data->id_sem);
            $this->kelas[$i] = intval($data->kelas);
            $this->ruang_pilihan[$i] = intval($data->id_ruang);
            $this->kuota_pengampu[$i] = intval($data->kuota);
            $this->jenis_mk[$i] = $data->jenis;
            $i++;
        }

        // Query untuk SKS = 1
        $this->jam1 = $this->getJamBySks(1);
        // Query untuk SKS = 2
        $this->jam2 = $this->getJamBySks(2);
        // Query untuk SKS = 3
        $this->jam3 = $this->getJamBySks(3);
        // Query untuk SKS = 4
        $this->jam4 = $this->getJamBySks(4);

        // Query untuk hari
        $rs_hari = $this->db->query("SELECT id FROM hari");
        $i = 0;
        foreach ($rs_hari->getResult() as $data) {
            $this->hari[$i] = (int) $data->id;
            $i++;
        }

        // Query untuk waktu dosen
        $this->getWaktuDosen($prodi);
        // Query untuk waktu tersedia
        $this->getWaktuTersedia($prodi);
        // Query untuk waktu tersimpan
        $this->getWaktuTersimpan($prodi);
    }

    private function getJamBySks($sks)
    {
        return $this->db->query("SELECT id FROM jam2 WHERE sks = ?", [$sks])->getResult();
    }

    private function getWaktuDosen($prodi)
    {
        $rs_Waktudosen = $this->db->query("SELECT a.id_dosen, CONCAT_WS(':', a.id_hari, b.sesi) AS id_hari_jam
                                            FROM waktu_tidak_bersedia a
                                            LEFT JOIN jam2 b ON a.id_jam = b.id");
        $i = 0;
        foreach ($rs_Waktudosen->getResult() as $data) {
            $this->idosen[$i] = (int) $data->id_dosen;
            $this->waktu_dosen[$i][0] = (int) $data->id_dosen;
            $this->waktu_dosen[$i][1] = (int) $data->id_hari_jam;
            $i++;
        }
    }

    private function getWaktuTersedia($prodi)
    {
        if ($prodi) {
            $rs_Waktutersedia = $this->db->query("SELECT a.id, a.id_pengampu, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.id_dosen) AS id_hari_ruang
                                                   FROM riwayat_penjadwalan a
                                                   LEFT JOIN pengampu b ON a.id_pengampu = b.id
                                                   LEFT JOIN semester c ON b.semester = c.id
                                                   LEFT JOIN jam2 d ON a.id_jam = d.id
                                                   WHERE c.tipe_semester = ?
                                                   AND b.tahun_akademik = ?
                                                   AND b.id_prodi != ?", [$this->semester_list, $this->tahun_akademik, $prodi]);
            $i = 0;
            foreach ($rs_Waktutersedia->getResult() as $data) {
                $this->itersedia[$i] = (int) $data->id_dosen;
                $this->waktu_tersedia[$i] = [(int) $data->id_dosen, $data->id_hari_ruang];
                $i++;
            }
        }
    }

    private function getWaktuTersimpan($prodi)
    {
        if ($prodi) {
            $rs_Waktutersimpan = $this->db->query("SELECT a.id, a.id_pengampu, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.id_dosen) AS id_hari_ruang
                                                   FROM jadwalkuliah a
                                                   LEFT JOIN pengampu b ON a.id_pengampu = b.id
                                                   LEFT JOIN semester c ON b.semester = c.id
                                                   LEFT JOIN jam2 d ON a.id_jam = d.id
                                                   WHERE c.tipe_semester = ?
                                                   AND b.tahun_akademik = ?
                                                   AND b.id_prodi = ?", [$this->semester_list, $this->tahun_akademik, $prodi]);
            $i = 0;
            foreach ($rs_Waktutersimpan->getResult() as $data) {
                $this->itersimpan[$i] = (int) $data->id_dosen;
                $this->waktu_tersimpan[$i] = [(int) $data->id_dosen, $data->id_hari_ruang];
                $i++;
            }
        } else {
            $rs_Waktutersimpan = $this->db->query("SELECT a.id, a.id_pengampu, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.id_dosen) AS id_hari_ruang
                                                   FROM jadwalkuliah a
                                                   LEFT JOIN pengampu b ON a.id_pengampu = b.id
                                                   LEFT JOIN semester c ON b.semester = c.id
                                                   LEFT JOIN jam2 d ON a.id_jam = d.id
                                                   WHERE c.tipe_semester = ?
                                                   AND b.tahun_akademik = ?", [$this->semester_list, $this->tahun_akademik]);
            $i = 0;
            foreach ($rs_Waktutersimpan->getResult() as $data) {
                $this->itersimpan[$i] = (int) $data->id_dosen;
                $this->waktu_tersimpan[$i] = [(int) $data->id_dosen, $data->id_hari_ruang];
                $i++;
            }
        }
    }

    public function Inisialisasi($jumlah_populasi)
    {
        $this->populasi = $jumlah_populasi;
        $jumlah_pengampu = count($this->pengampu);
        $jumlah_hari = count($this->hari);
        $jumlah_ruang_lab = count($this->ruangLaboratorium);

        // Untuk setiap individu dalam populasi
        for ($i = 0; $i < $this->populasi; $i++) {
            // untuk setiap pengampu
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                $sks = $this->sks[$j];

                // Penentuan ID pengampu
                $this->individu[$i][$j][0] = $j;

                // Penentuan jam secara acak berdasarkan jumlah sks
                switch ($sks) {
                    case 1:
                        $this->individu[$i][$j][1] = (int) $this->jam1[array_rand($this->jam1)];
                        break;
                    case 2:
                        $this->individu[$i][$j][1] = (int) $this->jam2[array_rand($this->jam2)];
                        break;
                    case 3:
                        $this->individu[$i][$j][1] = (int) $this->jam3[array_rand($this->jam3)];
                        break;
                    case 4:
                        $this->individu[$i][$j][1] = (int) $this->jam4[array_rand($this->jam4)];
                        break;
                }

                // Menentukan hari secara acak
                $this->individu[$i][$j][2] = mt_rand(0, $jumlah_hari - 1);

                // Menentukan ruang berdasarkan jenis mata kuliah
                $prodi = (int) $this->prodi[$j];

                // Jika mata kuliah TEORI
                if ($this->jenis_mk[$j] === $this->TEORI) {
                    $kuota = intval($this->kuota_pengampu[$j]);
                    $this->individu[$i][$j][3] = $this->getRuangReguler($prodi, $kuota, $j);
                }
                // Jika mata kuliah PRAKTIKUM
                else if ($this->jenis_mk[$j] === $this->PRAKTIKUM) {
                    $kuota = intval($this->kuota_pengampu[$j]);
                    $this->individu[$i][$j][3] = $this->getRuangLaboratorium($prodi, $kuota, $j);
                }
            }
        }
    }

    private function getRuangReguler($prodi, $kuota)
    {
        $ruangReguler = [];
        $rs_RuangReguler = $this->db->query("SELECT id FROM ruang WHERE jenis = ? AND id_prodi = ? AND kapasitas >= ?", [$this->TEORI, $prodi, $kuota]);

        if ($rs_RuangReguler->getNumRows() > 0) {
            foreach ($rs_RuangReguler->getResult() as $data) {
                $ruangReguler[] = (int) $data->id;
            }
            return $ruangReguler[array_rand($ruangReguler)];
        }
        $this->kap = false;
        $this->id_pengampu = $this->pengampu['$id_pengampu'];
        return null;
    }

    private function getRuangLaboratorium($prodi, $kuota)
    {
        $ruangLaboratorium = [];
        $rs_RuangLaboratorium = $this->db->query("SELECT id FROM ruang WHERE jenis = ? AND id_prodi = ? AND kapasitas >= ?", [$this->LABORATORIUM, $prodi, $kuota]);

        if ($rs_RuangLaboratorium->getNumRows() > 0) {
            foreach ($rs_RuangLaboratorium->getResult() as $data) {
                $ruangLaboratorium[] = (int) $data->id;
            }
            return $ruangLaboratorium[array_rand($ruangLaboratorium)];
        }
        $this->kap = false;
        $this->id_pengampu = $this->pengampu['$id_pengampu'];
        return null;
    }

    public function CekFitness($indv, $prodi)
    {
        $penalty = 0;
        $jumlah_pengampu = count($this->pengampu);

        // Cek bentrok dan kriteria lainnya
        for ($i = 0; $i < $jumlah_pengampu; $i++) {
            $ruang_a = intval($this->individu[$indv][$i][3]);
            $sks = intval($this->sks[$i]);
            $jam_a = intval($this->individu[$indv][$i][1]);
            $hari_a = intval($this->individu[$indv][$i][2]);
            $dosen_a = intval($this->dosen[$i]);

            // Loop untuk cek bentrok dengan individu lain
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                if ($i == $j) continue; // Lewati jika sama

                $jam_b = intval($this->individu[$indv][$j][1]);
                $hari_b = intval($this->individu[$indv][$j][2]);
                $ruang_b = intval($this->individu[$indv][$j][3]);
                $dosen_b = intval($this->dosen[$j]);
                
                // Bentrok: jam, hari dan ruang sama
                if ($jam_a == $jam_b && $hari_a == $hari_b && $ruang_a == $ruang_b) {
                    $penalty += 1;
                }

                // Bentrok: dosen yang sama pada jam dan hari yang sama
                if ($dosen_a == $dosen_b && $jam_a == $jam_b && $hari_a == $hari_b) {
                    $penalty += 1;
                }
            }

            // Bentrok dengan waktu yang tidak tersedia
            $this->cekWaktuTidakTersedia($indv, $dosen_a, $jam_a, $hari_a, $penalty);
        }

        $fitness = floatval(1 / (1 + $penalty));  
        return $fitness;     
    }

    private function cekWaktuTidakTersedia($indv, $dosen_a, $jam_a, $hari_a, &$penalty) 
    {
        $jumlah_waktu_tidak_bersedia = count($this->idosen);

        for ($j = 0; $j < $jumlah_waktu_tidak_bersedia; $j++) {
            if ($dosen_a == $this->idosen[$j]) {
                $hari_jam = explode(':', $this->waktu_dosen[$j][1]);
                
                if ($jam_a == $hari_jam[1] && $this->hari[$hari_a] == $hari_jam[0]) {
                    $penalty += 1;                        
                }
            }                            
        }
    }

    public function HitungFitness($jumlah_populasi, $prodi)
    {
        $this->populasi = $jumlah_populasi;
        $fitness = [];

        for ($indv = 0; $indv < $this->populasi; $indv++) {
            $fitness[$indv] = $this->CekFitness($indv, $prodi);
        }

        return $fitness;
    }

    public function Seleksi($fitness, $jumlah_populasi)
    {
        $this->populasi = $jumlah_populasi;
        $jumlah = 0;
        $rank = [];

        // Proses ranking berdasarkan nilai fitness
        for ($i = 0; $i < $this->populasi; $i++) {
            $rank[$i] = 1;
            for ($j = 0; $j < $this->populasi; $j++) {
                $fitnessA = floatval($fitness[$i]);
                $fitnessB = floatval($fitness[$j]);

                // Jika nilai fitness individu saat ini lebih besar dari individu lain, ranking naik
                if ($fitnessA > $fitnessB) {
                    $rank[$i] += 1;
                }
            }
            $jumlah += $rank[$i];
        }

        // Proses seleksi berdasarkan ranking yang telah dibuat
        for ($i = 0; $i < $this->populasi; $i++) {
            $target = mt_rand(0, $jumlah - 1);
            $cek = 0;
            for ($j = 0; $j < count($rank); $j++) {
                $cek += $rank[$j];
                if (intval($cek) >= intval($target)) {
                    // Menyimpan induk yang terpilih berdasarkan ranking
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }

    public function StartCrossOver($jumlah_populasi, $crossOver)
    {
        $this->populasi = $jumlah_populasi;
        $individu_baru = array_fill(0, $this->populasi, array_fill(0, count($this->pengampu), []));

        for ($i = 0; $i < $this->populasi; $i += 2) {
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax(); // Nilai random untuk crossover

            if ($cr < $crossOver) {
                $a = mt_rand(0, count($this->pengampu) - 2);
                $b = mt_rand($a, count($this->pengampu) - 1);

                // Crossover
                for ($j = 0; $j < count($this->pengampu); $j++) {
                    if ($j < $a || $j > $b) {
                        // Tidak melakukan crossover, salin individu langsung
                        $individu_baru[$i][$j] = $this->individu[$this->induk[$i]][$j];
                        $individu_baru[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                    } else {
                        // Melakukan crossover
                        $individu_baru[$i][$j] = $this->individu[$this->induk[$i + 1]][$j];
                        $individu_baru[$i + 1][$j] = $this->individu[$this->induk[$i]][$j];
                    }
                }
            } else {
                // Jika tidak terjadi crossover, salin individu langsung
                for ($j = 0; $j < count($this->pengampu); $j++) {
                    $individu_baru[$i][$j] = $this->individu[$this->induk[$i]][$j];
                    $individu_baru[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                }
            }
        }

        // update individu berdasarkan crossover
        for ($i = 0; $i < $this->populasi; $i += 2) {
            $this->individu[$i] = $individu_baru[$i];
            $this->individu[$i + 1] = $individu_baru[$i + 1];
        }
    }

    public function Mutasi($jumlah_populasi, $mutasi)
    {
        $this->populasi = $jumlah_populasi;

        // Melakukan iterasi untuk setiap individu dalam populasi
        for ($i = 0; $i < $this->populasi; $i++) {
            // Jika nilai acak lebih kecil dari probabilitas mutasi, lakukan mutasi
            if (mt_rand() / mt_getrandmax() < $mutasi) {
                $krom = mt_rand(0, count($this->pengampu) - 1);
                $sks = intval($this->sks[$krom]);

                // Switch untuk menangani mutasi berdasarkan jumlah sks
                switch ($sks) {
                    case 1:
                        $this->individu[$i][$krom][1] = $this->jam1[array_rand($this->jam1)];
                        break;
                    case 2:
                        $this->individu[$i][$krom][1] = $this->jam2[array_rand($this->jam2)];
                        break;
                    case 3:
                        $this->individu[$i][$krom][1] = $this->jam3[array_rand($this->jam3)];
                        break;
                    case 4:
                        $this->individu[$i][$krom][1] = $this->jam4[array_rand($this->jam4)];
                        break;
                }

                // Ganti hari secara acak
                $this->individu[$i][$krom][2] = mt_rand(0, count($this->hari) - 1);
                // Ambil id prodi untuk pengampu tersebut
                $prodi = intval($this->prodi[$krom]);
                $this->individu[$i][$krom][3] = $this->getRuangReguler($prodi, intval($this->kuota_pengampu[$krom]));
            }
        }
    }

    public function getIndividu($indv)
    {
        $individu_solusi = [];

        for ($j = 0; $j < count($this->pengampu); $j++) {
            $individu_solusi[$j] = [
                'id_pengampu' => intval($this->pengampu[$this->individu[$indv][$j][0]]),
                'id_jam' => intval($this->individu[$indv][$j][1]),
                'id_hari' => intval($this->hari[$this->individu[$indv][$j][2]]),
                'id_ruang' => intval($this->individu[$indv][$j][3])
            ];
        }

        return $individu_solusi;
    }
}
?>