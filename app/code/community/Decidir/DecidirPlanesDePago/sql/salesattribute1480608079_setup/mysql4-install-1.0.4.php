<?php
$installer = $this;
$installer->startSetup();

$installer->addAttribute("quote_address", "descuentopromocional_total", array("type"=>"varchar"));
$installer->addAttribute("order", "descuentopromocional_total", array("type"=>"varchar"));
$installer->endSetup();
	 