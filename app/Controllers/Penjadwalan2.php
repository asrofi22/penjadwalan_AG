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
use PhpOffice\PhpSpreadsheet\Writer\Xls;  // Jika Anda ingin menulis ke format ExcelXlsx

class Penjadwalan2 extends BaseController {
    
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
    private $id_jumat;
    private $range_jumat = array();
    private $id_dhuhur;
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
        $session = \Config\Services::session();
        $pengampu_tahun_akademik = $session->get('pengampu_tahun_akademik');

        if (!$session->get('logged_in')) {
            return redirect()->to('admin');
        }

        $data = [
            'prodi_list' => $this->ProdiModel->findAll(),
            'pengampu_list' => $this->PengampuModel->getPengampuWithDetails(),
            'matakuliah_list' => $this->MatakuliahModel->findAll(),
            'dosen_list' => $this->DosenModel->findAll(),
            'kelas_list' => $this->KelasModel->findAll(),
            'tahun_akademik_list' => $this->TahunakademikModel->findAll(),
            'semester_list' => $this->SemesterModel->findAll(),
            'ruang_list' => $this->RuangModel->findAll()
        ];
        
        return view('penjadwalan', $data);


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

                $jenis_semester = $this->request->getPost('tipe_semester');
                $prodi = $this->request->getPost('prodi');
                $tahun_akademik = $this->request->getPost('tahun_akademik');
                $crossOver = $this->request->getPost('probabilitas_crossover');
                $mutasi = $this->request->getPost('probabilitas_mutasi');
                $jumlah_generasi = $this->request->getPost('jumlah_generasi');
                $data['rs_jadwal'] = $PenjadwalanModel->getAllJadwal(); // Pastikan method get() mengembalikan data yang sesuai

                $data['semester_a'] = $this->request->getPost('tipe_semester') ?? false;
                $data['tahun_a'] = $this->request->getPost('tahun_akademik') ?? false; // atau default ke false jika tidak diatur
                $data['rs_tahun'] = $this->TahunakademikModel->findAll();
                $data['tahun_a'] = $this->request->getPost('tahun_akademik') ?? false; // atau default ke false jika tidak diatur
                $data['prodi'] = $this->request->getPost('prodi') ?? false; // atau default ke false jika tidak diatur


                // Menyimpan data yang dikirim
                $data['semester_a'] = $jenis_semester;
                $data['prodi'] = $prodi;
                $data['semua_prodi'] = $this->ProdiModel->semua_prodi2();
                $data['tahun_a'] = $tahun_akademik;
				$datas['tipe_semester'] = $jenis_semester;
				$datas['tahun_akademik'] = $tahun_akademik;
                $datas['probabilitas_crossover'] = $crossOver;
				$datas['probabilitas_mutasi'] = $mutasi;
				$datas['jumlah_generasi'] = $jumlah_generasi;
				

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
                if($rs_data->getNumRows() == 0){
                    $data['msg'] = 'Tidak ada data dengan semester dan tahun akademik ini';
                } else {
                    $n=0;
					
					if($rs_data->getNumRows() % 2 == 0 ){
						$jumlah_populasi =$rs_data->getNumRows();
					}
					else{
						$jumlah_populasi =$rs_data->getNumRows() + 1;
					}
					
					$banyak_populasi= intval($rs_data->getNumRows()/2);
					
					$e=0;
					$c=0;
					$this->db->query("TRUNCATE TABLE jadwalpelajaran");	
					for($f = 0;$f <= $banyak_populasi;$f++ ){
					$query='asc limit '.$e.',2';
						$mod = intval($rs_data->getNumRows() % 2);
						$banyak_populasi= intval($rs_data->getNumRows()/2);
						if($f == $banyak_populasi){
							$query='asc limit '.$e.','.$mod;
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
                return view('penjadwalan', $data);
            }
        }

        // Data yang dikirimkan ke view
        $data['page_name'] = 'penjadwalan';
        $data['rs_tahun'] = $this->TahunakademikModel->findAll();
        $data['pengampu_tahun_akademik'] = $pengampu_tahun_akademik;
        $data['rs_jadwal'] = $this->PenjadwalanModel->getAllJadwal();
        echo view('layout/navbar', $datas);
        return view('penjadwalan', $data);
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
                                                  WHERE c.tipe_semester = '$this->jenis_semester'
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
                                                  WHERE c.tipe_semester = '$this->jenis_semester'
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
        $db = Database::connect();
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

                // Jika mata kuliah TEORI
                if ($this->jenis_mk[$j] === $this->TEORI) {
                    if ($this->ruang_pilihan[$j] == true) {
                        $this->individu[$i][$j][3] = intval($this->ruang_pilihan[$j]);
                    } elseif ($this->status[$j] != 'Normal') {
                        $this->ruangReguler=false;
                        $kuota = intval($this->kuota_pengampu[$j]);
                        $rs_RuangReguler = $this->db->query("SELECT kode, kapasitas "
                                            ."FROM ruang "
                                            ."WHERE jenis = '$this->TEORI' and kode_jurusan='$prodi' and kapasitas >='$kuota' and lantai='1' ");
						$k = 0;

                        if($rs_RuangReguler->getNumRows()==0){
                            $this->kap = false;
                            $this->id_pengampu = $this-> pengampu[$j];
                            break;
                        }
                        foreach ($rs_RuangReguler->getResult() as $data) {
                            $this->ruangReguler[$k] = intval($data->kode);
                            $k++;

                            $jumlah_ruang_reguler = count($this->ruangReguler);
							$this->individu[$i][$j][3] = intval($this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)]);
						}
                    } else {
                        $kuota = intval($this->kuota_pengampu[$j]);
                        $query = $db->query("SELECT id FROM ruang WHERE kapasitas >= ? AND jenis = ? AND id_prodi = ?", [$kuota, $this->TEORI, $prodi]);
                        $results = $query->getResult();

                        if (empty($results)) {
                            $this->kap = false;
                            $this->id_pengampu = $this->pengampu[$j];
                            break;
                        }

                        $this->ruangReguler = array_column($results, 'id');
                        $this->individu[$i][$j][3] = $this->ruangReguler[array_rand($this->ruangReguler)];
                    }
                }
                // Jika mata kuliah PRAKTIKUM
                else if ($this->jenis_mk[$j] === $this->PRAKTIKUM) {
                    if($this->ruang_pilihan[$j] == true){
                        $this->individu[$i][$j][3] = intval($this->ruang_pilihan[$j]);				
                    }
                    else if($this->status[$j] != 'Normal' ){
                        $this->ruangLaboratorium=false;
                        $kuota=intval($this->kuota_pengampu[$j]);	
                        $rs_RuangLaboratorium = $this->db->query("SELECT kode, kapasitas "
                                        ."FROM ruang "
                                        ."WHERE jenis = 'LABORATORIUM' and kode_jurusan='$prodi' and lantai='1' and kapasitas >='$kuota' ");
                        $k = 0;
                        
                        if($rs_RuangLaboratorium->getNumRows()==0){
							
							$this->kap=false;
							$this->id_pengampu = $this->pengampu[$j];
								break ;
							}
							foreach ($rs_RuangLaboratorium->getResult() as $data) {
								$this->ruangLaboratorium[$k] = intval($data->kode);
								$k++;
							}
							$jumlah_ruang_lab = count($this->ruangLaboratorium);
							$this->individu[$i][$j][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);                    
                        } else {
                            $this->ruangLaboratorium=false;
                            $kuota=intval($this->kuota_pengampu[$j]);	
                            $rs_RuangLaboratorium = $this->db->query("SELECT kode, kapasitas "
                                        ."FROM ruang "
                                        ."WHERE kapasitas >='$kuota' and jenis = '$this->LABORATORIUM' and kode_jurusan='$prodi' ");
                            $k = 0;
                            if($rs_RuangLaboratorium->getNumRows()==0){
                        
                            $this->kap=false;
                            $this->id_pengampu = $this->pengampu[$j];
                                break ;
                            }
                            foreach ($rs_RuangLaboratorium->getResult() as $data) {
                                $this->ruangLaboratorium[$k] = intval($data->kode);
                                $k++;
                            }
                            $jumlah_ruang_lab = count($this->ruangLaboratorium);
                            $this->individu[$i][$j][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);                    
                        }
                } else{}
            }
        }
    }

    // Menghitung nilai fitness  untuk setiap individu dalam populasi berdasarkan beberapa kriteria
    public function CekFitness($indv, $prodi)
    {
        $this->db = \Config\Database::connect();
        $this->id_jumat = 5;
        $this->range_jumat = [6, 7];
        $this->id_dhuhur = 6;
        $penalty = 0;
        $jumlah_ruang_reguler = count($this->ruangReguler);
        $hari_jumat = $this->id_jumat;
        $jumat_0 = $this->range_jumat[0];
        $jumat_1 = $this->range_jumat[1];
        $jumlah_pengampu = count($this->pengampu);

        for ($i = 0; $i < $jumlah_pengampu; $i++)
        {
            $sks = intval($this->sks[$i]);
            $jam_a = intval($this->individu[$indv][$i][1]);
            $hari_a = intval($this->individu[$indv][$i][2]);
            $ruang_a = intval($this->individu[$indv][$i][3]);
            $dosen_a = intval($this->dosen[$i]);

            $kuota = intval($this->kuota_pengampu[$i]);        
            $semester_a = intval($this->semester[$i]);        
            $kelas_a = intval($this->kelas[$i]);        
		    $prodi_a = intval($this->prodi[$i]);        
		    $prodi=intval($this->prodi[$i]);

            $rs_jam1 = $this->db->query("SELECT * FROM jam2 where id='$jam_a'");
			foreach ($rs_jam1->getResult() as $data); 
			$sesiJam_a = $data->sesi;

            // Penanganan jam hari jumat
            if ($sks == 2 || $sks == 2 || $sks == 4) {
                if(($hari_a  + 1) != $hari_jumat){
                    if($sesiJam_a==5){
                            $q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='3'");
                            foreach ($q_jam1->getResult() as $q);
                            $this->individu[$indv][$i][1]= $q->id;
                            $sesiJam_a=3;	
                    }
                    if($sesiJam_a==6){
                            $q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='4'");
                            foreach ($q_jam1->getResult() as $q);
                            $this->individu[$indv][$i][1]= $q->id;
                            $sesiJam_a=4;	
                    }
                }
            }

            if(($hari_a  + 1) == $hari_jumat){
				if($sesiJam_a==3){
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='1'");
						foreach ($q_jam1->getResult() as $q);
						$this->individu[$indv][$i][1]= $q->id;
						$sesiJam_a=1;	
				}
				if($sesiJam_a==4){
					if($sks==3){
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='1'");
						foreach ($q_jam1->getResult() as $q);
						$this->individu[$indv][$i][1]= $q->id;
						$sesiJam_a=1;	
					}
					else{
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='2'");
						foreach ($q_jam1->getResult() as $q);
						$this->individu[$indv][$i][1]= $q->id;
						$sesiJam_a=2;	
					}	
				}
				if($sesiJam_a==2){
					if($sks==3){
						$q_jam1 = $this->db->query("SELECT * FROM jam2 where sks='$sks' and sesi='1'");
						foreach ($q_jam1->getResult() as $q);
						$this->individu[$indv][$i][1]= $q->id;
						$sesiJam_a=1;	
					}	
				}
			}

            // Loop untuk cek bentrok ruang dan waktu
            for ($j = 0; $j < $jumlah_pengampu; $j++) {

                $jam_b = intval($this->individu[$indv][$j][1]);
                $hari_b = intval($this->individu[$indv][$j][2]);
                $ruang_b = intval($this->individu[$indv][$j][3]);
                $dosen_b = intval($this->dosen[$j]);
                $semester_b = intval($this->semester[$j]);
                $kelas_b = intval($this->kelas[$j]);
                $prodi_b = intval($this->prodi[$j]);
                $rs_jam2 = $this->db->query("SELECT * FROM jam2 where kode='$jam_b'");
                foreach ($rs_jam2->getResult() as $data1); 
				$sesiJam_b = $data1->sesi;

                //1.bentrok ruang dan waktu dan 3.bentrok guru
                
                //ketika pemasaran matapelajaran sama, maka langsung ke perulangan berikutnya
                if ($i == $j)
                    continue;

                //Ketika jam,hari dan ruangnya sama, maka penalty + satu
				if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4 ){
					if (
					$sesiJam_a == $sesiJam_b &&
						$hari_a == $hari_b &&
						$ruang_a == $ruang_b)
					{
						$penalty += 1;
					}
				}
                
				
				//#region Bentrok Ruang dan Waktu
                //Ketika jam,hari dan semester sama, maka penalty + satu
				if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4 ){
						if (
						$prodi_a == $prodi_b &&
						$sesiJam_a == $sesiJam_b &&
						$hari_a == $hari_b &&
						$kelas_a == $kelas_b &&
						$semester_a == $semester_b)
						{
							$penalty += 1;
						}
					}
					
                
                //______________________BENTROK guru
				if ($sks == 1 || $sks == 2 || $sks == 3 || $sks == 4 ){
					if (
					//ketika jam sama
						$sesiJam_a == $sesiJam_b &&
					//dan hari sama
						$hari_a == $hari_b && 
					//dan gurunya sama
						$dosen_a == $dosen_b)
					{
					  //maka...
					  $penalty += 1;
					}
				}            
            }

            // Bentrok dengan keinginan dosen

            $jumlah_waktu_tidak_bersedia = count($this->idosen);

            for ($j = 0; $j < $jumlah_waktu_tidak_bersedia; $j++)
            {
                if ($dosen_a == $this->idosen[$j] )
                {
                    $hari_jam = explode(':', $this->waktu_dosen[$j][1]);
                    
                    if ($sesiJam_a == $hari_jam[1] &&
                        $this->hari[$hari_a] == $hari_jam[0])
                    {                    
                        $penalty += 1;                        
                    }
                }                            
				
            }

            //#region Bentrok dengan Waktu Yang Sudah Terpakai
			if($prodi==true){
				$jumlah_waktu_tersedia = count($this->itersedia);
				
				for ($j = 0; $j < $jumlah_waktu_tersedia; $j++)
				{
					
						$hari_ruang = explode(':', $this->waktu_tersedia[$j][1]);
						
						if ($dosen_a == $hari_ruang[3] &&
							$this->hari[$hari_a]  == $hari_ruang[0] &&
							$sesiJam_a == $hari_ruang[1])
						{
							 $penalty += 1;	   
						 }
						
						if ($this->hari[$hari_a]   == $hari_ruang[0]  && $ruang_a  == $hari_ruang[2])
						{   
							if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3)
							{
							   if ($sesiJam_a == $hari_ruang[1]  )
							   {	   
								   $penalty += 1;
							   }
							}                    
						}					 
					 
				}
			}
			//#endregion

            //#region Bentrok dengan Waktu Yang Sudah Tersimpan di tabel jadwalpelajaran
			
			$jumlah_waktu_tersimpan = count($this->itersimpan);
            
            for ($j = 0; $j < $jumlah_waktu_tersimpan; $j++)
            {
                
                $hari_ruang = explode(':', $this->waktu_tersimpan[$j][1]);
					
				if ($dosen_a == $hari_ruang[5] &&
					$this->hari[$hari_a]  == $hari_ruang[0] &&
					$sesiJam_a == $hari_ruang[1])
                {
					 $penalty += 1;	   
                 }
				 
				 if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3)
				 {
					if ( $prodi_a == $hari_ruang[6] &&
						$sesiJam_a == $hari_ruang[1]  &&
						$this->hari[$hari_a]  == $hari_ruang[0]&&
						$kelas_a == $hari_ruang[4] &&
						$semester_a == $hari_ruang[3])
					{
						$penalty += 1;
					}
				}
				    
					if ($this->hari[$hari_a]   == $hari_ruang[0]  && $ruang_a  == $hari_ruang[2])
                    {   
                        if ($sks == 1 || $sks == 2 || $sks == 4 || $sks == 3)
						{
						   if ($sesiJam_a == $hari_ruang[1])
						   {
							   $penalty += 1;
						   }
						}
                    }
				}
			
			//#endregion
			
        }      
        
        $fitness = floatval(1 / (1 + $penalty));  
        return $fitness;     
    }

    public function hitungFitness($jumlah_populasi, $prodi)
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

                // Jika nilai fitness individu saat ini lebih besar  dari individu lain, ranking naik
                if ($fitnessA > $fitnessB) {
                    $rank[$i] += 1;
                }
            }

            $jumlah += $rank[$i];
        }

        $jumlah_rank = count($rank);

        // Proses seleksi berdasarkan ranking yang telah dibuat
        for ($i = 0; $i < $this->populasi; $i++) {
            // Menghasilkan angka acak untuk menentukan individu yang terpilih
            $target = mt_rand(0, $jumlah - 1);

            $cek = 0;
            for ($j = 0; $j < $jumlah_rank; $j++) {
                $cek += $rank[$j];
                if (intval($cek) >= intval($target)) {
                    // Menyimpan induk yang terpilih berdasarkan ranking
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }

    // Fungsi StartCrossOver
    public function StartCrossOver($jumlah_populasi, $crossOver)
    {
        $this->populasi = $jumlah_populasi;
        $this->crossOver = $crossOver;
        $individu_baru = array_fill(0, $this->populasi, array_fill(0, count($this->pengampu), []));
        $jumlah_pengampu = count($this->pengampu);

        for ($i = 0; $i < $this->populasi; $i +=2) {
            $b = 0;
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax(); //Nilai random untuk crossover

            // Two-point  crossover
            if ($cr < $this->crossOver) {
                $a = mt_rand(0,  $jumlah_pengampu - 2);
                while ($b <= $a) {
                    $b = mt_rand(0, $jumlah_pengampu - 1);
                }

                // Crossover sebelum titik pertama
                for ($j = 0; $j < $a; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }

                // Crossover antara titik pertama dan kedua
                for ($j = $a; $j < $b; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                    }
                }

                // crossover setelah tititk kedua
                for ($j = $a; $j < $jumlah_pengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            } else {
                // Jika tidak terjadi crossover, salin individu langsung
                for ($j = 0; $j < $jumlah_pengampu; $j++) {
                    for ($k = 0; $k < 4; $k++) {
                        $individu_baru[$i][$j][$k] = $this->individu[$this->induk[$i]][$j][$k];
                        $individu_baru[$i + 1][$j][$k] = $this->individu[$this->induk[$i + 1]][$j][$k];
                    }
                }
            }
        }

        // update individu  berdasarkan crossover
        for ($i = 0; $i < $this->populasi; $i += 2) {
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                for ($k = 0; $k < 4; $k++) {
                    $this->individu[$i][$j][$k] = $individu_baru[$this->induk[$i]][$j][$k];
                    $this->individu[$i + 1][$j][$k] = $individu_baru[$this->induk[$i + 1]][$j][$k];
                }
            }
        }

        return $individu_baru;
    }

    public function mutasi($jumlah_populasi, $mutasi, $prodi)
    {
        $this->populasi = $jumlah_populasi;
        $this->mutasi = $mutasi;

        $fitness = [];
        $r = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax(); //Menghasilkan nilai acak untuk probabilitas mutasi
        $jumlah_pengampu = count($this->pengampu);
        $jumlah_hari = count($this->hari);

        // Melakukan iterasi untuk setiap individu dalam populasi
        for ($i = 0; $i < $this->populasi; $i++) {
            // Jika nilai acak lebih kecil dari probabilitas mutasi, lakukan mutasi
            if($r < $this->mutasi) {
                // Pilih pengampu secara acak yang akan dimutasi
                $krom = mt_rand(0, $jumlah_pengampu - 1);
                $j = intval($this->sks[$krom]);

                // Switch untuk menangani mutasi berdasarkan jumlah sks
                switch ($j) {
                    case 1;
                        $this->individu[$i][$krom][1] = $this->jam1[mt_rand(0, count($this->jam1) - 1)];
                        break;
                    case 2;
                        $this->individu[$i][$krom][1] = $this->jam2[mt_rand(0, count($this->jam2) - 1)];
                        break;
                    case 3;
                        $this->individu[$i][$krom][1] = $this->jam3[mt_rand(0, count($this->jam3) - 1)];
                        break;
                    case 4;
                        $this->individu[$i][$krom][1] = $this->jam4[mt_rand(0, count($this->jam4) - 1)];
                        break;
                }

                // Ganti hari secara acak
                $this->individu[$i][$krom][2] = mt_rand(0,  $jumlah_hari - 1);

                // Ambil id prodi untuk pengampu tersebut
                $prodi = intval($this->prodi[$krom]);

                // Cek apakah jenis mata kuliah adalah teori atau praktikum
                if ($this->jenis_mk[$krom] === $this->TEORI) {
                    if ($this->ruang_pilihan[$krom] == true) {
                        // Jika  ada ruang pilihan, gunakan ruang pilihan tersebut
                        $this->individu[$i][$krom][3] = intval($this->ruang_pilihan[$krom]);
                    } else {
                        // Jika tidak, pilihkan ruang reguler  untuk mata kuliah teori
                        $kuota = intval($this->kuota_pengampu[$krom]);
                        $rs_RuangReguler = $this->db->query("SELECT id, kapasitas FROM ruang WHERE jenis = 'TEORI' AND id_prodi = '$prodi'  AND kapasitas >= '$kuota'");
                        
                        // Mengubah hasil query  menjadi array id ruang
                        $ruangReguler = array_map(function($data) {
                            return intval ($data->id);
                        }, $rs_RuangReguler->getResult());

                        // Mengambil ruang acak dari ruang yang tersedia
                        $jumlah_ruang_reguler = count($ruangReguler);
                        $this->individu[$i][$krom][3] = $ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)];
                    }
                } else if ($this->jenis_mk[$krom] === $this->PRAKTIKUM) {
                    if ($this->ruang_pilihan[$krom] ==  true) {
                        // Jika ada ruang pilihan, gunakan ruang pilihan tersebut
                        $this->individu[$i][$krom][3] = intval($this->ruang_pilihan[$krom]);
                    } else {
                        // Jika tidak, pilihkan ruang laboratorium untuk praktikum
                        $kuota = intval($this->kuota_pengampu[$krom]);
                        $rs_RuangLaboratorium = $this->db->query("SELECT id, kapasitas FROM ruang WHERE jenis = 'LABORATORIUM' AND id_prodi = '$prodi' AND  kapasitas >= '$kuota'");

                        // Mengubah hasil query menjadi array id ruang
                        $ruangLaboratorium = array_map(function($data) {
                            return intval ($data->id);
                        }, $rs_RuangLaboratorium->getResult());

                        // Mengambil ruang acak dari ruang yang tersedia
                        $jumlah_ruang_lab = count($ruangLaboratorium);
                        $this->individu[$i][$krom][3] = $ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)];
                    }
                }
            }

            // Evaluasi fitness setelah mutasi
            $fitness[$i] = $this->CekFitness($i, $prodi);
        }

        return $fitness;
    }

    public function getIndividu($indv)
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

    public function excel_report()
    {
        // Mengambil data dari model
        $query = $this->PenjadwalanModel->findAll();

        if (!$query) {
            return false;
        }

        // Memuat PHP Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setTitle("Export");

        // Menentukan nama field  untuk header excel
        $fields = ["hari", "ruang", "jam_kuliah", "nama_mk", "dosen", "nama_kelas", "nama_semester", "nama_prodi", "kuota"];
        $col = 0;
        foreach ($fields as $field) {
            $sheet->setCellValueExplicit($col + 1, 1, $field, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $col++;
        }
        // Mengisi data ke dalam sheet
        $row = 2;
        foreach ($query as $data) {
            $col = 0;
            foreach ($fields as $field) {
                $sheet->setCellValue($col + 1, $row, $data[$field]);
                $col++;
            }
            $row++;
        }
        // Mengatur writer untuk menulis ke file Excel
        $writer = new Xls($spreadsheet);
        // Mengirimkan file Excel ke browser untuk diunduh
        return $this->response->setHeader('Content-Type', 'application/vnd.ms-excel')
                              ->setHeader('Content-Disposition', 'attachment;filename="Products_' . date('dMy') . '.xls"')
                              ->setHeader('Cache-Control', 'max-age=0')
                              ->setBody($writer->save('php://output'));
    }

    public function  simpan_jadwal()
    {
        // Mengambil data jadwal
        $jadwal = $this->PenjadwalanModel->findAll();
        
        foreach ($jadwal as $k) {
            $tipe_semester = $k['tipe_semester'];
            $tahun_akademik = $k['tahun_akademik'];
            $prodi = $k['id_prodi'];
        }

        $banyak_prodi = $this->PenjadwalanModel->cek_banyak_prodi($tipe_semester, $tahun_akademik);
        $riwayat = $this->PenjadwalanModel->semua_jadwal($tipe_semester, $tahun_akademik);
    
        foreach ($banyak_prodi as $b) {
            if ($b['banyak'] > 1) {
                // Hapus semua jadwal
                $this->RiwayatpenjadwalanModel->hapus_semua_jadwal($tipe_semester, $tahun_akademik);

                // Simpan jadwal
                foreach ($jadwal as $j) {
                    $id_pengampu = $j['id_pengampu'];
                    $id_jam = $j['id_jam'];
                    $id_hari = $j['id_hari'];
                    $id_ruang = $j['id_ruang'];
                    $this->PenjadwalanModel->simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang);
                }
            } else {
                $cek = $this->PenjadwalanModel->cek_jadwal($tipe_semester, $tahun_akademik, $prodi);
                
                if ($cek) {
                    // Hapus jadwal yang sudah ada
                    $this->RiwayatpenjadwalanModel->hapus_jadwal($tipe_semester, $tahun_akademik, $prodi);
                        
                    // Simpan jadwal baru
                    foreach ($jadwal as $j) {
                        $id_pengampu = $j['id_pengampu'];
                        $id_jam = $j['id_jam'];
                        $id_hari = $j['id_hari'];
                        $id_ruang = $j['id_ruang'];
                        $this->PenjadwalanModel->simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang);
                    }
                } else {
                    // Simpan jadwal
                    foreach ($jadwal as $j) {
                        $id_pengampu = $j['id_pengampu'];
                        $id_jam = $j['id_jam'];
                        $id_hari = $j['id_hari'];
                        $id_ruang = $j['id_ruang'];
                        $this->PenjadwalanModel->simpan_jadwal($id_pengampu, $id_jam, $id_hari, $id_ruang);
                    }
                }
            }
        }

        // Menyiapkan data untuk tampilan 
        $data['rs_tahun'] = $this->TahunakademikModel->findAll();
        $data['waktu'] = "Berhasil menyimpan jadwal";
        $data['rs_jadwal'] = $this->PenjadwalanModel->findAll();

        // Mengatur tampilan (view)
        return view('penjadwalan', $data);
    }

    public function hapus_jadwal()
    {
        // Menghapus data jadwal
        $this->db->query("TRUNCATE TABLE jadwalkuliah");

        // Menyiapkan data untuk tampilan
        $data['rs_tahun'] = $this->TahunakademikModel->findAll();
        $data['hapus'] = "Berhasil menghapus jadwal";
        $data['rs_jadwal'] = $this->PenjadwalanModel->findAll();

        // Mengatur tampilan (view)
        return view('penjadwalan', $data);
    } 
}

?>