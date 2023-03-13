INSERT INTO `db_e_rapot`.`user` (
    username,
    password
) VALUES 
('admin', 'admin');

INSERT INTO `db_e_rapot`.`guru` (
    nip,
    nama,
    jabatan,
    tempat_lahir,
    tanggal_lahir,
    jenis_kelamin,
    foto
) VALUES 
('196910291995031002', 'Rusmiansyah, S.Pd', 'Kepala Sekolah', 'Martapura', '1969-10-29', 'Laki - Laki', ''),
('197610132005011010', 'Zakaria, S.E', 'Wali Kelas', 'Martapura', '1976-10-13', 'Laki - Laki', ''),
('197207132006041003', 'Agung Basuki, S.Pd', 'Wali Kelas', 'Martapura', '1972-07-13', 'Laki - Laki', ''),
('196209102006041007', 'Drs.Mulyani', 'Guru', 'Martapura', '1962-09-10', 'Laki - Laki', ''),
('197602272006041015', 'Nurkhabib, S.Ag', 'Guru', 'Martapura', '1976-02-27', 'Laki - Laki', ''),
('198011142008021001', 'Suradi,S.Pd', 'Guru', 'Martapura', '1980-11-14', 'Laki - Laki', ''),
('197909202009032002', 'Sri Pujiastuti, S.Pd', 'Guru', 'Martapura', '1979-09-20', 'Perempuan', ''),
('198304212009032005', 'Sisetyowati, S.Pd', 'Guru', 'Martapura', '1983-04-21', 'Perempuan', ''),
('198308282009032005', 'Noorafni, S.Pd', 'Guru', 'Martapura', '1983-08-28', 'Perempuan', ''),
('198405152009031003', 'M. Muammar,SP', 'Guru', 'Martapura', '1984-05-15', 'Laki - Laki', '');

INSERT INTO `db_e_rapot`.`kelas` (
    nama,
    tingkat
) VALUES 
('VII', 1),
('VIII', 2),
('IX', 3);

INSERT INTO `db_e_rapot`.`semester` (
    nama,
    tingkat
) VALUES 
('1', 1),
('2', 2);

INSERT INTO `db_e_rapot`.`mata_pelajaran` (
    id, 
    nama, 
    kkm
) VALUES
(1, "Al Qur'an Hadits", 65),
(2, 'Akidah Akhlak', 65),
(3, 'Fiqih', 65),
(4, 'Sejarah Kebudayaan Islam', 65),
(5, 'Bahasa Arab', 65),
(6, 'Pendidikan Pancasila dan Kewarganegaraan', 65),
(7, 'Bahasa Indonesia', 65),
(8, 'Matematika', 65),
(9, 'Sejarah Indonesia', 65),
(10, 'Bahasa Inggris', 65),
(11, 'Seni Budaya', 65),
(12, 'Pendidikan Jasmani, Olah Raga dan Kesehatan', 65),
(13, 'Prakarya dan Kewirausahaan', 65),
(14, 'Geografi', 65),
(15, 'Sejarah', 65),
(16, 'Sosiologi', 65),
(17, 'Ekonomi', 65),
(18, 'Kimia', 65),
(19, 'Informatika', 65);

INSERT INTO `db_e_rapot`.`siswa` (
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
('131262130001160479', '0052588832', 'ATIKA ROHIMAH', 'Ampah', '2006-08-30', 'Perempuan', 'Islam', 'Jl. Talohen Rt.025', 'SURIANI', 'SITI RODIAH', 'Petani', 'IRT', '', 'Aktif'),
('131262130001160480', '0063928201', 'AULIA RAHMA', 'Wakatitir', '2006-08-26', 'Perempuan', 'Islam', 'Wakatitir Rt.30 Rw.10', 'ARIADI', 'ERPAH', 'Petani', 'IRT', '', 'Aktif'),
('131262130001160481', '0051753148', 'BAHTIAR', 'Ampah', '2005-12-31', 'Laki - Laki', 'Islam', 'Lenggang Rt.02 Rw.01', 'RAHMAT', 'JUBAIDAH', 'Petani', 'IRT', '', 'Aktif'),
('131262130001160482', '0068926361', 'ELZA MUTHIA', 'Ampah', '2006-03-26', 'Perempuan', 'Islam', 'Putai Rt.08', 'IWAN SULIONO', 'HADLIANI', 'PNS', 'IRT', '', 'Aktif'),
('131262130001160483', '0071958774', 'FAISAL REZA FIRMANSYAH', 'Marga Jaya', '2007-05-11', 'Laki - Laki', 'Islam', 'Desa Marga Jaya Rt.04 Rw.02', 'MASIRUN', 'KOMARIYAH', 'Petani', 'IRT', '', 'Aktif'),
('131262130001160484', '0055687803', 'HADIJAH', 'Putai', '2005-12-05', 'Perempuan', 'Islam', 'Jl. Nagaleah Rt.03', 'TAMRIN', 'DAYANG', 'Petani', 'Petani', '', 'Aktif'),
('131262130001160485', '3041657135', 'HAMIDI RAHMAN', 'Kelua', '2004-12-04', 'Laki - Laki', 'Islam', 'Jl. R. Sosilo Rt.04', 'HADRI', 'HILDA', 'Wiraswasta', 'IRT', '', 'Aktif');
