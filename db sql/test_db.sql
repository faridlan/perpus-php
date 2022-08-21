-- Active: 1660975785440@@127.0.0.1@3306@projek_perpus_test

CREATE DATABASE projek_perpus_test;

CREATE TABLE
    login (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(100),
        password VARCHAR(100),
        level VARCHAR(100),
        biodata_id INT NOT NULL
    ) engine = innoDB;

ALTER TABLE login(
        ADD
            CONSTRAINT fk_login_biodata FOREIGN KEY (biodata_id) REFERENCES anggota(id),
            admin(id);

)
CREATE TABLE
    anggota (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        alamat VARCHAR(100),
        kelas ENUM('X', 'XI', 'XII'),
        jurusan VARCHAR(100)
    ) engine = innoDB;

CREATE TABLE
    admin (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        alamat VARCHAR(100)
    ) engine = innoDB;