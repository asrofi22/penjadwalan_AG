<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjadwalan Kuliah</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Jadwal Kuliah</h1>

        <!-- Flash message -->
        <?php if (session()->getFlashdata('message')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
        <?php endif; ?>

        <!-- Button Generate -->
        <form method="post" action="<?= base_url('/penjadwalan/generate') ?>">
            <button type="submit" class="btn btn-primary mb-3">Generate Jadwal</button>
        </form>

        <!-- Table Jadwal -->
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>ID Pengampu</th>
                    <th>ID Jam</th>
                    <th>ID Hari</th>
                    <th>ID Ruang</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jadwal_list as $jadwal): ?>
                <tr>
                    <td><?= $jadwal['id'] ?></td>
                    <td><?= $jadwal['id_pengampu'] ?></td>
                    <td><?= $jadwal['id_jam'] ?></td>
                    <td><?= $jadwal['id_hari'] ?></td>
                    <td><?= $jadwal['id_ruang'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
