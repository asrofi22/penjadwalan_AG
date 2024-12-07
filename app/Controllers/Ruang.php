<?php

namespace App\Controllers;

use App\Models\RuangModel;
use App\Models\ProdiModel;

class Ruang extends BaseController
{
    protected $ruangModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->ruangModel = new RuangModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        $data = [
            'ruang' => $this->ruangModel->getRuang(),
            'prodi' => $this->prodiModel->findAll(), // Untuk dropdown pilihan prodi
        ];
        return view('ruang', $data);
    }

    public function store()
    {
        $this->ruangModel->save([
            'nama' => $this->request->getPost('nama'),
            'kapasitas' => $this->request->getPost('kapasitas'),
            'jenis' => $this->request->getPost('jenis'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'lantai' => $this->request->getPost('lantai'),
            'id_ruang' => $this->request->getPost('id_ruang') ?? null, // Optional
        ]);
        return redirect()->to('/ruang')->with('message', 'Data ruang berhasil ditambahkan!');
    }

    public function update($id)
    {
        $this->ruangModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'kapasitas' => $this->request->getPost('kapasitas'),
            'jenis' => $this->request->getPost('jenis'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'lantai' => $this->request->getPost('lantai'),
            'id_ruang' => $this->request->getPost('id_ruang') ?? null,
        ]);
        return redirect()->to('/ruang')->with('message', 'Data ruang berhasil diperbarui!');
    }

    public function delete($id)
    {
        $this->ruangModel->delete($id);
        return redirect()->to('/ruang')->with('message', 'Data ruang berhasil dihapus!');
    }
}
