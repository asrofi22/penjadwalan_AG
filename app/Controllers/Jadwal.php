<?php

namespace App\Controllers;

use App\Models\RiwayatpenjadwalanModel;

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
}