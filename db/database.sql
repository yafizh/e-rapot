DROP DATABASE IF EXISTS `db_e_rapot`;
CREATE DATABASE `db_e_rapot`;
USE `db_e_rapot`;

CREATE TABLE `user` (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `user_guru` (
    id INT NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_guru INT NOT NULL,
    status VARCHAR(255) NOT NULL COMMENT 'GURU ATAU WALI KELAS',
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES user (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `guru` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    tempat_lahir VARCHAR(255) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    PRIMARY KEY (id) 
);

CREATE TABLE `sub_kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    id_kelas INT NOT NULL,
    id_guru INT NOT NULL COMMENT 'Wali Kelas',
    nama VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_kelas) REFERENCES kelas (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `mata_pelajaran` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE `mata_pelajaran_kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    id_sub_kelas INT NOT NULL,
    id_mata_pelajaran INT NOT NULL,
    id_guru INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_sub_kelas) REFERENCES sub_kelas (id) ON DELETE CASCADE,
    FOREIGN KEY (id_mata_pelajaran) REFERENCES mata_pelajaran (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_sub_kelas INT NOT NULL COMMENT 'Sebagai Status Kelasnya Sekarang',
    nama VARCHAR(255) NOT NULL,
    tempat_lahir VARCHAR(255) NOT NULL,
    tanggal_lahir VARCHAR(255) NOT NULL,
    jenis_kelamin VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_sub_kelas) REFERENCES sub_kelas (id) ON DELETE CASCADE
);

CREATE TABLE `nilai_siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_siswa INT NOT NULL,
    id_mata_pelajaran_kelas INT NOT NULL,
    nilai INT,
    PRIMARY KEY (id),
    FOREIGN KEY (id_siswa) REFERENCES siswa (id) ON DELETE CASCADE,
    FOREIGN KEY (id_mata_pelajaran_kelas) REFERENCES mata_pelajaran_kelas (id) ON DELETE CASCADE
);
