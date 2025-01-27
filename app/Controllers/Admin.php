<?php
namespace App\Controllers;

use App\Models\AdminModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Admin extends BaseController
{
    public function index()
    {
        $model = new AdminModel();
        $data = [
            'action' => 'list', // Kirim variabel $action ke view
            'admins' => $model->findAll() // Kirim data admin ke view
        ];

        return view('admin', $data); // Kirim data ke view
    }

    public function create()
    {
        $data = [
            'action' => 'create' // Kirim variabel $action ke view
        ];

        return view('admin', $data); // Kirim data ke view
    }

    public function store()
    {
        $model = new AdminModel();

        $data = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            // 'user_image' => 'default.svg'
        ];

        $model->insert($data);

        return redirect()->to('/admin')->with('message', 'Admin berhasil ditambahkan');
    }

    public function edit($id)
    {
        $model = new AdminModel();
        $admin = $model->find($id);

        if (!$admin) {
            throw new PageNotFoundException('Admin dengan ID ' . $id . ' tidak ditemukan');
        }

        $data = [
            'action' => 'edit', // Kirim variabel $action ke view
            'admin' => $admin // Kirim data admin yang akan diedit ke view
        ];

        return view('admin', $data); // Kirim data ke view
    }

    public function update($id)
    {
        $model = new AdminModel();

        $data = [
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username')
        ];

        // Jika password diisi, update password
        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $model->update($id, $data);

        return redirect()->to('/admin')->with('message', 'Admin berhasil diperbarui');
    }

    public function delete($id)
    {
        $model = new AdminModel();
        $model->delete($id);

        return redirect()->to('/admin')->with('message', 'Admin berhasil dihapus');
    }
}