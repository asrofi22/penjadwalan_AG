<?php

namespace App\Controllers;

use App\Models\JamModel;
use App\Models\WaktutidakbersediaModel;
use App\Models\KelasModel;
use App\Models\ProdiModel;
use App\Models\JurusanModel;
use App\Models\SemesterModel;
use App\Models\PenjadwalanModel;
use App\Models\PengampuModel;
use App\Models\TahunakademikModel;
use App\Models\DosenModel;
use App\Models\HariModel;
use Myth\Auth\Models\UserModel;
use App\Models\MatakuliahModel;
use App\Models\RiwayatpenjadwalanModel;
use App\Models\RuangModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use Config\Services;

class Penjadwalan2 extends Controller
{
    protected $PRAKTIKUM = 'PRAKTIKUM';
    protected $TEORI = 'TEORI';
    protected $Normal = 'Normal';
    protected $LABORATORIUM = 'LABORATORIUM';

    protected $kap = true;
    protected $id_pengampu;
    protected $jenis_semester;
    protected $tahun_akademik;
    protected $populasi;
    protected $crossOver;
    protected $mutasi;

    protected $pengampuu = [];
    protected $pengampu = [];
    protected $individu = [];
    protected $sks = [];
    protected $dosen = [];
    protected $status = [];
    protected $status_dosen = [];
    protected $prodi = [];
    protected $jurusan;
    protected $kelas = [];
    protected $semester = [];
    protected $kuota_pengampu = [];
    protected $ruang_pilihan = [];

    protected $jam1 = [];
    protected $jam2 = [];
    protected $jam3 = [];
    protected $jam4 = [];
    protected $sesi1 = [];
    protected $sesi2 = [];
    protected $sesi3 = [];
    protected $sesi4 = [];
    protected $hari = [];
    protected $idosen = [];
    protected $itersedia = [];
    protected $itersimpan = [];
    protected $itersimpann = [];
    protected $itersediaa = [];

    protected $waktu_dosen = [];
    protected $waktu_tersedia = [];
    protected $waktu_tersimpan = [];
    protected $jenis_mk = [];

    protected $kuota_ruangReguler = [];
    protected $kuota_ruangLaboratorium = [];
    protected $ruangLaboratorium = [];
    protected $ruangReguler = [];
    protected $logAmbilData;
    protected $logInisialisasi;

    protected $induk = [];

    protected $id_jumat;
    protected $range_jumat = [];
    protected $id_dhuhur;
    protected $is_waktu_dosen_tidak_bersedia_empty;
    protected $JamModel;
    protected $WaktutidakbersediaModel;
    protected $KelasModel;
    protected $ProdiModel;
    protected $SemesterModel;
    protected $PenjadwalanModel;
    protected $PengampuModel;
    protected $TahunakademikModel;
    protected $DosenModel;
    protected $JurusanModel;
    protected $HariModel;
    protected $UserModel;
    protected $MatakuliahModel;
    protected $RiwayatpenjadwalanModel;
    protected $RuangModel;
    protected $jadwal;
    protected $queryLimit;
    protected $queryOffset;


    protected $session;
    protected $db;

    public function __construct()
    {
        $this->session = Services::session();
        $this->db = \Config\Database::connect();

        // Load models
        $this->JamModel = new JamModel();
        $this->WaktutidakbersediaModel = new WaktutidakbersediaModel();
        $this->KelasModel = new KelasModel();
        $this->ProdiModel = new ProdiModel();
        $this->JurusanModel = new JurusanModel();
        $this->SemesterModel = new SemesterModel();
        $this->PenjadwalanModel = new PenjadwalanModel();
        $this->PengampuModel = new PengampuModel();
        $this->TahunakademikModel = new TahunakademikModel();
        $this->DosenModel = new DosenModel();
        $this->HariModel = new HariModel();
        $this->UserModel = new UserModel();
        $this->MatakuliahModel = new MatakuliahModel();
        $this->RiwayatpenjadwalanModel = new RiwayatpenjadwalanModel();
        $this->RuangModel = new RuangModel();
    }

    public function index()
    {
        // if (!$this->session->get('logged_in')) {
        //     return redirect()->to('admin/index');
        // }

        $data = [
            'prodi_list' => $this->ProdiModel->findAll(),
            'pengampu_list' => $this->PengampuModel->getPengampuWithDetails(),
            'matakuliah_list' => $this->MatakuliahModel->findAll(),
            'dosen_list' => $this->DosenModel->findAll(),
            'kelas_list' => $this->KelasModel->findAll(),
            'tahun_akademik_list' => $this->TahunakademikModel->findAll(),
            'semester_list' => $this->SemesterModel->findAll(),
            'ruang_list' => $this->RuangModel->findAll(),
            'rs_jadwal' => $this->PenjadwalanModel->getAllJadwal(), // Ambil data jadwal di sini
            // 'rs_tahun' => $this->TahunakademikModel->semua_tahun() 
            'rs_tahun' => $this->TahunakademikModel->findAll(),
            'semua_prodi' => $this->ProdiModel->semua_prodi() // Panggil findAll() di sini
        ];

        return view('penjadwalan', $data);
    }

    public function store()
    {

        $data = [
            'prodi_list' => $this->ProdiModel->findAll(),
            'pengampu_list' => $this->PengampuModel->getPengampuWithDetails(),
            'matakuliah_list' => $this->MatakuliahModel->findAll(),
            'dosen_list' => $this->DosenModel->findAll(),
            'kelas_list' => $this->KelasModel->findAll(),
            'tahun_akademik_list' => $this->TahunakademikModel->findAll(),
            'semester_list' => $this->SemesterModel->findAll(),
            'ruang_list' => $this->RuangModel->findAll(),
            'rs_jadwal' => $this->PenjadwalanModel->get(), // Ambil data jadwal di sini
            // 'rs_tahun' => $this->TahunakademikModel->semua_tahun() 
            'rs_tahun' => $this->TahunakademikModel->findAll(),
            'semua_prodi' => $this->ProdiModel->semua_prodi() // Panggil findAll() di sini
        ];

        $found = false;

        $jenis_semester = $this->request->getPost('tipe_semester');
        $prodi = $this->request->getPost('prodi');
        $tahun_akademik = $this->request->getPost('tahun_akademik');

        if ($this->request->getMethod() === 'POST') {

            $data['rs_tahun'] = $this->TahunakademikModel->findAll();

            $validation = \Config\Services::validation();
            $validation->setRules([
                'tipe_semester' => 'required',
                'tahun_akademik' => 'required',
                'jumlah_populasi' => 'required',
                'probabilitas_crossover' => 'required',
                'probabilitas_mutasi' => 'required',
                'jumlah_generasi' => 'required'
            ]);
            if (true) {
                $start = microtime(true);

                // Bismillahhhhhh
                $jumlah_populasi = $this->request->getPost('jumlah_populasi');
                $jenis_semester = $this->request->getPost('tipe_semester');
                $prodi = $this->request->getPost('prodi');
                $tahun_akademik = $this->request->getPost('tahun_akademik');
                $crossOver = $this->request->getPost('probabilitas_crossover');
                $mutasi = $this->request->getPost('probabilitas_mutasi');
                $jumlah_generasi = $this->request->getPost('jumlah_generasi');
                $rs_jadwal = $this->PenjadwalanModel->get();
                $rs_tahun = $this->TahunakademikModel->findAll();

                $data['semester_a'] = $this->request->getPost('tipe_semester') ?? false;
                $data['tahun_a'] = $this->request->getPost('tahun_akademik') ?? false; // atau default ke false jika tidak diatur
                $data['tahun_a'] = $this->request->getPost('tahun_akademik') ?? false; // atau default ke false jika tidak diatur
                $data['prodi'] = $this->request->getPost('prodi') ?? false; // atau default ke false jika tidak diatur

                // Menyimpan data yang dikirim
                $data['semester_a'] = $jenis_semester;
                $data['prodi'] = $prodi;
                $data['semua_prodi'] = $this->ProdiModel->findAll();
                $data['tahun_a'] = $tahun_akademik;
                $datas['tipe_semester'] = $jenis_semester;
                $datas['tahun_akademik'] = $tahun_akademik;
                $datas['probabilitas_crossover'] = $crossOver;
                $datas['probabilitas_mutasi'] = $mutasi;
                $datas['jumlah_generasi'] = $jumlah_generasi;

                // Query untuk mendapatkan data berdasarkan semester dan tahun akademik
                if ($prodi != 0) {
                    $rs_data = $this->db->query("SELECT a.id FROM pengampu a 
                    LEFT JOIN semester b ON a.semester = b.id
                    LEFT JOIN tahun_akademik c ON a.tahun_akademik = c.id
                    WHERE b.semester_tipe = ? AND a.tahun_akademik = ? AND a.id_prodi = ?", [$jenis_semester, $tahun_akademik, $prodi]);
                } else {
                    $rs_data = $this->db->query("SELECT a.id FROM pengampu a 
                        LEFT JOIN semester b ON a.semester = b.id
                        LEFT JOIN tahun_akademik c ON a.tahun_akademik = c.id
                        WHERE b.semester_tipe = :jenis_semester: AND a.tahun_akademik = :tahun_akademik:", [
                        'jenis_semester' => $jenis_semester,
                        'tahun_akademik' => $tahun_akademik
                    ]);
                }
                if ($rs_data->getNumRows() == 0) {
                    $data['msg'] = 'Tidak ada data dengan semester dan tahun akademik ini';
                } 
                
                elseif($rs_data->getNumRows() < 3){
                    $data['msg'] = 'Pengemapu Minimal 3 Data';
                }
                else {

                    $data_all_query = [];
                    $n = 0;
                    $found = false;

                    if ($rs_data->getNumRows() % 2 == 0) {
                        $jumlah_populasi = $rs_data->getNumRows();
                    } else {
                        $jumlah_populasi = $rs_data->getNumRows() + 1;
                    }

                    $banyak_populasi = intval($rs_data->getNumRows() / 2);

                    $e = 0;
                    $c = 0;
                    $this->db->query("TRUNCATE TABLE jadwalkuliah");

                    $data_fitness_all = [];
                    for ($f = 0; $f <= $banyak_populasi; $f++) {

                        $query = [$e, 2];

                        $mod = intval($rs_data->getNumRows() % 2);
                        $banyak_populasi = intval($rs_data->getNumRows() / 2);

                        if ($f == $banyak_populasi) {
                            $query = [$e, $mod];
                        }

                        $data_all_query[] = $query;

                        $this->AmbilData($jenis_semester, $tahun_akademik, $jumlah_populasi, $prodi, $query, $e, $mod);
                        $this->Inisialisasi($jumlah_populasi);

                        if ($this->kap == false) {
                            $this->db->table('jadwalkuliah')->truncate();
                            break;
                        }

                        $found = false;

                        for ($i = 0; $i < $jumlah_generasi; $i++) {
                            $fitness = $this->Hitungfitness($jumlah_populasi, $prodi);

                            $this->Seleksi($fitness, $jumlah_populasi);
                            $this->StartCrossOver($jumlah_populasi, $crossOver);

                            $fitnessAfterMutation = $this->Mutasi($jumlah_populasi, $mutasi, $prodi);
                            for ($j = 0; $j < count($fitnessAfterMutation); $j++) {
                                if ($fitnessAfterMutation[$j] == 1) {
                                    $jadwal_kuliah = [[]];
                                    $jadwal_kuliah = $this->GetIndividu($j);

                                    foreach ($jadwal_kuliah as $row) {

                                        $data = [
                                            'id_pengampu' => intval($row[0]),
                                            'id_jam' => intval($row[1]),
                                            'id_hari' => intval($row[2]),
                                            'id_ruang' => intval($row[3])
                                        ];
                                        $data_fitness_all[] = ['j' => $j, 'data' => [
                                            'id_pengampu' => intval($row[0]),
                                            'id_jam' => intval($row[1]),
                                            'id_hari' => intval($row[2]),
                                            'id_ruang' => intval($row[3])
                                        ]];

                                        $this->db->table('jadwalkuliah')->insert($data);


                                    }
                                    
                                    $found = true;
                                    $this->kap = true;
                                }

                                if ($found) {
                                    break;
                                }
                            }

                            if ($found) {
                                break;
                            }
                        }

                        $e += 2;
                        $c++;
                    }

                    if ($this->kap == false) {
                        $d = $this->PenjadwalanModel->detail_pengampu($this->id_pengampu);
                        $data['msg'] = 'Tidak ada kapasitas ruangan yang sesuai dengan kuota matakuliah ' . $d[0]['nama_mk'] . ' kelas ' . $d[0]['nama_kelas'];
                    } elseif (!$found) {
                        $data['msg'] = 'Tidak ditemukan solusi optimal';
                    } else {
                        // $this->db->query("DELETE FROM jadwalkuliah WHERE id IN (SELECT id FROM (SELECT min(id) FROM jadwalkuliah GROUP BY id_pengampu HAVING COUNT(*) > 1) AS A)");

                        $finish = microtime(true);
                        $total_time = $finish - $start;
                        $total_menit = round(($total_time / 60), 4);
                        $data['waktu'] = "Selesai dalam " . $total_menit . " menit";
                    }
                }
            } else {
                $data['msg'] = $validation->getErrors();
                return view('penjadwalan', $data);
            }
        }
        // Data yang dikirimkan ke view
        $data['page_name'] = 'penjadwalan';
        $data['rs_tahun'] = $this->TahunakademikModel->findAll();
        $data['rs_jadwal'] = $this->PenjadwalanModel->get();
        $data['tahun_awal'] = $this->TahunakademikModel->tahun_awal(1);
        return view('penjadwalan', $data);
    }

    public function AmbilData($jenis_semester, $tahun_akademik, $jumlah_populasi, $prodi, $query, $e, $mod)
    {
        $this->jenis_semester = $jenis_semester;
        $this->tahun_akademik = $tahun_akademik;
        $this->populasi = $jumlah_populasi;

        // Ambil nilai dari array $query
        $queryOffset = $query[0]; // Offset
        $queryLimit = $query[1];

        if ($prodi) {
            $rs_data = $this->db->query("
                SELECT a.id, b.jumlah_jam, a.id_dosen, a.id_prodi, a.kelas, a.id_ruang, a.kuota, a.semester as id_sem, b.jenis, c.id as id_kelas, c.nama_kelas, d.id as id_prod, d.nama_prodi, d.id_jurusan, e.id as id_semester, e.nama_semester, f.status_dosen, g.status 
                FROM pengampu a 
                LEFT JOIN matakuliah b ON a.id_mk = b.id 
                LEFT JOIN kelas c ON a.kelas = c.id 
                LEFT JOIN prodi d ON a.id_prodi = d.id 
                LEFT JOIN semester e ON a.semester = e.id 
                LEFT JOIN dosen f ON a.id_dosen = f.id 
                LEFT JOIN status_dosen g ON f.status_dosen = g.id 
                WHERE b.semester = ? 
                AND a.tahun_akademik = ? AND a.id_prodi = ? 
                ORDER BY a.id 
                LIMIT ? OFFSET ?
            ", [$this->jenis_semester, $this->tahun_akademik, $prodi, $queryLimit, $queryOffset]);
        } else {
            $rs_data = $this->db->query("
                SELECT a.id, b.jumlah_jam, a.id_dosen, a.id_prodi, a.kelas, a.id_ruang, a.kuota, a.semester as id_sem, b.jenis, c.id as id_kelas, c.nama_kelas, d.id as id_prod, d.nama_prodi, d.id_jurusan, e.id as id_semester, e.nama_semester, f.status_dosen, g.status 
                FROM pengampu a 
                LEFT JOIN matakuliah b ON a.id_mk = b.id 
                LEFT JOIN kelas c ON a.kelas = c.id 
                LEFT JOIN prodi d ON a.id_prodi = d.id 
                LEFT JOIN semester e ON a.semester = e.id 
                LEFT JOIN dosen f ON a.id_dosen = f.id 
                LEFT JOIN status_dosen g ON f.status_dosen = g.id 
                WHERE b.semester = ? 
                AND a.tahun_akademik = ? 
                ORDER BY a.id 
                LIMIT ? OFFSET ?
            ", [$this->jenis_semester, $this->tahun_akademik, $queryLimit, $queryOffset]);
        }

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
            $this->jurusan[$i] = intval($data->id_jurusan);
            $i++;
        }

        // Fill Array of Jam Variables
        $rs_jam1 = $this->db->query("SELECT * FROM jam2 WHERE sks='1'");
        $b = 0;
        foreach ($rs_jam1->getResult() as $data) {
            $this->jam1[$b] = intval($data->id);
            $this->sesi1[$b] = intval($data->sesi);
            $b++;
        }

        $rs_jam2 = $this->db->query("SELECT * FROM jam2 WHERE sks='2'");
        $b = 0;
        foreach ($rs_jam2->getResult() as $data) {
            $this->jam2[$b] = intval($data->id);
            $this->sesi2[$b] = intval($data->sesi);
            $b++;
        }

        $rs_jam3 = $this->db->query("SELECT * FROM jam2 WHERE sks='3'");
        $b = 0;
        foreach ($rs_jam3->getResult() as $data) {
            $this->jam3[$b] = intval($data->id);
            $this->sesi3[$b] = intval($data->sesi);
            $b++;
        }

        $rs_jam4 = $this->db->query("SELECT * FROM jam2 WHERE sks='4'");
        $b = 0;
        foreach ($rs_jam4->getResult() as $data) {
            $this->jam4[$b] = intval($data->id);
            $this->sesi4[$b] = intval($data->sesi);
            $b++;
        }

        // Fill Array of Hari Variables
        $rs_hari = $this->db->query("SELECT id FROM hari");
        $i = 0;
        foreach ($rs_hari->getResult() as $data) {
            $this->hari[$i] = intval($data->id);
            $i++;
        }

        // Fill Array of Waktu dosen
        $rs_Waktudosen = $this->db->query("SELECT a.id_dosen, CONCAT_WS(':', a.id_hari, b.sesi) as id_hari_jam 
            FROM waktu_tidak_bersedia a 
            LEFT JOIN jam2 b ON a.id_jam = b.id");
        $i = 0;
        foreach ($rs_Waktudosen->getResult() as $data) {
            $this->idosen[$i] = intval($data->id_dosen);
            $this->waktu_dosen[$i][0] = intval($data->id_dosen);
            $this->waktu_dosen[$i][1] = $data->id_hari_jam;
            $i++;
        }

        // Fill Array of Waktu Tersedia
        if ($prodi) {
            $rs_Waktutersedia = $this->db->query("SELECT a.id, a.id_pengampu, b.id, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.id_dosen) as id_hari_ruang, c.id, c.semester_tipe 
                FROM riwayat_penjadwalan a 
                LEFT JOIN pengampu b ON a.id_pengampu = b.id 
                LEFT JOIN semester c ON b.semester = c.id 
                LEFT JOIN jam2 d ON a.id_jam = d.id 
                WHERE c.semester_tipe = '$this->jenis_semester' 
                AND b.tahun_akademik = '$this->tahun_akademik' AND b.id_prodi != '$prodi'");
            $i = 0;
            foreach ($rs_Waktutersedia->getResult() as $data) {
                $this->itersedia[$i] = intval($data->id_dosen);
                $this->itersediaa[$i] = $data->id_dosen;
                $this->waktu_tersedia[$i][0] = intval($data->id_dosen);
                $this->waktu_tersedia[$i][1] = $data->id_hari_ruang;
                $i++;
            }
        }

        // Fill Array of Waktu Tersimpan
        if ($prodi) {
            $rs_Waktutersimpan = $this->db->query("SELECT a.id, a.id_pengampu, b.id, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.semester, b.kelas, b.id_dosen, b.id_prodi) as id_hari_ruang, c.id, c.semester_tipe 
                FROM jadwalkuliah a 
                LEFT JOIN pengampu b ON a.id_pengampu = b.id 
                LEFT JOIN semester c ON b.semester = c.id 
                LEFT JOIN jam2 d ON a.id_jam = d.id 
                WHERE c.semester_tipe = '$this->jenis_semester' 
                AND b.tahun_akademik = '$this->tahun_akademik' AND b.id_prodi = '$prodi'");
            $i = 0;
            foreach ($rs_Waktutersimpan->getResult() as $data) {
                $this->itersimpan[$i] = intval($data->id_dosen);
                $this->itersimpann[$i] = $data->id_dosen;
                $this->waktu_tersimpan[$i][0] = intval($data->id_dosen);
                $this->waktu_tersimpan[$i][1] = $data->id_hari_ruang;
                $i++;
            }
        } else {
            $rs_Waktutersimpan = $this->db->query("SELECT a.id, a.id_pengampu, b.id, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.semester, b.kelas, b.id_dosen, b.id_prodi) as id_hari_ruang, c.id, c.semester_tipe 
                FROM jadwalkuliah a 
                LEFT JOIN pengampu b ON a.id_pengampu = b.id 
                LEFT JOIN semester c ON b.semester = c.id 
                LEFT JOIN jam2 d ON a.id_jam = d.id 
                WHERE c.semester_tipe = '$this->jenis_semester' 
                AND b.tahun_akademik = '$this->tahun_akademik'");
            $i = 0;
            foreach ($rs_Waktutersimpan->getResult() as $data) {
                $this->itersimpan[$i] = intval($data->id_dosen);
                $this->itersimpann[$i] = $data->id_dosen;
                $this->waktu_tersimpan[$i][0] = intval($data->id_dosen);
                $this->waktu_tersimpan[$i][1] = $data->id_hari_ruang;
                $i++;
            }
        }
    }

    public function Inisialisasi($jumlah_populasi)
    {
        $this->populasi = $jumlah_populasi;
        $jumlah_pengampu = count($this->pengampu);
        $jumlah_hari = count($this->hari);

        for ($i = 0; $i < $this->populasi; $i++) {
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                $sks = $this->sks[$j];
                $this->individu[$i][$j][0] = $j;

                // Pilih jam berdasarkan SKS
                if ($sks == 1) {
                    $jumlah_jam = count($this->jam1);
                    $this->individu[$i][$j][1] = intval($this->jam1[mt_rand(0, $jumlah_jam - 1)]);
                } elseif ($sks == 2) {
                    $jumlah_jam = count($this->jam2);
                    $this->individu[$i][$j][1] = intval($this->jam2[mt_rand(0, $jumlah_jam - 1)]);
                } elseif ($sks == 3) {
                    $jumlah_jam = count($this->jam3);
                    $this->individu[$i][$j][1] = intval($this->jam3[mt_rand(0, $jumlah_jam - 1)]);
                } elseif ($sks == 4) {
                    $jumlah_jam = count($this->jam4);
                    $this->individu[$i][$j][1] = intval($this->jam4[mt_rand(0, $jumlah_jam - 1)]);
                }

                $this->individu[$i][$j][2] = mt_rand(0, $jumlah_hari - 1);

                $jurusan = intval($this->jurusan[$j]);
                $kuota = intval($this->kuota_pengampu[$j]);

                if ($this->jenis_mk[$j] === $this->TEORI) {
                    $rs_RuangReguler = $this->db->query("SELECT id, kapasitas 
                        FROM ruang 
                        WHERE jenis = '$this->TEORI' AND id_prodi = '$jurusan' AND kapasitas >= '$kuota'");
                    if ($rs_RuangReguler->getNumRows() == 0) {
                        log_message('error', 'Tidak ada ruangan teori yang sesuai untuk pengampu ID: ' . $this->pengampu[$j]);
                        $this->kap = false;
                        $this->id_pengampu = $this->pengampu[$j];
                        break;
                    }
                    $ruangReguler = [];
                    foreach ($rs_RuangReguler->getResult() as $data) {
                        $ruangReguler[] = intval($data->id);
                    }
                    $this->individu[$i][$j][3] = $ruangReguler[mt_rand(0, count($ruangReguler) - 1)];
                } elseif ($this->jenis_mk[$j] === $this->PRAKTIKUM) {
                    $rs_RuangLaboratorium = $this->db->query("SELECT id, kapasitas 
                        FROM ruang 
                        WHERE jenis = 'LABORATORIUM' AND id_prodi = '$jurusan' AND kapasitas >= '$kuota'");
                    if ($rs_RuangLaboratorium->getNumRows() == 0) {
                        log_message('error', 'Tidak ada ruangan laboratorium yang sesuai untuk pengampu ID: ' . $this->pengampu[$j]);
                        $this->kap = false;
                        $this->id_pengampu = $this->pengampu[$j];
                        break;
                    }
                    $ruangLaboratorium = [];
                    foreach ($rs_RuangLaboratorium->getResult() as $data) {
                        $ruangLaboratorium[] = intval($data->id);
                    }
                    $this->individu[$i][$j][3] = $ruangLaboratorium[mt_rand(0, count($ruangLaboratorium) - 1)];
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

    public function CekFitness($indv, $prodi)
    {
        $this->id_jumat = 5;
        $this->range_jumat = explode('-', '6-7');
        $this->id_dhuhur = 6;
        $penalty = 0;
        $jumlah_pengampu = count($this->pengampu);

        for ($i = 0; $i < $jumlah_pengampu; $i++) {
            $sks = intval($this->sks[$i]);

            $jam_a = intval($this->individu[$indv][$i][1]);
            $hari_a = intval($this->individu[$indv][$i][2]);
            $ruang_a = intval($this->individu[$indv][$i][3]);

            $dosen_a = intval($this->dosen[$i]);
            $kuota = intval($this->kuota_pengampu[$i]);
            $semester_a = intval($this->semester[$i]);
            $kelas_a = intval($this->kelas[$i]);
            $prodi_a = intval($this->prodi[$i]);
            $jurusan = intval($this->jurusan[$i]);

            $rs_jam1 = $this->db->query("SELECT * FROM jam2 WHERE id = '$jam_a'");
            $data = $rs_jam1->getRow();
            $sesiJam_a = $data->sesi;

            if ($sks == 2 || $sks == 3 || $sks == 4) {
                if (($hari_a + 1) != $this->id_jumat) {
                    if ($sesiJam_a == 5) {
                        $q_jam1 = $this->db->query("SELECT * FROM jam2 WHERE sks = '$sks' AND sesi = '3'");
                        $q = $q_jam1->getRow();
                        $this->individu[$indv][$i][1] = $q->id;
                        $sesiJam_a = 3;
                    }
                    if ($sesiJam_a == 6) {
                        $q_jam1 = $this->db->query("SELECT * FROM jam2 WHERE sks = '$sks' AND sesi = '4'");
                        $q = $q_jam1->getRow();
                        $this->individu[$indv][$i][1] = $q->id;
                        $sesiJam_a = 4;
                    }
                }
            }

            if (($hari_a + 1) == $this->id_jumat) {
                if ($sesiJam_a == 3) {
                    $q_jam1 = $this->db->query("SELECT * FROM jam2 WHERE sks = '$sks' AND sesi = '1'");
                    $q = $q_jam1->getRow();
                    $this->individu[$indv][$i][1] = $q->id;
                    $sesiJam_a = 1;
                }
                if ($sesiJam_a == 4) {
                    if ($sks == 3) {
                        $q_jam1 = $this->db->query("SELECT * FROM jam2 WHERE sks = '$sks' AND sesi = '1'");
                        $q = $q_jam1->getRow();
                        $this->individu[$indv][$i][1] = $q->id;
                        $sesiJam_a = 1;
                    } else {
                        $q_jam1 = $this->db->query("SELECT * FROM jam2 WHERE sks = '$sks' AND sesi = '2'");
                        $q = $q_jam1->getRow();
                        $this->individu[$indv][$i][1] = $q->id;
                        $sesiJam_a = 2;
                    }
                }
                if ($sesiJam_a == 2) {
                    if ($sks == 3) {
                        $q_jam1 = $this->db->query("SELECT * FROM jam2 WHERE sks = '$sks' AND sesi = '1'");
                        $q = $q_jam1->getRow();
                        $this->individu[$indv][$i][1] = $q->id;
                        $sesiJam_a = 1;
                    }
                }
            }

            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                $jam_b = intval($this->individu[$indv][$j][1]);
                $hari_b = intval($this->individu[$indv][$j][2]);
                $ruang_b = intval($this->individu[$indv][$j][3]);

                $dosen_b = intval($this->dosen[$j]);
                $semester_b = intval($this->semester[$j]);
                $kelas_b = intval($this->kelas[$j]);
                $prodi_b = intval($this->prodi[$j]);

                $rs_jam2 = $this->db->query("SELECT * FROM jam2 WHERE id = '$jam_b'");
                $data1 = $rs_jam2->getRow();
                $sesiJam_b = $data1->sesi;

                if ($i == $j) continue;

                if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4) {
                    if ($sesiJam_a == $sesiJam_b && $hari_a == $hari_b && $ruang_a == $ruang_b) {
                        $penalty += 1;
                    }
                }

                if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4) {
                    if ($prodi_a == $prodi_b && $sesiJam_a == $sesiJam_b && $hari_a == $hari_b && $kelas_a == $kelas_b && $semester_a == $semester_b) {
                        $penalty += 1;
                    }
                }

                if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4) {
                    if ($sesiJam_a == $sesiJam_b && $hari_a == $hari_b && $dosen_a == $dosen_b) {
                        $penalty += 1;
                    }
                }
            }

            $jumlah_waktu_tidak_bersedia = count($this->idosen);
            for ($j = 0; $j < $jumlah_waktu_tidak_bersedia; $j++) {
                if ($dosen_a == $this->idosen[$j]) {
                    $hari_jam = explode(':', $this->waktu_dosen[$j][1]);

                    if ($sesiJam_a == $hari_jam[1] && $this->hari[$hari_a] == $hari_jam[0]) {
                        $penalty += 1;
                    }
                }
            }

            if ($prodi) {
                $jumlah_waktu_tersedia = count($this->itersedia);
                for ($j = 0; $j < $jumlah_waktu_tersedia; $j++) {
                    $hari_ruang = explode(':', $this->waktu_tersedia[$j][1]);

                    if ($dosen_a == $hari_ruang[3] && $this->hari[$hari_a] == $hari_ruang[0] && $sesiJam_a == $hari_ruang[1]) {
                        $penalty += 1;
                    }

                    if ($this->hari[$hari_a] == $hari_ruang[0] && $ruang_a == $hari_ruang[2]) {
                        if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3) {
                            if ($sesiJam_a == $hari_ruang[1]) {
                                $penalty += 1;
                            }
                        }
                    }
                }
            }

            $jumlah_waktu_tersimpan = count($this->itersimpan);
            for ($j = 0; $j < $jumlah_waktu_tersimpan; $j++) {
                $hari_ruang = explode(':', $this->waktu_tersimpan[$j][1]);

                if ($dosen_a == $hari_ruang[5] && $this->hari[$hari_a] == $hari_ruang[0] && $sesiJam_a == $hari_ruang[1]) {
                    $penalty += 1;
                }

                if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3) {
                    if ($prodi_a == $hari_ruang[6] && $sesiJam_a == $hari_ruang[1] && $this->hari[$hari_a] == $hari_ruang[0] && $kelas_a == $hari_ruang[4] && $semester_a == $hari_ruang[3]) {
                        $penalty += 1;
                    }
                }

                if ($this->hari[$hari_a] == $hari_ruang[0] && $ruang_a == $hari_ruang[2]) {
                    if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3) {
                        if ($sesiJam_a == $hari_ruang[1]) {
                            $penalty += 1;
                        }
                    }
                }
            }
        }

        $fitness = floatval(1 / (1 + $penalty));
        return $fitness;
    }

    public function Seleksi($fitness, $jumlah_populasi)
    {
        $this->populasi = $jumlah_populasi;
        $jumlah = 0;
        $rank = [];

        for ($i = 0; $i < $this->populasi; $i++) {
            $rank[$i] = 1;
            for ($j = 0; $j < $this->populasi; $j++) {
                $fitnessA = floatval($fitness[$i]);
                $fitnessB = floatval($fitness[$j]);

                if ($fitnessA > $fitnessB) {
                    $rank[$i] += 1;
                }
            }

            $jumlah += $rank[$i];
        }

        $jumlah_rank = count($rank);
        for ($i = 0; $i < $this->populasi; $i++) {
            $target = mt_rand(0, $jumlah - 1);
            $cek = 0;

            for ($j = 0; $j < $jumlah_rank; $j++) {
                $cek += $rank[$j];
                if (intval($cek) >= intval($target)) {
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }

    public function StartCrossOver($jumlah_populasi, $crossOver)
    {
        $this->populasi = $jumlah_populasi;
        $this->crossOver = $crossOver;
        $individu_baru = [];
        $jumlah_pengampu = count($this->pengampu);

        for ($i = 0; $i < $this->populasi; $i += 2) {
            $b = 0;
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();

            if (floatval($cr) < floatval($this->crossOver)) {
                $a = mt_rand(0, $jumlah_pengampu - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, $jumlah_pengampu - 1);
                }

                for ($j = 0; $j < $a; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }

                for ($j = $a; $j < $b; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                    }
                }

                for ($j = $b; $j < $jumlah_pengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else {
                for ($j = 0; $j < $jumlah_pengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }

        for ($i = 0; $i < $this->populasi; $i += 2) {
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                for ($k = 0; $k < 4; $k++) {
                    $this->individu[$i][$j][$k] = $individu_baru[$i][$j][$k];
                    $this->individu[$i + 1][$j][$k] = $individu_baru[$i + 1][$j][$k];
                }
            }
        }

        return $individu_baru;
    }

    public function Mutasi($jumlah_populasi, $mutasi, $prodi)
    {
        $this->populasi = $jumlah_populasi;
        $this->mutasi = $mutasi;
        $fitness = [];

        $r = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        $jumlah_pengampu = count($this->pengampu);
        $jumlah_hari = count($this->hari);

        for ($i = 0; $i < $this->populasi; $i++) {
            if ($r < $this->mutasi) {
                $krom = mt_rand(0, $jumlah_pengampu - 1);
                $j = intval($this->sks[$krom]);

                switch ($j) {
                    case 1:
                        $jumlah_jam = count($this->jam1);
                        $this->individu[$i][$krom][1] = $this->jam1[mt_rand(0, $jumlah_jam - 1)];
                        break;
                    case 2:
                        $jumlah_jam = count($this->jam2);
                        $this->individu[$i][$krom][1] = $this->jam2[mt_rand(0, $jumlah_jam - 1)];
                        break;
                    case 3:
                        $jumlah_jam = count($this->jam3);
                        $this->individu[$i][$krom][1] = $this->jam3[mt_rand(0, $jumlah_jam - 1)];
                        break;
                    case 4:
                        $jumlah_jam = count($this->jam4);
                        $this->individu[$i][$krom][1] = $this->jam4[mt_rand(0, $jumlah_jam - 1)];
                        break;
                }

                $this->individu[$i][$krom][2] = mt_rand(0, $jumlah_hari - 1);

                $jurusan = intval($this->jurusan[$krom]);
                $kuota = intval($this->kuota_pengampu[$krom]);

                if ($this->jenis_mk[$krom] === $this->TEORI) {
                    $this->ruangReguler = []; // Inisialisasi sebagai array kosong
                    $rs_RuangReguler = $this->db->query("SELECT id, kapasitas 
                        FROM ruang 
                        WHERE jenis = '$this->TEORI' AND id_prodi = '$jurusan' AND kapasitas >= '$kuota' AND lantai = '1'");
                    if ($rs_RuangReguler->getNumRows() > 0) {
                        foreach ($rs_RuangReguler->getResult() as $data) {
                            $this->ruangReguler[] = intval($data->id);
                        }
                    }
                    if (!empty($this->ruangReguler)) {
                        $jumlah_ruang_reguler = count($this->ruangReguler);
                        $this->individu[$i][$krom][3] = intval($this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)]);
                    } else {
                        $this->kap = false;
                        $this->id_pengampu = $this->pengampu[$krom];
                        break;
                    }
                } elseif ($this->jenis_mk[$krom] === $this->PRAKTIKUM) {
                    $this->ruangLaboratorium = []; // Inisialisasi sebagai array kosong
                    $rs_RuangLaboratorium = $this->db->query("SELECT id, kapasitas 
                        FROM ruang 
                        WHERE jenis = 'LABORATORIUM' AND id_prodi = '$jurusan' AND kapasitas >= '$kuota'");
                    if ($rs_RuangLaboratorium->getNumRows() > 0) {
                        foreach ($rs_RuangLaboratorium->getResult() as $data) {
                            $this->ruangLaboratorium[] = intval($data->id);
                        }
                    }
                    if (!empty($this->ruangLaboratorium)) {
                        $jumlah_ruang_lab = count($this->ruangLaboratorium);
                        $this->individu[$i][$krom][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);
                    } else {
                        $this->kap = false;
                        $this->id_pengampu = $this->pengampu[$krom];
                        break;
                    }
                }
            }

            $fitness[$i] = $this->CekFitness($i, $prodi);
        }

        return $fitness;
    }

    public function GetIndividu($indv)
    {
        $individu_solusi = [];

        for ($j = 0; $j < count($this->pengampu); $j++) {
            $individu_solusi[$j][0] = intval($this->pengampu[$this->individu[$indv][$j][0]]);
            $individu_solusi[$j][1] = intval($this->individu[$indv][$j][1]);
            $individu_solusi[$j][2] = intval($this->hari[$this->individu[$indv][$j][2]]);
            $individu_solusi[$j][3] = intval($this->individu[$indv][$j][3]);
        }

        return $individu_solusi;
    }

    // public function excel_report()
    // {
    //     $query = $this->PenjadwalanModel->get();
    //     if (!$query) {
    //         return false;
    //     }

    //     $this->load->library('PHPExcel');
    //     $this->load->library('PHPExcel/IOFactory');

    //     $objPHPExcel = new PHPExcel();
    //     $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

    //     $objPHPExcel->setActiveSheetIndex(0);

    //     $fields = ["hari", "ruang", "jam_kuliah", "nama_mk", "dosen", "nama_kelas", "nama_semester", "nama_prodi", "kuota"];
    //     $col = 0;
    //     foreach ($fields as $field) {
    //         $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
    //         $col++;
    //     }

    //     $row = 2;
    //     foreach ($query->getResult() as $data) {
    //         $col = 0;
    //         foreach ($fields as $field) {
    //             $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
    //             $col++;
    //         }

    //         $row++;
    //     }

    //     $objPHPExcel->setActiveSheetIndex(0);

    //     $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="Products_' . date('dMy') . '.xls"');
    //     header('Cache-Control: max-age=0');

    //     $objWriter->save('php://output');
    // }

    
    public function simpan_jadwal()
    {
        // Mulai transaksi database
        $this->db->transStart();

        try {
            // Ambil data jadwal dari tabel jadwalkuliah yang valid
            $query = $this->db->table('jadwalkuliah j')
                ->select('j.id_pengampu, j.id_jam, j.id_hari, j.id_ruang')
                ->join('hari h', 'h.id = j.id_hari', 'inner')
                ->join('jam m', 'm.id = j.id_jam', 'inner')
                ->get();

            $jadwal = $query->getResultArray();

            // Pastikan ada data yang valid
            if (!empty($jadwal)) {
                foreach ($jadwal as $j) {
                    $id_pengampu = $j['id_pengampu'];
                    $id_jam = $j['id_jam'];
                    $id_hari = $j['id_hari'];
                    $id_ruang = $j['id_ruang'];

                    // Simpan ke riwayat_penjadwalan
                    $simpan = $this->PenjadwalanModel->simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang);
                }

                // Commit transaksi jika semua operasi berhasil
                $this->db->transCommit();

                // Set session flash data untuk pesan sukses
                $this->session->setFlashdata('success', 'Data jadwal berhasil disimpan.');

                // Redirect ke laman penjadwalan
                return redirect()->to('/penjadwalan');
            } else {
                // Rollback transaksi jika tidak ada data yang valid
                $this->db->transRollback();

                // Set session flash data untuk pesan error
                $this->session->setFlashdata('error', 'Tidak ada data jadwal yang valid.');

                // Redirect ke laman penjadwalan
                return redirect()->to('/penjadwalan');
            }
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi error
            $this->db->transRollback();

            // Log error
            log_message('error', 'Error saat menyimpan jadwal: ' . $e->getMessage());

            // Set session flash data untuk pesan error
            $this->session->setFlashdata('error', 'Terjadi kesalahan saat menyimpan jadwal.');

            // Redirect ke laman penjadwalan
            return redirect()->to('/penjadwalan');
        }
    }

    public function hapus_jadwal()
    {
        $this->db->query("TRUNCATE TABLE jadwalkuliah");
        $data['rs_tahun'] = $this->TahunakademikModel->semua_tahun();
        $data['hapus'] = "Berhasil menghapus jadwal";
        $data['rs_jadwal'] = $this->PenjadwalanModel->get();

        return view('penjadwalan', $data) ;
    }
}