-- Active: 1660975785440@@127.0.0.1@3306@projek_perpus

show tables;

desc tbl_login;

SELECT * FROM tbl_login;

update tbl_login SET foto = '-' WHERE id_login = 6;

show tables;

select * from tbl_pinjam where status = 'Dipinjam';

SELECT
    YEAR(tgl_bergabung) AS tahun
FROM tbl_login
WHERE level = 'Anggota'
ORDER BY tgl_bergabung ASC;

desc tbl_buku;

SELECT * FROM tbl_buku ORDER BY title;

desc tbl_rak;

select * from tbl_pinjam;

select * from tbl_biaya_denda;

select * from tbl_login;

update tbl_login SET email = 'root@mail.com' WHERE id_login= 1;

DELETE FROM tbl_login WHERE user = 'root';

select * from tbl_pinjam;

select curdate();

select SYSDATE();

SELECT DATE(CONVERT_TZ(NOW(), '+00:00', '+07:00'));

SELECT *
from tbl_pinjam
WHERE
    status = 'Dipinjam'
    AND tgl_kembali = 0
    AND DATE(
        CONVERT_TZ(NOW(), '+00:00', '+07:00')
    ) > tgl_balik;