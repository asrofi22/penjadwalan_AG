<?php

namespace App\Controllers;

use App\Models\TahunAkademikModel;

class TahunAkademik extends BaseController
{
    protected $tahunAkademikModel;

    public function __construct()
    {
        $this->tahunAkademikModel = new TahunAkademikModel();
    }

    // Menampilkan halaman utama data tahun akademik
    public function index()
    {
        $data = [
            'tahun_akademik' => $this->tahunAkademikModel->findAll()
        ];
        return view('tahunakademik', $data);
    }

    // Menyimpan data baru
    public function store()
    {
        $this->tahunAkademikModel->save([
            'tahun' => $this->request->getPost('tahun')
        ]);
        return redirect()->to('/tahunakademik')->with('success', 'Data berhasil ditambahkan.');
    }

    // Menampilkan data untuk diedit
    public function edit($id)
    {
        $data = [
            'tahun' => $this->tahunAkademikModel->find($id)
        ];
        return view('tahunakademik/edit', $data);
    }

    // Memperbarui data
    public function update($id)
    {
        $this->tahunAkademikModel->update($id, [
            'tahun' => $this->request->getPost('tahun')
        ]);
        return redirect()->to('/tahunakademik')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus data
    public function delete($id)
    {
        $this->tahunAkademikModel->delete($id);
        return redirect()->to('/tahunakademik')->with('success', 'Data berhasil dihapus.');
    }
}
