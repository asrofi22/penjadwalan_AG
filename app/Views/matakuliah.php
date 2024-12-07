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
                                <div class="page-header-icon"><i data-feather="book-open"></i></div>
                                Data Mata Kuliah
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
                <div class="card-header">Tabel Data Mata Kuliah</div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Aktif</th>
                                <th>Jenis</th>
                                <th>Kode</th>
                                <th>Program Studi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($matakuliah_list as $matkul): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $matkul['nama']; ?></td>
                                <td><?= $matkul['jumlah_jam']; ?></td>
                                <td><?= $matkul['nama_semester']; ?></td>
                                <td><?= $matkul['aktif'] ?></td>
                                <td><?= $matkul['jenis']; ?></td>
                                <td><?= $matkul['nama_kode']; ?></td>
                                <td><?= $matkul['prodi']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $matkul['id']; ?>"
                                            data-nama="<?= $matkul['nama']; ?>"
                                            data-jumlah_jam="<?= $matkul['jumlah_jam']; ?>"
                                            data-semester="<?= $matkul['semester']; ?>"
                                            data-aktif="<?= $matkul['aktif']; ?>"
                                            data-jenis="<?= $matkul['jenis']; ?>"
                                            data-nama_kode="<?= $matkul['nama_kode']; ?>"
                                            data-id_prodi="<?= $matkul['id_prodi']; ?>">
                                        Edit
                                    </button>
                                    <a href="/matakuliah/delete/<?= $matkul['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        Hapus
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
                    <form action="/matakuliah/store" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data Mata Kuliah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Mata Kuliah</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah_jam" class="form-label">Jumlah SKS</label>
                                <input type="number" class="form-control" id="jumlah_jam" name="jumlah_jam" required>
                            </div>
                            <div class="mb-3">
                                <label for="semester" class="form-label">Semester</label>
                                <select class="form-control" id="semester" name="semester" required>
                                    <?php foreach ($semester_list as $semester): ?>
                                    <option value="<?= $semester['id']; ?>"><?= $semester['nama_semester']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="aktif" class="form-label">Status Aktif</label>
                                <select name="aktif" class="form-control" id="aktif">
                                    <option value="True">True</option>
                                    <option value="False">False</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Mata Kuliah</label>
                                <input type="text" class="form-control" id="jenis" name="jenis">
                            </div>
                            <div class="mb-3">
                                <label for="nama_kode" class="form-label">Kode Mata Kuliah</label>
                                <input type="text" class="form-control" id="nama_kode" name="nama_kode">
                            </div>
                            <div class="mb-3">
                                <label for="id_prodi" class="form-label">Program Studi</label>
                                <select class="form-control" id="id_prodi" name="id_prodi" required>
                                    <?php foreach ($prodi_list as $prodi): ?>
                                    <option value="<?= $prodi['id']; ?>"><?= $prodi['prodi']; ?></option>
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
                    <form id="formEdit" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Data Mata Kuliah</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editId" name="id">
                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama Mata Kuliah</label>
                                <input type="text" class="form-control" id="editNama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="editJumlahJam" class="form-label">Jumlah SKS</label>
                                <input type="number" class="form-control" id="editJumlahJam" name="jumlah_jam" required>
                            </div>
                            <div class="mb-3">
                                <label for="editSemester" class="form-label">Semester</label>
                                <select class="form-control" id="editSemester" name="semester" required>
                                    <?php foreach ($semester_list as $semester): ?>
                                    <option value="<?= $semester['id']; ?>"><?= $semester['nama_semester']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editAktif" class="form-label">Status Aktif</label>
                                <select name="aktif" class="form-control" id="editAktif">
                                    <option value="True">True</option>
                                    <option value="False">False</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editJenis" class="form-label">Jenis Mata Kuliah</label>
                                <input type="text" class="form-control" id="editJenis" name="jenis">
                            </div>
                            <div class="mb-3">
                                <label for="editNamaKode" class="form-label">Kode Mata Kuliah</label>
                                <input type="text" class="form-control" id="editNamaKode" name="nama_kode">
                            </div>
                            <div class="mb-3">
                                <label for="editIdProdi" class="form-label">Program Studi</label>
                                <select class="form-control" id="editIdProdi" name="id_prodi" required>
                                    <?php foreach ($prodi_list as $prodi): ?>
                                    <option value="<?= $prodi['id']; ?>"><?= $prodi['prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
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
        const id_mk = button.getAttribute('data-id_mk');
        const id_dosen = button.getAttribute('data-id_dosen');
        const id_kelas = button.getAttribute('data-id_kelas');
        const id_tahun_akademik = button.getAttribute('data-id_tahun_akademik');
        const id_prodi = button.getAttribute('data-id_prodi');
        const semester = button.getAttribute('data-semester');
        const kuota = button.getAttribute('data-kuota');
        const id_ruang = button.getAttribute('data-id_ruang');

        document.getElementById('editId').value = id;
        document.getElementById('editIdMk').value = id_mk;
        document.getElementById('editIdDosen').value = id_dosen;
        document.getElementById('editIdKelas').value = id_kelas;
        document.getElementById('editIdTahunAkademik').value = id_tahun_akademik;
        document.getElementById('editIdProdi').value = id_prodi;
        document.getElementById('editSemester').value = semester;
        document.getElementById('editKuota').value = kuota;
        document.getElementById('editIdRuang').value = id_ruang;

        const formEdit = document.getElementById('formEdit');
        formEdit.action = `/pengampu/update/${id}`;
    });
</script>
<?= $this->endSection(); ?>
