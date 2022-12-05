<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Aplikasi E-Rapot</title>
    <link rel="shortcut icon" href="assets/images/favicon.png" />

    <link rel="stylesheet" href="assets/css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <?php include_once('templates/sidebar.php'); ?>
        <div class="main">
            <?php include_once('templates/navbar.php'); ?>
            <?php
            if (isset($_GET['page'])) {
                switch ($_GET['page']) {
                    case "buku_tamu":
                        include_once "halaman_buku_tamu.php";
                        break;
                    case "buku_tamu_keluar":
                        include_once "halaman_buku_tamu/halaman_buku_tamu_keluar.php";
                        break;
                    case "tambah_user":
                        include_once "halaman_tambah_data/halaman_tambah_user.php";
                        break;
                    case "tambah_divisi":
                        include_once "halaman_tambah_data/halaman_tambah_divisi.php";
                        break;
                    case "tambah_pegawai":
                        include_once "halaman_tambah_data/halaman_tambah_pegawai.php";
                        break;
                    case "tambah_user_tamu":
                        include_once "halaman_tambah_data/halaman_tambah_user_tamu.php";
                        break;
                    case "data_tamu":
                        include_once "halaman_tampil_data/halaman_data_tamu.php";
                        break;
                    case "data_user":
                        include_once "halaman_tampil_data/halaman_data_user.php";
                        break;
                    case "data_divisi":
                        include_once "halaman_tampil_data/halaman_data_divisi.php";
                        break;
                    case "data_pegawai":
                        include_once "halaman_tampil_data/halaman_data_pegawai.php";
                        break;
                    case "data_user_tamu":
                        include_once "halaman_tampil_data/halaman_data_user_tamu.php";
                        break;
                    case "data_pendaftar":
                        include_once "halaman_tampil_data/halaman_data_pendaftar.php";
                        break;
                    case "data_user_lupa_password":
                        include_once "halaman_tampil_data/halaman_data_user_lupa_password.php";
                        break;
                    case "edit_tamu":
                        include_once "halaman_edit_data/halaman_edit_tamu.php";
                        break;
                    case "detail_tamu":
                        include_once "halaman_detail_data/halaman_detail_tamu.php";
                        break;
                    case "detail_user_tamu":
                        include_once "halaman_detail_data/halaman_detail_user_tamu.php";
                        break;
                    case "detail_pendaftar":
                        include_once "halaman_detail_data/halaman_detail_pendaftar.php";
                        break;
                    case "detail_user_lupa_password":
                        include_once "halaman_detail_data/halaman_detail_user_lupa_password.php";
                        break;
                    case "edit_user":
                        include_once "halaman_edit_data/halaman_edit_user.php";
                        break;
                    case "edit_divisi":
                        include_once "halaman_edit_data/halaman_edit_divisi.php";
                        break;
                    case "edit_pegawai":
                        include_once "halaman_edit_data/halaman_edit_pegawai.php";
                        break;
                    case "edit_user_tamu":
                        include_once "halaman_edit_data/halaman_edit_user_tamu.php";
                        break;
                    case "delete_tamu":
                        include_once "halaman_delete_data/halaman_delete_tamu.php";
                        break;
                    case "delete_user":
                        include_once "halaman_delete_data/halaman_delete_user.php";
                        break;
                    case "delete_divisi":
                        include_once "halaman_delete_data/halaman_delete_divisi.php";
                        break;
                    case "delete_pegawai":
                        include_once "halaman_delete_data/halaman_delete_pegawai.php";
                        break;
                    case "delete_user_tamu":
                        include_once "halaman_delete_data/halaman_delete_user_tamu.php";
                        break;
                    case "ganti_password":
                        include_once "halaman_auth/halaman_ganti_password.php";
                        break;
                    case "edit_profile":
                        include_once "halaman_profile/halaman_edit_profile.php";
                        break;
                    case "logout":
                        include_once "halaman_auth/halaman_logout.php";
                        break;
                    case "laporan":
                        include_once "halaman_laporan/halaman_laporan.php";
                        break;
                    default:
                        include_once "beranda.php";
                }
            } else include_once "beranda.php";
            ?>
        </div>
    </div>
    <script src="assets/js/app.js"></script>
</body>

</html>