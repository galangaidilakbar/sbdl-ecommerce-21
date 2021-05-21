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

INSERT INTO `accounts` (`username`, `password`, `email`) VALUES ('Galang', '$2y$10$gfM5uiVqrq6yE/XUttuonuO2Z9prT6GoLzqMNpHLfXdteZj1BHqG2', 'galangaidil45@gmail.com');


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
-- call tampilkan_produk(param);
-- drop procedure if exists `tampilkan_produk`;