/*=================================================
 PONZI CHEME DATABASE
*/

CREATE DATABASE IF NOT EXISTS `ponzi`;

USE `ponzi`;
DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`(
	`id` INT(255) NOT NULL AUTO_INCREMENT,
	`fullname` VARCHAR(255) NOT NULL,
	`sex` VARCHAR(1) NOT NULL,
	`bank` VARCHAR(255) NOT NULL,
	`account_no` VARCHAR(10) NOT NULL,
	`account_name` VARCHAR(255) NOT NULL,
	`mail` TEXT NOT NULL,
	`phone` VARCHAR(11) NOT NULL,
	`password` VARCHAR(32) NOT NULL,
	`category` SMALLINT(1) DEFAULT 0,
	`active` SMALLINT(1) DEFAULT 0,
	`blocked` SMALLINT(1) DEFAULT 0,
	PRIMARY KEY(`id`)
);
DROP TABLE IF EXISTS `transaction`;
CREATE TABLE `transaction`(
	`id` INT(255) NOT NULL AUTO_INCREMENT,
	`payee_id` INT(255) NOT NULL,
	`payer_id` INT(255) NOT NULL,
	`matched` SMALLINT(1) NOT NULL,
	`status` SMALLINT(1) DEFAULT 0,
	`duration` VARCHAR(10) NOT NULL,
	PRIMARY KEY(`id`)
);
