<?php

class Decidir_DecidirPlanesDePago_Helper_Data extends Mage_Core_Helper_Abstract
{

	const VISA = "iso8583";
	const AMEX = "iso8583";
	const FIRSTDATA = "cal";
	private $mensajerias_mp;

	public function __construct()
	{
		$this->mensajerias_mp = array(
			1 => self::VISA,
			6 => self::AMEX,
			8 => self::FIRSTDATA,
			15 => self::FIRSTDATA,
			20 => self::FIRSTDATA,
			30 => self::FIRSTDATA,
			65 => self::AMEX
 		);
	}

	public function getMensajeria($medio_pago)
	{
		$mensajeria = (array_key_exists($medio_pago, $this->mensajerias_mp)) ? $this->mensajerias_mp[$medio_pago] : '';
		return $mensajeria;
	}
}
