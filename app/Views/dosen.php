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
                                Tabel Data Dosen
                            </h1>
                        </div>
                        <div class="col-auto mt-4">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Data Dosen</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Telepon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; // Inisialisasi nomor urut ?>
                            <?php foreach ($dosen_list as $dosen): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $dosen['nip'] ?></td>
                                <td><?= $dosen['nama'] ?></td>
                                <td><?= $dosen['alamat'] ?></td>
                                <td><?= $dosen['telp'] ?></td>
                                <td><?= $dosen['status_dosen'] == 1 ? 'Aktif' : 'Non-aktif' ?></td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $dosen['id'] ?>" 
                                            data-nip="<?= $dosen['nip'] ?>" 
                                            data-nama="<?= $dosen['nama'] ?>" 
                                            data-alamat="<?= $dosen['alamat'] ?>" 
                                            data-telp="<?= $dosen['telp'] ?>" 
                                            data-status="<?= $dosen['status_dosen'] ?>">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <a href="/dosen/delete/<?= $dosen['id'] ?>" class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/dosen/store" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Dosen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" required>
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="telp" name="telp" required>
                            </div>
                            <div class="mb-3">
                                <label for="status_dosen" class="form-label">Status</label>
                                <select class="form-control" id="status_dosen" name="status_dosen" required>
                                    <option value="">Pilih Status</option>
                                    <?php foreach ($status_dosen as $status): ?>
                                    <option value="<?= $status['id'] ?>"><?= $status['status'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formEdit" action="" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" id="editId" name="id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Data Dosen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editNip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="editNip" name="nip" required>
                            </div>
                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="editNama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="editAlamat" class="form-label">Alamat</label>
                                <input type="text" class="form-control" id="editAlamat" name="alamat" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTelp" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="editTelp" name="telp" required>
                            </div>
                            <div class="mb-3">
                                <label for="editStatusDosen" class="form-label">Status</label>
                                <select class="form-control" id="editStatusDosen" name="status_dosen" required>
                                    <option value="">Pilih Status</option>
                                    <?php foreach ($status_dosen as $status): ?>
                                    <option value="<?= $status['id'] ?>"><?= $status['status'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    // Isi modal edit dengan data dari tombol yang diklik
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nip = button.getAttribute('data-nip');
        const nama = button.getAttribute('data-nama');
        const alamat = button.getAttribute('data-alamat');
        const telp = button.getAttribute('data-telp');
        const status = button.getAttribute('data-status');

        // Isi form edit
        document.getElementById('editId').value = id;
        document.getElementById('editNip').value = nip;
        document.getElementById('editNama').value = nama;
        document.getElementById('editAlamat').value = alamat;
        document.getElementById('editTelp').value = telp;
        document.getElementById('editStatusDosen').value = status;

        // Atur URL form
        const formEdit = document.getElementById('formEdit');
        formEdit.action = `/dosen/update/${id}`;
    });
</script>

<?= $this->endSection(); ?>
