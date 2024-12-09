<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\JamModel;
use App\Models\WaktutidakbersediaModel;
use App\Models\KelasModel;
use App\Models\ProdiModel;
use App\Models\SemesterModel;
use App\Models\PenjadwalanModel;
use App\Models\PengampuModel;
use App\Models\TahunakademikModel;
use App\Models\DosenModel;
use App\Models\HariModel;
use App\Models\UserModel;
use App\Models\MatakuliahModel;
use App\Models\RuangModel;

class Penjadwalan2 extends Controller {
    private $PRAKTIKUM = 'PRAKTIKUM';
    private $TEORI = 'TEORI';
    private $LABORATORIUM = 'LABORATORIUM';

    private $jenis_semester;
    private $tahun_akademik;
    private $populasi;
    private $crossOver;
    private $mutasi;

    private $pengampu = [];
    private $sks = [];
    private $dosen = [];
    private $prodi = [];
    private $jurusan;
    private $kuota_pengampu = [];
    private $ruang_pilihan = [];
    private $semester = [];
    
    private $jam = [];
    private $hari = [];
    private $idosen = [];
    private $itersedia = [];
    private $bayangan = [];

    private $waktu_dosen = [];
    private $waktu_tersedia = [];
    private $jenis_mk = [];
    
    private $ruangReguler = [];
    private $ruangLaboratorium = [];
    private $kuota_ruangReguler = [];
    private $kuota_ruangLaboratorium = [];
    private $logAmbilData;
    private $logInisialisasi;

    public function __construct() {
        helper(['url', 'form', 'date']);
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
        $this->userModel = new UserModel();
        $this->mapelModel = new MatakuliahModel();
        $this->ruangModel = new RuangModel();
    }

    public function index() {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('admin/index'));
        }

        $data = [];
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'semester_tipe' => 'required',
                'tahun_akademik' => 'required',
                'jumlah_populasi' => 'required',
                'probabilitas_crossover' => 'required',
                'probabilitas_mutasi' => 'required',
                'jumlah_generasi' => 'required'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                $start = microtime(true);

                // Ambil Data dari Request
                $jenis_semester = $this->request->getPost('semester_tipe');
                $tahun_akademik = $this->request->getPost('tahun_akademik');
                $jumlah_populasi = $this->request->getPost('jumlah_populasi');
                $crossOver = $this->request->getPost('probabilitas_crossover');
                $mutasi = $this->request->getPost('probabilitas_mutasi');
                $jumlah_generasi = $this->request->getPost('jumlah_generasi');
                $prodi = $this->request->getPost('prodi');

                // Logika penjadwalan... (sama seperti yang ada pada controller Anda)

                // Cek jumlah populasi
                $rs_data = $this->penjadwalanModel->getPengampu($jenis_semester, $tahun_akademik, $prodi);
                if ($rs_data->num_rows() == 0) {
                    $data['msg'] = 'Tidak Ada Data dengan Semester dan Tahun Akademik ini <br>Data yang tampil dibawah adalah data dari proses sebelumnya';
                } else {
                    // Menghitung jumlah populasi
                    $jumlah_populasi = ($rs_data->num_rows() % 2 == 0) ? $rs_data->num_rows() : $rs_data->num_rows() + 1;

                    $this->ambilData($jenis_semester, $tahun_akademik, $jumlah_populasi, $prodi);
                    $this->inisialisai($jumlah_populasi);

                    $found = false;

                    for ($i = 0; $i < $jumlah_generasi; $i++) {
                        $fitness = $this->hitungFitness($jumlah_populasi, $prodi);
                        $this->seleksi($fitness, $jumlah_populasi);
                        $this->startCrossOver($jumlah_populasi, $crossOver);
                        $fitnessAfterMutation = $this->mutasi($jumlah_populasi, $mutasi, $prodi);

                        for ($j = 0; $j < count($fitnessAfterMutation); $j++) {
                            if ($fitnessAfterMutation[$j] == 1) {
                                $this->penjadwalanModel->truncateJadwal();
                                $jadwal_kuliah = $this->getIndividu($j);
                                
                                foreach ($jadwal_kuliah as $item) {
                                    $kode_pengampu = intval($item[0]);
                                    $kode_jam = intval($item[1]);
                                    $kode_hari = intval($item[2]);
                                    $kode_ruang = intval($item[3]);
                                    $this->penjadwalanModel->simpanJadwal($kode_pengampu, $kode_jam, $kode_hari, $kode_ruang);
                                }

                                $found = true;
                                break;
                            }
                        }

                        if ($found) break;
                    }

                    if (!$found) {
                        $data['msg'] = 'Tidak Ditemukan Solusi Optimal';
                    } else {
                        $total_time = microtime(true) - $start;
                        $total_menit = round($total_time / 60, 4);
                        $data['waktu'] = "Selesai dalam " . $total_menit . " menit";
                    }
                }
            } else {
                $data['msg'] = $validation->getErrors();
            }
        }

        $data['page_name'] = 'penjadwalan';
        $data['page_title'] = 'Penjadwalan';
        $data['rs_tahun'] = $this->tahunModel->semuaTahun();
        $data['rs_jadwal'] = $this->penjadwalanModel->get();

        return view('penjadwalan', $data);
    }

    public function ambilData($jenis_semester, $tahun_akademik, $jumlah_populasi, $prodi) {
        $this->jenis_semester = $jenis_semester;
        $this->tahun_akademik = $tahun_akademik;
        $this->populasi = $jumlah_populasi;

        // Ambil data dari database
        $this->pengampu = $this->penjadwalanModel->getPengampuData($jenis_semester, $tahun_akademik, $prodi);

        // Isi jam dan hari yang tersedia
        $this->jam = $this->jamModel->findAll();
        $this->hari = $this->hariModel->findAll();

        $this->ruangReguler = $this->penjadwalanModel->getRuangReguler($prodi);
        $this->ruangLaboratorium = $this->penjadwalanModel->getRuangLaboratorium($prodi);
        $this->waktu_dosen = $this->penjadwalanModel->getWaktudosen();

        // Ambil waktu yang sudah digunakan
        if ($prodi) {
            $this->itersedia = $this->penjadwalanModel->getWaktuTersedia($this->jenis_semester, $this->tahun_akademik, $prodi);
        }
    }

    public function inisialisai($jumlah_populasi) {
        // Inisialisasi individu
        $this->populasi = $jumlah_populasi;
        $jumlah_pengampu = count($this->pengampu);
        $jumlah_jam = count($this->jam);
        $jumlah_hari = count($this->hari);
        $jumlah_ruang_reguler = count($this->ruangReguler);
        $jumlah_ruang_lab = count($this->ruangLaboratorium);
        
        for ($i = 0; $i < $this->populasi; $i++) {
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                $sks = $this->sks[$j];

                $this->individu[$i][$j][0] = $j;

                // Penentuan jam secara acak
                if ($sks == 1) {
                    $this->individu[$i][$j][1] = mt_rand(0, $jumlah_jam - 1);
                } elseif ($sks == 2) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlah_jam - 1) - 1);
                } elseif ($sks == 3) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlah_jam - 1) - 2);
                } elseif ($sks == 4) {
                    $this->individu[$i][$j][1] = mt_rand(0, ($jumlah_jam - 1) - 3);
                }

                $this->individu[$i][$j][2] = mt_rand(0, $jumlah_hari - 1); // Penentuan hari secara acak
                
                if ($this->jenis_mk[$j] === $this->TEORI) {
                    $this->individu[$i][$j][3] = intval($this->ruangReguler[mt_rand(0, $jumlah_ruang_reguler - 1)]);
                } else if ($this->jenis_mk[$j] === $this->LABORATORIUM) {
                    $this->individu[$i][$j][3] = intval($this->ruangLaboratorium[mt_rand(0, $jumlah_ruang_lab - 1)]);
                }
            }
        }
    }

    private function cekFitness($indv, $prodi) {
        $penalty = 0;
        $jumlah_pengampu = count($this->pengampu);

        for ($i = 0; $i < $jumlah_pengampu; $i++) {
            $sks = intval($this->sks[$i]);
            $jam_a = intval($this->individu[$indv][$i][1]);
            $hari_a = intval($this->individu[$indv][$i][2]);
            $ruang_a = intval($this->individu[$indv][$i][3]);
            $dosen_a = intval($this->dosen[$i]);
            $kuota = intval($this->kuota_pengampu[$i]);

            // Cek bentrok ruang dan waktu
            for ($j = 0; $j < $jumlah_pengampu; $j++) {
                if ($i == $j) continue;

                $jam_b = intval($this->individu[$indv][$j][1]);
                $hari_b = intval($this->individu[$indv][$j][2]);
                $ruang_b = intval($this->individu[$indv][$j][3]);
                $dosen_b = intval($this->dosen[$j]);

                if ($jam_a == $jam_b && $hari_a == $hari_b && $ruang_a == $ruang_b) {
                    $penalty++;
                }

                // Tambahkan logika lain untuk sks >= 2, 3, 4 di sini...
                if ($sks >= 2 && $jam_a + 1 == $jam_b && $hari_a == $hari_b && $ruang_a == $ruang_b) {
                    $penalty++;
                }

                // Penanganan bentrok dosen
                if ($jam_a == $jam_b && $hari_a == $hari_b && $dosen_a == $dosen_b) {
                    $penalty++;
                }
            }
        }

        return floatval(1 / (1 + $penalty));
    }

    public function hitungFitness($jumlah_populasi, $prodi) {
        $fitness = [];
        for ($indv = 0; $indv < $this->populasi; $indv++) {
            $fitness[$indv] = $this->cekFitness($indv, $prodi);
        }
        return $fitness;
    }

    public function seleksi($fitness, $jumlah_populasi) {
        // Proses seleksi berdasarkan nilai fitness
        $rank = [];
        for ($i = 0; $i < $jumlah_populasi; $i++) {
            $rank[$i] = 1;
            for ($j = 0; $j < $jumlah_populasi; $j++) {
                if ($i != $j && $fitness[$i] > $fitness[$j]) {
                    $rank[$i]++;
                }
            }
        }

        $total = array_sum($rank);
        for ($i = 0; $i < $jumlah_populasi; $i++) {
            $target = mt_rand(1, $total);
            $cek = 0;
            for ($j = 0; $j < count($rank); $j++) {
                $cek += $rank[$j];
                if ($cek >= $target) {
                    $this->induk[$i] = $j;
                    break;
                }
            }
        }
    }

    public function startCrossOver($jumlah_populasi, $crossOver) {
        $individu_baru = [];
        for ($i = 0; $i < $jumlah_populasi; $i += 2) {
            $cr = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
            if ($cr < $crossOver) {
                $a = mt_rand(0, count($this->pengampu) - 2);
                $b = mt_rand($a, count($this->pengampu) - 1);
                
                for ($j = 0; $j < count($this->pengampu); $j++) {
                    if ($j < $a) {
                        $individu_baru[$i][$j] = $this->individu[$this->induk[$i]][$j];
                        $individu_baru[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                    } elseif ($j < $b) {
                        $individu_baru[$i][$j] = $this->individu[$this->induk[$i + 1]][$j];
                        $individu_baru[$i + 1][$j] = $this->individu[$this->induk[$i]][$j];
                    } else {
                        $individu_baru[$i][$j] = $this->individu[$this->induk[$i]][$j];
                        $individu_baru[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                    }
                }
            } else {
                for ($j = 0; $j < count($this->pengampu); $j++) {
                    $individu_baru[$i][$j] = $this->individu[$this->induk[$i]][$j];
                    $individu_baru[$i + 1][$j] = $this->individu[$this->induk[$i + 1]][$j];
                }
            }
        }

        $this->individu = $individu_baru;
    }

    public function mutasi($jumlah_populasi, $mutasi, $prodi) {
        $fitness = [];
        for ($i = 0; $i < $jumlah_populasi; $i++) {
            if (mt_rand() / mt_getrandmax() < $mutasi) {
                $krom = mt_rand(0, count($this->pengampu) - 1);
                $sks = intval($this->sks[$krom]);
                $this->individu[$i][$krom][1] = mt_rand(0, ($sks <= 4 ? $sks - 1 : 0)); // Ubah jam
                $this->individu[$i][$krom][2] = mt_rand(0, count($this->hari) - 1); // Ubah hari

                // Ubah ruang
                if ($this->jenis_mk[$krom] === $this->TEORI) {
                    $this->individu[$i][$krom][3] = intval($this->ruangReguler[mt_rand(0, count($this->ruangReguler) - 1)]);
                } else {
                    $this->individu[$i][$krom][3] = intval($this->ruangLaboratorium[mt_rand(0, count($this->ruangLaboratorium) - 1)]);
                }
            }
            $fitness[$i] = $this->cekFitness($i, $prodi);
        }
        return $fitness;
    }
    public function getIndividu($indv) {
        $individu_solusi = [];
        for ($j = 0; $j < count($this->pengampu); $j++) {
            $individu_solusi[$j][0] = intval($this->pengampu[$this->individu[$indv][$j][0]]);
            $individu_solusi[$j][1] = intval($this->jam[$this->individu[$indv][$j][1]]);
            $individu_solusi[$j][2] = intval($this->hari[$this->individu[$indv][$j][2]]);                        
            $individu_solusi[$j][3] = intval($this->individu[$indv][$j][3]);            
        }
        return $individu_solusi;
    }

    public function excelReport() {
        $query = $this->penjadwalanModel->get();
        if (!$query) {
            return false;
        }

        // Load PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        
        $objPHPExcel = new \PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
        $objPHPExcel->setActiveSheetIndex(0);

        // Field names in the first row
        $fields = $query->listFields();
        $col = 0;
        foreach ($fields as $field) {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach ($query->getResult() as $data) {
            $col = 0;
            foreach ($fields as $field) {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }
            $row++;
        }
        
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Jadwal_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
    }

    public function simpanJadwal() {
        $jadwal = $this->penjadwalanModel->get();
        foreach ($jadwal->getResult() as $k) {
            $semester_tipe = $k->semester_tipe;
            $tahun_akademik = $k->tahun_akademik;
            $prodi = $k->kode_prodi;
        }

        $banyak_prodi = $this->penjadwalanModel->cekBanyakProdi($semester_tipe, $tahun_akademik);
        $riwayat = $this->penjadwalanModel->semuaJadwal($semester_tipe, $tahun_akademik);
        
        foreach ($banyak_prodi as $b) {
            if ($b->banyak > 1) {
                $cek = $this->penjadwalanModel->cekSemuaJadwal($semester_tipe, $tahun_akademik);
                if ($cek) {
                    foreach ($cek as $j) {
                        $id = $j->kode_riwayat;
                        $this->penjadwalanModel->hapusRiwayatJadwal($id);
                    }
                }

                foreach ($jadwal->getResult() as $j) {
                    $kode_pengampu = $j->kode_pengampu;
                    $kode_jam = $j->kode_jam;
                    $kode_hari = $j->kode_hari;
                    $kode_ruang = $j->kode_ruang;
                    $this->penjadwalanModel->simpanJadwal($kode_pengampu, $kode_jam, $kode_hari, $kode_ruang);
                }
            } else {
                $cek = $this->penjadwalanModel->cekJadwal($semester_tipe, $tahun_akademik, $prodi);
                if ($cek) {
                    foreach ($jadwal->getResult() as $j) {
                        $kode_pengampu = $j->kode_pengampu;
                        $kode_jam = $j->kode_jam;
                        $kode_hari = $j->kode_hari;
                        $kode_ruang = $j->kode_ruang;
                        $this->penjadwalanModel->updateJadwal($kode_pengampu, $kode_jam, $kode_hari, $kode_ruang);
                    }
                } else {
                    foreach ($jadwal->getResult() as $j) {
                        $kode_pengampu = $j->kode_pengampu;
                        $kode_jam = $j->kode_jam;
                        $kode_hari = $j->kode_hari;
                        $kode_ruang = $j->kode_ruang;
                        $this->penjadwalanModel->simpanJadwal($kode_pengampu, $kode_jam, $kode_hari, $kode_ruang);
                    }
                }
            }
        }

        return $this->response->setJSON(['status' => 'success']);
    }
}