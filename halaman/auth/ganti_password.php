<?php
if (isset($_GET['id'])) {
    $q = "
        SELECT 
            u.*,
            ug.id_guru,
            g.nama  
        FROM 
            user AS u 
        LEFT JOIN 
            user_guru AS ug 
        ON 
            ug.id_user=u.id 
        LEFT JOIN 
            guru AS g 
        ON 
            ug.id_guru=g.id 
        WHERE 
            u.id=" . $_GET['id'];
    $data = $mysqli->query($q)->fetch_assoc();
    if (isset($_POST['submit'])) {
        $password = $mysqli->real_escape_string($_POST['password']);

        $q = "UPDATE user SET password='$password' WHERE id=" . $_GET['id'];

        if ($mysqli->query($q)) {
            if (is_null($data['id_guru'])) {
                $_SESSION['ganti_password']['username'] =  $data['username'];
                echo "<script>location.href = '?h=admin';</script>";
            } else {
                $_SESSION['ganti_password']['nama'] =  $data['nama'];
                echo "<script>location.href = '?h=wali_kelas';</script>";
            }
        } else
            die($mysqli->error);
    }
} else {
    $q = "
        SELECT 
            * 
        FROM 
            user_guru 
        WHERE id_guru=" . $_SESSION['user']['id_guru'];
    $data = $mysqli->query($q)->fetch_assoc();
    if (isset($_POST['submit'])) {
        $password_lama = $mysqli->real_escape_string($_POST['password_lama']);
        $password_baru = $mysqli->real_escape_string($_POST['password_baru']);
        $konfirmasi_password_baru = $mysqli->real_escape_string($_POST['konfirmasi_password_baru']);

        $cek_password_lama = $mysqli->query("SELECT * FROM user WHERE id=" . $data['id_user'] . " AND password='$password_lama'");
        if ($cek_password_lama->num_rows) {
            if ($password_baru === $konfirmasi_password_baru) {
                if ($mysqli->query("UPDATE user SET password='$password' WHERE id=" . $data['id_user']))
                    $_SESSION['success'] =  true;
                else
                    die($mysqli->error);
            } else $_SESSION['error'][] = 'Password Baru Tidak Sama!';
        } else $_SESSION['error'][] = 'Password Lama Salah!';
    }
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Ganti Password</h1>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-xl-6">
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
                <?php if (isset($_SESSION['success'])) : ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        <div class="alert-message">
                            Password Berhasil Diperbaharui!
                        </div>
                    </div>
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>
                <?php if (isset($_GET['id'])) : ?>
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" required autocomplete="off">
                                </div>
                                <a href="?h=admin" class="btn btn-secondary float-start">Kembali</a>
                                <button type="submit" name="submit" class="btn btn-primary float-end">Ganti Password</button>
                            </form>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Password Lama</label>
                                    <input type="password" class="form-control" name="password_lama" required autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password Baru</label>
                                    <input type="password" class="form-control" name="password_baru" required autocomplete="off">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Konfirmasi Password Baru</label>
                                    <input type="password" class="form-control" name="konfirmasi_password_baru" required autocomplete="off">
                                </div>
                                <?php if (is_null($_SESSION['user']['id_guru'])) : ?>
                                    <a href="?h=admin" class="btn btn-secondary float-start">Kembali</a>
                                <?php else : ?>
                                    <a href="?" class="btn btn-secondary float-start">Kembali</a>
                                <?php endif; ?>
                                <button type="submit" name="submit" class="btn btn-primary float-end">Ganti Password</button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</main>