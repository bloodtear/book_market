#创建收货地址
CREATE TABLE address(
ship_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
ship_person VARCHAR(20) NOT NULL,
ship_city VARCHAR(20) NOT NULL,
ship_district CHAR(20) NOT NULL,
ship_addr CHAR(30) NOT NULL,
ship_zip CHAR(6),
ship_tel CHAR(11) NOT NULL,
ship_tel2 CHAR(11),
ship_email CHAR(30)
);

#创建用户收货地址列表
CREATE TABLE user_addr_list(
customerid  INT UNSIGNED NOT NULL REFERENCES customers(customerid),
ship_id INT UNSIGNED REFERENCES address(ship_id),
is_default BOOLEAN
);