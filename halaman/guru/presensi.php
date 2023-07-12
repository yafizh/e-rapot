<?php
if (isset($_POST['masuk'])) {
    $q = "
        DELETE FROM 
            presensi_guru 
        WHERE 
            id_guru=" . $_SESSION['user']['id_guru'] . " 
            AND 
            tanggal='" . Date("Y-m-d") . "' 
        ";
    $mysqli->query($q);
    $q = "
        INSERT INTO presensi_guru (
            id_guru,
            tanggal,
            masuk 
        ) VALUES (
            " . $_SESSION['user']['id_guru'] . ",
            '" . Date("Y-m-d") . "',
            '" . Date("H:i:s") . "' 
        ) 
    ";
    $mysqli->query($q);
    echo "<script>alert('Berhasil mengisi presensi masuk hari ini');</script>";
}

if (isset($_POST['keluar'])) {
    $q = "
        UPDATE presensi_guru SET 
            keluar='" . Date("H:i:s") . "' 
        WHERE 
            id_guru=" . $_SESSION['user']['id_guru'] . " 
            AND 
            tanggal='" . Date("Y-m-d") . "' 
    ";
    $mysqli->query($q);
    echo "<script>alert('Berhasil mengisi presensi pulang hari ini');</script>";
}
?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Presensi</h1>
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card">
                    <div class="card-body">
                        <div id="map" class="mb-3" style="height: 300px;"></div>
                        <h4 class="text-center"><?= indoensiaDateWithDay(Date("Y-m-d")); ?></h4>
                        <div class="d-flex justify-content-center py-3">
                            <form action="" method="POST">
                                <?php if (Date("H") < 13) : ?>
                                    <button type="submit" name="masuk" class="btn btn-primary">Presensi Masuk</button>
                                <?php else : ?>
                                    <button type="submit" name="keluar" class="btn btn-primary">Presensi Pulang</button>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                navigator.geolocation.getCurrentPosition((position) => {
                    var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 50);
                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(map);
                    var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
                    var circle = L.circle([position.coords.latitude, position.coords.longitude], {
                        color: 'red',
                        fillColor: '#f03',
                        fillOpacity: 0.5,
                        radius: 20
                    }).addTo(map);
                });
            </script>
            <div class="col-12 col-md">
                <?php include_once('templates/navigator_guru.php'); ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table datatables-reponsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center td-fit">No</th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Jam Masuk</th>
                                            <th class="text-center">Jam Keluar</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $q = "
                                        SELECT 
                                            *,
                                            HOUR(masuk) jam_masuk, 
                                            MINUTE(masuk) menit_masuk, 
                                            HOUR(keluar) jam_keluar, 
                                            MINUTE(keluar) menit_keluar
                                        FROM 
                                            presensi_guru 
                                        WHERE 
                                            id_guru=" . $_SESSION['user']['id_guru'] . "
                                    ";

                                    $kelas_siswa = $mysqli->query($q);
                                    $no = 1;
                                    ?>
                                    <tbody>
                                        <?php while ($row = $kelas_siswa->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center td-fit"><?= $no++; ?></td>
                                                <td class="text-center"><?= indoensiaDateWithDay($row['tanggal']); ?></td>
                                                <td class="text-center"><?= $row['jam_masuk']; ?>:<?= $row['menit_masuk']; ?></td>
                                                <td class="text-center">
                                                    <?php if (is_null($row['keluar'])) : ?>
                                                        Belum Mengisi Presensi
                                                    <?php else : ?>
                                                        <?= $row['jam_keluar']; ?>:<?= $row['menit_keluar']; ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>