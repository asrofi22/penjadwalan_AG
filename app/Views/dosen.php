<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div id="layoutSidenav_content">
    <main>
        <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
            <div class="container-xl px-4">
                <div class="page-header-content pt-4">
                    <div class="row align-items-center justify-content-between">
                        <div class="col-auto mt-4">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="users"></i></div>
                                Tabel Data Dosen
                            </h1>
                        </div>
                        <div class="col-auto mt-4">
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">Tambah Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Data Dosen</span>
                    <a href="/dosen/cetak" class="btn btn-primary" target="_blank">Cetak Data</a>
                </div>
                <div class="card-body">
                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
                <!-- <div class="col-auto">
                    <a href="/dosen/cetak" class="btn btn-primary" target="_blank">Cetak Data</a>
                </div> -->
                    <table id="datatablesSimple" class="table table-striped table-bordered" style="font-size: 12px;">
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
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; // Inisialisasi nomor urut ?>
                            <?php foreach ($dosen_list as $dosen): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $dosen['nip'] ?></td>
                                <td><?= $dosen['nama'] ?></td>
                                <td><?= $dosen['pangkat'] ?></td>
                                <td><?= $dosen['telp'] ?></td>
                                <td><?= $dosen['email'] ?></td>
                                <td><?= $dosen['tgl_lahir'] ?></td>
                                <td><?php
                                    // Konversi nilai status_dosen ke teks
                                    switch ($dosen['status_dosen']) {
                                        case 1:
                                            echo "Dosen Tetap PNS";
                                            break;
                                        case 2:
                                            echo "Dosen PPPK";
                                            break;
                                        case 3:
                                            echo "Dosen Tetap Bukan PNS";
                                            break;
                                        case 4:
                                            echo "Dosen Tetap BLU";
                                            break;
                                        case 5:
                                            echo "Dosen Luar Biasa";
                                            break;
                                        default:
                                            echo "Status Tidak Diketahui";
                                            break;
                                    }
                                    ?>
                                </td>
                                <td><?= $dosen['nama_prodi'] ?></td>
                                <td><?= $dosen['id_scopus'] ?></td>
                                <td>
                                    <button class="btn btn-datatable btn-icon btn-transparent-dark me-2" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit" 
                                            data-id="<?= $dosen['id'] ?>" 
                                            data-nip="<?= $dosen['nip'] ?>" 
                                            data-nama="<?= $dosen['nama'] ?>" 
                                            data-pangkat="<?= $dosen['pangkat'] ?>" 
                                            data-telp="<?= $dosen['telp'] ?>" 
                                            data-email="<?= $dosen['email'] ?>" 
                                            data-tgl_lahir="<?= $dosen['tgl_lahir'] ?>" 
                                            data-status="<?= $dosen['status_dosen'] ?>"
                                            data-id_prodi="<?= $dosen['id_prodi'] ?>" 
                                            data-id_scopus="<?= $dosen['id_scopus'] ?>" 
                                            >
                                        <i data-feather="edit"></i>
                                    </button>
                                    <a href="/dosen/delete/<?= $dosen['id'] ?>" class="btn btn-datatable btn-icon btn-transparent-dark" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');"><i data-feather="trash-2"></i></a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div> 
        </div>

        <!-- Modal Tambah -->
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="/dosen/store" method="post">
                        <?= csrf_field() ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTambahLabel">Tambah Data Dosen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="pangkat" class="form-label">Pangkat/Gol</label>
                                <input type="text" class="form-control" id="pangkat" name="pangkat" >
                            </div>
                            <div class="mb-3">
                                <label for="telp" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="telp" name="telp" >
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" >
                            </div>
                            <div class="mb-3">
                                <label for="tgl_lahir" class="form-label">Tgl Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" >
                            </div>
                            <div class="mb-3">
                                <label for="status_dosen" class="form-label">Status</label>
                                <select class="form-control" id="status_dosen" name="status_dosen" required>
                                    <option value="">Pilih Status</option>
                                    <option value="1">Dosen Tetap PNS</option>
                                    <option value="2">Dosen PPPK</option>
                                    <option value="3">Dosen Tetap Bukan PNS</option>
                                    <option value="4">Dosen Tetap BLU</option>
                                    <option value="5">Dosen Luar Biasa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_prodi" class="form-label">Homebase</label>
                                <select class="form-control" id="id_prodi" name="id_prodi" required>
                                    <?php foreach ($prodi_list as $prodi): ?>
                                    <option value="<?= $prodi['id']; ?>"><?= $prodi['nama_prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="id_scopus" class="form-label">Id Scopus</label>
                                <input type="text" class="form-control" id="id_scopus" name="id_scopus" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="formEdit" action="" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" id="editId" name="id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalEditLabel">Edit Data Dosen</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editNip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="editNip" name="nip" required>
                            </div>
                            <div class="mb-3">
                                <label for="editNama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="editNama" name="nama" required>
                            </div>
                            <div class="mb-3">
                                <label for="editPangkat" class="form-label">Pangkat/Gol</label>
                                <input type="text" class="form-control" id="editPangkat" name="pangkat">
                            </div>
                            <div class="mb-3">
                                <label for="editTelp" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="editTelp" name="telp">
                            </div>
                            <div class="mb-3">
                                <label for="editEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="editEmail" name="email">
                            </div>
                            <div class="mb-3">
                                <label for="editTgl_lahir" class="form-label">Tgl Lahir</label>
                                <input type="date" class="form-control" id="editTgl_lahir" name="tgl_lahir">
                            </div>
                            <div class="mb-3">
                                <label for="editStatusDosen" class="form-label">Status</label>
                                <select class="form-control" id="editStatusDosen" name="status_dosen" required>
                                    <option value="">Pilih Status</option>
                                    <option value="1">Dosen Tetap PNS</option>
                                    <option value="2">Dosen PPPK</option>
                                    <option value="3">Dosen Tetap Bukan PNS</option>
                                    <option value="4">Dosen Tetap BLU</option>
                                    <option value="5">Dosen Luar Biasa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editId_prodi" class="form-label">Homebase</label>
                                <select class="form-control" id="editId_prodi" name="id_prodi" required>
                                    <?php foreach ($prodi_list as $prodi): ?>
                                    <option value="<?= $prodi['id']; ?>"><?= $prodi['nama_prodi']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editId_scopus" class="form-label">Id Scopus</label>
                                <input type="text" class="form-control" id="editId_scopus" name="id_scopus" >
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</div>

<script>// Script untuk menampilkan modal tambah jika ada error
    $(document).ready(function() {
        <?php if (session()->getFlashdata('error') || session()->get('errors')): ?>
            $('#modalTambah').modal('show');
        <?php endif; ?>
    });
</script>
<script>
    
    // Isi modal edit dengan data dari tombol yang diklik
    const modalEdit = document.getElementById('modalEdit');
    modalEdit.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const nip = button.getAttribute('data-nip');
        const nama = button.getAttribute('data-nama');
        const pangkat = button.getAttribute('data-pangkat');
        const telp = button.getAttribute('data-telp');
        const email = button.getAttribute('data-email');
        const tgl_lahir = button.getAttribute('data-tgl_lahir');
        const status = button.getAttribute('data-status');
        const id_prodi = button.getAttribute('data-id_prodi');
        const id_scopus = button.getAttribute('data-id_scopus');


        // Isi form edit
        document.getElementById('editId').value = id;
        document.getElementById('editNip').value = nip;
        document.getElementById('editNama').value = nama;
        document.getElementById('editPangkat').value = pangkat;
        document.getElementById('editTelp').value = telp;
        document.getElementById('editEmail').value = email;
        document.getElementById('editTgl_lahir').value = tgl_lahir;
        document.getElementById('editStatusDosen').value = status;
        document.getElementById('editId_prodi').value = id_prodi;
        document.getElementById('editId_scopus').value = id_scopus;

        // Atur URL form
        const formEdit = document.getElementById('formEdit');
        formEdit.action = `/dosen/update/${id}`;
    });
</script>

<?= $this->endSection(); ?>
