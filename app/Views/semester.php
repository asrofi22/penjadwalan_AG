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
                                Tabel Data Semester
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
                <div class="card-header">Data Semester</div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Semester</th>
                                <th>Tipe</th>
                                <th>ID Semester</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($semester_list as $semester): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $semester['nama_semester'] ?></td>
                                <td><?= $semester['nama_tipe'] ?></td>
                                <td><?= $semester['id_semester'] ?></td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $semester['id'] ?>" 
                                            data-nama_semester="<?= $semester['nama_semester'] ?>" 
                                            data-semester_tipe="<?= $semester['semester_tipe'] ?>" 
                                            data-id_semester="<?= $semester['id_semester'] ?>" >
                                        <i data-feather="edit"></i>
                                    </button>
                                    <a href="/semester/delete/<?= $semester['id'] ?>" class="btn btn-datatable btn-icon btn-transparent-dark"><i data-feather="trash-2"></i></a>
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
                    <form action="/semester/store" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Semester</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_semester" class="form-label">Nama Semester</label>
                                <input type="text" class="form-control" id="nama_semester" name="nama_semester" required>
                            </div>
                            <div class="mb-3">
                                <label for="semester_tipe" class="form-label">Tipe Semester</label>
                                <select class="form-control" id="semester_tipe" name="semester_tipe" required>
                                    <option value="">Pilih Tipe</option>
                                    <?php foreach ($tipe_semester as $tipe): ?>
                                        <option value="<?= $tipe['id'] ?>"><?= $tipe['tipe_semester'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_semester" class="form-label">ID Semester</label>
                                <input type="text" class="form-control" id="id_semester" name="id_semester" required>
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
                            <h5 class="modal-title" id="modalEditLabel">Edit Data Semester</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editNamaSemester" class="form-label">Nama Semester</label>
                                <input type="text" class="form-control" id="editNamaSemester" name="nama_semester" required>
                            </div>
                            <div class="mb-3">
                                <label for="editTipeSemester" class="form-label">Tipe Semester</label>
                                <select class="form-control" id="editTipeSemester" name="semester_tipe" required>
                                    <option value="">Pilih Tipe</option>
                                    <?php foreach ($tipe_semester as $tipe): ?>
                                        <option value="<?= $tipe['id'] ?>"><?= $tipe['tipe_semester'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editIdSemester" class="form-label">ID Semester</label>
                                <input type="text" class="form-control" id="editIdSemester" name="id_semester" required>
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
        const nama_semester = button.getAttribute('data-nama_semester');
        const semester_tipe = button.getAttribute('data-semester_tipe');
        const id_semester = button.getAttribute('data-id_semester');

        // Isi form edit
        document.getElementById('editId').value = id;
        document.getElementById('editNamaSemester').value = nama_semester;
        document.getElementById('editTipeSemester').value = semester_tipe;
        document.getElementById('editIdSemester').value = id_semester;

        // Atur URL form
        const formEdit = document.getElementById('formEdit');
        formEdit.action = `/semester/update/${id}`;
    });
</script>

<?= $this->endSection(); ?>
