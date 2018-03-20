CREATE DATABASE book_sc;

USE book_sc;

#创建用户表，设定用户ID为主键
CREATE TABLE customers(
customerid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(40) NOT NULL,
email VARCHAR(30) NOT NULL,
PASSWORD CHAR(30) NOT NULL
);

#创建订单表，订单包括用户ID和ORDERID，其中邮寄的地址要另行保存，因为可能不是邮寄到用户的地址。
CREATE TABLE orders(
orderid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
customerid INT UNSIGNED NOT NULL REFERENCES customers(customerid),
amount FLOAT(6,2),
DATE DATE NOT NULL,
ship_name CHAR(60) NOT NULL,
ship_address CHAR(60) NOT NULL,
ship_city CHAR(30) NOT NULL,
ship_state CHAR(20),
ship_zip CHAR(10),
ship_country CHAR(20) NOT NULL);

#创建书籍表
CREATE TABLE books(
isbn CHAR(13) NOT NULL PRIMARY KEY,
author CHAR(100),
title CHAR(100),
catid INT UNSIGNED,
price FLOAT(4,2) NOT NULL,
description VARCHAR(255)
);

#创建书记类别
CREATE TABLE categories(
catid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
catname CHAR(60) NOT NULL
);

#创建订单的物品表
CREATE TABLE order_items(
orderid INT UNSIGNED NOT NULL REFERENCES orders(orderid),
isbn CHAR NOT NULL REFERENCES books(isbn),
item_price FLOAT(4,2) NOT NULL,
quantity TINYINT UNSIGNED NOT NULL,
PRIMARY KEY (orderid,isbn)
);

#创建管理员表
CREATE TABLE admin(
username CHAR(16) NOT NULL PRIMARY KEY,
PASSWORD CHAR(40) NOT NULL);

#开通权限给book_sc，密码为password;
GRANT SELECT,INSERT,UPDATE,DELETE ON book_sc.* TO book_sc@localhost IDENTIFIED BY 'password';