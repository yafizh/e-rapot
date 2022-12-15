<?php
if (isset($_POST['submit'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $_SESSION['old']['username'] = $username;

    $validasi = $mysqli->query("SELECT username FROM user WHERE username='$username'");
    if (!$validasi->num_rows) {
        $q = "INSERT INTO user (username, password) VALUES ('$username', '$password')";

        if ($mysqli->query($q)) {
            $_SESSION['tambah_data']['username'] =  $username;
            echo "<script>location.href = '?h=admin';</script>";
        } else
            die($mysqli->error);
    } else
        $_SESSION['error'][] = "Username $username telah digunakan, username tidak dapat sama dengan admin yang lain.";
}
?>
<main class="content">
    <div class="container-fluid p-0">

        <div class="mb-3 text-center">
            <h1 class="h3 d-inline align-middle">Tambah Admin</h1>
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
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" required autocomplete="off" value="<?= $_SESSION['old']['username'] ?? ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" required autocomplete="off">
                            </div>
                            <a href="?h=admin" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>