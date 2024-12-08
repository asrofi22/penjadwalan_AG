<nav class="topnav navbar navbar-expand shadow justify-content-between justify-content-sm-start navbar-light bg-white" id="sidenavAccordion">
            <!-- Sidenav Toggle Button-->
            <button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 me-2 ms-lg-2 me-lg-0" id="sidebarToggle"><i data-feather="menu"></i></button>
            
            <a class="navbar-brand pe-3 ps-4 ps-lg-2" href="index.html">Jadwal Kuliah FST</a>
            
            <!-- Navbar Items-->
            <ul class="navbar-nav align-items-center ms-auto">
                
                <!-- User Dropdown-->
                <li class="nav-item dropdown no-caret dropdown-user me-3 me-lg-4">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="<?= base_url(); ?>/assets/img/illustrations/profiles/profile-2.png" /></a>
                    <div class="dropdown-menu dropdown-menu-end border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="<?= base_url(); ?>/assets/img/illustrations/profiles/profile-2.png" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name">Valerie Luna</div>
                                <div class="dropdown-user-details-email">vluna@aol.com</div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#!">
                            <div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Account
                        </a>
                        <a class="dropdown-item" href="/logout">
                            <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sidenav shadow-right sidenav-light">
                    <div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">
                            <!-- Sidenav Menu Heading (Account)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <div class="sidenav-menu-heading d-sm-none">Account</div>
                            <!-- Sidenav Link (Alerts)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <a class="nav-link d-sm-none" href="#!">
                                <div class="nav-link-icon"><i data-feather="bell"></i></div>
                                Alerts
                                <span class="badge bg-warning-soft text-warning ms-auto">4 New!</span>
                            </a>
                            <!-- Sidenav Link (Messages)-->
                            <!-- * * Note: * * Visible only on and above the sm breakpoint-->
                            <a class="nav-link d-sm-none" href="#!">
                                <div class="nav-link-icon"><i data-feather="mail"></i></div>
                                Messages
                                <span class="badge bg-success-soft text-success ms-auto">2 New!</span>
                            </a>
                            <!-- Sidenav Menu Heading (Core)-->
                            <div class="sidenav-menu-heading">Main Navigation</div>
                            
                            <a class="nav-link" href="/">
                                <div class="nav-link-icon"><i data-feather="activity"></i></div>
                                Dashboard
                            </a>
                            <a class="nav-link" href="/dosen">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Dosen
                            </a>
                            <a class="nav-link" href="/matakuliah">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Mata Kuliah
                            </a>
                            <a class="nav-link" href="/waktutidakbersedia">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Waktu Tidak Bersedia
                            </a>
                            <a class="nav-link" href="/pengampu">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Penjadwalan
                            </a>
                            <a class="nav-link" href="/riwayat">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Riwayat Penjadwalan
                            </a>
                            <a class="nav-link" href="/kelas">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Kelas
                            </a>
                            <a class="nav-link" href="/prodi">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Prodi
                            </a>
                            <a class="nav-link" href="/semester">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Semester
                            </a>
                            <a class="nav-link" href="/tahunakademik">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Tahun Akademik
                            </a>
                            <a class="nav-link" href="/pengampu">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Pengampu
                            </a>
                            <a class="nav-link" href="/ruang">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Ruang
                            </a>
                            <a class="nav-link" href="/jam">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Jam
                            </a>
                            <a class="nav-link" href="/hari">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Hari
                            </a>
                            <a class="nav-link" href="/kromosom">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Kromosom
                            </a>
                            <a class="nav-link" href="/admin">
                                <div class="nav-link-icon"><i data-feather="rewind"></i></div>
                                Admin
                            </a><hr>
                            
                            <!-- Sidenav Link (Charts)-->
                            <a class="nav-link" href="/logout">
                                <div class="nav-link-icon"><i data-feather="x-square"></i></div>
                                Logout
                            </a>
                        </div>
                    </div>
                    <!-- Sidenav Footer-->
                    <div class="sidenav-footer">
                        <div class="sidenav-footer-content">
                            <div class="sidenav-footer-subtitle">Logged in as:</div>
                            <div class="sidenav-footer-title">Valerie Luna</div>
                        </div>
                    </div>
                </nav>
            </div>

            