<?php

namespace App\Controllers;

use App\Models\RiwayatpenjadwalanModel;
use Dompdf\Dompdf;
use Dompdf\Options;

class Jadwal extends BaseController
{
    protected $riwayatpenjadwalanModel;

    public function __construct()
    {
        // Load model yang diperlukan
        $this->riwayatpenjadwalanModel = new RiwayatpenjadwalanModel();
    }

    public function index()
    {
        // Ambil parameter filter dari query string
        $semester_tipe = $this->request->getGet('semester_tipe') ?? 1; // Default: GANJIL
        $tahun_akademik = $this->request->getGet('tahun_akademik') ?? 7; // Default: Tahun Akademik tertentu
        $prodi = $this->request->getGet('prodi') ?? 0; // Default: Semua Prodi
        $dosen = $this->request->getGet('dosen') ?? 0; // Default: Semua dosen

        // Ambil data jadwal berdasarkan filter
        if ($prodi == 0 && $dosen == 0) {
            $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->get($semester_tipe, $tahun_akademik);
        } elseif ($prodi != 0 && $dosen == 0) {
            $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->get_perprodi($semester_tipe, $tahun_akademik, $prodi);
        } elseif ($dosen != 0) {
            $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->getPerDosen($dosen);
        }

        // Ambil data untuk dropdown filter
        $data['rs_tahun'] = $this->riwayatpenjadwalanModel->getTahunAkademik();
        $data['rs_prodi'] = $this->riwayatpenjadwalanModel->getProdi();
        $data['rs_dosen'] = $this->riwayatpenjadwalanModel->getDosen();

        // Kirim data filter ke view
        $data['semester_tipe'] = $semester_tipe;
        $data['tahun_akademik'] = $tahun_akademik;
        $data['prodi'] = $prodi;
        $data['dosen'] = $dosen;

        // Tampilkan view jadwal_public
        return view('jadwal_public', $data);
    }

    public function cetak_pdf()
    {
        // Ambil parameter filter dari query string
        $semester_tipe = $this->request->getGet('semester_tipe') ?? 1;
        $tahun_akademik = $this->request->getGet('tahun_akademik') ?? 7;
        $prodi = $this->request->getGet('prodi') ?? 0;
        $dosen = $this->request->getGet('dosen') ?? 0;

        // Ambil data jadwal berdasarkan filter
        if ($prodi == 0 && $dosen == 0) {
            $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->get($semester_tipe, $tahun_akademik);
        } elseif ($prodi != 0 && $dosen == 0) {
            $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->get_perprodi($semester_tipe, $tahun_akademik, $prodi);
        } elseif ($dosen != 0) {
            $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->getPerDosen($dosen);
        }

        // Ambil label tahun akademik
        $tahun_akademik_label = $this->riwayatpenjadwalanModel->getTahunAkademik();
        $tahun_akademik_label = array_column($tahun_akademik_label, 'tahun', 'id')[$tahun_akademik];
        $data['tahun_akademik_label'] = $tahun_akademik_label;

        // Ambil label dosen
        $dosen_label = $this->riwayatpenjadwalanModel->getDosen();
        $dosen_label = array_column($dosen_label, 'nama', 'id')[$dosen] ?? 'Semua Dosen';
        $data['dosen_label'] = $dosen_label;

        // Load view untuk PDF
        $html = view('jadwal_pdf', $data);

        // Setup dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); // Ukuran kertas dan orientasi
        $dompdf->render();

        // Output PDF ke browser
        $dompdf->stream("jadwal_kuliah.pdf", array("Attachment" => false));
    }
}