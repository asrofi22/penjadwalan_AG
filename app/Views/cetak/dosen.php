<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Data Dosen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 3px;
            text-align: left;
            font-size: 11px;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
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
    </style>
</head>
<body>
    <h1>Data Dosen</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Pangkat/Gol</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Tgl Lahir</th>
                <th>Status</th>
                <th>Homebase</th>
                <th>Id Scopus</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php foreach ($dosen_list as $dosen): ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $dosen['nip'] ?></td>
                <td><?= $dosen['nama'] ?></td>
                <td><?= $dosen['pangkat'] ?></td>
                <td><?= $dosen['telp'] ?></td>
                <td><?= $dosen['email'] ?></td>
                <td><?= $dosen['tgl_lahir'] ?></td>
                <td>
                    <?php
                    switch ($dosen['status_dosen']) {
                        case 1: echo "Dosen Tetap PNS"; break;
                        case 2: echo "Dosen PPPK"; break;
                        case 3: echo "Dosen Tetap Bukan PNS"; break;
                        case 4: echo "Dosen Tetap BLU"; break;
                        case 5: echo "Dosen Luar Biasa"; break;
                        default: echo "Status Tidak Diketahui"; break;
                    }
                    ?>
                </td>
                <td><?= $dosen['nama_prodi'] ?></td>
                <td><?= $dosen['id_scopus'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>