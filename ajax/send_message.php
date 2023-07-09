<?php
require_once('../db/koneksi.php');
date_default_timezone_set('Asia/Kuala_Lumpur');

$result = $mysqli->query("
    INSERT INTO forum_diskusi (
        id_user,
        id_mata_pelajaran_kelas,
        tanggal_waktu,
        pesan 
    ) VALUES (
        " . $_GET['id_user'] . ",
        " . $_GET['id'] . ",
        '" . Date('Y-m-d H:i:s') . "',
        '" . $_GET['pesan'] . "'
    )
");
