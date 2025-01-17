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
                                <div class="page-header-icon"><i data-feather="calendar"></i></div>
                                Riwayat Penjadwalan
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Data Riwayat Penjadwalan</div>
                <div class="card-body">
                    <?php if (isset($hapus)) : ?>
                        <div class="alert alert-success">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?= $hapus; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('msg')) : ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <?= session()->getFlashdata('msg'); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?= base_url('pengampu/pengampu_search'); ?>">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Semester</label>
                                <select id="semester_tipe" name="semester_tipe" class="form-control" onchange="change_get()">
                                    <?php if ($semester_a == 1) : ?>
                                        <option value="1">GANJIL</option>
                                        <option value="2">GENAP</option>
                                    <?php else : ?>
                                        <option value="2">GENAP</option>
                                        <option value="1">GANJIL</option>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tahun Akademik</label>
                                <select id="tahun_akademik" name="tahun_akademik" class="form-control" onchange="change_get()">
                                    <?php if ($tahun_a == true) : ?>
                                        <?php
                                        $tahunModel = new \App\Models\TahunakademikModel();
                                        $tahun_awal = $tahunModel->tahun_awal($tahun_a);
                                        foreach ($tahun_awal as $a) :
                                        ?>
                                            <option value="<?= $a->id ?>"><?= $a->tahun ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php foreach ($rs_tahun as $tahun) : ?>
                                        <option value="<?= $tahun['id'] ?>" <?= session('pengampu_tahun_akademik') === $tahun['tahun'] ? 'selected' : '' ?>>
                                            <?= $tahun['tahun'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Program Studi</label>
                                    <select id="prodi" name="prodi" class="form-control" onchange="change_get()">
                                    <?php if ($prodi == true) : ?>
                                        <?php
                                        $prodiModel = new \App\Models\ProdiModel();
                                        $id_prodi = $prodiModel->per_prodi($prodi);
                                        foreach ($id_prodi as $j) :
                                        ?>
                                            <option value="<?= $j->id ?>"><?= $j->nama_prodi ?></option>
                                            <option value="0">Semua Prodi</option>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <option value="0">Semua Prodi</option>
                                    <?php endif; ?>

                                    <?php
                                    $semua_prodi = $prodiModel->semua_prodi2();
                                    foreach ($semua_prodi as $sj) :
                                    ?>
                                        <option value="<?= $sj['id'] ?>"><?= $sj['nama_prodi'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </form>

                    <?php if (empty($rs_riwayat)) : ?>
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            Tidak ada data.
                        </div>
                    <?php else : ?>
                        <div class="d-flex justify-content-between mb-3">
                            <a href="<?= base_url('riwayatpenjadwalan/hapus_jadwal'); ?>" class="btn btn-danger" onclick="ShowProgressAnimation();">
                                <i class="fa fa-trash"></i> Hapus Jadwal
                            </a>
                            <a href="<?= base_url('riwayatpenjadwalan/excel_report'); ?>" class="btn btn-primary">
                                <i class="fa fa-file-excel"></i> Cetak Excel
                            </a>
                        </div>

                        <table id="datatablesSimple" class="table table-bordered table-striped" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Hari</th>
                                <th>Sesi</th>
                                <th>Jam</th>
                                <th>Mata Kuliah</th>
                                <th>Dosen</th>
                                <th>SKS</th>
                                <th>Semester</th>
                                <th>Kelas</th>
                                <th>Prodi</th>
                                <th>Kuota</th>
                                <th>Ruang</th>
                                <th>Kapasitas</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $i = 1;
                            foreach ($rs_riwayat as $jadwal) :
                            ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $jadwal->hari ?></td>
                                    <td><?= $jadwal->sesi ?></td>
                                    <td><?= $jadwal->jam_kuliah ?></td>
                                    <td><?= $jadwal->nama_mk ?></td>
                                    <td><?= $jadwal->dosen ?></td>
                                    <td><?= $jadwal->jumlah_jam ?></td>
                                    <td><?= $jadwal->nama_semester ?></td>
                                    <td><?= $jadwal->nama_kelas ?></td>
                                    <td><?= $jadwal->nama_prodi ?></td>
                                    <td><?= $jadwal->kuota ?></td>
                                    <td><?= $jadwal->ruang ?></td>
                                    <td><?= $jadwal->kapasitas ?></td>
                                    <td>
                                        <button class="bbtn btn-datatable btn-icon btn-transparent-dark me-2"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $jadwal['id']; ?>"
                                            data-hari="<?= $jadwal['hari']; ?>"
                                            data-sesi="<?= $jadwal['sesi']; ?>"
                                            data-jam_kuliah="<?= $jadwal['jam_kuliah']; ?>"
                                            data-nama_mk="<?= $jadwal['nama_mk']; ?>"
                                            data-dosen="<?= $jadwal['dosen']; ?>"
                                            data-jumlah_jam="<?= $jadwal['jumlah_jam']; ?>"
                                            data-nama_semester="<?= $jadwal['nama_semester']; ?>"
                                            data-nama_kelas="<?= $jadwal['nama_kelas']; ?>"
                                            data-nama_prodi="<?= $jadwal['nama_prodi']; ?>"
                                            data-kuota="<?= $jadwal['kuota']; ?>"
                                            data-ruang="<?= $jadwal['ruang']; ?>"
                                            data-kapasitas="<?= $jadwal['kapasitas']; ?>">
                                            <i data-feather="edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php
                                $i++;
                            endforeach;
                            ?>
                        </tbody>
                    </table>
                    <?php endif; ?>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
                                <label for="editNamaid" class="form-label">id Mata Kuliah</label>
                                <input type="text" class="form-control" id="editNamaid" name="nama_id">
                            </div>
                            <div class="mb-3">
                                <label for="editIdProdi" class="form-label">Program Studi</label>
                                <select class="form-control" id="editIdProdi" name="id_prodi" required>
                                    <?php foreach ($prodi_list as $prodi): ?>
                                    <option value="<?= $prodi['id']; ?>"><?= $prodi['nama_prodi']; ?></option>
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

<script type="text/javascript">
    function change_get() {
        var semester_tipe = document.getElementById('semester_tipe');
        var tahun_akademik = document.getElementById('tahun_akademik');
        var prodi = document.getElementById('prodi');

        window.location.href = "<?= base_url('riwayatpenjadwalan'); ?>/" + semester_tipe.options[semester_tipe.selectedIndex].value + "/" + tahun_akademik.options[tahun_akademik.selectedIndex].value + "/" + prodi.options[prodi.selectedIndex].value;
    }

    // function ShowProgressAnimation() {
    //     $("#loading-div-background").show();
    // }
</script>

<?= $this->endSection(); ?>