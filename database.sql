-- -----------------------------------------------------
-- Schema setup
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `cool-page-setup` ;

CREATE SCHEMA IF NOT EXISTS `cool-page-setup` DEFAULT CHARACTER SET utf8 ;
USE `cool-page-setup` ;


-- -----------------------------------------------------
-- Table `cool-page-setup`.`example`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `cool-page-setup`.`example`;

CREATE TABLE IF NOT EXISTS `cool-page-setup`.`example`
(
    `id`        INT             AUTO_INCREMENT, 
    `content`   VARCHAR(64)     NULL,

    PRIMARY KEY (`id`)
)
ENGINE = InnoDB;

