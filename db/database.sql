DROP DATABASE IF EXISTS `db_e_rapot`;

CREATE DATABASE `db_e_rapot`;

USE `db_e_rapot`;

CREATE TABLE `db_e_rapot`.`user` (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    status_login BOOLEAN NULL,
    terakhir_login DATETIME NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `db_e_rapot`.`guru` (
    id INT NOT NULL AUTO_INCREMENT,
    nip VARCHAR(30) NOT NULL UNIQUE,
    nama VARCHAR(100) NOT NULL,
    jabatan VARCHAR(100) NULL,
    tempat_lahir VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin VARCHAR(30) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `db_e_rapot`.`user_guru` (
    id INT NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_guru INT NOT NULL,
    status VARCHAR(30) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES user (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(20) NOT NULL,
    tingkat INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `db_e_rapot`.`semester` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(20) NOT NULL,
    tingkat INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `db_e_rapot`.`mata_pelajaran` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(50) NOT NULL,
    kkm INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `db_e_rapot`.`kelas_aktif` (
    id INT NOT NULL AUTO_INCREMENT,
    id_kelas INT NOT NULL,
    id_guru INT NOT NULL,
    nama VARCHAR(30),
    tahun_pelajaran VARCHAR(20),
    status VARCHAR(20),
    PRIMARY KEY (id),
    FOREIGN KEY (id_kelas) REFERENCES kelas (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    nis VARCHAR(30) NOT NULL,
    nisn VARCHAR(30) NOT NULL,
    nama VARCHAR(100) NOT NULL,
    tempat_lahir VARCHAR(100) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin VARCHAR(20) NOT NULL,
    agama VARCHAR(30) NOT NULL,
    alamat TEXT NOT NULL,
    nama_ayah VARCHAR(100),
    pekerjaan_ayah VARCHAR(50),
    nama_ibu VARCHAR(100),
    pekerjaan_ibu VARCHAR(50),
    foto VARCHAR(255) NOT NULL,
    status VARCHAR(30) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `db_e_rapot`.`user_siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_siswa INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES user (id) ON DELETE CASCADE,
    FOREIGN KEY (id_siswa) REFERENCES siswa (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`kelas_siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_kelas_aktif INT NOT NULL,
    id_siswa INT NOT NULL,
    status VARCHAR(20) NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_kelas_aktif) REFERENCES kelas_aktif (id) ON DELETE CASCADE,
    FOREIGN KEY (id_siswa) REFERENCES siswa (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`semester_kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    id_kelas_siswa INT NOT NULL,
    id_semester INT NOT NULL,
    sakit INT NULL,
    izin INT NULL,
    tanpa_keterangan INT NULL,
    catatan_wali_kelas TEXT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_kelas_siswa) REFERENCES kelas_siswa (id) ON DELETE CASCADE,
    FOREIGN KEY (id_semester) REFERENCES semester (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`mata_pelajaran_kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    id_kelas_aktif INT NOT NULL,
    id_mata_pelajaran INT NOT NULL,
    id_guru INT NOT NULL,
    kkm INT NOT NULL,
    rps VARCHAR(255),
    PRIMARY KEY (id),
    FOREIGN KEY (id_kelas_aktif) REFERENCES kelas_aktif (id) ON DELETE CASCADE,
    FOREIGN KEY (id_mata_pelajaran) REFERENCES mata_pelajaran (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`tugas_mata_pelajaran_kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    id_mata_pelajaran_kelas INT NOT NULL,
    nama VARCHAR(50) NOT NULL,
    tanggal_mulai DATE NOT NULL,
    tanggal_selesai DATE NOT NULL,
    file VARCHAR(255) NOT NULL,
    keterangan TEXT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_mata_pelajaran_kelas) REFERENCES mata_pelajaran_kelas (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`tugas_siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_siswa INT NOT NULL,
    id_tugas_mata_pelajaran_kelas INT NULL,
    tanggal_waktu DATETIME NULL,
    file VARCHAR(255) NULL,
    nilai INT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_tugas_mata_pelajaran_kelas) REFERENCES tugas_mata_pelajaran_kelas (id) ON DELETE CASCADE,
    FOREIGN KEY (id_siswa) REFERENCES siswa (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`nilai_siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_semester_kelas INT NOT NULL,
    id_mata_pelajaran_kelas INT NOT NULL,
    nilai INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_semester_kelas) REFERENCES semester_kelas (id) ON DELETE CASCADE,
    FOREIGN KEY (id_mata_pelajaran_kelas) REFERENCES mata_pelajaran_kelas (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`presensi_mata_pelajaran_kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    id_mata_pelajaran_kelas INT NOT NULL,
    tanggal DATE NOT NULL,
    waktu_mulai TIME NULL,
    waktu_selesai TIME NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_mata_pelajaran_kelas) REFERENCES mata_pelajaran_kelas (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`presensi_siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_siswa INT NOT NULL,
    id_presensi_mata_pelajaran_kelas INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_siswa) REFERENCES siswa (id) ON DELETE CASCADE,
    FOREIGN KEY (id_presensi_mata_pelajaran_kelas) REFERENCES presensi_mata_pelajaran_kelas (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`buku_digital` (
    id INT NOT NULL AUTO_INCREMENT,
    judul VARCHAR(100) NOT NULL,
    pengarang VARCHAR(50) NOT NULL,
    tahun_terbit TINYINT UNSIGNED NOT NULL,
    jumlah_halaman TINYINT UNSIGNED NOT NULL,
    file VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `db_e_rapot`.`forum_diskusi` (
    id INT NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_mata_pelajaran_kelas INT NOT NULL,
    tanggal_waktu DATETIME,
    pesan TEXT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES user (id) ON DELETE CASCADE,
    FOREIGN KEY (id_mata_pelajaran_kelas) REFERENCES mata_pelajaran_kelas (id) ON DELETE CASCADE
);

CREATE TABLE `db_e_rapot`.`presensi_guru` (
    id INT NOT NULL AUTO_INCREMENT,
    id_guru INT NOT NULL,
    tanggal DATE NOT NULL,
    masuk TIME NOT NULL,
    keluar TIME NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);