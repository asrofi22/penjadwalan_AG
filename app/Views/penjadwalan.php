<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <header class="page-header page-header-dark pb-10" style="background-color: #800000;">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="calendar"></i></div>
                                Penjadwalan
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Form Penjadwalan</div>
                <div class="card-body">
                    
                    <?php if (isset($msg)): ?>                        
                        <div class="alert alert-danger">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <?= print_r($msg); ?>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($waktu)): ?>                        
                        <div class="alert alert-success">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <?= $waktu; ?>
                        </div>  
                    <?php endif; ?>
                    <!-- Notifikasi Sukses -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Notifikasi Error -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!isset($ses_id_dosen)): ?>
                        <form method="POST" action="<?= base_url('penjadwalan/store'); ?>">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Semester</label>
                                <select id="tipe_semester" name="tipe_semester" class="form-control" onchange="change_get()">            
                                    <?php
                                    if (!isset($semester_a) || $semester_a == false) {
                                        echo '<option value="1">GANJIL</option><option value="2">GENAP</option>';
                                    } else {
                                        $semester_b = ($semester_a == 1) ? 2 : 1;
                                        echo '<option value="'.$semester_a.'">'.($semester_a == 1 ? 'GANJIL' : 'GENAP').'</option>';
                                        echo '<option value="'.$semester_b.'">'.($semester_a == 1 ? 'GENAP' : 'GANJIL').'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tahun Akademik</label>
                                <select id="tahun_akademik" name="tahun_akademik" class="form-control" onchange="change_get()">
                                    <?php  
                                    if (isset($tahun_a) && $tahun_a == true && isset($tahun_awal) && !empty($tahun_awal)) {
                                        foreach ($tahun_awal as $a) {
                                            echo '<option value="' . $a->id . '">' . $a->tahun. '</option>';
                                        }
                                    }
                                    foreach($rs_tahun as $tahun) { 
                                    ?>
                                        <option value="<?php echo $tahun['id'];?>" <?php echo session('pengampu_tahun_akademik') === $tahun['tahun'] ? 'selected':''; ?>> <?php echo $tahun['tahun']; ?></option>
                                    <?php  
                                    } 
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Program Studi</label>
                                <select id="prodi" name="prodi" class="form-control">
                                    <option value="0">Semua Prodi</option>
                                    <?php if (isset($semua_prodi) && !empty($semua_prodi)) {
                                        foreach($semua_prodi as $sj) { 
                                            echo '<option value="'.$sj['id'].'">'.$sj['nama_prodi'].'</option>';
                                        } 
                                    } else { 
                                        echo '<option disabled>Tidak ada Prodi yang tersedia</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            </div>

                            <input type="hidden" name="jumlah_populasi" value="<?= isset($jumlah_populasi) ? $jumlah_populasi : '50'; ?>">  

                            <div class="mb-3">
                                <input type="hidden" name="probabilitas_crossover" value="<?= isset($probabilitas_crossover) ? $probabilitas_crossover : '0.70'; ?>">
                                <input type="hidden" name="probabilitas_mutasi" value="<?= isset($probabilitas_mutasi) ? $probabilitas_mutasi : '0.20'; ?>">
                                <input type="hidden" name="jumlah_generasi" value="<?= isset($jumlah_generasi) ? $jumlah_generasi : '800'; ?>">
                            </div>

                            <button type="submit" class="btn btn-primary mb-2" onclick="ShowProgressAnimation();"><i class="fa fa-plus"></i> Proses</button> 
                        </form>
                    <?php endif; ?>

                    <?php if (isset($rs_jadwal) && count($rs_jadwal) !== 0): ?>  
                        <!-- <a href="<?= base_url(); ?>penjadwalan/hapus_jadwal" class="btn btn-danger pull-right" onclick="ShowProgressAnimation();">Hapus Jadwal</a> -->
                        <a href="<?= base_url(); ?>penjadwalan/simpan_jadwal" class="btn btn-success pull-right" onclick="ShowProgressAnimation();">Simpan Jadwal</a>
                        <!-- <a href="<?= base_url(); ?>penjadwalan/excel_report" class="btn btn-primary pull-right">Cetak Excel</a> -->
                    <?php endif; ?>

                    <?php if (isset($rs_jadwal) && count($rs_jadwal) > 0): ?>
                    <h5>Semester <?= $rs_jadwal[0]['tipe_semester']; ?> Tahun Ajaran <?= $rs_jadwal[0]['nama_tahun']; ?></h5>  
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
                                <!-- <th>Kuota</th> -->
                                <th>Ruang</th>
                                <!-- <th>Kapasitas</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php                 
                            $i = 1;
                            foreach ($rs_jadwal as $jadwal):      
                                echo '
                                <tr class="A">
                                    <td>' . $i . '</td>
                                    <td>' . ($jadwal['hari'] ?? '') . '</td>
                                    <td>' . ($jadwal['sesi'] ?? '') . '</td>
                                    <td>' . ($jadwal['jam_kuliah'] ?? '') . '</td>
                                    <td>' . ($jadwal['nama_mk'] ?? '') . '</td>
                                    <td>' . ($jadwal['dosen'] ?? ''). '</td>
                                    <td>' . ($jadwal['jumlah_jam'] ?? 0) . '</td>
                                    <td>' . ($jadwal['nama_semester'] ?? '') . '</td>
                                    <td>' . ($jadwal['nama_kelas'] ?? '') . '</td>
                                    <td>' . ($jadwal['nama_prodi'] ?? '') . '</td>
                                    <td>' . ($jadwal['ruang'] ?? '') . '</td>
                                </tr>
                                ';
                                $i++;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                <?php else: ?>
                        <div class="alert alert-info">
                            <button type="button" class="close" data-dismiss="alert">×</button>             
                            Tidak ada data jadwal yang ditemukan.
                        </div>  
                    <?php endif; ?>

                    <!-- <div id="loading-div-background">
                        <div id="loading-div" class="ui-corner-all">
                            <img style="height:50px;width:50px;margin:20px;" src="<?php echo base_url()?>/assets/loader2.gif" alt="Loading.."/><br>PROCESSING<br>PLEASE WAIT
                        </div>
                    </div> -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.container-xl -->
    </main>
</div>

<script type="text/javascript">
    function get_prodi() {		
        var semester_tipe = document.getElementById('semester_tipe');
        var tahun_akademik = document.getElementById('tahun_akademik');
        var prodi = document.getElementById('prodi');
		
        window.location.href = "<?php echo base_url().'riwayatpenjadwalan/' ?>" + semester_tipe.options[semester_tipe.selectedIndex].value + "/" + tahun_akademik.options[tahun_akademik.selectedIndex].value + "/" + prodi.options[prodi.selectedIndex].value;		
    }

    $(document).ready(function () {
        $("#loading-div-background").css({ opacity: 0.5 });
        <?php if (isset($clear_text_box)): ?>    
            $('input[type=text]').each(function() {
                $(this).val('');
            });
        <?php endif; ?>
        
        $('#simpan_jadwa').on("click", function() {
            $.ajax({
                url: '<?php echo base_url();?>penjadwalan/simpan_jadwal',
                dataType: 'json',
                processData: false,
                contentType: false, 
                cache: false,
                async: false,
                success: function(data) {
                    document.getElementById('notif').style = 'display:block;';
                },
                error: function() {
                    alert('Could not get Data from Database');
                }
            });
        });
    });

    function ShowProgressAnimation() {
        $("#loading-div-background").show();
    }
</script>

<?= $this->endSection(); ?>