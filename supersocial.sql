-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema supersocial
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `supersocial` ;

-- -----------------------------------------------------
-- Schema supersocial
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `supersocial` DEFAULT CHARACTER SET latin1 ;
USE `supersocial` ;

-- -----------------------------------------------------
-- Table `supersocial`.`user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`user` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `namadepan` VARCHAR(100) NOT NULL,
  `namabelakang` VARCHAR(100) NULL,
  `email` VARCHAR(100) NOT NULL,
  `nohp` VARCHAR(100) NOT NULL,
  `password` VARCHAR(100) NOT NULL,
  `alamat` VARCHAR(100) NOT NULL,
  `kodepos` VARCHAR(100) NULL,
  `negara` VARCHAR(100) NOT NULL,
  `jabatan` VARCHAR(100) NOT NULL,
  `perusahaan` VARCHAR(100) NOT NULL,
  `bioperusahaan` VARCHAR(100) NULL,
  `biouser` VARCHAR(100) NULL,
  `private` TINYINT(1) NOT NULL,
  `img` TEXT NULL,
  `music` TEXT NULL,
  `music_ori` TEXT NULL,
  `verified` TINYINT(1) NULL,
  `code_password` VARCHAR(20) NULL,
  `code_activation` VARCHAR(20) NULL,
  `active` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 10
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `supersocial`.`posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`posts` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`posts` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `isi` VARCHAR(100) NULL,
  `datetime` DATETIME NOT NULL,
  `timed` TINYINT(1) NULL,
  `img` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_post_user_idx` (`user_id` ASC),
  CONSTRAINT `fk_post_user`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`likes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`likes` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`likes` (
  `posts_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`posts_id`, `user_id`),
  INDEX `fk_post_has_user_user1_idx` (`user_id` ASC),
  INDEX `fk_post_has_user_post1_idx` (`posts_id` ASC),
  CONSTRAINT `fk_post_has_user_post1`
    FOREIGN KEY (`posts_id`)
    REFERENCES `supersocial`.`posts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_has_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`comments` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`comments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `posts_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `isi` VARCHAR(100) NULL,
  `datetime` DATETIME NOT NULL,
  INDEX `fk_post_has_user_user2_idx` (`user_id` ASC),
  INDEX `fk_post_has_user_post2_idx` (`posts_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_post_has_user_post2`
    FOREIGN KEY (`posts_id`)
    REFERENCES `supersocial`.`posts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_has_user_user2`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`friends`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`friends` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`friends` (
  `user_id1` INT NOT NULL,
  `user_id2` INT NOT NULL,
  `status` VARCHAR(100) NOT NULL,
  `datetime` DATETIME NOT NULL,
  PRIMARY KEY (`user_id1`, `user_id2`),
  INDEX `fk_user_has_user_user2_idx` (`user_id2` ASC),
  INDEX `fk_user_has_user_user1_idx` (`user_id1` ASC),
  CONSTRAINT `fk_user_has_user_user1`
    FOREIGN KEY (`user_id1`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_user_has_user_user2`
    FOREIGN KEY (`user_id2`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `supersocial`.`notification`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`notification` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`notification` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `msg` TEXT NOT NULL,
  `datetime` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_notification_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_notification_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`chat_rooms`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`chat_rooms` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`chat_rooms` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `private` TINYINT(1) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`message`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`message` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `chat_rooms_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `msg` LONGTEXT NULL,
  `datetime` DATETIME NOT NULL,
  `img` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_chat_user1_idx` (`user_id` ASC),
  INDEX `fk_message_chat_rooms1_idx` (`chat_rooms_id` ASC),
  CONSTRAINT `fk_chat_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_chat_rooms1`
    FOREIGN KEY (`chat_rooms_id`)
    REFERENCES `supersocial`.`chat_rooms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`message_deleted`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`message_deleted` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`message_deleted` (
  `message_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  INDEX `fk_message_deleted_message1_idx` (`message_id` ASC),
  INDEX `fk_message_deleted_user1_idx` (`user_id` ASC),
  PRIMARY KEY (`message_id`, `user_id`),
  CONSTRAINT `fk_message_deleted_message1`
    FOREIGN KEY (`message_id`)
    REFERENCES `supersocial`.`message` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_message_deleted_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`chat_rooms_participant`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`chat_rooms_participant` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`chat_rooms_participant` (
  `chat_rooms_id` INT NULL,
  `user_id` INT NOT NULL,
  `read` TINYINT(1) NOT NULL,
  `deleted` TINYINT(1) NOT NULL,
  `message_id_last` INT NOT NULL,
  INDEX `fk_chat_rooms_user_user1_idx` (`user_id` ASC),
  PRIMARY KEY (`chat_rooms_id`, `user_id`),
  INDEX `fk_chat_rooms_participant_chat_rooms1_idx` (`chat_rooms_id` ASC),
  CONSTRAINT `fk_chat_rooms_user_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_chat_rooms_participant_chat_rooms1`
    FOREIGN KEY (`chat_rooms_id`)
    REFERENCES `supersocial`.`chat_rooms` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`skill`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`skill` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`skill` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `nama` VARCHAR(45) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_skill_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_skill_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`skill_endorse`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`skill_endorse` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`skill_endorse` (
  `skill_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  INDEX `fk_skill_endorse_skill1_idx` (`skill_id` ASC),
  INDEX `fk_skill_endorse_user1_idx` (`user_id` ASC),
  PRIMARY KEY (`skill_id`, `user_id`),
  CONSTRAINT `fk_skill_endorse_skill1`
    FOREIGN KEY (`skill_id`)
    REFERENCES `supersocial`.`skill` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_skill_endorse_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`report`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`report` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`report` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id_reporter` INT NOT NULL,
  `user_id_reported` INT NOT NULL,
  `posts_id` INT NULL,
  `datetime` DATETIME NOT NULL,
  `done` TINYINT(1) NOT NULL,
  `reason` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_report_user1_idx` (`user_id_reporter` ASC),
  INDEX `fk_report_user2_idx` (`user_id_reported` ASC),
  INDEX `fk_report_posts1_idx` (`posts_id` ASC),
  CONSTRAINT `fk_report_user1`
    FOREIGN KEY (`user_id_reporter`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_report_user2`
    FOREIGN KEY (`user_id_reported`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_report_posts1`
    FOREIGN KEY (`posts_id`)
    REFERENCES `supersocial`.`posts` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`comments_reply`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`comments_reply` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`comments_reply` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `comments_id` INT NOT NULL,
  `isi` VARCHAR(100) NULL,
  `datetime` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_comments_reply_user1_idx` (`user_id` ASC),
  INDEX `fk_comments_reply_comments1_idx` (`comments_id` ASC),
  CONSTRAINT `fk_comments_reply_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_reply_comments1`
    FOREIGN KEY (`comments_id`)
    REFERENCES `supersocial`.`comments` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`verify_account`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`verify_account` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`verify_account` (
  `user_id` INT NOT NULL,
  `reason` TEXT NULL,
  `img` TEXT NULL,
  `done` TINYINT(1) NOT NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_verify_account_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_verify_account_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`group` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT NULL,
  `img` VARCHAR(45) NULL,
  `datetime` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pages_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_pages_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`group_member`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`group_member` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`group_member` (
  `user_id` INT NOT NULL,
  `group_id` INT NOT NULL,
  INDEX `fk_pages_like_pages1_idx` (`group_id` ASC),
  INDEX `fk_pages_like_user1_idx` (`user_id` ASC),
  PRIMARY KEY (`user_id`, `group_id`),
  CONSTRAINT `fk_pages_like_pages1`
    FOREIGN KEY (`group_id`)
    REFERENCES `supersocial`.`group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pages_like_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`posts_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`posts_group` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`posts_group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `isi` VARCHAR(100) NULL,
  `datetime` DATETIME NOT NULL,
  `img` TEXT NULL,
  `timed` TINYINT(1) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_posts_copy1_pages1_idx` (`group_id` ASC),
  INDEX `fk_posts_group_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_posts_copy1_pages1`
    FOREIGN KEY (`group_id`)
    REFERENCES `supersocial`.`group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_posts_group_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`comments_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`comments_group` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`comments_group` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `posts_group_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `isi` VARCHAR(100) NULL,
  `datetime` DATETIME NOT NULL,
  INDEX `fk_post_has_user_user2_idx` (`user_id` ASC),
  INDEX `fk_post_has_user_post2_idx` (`posts_group_id` ASC),
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_post_has_user_post20`
    FOREIGN KEY (`posts_group_id`)
    REFERENCES `supersocial`.`posts_group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_post_has_user_user20`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`likes_group`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`likes_group` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`likes_group` (
  `posts_group_id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `type` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`posts_group_id`),
  INDEX `fk_post_has_user_post1_idx` (`posts_group_id` ASC),
  INDEX `fk_likes_group_user1_idx` (`user_id` ASC),
  CONSTRAINT `fk_post_has_user_post10`
    FOREIGN KEY (`posts_group_id`)
    REFERENCES `supersocial`.`posts_group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_likes_group_user1`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `supersocial`.`comments_group_reply`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `supersocial`.`comments_group_reply` ;

CREATE TABLE IF NOT EXISTS `supersocial`.`comments_group_reply` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `comments_group_id` INT NOT NULL,
  `isi` VARCHAR(100) NULL,
  `datetime` DATETIME NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_comments_reply_user1_idx` (`user_id` ASC),
  INDEX `fk_comments_reply_comments1_idx` (`comments_group_id` ASC),
  CONSTRAINT `fk_comments_reply_user10`
    FOREIGN KEY (`user_id`)
    REFERENCES `supersocial`.`user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_comments_reply_comments10`
    FOREIGN KEY (`comments_group_id`)
    REFERENCES `supersocial`.`comments_group` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `supersocial`.`user`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (1, 'user1', 'nama1', 'a@a.coma', '1234561', 'aA$123456', 'alamat', '12345', 'ID', 'jabatan', 'perusahaan', 'bioperusahaan', 'biouser', 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (2, 'user2', 'nama2', 'a@a.comb', '1234562', 'aA$123456', 'alamat', '23456', 'ID', 'jabatan', 'perushanaa', NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (3, 'user3', 'nama3', 'a@a.comc', '1234563', 'aA$123456', 'alamat', '1234547', 'ID', 'jabatan', 'perusahaan', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (4, 'user4', 'nama4', 'a@a.comd', '1234564', 'aA$123456', 'alamat', '1234547', 'ID', 'jabatan', 'perusahaan', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (5, 'user5', 'nama5', 'a@a.come', '1234565', 'aA$123456', 'alamat', '1234547', 'ID', 'jabatan', 'perusahaan', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (6, 'user6', 'nama6', 'a@a.comf', '1234566', 'aA$123456', 'alamat', '1234547', 'ID', 'jabatan', 'perusahaan', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (7, 'user7', 'nama7', 'a@a.comg', '1234567', 'aA$123456', 'alamat', '1234547', 'ID', 'jabatan', 'perusahaan', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (8, 'user8', 'nama8', 'a@a.comh', '1234568', 'aA$123456', 'alamat', '1234547', 'ID', 'jabatan', 'perusahaan', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (9, 'user9', 'nama9', 'a@a.comj', '1234569', 'aA$123456', 'alamat', '1234547', 'ID', 'jabatan', 'perusahaan', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (10, 'user10', 'nama10', 'a@a.comk', '12345610', 'aA$123456', 'alamat', '1234547', 'ID', 'jabatan', 'perusahaan', NULL, NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, 1);
INSERT INTO `supersocial`.`user` (`id`, `namadepan`, `namabelakang`, `email`, `nohp`, `password`, `alamat`, `kodepos`, `negara`, `jabatan`, `perusahaan`, `bioperusahaan`, `biouser`, `private`, `img`, `music`, `music_ori`, `verified`, `code_password`, `code_activation`, `active`) VALUES (0, 'admin', 'admin', 'admin@admin.com', '0', 'admin', '', NULL, DEFAULT, DEFAULT, DEFAULT, NULL, NULL, 1, NULL, NULL, NULL, 1, NULL, NULL, 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`posts`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (1, 1, 'test', '2017-12-01', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (2, 1, 'test2', '2017-12-02', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (3, 2, 'test', '2017-12-03', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (4, 2, 'test3', '2017-12-04', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (5, 1, 'test4', '2017-12-09', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (6, 1, 'test5', '2017-12-03', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (7, 1, 'test6', '2017-12-08', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (8, 1, 'test7', '2017-12-05', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (9, 1, 'test8', '2017-12-20', 0, NULL);
INSERT INTO `supersocial`.`posts` (`id`, `user_id`, `isi`, `datetime`, `timed`, `img`) VALUES (10, 1, 'test9', '2017-12-12', 0, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`likes`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 1, 'like');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 2, 'love');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 3, 'funny');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 4, 'wow');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 5, 'sad');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 6, 'mad');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 7, 'love');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 8, 'funny');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 9, 'sad');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (1, 10, 'mad');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (2, 1, 'like');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (2, 2, 'like');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (2, 3, 'like');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (2, 4, 'like');
INSERT INTO `supersocial`.`likes` (`posts_id`, `user_id`, `type`) VALUES (2, 5, 'like');

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`comments`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (1, 1, 1, 'comment1', '1939-04-15');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (2, 1, 2, 'comment2', '1939-04-16');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (3, 1, 2, 'comment3', '1939-04-17');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (4, 1, 2, 'comment4', '1939-04-18');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (5, 1, 1, 'comment5', '1939-04-19');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (6, 1, 1, 'comment6', '1939-04-20');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (7, 1, 1, 'comment7', '1939-04-26');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (8, 1, 2, 'comment8', '1939-04-21');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (9, 1, 2, 'comment9', '1939-04-22');
INSERT INTO `supersocial`.`comments` (`id`, `posts_id`, `user_id`, `isi`, `datetime`) VALUES (10, 1, 2, 'comment10', '1939-04-27');

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`friends`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 2, 'friend', '1939-04-01');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 3, 'friend', '1939-04-02');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 4, 'blocked', '1939-04-03');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 5, 'request', '1939-04-04');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 6, 'request', '1939-04-05');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 7, 'request', '1939-04-16');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 8, 'blocked', '1939-04-12');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 9, 'request', '1939-04-19');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (1, 10, 'blocked', '1939-04-14');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (2, 6, 'friend', '1939-04-15');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (2, 3, 'friend', '1939-04-13');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (2, 4, 'blocked', '1939-04-14');
INSERT INTO `supersocial`.`friends` (`user_id1`, `user_id2`, `status`, `datetime`) VALUES (2, 5, 'friend', '1939-04-21');

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`notification`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (1, 1, 'notif test1', '1939-04-05');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (2, 1, 'notif test2', '1939-04-14');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (3, 1, 'notif test3', '1939-04-12');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (4, 1, 'notif test4', '1939-04-21');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (5, 1, 'notif test5', '1939-04-12');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (6, 1, 'notif test6', '1939-04-17');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (7, 1, 'notif test7', '1939-04-18');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (8, 1, 'notif test8', '1939-04-19');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (9, 1, 'notif test9', '1939-04-20');
INSERT INTO `supersocial`.`notification` (`id`, `user_id`, `msg`, `datetime`) VALUES (10, 1, 'notif test10', '1939-04-24');

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`chat_rooms`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (1, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (2, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (3, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (4, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (5, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (6, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (7, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (8, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (9, 0);
INSERT INTO `supersocial`.`chat_rooms` (`id`, `private`) VALUES (10, 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`message`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (1, 1, 1, 'test1', '1939-04-15', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (2, 1, 2, 'test2', '1939-04-16', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (3, 1, 1, 'test1', '1939-04-17', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (4, 1, 1, 'test4', '1939-04-18', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (5, 1, 2, 'test5', '1939-04-19', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (6, 1, 1, 'test6', '1939-04-12', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (7, 1, 2, 'test7', '1939-04-21', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (8, 1, 1, 'test8', '1939-04-20', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (9, 1, 2, 'test9', '1939-04-22', NULL);
INSERT INTO `supersocial`.`message` (`id`, `chat_rooms_id`, `user_id`, `msg`, `datetime`, `img`) VALUES (10, 1, 1, 'test10', '1939-04-23', NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`message_deleted`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (1, 1);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (1, 2);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (2, 1);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (2, 2);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (3, 1);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (3, 2);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (4, 1);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (4, 2);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (5, 1);
INSERT INTO `supersocial`.`message_deleted` (`message_id`, `user_id`) VALUES (5, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`chat_rooms_participant`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (1, 1, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (1, 2, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (2, 1, 1, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (2, 3, 1, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (3, 1, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (3, 2, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (3, 3, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (4, 2, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (4, 3, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (4, 4, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (5, 4, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (5, 5, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (6, 5, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (6, 6, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (7, 6, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (7, 7, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (8, 7, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (8, 8, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (9, 8, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (9, 9, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (10, 9, 0, 0, 0);
INSERT INTO `supersocial`.`chat_rooms_participant` (`chat_rooms_id`, `user_id`, `read`, `deleted`, `message_id_last`) VALUES (10, 10, 0, 0, 0);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`skill`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (1, 1, 'Skill1');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (2, 1, 'Skill2');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (3, 2, 'Skill1');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (4, 2, 'Skill2');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (5, 2, 'Skill3');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (6, 2, 'Skill4');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (7, 1, 'Skill3');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (8, 1, 'Skill4');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (9, 1, 'Skill5');
INSERT INTO `supersocial`.`skill` (`id`, `user_id`, `nama`) VALUES (10, 2, 'Skill5');

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`skill_endorse`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 2);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 3);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 4);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 5);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 6);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 7);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 8);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 9);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (1, 10);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (2, 2);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (2, 3);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (2, 4);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (2, 5);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (2, 6);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (2, 7);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (2, 8);
INSERT INTO `supersocial`.`skill_endorse` (`skill_id`, `user_id`) VALUES (2, 9);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`report`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`report` (`id`, `user_id_reporter`, `user_id_reported`, `posts_id`, `datetime`, `done`, `reason`) VALUES (1, 1, 2, NULL, '2017-12-01', 0, 'asdf');
INSERT INTO `supersocial`.`report` (`id`, `user_id_reporter`, `user_id_reported`, `posts_id`, `datetime`, `done`, `reason`) VALUES (2, 1, 3, NULL, '2017-12-02', 0, 'fdafwet');

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`comments_reply`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`comments_reply` (`id`, `user_id`, `comments_id`, `isi`, `datetime`) VALUES (1, 1, 1, 'test', 'now');
INSERT INTO `supersocial`.`comments_reply` (`id`, `user_id`, `comments_id`, `isi`, `datetime`) VALUES (2, 1, 1, 'test1', 'now');

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`group`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`group` (`id`, `user_id`, `name`, `description`, `img`, `datetime`) VALUES (1, 1, 'GROUP TEST1', 'TEST DESKRIPSI1', NULL, DEFAULT);
INSERT INTO `supersocial`.`group` (`id`, `user_id`, `name`, `description`, `img`, `datetime`) VALUES (2, 1, 'GROUP TEST2', 'TEST DESKRIPSI2', NULL, DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`group_member`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`group_member` (`user_id`, `group_id`) VALUES (1, 1);
INSERT INTO `supersocial`.`group_member` (`user_id`, `group_id`) VALUES (1, 2);
INSERT INTO `supersocial`.`group_member` (`user_id`, `group_id`) VALUES (2, 1);
INSERT INTO `supersocial`.`group_member` (`user_id`, `group_id`) VALUES (2, 2);
INSERT INTO `supersocial`.`group_member` (`user_id`, `group_id`) VALUES (3, 1);
INSERT INTO `supersocial`.`group_member` (`user_id`, `group_id`) VALUES (4, 2);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`posts_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`posts_group` (`id`, `group_id`, `user_id`, `isi`, `datetime`, `img`, `timed`) VALUES (1, 1, 1, 'TEST POST GROUP 1', DEFAULT, NULL, NULL);
INSERT INTO `supersocial`.`posts_group` (`id`, `group_id`, `user_id`, `isi`, `datetime`, `img`, `timed`) VALUES (2, 1, 1, 'TEST POST GROUP2', DEFAULT, NULL, NULL);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`comments_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`comments_group` (`id`, `posts_group_id`, `user_id`, `isi`, `datetime`) VALUES (1, 1, 1, 'TEST COMMENT 1', DEFAULT);
INSERT INTO `supersocial`.`comments_group` (`id`, `posts_group_id`, `user_id`, `isi`, `datetime`) VALUES (2, 1, 1, 'TEST COMMENT 2', DEFAULT);

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`likes_group`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`likes_group` (`posts_group_id`, `user_id`, `type`) VALUES (1, 1, 'like');

COMMIT;


-- -----------------------------------------------------
-- Data for table `supersocial`.`comments_group_reply`
-- -----------------------------------------------------
START TRANSACTION;
USE `supersocial`;
INSERT INTO `supersocial`.`comments_group_reply` (`id`, `user_id`, `comments_group_id`, `isi`, `datetime`) VALUES (1, 1, 1, 'TEST REPLY COMMENT1', DEFAULT);

COMMIT;

