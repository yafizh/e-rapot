<main class="content">
    <div class="container-fluid p-0">
        <h1 class="mb-3">Buku Digital</h1>
        <div class="row">
            <?php include_once('templates/sidebar_guru.php'); ?>
            <div class="col-12 col-md">
                <?php include_once('templates/navigator_guru.php'); ?>
                <?php
                $result = $mysqli->query("SELECT * FROM buku_digital ORDER BY judul");
                ?>
                <div class="row">
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="card">
                                <div class="card-body p-0">
                                    <img src="<?= $row['foto'] ?>" class="w-100" style="height: 10rem; object-fit: cover;">
                                </div>
                                <style>
                                    .title,
                                    .author {
                                        text-overflow: ellipsis;

                                        /* Needed to make it work */
                                        overflow: hidden;
                                        white-space: nowrap;
                                    }
                                </style>
                                <div class="card-body">
                                    <h4 class="mb-0 title"><?= $row['judul']; ?></h4>
                                    <h6 class="text-muted mb-4 author"><?= $row['pengarang']; ?></h6>
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="<?= $row['file']; ?>" download="<?= $row['judul']; ?>" class="btn btn-success btn-sm">Download</a>
                                        <a href="<?= $row['file']; ?>" target="_blank" class="btn btn-info btn-sm">Baca</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</main>