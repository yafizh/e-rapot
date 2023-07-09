<?php 
require_once('../db/koneksi.php');

$result = $mysqli->query("
    SELECT 
        fd.*,
        HOUR(fd.tanggal_waktu) jam,
        MINUTE(fd.tanggal_waktu) menit,
        g.nama nama_guru,
        g.foto foto_guru,
        s.nama nama_siswa,
        s.foto foto_siswa 
    FROM 
        forum_diskusi fd 
    INNER JOIN 
        user u 
    ON 
        u.id=fd.id_user 
    LEFT JOIN 
        user_guru ug 
    ON 
        ug.id_user=u.id 
    LEFT JOIN 
        user_siswa us 
    ON 
        us.id_user=u.id 
    LEFT JOIN 
        guru g 
    ON 
        g.id=ug.id_guru 
    LEFT JOIN 
        siswa s 
    ON 
        s.id=us.id_siswa 
    WHERE 
        fd.id_mata_pelajaran_kelas=".$_GET['id']." 
");

echo json_encode($result->fetch_all(MYSQLI_ASSOC));