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
        // Cek apakah pengguna sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/admin');
        }

        // Membuat array kosong untuk data yang akan diteruskan ke view
        $data = [];

        // Memeriksa apakah form disubmit dengan metode POST
        if ($this->request->getMethod() == 'post') {
            // Validasi form
            if (!$this->validate([
                'prodi' => 'required',
                'tahun_akademik' => 'required',
                'semester' => 'required',
                'probabilitas_crossover' => 'required|numeric',
                'probabilitas_mutasi' => 'required|numeric',
                'jumlah_generasi' => 'required|numeric',
            ])) {
                // Jika validasi gagal, kembalikan ke form dengan error
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Mendapatkan data dari form
            $prodiId = $this->request->getPost('prodi');
            $tahunAkademikId = $this->request->getPost('tahun_akademik');
            $semesterId = $this->request->getPost('semester');
            $probabilitasCrossover = $this->request->getPost('probabilitas_crossover');
            $probabilitasMutasi = $this->request->getPost('probabilitas_mutasi');
            $jumlahGenerasi = $this->request->getPost('jumlah_generasi');

            // Mencatat waktu eksekusi
            $startTime = microtime(true);

            // Menentukan query untuk mengambil data pengampu berdasarkan prodi, semester, dan tahun akademik
            if ($prodiId) {
                $pengampuData = $this->pengampuModel->where('id_prodi', $prodiId)
                                                     ->where('id_tahun_akademik', $tahunAkademikId)
                                                     ->where('id_semester', $semesterId)
                                                     ->findAll();
            } else {
                $pengampuData = $this->pengampuModel->findAll();
            }

            // Jika tidak ada data pengampu ditemukan
            if (empty($pengampuData)) {
                return redirect()->back()->with('message', 'Tidak ada data pengampu yang sesuai dengan kriteria!');
            }

            // Menentukan jumlah populasi untuk algoritma genetika
            $jumlahPopulasi = count($pengampuData);
            if ($jumlahPopulasi % 2 != 0) {
                $jumlahPopulasi++; // Jika ganjil, tambahkan 1 agar genap
            }

            // Menginisialisasi populasi
            $this->AmbilData($pengampuData, $prodiId, $tahunAkademikId, $semesterId);
            $this->Inisialisasi($jumlahPopulasi);

            // Menghitung fitness
            $fitness = $this->HitungFitness($jumlahPopulasi, $prodiId);

            // Proses Seleksi, Crossover, dan Mutasi
            $this->Seleksi($fitness, $jumlahPopulasi);
            $this->StartCrossOver($jumlahPopulasi, $probabilitasCrossover);
            $fitnessAfterMutation = $this->Mutasi($jumlahPopulasi, $probabilitasMutasi, $prodiId);

            // Mengecek apakah solusi ditemukan dan menyimpannya ke database
            $jadwalKuliahData = $this->SimpanJadwal($fitnessAfterMutation);

            // Menghitung waktu total yang dibutuhkan untuk penjadwalan
            $executionTime = microtime(true) - $startTime;
            $executionTimeInMinutes = round($executionTime / 60, 2);

            // Menyimpan data jadwal dan menampilkan hasil
            $data['jadwal_list'] = $jadwalKuliahData;
            $data['execution_time'] = $executionTimeInMinutes . ' menit';
        }

        // Mengambil data prodi, tahun akademik, dan semester untuk form
        $data['prodi_list'] = $this->prodiModel->findAll();
        $data['semester_list'] = $this->semesterModel->findAll();
        $data['tahun_akademik_list'] = $this->tahunakademikModel->findAll();

        return view('penjadwalan', $data);
    }

    private function AmbilData($jenis_semester, $tahun_akademik, $jumlah_populasi, $prodi = null, $query = null)
    {
        // 1. Inisialisasi variabel
        $this->jenisSemester = $jenis_semester;
        $this->tahunAkademik = $tahun_akademik;
        $this->jumlahPopulasi = $jumlah_populasi;
        $this->prodi = $prodi;

        // Array untuk menyimpan data
        $this->pengampuModel = [];
        $this->jam = [];
        $this->hari = [];
        $this->waktuTidakBersedia = [];
        $this->waktuTersedia = [];
        $this->waktuTersimpan = [];

        // 2. Mengambil Data Pengampu Mata Kuliah
        if ($prodi) {
            $pengampuQuery = $this->pengampuModel
                ->where('id_prodi', $prodi)
                ->where('id_semester', $jenis_semester)
                ->where('id_tahun_akademik', $tahun_akademik)
                ->findAll();
        } else {
            $pengampuQuery = $this->pengampuModel
                ->where('id_semester', $jenis_semester)
                ->where('id_tahun_akademik', $tahun_akademik)
                ->findAll();
        }

        foreach ($pengampuQuery as $row) {
            $this->pengampu[] = [
                'id_pengampu' => $row['id_pengampu'],
                'id_dosen' => $row['id_dosen'],
                'mata_kuliah' => $row['mata_kuliah'],
                'kelas' => $row['kelas'],
                'id_prodi' => $row['id_prodi'],
                'sks' => $row['sks'],
                'kuota' => $row['kuota']
            ];
        }

        // 3. Mengambil Data Jam Berdasarkan SKS
        $jamQuery = $this->db->table('jam2')->get()->getResultArray();

        foreach ($jamQuery as $row) {
            $sks = $row['sks'];
            $this->jam[$sks][] = $row['id_jam'];
        }

        // 4. Mengambil Data Hari
        $hariQuery = $this->db->table('hari')->get()->getResultArray();

        foreach ($hariQuery as $row) {
            $this->hari[] = $row['id_hari'];
        }

        // 5. Mengambil Waktu Tidak Bersedia Dosen
        $tidakBersediaQuery = $this->db->table('waktu_tidak_bersedia')->get()->getResultArray();

        foreach ($tidakBersediaQuery as $row) {
            $this->waktuTidakBersedia[$row['id_dosen']][] = [
                'id_jam' => $row['id_jam'],
                'id_hari' => $row['id_hari']
            ];
        }

        // 6. Mengambil Waktu Tersedia Berdasarkan Prodi
        if ($prodi) {
            $tersediaQuery = $this->db->table('jadwal_tersedia')
                ->where('id_prodi', $prodi)
                ->get()
                ->getResultArray();
        } else {
            $tersediaQuery = $this->db->table('jadwal_tersedia')->get()->getResultArray();
        }

        foreach ($tersediaQuery as $row) {
            $this->waktuTersedia[] = [
                'id_jam' => $row['id_jam'],
                'id_hari' => $row['id_hari'],
                'id_ruang' => $row['id_ruang']
            ];
        }

        // 7. Mengambil Waktu Tersimpan untuk Menghindari Konflik
        if ($prodi) {
            $tersimpanQuery = $this->db->table('jadwalpelajaran')
                ->where('id_prodi', $prodi)
                ->get()
                ->getResultArray();
        } else {
            $tersimpanQuery = $this->db->table('jadwalpelajaran')->get()->getResultArray();
        }

        foreach ($tersimpanQuery as $row) {
            $this->waktuTersimpan[] = [
                'id_jam' => $row['id_jam'],
                'id_hari' => $row['id_hari'],
                'id_ruang' => $row['id_ruang']
            ];
        }
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

            // Seleksi individu terbaik
            $selected = $this->selection($population, $fitness);

            // Crossover
            $offspring = $this->crossover($selected);

            // Mutasi
            $population = $this->mutation($offspring, $jam_list, $hari_list, $ruang_list);
        }

        // Ambil solusi terbaik
        $finalFitness = $this->evaluateFitness($population);
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
        $this->penjadwalanModel->truncate(); // Hapus jadwal lama
        foreach ($bestSchedule as $schedule) {
            $this->penjadwalanModel->save($schedule);
        }
    }
}
