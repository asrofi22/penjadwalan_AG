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

        $semesterModel->save($data);
        return redirect()->to('/semester');
    }

    public function delete($id)
    {
        $semesterModel = new SemesterModel();
        $semesterModel->delete($id);

        return redirect()->to('/semester');
    }
}
