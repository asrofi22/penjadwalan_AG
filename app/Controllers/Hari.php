<?php

namespace App\Controllers;

use App\Models\HariModel;

class Hari extends BaseController
{
    protected $HariModel;

    public function __construct()
    {
        $this->HariModel = new HariModel();
    }

    // 1. Tampilkan semua data
    public function index()
    {
        $hari_list = $this->HariModel->findAll();
        return view('hari', ['hari_list' => $hari_list]);
    }

    // 2. Form tambah data
    public function create()
    {
        return view('hari'); // Tidak perlu data khusus untuk tambah
    }

    // 3. Simpan data baru
    public function store()
    {
        $nama = $this->request->getPost('nama');
        $id_hari = $this->request->getPost('id_hari');

        // Cek duplikasi data
        $existingData = $this->HariModel->where('nama', $nama)->orWhere('id_hari', $id_hari)->first();
        if ($existingData) {
            return redirect()->to('/hari')->with('error', 'Data hari sudah ada!');
        }

        $this->HariModel->save([
            'nama'      => $nama,
            'id_hari'   => $id_hari,
        ]);
        return redirect()->to('/hari')->with('message', 'Data hari berhasil ditambahkan!');
    }


    // 4. Form edit data
    public function edit($id)
    {
        $data['hari'] = $this->HariModel->find($id);
        $data['is_edit'] = true; // Flag untuk membedakan edit dan tambah
        return view('hari', $data);
    }

    // 5. Update data
    public function update($id)
    {
        $nama = $this->request->getPost('nama');
        $id_hari = $this->request->getPost('id_hari');

        // Cek duplikasi data, kecuali data yang sedang diupdate
        $existingData = $this->HariModel->where('nama', $nama)->orWhere('id_hari', $id_hari)->where('id !=', $id)->first();
        if ($existingData) {
            return redirect()->to('/hari')->with('error', 'Data hari sudah ada!');
        }

        $this->HariModel->update($id, [
            'nama'      => $nama,
            'id_hari'   => $id_hari,
        ]);
        return redirect()->to('/hari')->with('message', 'Data hari berhasil diperbarui!');
    }

    // 6. Hapus data
    public function delete($id)
    {
        try {
            $delete = $this->HariModel->delete($id);
            
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
        
        return redirect()->to('/hari');
    }
}
