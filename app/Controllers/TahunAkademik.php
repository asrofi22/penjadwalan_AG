<?php

namespace App\Controllers;

use App\Models\TahunakademikModel;

class TahunAkademik extends BaseController
{
    protected $tahunakademikModel;

    public function __construct()
    {
        $this->tahunakademikModel = new TahunakademikModel();
    }

    // Menampilkan halaman utama data tahun akademik
    public function index()
    {
        $data = [
            'tahun_akademik' => $this->tahunakademikModel->findAll()
        ];
        return view('tahunakademik', $data);
    }

    // Menyimpan data baru
    public function store()
    {
        $this->tahunakademikModel->save([
            'tahun' => $this->request->getPost('tahun')
        ]);
        return redirect()->to('/tahunakademik')->with('success', 'Data berhasil ditambahkan.');
    }

    // Menampilkan data untuk diedit
    public function edit($id)
    {
        $data = [
            'tahun' => $this->tahunakademikModel->find($id)
        ];
        return view('tahunakademik/edit', $data);
    }

    // Memperbarui data
    public function update($id)
    {
        $this->tahunakademikModel->update($id, [
            'tahun' => $this->request->getPost('tahun')
        ]);
        return redirect()->to('/tahunakademik')->with('success', 'Data berhasil diperbarui.');
    }

    // Menghapus data
    public function delete($id)
    {
        $this->tahunakademikModel->delete($id);
        return redirect()->to('/tahunakademik')->with('success', 'Data berhasil dihapus.');
    }

    public function semua_tahun()
    {
        return $this->tahunakademikModel->findAll(); // Mengembalikan semua data dari tabel tahun akademik
    }
    
    // Mengambil tahun akademik berdasarkan ID
    public function tahun_awal($id)
    {
        return $this->tahunakademikModel->find($id); // Mengembalikan data berdasarkan ID
    }
    
}
