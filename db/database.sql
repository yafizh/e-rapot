DROP DATABASE IF EXISTS `db_e_rapot`;
CREATE DATABASE `db_e_rapot`;
USE `db_e_rapot`;

CREATE TABLE `user` (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
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

INSERT INTO `guru` (
    nama,
    tempat_lahir,
    tanggal_lahir,
    jenis_kelamin,
    foto
) VALUES 
('Nurcholis', 'Martapura', '2000-01-01', 'Laki - Laki', ''),
('Habibi', 'Martapura', '2000-01-01', 'Laki - Laki', ''),
('Arif', 'Martapura', '2000-01-01', 'Laki - Laki', '');

CREATE TABLE `user_guru` (
    id INT NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    id_guru INT NOT NULL,
    status VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_user) REFERENCES user (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    tingkat INT NOT NULL,
    PRIMARY KEY (id) 
);

INSERT INTO `kelas` (
    nama,
    tingkat
) VALUES 
('Kelas 1', 1),
('Kelas 2', 2),
('Kelas 3', 3);

CREATE TABLE `semester` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    tingkat INT NOT NULL,
    PRIMARY KEY (id) 
);

INSERT INTO `semester` (
    nama,
    tingkat
) VALUES 
('Semester 1', 1),
('Semester 2', 2);

CREATE TABLE `mata_pelajaran` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO `mata_pelajaran` (
    nama
) VALUES 
('Matematika'),
('Bahasa Indonesia'),
('Bahasa Inggris');

CREATE TABLE `kelas_aktif` (
    id INT NOT NULL AUTO_INCREMENT,
    id_kelas INT NOT NULL,
    id_guru INT NOT NULL,
    nama VARCHAR(255),
    tahun_pelajaran VARCHAR(255),
    status VARCHAR(255),
    PRIMARY KEY (id),
    FOREIGN KEY (id_kelas) REFERENCES kelas (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    tempat_lahir VARCHAR(255) NOT NULL,
    tanggal_lahir VARCHAR(255) NOT NULL,
    jenis_kelamin VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO `siswa` (
    nama,
    tempat_lahir,
    tanggal_lahir,
    jenis_kelamin,
    foto,
    status
) VALUES 
('Diki', 'Martapura', '2000-01-01', 'Laki - Laki', '', 'Aktif'),
('Syafiq', 'Martapura', '2000-01-01', 'Laki - Laki', '', 'Aktif'),
('Gusti', 'Martapura', '2000-01-01', 'Laki - Laki', '', 'Aktif');

CREATE TABLE `kelas_siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_kelas_aktif INT NOT NULL,
    id_siswa INT NOT NULL,
    status VARCHAR(255) NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_kelas_aktif) REFERENCES kelas_aktif (id) ON DELETE CASCADE,
    FOREIGN KEY (id_siswa) REFERENCES siswa (id) ON DELETE CASCADE
);

CREATE TABLE `semester_kelas` (
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

CREATE TABLE `mata_pelajaran_kelas` (
    id INT NOT NULL AUTO_INCREMENT,
    id_kelas_aktif INT NOT NULL,
    id_mata_pelajaran INT NOT NULL,
    id_guru INT NOT NULL,
    kkm INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_kelas_aktif) REFERENCES kelas_aktif (id) ON DELETE CASCADE,
    FOREIGN KEY (id_mata_pelajaran) REFERENCES mata_pelajaran (id) ON DELETE CASCADE,
    FOREIGN KEY (id_guru) REFERENCES guru (id) ON DELETE CASCADE
);

CREATE TABLE `nilai_siswa` (
    id INT NOT NULL AUTO_INCREMENT,
    id_semester_kelas INT NOT NULL,
    id_mata_pelajaran_kelas INT NOT NULL,
    nilai INT NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (id_semester_kelas) REFERENCES semester_kelas (id) ON DELETE CASCADE,
    FOREIGN KEY (id_mata_pelajaran_kelas) REFERENCES mata_pelajaran_kelas (id) ON DELETE CASCADE
);
