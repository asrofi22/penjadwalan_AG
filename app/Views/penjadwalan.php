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
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($msg)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= $msg ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($waktu)): ?>
                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                            <?= $waktu ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!isset($ses_id_dosen)): ?>
                        <form method="POST" action="<?= base_url('penjadwalan/store'); ?>" id="penjadwalanForm">
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

                            <button type="submit" class="btn btn-primary mb-2" id="submitBtn">
                                <i class="fa fa-plus"></i> Proses
                            </button> 
                        </form>
                    <?php endif; ?>

                    <?php if (isset($rs_jadwal) && count($rs_jadwal) !== 0): ?>  
                        <a href="<?= base_url(); ?>penjadwalan/hapus_jadwal" class="btn btn-danger mb-2" onclick="showLoading()">
                            <i class="fa fa-trash"></i> Hapus Jadwal
                        </a>
                        <a href="<?= base_url(); ?>penjadwalan/simpan_jadwal" class="btn btn-success mb-2" onclick="showLoading()">
                            <i class="fa fa-save"></i> Simpan Jadwal
                        </a>
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
                                <th>Ruang</th>
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
                            Tidak ada data jadwal yang ditemukan.
                        </div>  
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Loading Overlay -->
<div id="loading-overlay">
    <div class="spinner"></div>
    <h3>Memproses penjadwalan...</h3>
    <p id="time-elapsed">Waktu: 0 detik</p>
    <div id="timeout-warning" class="alert alert-warning mt-3" style="display: none;">
        Proses memakan waktu lebih lama dari biasanya. Silakan tunggu...
    </div>
</div>

<style>
    #loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.8);
        z-index: 9999;
        display: none;
        justify-content: center;
        align-items: center;
        color: white;
        flex-direction: column;
        text-align: center;
    }
    
    .spinner {
        width: 50px;
        height: 50px;
        border: 5px solid #f3f3f3;
        border-top: 5px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin-bottom: 15px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<script>
    function showLoading() {
        document.getElementById('loading-overlay').style.display = 'flex';
    }

    document.getElementById('penjadwalanForm').addEventListener('submit', function(e) {
        const loadingOverlay = document.getElementById('loading-overlay');
        loadingOverlay.style.display = 'flex';
        
        let seconds = 0;
        const timeElapsed = document.getElementById('time-elapsed');
        const timeoutWarning = document.getElementById('timeout-warning');
        
        const timer = setInterval(() => {
            seconds++;
            timeElapsed.textContent = `Waktu: ${seconds} detik`;
            
            // Tampilkan peringatan setelah 60 detik
            if (seconds >= 60) {
                timeoutWarning.style.display = 'block';
            }
            
            // Set timeout maksimal 180 detik (3 menit)
            if (seconds >= 180) {
                clearInterval(timer);
                timeElapsed.innerHTML += '<br><strong>Proses dihentikan karena melebihi batas waktu</strong>';
                
                // Anda bisa menambahkan kode untuk membatalkan request di sini
                // Contoh: window.location.href = "<?= base_url('penjadwalan') ?>";
            }
        }, 1000);
        
        // Bersihkan interval ketika halaman selesai dimuat
        window.addEventListener('load', function() {
            clearInterval(timer);
        });
    });
</script>

<?= $this->endSection(); ?>