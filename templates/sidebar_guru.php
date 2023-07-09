<?php $guru = $mysqli->query("SELECT * FROM guru WHERE id=" . $_SESSION['user']['id_guru'])->fetch_assoc(); ?>
<div class="col-12 col-sm-6 col-md-5 col-xl-3">
    <div class="card mb-3">
        <div class="card-body text-center">
            <img src="<?= $guru['foto']; ?>" onerror="imageError(this)" class="img-fluid rounded-circle mb-2" style="width: 180px; height: 180px; object-fit: cover;">
            <h5 class="card-title mb-0"><?= $guru['nama']; ?></h5>
            <div class="text-muted mb-0"><?= $guru['nip']; ?></div>
        </div>
    </div>
</div>