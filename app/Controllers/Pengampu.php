<?php

namespace App\Controllers;

use App\Models\PengampuModel;
use App\Models\MatakuliahModel;
use App\Models\DosenModel;
use App\Models\KelasModel;
use App\Models\TahunAkademikModel;
use App\Models\ProdiModel;
use App\Models\SemesterModel;
use App\Models\RuangModel;

class Pengampu extends BaseController
{
    protected $pengampuModel;
    protected $matakuliahModel;
    protected $dosenModel;
    protected $kelasModel;
    protected $tahunAkademikModel;
    protected $prodiModel;
    protected $semesterModel;
    protected $ruangModel;

    public function __construct()
    {
        // Inisialisasi semua model yang digunakan
        $this->pengampuModel = new PengampuModel();
        $this->matakuliahModel = new MatakuliahModel();
        $this->dosenModel = new DosenModel();
        $this->kelasModel = new KelasModel();
        $this->tahunAkademikModel = new TahunAkademikModel();
        $this->prodiModel = new ProdiModel();
        $this->semesterModel = new SemesterModel();
        $this->ruangModel = new RuangModel();
    }

    // Menampilkan semua data pengampu
    public function index()
    {
        $data = [
            'pengampu_list' => $this->pengampuModel->getPengampuWithDetails(),
            'matakuliah_list' => $this->matakuliahModel->findAll(),
            'dosen_list' => $this->dosenModel->findAll(),
            'kelas_list' => $this->kelasModel->findAll(),
            'tahun_akademik_list' => $this->tahunAkademikModel->findAll(),
            'prodi_list' => $this->prodiModel->findAll(),
            'semester_list' => $this->semesterModel->findAll(),
            'ruang_list' => $this->ruangModel->findAll()
        ];
        return view('pengampu', $data);
    }

    // Menyimpan data pengampu baru
    public function store()
    {
        $this->pengampuModel->save([
            'id_mk' => $this->request->getPost('id_mk'),
            'id_dosen' => $this->request->getPost('id_dosen'),
            'kelas' => $this->request->getPost('kelas'),
            'tahun_akademik' => $this->request->getPost('tahun_akademik'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'semester' => $this->request->getPost('semester'),
            'kuota' => $this->request->getPost('kuota'),
            'id_ruang' => $this->request->getPost('id_ruang'),
        ]);
        return redirect()->to('/pengampu');
    }

    // Mengupdate data pengampu
    public function update($id)
    {
        $this->pengampuModel->update($id, [
            'id_mk' => $this->request->getPost('id_mk'),
            'id_dosen' => $this->request->getPost('id_dosen'),
            'id_kelas' => $this->request->getPost('id_kelas'),
            'id_tahun_akademik' => $this->request->getPost('id_tahun_akademik'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_semester' => $this->request->getPost('id_semester'),
            'kuota' => $this->request->getPost('kuota'),
            'id_ruang' => $this->request->getPost('id_ruang'),
        ]);
        return redirect()->to('/pengampu');
    }

    // Menghapus data pengampu
    public function delete($id)
    {
        $this->pengampuModel->delete($id);
        return redirect()->to('/pengampu');
    }
}
