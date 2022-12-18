<?php $kelas = $mysqli->query("SELECT * FROM kelas WHERE id=" . $_GET['id_kelas'])->fetch_assoc(); ?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item active">
                        <h1 class="h3 d-inline">Kelas <?= $kelas['nama']; ?></h1>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-striped datatables-reponsive" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center td-fit">Tahun Pelajaran</th>
                                    <th class="text-center td-fit">Nama Kelas</th>
                                    <th class="text-center td-fit">NIP</th>
                                    <th class="text-center">Wali Kelas</th>
                                    <th class="text-center td-fit">Jumlah Siswa</th>
                                    <th class="text-center td-fit">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            $query = "
                                SELECT 
                                    ka.id,
                                    k.nama AS kelas,
                                    ka.nama,
                                    ka.tahun_pelajaran,
                                    g.nip,
                                    g.nama AS wali_kelas,
                                    (SELECT COUNT(id) FROM kelas_siswa AS ks WHERE ks.id_kelas_aktif=ka.id AND status!='Tidak Aktif') AS jumlah_siswa 
                                FROM 
                                    kelas_aktif AS ka 
                                INNER JOIN 
                                    kelas AS k 
                                ON 
                                    k.id=ka.id_kelas 
                                INNER JOIN 
                                    guru AS g 
                                ON 
                                    g.id=ka.id_guru 
                                WHERE 
                                    k.id=" . $_GET['id_kelas'] . " 
                                    AND 
                                    ka.status = 'Selesai' 
                                ORDER BY 
                                    ka.tahun_pelajaran, ka.nama";
                            $result = $mysqli->query($query);
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center td-fit"><?= $row['tahun_pelajaran']; ?></td>
                                        <td class="text-center td-fit"><?= $row['nama']; ?></td>
                                        <td class="text-center td-fit"><?= $row['nip']; ?></td>
                                        <td><?= $row['wali_kelas']; ?></td>
                                        <td class="text-center td-fit"><?= $row['jumlah_siswa']; ?></td>
                                        <td class="text-center td-fit">
                                            <a href="?h=lihat_kelas_selesai&id_kelas=<?= $_GET['id_kelas']; ?>&id_kelas_aktif=<?= $row['id']; ?>" class="btn btn-sm btn-info">Lihat</a>
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