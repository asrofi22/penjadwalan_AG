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

    private $kap = true;
    private $kode_pengampu;
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


            }
        }
    }
}

?>