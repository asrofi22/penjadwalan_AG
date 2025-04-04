<?php

namespace App\Controllers;

use App\Models\JamModel;

class Jam extends BaseController
{
    protected $JamModel;

    public function __construct()
    {
        $this->JamModel = new JamModel();
    }

    // 1. Tampilkan semua data
    public function index()
    {
        $data['jam_list'] = $this->JamModel->findAll();
        return view('jam', $data);
    }

    // 2. Form tambah data
    public function create()
    {
        return view('jam'); // Tidak perlu data khusus untuk tambah
    }

    // 3. Simpan data baru
    public function store()
    {
        $range_jam = $this->request->getPost('range_jam');
        $id_jam = $this->request->getPost('id_jam');

        // Cek duplikasi data
        $existingData = $this->JamModel
            ->where('range_jam', $range_jam)
            ->orWhere('id_jam', $id_jam)
            ->first();

        if ($existingData) {
            return redirect()->to('/jam')->with('error', 'Data sudah ada!');
        }

        $this->JamModel->save([
            'range_jam' => $range_jam,
            'sks'       => $this->request->getPost('sks'),
            'sesi'      => $this->request->getPost('sesi'),
            'id_jam'    => $id_jam,
        ]);
        return redirect()->to('/jam')->with('message', 'Data berhasil ditambahkan!');
    }

    // 4. Form edit data
    public function edit($id)
    {
        $data['jam'] = $this->JamModel->find($id);
        $data['is_edit'] = true; // Flag untuk membedakan edit dan tambah
        return view('jam', $data);
    }

    // 5. Update data
    public function update($id)
    {
        $range_jam = $this->request->getPost('range_jam');
        $id_jam = $this->request->getPost('id_jam');

        // Cek duplikasi data, kecuali data yang sedang diupdate
        $existingData = $this->JamModel
            ->where('range_jam', $range_jam)
            ->orWhere('id_jam', $id_jam)
            ->where('id !=', $id)
            ->first();

        if ($existingData) {
            return redirect()->to('/jam')->with('error', 'Data sudah ada!');
        }

        $this->JamModel->update($id, [
            'range_jam' => $range_jam,
            'sks'       => $this->request->getPost('sks'),
            'sesi'      => $this->request->getPost('sesi'),
            'id_jam'    => $id_jam,
        ]);
        return redirect()->to('/jam')->with('message', 'Data berhasil diperbarui!');
    }

    // 6. Hapus data
    public function delete($id)
    {
        $this->JamModel->delete($id);
        return redirect()->to('/jam')->with('message', 'Data berhasil dihapus!');
    }
}
