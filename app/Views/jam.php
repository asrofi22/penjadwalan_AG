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
                                Tabel Data Jam
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
        <?php if (isset($jam_list)): ?>
        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Data Jam</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Range Jam</th>
                                <th>SKS</th>
                                <th>Sesi</th>
                                <th>ID Jam</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Range Jam</th>
                                <th>SKS</th>
                                <th>Sesi</th>
                                <th>ID Jam</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php $no = 1; // Inisialisasi nomor urut ?>
                            <?php foreach ($jam_list as $jam): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $jam['range_jam'] ?></td>
                                <td><?= $jam['sks'] ?></td>
                                <td><?= $jam['sesi'] ?></td>
                                <td><?= $jam['id_jam'] ?></td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $jam['id'] ?>" 
                                            data-range-jam="<?= $jam['range_jam'] ?>" 
                                            data-sks="<?= $jam['sks'] ?>" 
                                            data-sesi="<?= $jam['sesi'] ?>" 
                                            data-id-jam="<?= $jam['id_jam'] ?>">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <a href="/jam/delete/<?= $jam['id'] ?>" class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></a>
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
                    <form action="/jam/store" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Jam</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="rangeJam" class="form-label">Range Jam</label>
                                <input type="text" class="form-control" id="rangeJam" name="range_jam" required>
                            </div>
                            <div class="mb-3">
                                <label for="sks" class="form-label">SKS</label>
                                <input type="number" class="form-control" id="sks" name="sks" required>
                            </div>
                            <div class="mb-3">
                                <label for="sesi" class="form-label">Sesi</label>
                                <input type="text" class="form-control" id="sesi" name="sesi" required>
                            </div>
                            <div class="mb-3">
                                <label for="idJam" class="form-label">ID Jam</label>
                                <input type="text" class="form-control" id="idJam" name="id_jam" required>
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
                    <form action="/jam/update/<?= $jam['id'] ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" id="editId" name="id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Data Jam</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editRangeJam" class="form-label">Range Jam</label>
                                <input type="text" class="form-control" id="editRangeJam" name="range_jam" required>
                            </div>
                            <div class="mb-3">
                                <label for="editSks" class="form-label">SKS</label>
                                <input type="number" class="form-control" id="editSks" name="sks" required>
                            </div>
                            <div class="mb-3">
                                <label for="editSesi" class="form-label">Sesi</label>
                                <input type="text" class="form-control" id="editSesi" name="sesi" required>
                            </div>
                            <div class="mb-3">
                                <label for="editIdJam" class="form-label">ID Jam</label>
                                <input type="text" class="form-control" id="editIdJam" name="id_jam" required>
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
        const button = event.relatedTarget;
        document.getElementById('editId').value = button.getAttribute('data-id');
        document.getElementById('editRangeJam').value = button.getAttribute('data-range-jam');
        document.getElementById('editSks').value = button.getAttribute('data-sks');
        document.getElementById('editSesi').value = button.getAttribute('data-sesi');
        document.getElementById('editIdJam').value = button.getAttribute('data-id-jam');
    });
</script>

<?= $this->endSection(); ?>
