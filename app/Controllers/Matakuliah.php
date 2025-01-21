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
        // Ambil data dari form
        $nama = $this->request->getPost('nama');
        $nama_id = $this->request->getPost('nama_id');

        // Cek apakah data sudah ada
        $existingData = $this->matakuliahModel
            ->where('nama', $nama)
            ->orWhere('nama_id', $nama_id)
            ->first();

        if ($existingData) {
            // Jika data sudah ada, tampilkan notifikasi error
            session()->setFlashdata('error', 'Data mata kuliah atau kode MK sudah ada!');
            return redirect()->to('/matakuliah');
        }

        // Jika data belum ada, simpan data baru
        $this->matakuliahModel->save([
            'nama' => $nama,
            'jumlah_jam' => $this->request->getPost('jumlah_jam'),
            'semester' => $this->request->getPost('semester'),
            'aktif' => $this->request->getPost('aktif'),
            'jenis' => $this->request->getPost('jenis'),
            'nama_id' => $nama_id,
            'id_prodi' => $this->request->getPost('id_prodi'),
            'ket_mk' => $this->request->getPost('ket_mk'),
        ]);

        // Tampilkan notifikasi sukses
        session()->setFlashdata('success', 'Data mata kuliah berhasil ditambahkan!');
        return redirect()->to('/matakuliah');
    }

    public function update($id)
    {
        // Ambil data dari form
        $nama = $this->request->getPost('nama');
        $nama_id = $this->request->getPost('nama_id');

        // Cek apakah data sudah ada (kecuali data yang sedang diupdate)
        $existingData = $this->matakuliahModel
            ->where('id !=', $id) // Abaikan data yang sedang diupdate
            ->groupStart()
                ->where('nama', $nama)
                ->orWhere('nama_id', $nama_id)
            ->groupEnd()
            ->first();

        if ($existingData) {
            // Jika data sudah ada, tampilkan notifikasi error
            session()->setFlashdata('error', 'Data mata kuliah atau kode MK sudah ada!');
            return redirect()->to('/matakuliah');
        }

        // Jika data belum ada, update data
        $this->matakuliahModel->update($id, [
            'nama' => $nama,
            'jumlah_jam' => $this->request->getPost('jumlah_jam'),
            'semester' => $this->request->getPost('semester'),
            'aktif' => $this->request->getPost('aktif'),
            'jenis' => $this->request->getPost('jenis'),
            'nama_id' => $nama_id,
            'id_prodi' => $this->request->getPost('id_prodi'),
            'ket_mk' => $this->request->getPost('ket_mk'),
        ]);

        // Tampilkan notifikasi sukses
        session()->setFlashdata('success', 'Data mata kuliah berhasil diupdate!');
        return redirect()->to('/matakuliah');
    }

    public function delete($id)
    {
        $this->matakuliahModel->delete($id);
        return redirect()->to('/matakuliah');
    }

    public function jumlahJam($id)
    {
        $mataKuliahModel = new \App\Models\MataKuliahModel();
        return $mataKuliahModel->find($id);
    }

}
