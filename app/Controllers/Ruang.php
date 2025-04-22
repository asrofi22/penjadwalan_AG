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
        $nama = $this->request->getPost('nama');
        $id_ruang = $this->request->getPost('id_ruang');

        // Cek duplikasi data
        $existingData = $this->ruangModel
            ->where('nama', $nama)
            ->orWhere('id_ruang', $id_ruang)
            ->first();

        if ($existingData) {
            return redirect()->to('/ruang')->with('error', 'Data ruang sudah ada!');
        }

        $this->ruangModel->save([
            'nama' => $nama,
            'jenis' => $this->request->getPost('jenis'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'lantai' => $this->request->getPost('lantai'),
            'id_ruang' => $id_ruang ?? null, // Optional
        ]);
        return redirect()->to('/ruang')->with('message', 'Data berhasil disimpan');
    }

    public function update($id)
    {
        $nama = $this->request->getPost('nama');
        $id_ruang = $this->request->getPost('id_ruang');

        // Cek duplikasi data, kecuali data yang sedang diupdate
        $existingData = $this->ruangModel
            ->where('nama', $nama)
            ->orWhere('id_ruang', $id_ruang)
            ->where('id !=', $id)
            ->first();

        if ($existingData) {
            return redirect()->to('/ruang')->with('error', 'Data sudah ada!');
        }

        $this->ruangModel->update($id, [
            'nama' => $nama,
            'jenis' => $this->request->getPost('jenis'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'lantai' => $this->request->getPost('lantai'),
            'id_ruang' => $id_ruang ?? null,
        ]);
        return redirect()->to('/ruang')->with('message', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        try {
            $delete = $this->ruangModel->delete($id);
            
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
        
        return redirect()->to('/ruang');
    }
}
