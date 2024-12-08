<?php

namespace App\Controllers;

use App\Models\WaktutidakbersediaModel;
use App\Models\DosenModel;
use App\Models\HariModel;
use App\Models\JamModel;

class Waktutidakbersedia extends BaseController
{
    protected $waktutidakbersediaModel;
    protected $dosenModel;
    protected $hariModel;
    protected $jamModel;

    // Dependency Injection langsung dalam metode
    public function index()
    {
        $this->waktutidakbersediaModel = new WaktutidakbersediaModel();
        $this->dosenModel = new DosenModel();
        $this->hariModel = new HariModel();
        $this->jamModel = new JamModel();

        $data = [
            'waktutidakbersedia_list' => $this->waktutidakbersediaModel->getWaktutidakbersediaWithDetails(),
            'dosen_list' => $this->dosenModel->findAll(),
            'hari_list' => $this->hariModel->findAll(),
            'jam_list' => $this->jamModel->findAll(),
        ];

        return view('waktutidakbersedia', $data);
    }

    public function store()
    {
        $this->waktutidakbersediaModel = new WaktutidakbersediaModel();

        $data = [
            'id_dosen' => $this->request->getPost('id_dosen'),
            'id_hari'  => $this->request->getPost('id_hari'),
            'id_jam'   => implode(',', $this->request->getPost('id_jam')),
        ];

        $this->waktutidakbersediaModel->save($data);

        return redirect()->to('/waktutidakbersedia')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update($id)
    {
        $this->waktutidakbersediaModel = new WaktutidakbersediaModel();

        $data = [
            'id_dosen' => $this->request->getPost('id_dosen'),
            'id_hari'  => $this->request->getPost('id_hari'),
            'id_jam'   => implode(',', $this->request->getPost('id_jam')),
        ];

        $this->waktutidakbersediaModel->update($id, $data);

        return redirect()->to('/waktutidakbersedia')->with('success', 'Data berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->waktutidakbersediaModel = new WaktutidakbersediaModel();

        $this->waktutidakbersediaModel->delete($id);

        return redirect()->to('/waktutidakbersedia')->with('success', 'Data berhasil dihapus.');
    }
}
