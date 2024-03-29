<?php

if (isset($_POST['absen'])) {
    $id_pmpk = $_POST['id_pmpk'];
    $q = "
        INSERT INTO presensi_siswa (
            id_siswa, 
            id_presensi_mata_pelajaran_kelas
        ) VALUES (
            " . $_SESSION['user']['id_siswa'] . ", 
            " . $id_pmpk . "
        )";
    if ($mysqli->query($q)) {
        echo "<script>alert('Berhasil mengisi presensi')</script>";
    }
}

?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Presensi</h1>
        <div class="row">
            <div class="col-12 col-md-5">
                <?php
                $q = "
                    SELECT
                        pmpk.id,
                        pmpk.tanggal,
                        (
                            SELECT 
                                ps.id 
                            FROM 
                                presensi_siswa ps 
                            WHERE 
                                ps.id_siswa=" . $_SESSION['user']['id_siswa'] . "  
                                AND 
                                ps.id_presensi_mata_pelajaran_kelas=pmpk.id 
                        ) status  
                    FROM 
                        presensi_mata_pelajaran_kelas pmpk 
                    WHERE 
                        pmpk.id_mata_pelajaran_kelas=" . $_GET['id'] . " 
                    ORDER BY    
                        pmpk.tanggal DESC 
                ";
                $result = $mysqli->query($q);
                ?>
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-center mb-3">Lokasi Sekarang</h3>
                        <div id="map" style="height: 300px;"></div>
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
                <div class="card">
                    <div class="card-header">
                        <h4>Presensi</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <?php
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= indoensiaDateWithDay($row['tanggal']); ?></td>
                                        <td class="text-center">
                                            <?php if (is_null($row['status'])) : ?>
                                                <form action="" method="POST">
                                                    <input type="text" name="id_pmpk" value="<?= $row['id']; ?>" hidden>
                                                    <button type="submit" name="absen" class="btn btn-sm btn-primary">Isi Presensi</button>
                                                </form>
                                            <?php else : ?>
                                                <span class="badge rounded-pill text-bg-success">Hadir</span>
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
</main>