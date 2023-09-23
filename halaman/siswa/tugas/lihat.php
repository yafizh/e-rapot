<?php

?>
<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Halaman Tugas</h1>
        <?php
        $q = "
            SELECT
                tmpk.id,
                tmpk.file soal,
                ts.file jawaban,
                tmpk.nama,
                ts.nilai 
            FROM 
                tugas_mata_pelajaran_kelas tmpk  
            INNER JOIN 
                mata_pelajaran_kelas mpk 
            ON 
                mpk.id=tmpk.id_mata_pelajaran_kelas 
            LEFT JOIN 
                tugas_siswa ts 
            ON 
                ts.id_tugas_mata_pelajaran_kelas=tmpk.id 
            WHERE 
                mpk.id=" . $_GET['id'] . " 
            ORDER BY    
                tmpk.tanggal_mulai DESC 
        ";

        $result = $mysqli->query($q);
        ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tugas</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama Tugas</th>
                                    <th class="text-center">Soal</th>
                                    <th class="text-center">Jawaban</th>
                                    <th class="text-center">Nilai</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php
                            ?>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td class="text-center"><?= $row['nama']; ?></td>
                                        <td class="text-center">
                                            <a href="<?= $row['soal']; ?>" class="btn btn-sm btn-info" target="_blank">Lihat Soal</a>
                                        </td>
                                        <?php if (is_null($row['jawaban'])) : ?>
                                            <td class="text-center">Belum Mengumpulkan Jawaban</td>
                                        <?php else : ?>
                                            <td class="text-center">
                                                <a href="<?= $row['soal']; ?>" class="btn btn-info btn-sm" target="_blank">Lihat Jawaban</a>
                                            </td>
                                        <?php endif; ?>

                                        <?php if (is_null($row['jawaban'])) : ?>
                                            <td class="text-center">Belum Mengumpulkan Jawaban</td>
                                        <?php else : ?>
                                            <?php if (is_null($row['nilai'])) : ?>
                                                <td class="text-center">Menuggu Penilaian</td>
                                            <?php else : ?>
                                                <td class="text-center"><?= $row['nilai']; ?></td>
                                            <?php endif; ?>
                                        <?php endif; ?>

                                        <td class="td-fit">
                                            <a href="?h=perbaharui_tugas&id=<?= $_GET['id']; ?>&idd=<?= $row['id'] ?>" class="btn btn-info btn-sm">Pebaharui Jawaban</a>
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