<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Kuliah PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font-size: 12px; /* Mengecilkan ukuran font agar muat di format potret */
        }
        th {
            background-color: #f2f2f2;
        }

        /* Menetapkan format kertas ke A4 dalam mode potret */
        @page {
            size: A4 portrait;
            margin: 15mm;
        }

        /* Menyesuaikan margin untuk cetakan */
        body {
            margin: 0;
            padding: 0;
        }
        /* Style untuk label di atas tabel */
        .label {
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <h1>Jadwal Kuliah</h1>
    <div class="label">
        1. Fakultas : Sains dan Teknologi<br>
        2. Tahun Akademik : <?= esc($tahun_akademik_label) ?><br>
        3. Dosen : <?= esc($dosen_label) ?>
    </div>
    <table>
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
</body>
</html>