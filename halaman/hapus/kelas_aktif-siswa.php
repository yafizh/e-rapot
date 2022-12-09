<?php
$q = "
    SELECT 
        s.nama
    FROM 
        kelas_siswa AS ks
    INNER JOIN 
        siswa AS s
    ON 
        s.id=ks.id_siswa 
    WHERE 
        ks.id=" . $_GET['id'];
$data = $mysqli->query($q)->fetch_assoc();
if ($mysqli->query("DELETE FROM kelas_siswa WHERE id=" . $_GET['id'])) {
    $_SESSION['hapus_data']['nama'] =  $data['nama'];
    echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
} else {
    echo "<script>alert('Hapus Data Gagal!')</script>";
    die($mysqli->error);
}
