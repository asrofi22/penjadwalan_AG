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
    // public function store()
    // {
    //     $this->tahunakademikModel->save([
    //         'tahun' => $this->request->getPost('tahun')
    //     ]);
    //     return redirect()->to('/tahunakademik')->with('success', 'Data berhasil ditambahkan.');
    // }

    public function store()
    {
        $tahun = $this->request->getPost('tahun');

        // Cek duplikasi data
        $existingData = $this->tahunakademikModel->where('tahun', $tahun)->first();
        if ($existingData) {
            return redirect()->to('/tahunakademik')->with('error', 'Data tahun akademik sudah ada!');
        }

        $this->tahunakademikModel->save([
            'tahun'      => $tahun,
        ]);
        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('/tahunakademik')->with('message', 'Data tahun akademik berhasil ditambahkan!');
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
    // public function update($id)
    // {
    //     $this->tahunakademikModel->update($id, [
    //         'tahun' => $this->request->getPost('tahun')
    //     ]);
    //     return redirect()->to('/tahunakademik')->with('success', 'Data berhasil diperbarui.');
    // }

    public function update($id)
    {
        $tahun = $this->request->getPost('tahun');

        // Cek duplikasi data, kecuali data yang sedang diupdate
        $existingData = $this->tahunakademikModel->where('tahun', $tahun)->where('id !=', $id)->first();
        if ($existingData) {
            return redirect()->to('/tahunakademik')->with('error', 'Data tahun akademik sudah ada!');
        }

        $this->tahunakademikModel->update($id, [
            'tahun'      => $tahun,
        ]);
        return redirect()->to('/tahunakademik')->with('message', 'Data tahun akademik berhasil diperbarui!');
    }

    // Menghapus data
    public function delete($id)
    {
        try {
            $delete = $this->tahunakademikModel->delete($id);
            
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
        
        return redirect()->to('/tahunakademik');
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
