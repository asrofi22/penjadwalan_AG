<?php

namespace App\Controllers;

use App\Models\MatakuliahModel;
use App\Models\DosenModel;
use App\Models\RiwayatpenjadwalanModel;
use App\Models\PengampuModel;

class Home extends BaseController
{
    protected $matakuliahModel;
    protected $dosenModel;
    protected $riwayatpenjadwalanModel;
    protected $pengampuModel;

    public function __construct()
    {
        // Load model yang diperlukan
        $this->matakuliahModel = new MatakuliahModel();
        $this->dosenModel = new DosenModel();
        $this->riwayatpenjadwalanModel = new RiwayatpenjadwalanModel();
        $this->pengampuModel = new PengampuModel();
    }

    public function index()
    {
        // Ambil data dari model
        $data['totalMatakuliah'] = $this->matakuliahModel->countAllResults();
        $data['totalDosen'] = $this->dosenModel->countAllResults();
        $data['totalJadwal'] = $this->riwayatpenjadwalanModel->countAllResults();
        $data['totalPengampu'] = $this->pengampuModel->countAllResults();

        // Kirim data ke view
        return view('pages/home', $data);
    }

    public function user()
    {
        return view('user/index');
    }
}
