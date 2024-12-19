<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>Penjadwalan</h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
            <li class="active">Penjadwalan</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="container-fluid">
                            <?php if (isset($msg)): ?>                        
                                <div class="alert alert-error">
                                    <button type="button" class="close" data-dismiss="alert">x</button>                
                                    <?= $msg; ?>
                                </div>  
                            <?php endif; ?>
                            <?php if (isset($waktu)): ?>                        
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">x</button>                
                                    <?= $waktu; ?>
                                </div>  
                            <?php endif; ?>
                            <?php if (isset($simpan)): ?>                        
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">x</button>                
                                    <?= $simpan; ?>
                                </div>  
                            <?php endif; ?>
                            <?php if (isset($hapus)): ?>                        
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert">x</button>                
                                    <?= $hapus; ?>
                                </div>  
                            <?php endif; ?>
                            
                            <div id="notif" style="display: none" class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">x</button>                
                                <?= 'Berhasil Menyimpan Jadwal'; ?>
                            </div>

                            <?php if (!isset($ses_id_dosen)): ?>
                                <form class="form" method="POST" action="<?= base_url().'index.php/penjadwalan2/index'; ?>">
                                    <label>Semester</label>
                                    <select id="tipe_semester" name="tipe_semester" class="input-xlarge" onchange="change_get()">            
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

                                    <label>Tahun Akademik</label>
                                    <select id="tahun_akademik" name="tahun_akademik" class="input-xlarge" onchange="change_get()">
                                        <?php  
                                        if (isset($tahun_a) && $tahun_a == true) {
                                            $tahun_awal = $this->TahunakademikModel->tahun_awal($tahun_a);
                                            foreach ($tahun_awal as $a);
                                            echo '<option value="' . $a['id'] . '">' . $a['tahun'] . '</option>';
                                        }
                                        // Pastikan $rs_tahun sudah didefinisikan
                                        foreach($rs_tahun as $tahun) { 
                                        ?>
                                            <option value="<?php echo $tahun['id'];?>" <?php echo session('pengampu_tahun_akademik') === $tahun['tahun'] ? 'selected':''; ?>> <?php echo $tahun['tahun']; ?>
                                                
                                        <?php  
                                        } 
                                        ?>
                                    </select>

                                    <label>Prodi</label>
                                    <select id="prodi" name="prodi" class="input-xlarge">
                                    <?php  
                                        if(isset($prodi) && $prodi == true){
                                        $id_prodi = $this->ProdiModel->per_prodi($prodi);
                                            foreach($id_prodi as $j);
                                            echo'<option value="'.$j['id'].'">'.$j['prodi'].'</option>';
                                            echo'<option value="0">Semua Prodi</option>';
                                        }
                                        else{
                                            echo'<option value="0">Semua Prodi</option>';
                                        }
                                            
                                            foreach($semua_prodi as $sj) { 
                                            echo'<option value="'.$sj['prodi'].'">'.$sj['prodi'].'</option>';
                                            } 
                                            ?>
                                  </select>

                                  <input type="hidden" name="jumlah_populasi" value="<?= isset($jumlah_populasi) ? $jumlah_populasi : '50'; ?>">  
                                  
                                  <div class="block span6">
                                      <input type="hidden" name="probabilitas_crossover" value="<?= isset($probabilitas_crossover) ? $probabilitas_crossover : '0.70'; ?>">
                                      <input type="hidden" name="probabilitas_mutasi" value="<?= isset($probabilitas_mutasi) ? $probabilitas_mutasi : '0.20'; ?>">
                                      <input type="hidden" name="jumlah_generasi" value="<?= isset($jumlah_generasi) ? $jumlah_generasi : '800'; ?>">
                                  </div>

                                  <br><br>
                                  <button type="submit" class="btn btn-primary" onclick="ShowProgressAnimation();"><i class="fa fa-plus"></i> Proses</button> 
                              </form>
                          <?php endif; ?>

                          <?php if (isset($rs_jadwal) && count($rs_jadwal) !== 0): ?>  
                              <a href="<?= base_url(); ?>index.php/penjadwalan2/hapus_jadwal">
                                  <button id="hapus_jadwal" class="btn btn-danger pull-right" onclick="ShowProgressAnimation();">
                                      <i class="icon-plus"></i> Hapus Jadwal
                                  </button>
                              </a>
                              <a href="<?= base_url(); ?>index.php/penjadwalan2/simpan_jadwal">
                                  <button id="simpan_jadwal" class="btn btn-success pull-right" onclick="ShowProgressAnimation();">
                                      <i class="icon-plus"></i> Simpan Jadwal
                                  </button>
                              </a>
                              <a href="<?= base_url(); ?>index.php/penjadwalan2/excel_report">
                                  <button class="btn btn-primary pull-right">
                                      <i class="icon-plus"></i> Cetak Excel
                                  </button>
                              </a>
                          <?php endif; ?>

                          <?php if (isset($rs_jadwal) && !empty($rs_jadwal)): ?>
                            <div class="alert alert-error">
                              <button type="button" class="close" data-dismiss="alert">×</button>             
                              Tidak ada data.
                            </div>  
                            <?php else: // Jika ada data ?>
                              <br><br>

                            <!-- // Pastikan rs_jadwal tidak kosong sebelum menjalankan foreach -->

                            <?php if (isset($rs_jadwal) && count($rs_jadwal) !== 0): ?>                                <label> Semester <?= $rs_jadwal->getRow(0)->tipe_semester; ?> Tahun Ajaran <?= $rs_jadwal->getRow(0)->nama_tahun; ?> </label>  <!-- ambil data dari row pertama -->
                              <table id="example1" class="table table-bordered table-striped">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Hari</th>
                                          <th>Sesi</th>
                                          <th>Jam</th>
                                          <th>Mata Kuliah</th>
                                          <th>Dosen</th>
                                          <th>SKS</th>
                                          <th>Kelas</th>
                                          <th>Semester</th>
                                          <th>Prodi</th>
                                          <th>Kuota</th>
                                          <th>Ruang</th>
                                          <th>Kapasitas</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <?php                 
                                      $i = 1;
                                      foreach ($rs_jadwal->getResult() as $jadwal):      
                                          echo '
                                          <tr>
                                              <td>' . $i . '</td>
                                              <td>' . $jadwal->hari . '</td>
                                              <td>' . $jadwal->sesi . '</td>
                                              <td>' . $jadwal->jam_kuliah . '</td>
                                              <td>' . $jadwal->nama_mk . '</td>
                                              <td>' . $jadwal->dosen . '</td>
                                              <td>' . $jadwal->jumlah_jam . '</td>
                                              <td>' . $jadwal->nama_kelas . '</td>
                                                <td>' . $jadwal->nama_semester . '</td>
                                                <td>' . $jadwal->prodi . '</td>
                                                <td>' . $jadwal->kuota . '</td>
                                                <td>' . $jadwal->ruang . '</td>
                                                <td>' . $jadwal->kapasitas . '</td>
                                            </tr>
                                            ';
                                            $i++;
                                        endforeach; 
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <!-- Tambahkan jika diperlukan -->
                                        </tr>
                                    </tfoot>
                                </table>
                                <?php else: ?>
                                    <div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">×</button>             
                                    Tidak ada data jadwal yang ditemukan.
                                </div>  
                                <?php endif; ?>
                                <div id="loading-div-background">
                                    <div id="loading-div" class="ui-corner-all">
                                        <img style="height:50px;width:50px;margin:20px;" src="<?php echo base_url()?>assets/loader2.gif" alt="Loading.."/><br>PROCESSING<br>PLEASE WAIT
                                    </div>
                                </div>
                            <?php endif; // End of else for rs_jadwal ?>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
</div>

<script type="text/javascript">
    function get_prodi() {		
        var tipe_semester = document.getElementById('tipe_semester');
        var tahun_akademik = document.getElementById('tahun_akademik');
        var prodi = document.getElementById('prodi');
		
        window.location.href = "<?php echo base_url().'index.php/riwayat_penjadwalan/index/' ?>" + tipe_semester.options[tipe_semester.selectedIndex].value  + "/" + tahun_akademik.options[tahun_akademik.selectedIndex].value + "/" + prodi.options[prodi.selectedIndex].value;		
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
                url: '<?php echo base_url();?>index.php/penjadwalan/simpan_jadwal',
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
