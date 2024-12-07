<?php

namespace App\Controllers;

use App\Models\DosenModel;

class Dosen extends BaseController
{
    protected $dosenModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Dosen',
            'dosen_list' => $this->dosenModel->findAll(),
            'status_dosen' => $this->dosenModel->getStatusDosen()
        ];

        return view('dosen', $data);
    }

    public function store()
    {
        $this->dosenModel->save([
            'nip' => $this->request->getPost('nip'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'telp' => $this->request->getPost('telp'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status_dosen' => $this->request->getPost('status_dosen'),
            'id_dosen' => $this->request->getPost('id_dosen'),
        ]);

        return redirect()->to('/dosen');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Dosen',
            'dosen' => $this->dosenModel->find($id),
            'status_dosen' => $this->dosenModel->getStatusDosen()
        ];

        return view('dosen/edit', $data);
    }

    public function update($id)
    {
        $this->dosenModel->update($id, [
            'nip' => $this->request->getPost('nip'),
            'nama' => $this->request->getPost('nama'),
            'alamat' => $this->request->getPost('alamat'),
            'telp' => $this->request->getPost('telp'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status_dosen' => $this->request->getPost('status_dosen'),
            'id_dosen' => $this->request->getPost('id_dosen'),
        ]);

        return redirect()->to('/dosen');
    }

    public function delete($id)
    {
        $this->dosenModel->delete($id);
        return redirect()->to('/dosen');
    }
}
