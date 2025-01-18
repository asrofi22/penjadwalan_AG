<?php

namespace App\Controllers;

use App\Models\JamModel;
use App\Models\WaktutidakbersediaModel;
use App\Models\KelasModel;
use App\Models\ProdiModel;
use App\Models\JurusanModel;
use App\Models\SemesterModel;
use App\Models\PengampuModel;
use App\Models\TahunakademikModel;
use App\Models\DosenModel;
use App\Models\HariModel;
use Myth\Auth\Models\UserModel;
use App\Models\MatakuliahModel;
use App\Models\RiwayatpenjadwalanModel;
use App\Models\RuangModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Riwayatpenjadwalan extends BaseController
{
    protected $session;
    protected $JamModel;
    protected $RiwayatpenjadwalanModel;
    protected $WaktutidakbersediaModel;
    protected $KelasModel;
    protected $ProdiModel;
    protected $JurusanModel;
    protected $SemesterModel;
    protected $PengampuModel;
    protected $TahunakademikModel;
    protected $DosenModel;
    protected $HariModel;
    protected $UserModel;
    protected $MatakuliahModel;
    protected $RuangModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->JamModel = new JamModel();
        $this->RiwayatpenjadwalanModel = new RiwayatpenjadwalanModel();
        $this->WaktutidakbersediaModel = new WaktutidakbersediaModel();
        $this->KelasModel = new KelasModel();
        $this->ProdiModel = new ProdiModel();
        $this->JurusanModel = new JurusanModel();
        $this->SemesterModel = new SemesterModel();
        $this->PengampuModel = new PengampuModel();
        $this->TahunakademikModel = new TahunakademikModel();
        $this->DosenModel = new DosenModel();
        $this->HariModel = new HariModel();
        $this->UserModel = new UserModel();
        $this->MatakuliahModel = new MatakuliahModel();
        $this->RuangModel = new RuangModel();
    }

    public function index($semester_tipe = null, $tahun_akademik = null, $prodi = null)
    {
        $data = [];

        // Jika session belum ada, set default
        if (!$this->session->get('pengampu_semester_tipe') && !$this->session->get('tahun_akademik') && !$this->session->get('prodi')) {
            $this->session->set([
                'pengampu_semester_tipe' => 1,
                'tahun_akademik' => 7,
                'prodi' => '0'
            ]);
        }

        // Jika parameter null, gunakan session
        if ($semester_tipe === null && $tahun_akademik === null && $prodi === null) {
            $semester_tipe = $this->session->get('pengampu_semester_tipe');
            $tahun_akademik = $this->session->get('tahun_akademik');
            $prodi = $this->session->get('prodi');
        } else {
            // Update session dengan parameter baru
            $this->session->set([
                'pengampu_semester_tipe' => $semester_tipe,
                'tahun_akademik' => $tahun_akademik,
                'prodi' => $prodi
            ]);
        }

        // Ambil data riwayat berdasarkan prodi
        if ($prodi == 0) {
            $data['rs_riwayat'] = $this->RiwayatpenjadwalanModel->get($semester_tipe, $tahun_akademik);
        } else {
            $data['rs_riwayat'] = $this->RiwayatpenjadwalanModel->get_perprodi($semester_tipe, $tahun_akademik, $prodi);
        }

        $data['prodiModel'] = $this->ProdiModel;

        $data['semester_a'] = $semester_tipe;
        $data['tahun_a'] = $tahun_akademik;
        $data['prodi'] = $prodi;
        $data['rs_tahun'] = $this->TahunakademikModel->semua_tahun();

        return view('riwayatpenjadwalan', $data);
    }

    public function excel_report()
    {
        $semester_tipe = $this->session->get('pengampu_semester_tipe');
        $tahun_akademik = $this->session->get('tahun_akademik');
        $prodi = $this->session->get('prodi');
    
        if ($prodi == 0) {
            $query = $this->RiwayatpenjadwalanModel->get($semester_tipe, $tahun_akademik);
        } else {
            $query = $this->RiwayatpenjadwalanModel->get_perprodi($semester_tipe, $tahun_akademik, $prodi);
        }
    
        if (!$query) {
            return false;
        }
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
    
        // Field names in the first row
        $fields = ["Hari", "Sesi", "Jam", "Mata Kuliah", "SKS", "Lokal", "Semester", "Prodi", "Ruang"];
        $col = 1;
        foreach ($fields as $field) {
            // Konversi kolom angka ke huruf (1 -> A, 2 -> B, dst.)
            $columnLetter = Coordinate::stringFromColumnIndex($col);
            // Set nilai ke sel (misalnya, A1, B1, C1, dst.)
            $sheet->setCellValue($columnLetter . '1', $field);
            $col++;
        }
    
        // Fetching the table data
        $row = 2; // Mulai dari baris kedua
        foreach ($query as $data) {
            $col = 1;
            foreach ($fields as $field) {
                // Konversi kolom angka ke huruf
                $columnLetter = Coordinate::stringFromColumnIndex($col);
                // Ubah field yang ditampilkan di Excel
                switch ($field) {
                    case 'Hari':
                        $sheet->setCellValue($columnLetter . $row, $data['hari']);
                        break;
                    case 'Sesi':
                        $sheet->setCellValue($columnLetter . $row, $data['sesi']);
                        break;
                    case 'Jam':
                        $sheet->setCellValue($columnLetter . $row, $data['jam_kuliah']);
                        break;
                    case 'Mata Kuliah':
                        $sheet->setCellValue($columnLetter . $row, $data['nama_mk']);
                        break;
                    case 'SKS':
                        $sheet->setCellValue($columnLetter . $row, $data['jumlah_jam']);
                        break;
                    case 'Lokal':
                        $sheet->setCellValue($columnLetter . $row, $data['nama_kelas']);
                        break;
                    case 'Semester':
                        $sheet->setCellValue($columnLetter . $row, $data['nama_semester']);
                        break;
                    case 'Prodi':
                        $sheet->setCellValue($columnLetter . $row, $data['nama_prodi']);
                        break;
                    case 'Ruang':
                        $sheet->setCellValue($columnLetter . $row, $data['ruang']);
                        break;
                    default:
                        // Jika ada field yang tidak terdaftar, biarkan kosong
                        $sheet->setCellValue($columnLetter . $row, '');
                        break;
                }
                $col++;
            }
            $row++;
        }
    
        $writer = new Xlsx($spreadsheet);
    
        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Riwayat_Penjadwalan_' . date('dMy') . '.xlsx"');
        header('Cache-Control: max-age=0');
    
        $writer->save('php://output');
    }

    public function hapus_jadwal()
    {
        $semester_tipe = $this->session->get('pengampu_semester_tipe');
        $tahun_akademik = $this->session->get('tahun_akademik');
        $prodi = $this->session->get('prodi');

        if ($prodi == 0) {
            $this->RiwayatpenjadwalanModel->hapus_semua_jadwal($semester_tipe, $tahun_akademik);
        } else {
            $this->RiwayatpenjadwalanModel->hapus_jadwal($semester_tipe, $tahun_akademik, $prodi);
        }

        if ($prodi == 0) {
            $data['rs_riwayat'] = $this->RiwayatpenjadwalanModel->get($semester_tipe, $tahun_akademik);
        } else {
            $data['rs_riwayat'] = $this->RiwayatpenjadwalanModel->get_perprodi($semester_tipe, $tahun_akademik, $prodi);
        }        
        
        $data['prodiModel'] = $this->ProdiModel;

        $data['semester_a'] = $semester_tipe;
        $data['tahun_a'] = $tahun_akademik;
        $data['prodi'] = $prodi;
        $data['rs_tahun'] = $this->TahunakademikModel->semua_tahun();
        $data['hapus'] = "Berhasil menghapus jadwal";

        return view('riwayatpenjadwalan', $data);
    }

    public function update($id)
    {
        $this->RiwayatpenjadwalanModel->update($id, [
            'hari' => $this->request->getPost('hari'),
            'sesi' => $this->request->getPost('sesi'),
            'jam_kuliah' => $this->request->getPost('jam_kuliah'),
            'nama_mk' => $this->request->getPost('nama_mk'),
            'dosen' => $this->request->getPost('dosen'),
            'jumlah_jam' => $this->request->getPost('jumlah_jam'),
            'nama_semester' => $this->request->getPost('nama_semester'),
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'kuota' => $this->request->getPost('kuota'),
            'ruang' => $this->request->getPost('ruang'),
            'kapasitas' => $this->request->getPost('kapasitas'),
        ]);
        return redirect()->to('/matakuliah');
    }
}