<?php

namespace App\Controllers;

use App\Models\MatakuliahModel;
use App\Models\SemesterModel;
use App\Models\ProdiModel;

class Matakuliah extends BaseController
{
    protected $matakuliahModel;
    protected $semesterModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->matakuliahModel = new MatakuliahModel();
        $this->semesterModel = new SemesterModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        $data = [
            'matakuliah_list' => $this->matakuliahModel->getAllData(),
            'semester_list' => $this->semesterModel->findAll(),
            'prodi_list' => $this->prodiModel->findAll()
        ];
        return view('matakuliah', $data);
    }

    public function store()
    {
        $this->matakuliahModel->save([
            'nama' => $this->request->getPost('nama'),
            'jumlah_jam' => $this->request->getPost('jumlah_jam'),
            'semester' => $this->request->getPost('semester'),
            'aktif' => $this->request->getPost('aktif'),
            'jenis' => $this->request->getPost('jenis'),
            'nama_kode' => $this->request->getPost('nama_kode'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_mk' => $this->request->getPost('id_mk'),
        ]);
        return redirect()->to('/matakuliah');
    }

    public function update($id)
    {
        $this->matakuliahModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'jumlah_jam' => $this->request->getPost('jumlah_jam'),
            'semester' => $this->request->getPost('semester'),
            'aktif' => $this->request->getPost('aktif'),
            'jenis' => $this->request->getPost('jenis'),
            'nama_kode' => $this->request->getPost('nama_kode'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_matkul' => $this->request->getPost('id_matkul'),
        ]);
        return redirect()->to('/matakuliah');
    }

    public function delete($id)
    {
        $this->matakuliahModel->delete($id);
        return redirect()->to('/matakuliah');
    }
}
