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
                                Tabel Data Prodi
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
                <div class="card-header">Data Prodi</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Program Studi</th>
                                <th>ID Prodi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; // Inisialisasi nomor urut ?>
                            <?php foreach ($prodi_list as $prodi): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $prodi['prodi'] ?></td>
                                <td><?= $prodi['id_prodi'] ?></td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $prodi['id'] ?>" 
                                            data-prodi="<?= $prodi['prodi'] ?>" 
                                            data-id-prodi="<?= $prodi['id_prodi'] ?>">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <a href="/prodi/delete/<?= $prodi['id'] ?>" class="btn btn-datatable btn-icon btn-transparent-dark">
                                        <i data-feather="trash-2"></i>
                                    </a>
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
                    <form action="/prodi/store" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Prodi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="prodi" class="form-label">Prodi</label>
                                <input type="text" class="form-control" id="prodi" name="prodi" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_prodi" class="form-label">ID Prodi</label>
                                <input type="text" class="form-control" id="id_prodi" name="id_prodi" required>
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
                            <h5 class="modal-title" id="modalEditLabel">Edit Data Prodi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editProdi" class="form-label">Prodi</label>
                                <input type="text" class="form-control" id="editProdi" name="prodi" required>
                            </div>
                            <div class="mb-3">
                                <label for="editIdProdi" class="form-label">ID Prodi</label>
                                <input type="text" class="form-control" id="editIdProdi" name="id_prodi" required>
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
    // Event untuk mengisi modal edit dengan data
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        // Ambil data dari atribut tombol
        const id = button.getAttribute('data-id');
        const prodi = button.getAttribute('data-prodi');
        const id_prodi = button.getAttribute('data-id-prodi');

        // Isi form modal dengan data
        document.getElementById('editId').value = id;
        document.getElementById('editProdi').value = prodi;
        document.getElementById('editIdProdi').value = id_prodi;

        // Atur action pada form edit
        const formEdit = document.getElementById('formEdit');
        formEdit.action = `/prodi/update/${id}`;
    });

    // Render Feather Icons
    feather.replace();
</script>

<?= $this->endSection(); ?>
