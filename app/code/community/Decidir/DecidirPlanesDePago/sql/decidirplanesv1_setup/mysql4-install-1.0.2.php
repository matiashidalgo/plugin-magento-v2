<?php
$installer = $this;
$installer->startSetup();

$prefix = Mage::getConfig()->getTablePrefix();
$sql=<<<SQLTEXT
CREATE TABLE IF NOT EXISTS {$prefix}decidir_banco (
	banco_id INT(11) NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(100) NOT NULL,
	activo VARCHAR(3) NOT NULL,
	PRIMARY KEY (banco_id)
);

INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Argencard", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Ciudad", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Comafi", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco de La Pampa", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Galicia", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Hipotecario", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Industrial", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Itaú", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Macro", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Nacion", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Patagonia", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Provincia", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco San Juan", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Santa Cruz", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Santander Rio", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Banco Supervielle", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("BBVA Frances", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Citibank", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Diners", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("HSBC", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("ICBC", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Naranja", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Nativa Mastercard", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Nuevo Banco de Entre Rios", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Nuevo Banco de Santa Fe", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Provencred", 0);
INSERT INTO  {$prefix}decidir_banco (nombre, activo) VALUES ("Tarjeta Shopping", 0);


CREATE TABLE IF NOT EXISTS {$prefix}decidir_tarjeta (
	tarjeta_id INT(11) NOT NULL AUTO_INCREMENT,
	nombre VARCHAR(50) NOT NULL,
	clave INT(11) NOT NULL,
	activo VARCHAR(3) NOT NULL,
        tipo INT(11) NOT NULL DEFAULT '1',
   PRIMARY KEY (tarjeta_id)
);

INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (1, "Visa", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (8, "Diners", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (15, "MasterCard", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (22, "Naranja", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (23, "Tarjeta Shopping", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (25, "PagoFacil", 0, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (26, "RapiPago", 0, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (27, "Cabal", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (29, "Italcred", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (30, "ArgenCard", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (31, "Visa Débito", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (34, "CoopePlus", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (37, "Nexo", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (38, "Credimás", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (39, "Nevada", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (42, "Nativa", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (43, "Tarjeta Cencosud", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (44, "Tarjeta Carrefour / Cetelem", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (45, "Tarjeta PymeNacion", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (48, "Caja de Pagos", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (50, "BBPS", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (51, "Cobro Express", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (52, "Qida", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (54, "Grupar", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (55, "Patagonia 365", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (56, "Tarjeta Club Día", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (59, "Tuya", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (60, "Distribution", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (61, "Tarjeta La Anónima", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (62, "CrediGuia", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (64, "Tarjeta SOL", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (65, "Amex", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (66, "MasterCard Debit", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (67, "Cabal Débito", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (99, "Maestro", 1, 0);
INSERT INTO  {$prefix}decidir_tarjeta (clave, nombre, tipo, activo) VALUES (103, "Favacard", 1, 0);



CREATE TABLE IF NOT EXISTS {$prefix}decidir_plan (
	plan_id INT(11) NOT NULL AUTO_INCREMENT,
	banco_id INT(11) NOT NULL,
	activo VARCHAR(3) NOT NULL,
	tarjeta_id INT(11) NOT NULL,
	cuotas INT(11) NOT NULL,
	porcentaje DOUBLE NOT NULL,
	store_id INT(11) NOT NULL,
  cupon_tarjeta INT(11) NULL DEFAULT NULL,
	nro_comercio VARCHAR(8) NULL DEFAULT NULL,
	nro_comercio_test VARCHAR(8) NULL DEFAULT NULL,
	PRIMARY KEY (plan_id),
	UNIQUE INDEX plan_id_banco_id_tarjeta_id (cuotas, banco_id, tarjeta_id, store_id)
);


# INSERT INTO `{$prefix}permission_block` (`block_name`, `is_allowed`) VALUES ('decidirplanesv1/adminhtml_banco', '1');
# INSERT INTO `{$prefix}permission_block` (`block_name`, `is_allowed`) VALUES ('decidirplanesv1/adminhtml_tarjeta', '1');
# INSERT INTO `{$prefix}permission_block` (`block_name`, `is_allowed`) VALUES ('decidirplanesv1/adminhtml_plan', '1');


ALTER TABLE `{$prefix}decidir_tarjeta`
MODIFY COLUMN `tarjeta_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT;

CREATE TABLE IF NOT EXISTS `{$prefix}decidir_interes` (
					  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
					  `cuotas` TINYINT NOT NULL,
					  `tarjeta_id` INT(11) UNSIGNED NOT NULL,
					  `coeficiente` FLOAT NOT NULL,
					  `activo` TINYINT NOT NULL,
					  PRIMARY KEY (`id`),
						FOREIGN KEY (`tarjeta_id`) REFERENCES  `{$prefix}decidir_tarjeta` (`tarjeta_id`),
					  UNIQUE INDEX `INSTALLMENT_TARJETA` (`cuotas` ASC, `tarjeta_id` ASC)
					)
          ENGINE=InnoDB;


		  # Insert rows en interes
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(2,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.0589, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(3,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.0799, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(4,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.1012, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(5,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.1228, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(6,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.1447, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(7,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.1774, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(8,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.2013, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(9,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.2255, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(10,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.2500, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(11,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.2748, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(12,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 1), 1.2999, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(2,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.0540, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(3,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.0733, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(4,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.0928, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(5,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.1126, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(6,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.1325, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(7,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.1633, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(8,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.1852, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(9,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.2073, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(10,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.2297, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(11,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.2524, 1);
		  INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(12,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 15), 1.2753, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(2,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.0555, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(3,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.0753, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(4,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.0953, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(5,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.1156, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(6,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.1362, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(7,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.1750, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(8,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.1985, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(9,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.2224, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(10,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.2465, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(11,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.2710, 1);
		  #INSERT INTO `{$prefix}decidir_interes` (cuotas, tarjeta_id, coeficiente, activo) VALUES(12,(SELECT tarjeta_id FROM {$prefix}decidir_tarjeta WHERE clave = 65), 1.2957, 1);


         ALTER TABLE `{$prefix}decidir_plan`
 ADD COLUMN `nombre` VARCHAR(20) NOT NULL AFTER `plan_id`,
 ADD COLUMN `cuotas_a_enviar` TINYINT NULL AFTER `cuotas`,
 ADD COLUMN `idplan` TINYINT NULL DEFAULT NULL,
 ADD COLUMN `descuento` DOUBLE NULL AFTER `interes`,
 ADD COLUMN `reintegro` DOUBLE NULL AFTER `descuento`,
 ADD COLUMN `dias_semana` TINYINT NOT NULL AFTER `reintegro`,
 ADD COLUMN `desde` DATE NULL AFTER `dias_semana`,
 ADD COLUMN `hasta` DATE NULL AFTER `desde`,
 CHANGE COLUMN `tarjeta_id` `tarjeta_id` INT(11) NOT NULL AFTER `nombre`,
 CHANGE COLUMN `cupon_tarjeta` `cupon_tarjeta` INT(11) NULL DEFAULT NULL AFTER `nro_comercio_test`,
 CHANGE COLUMN `activo` `activo` VARCHAR(3) NOT NULL AFTER `cupon_tarjeta`,
 CHANGE COLUMN `store_id` `store_id` INT(11) NOT NULL AFTER `activo`,
 CHANGE COLUMN `porcentaje` `interes` DOUBLE NULL ,
 ADD INDEX `fk_plan_tarjeta_idx` (`tarjeta_id` ASC),
 ADD INDEX `fk_plan_banco_idx` (`banco_id` ASC);
 ALTER TABLE `{$prefix}decidir_plan` ENGINE=InnoDB;
 ALTER TABLE `{$prefix}decidir_plan`
 ADD CONSTRAINT `fk_plan_tarjeta`
   FOREIGN KEY (`tarjeta_id`)
   REFERENCES `{$prefix}decidir_tarjeta` (`tarjeta_id`)
   ON DELETE NO ACTION
   ON UPDATE NO ACTION,
 ADD CONSTRAINT `fk_plan_banco`
   FOREIGN KEY (`banco_id`)
   REFERENCES `{$prefix}decidir_banco` (`banco_id`)
   ON DELETE RESTRICT
   ON UPDATE CASCADE;

UPDATE {$prefix}decidir_plan SET cuotas = POW(2, cuotas - 1);
UPDATE {$prefix}decidir_plan SET interes = 1 + interes / 100;


ALTER TABLE {$prefix}decidir_banco ADD COLUMN `visible` TINYINT NOT NULL DEFAULT 1;
INSERT INTO {$prefix}decidir_banco (`nombre`, `activo`, `visible`) VALUES ("Otro", 1, 0);

SQLTEXT;

$installer->run($sql);
//demo
//Mage::getModel('core/url_rewrite')->setId(null);
//demo
$installer->endSetup();
