<main class="content">
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-12 col-sm-6 col-md-5 col-xl-3">
                <div class="card mb-3">
                    <div class="card-body text-center">
                        <img src="assets/img/avatars/avatar-4.jpg" alt="Christina Mason" class="img-fluid rounded-circle mb-2" width="128" height="128">
                        <h5 class="card-title mb-0">Christina Mason</h5>
                        <div class="text-muted mb-2">Lead Developer</div>

                        <div>
                            <a class="btn btn-primary btn-sm" href="#">Follow</a>
                            <a class="btn btn-primary btn-sm" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square">
                                    <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                                </svg> Message</a>
                        </div>
                    </div>
                    <hr class="my-0">
                    <div class="card-body">

                    </div>
                    <hr class="my-0">
                    <div class="card-body">
                        <h5 class="h6 card-title text-center">Riwayat Sebagai Wali Kelas</h5>
                        <table class="table" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="text-center">Tahun Pelajaran</th>
                                    <th class="text-center">Kelas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">2022/2023</td>
                                    <td class="text-center">1 A</td>
                                    <td class="td-fit">
                                        <button class="btn btn-sm btn-success">Lihat</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm">
                <?php $semester = $mysqli->query("SELECT * FROM semester ORDER BY tingkat DESC")->fetch_all(MYSQLI_ASSOC); ?>
                <?php $kelas_aktif = $mysqli->query("SELECT * FROM kelas_aktif WHERE id_guru=" . $_SESSION['user']['id_guru'] . " ORDER BY id DESC")->fetch_assoc(); ?>
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">No</th>
                                    <th class="text-center">Nomor Induk</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Status Nilai</th>
                                    <th class="text-center td-fit">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($semester as $value_semester) : ?>
                                    <?php
                                    $q = "
                                        SELECT 
                                        sk.id AS id_semester_kelas,
                                        ks.id,
                                        ks.status,
                                        s.id AS id_siswa,
                                        s.nama,
                                        IFNULL(
                                            (SELECT id FROM nilai_siswa WHERE id_semester_kelas=sk.id),
                                            0
                                        ) AS status_nilai 
                                        FROM 
                                            kelas_siswa AS ks 
                                        INNER JOIN 
                                            siswa AS s 
                                        ON 
                                            s.id=ks.id_siswa 
                                        INNER JOIN 
                                            semester_kelas AS sk 
                                        ON 
                                            sk.id_kelas_siswa=ks.id  
                                        WHERE 
                                            ks.id_kelas_aktif=" . $kelas_aktif['id'] . " 
                                            AND 
                                            sk.id_semester=" . $value_semester['id'] . "
                                        ORDER BY 
                                            s.nama 
                                      ";
                                    $result = $mysqli->query($q);
                                    $no = 1;
                                    ?>
                                    <?php if ($result->num_rows) : ?>
                                        <?php while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td class="text-center td-fit"><?= $no++; ?></td>
                                                <td class="text-center"><?= $no++; ?></td>
                                                <td class="text-center"><?= $row['nama']; ?></td>
                                                <td class="text-center"><?= $row['status_nilai']; ?></td>
                                                <td class="text-center td-fit">
                                                    <a href="#" class="btn btn-sm btn-info">Nilai</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                        <?php break; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>