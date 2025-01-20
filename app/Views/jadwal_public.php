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
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>/assets/img/favicon.png" />
    <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/js/all.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.28.0/feather.min.js" crossorigin="anonymous"></script>

    <style>
        .small-font {
            font-size: 14px; /* Ubah ukuran sesuai kebutuhan */
        }

        .small-font th, .small-font td {
            font-size: 13.5px; /* Terapkan ukuran font pada sel header dan isi tabel */
        }

        /* Sembunyikan elemen pencarian bawaan DataTables */
        .dataTables_filter {
            display: none;
        }

        /* Tata letak untuk input pencarian dan entries per page */
        .datatable-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .datatable-top .datatable-dropdown {
            margin-right: 1rem;
        }

        .datatable-top .custom-search {
            display: flex;
            align-items: center;
            flex-grow: 1; /* Input pencarian akan mengisi sisa ruang yang tersedia */
            margin-left: 1rem; /* Jarak antara entries per page dan input pencarian */
        }

        .datatable-top .custom-search input {
            margin-left: 1rem;
        }
    </style>
</head>
<body class="nav-fixed">

<div id="layoutSidenav_content">
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="calendar"></i></div>
                                Jadwal Kuliah
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
    <div class="card mb-4">
        <div class="card-header">Data Jadwal Kuliah</div>
        <div class="card-body">
            <!-- Form Filter -->
            <form method="GET" action="<?= base_url('jadwal'); ?>">
                <div class="row mb-3">
                    <!-- Filter Semester -->
                    <div class="col-md-4">
                        <label class="form-label">Semester</label>
                        <select id="semester_tipe" name="semester_tipe" class="form-control" onchange="this.form.submit()">
                            <option value="1" <?= ($semester_tipe == 1) ? 'selected' : ''; ?>>GANJIL</option>
                            <option value="2" <?= ($semester_tipe == 2) ? 'selected' : ''; ?>>GENAP</option>
                        </select>
                    </div>

                    <!-- Filter Tahun Akademik -->
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                </div>
            </form>

            <!-- Tabel Jadwal -->
            <?php if (empty($rs_riwayat)) : ?>
                <div class="alert alert-info">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    Tidak ada data.
                </div>
            <?php else : ?>
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
                            <th>Kuota</th>
                            <th>Ruang</th>
                            <th>Kapasitas</th>
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
                                <td><?= esc($jadwal['kuota']) ?></td>
                                <td><?= esc($jadwal['ruang']) ?></td>
                                <td><?= esc($jadwal['kapasitas']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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
        }
    });

    // Tambahkan input pencarian custom ke dalam div yang sama dengan entries per page
    const datatableTop = document.querySelector('.datatable-top');
    if (datatableTop) {
        const customSearch = document.createElement('div');
        customSearch.className = 'custom-search';
        customSearch.innerHTML = `
            <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan kata kunci (contoh: Kimia, III B, LIDIA)">
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