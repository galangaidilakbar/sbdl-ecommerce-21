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

INSERT INTO `accounts` (`id`, `username`, `password`, `email`) VALUES (1, 'test', '$2y$10$SfhYIDtn.iOuCW7zfoFLuuZHX6lja4lF4XA4JqNmpiH/.P3zB8JCa', 'test@test.com');

-- create view --
CREATE VIEW data_produk AS
SELECT `products`.`id`, `products`.`name`, `products`.`price`, `products`.`rrp`, `products`.`quantity`, `products`.`img`
FROM `products`;

SELECT * FROM `data_produk`;

-- Procedure Procs -- 
DELIMITER $$
CREATE PROCEDURE tampil_data_products(stokproduk INT(10))
BEGIN
SELECT `id`, `name`, `desc` FROM `products`
WHERE `quantity` = stokproduk;
END $$
DELIMITER $$

CALL `tampil_data_products` (7);

-- trigger -- 
DELIMITER $$
CREATE TRIGGER loghist_user_update
AFTER UPDATE ON `accounts` FOR EACH ROW
BEGIN
INSERT INTO `loghistaccounts` SET 
`nama_lama`=old.username,
`nama_baru`=new.username,
`passord_lama`=old.password,
`pasword_baru`=new.password,
`email_lama`=old.email,
`email_baru`=new.email,
`change_time`=NOW();
 END $$
DELIMITER;

UPDATE `accounts` SET username='kaka', PASSWORD='12345', email='kaka@gmail.com';

-- function --

DELIMITER $$
CREATE FUNCTION fc_produk(qtyproduk INT) RETURNS INT DETERMINISTIC
BEGIN
DECLARE quantity INT;
SELECT COUNT(id) AS jumlahproduk INTO quantity FROM products
WHERE quantity=qtyproduk;
RETURN quantity;
END$$
DELIMITER;  

SELECT fc_produk('7');
