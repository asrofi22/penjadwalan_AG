<?php

namespace App\Controllers;

use App\Models\ProdiModel;

class Prodi extends BaseController
{
    protected $prodiModel;

    public function __construct()
    {
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Prodi',
            'prodi_list' => $this->prodiModel->findAll(),
        ];

        return view('prodi', $data);
    }

    public function semua_prodi(){
        $result = $this->prodiModel->findAll();
        echo json_encode($result);
    }

    public function store()
    {
        $this->prodiModel->save([
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            // 'id_jurusan' => $this->request->getPost('id_jurusan'),
        ]);

        return redirect()->to('/prodi');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Prodi',
            'prodi' => $this->prodiModel->find($id),
        ];

        return view('prodi/edit', $data);
    }

    public function update($id)
    {
        $this->prodiModel->update($id, [
            'nama_prodi' => $this->request->getPost('nama_prodi'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            // 'id_jurusan' => $this->request->getPost('id_jurusan')
        ]);

        return redirect()->to('/prodi');
    }

    public function delete($id)
    {
        try {
            $delete = $this->prodiModel->delete($id);
            
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
        
        return redirect()->to('/prodi');
    }
}