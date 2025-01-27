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

        // Load model yang diperlukan
        $hariModel = new HariModel();
        $jamModel = new JamModel();
        $ruangModel = new RuangModel();
        $riwayatModel = new RiwayatpenjadwalanModel();

        // Ambil data untuk dropdown
        $data['hari_list'] = $this->HariModel->findAll();
        $data['sesi_list'] = $this->JamModel->findAll(); // Sesuaikan dengan model yang benar
        $data['jam_list'] = $this->JamModel->findAll(); // Sesuaikan dengan model yang benar
        $data['ruang_list'] = $this->RuangModel->findAll();

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

    // Header sesuai dengan format BLANKO ROSTER.xlsx
    $sheet->setCellValue('A1', 'DRAF ROSTER KULIAH FAKULTAS SAINS DAN TEKNOLOGI UIN SULTHAN THAHA SAIFUDDIN JAMBI');
    $sheet->mergeCells('A1:P1'); // Merge cells untuk judul utama
    $sheet->setCellValue('A2', 'SEMESTER GENAP TAHUN AKADEMIK 2024/2025');
    $sheet->mergeCells('A2:P2'); // Merge cells untuk subjudul

    // Header tabel
    $header = [
        'NO', 'PRODI', 'NAMA DOSEN', 'NIP', 'PANGKAT/GOL', 'STATUS DOSEN (DOSEN TETAP PNS, DOSEN PPPK, DTBPNS, DTBLU & DLB)',
        'KODE MK', 'MATA KULIAH', 'KETERANGAN MK (WAJIB / PILIHAN)', 'SEMESTER', 'PRODI', 'SKS', 'HARI', 'JAM', 'RUANG KULIAH', 'KET'
    ];

    // Menulis header ke Excel
    $sheet->fromArray($header, null, 'A4'); // Mulai dari baris 4

    // Fetching the table data
    $row = 5; // Mulai dari baris 5
    $no = 1; // Nomor urut
    foreach ($query as $data) {
        $sheet->setCellValue('A' . $row, $no); // NO
        $sheet->setCellValue('B' . $row, $data['nama_prodi']); // PRODI
        $sheet->setCellValue('C' . $row, $data['dosen']); // NAMA DOSEN
        $sheet->setCellValue('D' . $row, ''); // NIP (kosong, karena tidak ada di data)
        $sheet->setCellValue('E' . $row, ''); // PANGKAT/GOL (kosong, karena tidak ada di data)
        $sheet->setCellValue('F' . $row, ''); // STATUS DOSEN (kosong, karena tidak ada di data)
        $sheet->setCellValue('G' . $row, $data['kode_mk'] ?? ''); // KODE MK (kosong jika tidak ada)
        $sheet->setCellValue('H' . $row, $data['nama_mk']); // MATA KULIAH
        $sheet->setCellValue('I' . $row, ''); // KETERANGAN MK (kosong, karena tidak ada di data)
        $sheet->setCellValue('J' . $row, $data['nama_semester']); // SEMESTER
        $sheet->setCellValue('K' . $row, $data['nama_prodi']); // PRODI
        $sheet->setCellValue('L' . $row, $data['jumlah_jam']); // SKS
        $sheet->setCellValue('M' . $row, $data['hari']); // HARI
        $sheet->setCellValue('N' . $row, $data['jam_kuliah']); // JAM
        $sheet->setCellValue('O' . $row, $data['ruang']); // RUANG KULIAH
        $sheet->setCellValue('P' . $row, ''); // KET (kosong, karena tidak ada di data)

        $row++;
        $no++;
    }

    // Menambahkan filter dan sorting di Excel
    $sheet->setAutoFilter('A4:P4'); // Menambahkan filter di header

    // Mengatur lebar kolom otomatis
    foreach (range('A', 'P') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Menambahkan border ke seluruh tabel
    $styleArray = [
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
    ];
    $sheet->getStyle('A4:P' . ($row - 1))->applyFromArray($styleArray);

    // Menambahkan tanda tangan di bagian bawah
    $sheet->setCellValue('A' . ($row + 2), 'BLANKO INI DIBUAT BERDASARKAN FORMAT UNTUK USULAN SK REKTOR.');
    $sheet->setCellValue('F' . ($row + 4), 'Jambi,');
    $sheet->setCellValue('F' . ($row + 5), 'Ketua Prodi,');
    $sheet->setCellValue('F' . ($row + 7), '..........................');

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
        
        // Set flashdata untuk menampilkan pesan sukses
    $this->session->setFlashdata('msg', 'Jadwal berhasil dihapus.');

    // Redirect ke laman riwayatpenjadwalan
    return redirect()->to('/riwayatpenjadwalan');
    }

    public function update($id)
    {
        // Ambil data dari form
        $data = [
            'id_hari' => $this->request->getPost('id_hari') ?? null,
            'id_jam' => $this->request->getPost('id_jam') ?? null,
            'id_ruang' => $this->request->getPost('id_ruang') ?? null
        ];

        // Debug data yang dikirim
        log_message('debug', 'Data yang dikirim: ' . print_r($data, true));

        // Validasi apakah id_jam ada di tabel jam2
        $jamExists = $this->JamModel->find($data['id_jam']);
        if (!$jamExists) {
            return redirect()->to('/riwayatpenjadwalan')->with('msg', 'ID Jam tidak valid.');
        }

        // Cek apakah ada bentrok
        $bentrok = $this->RiwayatpenjadwalanModel->cek_bentrok($data['id_hari'], $data['id_jam'], $data['id_ruang'], $id);

        if ($bentrok) {
            // Jika ada bentrok, kembalikan pesan error
            return redirect()->to('/riwayatpenjadwalan')->with('msg', 'Tidak bisa edit data jadwal karena bentrok dengan jadwal lain.');
        } else {
            // Jika tidak ada bentrok, update data
            $this->RiwayatpenjadwalanModel->update_jadwal($id, $data);
            return redirect()->to('/riwayatpenjadwalan')->with('msg', 'Jadwal berhasil diupdate.');
        }
    }

    public function get_sesi($id_jam)
    {
        // Ambil data sesi dari tabel jam2 berdasarkan id_jam
        $jam = $this->JamModel->find($id_jam);

        if ($jam) {
            return $this->response->setJSON(['sesi' => $jam['sesi']]);
        } else {
            return $this->response->setJSON(['sesi' => null]);
        }
    }
}