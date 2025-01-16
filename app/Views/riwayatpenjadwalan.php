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
        <!-- /.container-xl -->
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