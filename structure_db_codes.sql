-- MySQL Script generated by MySQL Workbench
-- Qua 06 Jan 2016 20:43:17 CET
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema codes
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `codes` ;

-- -----------------------------------------------------
-- Schema codes
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `codes` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `codes` ;

-- -----------------------------------------------------
-- Table `codes`.`User`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `codes`.`User` ;

CREATE TABLE IF NOT EXISTS `codes`.`User` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `username` VARCHAR(45) NOT NULL COMMENT '',
  `password` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `codes`.`UserLog`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `codes`.`UserLog` ;

CREATE TABLE IF NOT EXISTS `codes`.`UserLog` (
  `timestamp` VARCHAR(45) NOT NULL COMMENT '',
  `User_id` INT NOT NULL COMMENT '',
  INDEX `fk_table1_User_idx` (`User_id` ASC)  COMMENT '',
  PRIMARY KEY (`timestamp`, `User_id`)  COMMENT '',
  CONSTRAINT `fk_table1_User`
    FOREIGN KEY (`User_id`)
    REFERENCES `codes`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `codes`.`Logins`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `codes`.`Logins` ;

CREATE TABLE IF NOT EXISTS `codes`.`Logins` (
  `id` INT NOT NULL AUTO_INCREMENT COMMENT '',
  `username` VARCHAR(45) NULL COMMENT '',
  `password` VARCHAR(45) NOT NULL COMMENT '',
  `description` VARCHAR(100) NOT NULL COMMENT '',
  `link` VARCHAR(200) NULL COMMENT '',
  `User_id` INT NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_Logins_User1_idx` (`User_id` ASC)  COMMENT '',
  CONSTRAINT `fk_Logins_User1`
    FOREIGN KEY (`User_id`)
    REFERENCES `codes`.`User` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
