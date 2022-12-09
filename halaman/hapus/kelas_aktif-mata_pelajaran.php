<?php
$q = "
    SELECT 
        mp.nama 
    FROM 
        mata_pelajaran_kelas AS mpk 
    INNER JOIN 
        mata_pelajaran AS mp 
    ON 
        mp.id=mpk.id_mata_pelajaran 
    WHERE 
        mpk.id=" . $_GET['id'];
$data = $mysqli->query($q)->fetch_assoc();
if ($mysqli->query("DELETE FROM mata_pelajaran_kelas WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data']['nama'] =  $data['nama'];
    echo "<script>location.href = '?h=lihat_kelas_aktif-mata_pelajaran&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
