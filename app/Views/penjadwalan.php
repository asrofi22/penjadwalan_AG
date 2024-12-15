<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjadwalan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="content-wrapper">
    <section class="content-header">
        <h1>Penjadwalan</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Penjadwalan</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid">
                            <!-- Menampilkan pesan jika ada -->
                            <?php if(isset($waktu)): ?>
                                <div class="alert alert-success"><?= $waktu ?></div>
                            <?php endif; ?>

                            <?php if(isset($hapus)): ?>
                                <div class="alert alert-danger"><?= $hapus ?></div>
                            <?php endif; ?>

                            <!-- Form untuk menyimpan jadwal -->
                            <h4>Form Penjadwalan</h4>
                            <form method="POST" action="<?= base_url('penjadwalan3/simpan_jadwal') ?>">
                                <div class="form-group">
                                    <label for="tipe_semester">Tipe Semester</label>
                                    <select name="tipe_semester" id="tipe_semester" class="form-control" required>
                                        <option value="">Pilih Tipe Semester</option>
                                        <?php foreach ($semester_list as $semester): ?>
                                            <option value="<?= $semester['tipe_semester'] ?>"><?= $semester['tipe_semester'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="tahun_akademik">Tahun Akademik</label>
                                    <select name="tahun_akademik" id="tahun_akademik" class="form-control" required>
                                        <option value="">Pilih Tahun Akademik</option>
                                        <?php foreach ($tahun_akademik_list as $tahun): ?>
                                            <option value="<?= $tahun['id'] ?>"><?= $tahun['tahun'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="prodi">Program Studi</label>
                                    <select name="prodi" id="prodi" class="form-control">
                                        <option value="">Pilih Program Studi</option>
                                        <?php foreach ($prodi_list as $prodi): ?>
                                            <option value="<?= $prodi['id'] ?>"><?= $prodi['prodi'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Simpan Jadwal</button>
                            </form>

                            <h4 class="mt-5">Parameter untuk Algoritma Genetika</h4>
                            <form method="POST" action="<?= base_url('penjadwalan3/proses_penjadwalan') ?>">
                                <div class="form-group">
                                    <label for="jumlah_populasi">Jumlah Populasi</label>
                                    <input type="number" name="jumlah_populasi" id="jumlah_populasi" class="form-control" value="<?= isset($jumlah_populasi) ? $jumlah_populasi : '50' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="probabilitas_crossover">Probabilitas Crossover</label>
                                    <input type="text" name="probabilitas_crossover" id="probabilitas_crossover" class="form-control" value="<?= isset($probabilitas_crossover) ? $probabilitas_crossover : '0.7' ?>" required>
                                </div>
                                <div class="form-group">
                                <label for="probabilitas_mutasi">Probabilitas Mutasi</label>
                                    <input type="text" name="probabilitas_mutasi" id="probabilitas_mutasi" class="form-control" value="<?= isset($probabilitas_mutasi) ? $probabilitas_mutasi : '0.2' ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="jumlah_generasi">Jumlah Generasi</label>
                                    <input type="number" name="jumlah_generasi" id="jumlah_generasi" class="form-control" value="<?= isset($jumlah_generasi) ? $jumlah_generasi : '800' ?>" required>
                                </div>
                                <button type="submit" class="btn btn-info">Proses Jadwal</button>
                            </form>

                            <h4 class="mt-5">Jadwal yang Tersimpan</h4>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID Pengampu</th>
                                        <th>Hari</th>
                                        <th>Ruang</th>
                                        <th>Jam Kuliah</th>
                                        <th>Nama MK</th>
                                        <th>Dosen</th>
                                        <th>Nama Kelas</th>
                                        <th>Nama Semester</th>
                                        <th>Nama Prodi</th>
                                        <th>Kuota</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($rs_jadwal)): ?>
                                        <?php foreach ($rs_jadwal as $jadwal): ?>
                                            <tr>
                                                <td><?= $jadwal['id_pengampu'] ?></td>
                                                <td><?= $jadwal['id_hari'] ?></td>
                                                <td><?= $jadwal['id_ruang'] ?></td>
                                                <td><?= $jadwal['id_jam'] ?></td>
                                                <td><?= $jadwal['nama_mk'] ?></td>
                                                <td><?= $jadwal['dosen'] ?></td>
                                                <td><?= $jadwal['nama_kelas'] ?></td>
                                                <td><?= $jadwal['nama_semester'] ?></td>
                                                <td><?= $jadwal['nama_prodi'] ?></td>
                                                <td><?= $jadwal['kuota'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="10" class="text-center">Tidak ada jadwal yang tersimpan.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <h4 class="mt-5">Ekspor Laporan</h4>
                            <form method="POST" action="<?= base_url('penjadwalan3/excel_report') ?>">
                                <button type="submit" class="btn btn-success">Unduh Laporan Excel</button>
                            </form>

                            <h4 class="mt-5">Hapus Semua Jadwal</h4>
                            <form method="POST" action="<?= base_url('penjadwalan3/hapus_jadwal') ?>" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua jadwal?');">
                                <button type="submit" class="btn btn-danger">Hapus Jadwal</button>
                            </form>
                        </div>
                    </div> <!-- /.box-body -->
                </div> <!-- /.box -->
            </div> <!-- /.col -->
        </div> <!-- /.row -->
    </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script type="text/javascript">
    function ShowProgressAnimation() {
        $("#loading-div-background").show(); // Jika Anda memiliki elemen loading yang ingin ditampilkan
    }
</script>

</body>
</html>