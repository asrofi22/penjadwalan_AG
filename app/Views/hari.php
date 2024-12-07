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
                                <div class="page-header-icon"><i data-feather="filter"></i></div>
                                Tabel Data Hari
                            </h1>
                            <div class="page-header-subtitle">An extension of the Simple DataTables library, customized for SB Admin Pro</div>
                        </div>
                        <div class="col-auto mt-4">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <?php if (isset($hari_list)): ?>
        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Data Hari</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>ID Hari</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>ID Hari</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; // Inisialisasi nomor urut ?>
                            <?php foreach ($hari_list as $hari): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $hari['hari'] ?></td>
                                <td><?= $hari['id_hari'] ?></td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $hari['id'] ?>" 
                                            data-hari="<?= $hari['hari'] ?>" 
                                            data-id-hari="<?= $hari['id_hari'] ?>">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <a href="/hari/delete/<?= $hari['id'] ?>" class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>
        <?php endif; ?>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/hari/store" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Hari</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="hari" class="form-label">Hari</label>
                                <select class="form-control" id="hari" name="hari" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="idHari" class="form-label">ID Hari</label>
                                <input type="text" class="form-control" id="idHari" name="id_hari" required>
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
                            <h5 class="modal-title" id="modalEditLabel">Edit Data Hari</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="hari" class="form-label">Hari</label>
                                <select class="form-control" id="hari" name="hari" required>
                                    <option value="">Pilih Hari</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                    <option value="Minggu">Minggu</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editIdHari" class="form-label">ID Hari</label>
                                <input type="text" class="form-control" id="editIdHari" name="id_hari" required>
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
    // Fill the Edit Modal with data
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        const id = button.getAttribute('data-id');
        const hari = button.getAttribute('data-hari');
        const idHari = button.getAttribute('data-id-hari');
        
        // Fill form fields
        document.getElementById('editId').value = id;
        document.getElementById('editIdHari').value = idHari;
        document.querySelector('#modalEdit select[name="hari"]').value = hari;

        // Set form action URL dynamically
        const formEdit = document.getElementById('formEdit');
        formEdit.action = `/hari/update/${id}`;
    });

</script>

<?= $this->endSection(); ?>
