CREATE DATABASE `tatvasoft`;

CREATE TABLE `tatvasoft`.`tblevent` ( `id` INT NOT NULL AUTO_INCREMENT , `title` VARCHAR(50) NOT NULL , `startdate` DATE NOT NULL , `enddate` DATE NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `tatvasoft`.`tbleventoccurrence` ( `id` INT NOT NULL AUTO_INCREMENT , `eventId` INT NOT NULL , `isEvery` BOOLEAN NOT NULL , `occurrenceValue` VARCHAR(15) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
