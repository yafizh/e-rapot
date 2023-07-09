<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Presensi dan Forum Diskusi</h1>
        <div class="row">
            <div class="col-12 col-md-5">
                <?php
                $q = "
                    SELECT  
                        *
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
                    <div class="card-header d-flex justify-content-between">
                        <h3>Presensi</h3>
                        <a href="?h=tambah_presensi&id=<?= $_GET['id']; ?>" class="btn btn-primary">Tambah Presensi</a>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= indoensiaDateWithDay($row['tanggal']); ?></td>
                                        <td class="text-center">
                                            <a href="?h=lihat_presensi&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-info btn-sm">Lihat</a>
                                            <a href="?h=edit_presensi&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="?h=hapus_presensi&id=<?= $_GET['id'] ?>&idd=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin?')">Hapus</a>
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