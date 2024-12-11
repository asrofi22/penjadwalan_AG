<?php 

namespace App\Controllers;

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

class Penjadwalan extends BaseController {
    
    private $TEORI = 'TEORI';
    private $NORMAL = 'NORMAL';
    private $LABORATORIUM = 'LABORATORIUM';
    private $PRAKTIKUM = 'PRAKTIKUM';

    private $kap = true;
    private $id_pengampu;
    private $jenis_semester;
    private $tahun_akademik;
    private $populasi;
    private $crossOver;
    private $mutasi;

    private $pengampu = array();
    private $individu = array(array(array()));
    private $sks = array();
    private $dosen = array();
    private $status = array();
    private $status_dosen = array();
    private $prodi = array();
    private $kuota_pengampu = array();
    private $kelas = array();
    private $ruang_pilihan = array();
    private $semester = array();

    private $jam1 = array();
    private $jam2 = array();
    private $jam3 = array();
    private $jam4 = array();
    private $sesi1 = array();
    private $sesi2 = array();
    private $sesi3 = array();
    private $sesi4 = array();
    private $hari = array();
    private $idosen = array();
    private $itersimpan = array();
    private $itersimpann = array();
    private $itersedia = array();
    private $itersediaa = array();


    // Waktu keinginan dosen
    private $waktu_dosen = array(array());
    private $waktu_tersedia = array(array());
    private $waktu_tersimpan = array(array());
    private $jenis_mk = array(); //teori atau praktikum

    private $kuota_ruangReguler = array();
    private $kuota_ruangLaboratorium = array();
    private $ruangLaboratorium = array();
    private $ruangReguler = array();
    private $logAmbilData;
    private $logInisialisasi;

    private $induk = array();

    // jumat
    private $kode_jumat;
    private $range_jumat = array();
    private $kode_dhuhur;
    private $is_waktu_dosen_tidak_bersedia_empty;

    protected $session;
    protected $form_validation;
    protected $db;
    protected $pagination;
    protected $helpers = ['url', 'download', 'security', 'date'];

    // Menyimpan objek model
    protected $JamModel;
    protected $WaktutidakbersediaModel;
    protected $KelasModel;
    protected $ProdiModel;
    protected $SemesterModel;
    protected $PenjadwalanModel;
    protected $PengampuModel;
    protected $TahunakademikModel;
    protected $DosenModel;
    protected $HariModel;
    protected $UserModel;
    protected $MatakuliahModel;
    protected $RiwayatpenjadwalanModel;
    protected $RuangModel;

    public function __construct()
    {
        // Memuat pustaka, helper, dan model di CI4
        $this->session = session(); // Mendapatkan session dari CI4
        $this->form_validation = \Config\Services::validation(); // Form validation di CI4
        $this->db = \Config\Database::connect(); // Mengakses database
        $this->pagination = \Config\Services::pagination(); // Mengakses pagination

        // Memuat model
        $this->JamModel = new JamModel();
        $this->WaktutidakbersediaModel = new WaktutidakbersediaModel();
        $this->KelasModel = new KelasModel();
        $this->ProdiModel = new ProdiModel();
        $this->SemesterModel = new SemesterModel();
        $this->PenjadwalanModel = new PenjadwalanModel();
        $this->PengampuModel = new PengampuModel();
        $this->TahunakademikModel = new TahunakademikModel();
        $this->DosenModel = new DosenModel();
        $this->HariModel = new HariModel();
        $this->MatakuliahModel = new MatakuliahModel();
        $this->RiwayatpenjadwalanModel = new RiwayatpenjadwalanModel();
        $this->RuangModel = new RuangModel();
        
        // Mengatur variabel konstan
        define('IS_TEST', 'FALSE');
    }

    public function index() 
    {
        // Menggunakan session() untuk mengakses sesssion di CI4
        $session = session();

        if (!$session->get('logged_in')) {
            return redirect()->to('admin');
        }

        $data = array();
        $userModel = new UserModel();
        $user = $userModel->find($session->get('user_id'));

        if (!empty($_POST)) {
            $this->validate([
                'tipe_semester' => 'required',
                'tahun_akademik' => 'required',
                'jumlah_populasi' => 'required',
                'probabilitas_crossover' => 'required',
                'probabilitas_mutasi' => 'required',
                'jumlah_generasi' => 'required'
            ]);

            if($this->form_validation->run() === true){
                $start = microtime(true);

                // Bismillah, one step closer to getting S.Kom(edi).  SEMANGATTTTTTTTTTTTTTTTTTTTTTTT

                $jenis_semester = $this->request->getPost('tipe_semester');
                $prodi = $this->request->getPost('prodi');
                $tahun_akademik = $this->request->getPost('tahun_akademik');
                $crossOver = $this->request->getPost('probabilitas_crossover');
                $mutasi = $this->request->getPost('probabilitas_mutasi');
                $jumlah_generasi = $this->request->getPost('jumlah_generasi');
 
                // Menyimpan data yang dikirim
                $data['semester_a'] = $jenis_semester;
                $data['tahun_a'] = $tahun_akademik;
                $data['prodi'] = $prodi;

                // Query untuk mendapatkan data berdasarkan semester dan tahun akademik
                if($prodi) {
                    $rs_data = $this->db->query("SELECT a.id FROM pengampu a 
                    LEFT JOIN semester b ON a.semester = b.id
                    LEFT JOIN tahun_akademik c ON a.tahun_akademik = c.id
                    WHERE b.tipe_semester = ? AND a.tahun_akademik = ? AND a.id_prodi = ?", [$jenis_semester, $tahun_akademik, $prodi]);
                } else {
                    $rs_data = $this->db->query("SELECT a.id FROM pengampu a 
                    LEFT JOIN semester b ON a.semester = b.id
                    LEFT JOIN tahun_akademik c ON a.tahun_akademik = c.id
                    WHERE b.tipe_semester = ? AND a.tahun_akademik = ?", [$jenis_semester, $tahun_akademik]);
                }

                // Mengecek apakkah data  ditemukan
                if ($rs_data->getNumRows() == 0) {
                    $data['msg'] = 'Tidak ada data dengan semester dan tahun akademik ini';
                } else {
                    $n = 0;

                    // Menghitung jumlah populasi
                    $jumlah_populasi = ($rs_data->getNumRows() % 2 == 0) ? $rs_data->getNumRows() : $rs_data->getNumRows() + 1;
                    $banyak_populasi = intval($rs_data->getNumRows() / 2);

                    $e = 0;
                    $c = 0;

                    // Truncate tabel jadwalkuliah
                    $this->db->table('jadwalkuliah')->truncate();

                    for($f = 0; $f <= $banyak_populasi; $f++) {
                        $mod = intval($rs_data->getNumRows() % 2);
                        $query = "asc llimit $e,2";
                        if ($f == $banyak_populasi){
                            $query = "asc limit $e,$mod";
                        }

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
                                            'id_ruang' =>intval($row[3])
                                        ];
                                    }
                                    $this->db->table('jadwalkuliah')->insert($data);
                                }

                                $found = true;
                                $this->kap = true;
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
                    $data['msg'] = 'Tidak ada kapasitas ruangan yang sesuai dengan kuota matakuliah ' . $d->nama_mk . ' kelas ' . $d->nama_kelas;
                } elseif (!$found) {
                    $data['msg'] = 'Tidak ditemukan solusi optimal';
                } else {
                    $this->db->query("DELETE FROM jadwalkuliah WHERE id IN (SELECT * FROM (SELECT id FROM jadwalkuliah GROUP BY id_pengampu HAVING COUNT(*) > 1) AS A)");

                    $finish = microtime(true);
                    $total_time = $finish - $start;
                    $total_menit = round(($total_time / 60), 4);
                    $data['waktu'] = "Selesai dalam " . $total_menit . " menit";
                }
            } else {
                $data['msg'] = validation_errors();
            }
        }

        // Data yang dikirimkan ke view
        $data['page_name'] = 'penjadwalan';
        $data['page_title'] = 'Penjadwalan';
        $data['rs_tahun'] = $this->TahunakademikModel->semua_tahun();
        $data['rs_jadwal'] = $this->PenjadwalanModel->get();
        $datas['aside']='penjadwalan_bar';
        echo view('layout/navbar', $datas);
        echo view('penjadwalan', $data);
    }

    public function AmbilData($jenis_semester, $tahun_akademik, $jumlah_populasi, $prodi, $query, $e, $mod)
    {
        $this->jenis_semester = $jenis_semester;
        $this->tahun_akademik = $tahun_akademik;
        $this->populasi       = $jumlah_populasi;

        // Penggunaan quoery builder untuk tabel pengampu
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
                ->where('b.semester', $this->jenis_semester)
                ->where('a.tahun_akademik', $this->tahun_akademik);

        // Jika filter prodi diberikan
        if($prodi) {
            $builder->where('a.id_prodi', $prodi);
        }  

        // Menambah Order By
        if($query){
            $builder->orderBy('a.id', $query);
        }

        // Eksekusi query
        $rs_data = $builder->get();

        // Parsing data
        $i = 0;
        foreach ($rs_data->getResult() as $data) {
            $this->pengampu[$i]     = intval($data->id);
            $this->sks[$i]          = intval($data->jumlah_jam);
            $this->dosen[$i]        = intval($data->id_dosen);
            $this->status_dosen[$i] = intval($data->status_dosen);
            $this->status[$i]       = $data->status;
            $this->prodi[$i]        = intval($data->id_prodi);
            $this->semester[$i]     = intval($data->id_sem);
            $this->kelas[$i]        = intval($data->kelas);
            $this->ruang_pilihan[$i] = intval($data->id_ruang);
            $this->kuota_pengampu[$i] = intval($data->kuota);
            $this->jenis_mk[$i]     = $data->jenis;
            $this->prodi[$i]        = intval($data->id_prodi);
            $i++;
        }

        //var_dump($this->jenis_mk);
        //exit();
        
        // Query untuk SKS = 1
        $rs_data1 = $this->db->query("SELECT * FROM jam2 WHERE sks = '1'");
        $b = 0;
        foreach ($rs_data->getResult() as $data) {
            $this->jam1[$b] = (int) $data->id;
            $this->sesi1[$b] = (int) $data->sesi;
            $b++;
        }

        // Query untuk SKS = 2
        $rs_data2 = $this->db->query("SELECT * FROM jam2 WHERE sks = '2'");
        $b = 0;
        foreach ($rs_data->getResult() as $data) {
            $this->jam2[$b] = (int) $data->id;
            $this->sesi2[$b] = (int) $data->sesi;
            $b++;
        }

        // Query untuk SKS = 3
        $rs_data3 = $this->db->query("SELECT * FROM jam2 WHERE sks = '3'");
        $b = 0;
        foreach ($rs_data->getResult() as $data) {
            $this->jam3[$b] = (int) $data->id;
            $this->sesi3[$b] = (int) $data->sesi;
            $b++;
        }

        // Query untuk SKS = 4
        $rs_data4 = $this->db->query("SELECT * FROM jam2 WHERE sks = '4'");
        $b = 0;
        foreach ($rs_data->getResult() as $data) {
            $this->jam4[$b] = (int) $data->id;
            $this->sesi4[$b] = (int) $data->sesi;
            $b++;
        }
        
        // Queri untuk hari
        $rs_hari = $this->db->query("SELECT id FROM hari");
        $i = 0;
        foreach($rs_hari->getResult() as $data) {
            $this->hari[$i] = (int) $data->id;
            $i++;
        }

        // Query untuk waktu dosen
        $rs_Waktudosen = $this->db->query("SELECT a.id_dosen, CONCAT_WS(':', a.id_hari, b.sesi)
                                           FROM waktu_tidak_bersedia a LEFT JOIN jam2 b ON a.id_jam = b.id");
        $i = 0;
        foreach ($rs_Waktudosen->getResult() as $data) {
            $this->idosen[$i] = (int) $data->id_dosen;
            $this->waktu_dosen[$i][0] = (int) $data->id_dosen;
            $this->waktu_dosen[$i][1] = (int) $data->id_hari_jam;
            $i++;
        }

        // Query untuk Waktu Tersedia (Jika Prodi Terpilih)
        if ($prodi == true) {
            $rs_Waktutersedia = $this->db->query("SELECT a.id, a.id_pengampu, b.id, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.id_dosen) 
                                                    as id_hari_ruang, c.id, c.tipe_semester
                                                  FROM riwayat_penjadwalan a
                                                  LEFT JOIN pengampu b ON a.id_pengampu = b.id
                                                  LEFT JOIN semester c ON b.semester = c.id
                                                  LEFT JOIN jam2 d ON a.id_jam = d.id
                                                  WHERE c.semester_tipe = '$this->jenis_semester'
                                                  AND b.tahun_akademik = '$this->tahun_akademik'
                                                  AND b.id_prodi != '$prodi'");
            $i = 0;
            foreach ($rs_Waktutersedia->getResult() as $data) {
                $this->itersedia[$i] = (int) $data->id_dosen;
                $this->itersediaa[$i] = $data->id_dosen;
                $this->waktu_tersedia[$i][0] = (int) $data->id_dosen;
                $this->waktu_tersedia[$i][1] = $data->id_hari_ruang;
                $i++;
            }
        }

        // Query  untuk waktu tersimpan (Jika Prodi Terpilih)
        if($prodi == true) {
            $rs_Waktutersimpan = $this->db->query("SELECT a.id, a.id_pengampu, b.id, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.id_dosen) 
                                                    as id_hari_ruang, c.id, c.tipe_semester
                                                  FROM jadwalkuliah a
                                                  LEFT JOIN pengampu b ON a.id_pengampu = b.id
                                                  LEFT JOIN semester c ON b.semester = c.id
                                                  LEFT JOIN jam2 d ON a.id_jam = d.id
                                                  WHERE c.semester_tipe = '$this->jenis_semester'
                                                  AND b.tahun_akademik = '$this->tahun_akademik'
                                                  AND b.id_prodi = '$prodi'");
            $i = 0;
            foreach ($rs_Waktutersimpan->getResult() as $data) {
                $this->itersimpan[$i] = (int) $data->id_dosen;
                $this->itersimpann[$i] = $data->id_dosen;
                $this->waktu_tersimpan[$i][0] = (int) $data->id_dosen;
                $this->waktu_tersimpan[$i][1] = $data->id_hari_ruang;
                $i++;
            }
        } else {
            // Query waktu tersimpan tanpa Prodi terpilih
            $rs_Waktutersimpan = $this->db->query("SELECT a.id, a.id_pengampu, b.id, b.id_dosen, CONCAT_WS(':', a.id_hari, d.sesi, a.id_ruang, b.id_dosen) 
                                                    as id_hari_ruang, c.id, c.tipe_semester
                                                  FROM jadwalkuliah a
                                                  LEFT JOIN pengampu b ON a.id_pengampu = b.id
                                                  LEFT JOIN semester c ON b.semester = c.id
                                                  LEFT JOIN jam2 d ON a.id_jam = d.id
                                                  WHERE c.tipe_semester = '$this->jenis_semester'
                                                  AND b.tahun_akademik = '$this->tahun_akademik'");
            $i = 0;
            foreach ($rs_Waktutersimpan->getResult() as $data) {
                $this->itersimpan[$i] = (int) $data->id_dosen;
                $this->itersimpann[$i] = $data->id_dosen;
                $this->waktu_tersimpan[$i][0] = (int) $data->id_dosen;
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
        $jumlah_ruang_lab = count($this->ruangLaboratorium);

        // Untuk setiap individu dalam populasi
        for ($i = 0; $i < $this->populasi; $i++) {
            // untuk setiap  pengampu
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                $sks = $this->sks[$j];

                
                $this->individu[$i][$j][0] = $j;

                // Penentuan jam secara acak berdasarkan jumlah sks
                if ($sks == 1) {
                    $jumlah_jam = count($this->jam1);
                    $this->individu[$i][$j][1] = (int) $this->jam1[mt_rand(0, $jumlah_jam - 1)];
                } elseif ($sks == 2) {
                    $jumlah_jam = count($this->jam2);
                    $this->individu[$i][$j][1] = (int) $this->jam2[mt_rand(0, $jumlah_jam - 1)];
                } elseif ($sks == 3) {
                    $jumlah_jam = count($this->jam3);
                    $this->individu[$i][$j][1] = (int) $this->jam3[mt_rand(0, $jumlah_jam - 1)];
                } elseif ($sks == 4) {
                    $jumlah_jam = count($this->jam4);
                    $this->individu[$i][$j][1] = (int) $this->jam4[mt_rand(0, $jumlah_jam - 1)];
                }

                $this->individu[$i][$j][2] = mt_rand(0, $jumlah_hari - 1); // Penentuan hari secara acak

                // Menentukan ruang berdasarkan jenis mata kuliah
                $prodi = (int) $this->prodi[$j];
                if ($this->jenis_mk[$j] === $this->TEORI) {
                    if ($this->ruang_pilihan[$j] == true) {
                        $this->individu[$i][$j][3] = (int) $this->ruang_pilihan[$j];
                    } else {
                        $this->handleRuangReguler($prodi, $j, $i);
                    }
                } else if ($this->jenis_mk[$j] === $this->PRAKTIKUM) {
                    if ($this->ruang_pilihan[$j] == true) {
                        $this->individu[$i][$j][3] = (int) $this->ruang_pilihan[$j];
                    } else {
                        $this->handleRuangLaboratorium($prodi, $j, $i);
                    }
                }
            }
        }
    }

    // Menangani ruang reguler atau teori
}

?>