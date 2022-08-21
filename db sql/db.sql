-- Active: 1660975785440@@127.0.0.1@3306@projek_perpus

ALTER Table tbl_login
ADD
    COLUMN kelas ENUM('', 'X', 'XI', 'XII') default '',
ADD
    COLUMN jurusan VARCHAR(100) NOT NULL DEFAULT '';

ALTER TABLE tbl_login MODIFY jurusan_id INT NOT NULL DEFAULT 1;

SELECT * FROM tbl_login;

DELETE FROM tbl_login;

CREATE Table
    jurusan(
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama_jurusan VARCHAR(200) NOT NULL
    ) engine = InnoDB;

insert into jurusan(nama_jurusan) values ('RPL1');

UPDATE tbl_login
SET kelas = 'X', jurusan_id = 1
WHERE level = 'Anggota';

SELECT * from tbl_login where level = 'Anggota';

SELECT * FROM tbl_login;

SELECT * from jurusan;

desc tbl_login;

select * FROM tbl_login;

ALTER TABLE tbl_login
ADD
    CONSTRAINT fk_anggota_jurusan FOREIGN KEY (jurusan_id) REFERENCES jurusan(id);

INSERT INTO
    `tbl_login` (
        `id_login`,
        `anggota_id`,
        `user`,
        `pass`,
        `level`,
        `nama`,
        `tempat_lahir`,
        `tgl_lahir`,
        `jenkel`,
        `alamat`,
        `telepon`,
        `email`,
        `tgl_bergabung`,
        `foto`
    )
VALUES (
        1,
        'AG001',
        'anang',
        '202cb962ac59075b964b07152d234b70',
        'Petugas',
        'Anang',
        'Bekasi',
        '1999-04-05',
        'Laki-Laki',
        'Ujung Harapan',
        '089618173609',
        'fauzan1892@codekop.com',
        '2019-11-20',
        'user_1567327491.png'
    ), (
        2,
        'AG002',
        'fauzan',
        '202cb962ac59075b964b07152d234b70',
        'Anggota',
        'Fauzan',
        'Bekasi',
        '1998-11-18',
        'Laki-Laki',
        'Bekasi Barat',
        '08123123185',
        'fauzanfalah21@gmail.com',
        '2019-11-21',
        'user_1589911243.png'
    );

UPDATE tbl_login SET jurusan_id = '';

show create TABLE tbl_login;

ALTER Table tbl_login
CHANGE jurusan_id jurusan VARCHAR(100) NOT NULL DEFAULT '';

DESC tbl_login;

select * from tbl_login;

