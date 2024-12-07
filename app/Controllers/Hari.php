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
        $this->HariModel->save([
            'hari'      => $this->request->getPost('hari'),
            'id_hari'    => $this->request->getPost('id_hari'),
        ]);
        return redirect()->to('/hari')->with('message', 'Data berhasil ditambahkan!');
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
        $this->HariModel->update($id, [
            'hari'      => $this->request->getPost('hari'),
            'id_hari'    => $this->request->getPost('id_hari'),
        ]);
        return redirect()->to('/hari')->with('message', 'Data berhasil diperbarui!');
    }

    // 6. Hapus data
    public function delete($id)
    {
        $this->HariModel->delete($id);
        return redirect()->to('/hari')->with('message', 'Data berhasil dihapus!');
    }
}
