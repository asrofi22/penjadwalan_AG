<?php

namespace App\Controllers;

use App\Models\DosenModel;
use App\Models\ProdiModel;
use Dompdf\Dompdf;


class Dosen extends BaseController
{
    protected $dosenModel;
    protected $prodiModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
        $this->prodiModel = new ProdiModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Dosen',
            // 'dosen_list' => $this->dosenModel->findAll(),
            'dosen_list' => $this->dosenModel->getProdiData(),
            'status_dosen' => $this->dosenModel->getStatusDosen(),
            'prodi_list' => $this->prodiModel->findAll()
        ];

        return view('dosen', $data);
    }

    public function store()
    {
        // Ambil data dari form
        $nip = $this->request->getPost('nip');
        $nama = $this->request->getPost('nama');

        // Validasi input
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nip' => 'required|numeric',
            'nama' => 'required',
            'id_prodi' => 'required',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            // Jika validasi gagal, kembalikan ke form dengan pesan error
            return redirect()->to('/dosen')->withInput()->with('errors', $validation->getErrors());
        }

        // Cek apakah NIP atau Nama sudah ada di database
        $existingNip = $this->dosenModel->where('nip', $nip)->first();
        $existingNama = $this->dosenModel->where('nama', $nama)->first();

        if ($existingNip || $existingNama) {
            // Jika data sudah ada, set flashdata dan redirect kembali ke form
            session()->setFlashdata('error', 'Data dengan NIP atau Nama yang sama sudah ada dalam database.');
            return redirect()->to('/dosen')->withInput();
        }

        // Jika data belum ada, simpan data baru
        $this->dosenModel->save([
            'nip' => $nip,
            'nama' => $nama,
            'pangkat' => $this->request->getPost('pangkat'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            'status_dosen' => $this->request->getPost('status_dosen'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_scopus' => $this->request->getPost('id_scopus'),
            'id_dosen' => $this->request->getPost('id_dosen'),
        ]);

        session()->setFlashdata('success', 'Data berhasil disimpan.');
        return redirect()->to('/dosen');
    }

    public function edit($id)
    {
        $data = [
            'title' => 'Edit Dosen',
            'dosen' => $this->dosenModel->find($id),
            'dosen_list' => $this->dosenModel->getProdiData(),
            'status_dosen' => $this->dosenModel->getStatusDosen(),
            'prodi_list' => $this->prodiModel->findAll()
        ];

        return view('dosen/edit', $data);
    }

    public function update($id)
    {
        $this->dosenModel->update($id, [
            'nip' => $this->request->getPost('nip'),
            'nama' => $this->request->getPost('nama'),
            'pangkat' => $this->request->getPost('pangkat'),
            'telp' => $this->request->getPost('telp'),
            'email' => $this->request->getPost('email'),
            'tgl_lahir' => $this->request->getPost('tgl_lahir'),
            // 'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status_dosen' => $this->request->getPost('status_dosen'),
            'id_prodi' => $this->request->getPost('id_prodi'),
            'id_scopus' => $this->request->getPost('id_scopus'),
            'id_dosen' => $this->request->getPost('id_dosen')
        ]);

        return redirect()->to('/dosen');
    }

    public function delete($id)
    {
        $this->dosenModel->delete($id);
        return redirect()->to('/dosen');
    }
    

    public function cetak()
    {
        // Ambil data dosen dari model
        $data['dosen_list'] = $this->dosenModel->getProdiData();

        // Load view untuk cetak
        $html = view('cetak/dosen', $data);

        // Inisialisasi Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // (Opsional) Set ukuran dan orientasi kertas
        $dompdf->setPaper('A4', 'landscape');

        // Render PDF
        $dompdf->render();

        // Output PDF ke browser
        $dompdf->stream('data_dosen.pdf', ['Attachment' => false]);
    }
}
