<?php if ($this->ion_auth->is_admin()) : ?>

    <div class="box">
        <div class="box-body">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h3 class="box-title">Inputkan Cluster</h3>
                </div>
                <form action="<?php echo base_url() . '/perhitungan' ?>">
                    <div class="form-group col-sm-12" align="center">
                        <label for="clustering" class="control-label">Jumlah Cluster</label>
                        <input required="required" value="<?php echo $this->input->get('clustering') ?>" type="number" name="clustering" placeholder="Masukkan Jumlah Cluster Yang Diinginkan" id="clustering" class="form-control" onKeyPress="if(this.value.length==<?php echo count($dataConditions) ?>) return false;">
                    </div>
                    <div class="form-group" align="center">
                        <button type="submit" id="submit" class="btn btn-flat bg-purple"><i class="fa fa-calculator"></i> Hitung</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php if ($clustering) :   ?>
        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php foreach ($mahasiswaCluster as $keyMahasiswaCluster => $valMahasiswaCluster) : ?>
                            <?= $keyMahasiswaCluster % 2 == 1 ? "<div class='row'>" : ''; ?>
                            <div class="col-md-6">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Cluster <?= $keyMahasiswaCluster ?></h3>
                                </div>
                                <div class="table-responsive mt-2 mb-3">
                                    <table class="table table-striped table-bordered table-hover datatables">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">No.</th>
                                                <th style="text-align: center;">NIM</th>
                                                <th style="text-align: center;">Nama</th>
                                                <th style="text-align: center;">Kluster</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php ?>
                                            <?php foreach ($valMahasiswaCluster as $key => $value) : ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $key + 1; ?></td>
                                                    <td style="text-align: center;">
                                                        <?= $value['nim'] ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?= $value['nama'] ?>
                                                    </td>
                                                    <td style="text-align: center;">
                                                        <?= $keyMahasiswaCluster ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <?= $keyMahasiswaCluster % 2 == 0 ? "</div>" : ''; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-md-12">
                        <div class="box-header with-border">
                            <h3 class="box-title">Grafik</h3>
                        </div>
                        <div class="mt-2 mb-3">
                            <canvas id="myChart" style="width:100%;height:300px;"></canvas>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="box-header with-border">
                            <button class='btn btn-info col-md-12' id="btn-lihat-hitung">Lihat Perhitungan</button>
                        </div>
                    </div>

                    <div class="col-md-6 perhitunganCluster" hidden>
                        <div class="box-header with-border">
                            <h3 class="box-title">Perhitungan Cluster Lama</h3>
                            <p>Iterasi : <?= $perhitungan['iterasi'] - 1 ?></p>
                            <div class="table-responsive mt-2 mb-3">
                                <?php
                                $centeroid1 = $perhitungan['medoids'][0]['random'];
                                $cluster1 = $perhitungan['medoids'][0]['jarak'];
                                ?>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr align='center'>
                                            <th colspan=2>Centeroid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($centeroid1 as $cVal) : ?>
                                            <tr align='center'>
                                                <td><?= $jumlahLangkah[$cVal]; ?></td>
                                                <td><?= $jumlahWaktu[$cVal]; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <table id="cluster1" class="table table-striped table-bordered table-hover datatables">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">NIM</th>
                                            <th style="text-align: center;">id_user</th>
                                            <?php for ($i = 0; $i < $clustering; $i++) : ?>
                                                <th style="text-align: center;">Cost <?= $i + 1; ?></th>
                                            <?php endfor; ?>
                                            <th style="text-align: center;">Kedekatan</th>
                                            <th style="text-align: center;">Kluster</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($dataConditions as $key => $value) : ?>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <?= $value['nim'] ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?= $value['id_user'] ?>
                                                </td>
                                                <?php $dataCluster = $cluster1[$value['id_user']]; ?>
                                                <?php for ($i = 0; $i < $clustering; $i++) : ?>
                                                    <th style="text-align: center;"><?= $dataCluster[$i]; ?></th>
                                                <?php endfor; ?>
                                                <th style="text-align: center;"><?= $dataCluster[$dataCluster['cluster'] - 1]; ?></th>
                                                <th style="text-align: center;"><?= $dataCluster['cluster']; ?></th>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 perhitunganCluster" hidden>
                        <div class="box-header with-border">
                            <h3 class="box-title">Perhitungan Cluster Baru</h3>
                            <p>Iterasi : <?= $perhitungan['iterasi']  ?></p>
                            <div class="table-responsive mt-2 mb-3">
                                <?php
                                $centeroid2 = $perhitungan['medoids'][1]['random'];
                                $cluster2 = $perhitungan['medoids'][1]['jarak'];
                                ?>
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr align='center'>
                                            <th colspan=2>Centeroid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($centeroid2 as $cVal) : ?>
                                            <tr align='center'>
                                                <td><?= $jumlahLangkah[$cVal]; ?></td>
                                                <td><?= $jumlahWaktu[$cVal]; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <table id="cluster1" class="table table-striped table-bordered table-hover datatables">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">NIM</th>
                                            <th style="text-align: center;">id_user</th>
                                            <?php for ($i = 0; $i < $clustering; $i++) : ?>
                                                <th style="text-align: center;">Cost <?= $i + 1; ?></th>
                                            <?php endfor; ?>
                                            <th style="text-align: center;">Kedekatan</th>
                                            <th style="text-align: center;">Kluster</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($dataConditions as $key => $value) : ?>
                                            <tr>
                                                <td style="text-align: center;">
                                                    <?= $value['nim'] ?>
                                                </td>
                                                <td style="text-align: center;">
                                                    <?= $value['id_user'] ?>
                                                </td>
                                                <?php $dataCluster = $cluster2[$value['id_user']]; ?>
                                                <?php for ($i = 0; $i < $clustering; $i++) : ?>
                                                    <th style="text-align: center;"><?= $dataCluster[$i]; ?></th>
                                                <?php endfor; ?>
                                                <th style="text-align: center;"><?= $dataCluster[$dataCluster['cluster'] - 1]; ?></th>
                                                <th style="text-align: center;"><?= $dataCluster['cluster']; ?></th>

                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="box-header with-border">
                            <button class='btn btn-info col-md-12' id="btn-lihat-nilai">Lihat Test Nilai</button>
                        </div>
                    </div>

                    <div class="col-md-12 nilai" hidden>
                        <div class="box-header with-border">
                            <h3 class="box-title">Data Nilai</h3>

                            <table class="table table-striped table-bordered table-hover datatables">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No.</th>
                                        <th style="text-align: center;">NIM</th>
                                        <th style="text-align: center;">Nama</th>
                                        <th style="text-align: center;">Jumlah Langkah</th>
                                        <th style="text-align: center;">Jumlah Waktu</th>
                                        <th style="text-align: center;">Post Test</th>
                                        <th style="text-align: center;">Pre Test</th>
                                        <th style="text-align: center;">Cluster</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($dataConditions) : ?>
                                        <?php foreach ($dataConditions as $key => $value) : ?>
                                            <tr>
                                                <td style="text-align: center;"><?= $key + 1; ?></td>
                                                <td style="text-align: center;"><?= $value['nim']; ?></td>
                                                <td style="text-align: center;"><?= $value['nama']; ?></td>
                                                <td style="text-align: center;"><?= $value['jumlah_langkah']; ?></td>
                                                <td style="text-align: center;"><?= $value['jumlah_waktu']; ?></td>
                                                <td style="text-align: center;"><?= $value['post_test'] ?></td>
                                                <td style="text-align: center;"><?= $value['pre_test'] ?></td>
                                                <td style="text-align: center;"><?= $perhitungan['arrCluster'][$value['id_user']]; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
<script>
    $(document).ready(function() {
        $('.datatables').DataTable();
    });
    $("#btn-lihat-hitung").click(function() {
        $(".perhitunganCluster").toggle();
    });
    $("#btn-lihat-nilai").click(function() {
        $(".nilai").toggle();
    });
</script>
<script>
    <?php
    $groupCluster = array_count_values($perhitungan['arrCluster']);
    $xValues = "";
    $yValues = "";
    foreach ($groupCluster as $key => $value) {
        $persentase = ($value / count($perhitungan['arrCluster'])) * 100;
        $xValues .= "'Cluster $key ( $persentase% )',";
        $yValues .= $value . ",";
    }
    $xValues = rtrim($xValues, ",");
    $yValues = rtrim($yValues, ",");

    ?>
    var xValues = [<?= $xValues ?>];
    var yValues = [<?= $yValues ?>];
    var barColors = ["red", "green", "blue", "orange", "brown"];

    new Chart("myChart", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues,
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    display: true,
                    ticks: {
                        beginAtZero: true,
                        max: 20,
                        min: 0
                    }
                }]
            },
            legend: {
                display: false
            },
            title: {
                display: true,
                text: "Jumlah Mahasiswa per Cluster"
            }
        }
    });
</script>