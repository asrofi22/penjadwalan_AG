<?php
namespace App\Controllers;

use App\Models\{ 
    RequestKuliahModel, 
    RequestRuangModel, 
    RequestWaktuModel, 
    SemesterModel, 
    TahunakademikModel, 
    PengampuModel,
    ProdiModel, 
    RuangModel, 
    WaktuModel, 
    DosenModel, 
    HariModel, 
    JamModel, 
    JadwalModel, 
    MatakuliahModel, 
    KelasModel
};
use CodeIgniter\Controller;

class Penjadwalan4 extends Controller
{
    public function generatejadwalform()
    {
        $session = session();
        $user_login = $session->get('user_login');
        // $requestKuliahModel = new RequestKuliahModel();
        // $requestRuangModel = new RequestRuangModel();
        // $requestWaktuModel = new RequestWaktuModel();

        // $countRequest = $requestKuliahModel->countAll() + $requestRuangModel->countAll() + $requestWaktuModel->countAll();
        
        $semesterModel = new SemesterModel();
        $allTahunAkademik = (new TahunakademikModel())->findAll();

        $countPengampuTabel = [];
        $pengampuModel = new PengampuModel();

        foreach($allTahunAkademik as $tahun) {
            $countGanjil = $pengampuModel->where('id_semester', 1)->where('tahun_akademik', $tahun['tahun_akademik'])->countAllResults();
            $countGenap = $pengampuModel->where('id_semester', 2)->where('tahun_akademik', $tahun['tahun_akademik'])->countAllResults();
            array_push($countPengampuTabel, [
                'tahun_akademik' => $tahun['tahun_akademik'],
                'semester_ganjil_count' => $countGanjil,
                'semester_genap_count' => $countGenap
            ]);
        }

        $pengampu = $pengampuModel->findAll();
        $ruangModel = new RuangModel();
        $ruang = $ruangModel->findAll();
        $waktuModel = new WaktuModel();
        $waktu = $waktuModel->findAll();
        $dosenModel = new DosenModel();
        $allDosen = $dosenModel->findAll();
        $hariModel = new HariModel();
        $allHari = $hariModel->findAll();

        if(count($pengampu) == 0) {
            return redirect()->to('/pengampu')->with('status', 'Harap Mengisi Data Kelas Terlebih Dahulu!');
        }

        foreach($countPengampuTabel as $countPengampu){
            if($countPengampu['semester_ganjil_count'] == 0) {
                return redirect()->to('/pengampu')->with('status', 'Harap Menambahkan Data Kelas di Semester Ganjil Tahun Akademik '.$countPengampu['tahun_akademik']);
            }

            if($countPengampu['semester_genap_count'] == 0) {
                return redirect()->to('/pengampu')->with('status', 'Harap Menambahkan Data Kelas di Semester Genap Tahun Akademik '.$countPengampu['tahun_akademik']);
            }
        }

        if(count($ruang) == 0) {
            return redirect()->to('/ruang')->with('status', 'Harap Mengisi Data Ruang Terlebih Dahulu!');
        }

        if(count($waktu) == 0) {
            return redirect()->to('/waktu')->with('status', 'Harap Mengisi Data Waktu Terlebih Dahulu!');
        }

        foreach($countPengampuTabel as $countPengampu){
            $pengampu = $pengampuModel->where('tahun_akademik', $countPengampu['tahun_akademik'])->findAll();
            if ($pengampu[count($pengampu)-1]['id_pengampu'] != count($pengampu)) {
                for ($i=0; $i < count($pengampu); $i++) { 
                    $pengampuModel->update($pengampu[$i]['id_pengampu'], [
                        'id_pengampu' => $i+1,
                    ]);
                }
            }
        }

        if ($ruang[count($ruang)-1]['id_ruang'] != count($ruang)) {
            for ($i=0; $i < count($ruang); $i++) { 
                $ruangModel->update($ruang[$i]['id_ruang'], [
                    'id_ruang' => $i+1,
                ]);
            }
        }
        if ($waktu[count($waktu)-1]['id_waktu'] != count($waktu)) {
            for ($i = 0; $i < count($waktu); $i++) { 
                $waktuModel->update($waktu[$i]['id_waktu'], [
                    'id_waktu' => $i+1,
                ]);
            }
        }

        $algoritma_proses = [];
        $execution_time = [];

        return view('penjadwalankuliah.generatejadwal', compact('user_login', 'semesterModel->findAll()', 'algoritma_proses', 'countRequest', 'execution_time', 'allDosen', 'allHari', 'countPengampuTabel', 'allTahunAkademik'));
    }

    public function generate_action()
    {
        $request = $this->request;
        
        if ($request->isAJAX()) {
            if ($request->getPost('dosen')) {
                $namaDosen = $request->getPost('dosen');
                $dosenModel = new DosenModel();
                $idDosen = $dosenModel->where('nama', $namaDosen)->first()['id_dosen'];
                $semester = $request->getPost('semester');
                $tahun_akademik = $request->getPost('tahun_akademik');
                $idKelasBySemesterAndYear = (new PengampuModel())->where('id_dosen', $idDosen)->where('id_semester', $semester)->where('tahun_akademik', $tahun_akademik)->findAll();
                
                $kelasBySemesterAndYear = [];
                $kelasModel = new KelasModel();
                foreach ($idKelasBySemesterAndYear as $key => $kelas) {
                    $kelasBySemesterAndYear[$key] = $kelasModel->where('id_kelas', $kelas['id_kelas'])->where('tahun_akademik', $tahun_akademik)->first();
                }
                
                return $this->response->setJSON(['allKelas' => $kelasBySemesterAndYear]);
            }

            if ($request->getPost('hari')) {
                $idHari = $request->getPost('hari');
                $getIdJamByHari = (new WaktuModel())->where('id_hari', $idHari)->findAll();
                
                $allJamByIdJam = [];
                $jamModel = new JamModel();

                foreach ($getIdJamByHari as $key => $jam) {
                    $allJamByIdJam[$key] = $jamModel->where('id_jam', $jam['id_jam'])->first();
                }

                return $this->response->setJSON(['allJam' => $allJamByIdJam]);
            }

            if ($request->getPost('i')) {
                $getAllDosen = (new DosenModel())->findAll();
                $getAllHari = (new HariModel())->findAll();

                return $this->response->setJSON([
                    'dosen' => $getAllDosen,
                    'hari' => $getAllHari
                ]);
            }
        }
    }

    public function generatejadwal()
    {
        $session = session();
        $user_login = $session->get('user_login');
        // $countRequest = (new RequestKuliahModel())->countAll() + (new RequestRuangModel())->countAll() + (new RequestWaktuModel())->countAll();

        $semesterModel = new SemesterModel();
        $allDosen = (new DosenModel())->findAll();
        $allHari = (new HariModel())->findAll();
        $allTahunAkademik = (new TahunakademikModel())->findAll();
        $jumlahIndividu = $this->request->getPost('individu');
        $maxGenerasi = $this->request->getPost('generasi');
        $tahunAkademik = $this->request->getPost('tahun_akademik');
        $idSemester = $this->request->getPost('radioSemester');
        $showAlgorithm = $this->request->getPost('algoritma');
        $crossoverRate = $this->request->getPost('crossover_rate');

        $countPengampuTabel = [];
        foreach ($allTahunAkademik as $tahun) {
            $countGanjil = (new PengampuModel())->where('id_semester', 1)->where('tahun_akademik', $tahun['tahun_akademik'])->countAllResults();
            $countGenap = (new PengampuModel())->where('id_semester', 2)->where('tahun_akademik', $tahun['tahun_akademik'])->countAllResults();

            array_push($countPengampuTabel, [
                'tahun_akademik' => $tahun['tahun_akademik'],
                'semester_ganjil_count' => $countGanjil,
                'semester_genap_count' => $countGenap
            ]);
        }

        if(!$idSemester) {
            session()->setFlashdata('errorSemester', "Harap Memilih Semester Terlebih Dahulu!");
            return redirect()->back();
        }

        if(!$tahunAkademik) { 
            session()->setFlashdata('errorTahunAkademik', "Harap Memilih Tahun Akademik Terlebih Dahulu!");
            return redirect()->back();
        }

        if($maxGenerasi < 1) { 
            session()->setFlashdata('errorJumlahGenerasi', "Generasi Minimal 1!");
            return redirect()->back();
        }

        if($jumlahIndividu < 4) { 
            session()->setFlashdata('errorJumlahIndividu', "Individu Minimal 4!");
            return redirect()->back();
        }

        // Request prioritas kelas
        $kelas = $this->request->getPost('kelas');

        $hari = [];
        foreach ((array) $this->request->getPost('hari') as $h) {
            if ($h != null) {
                array_push($hari, $h);
            }
        }
        $jam = $this->request->getPost('jam');

        $id_waktu = [];
        foreach ((array) $hari as $key => $value) {
            array_push($id_waktu,
                (new WaktuModel())->where('id_hari', $value)->where('id_jam', $jam[$key])->first()['id_waktu']
            );
        }

        $id_pengampu = [];
        foreach ((array) $kelas as $key => $value) {
            array_push($id_pengampu,
                (new PengampuModel())->where('id_kelas', $value)->first()['id_pengampu']
            );
        }

        $prioritas_kelas = [];
        foreach ((array)$kelas as $key => $value) {
            array_push($prioritas_kelas, [
                'id_pengampu' => $id_pengampu[$key],
                'id_kelas' => $value,
                'id_waktu' => $id_waktu[$key]
            ]);
        }

        // Get kuliah, ruang, and waktu
        $pengampuTable = (new PengampuModel())->where('id_semester', $idSemester)->where('tahun_akademik', $tahunAkademik)->findAll();
        $ruangTable = (new RuangModel())->findAll();

        $firstIdRuang = $ruangTable[0]['id_ruang'];
        $lastIdRuang = $ruangTable[count($ruangTable) - 1]['id_ruang'];

        $waktuTable = (new WaktuModel())->findAll();
        $firstIdWaktu = $waktuTable[0]['id_waktu'];
        $lastIdWaktu = $waktuTable[count($waktuTable) - 1]['id_waktu'];

        function random_id_ruang($id_prodi) {
            $nama_prodi = (new ProdiModel())->where('id_prodi', $id_prodi)->first()['nama_prodi'];
            $ruangByProdi = (new RuangModel())->where('nama_prodi', $nama_prodi)->findAll();

            if (count($ruangByProdi) == 0) {
                $ruangByProdi = (new RuangModel())->findAll();
            }

            $allIdRuangByProdi = [];
            foreach ($ruangByProdi as $ruang) {
                array_push($allIdRuangByProdi, $ruang['id_ruang']);
            }

            return $allIdRuangByProdi[mt_rand(0, count($allIdRuangByProdi) - 1)];
        }

        function random_1($individu) {
            $random = [];
            for ($i = 0; $i < count($individu); $i++) { 
                $random[$i] = (rand(0, 1000) / 1000);
            }
            return $random;
        }

        function random_2($individu) {
            $length = count($individu) - 1;
            return rand(1, $length);
        }

        function individuWithDetail($individu, $tahun_akademik) {
            $individuWithDetail = [];
            for ($i = 0; $i < count($individu); $i++) {
                $individuWithDetail[$i] = [];
                for ($j = 0; $j < count($individu[$j]); $j++) { 
                    $id_mk = (new PengampuModel())->where('id_pengampu', $individu[$i][$j][0])
                        ->where('tahun_akademik', $tahun_akademik)
                        ->first()['id_mk'];
                    $id_dosen = [ 
                        'id' => (new PengampuModel())->where('id_pengampu', $individu[$i][$j][0])->first()['id_dosen'], 
                        'clash' => 0
                    ];
                    $id_kelas = (new PengampuModel())->where('id_pengampu', $individu[$i][$j][0])
                        ->where('tahun_akademik', $tahun_akademik)
                        ->first()['id_kelas'];
                    $jumlah_sks = (new MatakuliahModel())->where('id_mk', $id_mk)->first()['sks'];
                    $nama_ruang = [
                        'id' => (new RuangModel())->where('id_ruang', $individu[$i][$j][1])->first()['nama_ruang'], 
                        'clash' => 0
                    ];
                    $id_hari = (new WaktuModel())->where('id_waktu', $individu[$i][$j][2])->first()['id_hari'];
                    $id_jam = (new WaktuModel())->where('id_waktu', $individu[$i][$j][2])->first()['id_jam'];

                    array_push($individuWithDetail[$i], [
                        'id_mk' => $id_mk, 
                        'id_dosen' => $id_dosen, 
                        'id_kelas' => $id_kelas, 
                        'jumlah_sks' => $jumlah_sks, 
                        'nama_ruang' => $nama_ruang, 
                        'id_hari' => $id_hari, 
                        'id_jam' => $id_jam
                    ]);            
                }
            }

            // Clash detection logic here...
            $clashDosen = [];
            $clashRuang = [];

            for ($i = 0; $i < count($individuWithDetail); $i++) { 
                for ($a = 0; $a < count($individuWithDetail[$i]); $a++) { 
                    for ($b = 0; $b < count($individuWithDetail[$i]); $b++) { 
                        if ($a == $b) {
                            continue;
                        }

                        // Check class dosen
                        if ($individuWithDetail[$i][$a]['id_dosen']['id'] == $individuWithDetail[$i][$b]['id_dosen']['id']) { 
                            if ($individuWithDetail[$i][$a]['id_hari'] == $individuWithDetail[$i][$b]['id_hari']) {
                                if ($individuWithDetail[$i][$a]['id_jam'] > $individuWithDetail[$i][$b]['id_jam']) {
                                    if (($individuWithDetail[$i][$b]['id_jam'] - 1) + $individuWithDetail[$i][$b]['jumlah_sks'] >= $individuWithDetail[$i][$a]['id_jam']) {
                                        array_push($clashDosen, "$i-$a-$b");
                                        $individuWithDetail[$i][$a]['id_dosen']['clash'] = 1;
                                        $individuWithDetail[$i][$b]['id_dosen']['clash'] = 1;
                                    }
                                } elseif ($individuWithDetail[$i][$a]['id_jam'] < $individuWithDetail[$i][$b]['id_jam']) {
                                    if (($individuWithDetail[$i][$a]['id_jam'] - 1) + $individuWithDetail[$i][$a]['jumlah_sks'] >= $individuWithDetail[$i][$b]['id_jam']) {
                                        array_push($clashDosen, "$i-$a-$b");
                                        $individuWithDetail[$i][$a]['id_dosen']['clash'] = 1;
                                        $individuWithDetail[$i][$b]['id_dosen']['clash'] = 1;
                                    }
                                } else {
                                    array_push($clashDosen, "$i-$a-$b");
                                    $individuWithDetail[$i][$a]['id_dosen']['clash'] = 1;
                                    $individuWithDetail[$i][$b]['id_dosen']['clash'] = 1;
                                }
                            }
                        }
                        // Check class ruang
                        if ($individuWithDetail[$i][$a]['nama_ruang']['id'] == $individuWithDetail[$i][$b]['nama_ruang']['id']) { 
                            if ($individuWithDetail[$i][$a]['id_hari'] == $individuWithDetail[$i][$b]['id_hari']) {
                                if ($individuWithDetail[$i][$a]['id_jam'] > $individuWithDetail[$i][$b]['id_jam']) {
                                    if (($individuWithDetail[$i][$b]['id_jam'] - 1) + $individuWithDetail[$i][$b]['jumlah_sks'] >= $individuWithDetail[$i][$a]['id_jam']) {
                                        array_push($clashRuang, "$i-$a-$b");
                                        $individuWithDetail[$i][$a]['nama_ruang']['clash'] = 1;
                                        $individuWithDetail[$i][$b]['nama_ruang']['clash'] = 1;
                                    }
                                } elseif ($individuWithDetail[$i][$a]['id_jam'] < $individuWithDetail[$i][$b]['id_jam']) {
                                    if (($individuWithDetail[$i][$a]['id_jam'] - 1) + $individuWithDetail[$i][$a]['jumlah_sks'] >= $individuWithDetail[$i][$b]['id_jam']) {
                                        array_push($clashRuang, "$i-$a-$b");
                                        $individuWithDetail[$i][$a]['nama_ruang']['clash'] = 1;
                                        $individuWithDetail[$i][$b]['nama_ruang']['clash'] = 1;
                                    }
                                } else {
                                    array_push($clashRuang, "$i-$a-$b");
                                    $individuWithDetail[$i][$a]['nama_ruang']['clash'] = 1;
                                    $individuWithDetail[$i][$b]['nama_ruang']['clash'] = 1;
                                }
                            }
                        }
                    }
                }
            }

            return $individuWithDetail;
        }

        function codeIntoNameIndividuDetail($individuWithDetail, $tahun_akademik) {
            $codeIntoNameIndividuDetail = [];

            for ($i = 0; $i < count($individuWithDetail); $i++) {
                for ($j = 0; $j < count($individuWithDetail[$i]); $j++) {
                    $codeIntoNameIndividuDetail[$i][$j] = [
                        'id_kelas' => $individuWithDetail[$i][$j]['id_kelas'],
                        'matkul' => (new MatakuliahModel())->where('id_mk', $individuWithDetail[$i][$j]['id_mk'])
                                                  ->where('tahun_akademik', $tahun_akademik)
                                                  ->first()['nama_matkul'],
                        'dosen' => (new DosenModel())->where('id_dosen', $individuWithDetail[$i][$j]['id_dosen']['id'])->first()['nama'],
                        'kelas' => (new KelasModel())->where('id_kelas', $individuWithDetail[$i][$j]['id_kelas'])
                                                   ->where('tahun_akademik', $tahun_akademik)
                                                   ->first()['kelas'],
                        'jumlah_sks' => $individuWithDetail[$i][$j]['jumlah_sks'],
                        'nama_ruang' => $individuWithDetail[$i][$j]['nama_ruang']['id'],
                        'hari' => (new HariModel())->where('id_hari', $individuWithDetail[$i][$j]['id_hari'])->first()['nama_hari'],
                        'jam' => (new JamModel())->where('id_jam', $individuWithDetail[$i][$j]['id_jam'])->first()['jam'],
                    ];
                }
            }

            return $codeIntoNameIndividuDetail;
        }

        function fitness($individuWithDetail) {
            $fitness_function = [];
            $CD = [];
            $CR = [];

            for ($i = 0; $i < count($individuWithDetail); $i++) { 
                $CD[$i] = 0;
                $CR[$i] = 0;
                for ($j = 0; $j < count($individuWithDetail[$i]); $j++) { 
                    if($individuWithDetail[$i][$j]['id_dosen']['clash'] == 1) {
                        $CD[$i]++;
                    }
                    if($individuWithDetail[$i][$j]['nama_ruang']['clash'] == 1) {
                        $CR[$i]++;
                    }
                }

                $CD[$i] = (int) ceil($CD[$i] / 2);
                $CR[$i] = (int) ceil($CR[$i] / 2);
            }
            $fitness_function["CD"] = $CD;
            $fitness_function["CR"] = $CR;

            $fitnessIndividu = [];
            $total_nilai_fitness = 0;

            for ($i = 0; $i < count($individuWithDetail); $i++) { 
                $fitnessIndividu[$i] = 1 / (1 + ($CD[$i] + $CR[$i]));
                $total_nilai_fitness += $fitnessIndividu[$i];
            }

            $fitness_function["fitness_individu"] = $fitnessIndividu;
            $fitness_function["total_fitness"] = $total_nilai_fitness;

            $hasOne = array_keys($fitnessIndividu, 1);
            $fixJadwal = [];

            if ($hasOne) {
                for ($i = 0; $i < count($hasOne); $i++) { 
                    $fixJadwal[$i] = $individuWithDetail[$hasOne[$i]];
                }
            }

            $fitness_function["fix_jadwal"] = $fixJadwal;
            return $fitness_function;
        }

        function allClashChromosome($individu, $tahun_akademik) {
            $individuWithDetail = individuWithDetail($individu, $tahun_akademik);
            $allClashChromosome = [];

            for ($i = 0; $i < count($individuWithDetail); $i++) {
                for ($j = 0; $j < count($individuWithDetail[$i]); $j++) {
                    if ($individuWithDetail[$i][$j]["id_dosen"]["clash"] == 1 || $individuWithDetail[$i][$j]["nama_ruang"]["clash"] == 1) {
                        array_push($allClashChromosome, [
                            "kromosom" => $individu[$i][$j],
                            "index_individu" => $i,
                            "index_kromosom" => $j
                        ]);
                    }
                }
            }

            return $allClashChromosome;
        }

        // Initialize population
        $individu = [];
        for ($i = 0; $i < $jumlahIndividu; $i++) { 
            $individu[$i] = [];
            foreach ($pengampuTable as $pengampu) {
                if (count($prioritas_kelas) != 0) {
                    $tea = 0;
                    for ($j = 0; $j < count($prioritas_kelas); $j++) {
                        if ($pengampu['id_kelas'] == $prioritas_kelas[$j]['id_kelas']) {
                            $tea = $prioritas_kelas[$j];
                        }

                        if ($j == count($prioritas_kelas) - 1) {
                            if ($tea != 0) {
                                array_push($individu[$i], [
                                    $pengampu['id_pengampu'], 
                                    random_id_ruang($pengampu['id_prodi']),
                                    $tea['id_waktu']
                                ]);
                            } else {
                                array_push($individu[$i], [
                                    $pengampu['id_pengampu'], 
                                    random_id_ruang($pengampu['id_prodi']),
                                    rand($firstIdWaktu, $lastIdWaktu)
                                ]);
                            }
                        }
                    }
                } else {
                    array_push($individu[$i], [
                        $pengampu['id_pengampu'], 
                        random_id_ruang($pengampu['id_prodi']),
                        rand($firstIdWaktu, $lastIdWaktu)
                    ]);
                }
            }
        }

        // Algorithm start
        $algoritma_proses = [];
        $time_start = microtime(true); 
        $fixJadwal = [];
        $generasi = 0;

        while ($generasi < $maxGenerasi && count($fixJadwal) == 0) {
            $individuWithDetail = individuWithDetail($individu, $tahunAkademik);
            $algoritma_proses[$generasi]["individu"] = $individu;
            $algoritma_proses[$generasi]["individuWithDetail"] = $individuWithDetail;
            $algoritma_proses[$generasi]["individuWithDetail_with_name"] = codeIntoNameIndividuDetail($individuWithDetail, $tahunAkademik);

            // Fitness Function
            $fitness_function = fitness($individuWithDetail);
            $CD = $fitness_function['CD'];
            $CR = $fitness_function['CR'];
            $fitnessIndividu = $fitness_function['fitness_individu'];
            $total_nilai_fitness = $fitness_function['total_fitness'];
            $fixJadwal = $fitness_function['fix_jadwal'];

            $algoritma_proses[$generasi]["CD"] = $CD;
            $algoritma_proses[$generasi]["CR"] = $CR;
            $algoritma_proses[$generasi]["fitness_individu"] = $fitnessIndividu;
            $algoritma_proses[$generasi]["total_fitness"] = $total_nilai_fitness;
            $algoritma_proses[$generasi]["fix_jadwal"] = $fixJadwal;

            if ($fixJadwal) break;

            // SELECTION (Roullete Wheel)
            $probabilitas = [];
            for ($i = 0; $i < count($fitnessIndividu); $i++) { 
                $probabilitas[$i] = $fitnessIndividu[$i] / $total_nilai_fitness;
            }

            $algoritma_proses[$generasi]["probabilitas"] = $probabilitas;

            // Calculate cumulative probabilities
            $kumulatif = [];
            $total_kumulatif = 0;
            for ($i = 0; $i < count($probabilitas); $i++) { 
                $kumulatif[$i] = $probabilitas[$i] + $total_kumulatif;
                $total_kumulatif = $kumulatif[$i];
            }

            $algoritma_proses[$generasi]["kumulatif"] = $kumulatif;
            $algoritma_proses[$generasi]["total_kumulatif"] = $total_kumulatif;

            // Generate random numbers for selection
            $random = random_1($individu);
            $algoritma_proses[$generasi]["random1_selection"] = $random;

            // Select new individuals
            $newIndividu = [];
            $listNewIndividu = [];
            for ($i = 0; $i < count($individu); $i++) { 
                for ($j = 0; $j < count($random); $j++) { 
                    $newIndividu[$i] = $random[$i] <= $kumulatif[$j] ? $individu[$j] : [];
                    if ($newIndividu[$i]) {
                        array_push($listNewIndividu, $j);
                        break;
                    }
                }
            }

            $algoritma_proses[$generasi]["list_new_individu_selection"] = $listNewIndividu;
            $algoritma_proses[$generasi]["new_individu_selection"] = $newIndividu;

            // CROSSOVER
            $PC = $crossoverRate / 100;
            $indexIndividuSelected = [];

            $algoritma_proses[$generasi]["PC"] = $PC;

            while (count($indexIndividuSelected) < 3) {
                $random = random_1($individu);
                for ($i = 0; $i < count($random); $i++) { 
                    if ($random[$i] < $PC) {
                        array_push($indexIndividuSelected, $i);
                    }
                }

                if (count($indexIndividuSelected) < 3) {
                    $indexIndividuSelected = [];
                }
            }

            $algoritma_proses[$generasi]["random1_crossover"] = $random;
            $algoritma_proses[$generasi]["index_best_individu"] = $indexIndividuSelected;

            $parents = [];
            for ($i = 0; $i < count($indexIndividuSelected); $i++) { 
                $parents[$i] = [];
                $lastIndex = count($indexIndividuSelected) - 1;

                $father = $indexIndividuSelected[$i];
                if ($i == $lastIndex) {
                    $mother = $indexIndividuSelected[0];
                } else {
                    $mother = $indexIndividuSelected[$i + 1];
                }
                $parents[$i] = [
                    'father' => $father,
                    'mother' => $mother,
                    'cut-point' => random_2($individu[0]),
                ];
            }

            $algoritma_proses[$generasi]["parents"] = $parents;

            // Create offspring
            $offSpring = [];
            for ($i = 0; $i < count($parents); $i++) { 
                $offSpring[$i] = [];
                $first_kromosom = [];
                $last_kromosom = [];

                array_push($first_kromosom, array_chunk($newIndividu[$parents[$i]['father']], $parents[$i]['cut-point'])[0]);

                $new_cut_point = count($newIndividu[$parents[$i]['father']]) - $parents[$i]['cut-point'];

                array_push($last_kromosom, array_reverse(array_chunk(array_reverse($newIndividu[$parents[$i]['mother']]), $new_cut_point)[0]));

                array_push($offSpring[$i], array_merge($first_kromosom[0], $last_kromosom[0]));
                $offSpring[$i] = $offSpring[$i][0];
            }

            $algoritma_proses[$generasi]["offSpring"] = $offSpring;

            for ($i = 0; $i < count($indexIndividuSelected); $i++) { 
                $newIndividu[$indexIndividuSelected[$i]] = $offSpring[$i];
            }

            $individuWithDetail = individuWithDetail($newIndividu, $tahunAkademik);

            $algoritma_proses[$generasi]["new_individu_crossover"] = $newIndividu;
            $algoritma_proses[$generasi]["new_individu_crossover_with_detail"] = $individuWithDetail;

            // Fitness Function
            $fitness_function = fitness($individuWithDetail);
            $CD = $fitness_function['CD'];
            $CR = $fitness_function['CR'];
            $fitnessIndividu = $fitness_function['fitness_individu'];
            $total_nilai_fitness = $fitness_function['total_fitness'];
            $fixJadwal = $fitness_function['fix_jadwal'];

            $algoritma_proses[$generasi]["new_CD"] = $CD;
            $algoritma_proses[$generasi]["new_CR"] = $CR;
            $algoritma_proses[$generasi]["new_fitness_individu"] = $fitnessIndividu;
            $algoritma_proses[$generasi]["new_total_fitness"] = $total_nilai_fitness;
            $algoritma_proses[$generasi]["new_fix_jadwal"] = $fixJadwal;

            if ($fixJadwal) break;

            // Mutation
            $allClashChromosome = allClashChromosome($newIndividu, $tahunAkademik);
            $algoritma_proses[$generasi]["all_clash_chromosome"] = $allClashChromosome;

            for ($i = 0; $i < count($allClashChromosome); $i++) { 
                $nama_prodi = (new RuangModel())->where('id_ruang', $allClashChromosome[$i]['kromosom'][1])->first()['nama_prodi'];
                $id_prodi = (new ProdiModel())->where('nama_prodi', $nama_prodi)->first()['id_prodi'];

                if (count($prioritas_kelas) != 0) {
                    $tea = 0;
                    for ($j = 0; $j < count($prioritas_kelas); $j++) {
                        if ($allClashChromosome[$i]['kromosom'][0] == $prioritas_kelas[$j]['id_pengampu']) {
                            $tea = $prioritas_kelas[$j];
                        }

                        if ($j == count($prioritas_kelas) - 1) {
                            if ($tea != 0) {
                                $mutatedChro = [
                                    $allClashChromosome[$i]['kromosom'][0],
                                    random_id_ruang($id_prodi),
                                    $tea['id_waktu']
                                ];
                            } else {
                                $mutatedChro = [
                                    $allClashChromosome[$i]['kromosom'][0],
                                    random_id_ruang($id_prodi),
                                    rand($firstIdWaktu, $lastIdWaktu)
                                ];
                            }
                        }
                    }
                } else {
                    $mutatedChro = [
                        $allClashChromosome[$i]['kromosom'][0],
                        random_id_ruang($id_prodi),
                        rand($firstIdWaktu, $lastIdWaktu)
                    ];
                }

                $algoritma_proses[$generasi]["mutated_chromosome"][$i] = $mutatedChro;

                $newIndividu[$allClashChromosome[$i]['index_individu']][$allClashChromosome[$i]['index_kromosom']] = $mutatedChro;
            }

            $algoritma_proses[$generasi]["new_individu_has_mutated"] = $newIndividu;
            $individu = $newIndividu;
            $generasi++;
        }

        $execution_time = microtime(true) - $time_start;
        if (!$showAlgorithm) {
            $algoritma_proses = [];
        }

        return view('penjadwalankuliah.generatejadwal', compact(
            'user_login', 'semesterModel->findAll()', 'algoritma_proses', 'execution_time', 
            'fixJadwal', 'idSemester', 'countRequest', 'tahunAkademik', 
            'allTahunAkademik', 'allDosen', 'allHari', 'countPengampuTabel'
        ));
    }

    public function hasilgenerate($jadwal_index)
    {
        $session = session();
        $allJadwal = $session->get('jadwal');
        $id_semester = $session->get('idSemester');
        $tahun_akademik = $session->get('tahunAkademik');

        $semesterModel = new SemesterModel();
        $nama_semester = $semesterModel->where('id_semester', $id_semester)->first()['nama_semester'];
        $jadwalModel = new jadwalModel();
        $jadwalTable = $jadwalModel->where('semester', $nama_semester)->findAll();

        $fixJadwal = $allJadwal[$jadwal_index];

        if (count($jadwalTable) > 0) {
            $jadwalModel->where('semester', $nama_semester)->where('tahun_akademik', $tahun_akademik)->delete();
        }

        // Insert data ke tabel jadwal
        foreach ($fixJadwal as $row) {
            // Mencari jam keluar
            $menit_dalam_sks = $row['jumlah_sks'] * 50;
            $jam_masuk = (new JamModel())->where('id_jam', $row['id_jam'])->first()['jam'];
            $explode_jam = explode(':', $jam_masuk);
            $menit_dalam_jam_masuk = $explode_jam[0] * 60 + $explode_jam[1];
            $total_menit_digabungkan = $menit_dalam_jam_masuk + $menit_dalam_sks;
            $jam = floor($total_menit_digabungkan / 60);
            $menit = $total_menit_digabungkan % 60;
            if ($menit == "0") $menit = "00";
            $jam_keluar = $jam . ":" . $menit;

            // Masukkan jadwal ke tabel jadwal
            $jadwalModel->insert([
                'matkul' => (new MatakuliahModel())->where('id_matkul', $row['id_matkul'])->first()['nama_matkul'],
                'dosen' => (new DosenModel())->where('id_dosen', $row['id_dosen']['id'])->first()['nama'],
                'kelas' => (new KelasModel())->where('id_kelas', $row['id_kelas'])->first()['kelas'],
                'jumlah_sks' => $row['jumlah_sks'],
                'nama_ruang' => $row['nama_ruang']['id'],
                'hari' => (new HariModel())->where('id_hari', $row['id_hari'])->first()['nama_hari'],
                'jam_masuk' => (new JamModel())->where('id_jam', $row['id_jam'])->first()['jam'],
                'jam_keluar' => $jam_keluar,
                'semester' => $nama_semester,
                'tahun_akademik' => $tahun_akademik
            ]);

            // Masukkan tahun akademik ke tabel tahun_akademik jika belum ada
            if (!(new TahunakademikModel())->where('tahun_akademik', $tahun_akademik)->first()) {
                (new TahunakademikModel())->insert(['tahun_akademik' => $tahun_akademik]);
            }
        }

        return redirect()->to('/hasiljadwal');
    }

    public function hasiljadwal()
    {
        $session = session();
        $user_login = $session->get('user_login');
        // $countRequest = (new RequestKuliahModel())->countAll() + (new RequestRuangModel())->countAll() + (new RequestWaktuModel())->countAll();

        // Ambil jadwal per semester
        $semesterModel = new SemesterModel();
        $semester = $semesterModel->findAll();
        $jadwal = [];

        foreach ($semester as $i => $sem) {
            $jadwal[$i] = (new JadwalModel())->where('semester', $sem['nama_semester'])->findAll();
        }

        // List tahun akademik yang ada
        $tahun_akademik = (new TahunakademikModel())->findAll();
        return view('penjadwalankuliah.hasiljadwal', compact('user_login', 'jadwal', 'countRequest', 'semester', 'tahun_akademik'));
    }
}
