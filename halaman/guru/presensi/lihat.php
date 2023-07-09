<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Presensi dan Forum Diskusi</h1>
        <div class="row">
            <div class="col-12 col-md-5">
                <?php
                $q = "
                    SELECT 
                        s.nama,
                        (
                            SELECT 
                                ps.id 
                            FROM 
                                presensi_siswa ps 
                            WHERE 
                                ps.id_siswa=s.id  
                                AND 
                                ps.id_presensi_mata_pelajaran_kelas=" . $_GET['idd'] . " 
                        ) status  
                    FROM 
                        kelas_siswa ks 
                    INNER JOIN 
                        siswa s 
                    ON 
                        s.id=ks.id_siswa 
                    INNER JOIN 
                        kelas_aktif ka 
                    ON 
                        ka.id=ks.id_kelas_aktif 
                    INNER JOIN 
                        mata_pelajaran_kelas mpk 
                    ON 
                        mpk.id_kelas_aktif=ka.id 
                    INNER JOIN 
                        presensi_mata_pelajaran_kelas pmpk 
                    ON 
                        pmpk.id_mata_pelajaran_kelas=mpk.id 
                    WHERE 
                        mpk.id=" . $_GET['id'] . " 
                        AND 
                        pmpk.id=" . $_GET['idd'] . "
                ";
                $result = $mysqli->query($q);
                ?>
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3>Presensi Siswa</h3>
                        <a href="?h=mata_pelajaran&id=<?= $_GET['id']; ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center">
                                            <?php if (is_null($row['status'])) : ?>
                                                <span class="badge rounded-pill text-bg-danger">Tidak Hadir</span>
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