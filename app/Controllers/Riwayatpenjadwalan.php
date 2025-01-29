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

    // Header Judul
    $sheet->setCellValue('A1', 'DRAF ROSTER KULIAH FAKULTAS SAINS DAN TEKNOLOGI UIN SULTHAN THAHA SAIFUDDIN JAMBI')
          ->mergeCells('A1:P1');
    $sheet->setCellValue('A2', 'SEMESTER GENAP TAHUN AKADEMIK 2024/2025')
          ->mergeCells('A2:P2');

    // Styling Judul
    $sheet->getStyle('A1:A2')->applyFromArray([
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'font' => ['bold' => true]
    ]);

    // Header Tabel
    $header = ['NO', 'PRODI', 'NAMA DOSEN', 'NIP', 'PANGKAT/GOL', 'STATUS DOSEN', 'KODE MK', 'MATA KULIAH', 'KETERANGAN MK', 'SEMESTER', 'PRODI', 'SKS', 'HARI', 'JAM', 'RUANG KULIAH', 'KET'];
    $sheet->fromArray($header, null, 'A4');

    // Styling Header
    $sheet->getStyle('A4:P4')->applyFromArray([
        'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        'font' => ['bold' => true],
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
    ]);

    // Mapping status dosen
    $statusMapping = [
        1 => 'Dosen Tetap PNS',
        2 => 'Dosen PPPK',
        3 => 'Dosen Tetap Bukan PNS',
        4 => 'Dosen Tetap BLU',
        5 => 'Dosen Luar Biasa'
    ];

    $row = 5;
    $no = 1;
    foreach ($query as $data) {
        $sheet->setCellValue('A' . $row, $no);
        $sheet->setCellValue('B' . $row, $data['nama_prodi']);
        $sheet->setCellValue('C' . $row, $data['dosen']);
        $sheet->setCellValue('D' . $row, $data['nip'] ?? '');
        $sheet->setCellValue('E' . $row, $data['pangkat'] ?? '');
        $sheet->setCellValue('F' . $row, $statusMapping[$data['status_dosen']] ?? '-');
        $sheet->setCellValue('G' . $row, $data['kode_mk'] ?? '');
        $sheet->setCellValue('H' . $row, $data['nama_mk']);
        $sheet->setCellValue('I' . $row, $data['ket_mk'] ?? '');
        $sheet->setCellValue('J' . $row, $data['nama_semester']);
        $sheet->setCellValue('K' . $row, $data['nama_prodi']);
        $sheet->setCellValue('L' . $row, $data['jumlah_jam']);
        $sheet->setCellValue('M' . $row, $data['hari']);
        $sheet->setCellValue('N' . $row, $data['jam_kuliah']);
        $sheet->setCellValue('O' . $row, $data['ruang']);
        $sheet->setCellValue('P' . $row, '');
        $row++;
        $no++;
    }

    // Styling No agar lebih kecil
    $sheet->getColumnDimension('A')->setWidth(5);

    // Auto-width untuk kolom lainnya
    foreach (range('B', 'P') as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    // Menambahkan border ke seluruh tabel
    $sheet->getStyle('A4:P' . ($row - 1))->applyFromArray([
        'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]]
    ]);

    // Menambahkan tanda tangan di bagian bawah
    $sheet->setCellValue('A' . ($row + 2), 'BLANKO INI DIBUAT BERDASARKAN FORMAT UNTUK USULAN SK REKTOR.');
    $sheet->setCellValue('O' . ($row + 4), 'Jambi,');
    $sheet->setCellValue('O' . ($row + 5), 'Ketua Prodi,');
    $sheet->setCellValue('O' . ($row + 7), '..........................');

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