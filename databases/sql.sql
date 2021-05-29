CREATE DATABASE shoppingcart;
USE shoppingcart;

CREATE TABLE IF NOT EXISTS `products` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(200) NOT NULL,
	`desc` TEXT NOT NULL,
	`price` DECIMAL(7,2) NOT NULL,
	`rrp` DECIMAL(7,2) NOT NULL DEFAULT '0.00',
	`quantity` INT(11) NOT NULL,
	`img` TEXT NOT NULL,
	`date_added` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

INSERT INTO `products` (`id`, `name`, `desc`, `price`, `rrp`, `quantity`, `img`, `date_added`) VALUES
(1, 'Smart Watch', '<p>Unique watch made with stainless steel, ideal for those that prefer interative watches.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Powered by Android with built-in apps.</li>\r\n<li>Adjustable to fit most.</li>\r\n<li>Long battery life, continuous wear for up to 2 days.</li>\r\n<li>Lightweight design, comfort on your wrist.</li>\r\n</ul>', '29.99', '0.00', 10, 'watch.jpg', '2019-03-13 17:55:22'),
(2, 'Wallet', '', '14.99', '19.99', 34, 'wallet.jpg', '2019-03-13 18:52:49'),
(3, 'Headphones', '', '19.99', '0.00', 23, 'headphones.jpg', '2019-03-13 18:47:56'),
(4, 'Digital Camera', '', '69.99', '0.00', 7, 'camera.jpg', '2019-03-13 17:42:04');

CREATE TABLE IF NOT EXISTS `accounts` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

INSERT INTO `accounts` (`username`, `password`, `email`, `role`) VALUES ('fandi', '$2y$10$gfM5uiVqrq6yE/XUttuonuO2Z9prT6GoLzqMNpHLfXdteZj1BHqG2', 'galangaidil45@gmail.com', 'admin');


-- create view for select 4 the most recently added product
CREATE VIEW recently_added AS
SELECT `id`, `img`, `name`, `price`, `rrp` FROM products ORDER BY date_added DESC LIMIT 4;

-- memanggil view --
SELECT * FROM `recently_added`;

-- create stored procedure to menampilkan produk
DELIMITER $$
CREATE PROCEDURE tampilkan_produk (sp_id INT(11))
BEGIN 
	SELECT `img`, `name`, `price`, `rrp`, `quantity`, `id`, `desc`
	FROM `products`
	WHERE `id` = `sp_id`;
END $$
DELIMITER ;

-- memanggil stored procedure`tampilkan_produk`
-- call tampilkan_produk(parameternya);
-- drop procedure if exists `tampilkan_produk`;

-- create stored procedure to insert data product
DELIMITER $$
CREATE PROCEDURE insert_new_product(
	IN sp_id INT(11),
	IN sp_name VARCHAR(200),
	IN sp_desc TEXT,
	IN sp_price DECIMAL(7,2),
	IN sp_rrp DECIMAL(7,2),
	IN sp_quantity INT(11),
	IN sp_img TEXT,
	IN sp_date_added DATETIME
)
BEGIN
	INSERT INTO products VALUES (`sp_id`, `sp_name`, `sp_desc`, `sp_price`, `sp_rrp`, `sp_quantity`, `sp_img`, `sp_date_added`);
END $$
DELIMITER ;

-- create trigger when admin insert new product
CREATE TABLE IF NOT EXISTS `log_products`(
	`id_` INT(11),
	`name` VARCHAR(200),
	`kejadian` DATETIME,
	`keterangan` TEXT
);

DELIMITER $$
CREATE TRIGGER log_new_products
AFTER INSERT ON products
FOR EACH ROW
BEGIN
	INSERT INTO `log_products` VALUES (NEW.id, NEW.name, NOW(), "Inserting new product");
END $$
DELIMITER ;


SELECT * FROM log_products;

-- function untuk menghitung total produk

DELIMITER $$
CREATE FUNCTION count_total_product()
RETURNS INT(11)
DETERMINISTIC
BEGIN
	DECLARE total_product INT(11);
	SELECT COUNT(id) INTO total_product FROM products;
	RETURN total_product;
END $$
DELIMITER ;

SELECT count_total_product();

-- add column to table accounts

ALTER TABLE accounts
ADD `role` VARCHAR (100);

SELECT * FROM accounts;
SELECT * FROM products;
SELECT * FROM log_products;
SELECT * FROM orders;

-- create table order 
CREATE TABLE IF NOT EXISTS `orders`(
	orderID INT(11),
	productID INT(11),
	accountsID INT(11),
	date_created DATETIME,
	PRIMARY KEY (orderID),
	FOREIGN KEY (productID) REFERENCES products(id),
	FOREIGN KEY (accountsID) REFERENCES accounts(id)
);

SELECT * FROM `orders`;

INSERT INTO `orders` (productID, accountsID, date_created, jumlah)VALUES (3, 9, NOW(), 1);

ALTER TABLE `orders`
ADD COLUMN `jumlah` INT(11);

ALTER TABLE `orders`
MODIFY `orderID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `orders`
ADD COLUMN `total` DECIMAL(7,2) NOT NULL;

DELETE FROM log_products;

-- menampilkan nama produk, nama costumer, jumlah, dan harga berdasarkan orderID
SELECT products.`name`, accounts.`username`, `orders`.`jumlah`, products.`price`, orders.`total`
FROM `orders`
INNER JOIN products ON orders.`productID` = `products`.`id`
INNER JOIN accounts ON orders.`accountsID` = `accounts`.`id`;

-- add column verification code to accounts 
ALTER TABLE accounts
ADD COLUMN `code` INT(6);

-- add column active ke accounts
ALTER TABLE accounts
ADD COLUMN `active` INT(1) NOT NULL DEFAULT 0;

UPDATE `accounts` SET `active` = 1 WHERE `accounts`.`id` = 6;

SELECT * FROM accounts;

-- create view to show orders
CREATE VIEW orderan_masuk AS
SELECT products.`name`, accounts.`username`, `orders`.`jumlah`, products.`price`, orders.`total`
FROM `orders`
INNER JOIN products ON orders.`productID` = `products`.`id`
INNER JOIN accounts ON orders.`accountsID` = `accounts`.`id`;

-- create procedure to search products;
DELIMITER $$
CREATE PROCEDURE search_product (
	IN `nama_products` VARCHAR(200)
)
BEGIN
	SELECT products.`id`, products.`img`, products.`name`, products.`price`, products.`rrp` FROM products WHERE `name` LIKE CONCAT("%", `nama_products`, "%");
END $$
DELIMITER ;

-- drop the search_product
DROP PROCEDURE IF EXISTS search_product;

-- call it
CALL search_product("Macbook");
