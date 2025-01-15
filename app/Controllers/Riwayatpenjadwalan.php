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

    // public function excel_report()
    // {
    //     $semester_tipe = $this->session->get('pengampu_semester_tipe');
    //     $tahun_akademik = $this->session->get('tahun_akademik');
    //     $prodi = $this->session->get('prodi');

    //     if ($prodi == 0) {
    //         $query = $this->RiwayatpenjadwalanModel->get($semester_tipe, $tahun_akademik);
    //     } else {
    //         $query = $this->RiwayatpenjadwalanModel->get_perprodi($semester_tipe, $tahun_akademik, $prodi);
    //     }

    //     if (!$query) {
    //         return false;
    //     }

    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // Field names in the first row
    //     $fields = ["hari", "sesi", "jam_kuliah", "nama_mk", "guru", "jumlah_jam", "nama_kelas", "nama_semester", "nama_prodi", "kuota", "nama_jurusan", "ruang", "kapasitas"];
    //     $col = 1;
    //     foreach ($fields as $field) {
    //         $sheet->setCellValueByColumnAndRow($col, 1, $field);
    //         $col++;
    //     }

    //     // Fetching the table data
    //     $row = 2;
    //     foreach ($query as $data) {
    //         $col = 1;
    //         foreach ($fields as $field) {
    //             $sheet->setCellValueByColumnAndRow($col, $row, $data->$field);
    //             $col++;
    //         }
    //         $row++;
    //     }

    //     $writer = new Xlsx($spreadsheet);

    //     // Sending headers to force the user to download the file
    //     header('Content-Type: application/vnd.ms-excel');
    //     header('Content-Disposition: attachment;filename="Riwayat_Penjadwalan_' . date('dMy') . '.xlsx"');
    //     header('Cache-Control: max-age=0');

    //     $writer->save('php://output');
    // }

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
}