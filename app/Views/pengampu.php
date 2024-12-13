<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="users"></i></div>
                                Data Pengampu
                            </h1>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Tabel Data Pengampu</div>
                <div class="card-body">
                    <table id="datatablesSimple" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Mata Kuliah</th>
                                <th>Dosen</th>
                                <th>Kelas</th>
                                <th>Tahun Akademik</th>
                                <th>Program Studi</th>
                                <th>Semester</th>
                                <th>Kuota</th>
                                <th>Ruang</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($pengampu_list as $pengampu): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $pengampu['matakuliah']; ?></td>
                                <td><?= $pengampu['dosen']; ?></td>
                                <td><?= $pengampu['kelas']; ?></td>
                                <td><?= $pengampu['tahun']; ?></td>
                                <td><?= $pengampu['prodi']; ?></td>
                                <td><?= $pengampu['nama_semester']; ?></td>
                                <td><?= $pengampu['kuota']; ?></td>
                                <td><?= $pengampu['nama']; ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $pengampu['id']; ?>"
                                            data-id_mk="<?= $pengampu['id_mk']; ?>"
                                            data-id_dosen="<?= $pengampu['id_dosen']; ?>"
                                            data-kelas="<?= $pengampu['kelas']; ?>"
                                            data-tahun_akademik="<?= $pengampu['tahun_akademik']; ?>"
                                            data-id_prodi="<?= $pengampu['id_prodi']; ?>"
                                            data-semester="<?= $pengampu['semester']; ?>"
                                            data-kuota="<?= $pengampu['kuota']; ?>"
                                            data-id_ruang="<?= $pengampu['id_ruang']; ?>">
                                        Edit
                                    </button>
                                    <a href="/pengampu/delete/<?= $pengampu['id']; ?>" 
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
                    <form action="/pengampu/store" method="post">
                        <?= csrf_field(); ?>
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Data Pengampu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="id_mk" class="form-label">Mata Kuliah</label>
                                <select class="form-control" id="id_mk" name="id_mk" required>
                                    <?php foreach ($matakuliah_list as $matkul): ?>
                                    <option value="<?= $matkul['id']; ?>"><?= $matkul['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_dosen" class="form-label">Dosen</label>
                                <select class="form-control" id="id_dosen" name="id_dosen" required>
                                    <?php foreach ($dosen_list as $dosen): ?>
                                    <option value="<?= $dosen['id']; ?>"><?= $dosen['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kelas" class="form-label">Kelas</label>
                                <select class="form-control" id="kelas" name="kelas" required>
                                    <?php foreach ($kelas_list as $kelas): ?>
                                    <option value="<?= $kelas['id']; ?>"><?= $kelas['nama_kelas']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tahun_akademik" class="form-label">Tahun Akademik</label>
                                <select class="form-control" id="tahun_akademik" name="tahun_akademik" required>
                                    <?php foreach ($tahun_akademik_list as $tahun): ?>
                                    <option value="<?= $tahun['id']; ?>"><?= $tahun['tahun']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_prodi" class="form-label">Program Studi</label>
                                <select class="form-control" id="id_prodi" name="id_prodi" required>
                                    <?php foreach ($prodi_list as $prodi): ?>
                                    <option value="<?= $prodi['id']; ?>"><?= $prodi['prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                                <label for="kuota" class="form-label">Kuota</label>
                                <input type="number" class="form-control" id="kuota" name="kuota" required>
                            </div>
                            <div class="mb-3">
                                <label for="id_ruang" class="form-label">Ruang</label>
                                <select class="form-control" id="id_ruang" name="id_ruang" required>
                                    <?php foreach ($ruang_list as $ruang): ?>
                                    <option value="<?= $ruang['id']; ?>"><?= $ruang['nama']; ?></option>
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
                            <h5 class="modal-title">Edit Data Pengampu</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="editId" name="id">
                            <div class="mb-3">
                                <label for="editIdMk" class="form-label">Mata Kuliah</label>
                                <select class="form-control" id="editIdMk" name="id_mk" required>
                                    <?php foreach ($matakuliah_list as $matkul): ?>
                                    <option value="<?= $matkul['id']; ?>"><?= $matkul['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editIdDosen" class="form-label">Dosen</label>
                                <select class="form-control" id="editIdDosen" name="id_dosen" required>
                                    <?php foreach ($dosen_list as $dosen): ?>
                                    <option value="<?= $dosen['id']; ?>"><?= $dosen['nama']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editKelas" class="form-label">Kelas</label>
                                <select class="form-control" id="editIdKelas" name="kelas" required>
                                    <?php foreach ($kelas_list as $kelas): ?>
                                    <option value="<?= $kelas['id']; ?>"><?= $kelas['nama_kelas']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editTahunAkademik" class="form-label">Tahun Akademik</label>
                                <select class="form-control" id="editTahunAkademik" name="tahun_akademik" required>
                                    <?php foreach ($tahun_akademik_list as $tahun): ?>
                                    <option value="<?= $tahun['id']; ?>"><?= $tahun['tahun']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editIdProdi" class="form-label">Program Studi</label>
                                <select class="form-control" id="editIdProdi" name="id_prodi" required>
                                    <?php foreach ($prodi_list as $prodi): ?>
                                    <option value="<?= $prodi['id']; ?>"><?= $prodi['prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
                                <label for="editKuota" class="form-label">Kuota</label>
                                <input type="number" class="form-control" id="editKuota" name="kuota" required>
                            </div>
                            <div class="mb-3">
                                <label for="editIdRuang" class="form-label">Ruang</label>
                                <select class="form-control" id="editIdRuang" name="id_ruang" required>
                                    <?php foreach ($ruang_list as $ruang): ?>
                                    <option value="<?= $ruang['id']; ?>"><?= $ruang['nama']; ?></option>
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
        
        // Mengambil atribut data yang ada pada tombol Edit
        const id = button.getAttribute('data-id');
        const id_mk = button.getAttribute('data-id_mk');
        const id_dosen = button.getAttribute('data-id_dosen');
        const kelas = button.getAttribute('data-kelas');
        const tahun_akademik = button.getAttribute('data-tahun_akademik');
        const id_prodi = button.getAttribute('data-id_prodi');
        const semester = button.getAttribute('data-semester');
        const kuota = button.getAttribute('data-kuota');
        const id_ruang = button.getAttribute('data-id_ruang');

        // Menetapkan nilai ke input di dalam modal edit
        document.getElementById('editId').value = id;
        document.getElementById('editIdMk').value = id_mk;
        document.getElementById('editIdDosen').value = id_dosen;
        document.getElementById('editKelas').value = kelas;
        document.getElementById('editTahunAkademik').value = tahun_akademik;
        document.getElementById('editIdProdi').value = id_prodi;
        document.getElementById('editSemester').value = semester;
        document.getElementById('editKuota').value = kuota;
        document.getElementById('editIdRuang').value = id_ruang;

        // Menyusun aksi form edit untuk mengarah ke route yang tepat
        const formEdit = document.getElementById('formEdit');
        formEdit.action = `/pengampu/update/${id}`;
    });
</script>


<?= $this->endSection(); ?>
