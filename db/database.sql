DROP DATABASE IF EXISTS `db_e_rapot`;
CREATE DATABASE `db_e_rapot`;
USE `db_e_rapot`;

CREATE TABLE `user` (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO `user` (
    username,
    password
) VALUES 
('admin', 'admin');

CREATE TABLE `guru` (
    id INT NOT NULL AUTO_INCREMENT,
    nip VARCHAR(255) NOT NULL UNIQUE,
    nama VARCHAR(255) NOT NULL,
    tempat_lahir VARCHAR(255) NOT NULL,
    tanggal_lahir DATE NOT NULL,
    jenis_kelamin VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO `guru` (
    nip,
    nama,
    tempat_lahir,
    tanggal_lahir,
    jenis_kelamin,
    foto
) VALUES 
('1', 'Nurcholis', 'Martapura', '2000-01-01', 'Laki - Laki', ''),
('2', 'Habibi', 'Martapura', '2000-01-01', 'Laki - Laki', ''),
('3', 'Arif', 'Martapura', '2000-01-01', 'Laki - Laki', '');

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
('1', 1),
('2', 2),
('3', 3);

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
('1', 1),
('2', 2);

CREATE TABLE `mata_pelajaran` (
    id INT NOT NULL AUTO_INCREMENT,
    nama VARCHAR(255) NOT NULL,
    kkn INT NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO `mata_pelajaran` (
    nama
) VALUES 
('Matematika', 75),
('Bahasa Indonesia', 65),
('Bahasa Inggris', 80);

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
    nis VARCHAR(255) NOT NULL,
    nisn VARCHAR(255) NOT NULL,
    nama VARCHAR(255) NOT NULL,
    tempat_lahir VARCHAR(255) NOT NULL,
    tanggal_lahir VARCHAR(255) NOT NULL,
    jenis_kelamin VARCHAR(255) NOT NULL,
    agama VARCHAR(255) NOT NULL,
    alamat TEXT NOT NULL,
    nama_ayah VARCHAR(255),
    pekerjaan_ayah VARCHAR(255),
    nama_ibu VARCHAR(255),
    pekerjaan_ibu VARCHAR(255),
    foto VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO `siswa` (
    nis,
    nisn,
    nama,
    tempat_lahir,
    tanggal_lahir,
    jenis_kelamin,
    agama,
    alamat,
    nama_ayah,
    pekerjaan_ayah,
    nama_ibu,
    pekerjaan_ibu,
    foto,
    status
) VALUES 
('131262130001160477', '3066683363', 'AHMAD ALGI PARI', 'Ampah', '2006-03-16', 'Laki - Laki', 'Islam', 'Ampah Rt.09 Rw.03', 'SUWAJI', 'ASMIAH', 'Wiraswasta', 'IRT', '', 'Aktif'),
('131262130001160478', '0068438164', 'AHMAD AZHARI', 'Ampah', '2006-01-12', 'Laki - Laki', 'Islam', 'Ampah Kota Rt.024 Rw.008', 'JUPRIANTO', 'ASNANI', 'PNS', 'IRT', '', 'Aktif'),
('131262130001160479', '0052588832', 'ATIKA ROHIMAH', 'Ampah', '2006-08-30', 'Perempuan', 'Islam', 'Jl. Talohen Rt.025', 'SURIANI', 'SITI RODIAH', 'Petani', 'IRT', '', 'Aktif');

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
