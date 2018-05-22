<?php
$installer = $this;
$installer->startSetup();

$sql=<<<SQLTEXT
DROP TABLE IF EXISTS {$this->getTable('decidirtransaction')};
CREATE TABLE {$this->getTable('decidirtransaction')} (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `order_id` VARCHAR(30) NULL DEFAULT NULL,
  `decidir_order_id` VARCHAR(30) NULL DEFAULT NULL,
  `payment_response` TEXT NULL DEFAULT NULL,
  `marca` INT(10) UNSIGNED NOT NULL,
  `banco` INT(10) UNSIGNED NOT NULL,
  `cuotas` INT(3) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
);
SQLTEXT;

$installer->run($sql);

$sql=<<<SQLTEXT
DROP TABLE IF EXISTS {$this->getTable('decidirtoken')};
CREATE TABLE {$this->getTable('decidirtoken')} (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) UNSIGNED NOT NULL,
  `marca_id` INT(11) UNSIGNED NOT NULL,
  `banco_id` INT(11) UNSIGNED NOT NULL,
  `token` VARCHAR(255) NULL DEFAULT NULL,
  `payment_method_id` INT(11) UNSIGNED NULL DEFAULT NULL,
  `bin` VARCHAR(10) NULL DEFAULT NULL,
  `last_four_digits` VARCHAR(4) NULL DEFAULT NULL,
  `expiration_month` VARCHAR(2) NULL DEFAULT NULL,
  `expiration_year` VARCHAR(2) NULL DEFAULT NULL,
  `expired` VARCHAR(5) NULL DEFAULT NULL,
  `token_response` VARCHAR(255) NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
);
SQLTEXT;

$installer->run($sql);

$installer->addAttribute("quote_address", "costofinanciero_total", array("type"=>"varchar"));
$installer->addAttribute("order", "costofinanciero_total", array("type"=>"varchar"));
$installer->addAttribute("order", "decidirclave", array("type"=>"varchar"));

$installer->endSetup();