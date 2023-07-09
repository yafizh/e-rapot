<?php

if (isset($_POST['absen'])) {
    $q = "
        INSERT INTO presensi_siswa (
            id_siswa, 
            id_presensi_mata_pelajaran_kelas
        ) VALUES (
            " . $_SESSION['user']['id_siswa'] . ", 
            " . $_GET['id'] . "
        )";
    if ($mysqli->query($q)) {
        echo "<script>alert('Berhasil mengisi presensi')</script>";
    }
}

?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Presensi dan Forum Diskusi</h1>
        <div class="row">
            <div class="col-12 col-md-5">
                <?php
                $q = "
                    SELECT
                        pmpk.tanggal,
                        (
                            SELECT 
                                ps.id 
                            FROM 
                                presensi_siswa ps 
                            WHERE 
                                ps.id_siswa=" . $_SESSION['user']['id_siswa'] . "  
                                AND 
                                ps.id_presensi_mata_pelajaran_kelas=" . $_GET['id'] . " 
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
                        <hr>
                        <h3>Presensi</h3>
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
            <div class="col-12 col-md bg-white">
                <div class="py-3 px-4 border-bottom">
                    <h4 class="mb-0">Forum Diskusi Kelas</h4>
                </div>

                <div class="position-relative">
                    <div class="chat-messages p-4">

                        <div class="chat-message-right pb-4">
                            <div>
                                <img src="https://demo.adminkit.io/img/avatars/avatar.jpg" class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:33 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 me-3">
                                <div class="font-weight-bold mb-1">You</div>
                                Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.
                            </div>
                        </div>

                        <div class="chat-message-left pb-4">
                            <div>
                                <img src="img/avatars/avatar-3.jpg" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:34 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                Sit meis deleniti eu, pri vidit meliore docendi ut, an eum erat animal commodo.
                            </div>
                        </div>

                        <div class="chat-message-right mb-4">
                            <div>
                                <img src="img/avatars/avatar.jpg" class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:35 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 me-3">
                                <div class="font-weight-bold mb-1">You</div>
                                Cum ea graeci tractatos.
                            </div>
                        </div>

                        <div class="chat-message-left pb-4">
                            <div>
                                <img src="img/avatars/avatar-3.jpg" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:36 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                Sed pulvinar, massa vitae interdum pulvinar, risus lectus porttitor magna, vitae commodo lectus mauris et velit.
                                Proin ultricies placerat imperdiet. Morbi varius quam ac venenatis tempus.
                            </div>
                        </div>

                        <div class="chat-message-left pb-4">
                            <div>
                                <img src="img/avatars/avatar-3.jpg" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:37 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                Cras pulvinar, sapien id vehicula aliquet, diam velit elementum orci.
                            </div>
                        </div>

                        <div class="chat-message-right mb-4">
                            <div>
                                <img src="img/avatars/avatar.jpg" class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:38 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 me-3">
                                <div class="font-weight-bold mb-1">You</div>
                                Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.
                            </div>
                        </div>

                        <div class="chat-message-left pb-4">
                            <div>
                                <img src="img/avatars/avatar-3.jpg" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:39 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                Sit meis deleniti eu, pri vidit meliore docendi ut, an eum erat animal commodo.
                            </div>
                        </div>

                        <div class="chat-message-right mb-4">
                            <div>
                                <img src="img/avatars/avatar.jpg" class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:40 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 me-3">
                                <div class="font-weight-bold mb-1">You</div>
                                Cum ea graeci tractatos.
                            </div>
                        </div>

                        <div class="chat-message-right mb-4">
                            <div>
                                <img src="img/avatars/avatar.jpg" class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:41 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 me-3">
                                <div class="font-weight-bold mb-1">You</div>
                                Morbi finibus, lorem id placerat ullamcorper, nunc enim ultrices massa, id dignissim metus urna eget purus.
                            </div>
                        </div>

                        <div class="chat-message-left pb-4">
                            <div>
                                <img src="img/avatars/avatar-3.jpg" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:42 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                Sed pulvinar, massa vitae interdum pulvinar, risus lectus porttitor magna, vitae commodo lectus mauris et velit.
                                Proin ultricies placerat imperdiet. Morbi varius quam ac venenatis tempus.
                            </div>
                        </div>

                        <div class="chat-message-right mb-4">
                            <div>
                                <img src="img/avatars/avatar.jpg" class="rounded-circle me-1" alt="Chris Wood" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:43 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 me-3">
                                <div class="font-weight-bold mb-1">You</div>
                                Lorem ipsum dolor sit amet, vis erat denique in, dicunt prodesset te vix.
                            </div>
                        </div>

                        <div class="chat-message-left pb-4">
                            <div>
                                <img src="img/avatars/avatar-3.jpg" class="rounded-circle me-1" alt="Sharon Lessman" width="40" height="40">
                                <div class="text-muted small text-nowrap mt-2">2:44 am</div>
                            </div>
                            <div class="flex-shrink-1 bg-light rounded py-2 px-3 ms-3">
                                <div class="font-weight-bold mb-1">Sharon Lessman</div>
                                Sit meis deleniti eu, pri vidit meliore docendi ut, an eum erat animal commodo.
                            </div>
                        </div>

                    </div>
                </div>

                <div class="flex-grow-0 py-3 px-4 border-top">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Type your message">
                        <button class="btn btn-primary">Send</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</main>