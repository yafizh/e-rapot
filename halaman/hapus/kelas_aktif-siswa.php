<?php
$q = "
    SELECT 
        s.nama,
        (SELECT COUNT(id) FROM semester_kelas WHERE id_kelas_siswa=" . $_GET['id'] . ") AS jumlah_semester 
    FROM 
        kelas_siswa AS ks
    INNER JOIN 
        siswa AS s
    ON 
        s.id=ks.id_siswa 
    WHERE 
        ks.id=" . $_GET['id'];
$data = $mysqli->query($q)->fetch_assoc();
if ($data['jumlah_semester'] > 1) {
    if (!$mysqli->query("DELETE FROM semester_kelas WHERE id=" . $_GET['id_semester_kelas']))
        die($mysqli->error);
} else {
    if (!$mysqli->query("DELETE FROM kelas_siswa WHERE id=" . $_GET['id']))
        die($mysqli->error);
}

$_SESSION['hapus_data']['nama'] =  $data['nama'];
echo "<script>location.href = '?h=lihat_kelas_aktif-siswa&id_kelas=" . $_GET['id_kelas'] . "&id_kelas_aktif=" . $_GET['id_kelas_aktif'] . "';</script>";
