<?php

namespace App\Controllers;

use App\Models\KelasModel;
use App\Models\ProdiModel;

class Kelas extends BaseController
{
    protected $kelasModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->kelasModel = new KelasModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        $data = [
            'kelas' => $this->kelasModel->getKelas(),
            'prodi' => $this->prodiModel->findAll(), // Untuk dropdown pilihan prodi
        ];
        return view('kelas', $data);
    }

    public function store()
    {
        $this->kelasModel->save([
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_kelas' => $this->request->getPost('id_kelas') ?? null, // Optional
        ]);
        return redirect()->to('/kelas')->with('message', 'Data kelas berhasil ditambahkan!');
    }

    public function update($id)
    {
        $this->kelasModel->update($id, [
            'nama_kelas' => $this->request->getPost('nama_kelas'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_kelas' => $this->request->getPost('id_kelas'),
        ]);
        return redirect()->to('/kelas')->with('message', 'Data kelas berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->kelasModel->delete($id);
        return redirect()->to('/kelas')->with('message', 'Data kelas berhasil dihapus!');
    }
}
