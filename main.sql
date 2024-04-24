-- Create database if not exists
CREATE DATABASE IF NOT EXISTS sait_db_uts;

-- Use the database
USE sait_db_uts;

-- Create table mahasiswa
CREATE TABLE IF NOT EXISTS mahasiswa (
    nim VARCHAR(10) PRIMARY KEY,
    nama VARCHAR(20),
    alamat VARCHAR(40),
    tanggal_lahir DATE
);

-- Create table matakuliah
CREATE TABLE IF NOT EXISTS matakuliah (
    kode_mk VARCHAR(10) PRIMARY KEY,
    nama_mk VARCHAR(20),
    sks INT(2)
);

-- Create table perkuliahan
CREATE TABLE IF NOT EXISTS perkuliahan (
    id_perkuliahan INT(5) PRIMARY KEY AUTO_INCREMENT,
    nim VARCHAR(10),
    kode_mk VARCHAR(10),
    nilai DOUBLE,
    FOREIGN KEY (nim) REFERENCES mahasiswa(nim),
    FOREIGN KEY (kode_mk) REFERENCES matakuliah(kode_mk)
);

-- Insert data into mahasiswa table
INSERT INTO mahasiswa (nim, nama, alamat, tanggal_lahir)
VALUES
('sv_001', 'joko', 'bantul', '1999-12-07'),
('sv_002', 'paul', 'sleman', '2000-10-07'),
('sv_003', 'andy', 'surabaya', '2000-02-09');

-- Insert data into matakuliah table
INSERT INTO matakuliah (kode_mk, nama_mk, sks)
VALUES
('svpl_01', 'database', 2),
('svpl_02', 'kecerdasan artifial', 2),
('svpl_03', 'interoperabilitas', 2);

-- Insert data into perkuliahan table
INSERT INTO perkuliahan (id_perkuliahan, nim, kode_mk, nilai)
VALUES
(1, 'sv_001', 'svpl_01', 90),
(2, 'sv_001', 'svpl_02', 87),
(3, 'sv_001', 'svpl_03', 88),
(4, 'sv_002', 'svpl_01', 98),
(5, 'sv_002', 'svpl_02', 77);


-- Join mahasiswa, perkuliahan, dan matakuliah berdasarkan nim dan kode_mk
SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.alamat, matakuliah.nama_mk, perkuliahan.nilai
FROM mahasiswa
JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim
JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk;
