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
                                <div class="page-header-icon"><i data-feather="layers"></i></div>
                                Tabel Data Kelas
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
                <div class="card-header">Data Kelas</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kelas</th>
                                <th>Prodi</th>
                                <th>ID Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($kelas as $k): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $k['nama_kelas']; ?></td>
                                <td><?= $k['nama_prodi']; ?></td>
                                <td><?= $k['id_kelas']; ?></td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $k['id']; ?>" 
                                            data-nama_kelas="<?= $k['nama_kelas']; ?>" 
                                            data-id_prodi="<?= $k['id_prodi']; ?>" 
                                            data-id_kelas="<?= $k['id_kelas']; ?>">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <a href="/kelas/delete/<?= $k['id']; ?>" 
                                       class="btn btn-datatable btn-icon btn-transparent-dark" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
                    <form action="/kelas/store" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                                <input type="text" name="nama_kelas" id="nama_kelas" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_prodi" class="form-label">Prodi</label>
                                <select name="id_prodi" id="id_prodi" class="form-select" required>
                                    <option value="">Pilih Prodi</option>
                                    <?php foreach ($prodi as $p): ?>
                                    <option value="<?= $p['id']; ?>"><?= $p['prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_kelas" class="form-label">ID Kelas (Opsional)</label>
                                <input type="text" name="id_kelas" id="id_kelas" class="form-control">
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
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" id="editId">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Data Kelas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editNamaKelas" class="form-label">Nama Kelas</label>
                                <input type="text" name="nama_kelas" id="editNamaKelas" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editIdProdi" class="form-label">Prodi</label>
                                <select name="id_prodi" id="editIdProdi" class="form-select" required>
                                    <?php foreach ($prodi as $p): ?>
                                    <option value="<?= $p['id']; ?>"><?= $p['prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editIdKelas" class="form-label">ID Kelas (Opsional)</label>
                                <input type="text" name="id_kelas" id="editIdKelas" class="form-control">
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
        const namaKelas = button.getAttribute('data-nama_kelas');
        const idProdi = button.getAttribute('data-id_prodi');
        const idKelas = button.getAttribute('data-id_kelas');

        document.getElementById('formEdit').action = `/kelas/update/${id}`;
        document.getElementById('editId').value = id;
        document.getElementById('editNamaKelas').value = namaKelas;
        document.getElementById('editIdProdi').value = idProdi;
        document.getElementById('editIdKelas').value = idKelas;
    });
</script>

<?= $this->endSection(); ?>
