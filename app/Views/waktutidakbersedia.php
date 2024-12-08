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
                                    Tabel Data Waktu Tidak Bersedia
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
                    <div class="card-header">Data Waktu Tidak Bersedia</div>
                    <div class="card-body">
                        <table id="datatablesSimple">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dosen</th>
                                    <th>Hari</th>
                                    <th>Jam</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        <tbody>
                            <?php $no = 1; foreach ($waktutidakbersedia_list as $item): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $item['dosen']; ?></td>
                                    <td><?= $item['hari']; ?></td>
                                    <td><?= $item['range_jam']; ?></td>
                                    <td>
                                        <!-- Tombol Edit -->
                                        <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" data-bs-toggle="modal" data-bs-target="#modalEdit"
                                            data-id="<?= $item['id']; ?>"
                                            data-id_dosen="<?= $item['id_dosen']; ?>"
                                            data-id_hari="<?= $item['id_hari']; ?>"
                                            data-id_jam="<?= $item['id_jam']; ?>">
                                            <i data-feather="edit"></i>
                                        </button>
                                        <a href="/waktutidakbersedia/delete/<?= $item['id']; ?>" 
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
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Waktu Tidak Bersedia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/waktutidakbersedia/store" method="POST">
                        <?= csrf_field(); ?>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="id_dosen" class="form-label">Dosen</label>
                                    <select class="form-select" id="id_dosen" name="id_dosen" required>
                                        <option value="">Pilih Dosen</option>
                                        <?php foreach ($dosen_list as $dosen): ?>
                                            <option value="<?= $dosen['id']; ?>"><?= $dosen['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="id_hari" class="form-label">Hari</label>
                                    <select class="form-select" id="id_hari" name="id_hari" required>
                                        <option value="">Pilih Hari</option>
                                        <?php foreach ($hari_list as $hari): ?>
                                            <option value="<?= $hari['id']; ?>"><?= $hari['hari']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="id_jam" class="form-label">Jam</label>
                                    <div class="form-check">
                                        <?php foreach ($jam_list as $jam): ?>
                                            <input type="checkbox" class="form-check-input" id="jam_<?= $jam['id']; ?>" name="id_jam[]" value="<?= $jam['id']; ?>">
                                            <label class="form-check-label" for="jam_<?= $jam['id']; ?>"><?= $jam['range_jam']; ?></label><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Waktu Tidak Bersedia</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEdit" method="POST">
                            <div class="modal-body">
                                <input type="hidden" id="editId" name="id">
                                <div class="mb-3">
                                    <label for="editIdDosen" class="form-label">Dosen</label>
                                    <select class="form-select" id="editIdDosen" name="id_dosen" required>
                                        <option value="">Pilih Dosen</option>
                                        <?php foreach ($dosen_list as $dosen): ?>
                                            <option value="<?= $dosen['id']; ?>"><?= $dosen['nama']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editIdHari" class="form-label">Hari</label>
                                    <select class="form-select" id="editIdHari" name="id_hari" required>
                                        <option value="">Pilih Hari</option>
                                        <?php foreach ($hari_list as $hari): ?>
                                            <option value="<?= $hari['id']; ?>"><?= $hari['hari']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editIdJam" class="form-label">Jam</label>
                                    <div class="form-check">
                                        <?php foreach ($jam_list as $jam): ?>
                                            <input type="checkbox" class="form-check-input" id="jam_<?= $jam['id']; ?>" name="id_jam[]" value="<?= $jam['id']; ?>">
                                            <label class="form-check-label" for="jam_<?= $jam['id']; ?>"><?= $jam['range_jam']; ?></label><br>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const idDosen = button.getAttribute('data-id_dosen');
        const idHari = button.getAttribute('data-id_hari');
        const idJam = button.getAttribute('data-id_jam').split(',');

        document.getElementById('editId').value = id;
        document.getElementById('editIdDosen').value = idDosen;
        document.getElementById('editIdHari').value = idHari;

        // Reset semua checkbox
        document.querySelectorAll('input[name="id_jam[]"]').forEach((checkbox) => {
            checkbox.checked = false;
        });

        // Centang checkbox yang sesuai
        idJam.forEach(function(jamId) {
            const checkbox = document.getElementById('jam_' + jamId);
            if (checkbox) {
                checkbox.checked = true;
            }
        });

        const formEdit = document.getElementById('formEdit');
        formEdit.action = `/waktutidakbersedia/update/${id}`;
    });

</script>
<?= $this->endSection(); ?>
