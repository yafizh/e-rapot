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
        <h1 class="mb-3">Halaman Forum Diskusi</h1>
        <div class="row">
            <div class="col-12 bg-white">
                <div class="py-3 px-4 border-bottom">
                    <h4 class="mb-0">Forum Diskusi Kelas</h4>
                </div>

                <?php include_once('templates/forum_diskusi.php') ?>
            </div>
        </div>
    </div>
</main>