<?php

namespace App\Controllers;
use CodeIgniter\Database\Config;
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

class Penjadwalan extends BaseController
{
    protected $pengampuModel;
    protected $jamModel;
    protected $hariModel;
    protected $ruangModel;
    protected $penjadwalanModel;
    protected $waktutidakbersediaModel;
    protected $kelasModel;
    protected $prodiModel;
    protected $semesterModel;
    protected $tahunakademikModel;
    protected $dosenModel;
    protected $matakuliahModel;
    protected $riwayatpenjadwalanModel;


    public function __construct()
    {
        $this->jamModel = new JamModel();
        $this->waktutidakbersediaModel = new WaktutidakbersediaModel();
        $this->kelasModel = new KelasModel();
        $this->prodiModel = new ProdiModel();
        $this->semesterModel = new SemesterModel();
        $this->penjadwalanModel = new PenjadwalanModel();
        $this->pengampuModel = new PengampuModel();
        $this->tahunakademikModel = new TahunakademikModel();
        $this->dosenModel = new DosenModel();
        $this->hariModel = new HariModel();
        $this->matakuliahModel = new MatakuliahModel();
        $this->riwayatpenjadwalanModel = new RiwayatpenjadwalanModel();
        $this->ruangModel = new RuangModel();

        // Mengatur variabel konstan
        define('IS_TEST', 'FALSE');
    }

    public function index()
    {
        
        $data = [];
        $data['jadwal_list'] = $this->penjadwalanModel->findAll();
        helper(['form']); // Load form helper

        // Validasi Input
        if ($this->request->getMethod() == 'post') {
            $rules = [
                'tipe_semester'          => 'required',
                'tahun_akademik'         => 'required',
                'jumlah_populasi'        => 'required|integer',
                'probabilitas_crossover' => 'required|numeric',
                'probabilitas_mutasi'    => 'required|numeric',
                'jumlah_generasi'        => 'required|integer',
            ];

            if ($this->validate($rules)) {
                // Mulai waktu eksekusi
                $startTime = microtime(true);

                // Ambil inputan
                $jenis_semester  = $this->request->getPost('tipe_semester');
                $tahun_akademik  = $this->request->getPost('tahun_akademik');
                $prodi           = $this->request->getPost('prodi');
                $jumlah_populasi = $this->request->getPost('jumlah_populasi');
                $crossOver       = $this->request->getPost('probabilitas_crossover');
                $mutasi          = $this->request->getPost('probabilitas_mutasi');
                $jumlah_generasi = $this->request->getPost('jumlah_generasi');

                // Query data pengampu berdasarkan input
                $query = $this->pengampuModel
                        ->select('id')
                        ->join('semester', 'pengampu.semester = semester.id', 'left')
                        ->join('tahun_akademik', 'pengampu.tahun_akademik = tahun_akademik.id', 'left')
                        ->where('semester.tipe_semester', $jenis_semester)
                        ->where('pengampu.tahun_akademik', $tahun_akademik)
                        ->get();


                if (!empty($prodi)) {
                    $query->where('pengampu.id_prodi', $prodi);
                }

                $rs_data = $query->get()->getResult();

                if (empty($rs_data)) {
                    $data['msg'] = 'Tidak Ada Data dengan Semester dan Tahun Akademik ini';
                } else {
                    // Algoritma Genetika
                    $result = $this->generate($jenis_semester, $tahun_akademik, $rs_data, $jumlah_generasi, $crossOver, $mutasi, $prodi);

                    if (!$result) {
                        $data['msg'] = 'Tidak ditemukan solusi optimal';
                    } else {
                        // Menggunakan Query Builder untuk menghapus duplikat jadwal
                        $this->penjadwalanModel->query("DELETE FROM jadwalkuliah WHERE id IN 
                            (SELECT * FROM (SELECT id FROM jadwalkuliah GROUP BY id_pengampu HAVING COUNT(*) > 1) AS A)");    

                        $finishTime = microtime(true);
                        $totalTime = round(($finishTime - $startTime) / 60, 4);
                        $data['waktu'] = "Selesai dalam {$totalTime} menit";
                    }
                }
            } else {
                $data['msg'] = $this->validator->listErrors();
            }
        }

        // Load data tambahan ke view
        $data['page_name']   = 'penjadwalan';
        $data['page_title']  = 'Penjadwalan';
        $data['rs_tahun']    = $this->tahunakademikModel->findAll();
        $data['rs_jadwal']   = $this->penjadwalanModel->findAll();
        $data['aside']       = 'penjadwalan_bar';

        // Load views
        echo view('penjadwalan', $data);
    }


    public function generate()
    {
        // 1. Ambil data awal
        $pengampu_list = $this->pengampuModel->findAll();
        $jam_list = $this->jamModel->findAll();
        $hari_list = $this->hariModel->findAll();
        $ruang_list = $this->ruangModel->findAll();

        // 2. Inisialisasi populasi
        $population = $this->initializePopulation($pengampu_list, $jam_list, $hari_list, $ruang_list);

        // 3. Jalankan algoritma genetika
        $bestSchedule = $this->geneticAlgorithm($population, $jam_list, $hari_list, $ruang_list);

        // 4. Simpan jadwal terbaik ke database
        $this->saveSchedule($bestSchedule);

        return redirect()->to('/penjadwalan')->with('message', 'Jadwal berhasil digenerate!');
    }

    private function initializePopulation($pengampu_list, $jam_list, $hari_list, $ruang_list, $populationSize = 50)
    {
        $population = [];
        for ($i = 0; $i < $populationSize; $i++) {
            $schedule = [];
            foreach ($pengampu_list as $pengampu) {
                $schedule[] = [
                    'id_pengampu' => $pengampu['id'],
                    'id_jam'      => $jam_list[array_rand($jam_list)]['id'],
                    'id_hari'     => $hari_list[array_rand($hari_list)]['id'],
                    'id_ruang'    => $ruang_list[array_rand($ruang_list)]['id']
                ];
            }
            $population[] = $schedule;
        }
        return $population;
    }

    private function geneticAlgorithm($population, $jam_list, $hari_list, $ruang_list, $maxGenerations = 100)
{
    for ($gen = 0; $gen < $maxGenerations; $gen++) {
        // Evaluasi fitness
        $fitness = $this->evaluateFitness($population);

        // Validasi fitness
        if (empty($fitness)) {
            log_message('error', 'Fitness array is empty during generation ' . $gen);
            break; // Keluar dari loop jika fitness tidak bisa dihitung
        }

        // Seleksi individu terbaik
        $selected = $this->selection($population, $fitness);

        // Crossover
        $offspring = $this->crossover($selected);

        // Mutasi
        $population = $this->mutation($offspring, $jam_list, $hari_list, $ruang_list);
    }

    // Ambil solusi terbaik
    if (empty($population)) {
        log_message('error', 'Population is empty, cannot determine best schedule.');
        return null; // Tangani keadaan kosong
    }

    $finalFitness = $this->evaluateFitness($population);
    if (empty($finalFitness)) {
        log_message('error', 'Final fitness is empty, cannot determine best index.');
        return null; 
    }
    
    $bestIndex = array_search(max($finalFitness), $finalFitness);
    return $population[$bestIndex];
}

    private function evaluateFitness($population)
    {
        $fitness = [];
        foreach ($population as $schedule) {
            $conflicts = 0;
            foreach ($schedule as $i => $class1) {
                foreach ($schedule as $j => $class2) {
                    if ($i != $j) {
                        // Cek konflik ruang, jam, dan hari
                        if ($class1['id_ruang'] == $class2['id_ruang'] &&
                            $class1['id_jam'] == $class2['id_jam'] &&
                            $class1['id_hari'] == $class2['id_hari']) {
                            $conflicts++;
                        }
                    }
                }
            }
            $fitness[] = 1 / (1 + $conflicts); // Nilai fitness lebih tinggi jika konflik lebih sedikit
        }
        return $fitness;
    }

    private function selection($population, $fitness)
    {
        arsort($fitness);
        $selected = [];
        foreach (array_keys($fitness) as $key) {
            $selected[] = $population[$key];
            if (count($selected) >= count($population) / 2) {
                break;
            }
        }
        return $selected;
    }

    private function crossover($selected)
    {
        $offspring = [];
        for ($i = 0; $i < count($selected) - 1; $i += 2) {
            $parent1 = $selected[$i];
            $parent2 = $selected[$i + 1];
            $cutPoint = rand(0, count($parent1) - 1);

            $child1 = array_merge(array_slice($parent1, 0, $cutPoint), array_slice($parent2, $cutPoint));
            $child2 = array_merge(array_slice($parent2, 0, $cutPoint), array_slice($parent1, $cutPoint));

            $offspring[] = $child1;
            $offspring[] = $child2;
        }
        return $offspring;
    }

    private function mutation($population, $jam_list, $hari_list, $ruang_list, $mutationRate = 0.1)
    {
        foreach ($population as &$schedule) {
            if (rand() / getrandmax() < $mutationRate) {
                $index = array_rand($schedule);
                $schedule[$index]['id_jam'] = $jam_list[array_rand($jam_list)]['id'];
                $schedule[$index]['id_hari'] = $hari_list[array_rand($hari_list)]['id'];
                $schedule[$index]['id_ruang'] = $ruang_list[array_rand($ruang_list)]['id'];
            }
        }
        return $population;
    }

    private function saveSchedule($bestSchedule)
{
    if (empty($bestSchedule)) {
        log_message('error', 'Best schedule is empty, nothing to save.');
        return; // Tidak melakukan apa-apa jika jadwal terbaik tidak ada
    }

    $this->penjadwalanModel->truncate(); // Hapus jadwal lama
    foreach ($bestSchedule as $schedule) {
        $this->penjadwalanModel->save($schedule);
    }
}
}
