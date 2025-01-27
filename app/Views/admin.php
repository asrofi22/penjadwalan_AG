<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="users"></i></div>
                                Tabel Data Admin
                            </h1>
                        </div>
                        <div class="col-auto mt-4">
                            <a href="/admin/create" class="btn btn-success">Tambah Admin</a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Data Admin</div>
                <div class="card-body">
                    <!-- Notifikasi -->
                    <?php if (session()->getFlashdata('success')) : ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error'); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($action) && $action === 'list') : ?>
                        <!-- Tampilan Daftar Admin -->
                        <table id="datatablesSimple" style="font-size: 12px;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Username</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                <?php foreach ($admins as $admin) : ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $admin['email'] ?></td>
                                        <td><?= $admin['username'] ?></td>
                                        <td>
                                            <a href="/admin/edit/<?= $admin['id'] ?>" class="btn btn-datatable btn-icon btn-transparent-dark me-2">
                                                <i data-feather="edit"></i>
                                            </a>
                                            <a href="/admin/delete/<?= $admin['id'] ?>" class="btn btn-datatable btn-icon btn-transparent-dark" onclick="return confirm('Apakah Anda yakin ingin menghapus?')">
                                                <i data-feather="trash-2"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    <?php elseif (isset($action) && $action === 'create') : ?>
                        <!-- Tampilan Tambah Admin -->
                        <form action="/admin/store" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="/admin" class="btn btn-secondary">Batal</a>
                        </form>

                    <?php elseif (isset($action) && $action === 'edit') : ?>
                        <!-- Tampilan Edit Admin -->
                        <form action="/admin/update/<?= $admin['id'] ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= $admin['email'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="<?= $admin['username'] ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password (biarkan kosong jika tidak ingin mengubah)</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="/admin" class="btn btn-secondary">Batal</a>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<?= $this->endSection(); ?>