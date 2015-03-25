-- database
CREATE DATABASE group13 CHARACTER SET UTF8 COLLATE UTF8_GENERAL_CI;

USE group13;

-- group
CREATE TABLE `group`(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(32) NOT NULL UNIQUE,
    review INT UNSIGNED,
    PRIMARY KEY(id)
)ENGINE=MYISAM;

INSERT INTO `group`(name) VALUE('group1');

-- user
CREATE TABLE `user`(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(32) NOT NULL,
    lastname VARCHAR(32) NOT NULL,
    email VARCHAR(32) NOT NULL UNIQUE,
    `password` VARCHAR(32) NOT NULL,
    groupid INT UNSIGNED,
    role TINYINT NOT NULL DEFAULT 0 COMMENT '0:user 1:admin',
    PRIMARY KEY(id)
)ENGINE=MYISAM;

INSERT INTO `user`(firstname,lastname,email,`password`,groupid,role)
VALUE
('admin','','admin@example.com',MD5('123'),NULL,1),
('test','aa','test1@test.com',MD5('123'),1,0),
('test','bb','test2@test.com',MD5('123'),1,0);

-- report
CREATE TABLE report(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    groupid INT UNSIGNED NOT NULL,
    name VARCHAR(32) NOT NULL,
    url VARCHAR(100) NOT NULL,
    createtime INT UNSIGNED NOT NULL,
    authorid INT UNSIGNED NOT NULL,
    PRIMARY KEY(id)
)ENGINE=MYISAM;

-- comment
CREATE TABLE `comment`(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    userid INT UNSIGNED NOT NULL,
    reportid INT UNSIGNED NOT NULL,
    assessment INT UNSIGNED NOT NULL,
    content VARCHAR(140) NOT NULL,
    createtime INT UNSIGNED NOT NULL,
    PRIMARY KEY(id)
)ENGINE=MYISAM;
