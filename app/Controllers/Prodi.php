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

    public function store()
    {
        $this->prodiModel->save([
            'prodi' => $this->request->getPost('prodi'),
            'id_prodi' => $this->request->getPost('id_prodi'),
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
            'prodi' => $this->request->getPost('prodi'),
            'id_prodi' => $this->request->getPost('id_prodi')
        ]);

        return redirect()->to('/prodi');
    }

    public function delete($id)
    {
        $this->prodiModel->delete($id);
        return redirect()->to('/prodi');
    }
}
