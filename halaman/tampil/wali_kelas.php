<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 d-flex justify-content-between">
            <h1 class="h3 d-inline align-middle">Data Wali Kelas</h1>
        </div>

        <div class="row">
            <?php if (isset($_SESSION['ganti_password'])) : ?>
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible delete" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            <h4 class="alert-heading">Ganti Password Berhasil</h4>
                            <p>Berhasil memperbaharui password wali kelas <strong><?= $_SESSION['ganti_password']['nama']; ?></strong>.</p>
                            <hr>
                        </div>
                    </div>
                </div>
                <?php unset($_SESSION['ganti_password']); ?>
            <?php endif; ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped datatables-reponsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">No</th>
                                    <th class="text-center">NIP/Username</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Wali Kelas</th>
                                    <th class="text-center td-fit">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $q = "
                                SELECT 
                                    ug.id_user,
                                    g.nip, 
                                    g.nama, 
                                    k.nama AS kelas, 
                                    ka.nama AS nama_kelas 
                                FROM 
                                    user_guru AS ug 
                                INNER JOIN 
                                    guru AS g 
                                ON 
                                    g.id=ug.id_guru 
                                INNER JOIN 
                                    kelas_aktif AS ka  
                                ON 
                                    g.id=ka.id_guru 
                                INNER JOIN 
                                    kelas AS k   
                                ON 
                                    k.id=ka.id_kelas";
                            $result = $mysqli->query($q);
                            $no = 1;
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center td-fit"><?= $no++; ?></td>
                                        <td class="text-center"><?= $row['nip']; ?></td>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center"><?= $row['kelas']; ?> <?= $row['nama_kelas']; ?></td>
                                        <td class="text-center td-fit">
                                            <a href="?h=ganti_password&id=<?= $row['id_user']; ?>" class="btn btn-sm btn-secondary">Ganti Password</a>
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