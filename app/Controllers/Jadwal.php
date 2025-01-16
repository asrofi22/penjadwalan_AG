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
        // Ambil keyword pencarian dari query string (jika ada)
        $keyword = $this->request->getGet('keyword');

        // Ambil data jadwal dari model
        if (!empty($keyword)) {
            // Jika ada keyword, lakukan pencarian
            $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->cari_jadwal($keyword);
        } else {
            // Jika tidak ada keyword, ambil semua data jadwal
            $data['rs_riwayat'] = $this->riwayatpenjadwalanModel->get_all_jadwal();
        }

        // Kirim keyword ke view (untuk menampilkan kembali di form pencarian)
        $data['keyword'] = $keyword;

        // Tampilkan view jadwal_public
        return view('jadwal_public', $data);
    }
}