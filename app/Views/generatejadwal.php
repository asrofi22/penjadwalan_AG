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
                                <div class="page-header-icon"><i class="fas fa-calendar-alt"></i></div>
                                Generate Jadwal Perkuliahan Menggunakan Algoritma Genetika
                            </h1>
                        </div>
                        <div class="col-auto">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="/home/dashboard"><i class="fas fa-igloo mr-2"></i>Home</a></li>
                                <li class="breadcrumb-item active">Generate Jadwal</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Form Generate Jadwal Perkuliahan</div>
                <div class="card-body">
                    <?= form_open('/generatejadwal'); ?>
                    <div class="mb-3">
                        <label>Jumlah <span class="text-maroon" data-toggle="modal" data-target="#individuDetail">Individu</span> Dibangkitkan</label>
                        <select name="individu" class="form-control select2bs4 <?= session()->getFlashdata('errorJumlahIndividu') ? 'is-invalid' : ''; ?>">
                            <?php foreach (range(4, 50) as $v): ?>
                                <option value="<?= $v; ?>"><?= $v; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errorJumlahIndividu')): ?>
                            <p class="error-msg"><?= session()->getFlashdata('errorJumlahIndividu'); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label>Maksimal <span class="text-maroon" data-toggle="modal" data-target="#generasiDetail">Generasi</span></label>
                        <select name="generasi" class="form-control select2bs4 <?= session()->getFlashdata('errorJumlahGenerasi') ? 'is-invalid' : ''; ?>">
                            <?php foreach (range(10, 500) as $v): ?>
                                <option value="<?= $v; ?>"><?= $v; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errorJumlahGenerasi')): ?>
                            <p class="error-msg"><?= session()->getFlashdata('errorJumlahGenerasi'); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label>Tahun Ajaran</label>
                        <select name="tahun_akademik" id="the_tahun_akademik" class="form-control select2bs4 <?= session()->getFlashdata('errorTahunAkademik') ? 'is-invalid' : ''; ?>">
                            <option value="" id="the_tahun_akademik_default">-- Silahkan Pilih Tahun Ajaran --</option>
                            <?php foreach ($allTahunAkademik as $tahun): ?>
                                <option value="<?= $tahun['tahun']; ?>"><?= $tahun['tahun']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (session()->getFlashdata('errorTahunAkademik')): ?>
                            <p class="error-msg"><?= session()->getFlashdata('errorTahunAkademik'); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" name="algoritma" id="algoritma" class="form-check-input">
                        <label class="form-check-label" for="algoritma">Tampilkan Proses Algoritma</label>
                    </div>

                    <div class="modal-footer">
                        <a href="/" class="btn btn-outline-greenTheme">
                            <i class="fas fa-arrow-circle-right mr-1"></i>Opsi Lain
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-dna mr-2"></i>Generate Jadwal
                        </button>
                    </div>
                    
                    <div class="row mt-4 optional-input">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label><span class="text-maroon" data-toggle="modal" data-target="#crossOverDetail">Crossover Rate</span></label>
                                <select name="crossover_rate" class="form-control select2bs4 <?= session()->getFlashdata('crossover_rate') ? 'is-invalid' : ''; ?>">
                                    <?php foreach (range(1, 100) as $v): ?>
                                        <option value="<?= $v; ?>" <?= $v == 75 ? 'selected' : ''; ?>><?= $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session()->getFlashdata('crossover_rate')): ?>
                                    <div class="invalid-feedback"><?= session()->getFlashdata('crossover_rate'); ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="dosen-request-container">
                                <?php
                                $totalPengampuTabel = 0;
                                foreach ($countPengampuTabel as $countPengampu):
                                    $totalPengampuTabel += $countPengampu['semester_ganjil_count'] + $countPengampu['semester_genap_count'];
                                endforeach;
                                ?>

                                <input type="hidden" value="<?= $totalPengampuTabel; ?>" id='maxKelas'>

                                <?php for ($i = 1; $i <= $totalPengampuTabel; $i++): ?>
                                    <div class="dosen-request-wrap-<?= $i; ?> d-none">
                                        <hr class="hr-text" data-content="Prioritas Dosen <?= $i; ?>">
                                        <div class="mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label>Dosen Pengajar</label>
                                                    <select name="dosen[]" id="select-dosen_<?= $i; ?>" class="form-control select2bs4">
                                                        <option value="" id="default-select-dosen_<?= $i; ?>" selected>-- Silahkan Pilih Dosen --</option>
                                                        <?php foreach ($allDosen as $dosen): ?>
                                                            <option value="<?= $dosen->nama; ?>"><?= ucwords($dosen->nama); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Kelas</label>
                                                    <select name="kelas[]" id="select-kelas_<?= $i; ?>" disabled class="form-control select2bs4">
                                                        <option value="" selected id="default-select-kelas_<?= $i; ?>">-- Kelas Yang Diajar --</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label>Hari Mengajar</label>
                                                    <select name="hari[]" id="select-hari_<?= $i; ?>" class="form-control select2bs4">
                                                        <option value="" id="default-select-hari_<?= $i; ?>">-- Hari Mengajar --</option>
                                                        <option value="" id="default-select2-hari_<?= $i; ?>">-- Pilih Hari --</option>
                                                        <?php foreach ($allHari as $hari): ?>
                                                            <option value="<?= $hari->id_hari; ?>"><?= ucwords($hari->nama_hari); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>Jam Mengajar</label>
                                                    <select name="jam[]" id="select-jam_<?= $i; ?>" disabled class="form-control select2bs4">
                                                        <option value="" selected id="default-select-jam_<?= $i; ?>">-- Jam Mengajar --</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="btn btn-success button-add mr-auto ml-auto mt-2 mb-2">
                            <i class="fas fa-plus"></i> Tambah Prioritas Dosen
                        </div>
                    </div>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>

        <?php if ($algoritma_proses): ?>
            <?php for ($i = 0; $i < count($algoritma_proses); $i++): ?>
                <div class="container bg-light py-4">
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12">
                            <h1 class="text-center">GENERASI KE-<?= $i + 1; ?></h1>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12">
                            <p>PROSES 1 : INISIALISASI POPULASI</p>
                        </div>
                    </div>
                    <div class="row justify-content-center align-items-center">
                        <?php foreach ($algoritma_proses[$i]['individuWithDetail'] as $individu): ?>
                            <?php $individuIndex = $loop->index; ?>
                            <div class="col-md-6">
                                <table class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col" colspan="8">Individu <?= $loop->iteration; ?></th>
                                        </tr>
                                        <tr class="bg-success text-white">
                                            <th scope="col" class="verticalTableHeader" rowspan="2">Kromosom</th>
                                            <th scope="col" colspan="3">Gen 1</th>
                                            <th scope="col">Gen 2</th>
                                            <th scope="col" colspan="2">Gen 3</th>
                                            <th scope="col" rowspan="2" class="verticalTableHeader">Detail</th>
                                        </tr>
                                        <tr>
                                            <th scope="col">matkul</th>
                                            <th scope="col">Dosen</th>
                                            <th scope="col">Kelas</th>
                                            <th scope="col">Ruang</th>
                                            <th scope="col">Hari</th>
                                            <th scope="col">Jam</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($individu as $kromosom): ?>
                                            <tr>
                                                <th scope="row"><?= $loop->iteration; ?></th>
                                                <td><?= $kromosom['id_matkul']; ?></td>
                                                <td <?= $kromosom['id_dosen']['clash'] == 1 ? 'class="bg-danger text-white"' : ''; ?>>
                                                    <?= $kromosom['id_dosen']['id']; ?>
                                                </td>
                                                <td><?= $kromosom['id_kelas']; ?></td>
                                                <td <?= $kromosom['nama_ruang']['clash'] == 1 ? 'class="bg-danger text-white"' : ''; ?>>
                                                    <?= ucwords($kromosom['nama_ruang']['id']); ?>
                                                </td>
                                                <td><?= $kromosom['id_hari']; ?></td>
                                                <td><?= $kromosom['id_jam']; ?></td>
                                                <td>
                                                    <i class="fas fa-info-circle" data-toggle="modal" data-target="#detail-<?= $i; ?>-<?= $individuIndex; ?>-<?= $kromosom['id_kelas']; ?>"></i>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <p>Individu Dalam Bentuk ID.</p>
                            <?php for ($j = 0; $j < count($algoritma_proses[$i]["individu"]); $j++): ?>
                                <?php
                                $stringIndividu = "";
                                foreach ($algoritma_proses[$i]["individu"][$j] as $kromosom) {
                                    $stringIndividu .= '[' . $kromosom[0] . ',' . $kromosom[1] . ',' . $kromosom[2] . '],';
                                }
                                $stringIndividu = '{' . substr($stringIndividu, 0, -1) . '}';
                                ?>
                                <p><?= $j + 1; ?>. Individu[<?= $j + 1; ?>] = <?= $stringIndividu; ?>.</p>
                            <?php endfor; ?>
                        </div>
                    </div>
                    
                    <div class="row justify-content-center align-items-center">
                        <div class="col-md-12">
                            <p>PROSES 2 : MENGHITUNG FITNESS FUNCTION</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table>
                                <tr>
                                    <td rowspan="2">Fitness Function = </td>
                                    <td style="border-bottom: solid 1px #FDE8CD;" class="text-center">1</td>
                                </tr>
                                <tr>
                                    <td class="text-center">1 +(CD + CR)</td>
                                </tr>
                                <?php foreach ($algoritma_proses[$i]['fitness_individu'] as $fitness_individu): ?>
                                    <tr>
                                        <td rowspan="2">Fitness Individu <?= $loop->iteration; ?> : </td>
                                        <td style="border-bottom: solid 1px #FDE8CD;" class="text-center">1</td>
                                        <td rowspan="2"> = <?= round($fitness_individu, 2); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">1 + ( <?= $algoritma_proses[$i]['CD'][$loop->index]; ?> + <?= $algoritma_proses[$i]['CR'][$loop->index]; ?>)</td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <p>Total Nilai Fitness = <?= round($algoritma_proses[$i]['total_fitness'], 2); ?></p>
                        </div>
                    </div>

                    <?php if (array_key_exists("probabilitas", $algoritma_proses[$i])): ?>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-12">
                                <p>PROSES 3 : SELECTION (METODE ROULETTE WHEEL)</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>Probability = fitness[i] / total fitness</p>
                                <p>1. Hitung Probabilitas</p>
                                <div class="pl-2">
                                    <?php foreach ($algoritma_proses[$i]['fitness_individu'] as $individu): ?>
                                        <p><?= $loop->iteration; ?>. Probabilitas[<?= $loop->iteration; ?>] = <?= round($individu, 2); ?> / <?= round($algoritma_proses[$i]['total_fitness'], 2); ?> = <?= round($algoritma_proses[$i]['probabilitas'][$loop->index], 2); ?>.</p>
                                    <?php endforeach; ?>
                                </div>

                                <p>2. Hitung Kumulatif</p>
                                <div class="pl-2">
                                    <?php for ($j = 0; $j < count($algoritma_proses[$i]['kumulatif']); $j++): ?>
                                        <?php if ($j == 0): ?>
                                            <p><?= $j + 1; ?>. Kumulatif[<?= $j + 1; ?>] = <?= round($algoritma_proses[$i]['probabilitas'][$j], 2); ?>.</p>
                                        <?php else: ?>
                                            <p><?= $j + 1; ?>. Kumulatif[<?= $j + 1; ?>] = <?= round($algoritma_proses[$i]['kumulatif'][$j - 1], 2); ?> + <?= round($algoritma_proses[$i]['probabilitas'][$j], 2); ?> = <?= round($algoritma_proses[$i]['kumulatif'][$j], 2); ?>.</p>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>

                                <p>3. Menghasilkan Bilangan Acak 1-0</p>
                                <div class="pl-2">
                                    <?php for ($j = 0; $j < count($algoritma_proses[$i]["random1_selection"]); $j++): ?>
                                        <p><?= $j + 1; ?>. Random[<?= $j + 1; ?>] = <?= $algoritma_proses[$i]['random1_selection'][$j]; ?>.</p>
                                    <?php endfor; ?>
                                </div>

                                <p>4. Menggantikan Individu Lama berdasarkan nilai acak terhadap nilai kumulatif.</p>
                                <div class="pl-2">
                                    <?php for ($j = 0; $j < count($algoritma_proses[$i]["individu"]); $j++): ?>
                                        <p><?= $j + 1; ?>. Individu[<?= $j + 1; ?>] = Individu[<?= $algoritma_proses[$i]["list_new_individu_selection"][$j] + 1; ?>].</p>
                                    <?php endfor; ?>
                                </div>

                                <p>5. Hasil Seleksi Individu Baru.</p>
                                <?php for ($j = 0; $j < count($algoritma_proses[$i]["list_new_individu_selection"]); $j++): ?>
                                    <?php
                                    $stringNewIndividu = "";
                                    foreach ($algoritma_proses[$i]["individu"][$algoritma_proses[$i]["list_new_individu_selection"][$j]] as $kromosom) {
                                        $stringNewIndividu .= '[' . $kromosom[0] . ',' . $kromosom[1] . ',' . $kromosom[2] . '],';
                                    }
                                    $stringNewIndividu = '{' . substr($stringNewIndividu, 0, -1) . '}';
                                    ?>
                                    <p><?= $j + 1; ?>. Individu[<?= $j + 1; ?>] = <?= $stringNewIndividu; ?>.</p>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (array_key_exists("index_best_individu", $algoritma_proses[$i])): ?>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-12">
                                <p>PROSES 4 : CROSSOVER (METODE One Cut-Point CROSSOVER)</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <p>CrossOver Rate (PC) = <?= $algoritma_proses[$i]["PC"]; ?></p>
                                <p>1. Menghasilkan Bilangan Acak 1-0</p>
                                <div class="pl-2">
                                    <?php for ($j = 0; $j < count($algoritma_proses[$i]["random1_crossover"]); $j++): ?>
                                        <p><?= $j + 1; ?>. Random[<?= $j + 1; ?>] = <?= $algoritma_proses[$i]['random1_crossover'][$j]; ?>.</p>
                                    <?php endfor; ?>
                                </div>

                                <p>2. Individu Terpilih</p>
                                <div class="pl-2">
                                    <?php for ($j = 0; $j < count($algoritma_proses[$i]["index_best_individu"]); $j++): ?>
                                        <p><?= $j + 1; ?>. Individu[<?= $algoritma_proses[$i]["index_best_individu"][$j] + 1; ?>].</p>
                                    <?php endfor; ?>
                                </div>

                                <p>3. Individu dipasangkan dua-dua.</p>
                                <div class="pl-2">
                                    <?php for ($j = 0; $j < count($algoritma_proses[$i]["parents"]); $j++): ?>
                                        <p><?= $j + 1; ?>. Individu[<?= $algoritma_proses[$i]["parents"][$j]['father'] + 1; ?>] >< Individu[<?= $algoritma_proses[$i]["parents"][$j]['mother'] + 1; ?>].</p>
                                    <?php endfor; ?>
                                </div>

                                <p>4. Menentukan posisi one cut point secara acak.</p>
                                <div class="pl-2">
                                    <?php for ($j = 0; $j < count($algoritma_proses[$i]["parents"]); $j++): ?>
                                        <p><?= $j + 1; ?>. Individu[<?= $algoritma_proses[$i]["parents"][$j]['father'] + 1; ?>] >< Individu[<?= $algoritma_proses[$i]["parents"][$j]['mother'] + 1; ?>] <span class="text-maroon">(Crossover[<?= $j + 1; ?>])</span> = <?= $algoritma_proses[$i]["parents"][$j]['cut-point']; ?>.</p>
                                    <?php endfor; ?>
                                </div>

                                <?php for ($j = 0; $j < count($algoritma_proses[$i]["parents"]); $j++): ?>
                                    <?php
                                    $stringFatherIndividu = "";
                                    $stringMotherIndividu = "";
                                    $stringOffSpringIndividu = "";

                                    foreach ($algoritma_proses[$i]["new_individu_selection"][$algoritma_proses[$i]["parents"][$j]['father']] as $kromosom) {
                                        $stringFatherIndividu .= '[' . $kromosom[0] . ',' . $kromosom[1] . ',' . $kromosom[2] . '],';
                                    }
                                    foreach ($algoritma_proses[$i]["new_individu_selection"][$algoritma_proses[$i]["parents"][$j]['mother']] as $kromosom) {
                                        $stringMotherIndividu .= '[' . $kromosom[0] . ',' .$kromosom[1] . ',' . $kromosom[2] . '],';
                                    }
                                    foreach ($algoritma_proses[$i]["offSpring"][$j] as $kromosom) {
                                        $stringOffSpringIndividu .= '[' . $kromosom[0] . ',' . $kromosom[1] . ',' . $kromosom[2] . '],';
                                    }

                                    $stringFatherIndividu = '{' . substr($stringFatherIndividu, 0, -1) . '}';
                                    $stringMotherIndividu = '{' . substr($stringMotherIndividu, 0, -1) . '}';
                                    $stringOffSpringIndividu = '{' . substr($stringOffSpringIndividu, 0, -1) . '}';
                                    ?>
                                    <p>Proses Crossover ke-<?= $j + 1; ?>.</p>
                                    Individu[<?= $algoritma_proses[$i]["parents"][$j]['father'] + 1; ?>] = <?= $stringFatherIndividu; ?><br>
                                    Individu[<?= $algoritma_proses[$i]["parents"][$j]['mother'] + 1; ?>] = <?= $stringMotherIndividu; ?><br>
                                    Offspring <?= $j + 1; ?> = <?= $stringOffSpringIndividu; ?><br><br>
                                <?php endfor; ?>

                                <p>Individu Baru Hasil Crossover.</p>
                                <?php for ($j = 0; $j < count($algoritma_proses[$i]["new_individu_crossover"]); $j++): ?>
                                    <?php
                                    $stringNewIndividu = "";
                                    foreach ($algoritma_proses[$i]["new_individu_crossover"][$j] as $kromosom) {
                                        $stringNewIndividu .= '[' . $kromosom[0] . ',' . $kromosom[1] . ',' . $kromosom[2] . '],';
                                    }
                                    $stringNewIndividu = '{' . substr($stringNewIndividu, 0, -1) . '}';
                                    ?>
                                    <p><?= $j + 1; ?>. Individu[<?= $j + 1; ?>] = <?= $stringNewIndividu; ?>.</p>
                                <?php endfor; ?>
                                    
                                <p>Hitung Fitness Function Individu Baru.</p>
                                <table>
                                    <tr>
                                        <td rowspan="2">Fitness Function = </td>
                                        <td style="border-bottom: solid 1px #FDE8CD;" class="text-center">1</td>
                                    </tr>
                                    <tr>
                                        <td class="text-center">1 + ( CD + CR )</td>
                                    </tr>
                                    <?php foreach ($algoritma_proses[$i]['new_fitness_individu'] as $fitness_individu): ?>
                                        <tr>
                                            <td rowspan="2">Fitness Individu <?= $loop->iteration; ?> : </td>
                                            <td style="border-bottom: solid 1px #FDE8CD;" class="text-center">1</td>
                                            <td rowspan="2"> = <?= round($fitness_individu, 2); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">1 + ( <?= $algoritma_proses[$i]['new_CD'][$loop->index]; ?> + <?= $algoritma_proses[$i]['new_CR'][$loop->index]; ?>)</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                                <p>Total Nilai Fitness = <?= round($algoritma_proses[$i]['new_total_fitness'], 2); ?></p>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (array_key_exists("all_clash_chromosome", $algoritma_proses[$i])): ?>
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-12">
                                <p>PROSES 5 : MUTASI</p>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                    $stringClashChromosom = "";
                                    $stringMutatedChromosom = "";

                                    foreach ($algoritma_proses[$i]["all_clash_chromosome"] as $kromosom) {
                                        $stringClashChromosom .= '[' . $kromosom['kromosom'][0] . ',' . $kromosom['kromosom'][1] . ',' . $kromosom['kromosom'][2] . '],';
                                    }

                                    foreach ($algoritma_proses[$i]["mutated_chromosome"] as $kromosom) {
                                        $stringMutatedChromosom .= '[' . $kromosom[0] . ',' . $kromosom[1] . ',' . $kromosom[2] . '],';
                                    }

                                    $stringClashChromosom = '{' . substr($stringClashChromosom, 0, -1) . '}';
                                    $stringMutatedChromosom = '{' . substr($stringMutatedChromosom, 0, -1) . '}';
                                ?>

                                <p>Total Kromosom Bentrok: <?= count($algoritma_proses[$i]["all_clash_chromosome"]); ?></p>
                                <p>Kromosom Bentrok: <?= $stringClashChromosom; ?></p>
                                <p>Mutasi Kromosom Bentrok: <?= $stringMutatedChromosom; ?></p>
                                <p>Individu Baru Hasil Mutasi.</p>

                                <?php for ($j = 0; $j < count($algoritma_proses[$i]["new_individu_crossover"]); $j++): ?>
                                    <?php
                                        $stringNewIndividu = "";
                                        foreach ($algoritma_proses[$i]["new_individu_has_mutated"][$j] as $kromosom) {
                                            $stringNewIndividu .= '[' . $kromosom[0] . ',' . $kromosom[1] . ',' . $kromosom[2] . '],';
                                        }

                                        $stringNewIndividu = '{' . substr($stringNewIndividu, 0, -1) . '}';
                                    ?>
                                    <p><?= $j + 1; ?>. Individu[<?= $j + 1; ?>] = <?= $stringNewIndividu; ?>.</p>
                                <?php endfor; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endfor; ?>
        <?php endif; ?>

        <?php if (isset($fixJadwal)): ?>
            <?php if (count($fixJadwal) > 0): ?>
                <?= session()->set('jadwal', $fixJadwal); ?>
                <?= session()->set('idSemester', $idSemester); ?>
                <?= session()->set('TahunAkademik', $TahunAkademik); ?>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="container">
                            <h2 class="text-center bg-light">Jadwal Ditemukan</h2>
                            <p class="h4 text-center bg-light mb-2">Waktu Eksekusi: <?= number_format((float)$execution_time, 2, '.', ''); ?> Detik</p>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="container">
                                        <?php foreach ($fixJadwal as $individu): ?>
                                            <table class="table table-bordered table-hover text-center">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" colspan="7">Jadwal <?= $loop->iteration; ?></th>
                                                    </tr>
                                                    <tr class="bg-success text-white">
                                                        <th scope="col" rowspan="2" style="max-width: 80px; font-size: 18px;">Kromosom ke -</th>
                                                        <th scope="col" colspan="3">Gen 1</th>
                                                        <th scope="col">Gen 2</th>
                                                        <th scope="col" colspan="2">Gen 3</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">matkul</th>
                                                        <th scope="col">Dosen</th>
                                                        <th scope="col">Kelas</th>
                                                        <th scope="col">Ruang</th>
                                                        <th scope="col">Hari</th>
                                                        <th scope="col">Jam</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($individu as $kromosom): ?>
                                                        <tr>
                                                            <th scope="row"><?= $loop->iteration; ?></th>
                                                            <td><?= $kromosom['id_matkul']; ?></td>
                                                            <td><?= $kromosom['id_dosen']['id']->first()->nidn; ?></td>
                                                            <td><?= $kromosom['id_kelas']; ?></td>
                                                            <td><?= ucwords($kromosom['nama_ruang']['id']); ?></td>
                                                            <td><?= $kromosom['id_hari']; ?></td>
                                                            <td><?= $kromosom['id_jam']; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    <tr>
                                                        <th scope="col" colspan="7">
                                                            <a href="/pengampu/delete/<?= $loop->index; ?>" 
                                                               class="btn bg-danger text-center" 
                                                               onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                                <i class="fas fa-table mr-1"></i> Gunakan Jadwal
                                                            </a>
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>      
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($fixJadwal) == 0): ?>
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="container">
                            <h2 class="text-center bg-light">Jadwal Tidak Ditemukan</h2>
                            <p class="h4 text-center bg-light">Waktu Eksekusi: <?= number_format((float)$execution_time, 2, '.', ''); ?> Detik</p>
                            <a href="#"><p class="h4 text-center bg-danger mb-2" style="cursor: pointer">Silahkan Generate Kembali</p></a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Modal for Algoritma Genetika -->
        <div class="modal fade" id="algoritmagenetikaDetail" tabindex="-1" aria-labelledby="algoritmagenetikaDetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="algoritmagenetikaDetailLabel">Algoritma Genetika</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="/img/ga.png" class="img-fluid mb-3" alt="Algoritma Genetika">
                        <h2>Apa Itu Algoritma Genetika?</h2>
                        <p>Algoritma Genetika merupakan teknik untuk menemukan solusi optimal dari permasalahan yang mempunyai banyak solusi. Teknik ini akan melakukan pencarian dari beberapa solusi yang diperoleh sampai mendapatkan solusi terbaik sesuai dengan kriteria yang telah ditentukan atau yang disebut sebagai fungsi fitness.</p>
                        <p>Algoritma ini masuk dalam kelompok algoritma evolusioner dengan menggunakan pendekatan evolusi Darwin di bidang Biologi seperti pewarisan sifat, seleksi alam, mutasi gen dan kombinasi (crossover). Karena merupakan teknik pencarian optimal dalam bidang ilmu komputer, maka algoritma ini juga termasuk dalam kelompok algoritma metaheuristik.</p>
                        <img src="/img/genetika-1.png" class="img-fluid mb-3" alt="Algoritma Genetika">
                        <p>Ada beberapa istilah pada Algoritma Genetika seperti populasi, individu, kromosom, gen dan allelle.</p>
                        <ul>
                            <li>Gen : Sebuah nilai yang menyatakan satuan dasar yang membentuk suatu arti tertentu dalam satu kesatuan gen yang dinamakan kromosom.</li>
                            <li>Allelle : Nilai dari gen.</li>
                            <li>Kromosom : Gabungan gen-gen yang membentuk nilai tertentu.</li>
                            <li>Individu : Menyatakan satu nilai atau keadaan yang menyatakan salah satu solusi yang mungkin dari permasalahan yang diangkat.</li>
                            <li>Populasi : Merupakan sekumpulan individu yang akan diproses bersama dalam satu siklus proses evolusi.</li>
                            <li>Generasi : Menyatakan satu siklus proses evolusi atau satu iterasi di dalam algoritma genetika.</li>
                        </ul>

                        <img src="/img/genetika-2.png" class="img-fluid mb-3" alt="Algoritma Genetika">
                        <p>Bagaimana teori genetika diterapkan pada penjadwalan perkuliahan? Gen-gen tadi merepresentasikan penjadwalan kuliah dengan sub-gen mata kuliah, dosen, dan kelas, ruang, dan waktu dengan sub-gen hari dan jam.</p>
                        <p>Yang menjadi perhatian di sini adalah sub-gen dari kuliah yaitu <strong>Dosen</strong> dan gen <strong>Ruang</strong>, di mana algoritma genetika akan mengatur sedemikian rupa agar tidak terjadi bentrok antara kedua gen tersebut; yaitu, Dosen dan Ruang tidak dapat digunakan oleh kelas lain pada waktu yang bersamaan, maupun SKS dari mata kuliah yang belum selesai.</p>

<img src="/img/fase-genetika.png" class="img-fluid mb-3" alt="Algoritma Genetika">
<p>Terdapat 5 fase dari Algoritma Genetika:</p>
<ul>
    <li><strong>Inisialisasi Populasi:</strong> Input populasi awal/jadwal-jadwal yang kemungkinan masih terdapat bentrok.</li>
    <li><strong>Fitness Function:</strong> Digunakan untuk mengevaluasi apakah jadwal sudah tepat (tidak ada/masih ada yang bentrok). Jika ada, lanjut ke proses selection.</li>
    <li><strong>Selection:</strong> Untuk mencari individu-individu terbaik berdasarkan fitness value, setelah dapat individu, lanjut ke proses crossover.</li>
    <li><strong>Crossover:</strong> Persilangan masing-masing individu terbaik, individu tersebut disebut parent, dan hasil persilangan disebut child. Child ini akan menggantikan parent jika individu ini (jadwal) belum tepat (masih ada yang bentrok), lanjut ke proses mutasi.</li>
    <li><strong>Mutasi:</strong> Dilakukan pergantian gen (ruang atau waktu) sehingga rangkaian kromosom pada individu berbeda dari sebelumnya, untuk berharap mendapatkan individu (jadwal) yang tepat. Child mutated (individu yang sudah dimutasi) dikembalikan ke populasi dan dilakukan proses dari awal lagi jika belum didapatkan individu (jadwal) yang pas.</li>
</ul>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-success" data-dismiss="modal">Oke Paham<i class="fas fa-thumbs-up ml-1"></i></button>
</div>
</div>
</div>
</div>

<!-- Modal for Individu -->
<div class="modal fade" id="individuDetail" tabindex="-1" aria-labelledby="individuDetailLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable">
<div class="modal-content">
<div class="modal-header bg-success text-white">
<h5 class="modal-title" id="individuDetailLabel">Individu</h5>
<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<img src="/img/individu.png" class="img-fluid mb-3" alt="Individu">
<h2>Apa Itu Individu?</h2>
<p>Di dalam Algoritma Genetika, <strong>Individu</strong> menyatakan satu solusi dari permasalahan yang diangkat. Singkatnya, individu adalah jadwal dari perkuliahan.</p>
<p>Dalam prosesnya, dibutuhkan beberapa individu yang perlu dibangkitkan, yang akan diproses untuk mendapatkan jadwal perkuliahan tanpa adanya bentrok.</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-success" data-dismiss="modal">Oke Paham<i class="fas fa-thumbs-up ml-1"></i></button>
</div>
</div>
</div>
</div>

<!-- Modal for Generasi -->
<div class="modal fade" id="generasiDetail" tabindex="-1" aria-labelledby="generasiDetailLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-scrollable">
<div class="modal-content">
<div class="modal-header bg-success text-white">
<h5 class="modal-title" id="generasiDetailLabel">Generasi</h5>
<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
<img src="/img/fase-genetika.png" class="img-fluid mb-3" alt="Generasi">
<h2>Apa Itu Generasi?</h2>
<p>Di dalam Algoritma Genetika, <strong>Generasi</strong> menyatakan satu siklus proses evolusi atau satu iterasi di dalam algoritma genetika. Singkatnya, generasi adalah satu kali proses dan biasanya diperlukan beberapa generasi untuk mendapatkan individu (jadwal) yang bagus (tidak terdapat bentrok).</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Oke Paham<i class="fas fa-thumbs-up ml-1"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Cross Over Rate -->
        <div class="modal fade" id="crossOverDetail" tabindex="-1" aria-labelledby="crossOverDetailLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title" id="crossOverDetailLabel">Cross Over Rate</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <img src="/img/crossover.png" class="img-fluid mb-3" alt="Crossover">
                        <h2>Apa Itu Cross Over Rate?</h2>
                        <p><strong>Cross Over (pindah silang)</strong> adalah proses pemilihan posisi string secara acak dan menukar karakter-karakter stringnya (Goldberg, 1989). Fungsi crossover adalah untuk menghasilkan kromosom anak dari kombinasi materi gen dua kromosom induk.</p> 
                        <p>Singkatnya, crossover adalah pertukaran kromosom antara dua individu. Cross Over Rate / Probabilitas Crossover (PC) ditentukan untuk mengendalikan frekuensi crossover; semakin besar nilai crossover rate, semakin besar kemungkinan banyaknya crossover yang dibangkitkan.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Oke Paham<i class="fas fa-thumbs-up ml-1"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <?php for ($i = 0; $i < count($algoritma_proses); $i++): ?>
            <?php foreach ($algoritma_proses[$i]['individuWithDetail_with_name'] as $individu): ?>
                <?php $individuIndex = $loop->index; ?>
                <?php foreach ($individu as $kromosom): ?>
                    <div class="modal fade" id="detail-<?= $i; ?>-<?= $individuIndex; ?>-<?= $kromosom['id_kelas']; ?>" tabindex="-1" aria-labelledby="detailJadwalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="detailJadwalLabel"><i class="fas fa-info-circle mr-2"></i>Detail Individu ke-<?= $individuIndex + 1; ?>, kromosom ke-<?= $loop->iteration; ?></h5>
                                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="sks">Jumlah SKS</label>
                                        <input name="sks" type="text" disabled class="form-control" id="sks" value="<?= $kromosom['jumlah_sks']; ?>">
                                    </div>
                                    <p class="text-center h4 text-maroon">- GEN 1 -</p>
                                    <div class="mb-3">
                                        <label for="matkul">Mata Kuliah</label>
                                        <input name="matkul" type="text" disabled class="form-control" id="matkul" value="<?= ucwords($kromosom['matkul']); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="dosen">Dosen Pengajar</label>
                                        <input name="dosen" type="text" disabled class="form-control" id="dosen" value="<?= ucwords($kromosom['dosen']); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="kelas">Kelas</label>
                                        <input name="kelas" type="text" disabled class="form-control" id="kelas" value="<?= $kromosom['kelas']; ?>">
                                    </div>
                                    <p class="text-center h4 text-maroon">- GEN 2 -</p>
                                    <div class="mb-3">
                                        <label for="ruang">Ruangan</label>
                                        <input name="ruang" type="text" disabled class="form-control" id="ruang" value="<?= ucwords($kromosom['nama_ruang']); ?>">
                                    </div>
                                    <p class="text-center h4 text-maroon">- GEN 3 -</p>
                                    <div class="mb-3">
                                        <label for="hari">Hari</label>
                                        <input name="hari" type="text" disabled class="form-control" id="hari" value="<?= ucwords($kromosom['hari']); ?>">
                                    </div>
                                    <div class="mb-3">
                                        <label for="jam">Jam</label>
                                        <input name="jam" type="text" disabled class="form-control" id="jam" value="<?= $kromosom['jam']; ?>">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-success" data-dismiss="modal">Kembali</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endfor; ?>
    </main>
</div>

<?= $this->endSection(); ?>