<?php

namespace App\Controllers;

use App\Models\PenjadwalanModel;
use App\Models\PengampuModel;
use App\Models\TahunakademikModel;
use App\Models\DosenModel;
use App\Models\HariModel;
use App\Models\MatakuliahModel;
use App\Models\RiwayatpenjadwalanModel;
use App\Models\RuangModel;
use Myth\Auth\Models\UserModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Penjadwalan4 extends BaseController
{
    protected $penjadwalanModel;
    protected $pengampuModel;
    protected $tahunakademikModel;
    protected $dosenModel;
    protected $hariModel;
    protected $userModel;
    protected $matakuliahModel;
    protected $riwayatpenjadwalanModel;
    protected $ruangModel;

    public function __construct()
    {
        $this->penjadwalanModel = new PenjadwalanModel();
        $this->pengampuModel = new PengampuModel();
        $this->tahunakademikModel = new TahunakademikModel();
        $this->dosenModel = new DosenModel();
        $this->hariModel = new HariModel();
        $this->userModel = new UserModel();
        $this->matakuliahModel = new MatakuliahModel();
        $this->riwayatpenjadwalanModel = new RiwayatpenjadwalanModel();
        $this->ruangModel = new RuangModel();
    }

    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('admin/index');
        }
        
        $data = [];

        if ($this->request->getMethod() === 'post') {
            $rules = [
                'semester_tipe' => 'required',
                'tahun_akademik' => 'required',
                'jumlah_populasi' => 'required',
                'probabilitas_crossover' => 'required',
                'probabilitas_mutasi' => 'required',
                'jumlah_generasi' => 'required'
            ];

            if ($this->validate($rules)) {
                $start = microtime(true);

                $jenis_semester = $this->request->getPost('semester_tipe');
                $prodi = $this->request->getPost('prodi');
                $tahun_akademik = $this->request->getPost('tahun_akademik');
                $crossOver = $this->request->getPost('probabilitas_crossover');
                $mutasi = $this->request->getPost('probabilitas_mutasi');
                $jumlah_generasi = $this->request->getPost('jumlah_generasi');

                $data['semester_a'] = $jenis_semester;
                $data['tahun_a'] = $tahun_akademik;
                $data['prodi'] = $prodi;

                $db = \Config\Database::connect();
                $builder = $db->table('pengampu a');
                $builder->select('a.kode');
                $builder->join('semester b', 'a.semester = b.kode', 'left');
                $builder->join('tahun_akademik c', 'a.tahun_akademik = c.kode', 'left');
                $builder->where('b.semester_tipe', $jenis_semester);
                $builder->where('a.tahun_akademik', $tahun_akademik);
                
                if ($prodi) {
                    $builder->where('a.kode_prodi', $prodi);
                }

                $rs_data = $builder->get();

                if ($rs_data->getNumRows() == 0) {
                    if ($rs_data->getNumRows() == 0) {
                        $data['msg'] = 'Tidak Ada Data dengan Semester dan Tahun Akademik ini <br>Data yang tampil dibawah adalah data dari proses sebelumnya';
                    } else {
                        $kode_pengampu = [];
                        foreach ($rs_data->getResult() as $row) {
                            $kode_pengampu[] = $row->kode;
                        }
    
                        $jenis_semester = $this->request->getPost('semester_tipe');
                        $tahun_akademik = $this->request->getPost('tahun_akademik');
                        $jumlah_populasi = $this->request->getPost('jumlah_populasi');
                        $crossOver = $this->request->getPost('probabilitas_crossover');
                        $mutasi = $this->request->getPost('probabilitas_mutasi');
                        $jumlah_generasi = $this->request->getPost('jumlah_generasi');
    
                        $data['kode_pengampu'] = $kode_pengampu;
                        $data['jenis_semester'] = $jenis_semester;
                        $data['tahun_akademik'] = $tahun_akademik;
                        $data['jumlah_populasi'] = $jumlah_populasi;
                        $data['crossOver'] = $crossOver;
                        $data['mutasi'] = $mutasi;
                        $data['jumlah_generasi'] = $jumlah_generasi;
    
                        $populasi = $this->inisialisasi($jumlah_populasi, $kode_pengampu);
                        $populasi_terbaik = $this->algoritmaGenetika($populasi, $jumlah_generasi, $crossOver, $mutasi);
    
                        $this->penjadwalanModel->truncate();
    
                        foreach ($populasi_terbaik as $kromosom) {
                            $this->penjadwalanModel->insert([
                                'kode_pengampu' => $kromosom['kode_pengampu'],
                                'kode_jam' => $kromosom['kode_jam'],
                                'kode_hari' => $kromosom['kode_hari'],
                                'kode_ruang' => $kromosom['kode_ruang']
                            ]);
                        }
    
                        $waktu_komputasi = microtime(true) - $start;
                        $this->riwayatpenjadwalanModel->insert([
                            'waktu_mulai' => date('Y-m-d H:i:s', $start),
                            'waktu_selesai' => date('Y-m-d H:i:s'),
                            'durasi' => $waktu_komputasi,
                            'semester' => $jenis_semester,
                            'tahun_akademik' => $tahun_akademik,
                            'kode_prodi' => $prodi,
                            'populasi' => $jumlah_populasi,
                            'crossover' => $crossOver,
                            'mutasi' => $mutasi,
                            'generasi' => $jumlah_generasi
                        ]);
    
                        $data['msg'] = 'Penjadwalan berhasil dilakukan dalam waktu ' . number_format($waktu_komputasi, 4) . ' detik';
                    }
                } else {
                    $data['msg'] = $this->validator->listErrors();
                }
            }
    
            $data['page_name'] = 'penjadwalan';
            $data['page_title'] = 'Penjadwalan';
            $data['rs_tahun'] = $this->tahunakademikModel->findAll();
            $data['rs_jadwal'] = $this->penjadwalanModel->get();
            
            return view('head', ['aside' => 'penjadwalan_bar'])
            . view('penjadwalan', $data)
            . view('footer');
        }
    }

    private function inisialisasi($jumlah_populasi, $kode_pengampu)
    {
        $populasi = [];
        for ($i = 0; $i < $jumlah_populasi; $i++) {
            $kromosom = [];
            foreach ($kode_pengampu as $kp) {
                $kromosom[] = [
                    'kode_pengampu' => $kp,
                    'kode_jam' => rand(1, 9), // Asumsi ada 9 slot waktu
                    'kode_hari' => rand(1, 6), // Asumsi 6 hari kerja
                    'kode_ruang' => rand(1, 10) // Asumsi ada 10 ruangan
                ];
            }
            $populasi[] = $kromosom;
        }
        return $populasi;
    }

    private function algoritmaGenetika($populasi, $jumlah_generasi, $crossOver, $mutasi)
    {
        for ($i = 0; $i < $jumlah_generasi; $i++) {
            $populasi = $this->seleksi($populasi);
            $populasi = $this->crossover($populasi, $crossOver);
            $populasi = $this->mutasi($populasi, $mutasi);
        }
        return $this->getBest($populasi);
    }

    private function seleksi($populasi)
    {
        $fitness = [];
        foreach ($populasi as $kromosom) {
            $fitness[] = $this->hitungFitness($kromosom);
        }
        
        $totalFitness = array_sum($fitness);
        $probabilitas = array_map(function($f) use ($totalFitness) {
            return $f / $totalFitness;
        }, $fitness);
        
        $newPopulasi = [];
        for ($i = 0; $i < count($populasi); $i++) {
            $r = mt_rand() / mt_getrandmax();
            $sum = 0;
            for ($j = 0; $j < count($probabilitas); $j++) {
                $sum += $probabilitas[$j];
                if ($r <= $sum) {
                    $newPopulasi[] = $populasi[$j];
                    break;
                }
            }
        }
        return $newPopulasi;
    }

    private function crossover($populasi, $crossOver)
    {
        $newPopulasi = [];
        for ($i = 0; $i < count($populasi); $i += 2) {
            if (mt_rand() / mt_getrandmax() < $crossOver && isset($populasi[$i + 1])) {
                $crossoverPoint = rand(0, count($populasi[$i]) - 1);
                $child1 = array_merge(
                    array_slice($populasi[$i], 0, $crossoverPoint),
                    array_slice($populasi[$i + 1], $crossoverPoint)
                );
                $child2 = array_merge(
                    array_slice($populasi[$i + 1], 0, $crossoverPoint),
                    array_slice($populasi[$i], $crossoverPoint)
                );
                $newPopulasi[] = $child1;
                $newPopulasi[] = $child2;
            } else {
                $newPopulasi[] = $populasi[$i];
                if (isset($populasi[$i + 1])) {
                    $newPopulasi[] = $populasi[$i + 1];
                }
            }
        }
        return $newPopulasi;
    }

    private function mutasi($populasi, $mutasi)
    {
        foreach ($populasi as &$kromosom) {
            foreach ($kromosom as &$gen) {
                if (mt_rand() / mt_getrandmax() < $mutasi) {
                    $gen['kode_jam'] = rand(1, 9);
                    $gen['kode_hari'] = rand(1, 6);
                    $gen['kode_ruang'] = rand(1, 10);
                }
            }
        }
        return $populasi;
    }

    private function hitungFitness($kromosom)
    {
        $bentrok = 0;
        for ($i = 0; $i < count($kromosom); $i++) {
            for ($j = $i + 1; $j < count($kromosom); $j++) {
                if ($kromosom[$i]['kode_jam'] == $kromosom[$j]['kode_jam'] &&
                    $kromosom[$i]['kode_hari'] == $kromosom[$j]['kode_hari'] &&
                    $kromosom[$i]['kode_ruang'] == $kromosom[$j]['kode_ruang']) {
                    $bentrok++;
                }
            }
        }
        return 1 / (1 + $bentrok);
    }

    private function getBest($populasi)
    {
        $bestFitness = 0;
        $bestKromosom = null;
        foreach ($populasi as $kromosom) {
            $fitness = $this->hitungFitness($kromosom);
            if ($fitness > $bestFitness) {
                $bestFitness = $fitness;
                $bestKromosom = $kromosom;
            }
        }
        return $bestKromosom;
    }

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $style_col = [
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]
            ]
        ];

        $sheet->setCellValue('A1', "JADWAL KULIAH");
        $sheet->mergeCells('A1:F1');
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A3', "NO");
        $sheet->setCellValue('B3', "MATA KULIAH");
        $sheet->setCellValue('C3', "DOSEN");
        $sheet->setCellValue('D3', "RUANG");
        $sheet->setCellValue('E3', "HARI");
        $sheet->setCellValue('F3', "JAM");

        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);

        $jadwal = $this->penjadwalanModel->getJadwalLengkap();
        $no = 1;
        $numrow = 4;
        foreach($jadwal as $data){
            $sheet->setCellValue('A'.$numrow, $no);
            $sheet->setCellValue('B'.$numrow, $data['nama_mk']);
            $sheet->setCellValue('C'.$numrow, $data['nama_dosen']);
            $sheet->setCellValue('D'.$numrow, $data['nama_ruang']);
            $sheet->setCellValue('E'.$numrow, $data['nama_hari']);
            $sheet->setCellValue('F'.$numrow, $data['range_jam']);
            
            $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
            
            $no++;
            $numrow++;
        }

        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(15);
        $sheet->getColumnDimension('F')->setWidth(15);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Jadwal Kuliah.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit();
    }

    public function riwayat()
    {
        $data['page_name'] = 'riwayat';
        $data['page_title'] = 'Riwayat Penjadwalan';
        $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->findAll();
        
        return view('head', ['aside' => 'penjadwalan_bar'])
            . view('riwayat', $data)
            . view('footer');
    }

    public function hapusRiwayat($id)
    {
        $this->riwayatpenjadwalanModel->delete($id);
        return redirect()->to(base_url('penjadwalan3/riwayat'))->with('success', 'Data riwayat berhasil dihapus');
    }
}