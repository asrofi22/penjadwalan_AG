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
        // Ambil data dari form
        $id_mk = $this->request->getPost('id_mk');
        $id_dosen = $this->request->getPost('id_dosen');
        $kelas = $this->request->getPost('kelas');
        $tahun_akademik = $this->request->getPost('tahun_akademik');
        $semester = $this->request->getPost('semester');
        $id_ruang = $this->request->getPost('id_ruang');

        // Cek apakah data sudah ada
        $existingData = $this->pengampuModel
            ->where('id_mk', $id_mk)
            ->where('id_dosen', $id_dosen)
            ->where('kelas', $kelas)
            ->where('tahun_akademik', $tahun_akademik)
            ->where('semester', $semester)
            ->where('id_ruang', $id_ruang)
            ->first();

        if ($existingData) {
            // Jika data sudah ada, tampilkan notifikasi error
            session()->setFlashdata('error', 'Data pengampu sudah ada!');
            return redirect()->to('/pengampu');
        }

        // Jika data belum ada, simpan data baru
        $this->pengampuModel->save([
            'id_mk' => $id_mk,
            'id_dosen' => $id_dosen,
            'kelas' => $kelas,
            'tahun_akademik' => $tahun_akademik,
            'id_prodi' => $this->request->getPost('id_prodi'),
            'semester' => $semester,
            'id_ruang' => $this->request->getPost('id_ruang'),
        ]);

        // Tampilkan notifikasi sukses
        session()->setFlashdata('success', 'Data berhasil disimpan');
        return redirect()->to('/pengampu');
    }

    // Mengupdate data pengampu
    public function update($id)
    {
        // Ambil data dari form
        $id_mk = $this->request->getPost('id_mk');
        $id_dosen = $this->request->getPost('id_dosen');
        $kelas = $this->request->getPost('kelas');
        $tahun_akademik = $this->request->getPost('tahun_akademik');
        $semester = $this->request->getPost('semester');
        $id_ruang = $this->request->getPost('id_ruang');

        // Cek apakah data sudah ada (kecuali data yang sedang diupdate)
        $existingData = $this->pengampuModel
            ->where('id_mk', $id_mk)
            ->where('id_dosen', $id_dosen)
            ->where('kelas', $kelas)
            ->where('tahun_akademik', $tahun_akademik)
            ->where('semester', $semester)
            ->where('id_ruang', $id_ruang)
            ->where('id !=', $id) // Exclude the current record being updated
            ->first();

        if ($existingData) {
            // Jika data sudah ada, tampilkan notifikasi error
            session()->setFlashdata('error', 'Data pengampu sudah ada!');
            return redirect()->to('/pengampu');
        }

        // Jika data belum ada, update data
        $this->pengampuModel->update($id, [
            'id_mk' => $id_mk,
            'id_dosen' => $id_dosen,
            'kelas' => $kelas,
            'tahun_akademik' => $tahun_akademik,
            'id_prodi' => $this->request->getPost('id_prodi'),
            'semester' => $semester,
            'id_ruang' => $id_ruang,
        ]);

        // Tampilkan notifikasi sukses
        session()->setFlashdata('success', 'Data berhasil diperbarui');
        return redirect()->to('/pengampu');
    }

    // Menghapus data pengampu
    public function delete($id)
    {
        try {
            $delete = $this->pengampuModel->delete($id);
            
            if ($delete) {
                session()->setFlashdata('success', 'Data berhasil dihapus');
            } else {
                session()->setFlashdata('error', 'Gagal menghapus data');
            }
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            if ($e->getCode() == 1451) {
                session()->setFlashdata('error', 'Data tidak dapat dihapus karena masih digunakan di sistem');
            } else {
                session()->setFlashdata('error', 'Terjadi kesalahan: ' . $e->getMessage());
            }
        }
        
        return redirect()->to('/pengampu');
    }
}
