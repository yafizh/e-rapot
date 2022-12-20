<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Dashboard</h1>

        <div class="row justify-content-center">
            <div class="col-md-12 col-xl-9">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-4">
                            <?php $guru = $mysqli->query("SELECT * FROM guru"); ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Guru</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="truck"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3"><?= $guru->num_rows; ?> Guru</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <?php $siswa_aktif = $mysqli->query("SELECT * FROM siswa WHERE status='Aktif'"); ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Siswa Aktif</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="shopping-cart"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3"><?= $siswa_aktif->num_rows; ?> Siswa</h1>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <?php $siswa_lulus = $mysqli->query("SELECT * FROM siswa WHERE status='Alumni'"); ?>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Siswa Lulus</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="shopping-cart"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3"><?= $siswa_lulus->num_rows; ?> Siswa</h1>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php
        $q = "
            SELECT 
                k.*,
                (SELECT COUNT(*) FROM kelas_aktif WHERE id_kelas=k.id AND status='Aktif') jumlah
            FROM 
                kelas k
        ";
        $result = $mysqli->query($q);
        $kelas_aktif = $result->fetch_all(MYSQLI_ASSOC);
        ?>

        <div class="row justify-content-evenly">
            <div class="col-12 col-md-6 col-xxl-3 d-flex order-2 order-xxl-3">
                <div class="card flex-fill w-100">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Siswa Aktif</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="align-self-center w-100">
                            <div class="py-3">
                                <div class="chart chart-xs">
                                    <canvas id="chartjs-dashboard-pie"></canvas>
                                </div>
                            </div>

                            <table class="table mb-0">
                                <tbody>
                                    <?php foreach ($kelas_aktif as $value) : ?>
                                        <tr>
                                            <td>Kelas <?= $value['nama']; ?></td>
                                            <td class="text-end"><?= $value['jumlah']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xxl-3 d-flex order-1 order-xxl-1">
                <div class="card flex-fill">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Kalender</h5>
                    </div>
                    <div class="card-body d-flex">
                        <div class="align-self-center w-100">
                            <div class="chart">
                                <div id="datetimepicker-dashboard"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
$labels = [];
$data = [];
foreach ($kelas_aktif as $value) {
    $labels[] = 'Kelas ' . $value['nama'];
    $data[] = (int)$value['jumlah'];
}
?>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Pie chart
        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: JSON.parse('<?= json_encode($labels); ?>'),
                datasets: [{
                    data: JSON.parse('<?= json_encode($data); ?>'),
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger,
                        "#E8EAED"
                    ],
                    borderWidth: 5,
                    borderColor: window.theme.white
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                cutoutPercentage: 70
            }
        });
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var date = new Date();
        var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
        document.getElementById("datetimepicker-dashboard").flatpickr({
            inline: true,
            prevArrow: "<span class=\"fas fa-chevron-left\" title=\"Previous month\"></span>",
            nextArrow: "<span class=\"fas fa-chevron-right\" title=\"Next month\"></span>",
            defaultDate: defaultDate
        });
    });
</script>