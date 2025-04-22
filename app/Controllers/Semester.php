<?php

namespace App\Controllers;

use App\Models\SemesterModel;

class Semester extends BaseController
{
    public function index()
    {
        $semesterModel = new SemesterModel();

        $data = [
            'semester_list' => $semesterModel->getSemesterWithTipe(),
            'tipe_semester' => $semesterModel->getAllTipeSemester()
        ];

        return view('semester', $data);
    }

    public function store()
    {
        $semesterModel = new SemesterModel();

        $data = [
            'nama_semester' => $this->request->getPost('nama_semester'),
            'semester_tipe' => $this->request->getPost('tipe_semester'),
            'id_semester'   => $this->request->getPost('id_semester'),
        ];

        session()->setFlashdata('success', 'Data berhasil disimpan.');
        $semesterModel->save($data);
        return redirect()->to('/semester');
    }

    public function update($id)
    {
        $semesterModel = new SemesterModel();

        $data = [
            'id'            => $id,
            'nama_semester' => $this->request->getPost('nama_semester'),
            'semester_tipe' => $this->request->getPost('tipe_semester'),
            'id_semester'   => $this->request->getPost('id_semester'),
        ];

        session()->setFlashdata('success', 'Data berhasil diperbarui.');
        $semesterModel->save($data);
        return redirect()->to('/semester');
    }

    public function delete($id)
    {
        $semesterModel = new SemesterModel();

        try {
            $delete = $semesterModel->delete($id); 
            
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
        
        return redirect()->to('/semester');
    }
}
