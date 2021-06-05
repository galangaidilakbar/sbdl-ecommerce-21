-- fisrt we need to create database, in this case, we create database named shoppingcart
CREATE DATABASE shoppingcart;
-- then we use the shoppingcart database
USE shoppingcart;

-- create user yuda with all privileges
CREATE USER 'yuda'@'localhost' IDENTIFIED BY 'tes123';
GRANT ALL PRIVILEGES ON * . * TO 'yuda'@'localhost';

-- create table products
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

-- create table accounts
CREATE TABLE IF NOT EXISTS `accounts` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
	`role` VARCHAR (100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- create table `log_products` 
-- this table use to see what products that inserted, and when.
CREATE TABLE IF NOT EXISTS `log_products`(
	`id_` INT(11),
	`name` VARCHAR(200),
	`kejadian` DATETIME,
	`keterangan` TEXT
);

-- create table orders
CREATE TABLE IF NOT EXISTS `orders`(
	orderID INT(11) NOT NULL AUTO_INCREMENT,
	productID INT(11) NOT NULL,
	accountsID INT(11) NOT NULL,
	date_created DATETIME,
	`jumlah` INT(11) NOT NULL,
	`total` DECIMAL(7,2) NOT NULL
	PRIMARY KEY (orderID),
	FOREIGN KEY (productID) REFERENCES products(id),
	FOREIGN KEY (accountsID) REFERENCES accounts(id)
);

-- create table `log_update_products`
-- this table use to see what product that admin updates
CREATE TABLE IF NOT EXISTS `log_update_products`(
	`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`productID` INT(11) NOT NULL, 
	`oldName` VARCHAR(200) NOT NULL,
	`newName` VARCHAR(200) NOT NULL,
	`oldPrice` DECIMAL(7,2) NOT NULL,
  `newPrice` DECIMAL(7,2) NOT NULL,
	`oldQuantity` INT(11) NOT NULL,
  `newQuantity` INT(11) NOT NULL,
	`oldImg` TEXT NOT NULL,
	`newImg` TEXT NOT NULL,
	`changeAt` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


-- create view for select 4 the most recently added product
-- this view will we use in home.php
CREATE VIEW recently_added AS
SELECT `id`, `img`, `name`, `price`, `rrp` FROM products ORDER BY date_added DESC LIMIT 4;

-- create view to show incoming orders
-- this view will we use in admin/orders.php
CREATE VIEW orderan_masuk AS
SELECT products.`name`, accounts.`username`, `orders`.`jumlah`, products.`price`, orders.`total`
FROM `orders`
INNER JOIN products ON orders.`productID` = `products`.`id`
INNER JOIN accounts ON orders.`accountsID` = `accounts`.`id`;

-- create stored procedure to menampilkan produk bases on id product.
-- this stored procedure will we use in product.php
DELIMITER $$
CREATE PROCEDURE tampilkan_produk (sp_id INT(11))
BEGIN 
	SELECT `img`, `name`, `price`, `rrp`, `quantity`, `id`, `desc`
	FROM `products`
	WHERE `id` = `sp_id`;
END $$
DELIMITER ;

-- create stored procedure to insert new product
-- this stored procedure will we use in admin/create.php
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

-- create stored procedure to update products
-- this stored procedure will we use in admin/update.php
DELIMITER $$
CREATE PROCEDURE update_product(
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
	UPDATE products SET `name`=`sp_name`, `desc`=`sp_desc`, `price`=`sp_price`, `rrp`=`sp_rrp`, 
	`quantity`=`sp_quantity`, `img`=`sp_img`, `date_added`=`sp_date_added` WHERE `id`=`sp_id`;
END $$
DELIMITER ;

-- create procedure to search products;
-- this store procedure will we use in function : template_header()
DELIMITER $$
CREATE PROCEDURE search_product (
	IN `nama_products` VARCHAR(200)
)
BEGIN
	SELECT products.`id`, products.`img`, products.`name`, products.`price`, products.`rrp` FROM products WHERE `name` LIKE CONCAT("%", `nama_products`, "%");
END $$
DELIMITER ;

-- create trigger when admin insert new product
-- when admin inserting new products, this trigger will insert data product to `log_products`
DELIMITER $$
CREATE TRIGGER log_new_products
AFTER INSERT ON products
FOR EACH ROW
BEGIN
	INSERT INTO `log_products` VALUES (NEW.id, NEW.name, NOW(), "Inserting new product");
END $$
DELIMITER ;

-- create trigger after admin update product
-- the trigger bases on price
DELIMITER $$
CREATE TRIGGER update_product
AFTER UPDATE ON products
FOR EACH ROW
BEGIN
	IF OLD.price <> NEW.price THEN
	INSERT INTO `log_update_products`(productID, oldName, newName, oldPrice, newPrice, oldQuantity, newQuantity, oldImg, newImg)
	VALUES (old.id, old.name, new.name, old.price, new.price, old.quantity, new.quantity, old.img, new.img);
	END IF;
END $$
DELIMITER ;

-- create trigger when admin delete the product
DELIMITER $$
CREATE TRIGGER log_delete_products
AFTER DELETE ON products
FOR EACH ROW
BEGIN
	INSERT INTO `log_products` VALUES (OLD.id, OLD.name, SYSDATE(), "Deleting product");
END $$
DELIMITER ;

-- function to count total product
-- this function will we use in functions.php in root, products.php, admin/index.php
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

-- try to inserting some values to table products
INSERT INTO `products` (`id`, `name`, `desc`, `price`, `rrp`, `quantity`, `img`, `date_added`) VALUES
(1, 'Smart Watch', '<p>Unique watch made with stainless steel, ideal for those that prefer interative watches.</p>\r\n<h3>Features</h3>\r\n<ul>\r\n<li>Powered by Android with built-in apps.</li>\r\n<li>Adjustable to fit most.</li>\r\n<li>Long battery life, continuous wear for up to 2 days.</li>\r\n<li>Lightweight design, comfort on your wrist.</li>\r\n</ul>', '29.99', '0.00', 10, 'watch.jpg', '2019-03-13 17:55:22'),
(2, 'Wallet', '', '14.99', '19.99', 34, 'wallet.jpg', '2019-03-13 18:52:49'),
(3, 'Headphones', '', '19.99', '0.00', 23, 'headphones.jpg', '2019-03-13 18:47:56'),
(4, 'Digital Camera', '', '69.99', '0.00', 7, 'camera.jpg', '2019-03-13 17:42:04');

-- try to insert some values to table accounts
-- because we do not want to expose the password in our database, we use password_hash in the column `password`
-- role has two values: admin, and costumer. each values determine where the user will go. role with admin values will go to admin pages, and role with costumes values will go to home pages.
INSERT INTO `accounts` (`username`, `password`, `email`, `role`) VALUES ('YourName', '$2y$10$gfM5uiVqrq6yE/XUttuonuO2Z9prT6GoLzqMNpHLfXdteZj1BHqG2', 'test@example', 'admin');

-- how to call the view `recently_added`
SELECT * FROM `recently_added`;

-- how to call the view `orderan_masuk`
SELECT * FROM `orderan_masuk`;

-- How to call stored procedure`tampilkan_produk`
CALL tampilkan_produk(parameter);

-- how to call stored procedure `insert_new_product`
-- ? = param
CALL insert_new_product(?,?,?,?,?,?,?,?);

-- how to see log update product
SELECT * FROM log_update_products;

-- how to call the stored procedure search_product
CALL search_product("Macbook");

-- how to drop stored procedure `tampilkan_produk`
-- if you want to edit the stored procedure, you have to drop the stored procedure first, then edit it
DROP PROCEDURE IF EXISTS `tampilkan_produk`;

-- how to drop stored procedure `insert_new_product`
-- if you want to edit the stored procedure, feel free to drop the stored procedure first, then edit it
DROP PROCEDURE IF EXISTS `insert_new_product`;

-- how to drop stored procedure `search_product`
DROP PROCEDURE IF EXISTS search_product;

-- how to call the function count_total_product()
SELECT count_total_product();

-- see data that admin inserting into table products in table log_products
SELECT * FROM log_products;