<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
            <div id="layoutSidenav_content">
                <main>
                    <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                        <div class="container-xl px-4">
                            <div class="page-header-content pt-4">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col-auto mt-4 d-flex align-items-center">
                                        <img src="<?= base_url('img/fst.png') ?>" alt="Logo" class="me-3" width="80" height="80">
                                        <div>
                                            <h1 class="page-header-title">
                                                <i class="me-2" data-feather="activity"></i> Dashboard
                                            </h1>
                                            <div class="page-header-subtitle text-white-75">Sistem Cerdas Penjadwalan Mata Kuliah FST</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                    <!-- Main page content-->
                    <div class="container-xl px-4 mt-n10">
                        <div class="row">
                            <div class="col-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body h-100 p-4">
                                        <div class="row align-items-center">
                                            
                                                <div class="col-lg-8 text-center text-lg-start mb-2 mb-lg-0">
                                                    <h1 class="text-primary">Selamat Datang di Sistem Cerdas Penjadwalan Mata Kuliah FST!</h1>
                                                    <p class="text-gray-700 mb-0">Kelola jadwal mata kuliah dengan mudah, cepat, dan akurat. Sistem ini dirancang untuk membantu mengatur jadwal secara efisien, mengurangi resiko bentrok jadwal, dan mendukung kegiatan akademik di Fakultas Sains dan Teknologi.</p>
                                                </div>
                                            
                                            <div class="col-lg-4 text-center"><img class="img-fluid" src="<?= base_url(); ?>/img/ilustrasi2.jpg" style="max-width: 19rem" /></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Example Colored Cards for Dashboard Demo-->
                        <div class="row">
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-success text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Jadwal</div>
                                                <div class="text-lg fw-bold"><?= $totalJadwal; ?></div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="calendar"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="<?= base_url('riwayatpenjadwalan'); ?>">Lihat Detail</a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-danger text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Pengampu</div>
                                                <div class="text-lg fw-bold"><?= $totalPengampu; ?></div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="user-check"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="<?= base_url('pengampu'); ?>">Lihat Detail</a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-primary text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Mata Kuliah</div>
                                                <div class="text-lg fw-bold"><?= $totalMatakuliah; ?></div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="book"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="<?= base_url('matakuliah'); ?>">Lihat Detail</a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-3 mb-4">
                                <div class="card bg-warning text-white h-100">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="me-3">
                                                <div class="text-white-75 small">Total Dosen</div>
                                                <div class="text-lg fw-bold"><?= $totalDosen; ?></div>
                                            </div>
                                            <i class="feather-xl text-white-50" data-feather="users"></i>
                                        </div>
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between small">
                                        <a class="text-white stretched-link" href="<?= base_url('dosen'); ?>">Lihat Detail</a>
                                        <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>
                </main>
                <footer class="footer-admin mt-auto footer-light">
                    <div class="container-xl px-4">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; 2024 Asrofi</div>
                            
                        </div>
                    </div>
                </footer>
            </div>
<?= $this->endSection(); ?>