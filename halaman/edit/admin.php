<?php
$data = $mysqli->query("SELECT * FROM user WHERE id=" . $_GET['id'])->fetch_assoc();
if (isset($_POST['submit'])) {
    $username = $mysqli->real_escape_string($_POST['username']);
    $password = $mysqli->real_escape_string($_POST['password']);

    $_SESSION['old']['username'] = $username;

    $validasi = $mysqli->query("SELECT username FROM user WHERE username='$username' AND id !=" . $data['id']);
    if (!$validasi->num_rows) {
        $q = "UPDATE admin SET username='$username' WHERE id=" . $_GET['id'];

        if ($mysqli->query($q)) {
            $_SESSION['edit_data']['username'] =  $data['username'];
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
            <h1 class="h3 d-inline align-middle">Edit Admin</h1>
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
                                <input type="text" class="form-control" name="username" required autocomplete="off" value="<?= $_SESSION['old']['username'] ?? $data['nama']; ?>">
                            </div>
                            <a href="?h=admin" class="btn btn-secondary float-start">Kembali</a>
                            <button type="submit" name="submit" class="btn btn-primary float-end">Perbaharui</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>