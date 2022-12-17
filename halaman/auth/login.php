<?php 
session_start();
$_SESSION['error'] = [];
require_once('../../db/koneksi.php');
if (isset($_POST['submit'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $q = "
        SELECT 
            u.id AS id_user,
            u.username, 
            u.password,
            ug.id_guru,
            g.nip,
            g.nama,
            g.foto,
            ug.status 
        FROM 
            user AS u 
        LEFT JOIN 
            user_guru AS ug 
        ON 
            u.id=ug.id_user 
        LEFT JOIN 
            guru AS g 
        ON 
            g.id=ug.id_guru 
        WHERE 
            u.username='$username' 
            AND 
            u.password='$password' 
    ";
    $data = $mysqli->query($q);
    if ($data->num_rows) {
        $_SESSION['user'] =  $data->fetch_assoc();
        echo "<script>location.href = '../../index.php';</script>";
    } else
        $_SESSION['error'][] = "Username atau Password Salah!";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="canonical" href="https://demo.adminkit.io/pages-sign-in.html" />

    <title>LOGIN</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../assets/css/light.css">
    <style>
        body {
            opacity: 0;
        }
    </style>
</head>

<body data-theme="default" data-layout="fluid" data-sidebar-position="left" data-sidebar-layout="default">
    <main class="d-flex w-100 h-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center">
                            <img src="../../assets/img/icons/kemenag.svg" style="width: 12rem; aspect-ratio: 1;" class="mb-3">
                            <h1 class="h2">APLIKASI E-RAPOT PADA</h1>
                            <h1 class="h2">MADRASAH ALIYAH AMPAH</h1>
                            <p class="lead">Silakan Login Untuk Melanjutkan</p>
                        </div>
                        <?php if (count($_SESSION['error'])) : ?>
                            <?php foreach ($_SESSION['error'] as $error) : ?>
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    <div class="alert-message">
                                        <?= $error; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">NIP</label>
                                            <input class="form-control form-control-lg" type="text" name="username" autofocus placeholder="Masukkan NIP" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" type="password" name="password" placeholder="Masukkan Password" />
                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" name="submit" class="btn btn-lg btn-primary">LOGIN</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../../assets/js/app.js"></script>
</body>

</html>