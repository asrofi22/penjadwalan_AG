<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Sistem Cerdas Penjadwalan Mata Kuliah FST</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/litepicker/dist/css/litepicker.css" rel="stylesheet" />
    <link href="<?= base_url(); ?>/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>/img/fst.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

    <style>
    /* Tabel Responsive */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .small-font th, .small-font td {
        font-size: 13.5px;
    }

    /* Tata letak header agar tidak menutupi konten */
    .page-header {
        background: url('<?= base_url(); ?>/img/uinjambibanner.jpg') no-repeat center center;
        background-size: cover;
        height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
    }

    .content-container {
        margin-top: -50px; /* Menggeser konten ke bawah agar tidak menutupi header */
    }

    /* Styling Navigasi */
    .navbar {
        background-color: #343a40;
    }
    .navbar .nav-link {
        color: white;
    }
    .navbar .nav-link:hover {
        color: #f8f9fa;
    }
    .navbar-brand img {
        height: 40px;
        margin-right: 10px;
    }
    </style>
</head>
<body class="nav-fixed">

<!-- Navigasi -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">
        <img src="<?= base_url(); ?>/img/fst.png" alt="Logo">Sistem Penjadwalan FST UIN Sutha</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link btn btn-primary text-white px-3" href="/">Login</a></li>
            </ul>
        </div>
    </div>
</nav>

<div id="layoutSidenav_content">
    <main>
        <header class="page-header">
            <div class="container">
                <h1 class="page-header-title text-white">
                    <i data-feather=""></i> Jadwal Kuliah Fakultas Sains dan Teknologi UIN Sutha Jambi
                </h1>
            </div>
        </header>

        <div class="container-xl px-4 content-container">

            <div class="card mb-4">
                <div class="card-header">Data Jadwal Kuliah</div>
                <div class="card-body">
            <!-- Form Filter -->
            <form method="GET" action="<?= base_url('jadwal'); ?>">
                <div class="row mb-3">
                    <!-- Filter Semester -->
                    <div class="col-md-3">
                        <label class="form-label">Semester</label>
                        <select id="semester_tipe" name="semester_tipe" class="form-control" onchange="this.form.submit()">
                            <option value="1" <?= ($semester_tipe == 1) ? 'selected' : ''; ?>>GANJIL</option>
                            <option value="2" <?= ($semester_tipe == 2) ? 'selected' : ''; ?>>GENAP</option>
                        </select>
                    </div>

                    <!-- Filter Tahun Akademik -->
                    <div class="col-md-3">
                        <label class="form-label">Tahun Akademik</label>
                        <select id="tahun_akademik" name="tahun_akademik" class="form-control" onchange="this.form.submit()">
                            <?php foreach ($rs_tahun as $tahun) : ?>
                                <option value="<?= $tahun['id']; ?>" <?= ($tahun_akademik == $tahun['id']) ? 'selected' : ''; ?>>
                                    <?= $tahun['tahun']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Filter Program Studi -->
                    <div class="col-md-3">
                        <label class="form-label">Program Studi</label>
                        <select id="prodi" name="prodi" class="form-control" onchange="this.form.submit()">
                            <option value="0" <?= ($prodi == 0) ? 'selected' : ''; ?>>Semua Prodi</option>
                            <?php foreach ($rs_prodi as $prodi_item) : ?>
                                <option value="<?= $prodi_item['id']; ?>" <?= ($prodi == $prodi_item['id']) ? 'selected' : ''; ?>>
                                    <?= $prodi_item['nama_prodi']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Filter Dosen -->
                    <div class="col-md-3">
                        <label class="form-label">Dosen</label>
                        <select id="dosen" name="dosen" class="form-control" onchange="this.form.submit()">
                            <option value="0" <?= ($dosen == 0) ? 'selected' : ''; ?>>Semua Dosen</option>
                            <?php foreach ($rs_dosen as $dosen_item) : ?>
                                <option value="<?= $dosen_item['id']; ?>" <?= ($dosen == $dosen_item['id']) ? 'selected' : ''; ?>>
                                    <?= $dosen_item['nama']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <!-- Tombol Cetak PDF --> 
                <div class="mb-3">
                    <a href="<?= base_url('jadwal/cetak_pdf') . '?' . http_build_query($_GET); ?>" class="btn btn-primary">
                        <i class="fas fa-file-pdf"></i> Cetak PDF
                    </a>
                </div>
            </form>

            <!-- Tabel Jadwal -->
            <?php if (empty($rs_riwayat)) : ?>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Tidak ada data.
                </div>
            <?php else : ?>
                <div class="table-responsive">
                <table id="datatablesSimple" class="table table-bordered table-striped small-font">
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
                        <?php $i = 1; ?>
                        <?php foreach ($rs_riwayat as $jadwal) : ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><?= esc($jadwal['hari']) ?></td>
                                <td><?= esc($jadwal['sesi']) ?></td>
                                <td><?= esc($jadwal['jam_kuliah']) ?></td>
                                <td><?= esc($jadwal['nama_mk']) ?></td>
                                <td><?= esc($jadwal['dosen']) ?></td>
                                <td><?= esc($jadwal['jumlah_jam']) ?></td>
                                <td><?= esc($jadwal['nama_semester']) ?></td>
                                <td><?= esc($jadwal['nama_kelas']) ?></td>
                                <td><?= esc($jadwal['nama_prodi']) ?></td>
                                <td><?= esc($jadwal['ruang']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>/js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>/assets/demo/chart-area-demo.js"></script>
<script src="<?= base_url(); ?>/assets/demo/chart-bar-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>/js/datatables/datatables-simple-demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/litepicker/dist/bundle.js" crossorigin="anonymous"></script>
<script src="<?= base_url(); ?>/js/litepicker.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Simple DataTables
    const dataTable = new simpleDatatables.DataTable('#datatablesSimple', {
        searchable: false, // Nonaktifkan fitur pencarian bawaan
        perPage: 10, // Jumlah baris per halaman
        perPageSelect: [10, 25, 50, 100], // Opsi entries per page
        layout: {
            top: '', // Tidak ada elemen di bagian atas
            bottom: 'info paging' // Info dan pagination di bagian bawah
        },
        responsive: true
    });

    // Tambahkan input pencarian custom ke dalam div yang sama dengan entries per page
    const datatableTop = document.querySelector('.datatable-top');
    if (datatableTop) {
        const customSearch = document.createElement('div');
        customSearch.className = 'custom-search';
        customSearch.innerHTML = `
            <input type="text" id="searchInput" class="form-control" placeholder="Masukkan kata kunci">
        `;
        datatableTop.appendChild(customSearch);
    }

    // Pencarian realtime menggunakan input custom
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase(); // Ambil nilai dari input pencarian
        const rows = document.querySelectorAll('#datatablesSimple tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let match = false;

            // Cek setiap kolom secara terpisah
            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(searchValue)) {
                    match = true; // Jika ada kecocokan di kolom mana pun
                }
            });

            // Cek gabungan nilai dari kolom tertentu (misalnya, Semester dan Kelas)
            const semester = cells[7].textContent.toLowerCase(); // Kolom Semester (indeks 7)
            const kelas = cells[8].textContent.toLowerCase(); // Kolom Kelas (indeks 8)
            const combinedValue = `${semester} ${kelas}`; // Gabungkan nilai

            if (combinedValue.includes(searchValue)) {
                match = true; // Jika ada kecocokan di gabungan kolom
            }

            // Tampilkan atau sembunyikan baris berdasarkan hasil pencarian
            if (match) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>