SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `RegistroEmbarcado` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `RegistroEmbarcado` ;

-- -----------------------------------------------------
-- Table `RegistroEmbarcado`.`caixa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `RegistroEmbarcado`.`caixa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NOT NULL,
  `numero_serie` INT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC),
  UNIQUE INDEX `numero_serie_UNIQUE` (`numero_serie` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RegistroEmbarcado`.`carrinho`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `RegistroEmbarcado`.`carrinho` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `numero_serie` INT NOT NULL,
  `nome` VARCHAR(45) NOT NULL,
  `ir` VARCHAR(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `nome_UNIQUE` (`nome` ASC),
  UNIQUE INDEX `ir_UNIQUE` (`ir` ASC),
  UNIQUE INDEX `numero_serie_UNIQUE` (`numero_serie` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RegistroEmbarcado`.`produto`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `RegistroEmbarcado`.`produto` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo_barras` VARCHAR(45) NOT NULL,
  `descricao` VARCHAR(100) NOT NULL,
  `valor` DECIMAL(10,2) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RegistroEmbarcado`.`compra`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `RegistroEmbarcado`.`compra` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `total` DECIMAL(10,2) NULL DEFAULT 0,
  `carrinho_id` INT NOT NULL,
  `caixa_id` INT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_compra_carrinho1_idx` (`carrinho_id` ASC),
  INDEX `fk_compra_caixa1_idx` (`caixa_id` ASC),
  UNIQUE INDEX `carrinho_id_UNIQUE` (`carrinho_id` ASC),
  UNIQUE INDEX `caixa_id_UNIQUE` (`caixa_id` ASC),
  CONSTRAINT `fk_compra_carrinho1`
    FOREIGN KEY (`carrinho_id`)
    REFERENCES `RegistroEmbarcado`.`carrinho` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_compra_caixa1`
    FOREIGN KEY (`caixa_id`)
    REFERENCES `RegistroEmbarcado`.`caixa` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RegistroEmbarcado`.`lote`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `RegistroEmbarcado`.`lote` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) NULL,
  `validade` DATE NULL,
  `produto_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_lote_produto1_idx` (`produto_id` ASC),
  CONSTRAINT `fk_lote_produto1`
    FOREIGN KEY (`produto_id`)
    REFERENCES `RegistroEmbarcado`.`produto` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RegistroEmbarcado`.`item`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `RegistroEmbarcado`.`item` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uid` VARCHAR(45) NOT NULL,
  `lote_id` INT NOT NULL,
  `compra_id` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `item_uid_UNIQUE` (`uid` ASC),
  INDEX `fk_item_compra1_idx` (`compra_id` ASC),
  INDEX `fk_item_lote1_idx` (`lote_id` ASC),
  CONSTRAINT `fk_item_compra1`
    FOREIGN KEY (`compra_id`)
    REFERENCES `RegistroEmbarcado`.`compra` (`id`)
    ON DELETE CASCADE
    ON UPDATE SET NULL,
  CONSTRAINT `fk_item_lote1`
    FOREIGN KEY (`lote_id`)
    REFERENCES `RegistroEmbarcado`.`lote` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RegistroEmbarcado`.`log`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `RegistroEmbarcado`.`log` (
  `id` INT NULL AUTO_INCREMENT,
  `evento` VARCHAR(200) NOT NULL,
  `data` DATETIME NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `RegistroEmbarcado`.`configuracao`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `RegistroEmbarcado`.`configuracao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `separador` VARCHAR(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `separador_UNIQUE` (`separador` ASC))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
USE `RegistroEmbarcado`;

DELIMITER $$
USE `RegistroEmbarcado`$$
CREATE TRIGGER calcular_total AFTER UPDATE ON item FOR EACH ROW
BEGIN
	UPDATE compra, item
	SET compra.total = (SELECT SUM(p.valor) 
						FROM produto p, lote l, item i
						WHERE l.id = i.lote_id
						AND p.id = l.produto_id
						AND i.compra_id = compra.id )
	WHERE compra.id = item.compra_id;
	IF (SELECT COUNT(*) FROM item WHERE compra_id = OLD.compra_id) = 0 
		THEN UPDATE compra SET compra.total = 0 WHERE compra.id = OLD.compra_id;
	END IF;
END
$$


DELIMITER ;
