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
                                Tabel Data Ruang
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
                <div class="card-header">Data Ruangan</div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Ruang</th>
                                <th>Kapasitas</th>
                                <th>Jenis</th>
                                <th>Prodi</th>
                                <th>Lantai</th>
                                <th>ID Ruang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($ruang as $k): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $k['nama']; ?></td>
                                <td><?= $k['kapasitas']; ?></td>
                                <td><?= $k['jenis']; ?></td>
                                <td><?= $k['nama_prodi']; ?></td>
                                <td><?= $k['lantai']; ?></td>
                                <td><?= $k['id_ruang']; ?></td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $k['id']; ?>" 
                                            data-nama="<?= $k['nama']; ?>" 
                                            data-kapasitas="<?= $k['kapasitas']; ?>" 
                                            data-jenis="<?= $k['jenis']; ?>"
                                            data-id_prodi="<?= $k['id_prodi']; ?>" 
                                            data-lantai="<?= $k['lantai']; ?>"
                                            data-id_ruang="<?= $k['id_ruang']; ?>">
                                        <i data-feather="edit"></i>
                                    </button>
                                    <a href="/ruang/delete/<?= $k['id']; ?>" 
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
                    <form action="/ruang/store" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Ruang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Ruang</label>
                                <input type="text" name="nama" id="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="kapasitas" class="form-label">Kapasitas</label>
                                <input type="number" name="kapasitas" id="kapasitas" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis</label>
                                <select class="form-select" id="jenis" name="jenis" required>
                                    <option value="TEORI">TEORI</option>
                                    <option value="LABORATORIUM">LABORATORIUM</option>
                                </select>
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
                                <label for="lantai" class="form-label">Lantai</label>
                                <input type="number" name="lantai" id="lantai" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_ruang" class="form-label">ID Ruang</label>
                                <input type="text" name="id_ruang" id="id_ruang" class="form-control">
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
                            <h5 class="modal-title" id="modalEditLabel">Edit Data Ruang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama Ruang</label>
                                <input type="text" name="nama" id="editNama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editKapasitas" class="form-label">Kapasitas</label>
                                <input type="number" name="kapasitas" id="editKapasitas" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editJenis" class="form-label">Jenis</label>
                                <select class="form-select" id="editJenis" name="jenis" required>
                                    <option value="TEORI">TEORI</option>
                                    <option value="LABORATORIUM">LABORATORIUM</option>
                                </select>
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
                                <label for="editLantai" class="form-label">Lantai</label>
                                <input type="number" name="lantai" id="editLantai" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="editIdRuang" class="form-label">ID Ruang</label>
                                <input type="text" name="id_ruang" id="editIdRuang" class="form-control">
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
        const nama = button.getAttribute('data-nama');
        const kapasitas = button.getAttribute('data-kapasitas');
        const jenis = button.getAttribute('data-jenis');
        const idProdi = button.getAttribute('data-id_prodi');
        const lantai = button.getAttribute('data-lantai');
        const idRuang = button.getAttribute('data-id_ruang');

        document.getElementById('formEdit').action = `/ruang/update/${id}`;
        document.getElementById('editId').value = id;
        document.getElementById('editNama').value = nama;
        document.getElementById('editJenis').value = jenis;
        document.getElementById('editIdProdi').value = idProdi;
        document.getElementById('ediLantai').value = lantai;
        document.getElementById('editIdRuang').value = idRuang;
    });
</script>

<?= $this->endSection(); ?>
